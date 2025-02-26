<?php
include('../adminpage/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
?>
<style>
    #calendar {
        max-width: 600px; /* Adjust width */
        margin: 0 auto; /* Center the calendar */
        font-size: 0.85rem; /* Adjust text size */
    }
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Time Slots</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Calendar will render here -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">Available Slots for <span id="modalDate"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Time Pickers -->
                <div id="timePickerSection">
                    <p><strong>Date:</strong> <span id="selectedDate"></span></p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="timeFrom" class="form-label">From:</label>
                            <input type="time" id="timeFrom" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="timeTo" class="form-label">To:</label>
                            <input type="time" id="timeTo" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- Time Slots -->
                <div id="timeSlotsSection" class="mt-4" style="display: none;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Time Slot</th>
                                <th>Number of Slots</th>
                            </tr>
                        </thead>
                        <tbody id="timeSlots"></tbody>
                    </table>
                </div>
                <!-- Message if no slots exist -->
                <div id="noSlotsMessage" style="display: none;">
                    <p>No slots found for this date. Please create new slots.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="generateSlots">Generate Slots</button>
                <button class="btn btn-primary" id="saveSlots">Add Slots</button>
            </div>
        </div>
    </div>
</div>
    

    
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function(info, successCallback, failureCallback) {
            // Make an AJAX call to get events from the server
            $.ajax({
                url: '../backendAdmin/schedule.php',
                type: 'POST',
                data: {
                    action: 'get_events' // Fetch dates with available slots
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    var events = [];
                    var today = new Date();
                    today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

                    data.forEach(function(event) {
                        var eventDate = new Date(event.date);
                        
                        // Only add event if the date is in the future (not past or current)
                        if (eventDate >= today) {
                            events.push({
                                title: 'Available slot',
                                date: event.date // Add the date when the slot is available
                            });
                        }
                    });

                    successCallback(events); // Return events to FullCalendar
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching events: ' + error);
                    failureCallback();
                }
            });
        },
        dateClick: function (info) {
            var today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

            var clickedDate = new Date(info.dateStr);

            if (clickedDate > today) {
                // Format the selected date as "MonthName Date Year"
                var formattedDate = formatDate(info.dateStr);

                // Update modal with selected date
                document.getElementById('modalDate').innerText = formattedDate;
                document.getElementById('selectedDate').innerText = formattedDate;

                // Check if slots exist for the clicked date
                $.ajax({
                    url: '../backendAdmin/schedule.php',
                    type: 'POST',
                    data: {
                        action: 'check_slots',
                        date: info.dateStr
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.found) {
                            // If slots exist, show them in the modal
                            document.getElementById('timePickerSection').style.display = "none";
                            document.getElementById('timeSlotsSection').style.display = "block";
                            document.getElementById('noSlotsMessage').style.display = "none";

                            // Populate the table with existing slots
                            var slotsContainer = document.getElementById('timeSlots');
                            slotsContainer.innerHTML = '';
                            data.slots.forEach(function(slot) {
                                var row = document.createElement('tr');
                                var timeCell = document.createElement('td');
                                timeCell.textContent = formatAMPM(slot.time_from) + ' - ' + formatAMPM(slot.time_to);
                                var slotsCell = document.createElement('td');
                                slotsCell.textContent = slot.slots;
                                row.appendChild(timeCell);
                                row.appendChild(slotsCell);
                                slotsContainer.appendChild(row);
                            });

                            // Hide both buttons if slots exist
                            document.getElementById('generateSlots').style.display = "none";
                            document.getElementById('saveSlots').style.display = "none";

                        } else {
                            // If no slots exist, show message to create slots
                            document.getElementById('timePickerSection').style.display = "block";
                            document.getElementById('timeSlotsSection').style.display = "none";
                            document.getElementById('noSlotsMessage').style.display = "block";

                            // Show the generateSlots button and hide saveSlots
                            document.getElementById('generateSlots').style.display = "block";
                            document.getElementById('saveSlots').style.display = "none";
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error checking slots: ' + error);
                    }
                });

                // Show the modal
                var dateModal = new bootstrap.Modal(document.getElementById('dateModal'));
                dateModal.show();
            } else {
                console.log("Past or current date clicked, no modal shown.");
            }
        }
    });
    calendar.render();



    // Generate slots on button click
    document.getElementById('generateSlots').addEventListener('click', function () {
        var fromTime = document.getElementById('timeFrom').value;
        var toTime = document.getElementById('timeTo').value;

        if (fromTime && toTime) {
            var fromDate = new Date(`1970-01-01T${fromTime}:00`);
            var toDate = new Date(`1970-01-01T${toTime}:00`);

            if (fromDate < toDate) {
                var timeSlots = [];
                while (fromDate < toDate) {
                    var nextHour = new Date(fromDate.getTime() + 60 * 60 * 1000); // Add 1 hour
                    timeSlots.push({
                        time_from: fromDate.toTimeString().slice(0, 5),
                        time_to: nextHour.toTimeString().slice(0, 5),
                        slots: 0 // Default slots
                    });
                    fromDate = nextHour;
                }

                // Populate slots in the table
                var slotsContainer = document.getElementById('timeSlots');
                slotsContainer.innerHTML = '';
                timeSlots.forEach(function(slot) {
                    var row = document.createElement('tr');
                    var timeCell = document.createElement('td');
                    timeCell.textContent = slot.time_from + ' - ' + slot.time_to;
                    var slotsCell = document.createElement('td');
                    var input = document.createElement('input');
                    input.type = 'number';
                    input.className = 'form-control';
                    input.placeholder = 'Enter slots';
                    input.min = '1';
                    slotsCell.appendChild(input);
                    row.appendChild(timeCell);
                    row.appendChild(slotsCell);
                    slotsContainer.appendChild(row);
                });

                // Hide time picker and show slots
                document.getElementById('timePickerSection').style.display = "none";
                document.getElementById('timeSlotsSection').style.display = "block";
                // Show saveSlots button
                document.getElementById('saveSlots').style.display = "block";
                document.getElementById('generateSlots').style.display = "none";
            } else {
                alert("Invalid time range! Ensure 'From' is earlier than 'To'.");
            }
        } else {
            alert("Please select both 'From' and 'To' times.");
        }
    });

    // Save slots to the database
    document.getElementById('saveSlots').addEventListener('click', function () {
    var date = formatDates(document.getElementById('selectedDate').innerText); // Format date

    var slotsData = [];

    // Collect the slots data from the table
    var rows = document.querySelectorAll('#timeSlots tr');
    rows.forEach(function(row) {
        var timeFrom = row.querySelector('td').textContent.split(' - ')[0];
        var timeTo = row.querySelector('td').textContent.split(' - ')[1];
        var slots = row.querySelector('input').value;

        if (slots && slots > 0) {
            slotsData.push({
                time_from: timeFrom,
                time_to: timeTo,
                slots: slots
            });
        }
    });

    // Send data to PHP for insertion
    if (slotsData.length > 0) {
        $.ajax({
            url: '../backendAdmin/schedule.php', // PHP script to save the data
            type: 'POST',
            data: {
                action: 'save_slots',
                date: date, // Use the formatted date
                slots_data: JSON.stringify(slotsData) // Send as JSON
            },
            success: function(response) {
                // After success, reload the page
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error occurred: ' + error);
            }
        });
    } else {
        alert('Please enter the number of slots for each time range.');
    }
});
});


// Function to format time into AM/PM format
function formatAMPM(dateStr) {
    var date = new Date('1970-01-01T' + dateStr); // Set time from string
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // 0 becomes 12
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

// Function to format date as "MonthName Date Year"
function formatDate(dateStr) {
    var date = new Date(dateStr); // Convert string to Date object
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var monthName = months[date.getMonth()];
    var day = date.getDate();
    var year = date.getFullYear();

    return monthName + " " + day + ", " + year;
}

function formatDates(dateStr) {
    var date = new Date(dateStr);
    var year = date.getFullYear();
    var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Ensure 2 digits
    var day = date.getDate().toString().padStart(2, '0'); // Ensure 2 digits
    return year + '-' + month + '-' + day;
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            // Show the success message using Alertify
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            // Remove the message from sessionStorage after showing it
            sessionStorage.removeItem('successMessage');
        }
    });
</script>


<?php
include('../adminpage/footer.php');
?>

