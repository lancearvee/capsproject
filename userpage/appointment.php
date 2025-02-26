<?php
include('../userpage/header.php');
require '../userLogin/db_con.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<style>
.calendar-section {
    font-family: Arial, sans-serif;
    padding: 20px;
    text-align: center;
}
.calendar-header {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
}
.nav-btn {
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 16px;
}
#calendar {
    max-width: 600px;
    margin: 0 auto; 
    background-color: white; 
}
.fc-daygrid-day-number {
    font-size: 12px; 
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4); 
}
.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    text-align: center;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.slots-table {
width: 100%;
border-collapse: collapse;
margin-top: 10px;
}
.slots-table th,
.slots-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}
.slots-table th {
    background-color: #f4f4f4;
    font-weight: bold;
}
.select-slot.highlighted {
    background-color: #4CAF50; /* Green */
    color: white;
    border: none;
}

#okayButton {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007BFF; /* Blue */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#okayButton:hover {
    background-color: #0056b3;
}
#okayButton {
    margin-left: auto;
    display: block;
    padding: 5px 15px; /* Reduced padding for smaller button */
    font-size: 15px;   /* Smaller font size */
    background-color: #4CAF50; /* Green background */
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
}
#okayButton:hover {
    background-color: #45a049;
}
</style>



  <main class="main">


    <!-- Appointment Section -->
    <section id="appointment" class="appointment section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Appointment</h2>
        <p>Schedule your appointment with ease and receive expert medical care tailored to your needs. Your health is our priority.</p>
      </div><!-- End Section Title -->


        <div class="calendar-header">
            <button class="nav-btn" id="prevMonthBtn">&lt;</button>
            <span id="monthName"></span>
            <button class="nav-btn" id="nextMonthBtn">&gt;</button>
        </div>

        <div id="calendar"></div>
    </section>

    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <h3 id="modalDate"></h3>
                    <div id="modalMessage"></div> <!-- Display warning or success message here -->
                    <div id="timeSlotsContainer"></div> <!-- Time slots and buttons will be inserted here -->
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" id="okayButton" class="btn btn-primary" style="display: none;">Okay</button>
                </div>
            </div>
        </div>
    </div>


  </main>

  
<script>
   document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var currentDate = new Date();

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'en',
        headerToolbar: false, 
        initialDate: currentDate, 
        events: [],
        dateClick: function(info) {
            var clickedDate = new Date(info.dateStr);
            var currentDate = new Date();

            if (clickedDate < currentDate) {
                return;
            }

            var modal = new bootstrap.Modal(document.getElementById('myModal'));
            var modalDate = document.getElementById("modalDate");
            var closeBtn = document.getElementsByClassName("close")[0];
            var timeSlotsContainer = document.getElementById("timeSlotsContainer");
            var modalMessage = document.getElementById("modalMessage");

            var formattedDate = new Intl.DateTimeFormat('en-US', { month: 'long', day: '2-digit', year: 'numeric' }).format(clickedDate);
            modalDate.innerHTML = `<span class="small">Selected Date: ${formattedDate}</span>`;

            timeSlotsContainer.innerHTML = "";
            modalMessage.innerHTML = ""; 

            fetch('../backendUser/check_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'date=' + encodeURIComponent(info.dateStr),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success === false && data.message) {
                    modalMessage.innerHTML = `<div class="alert alert-warning">${data.message}</div>`;
                    return; 
                }
                fetch('../backendUser/fetch_slots.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'date=' + encodeURIComponent(info.dateStr),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        if (data.data.length > 0) {
                            let selectedTimeFrom = null;
                            let selectedTimeTo = null;
                            let selectedDate = info.dateStr;

                            const table = document.createElement('table');
                            table.classList.add('table', 'table-striped', 'table-bordered', 'text-center');
                            table.innerHTML = `
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Time From</th>
                                        <th>Time To</th>
                                        <th>Available Slots</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ${data.data
                                    .map((slot) => {
                                        let timeFrom = formatTime(slot.time_from);
                                        let timeTo = formatTime(slot.time_to);
                                        return `
                                            <tr>
                                                <td>${timeFrom}</td>
                                                <td>${timeTo}</td>
                                                <td>${slot.slots}</td>
                                                <td>
                                                    ${slot.slots > 0 ? `
                                                        <button class="btn-sm select-slot" data-time-from="${slot.time_from}" data-time-to="${slot.time_to}">
                                                            Select
                                                        </button>
                                                    ` : '<span class="text-danger">No slots available</span>'}
                                                </td>
                                            </tr>
                                        `;
                                    })
                                    .join('')}
                                </tbody>
                            `;
                            timeSlotsContainer.appendChild(table);

                            const okayButton = document.createElement('button');
                            okayButton.id = 'okayButton';
                            okayButton.textContent = 'Okay';
                            okayButton.style.display = 'none';
                            okayButton.addEventListener('click', function () {
                                if (selectedTimeFrom && selectedTimeTo) {
                                    fetch('../backendUser/insert_appointment.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: `time_from=${encodeURIComponent(selectedTimeFrom)}&time_to=${encodeURIComponent(selectedTimeTo)}&date=${encodeURIComponent(selectedDate)}`,
                                    })
                                    .then((response) => response.json())
                                    .then((result) => {
                                        if (result.success) {
                                            sessionStorage.setItem('successMessage', 'Appointment successfully scheduled!');
                                            window.location.href = '../userpage/home.php';
                                        } else {
                                            alertify.error('Failed to schedule appointment: ' + result.error);
                                        }
                                    })
                                    .catch((error) => {
                                        alertify.error('An error occurred: ' + error);
                                    });
                                } else {
                                    alertify.warning('Please select a time slot before confirming.');
                                }
                            });

                            timeSlotsContainer.appendChild(okayButton);

                            document.querySelectorAll('.select-slot').forEach((button) => {
                                button.addEventListener('click', function () {
                                    document.querySelectorAll('.select-slot').forEach((btn) => {
                                        btn.classList.remove('highlighted');
                                    });

                                    this.classList.add('highlighted');
                                    selectedTimeFrom = this.getAttribute('data-time-from');
                                    selectedTimeTo = this.getAttribute('data-time-to');
                                    okayButton.style.display = 'block';
                                });
                            });
                        } else {
                            timeSlotsContainer.innerHTML = '<p>No available slots for this date.</p>';
                        }
                    } else {
                        alertify.error('Failed to fetch slots: ' + data.error);
                    }
                })
                .catch((error) => {
                    alertify.error('An error occurred: ' + error);
                });
            })
            .catch((error) => {
                alertify.error('An error occurred: ' + error);
            });
            modal.show(); 
        }
    });

    calendar.render();





    var prevMonthBtn = document.getElementById('prevMonthBtn');
    var nextMonthBtn = document.getElementById('nextMonthBtn');
    var monthName = document.getElementById('monthName');

        prevMonthBtn.addEventListener('click', function() {
            calendar.prev();
            updateMonthName();
        });

        nextMonthBtn.addEventListener('click', function() {
            calendar.next();
            updateMonthName();
        });

        function updateMonthName() {
            var currentDate = calendar.getDate();
            var options = { month: 'long', year: 'numeric' };
            monthName.textContent = currentDate.toLocaleDateString('en-US', options).toUpperCase();
        }

        updateMonthName(); 
    });

    function formatTime(time) {
        let [hours, minutes] = time.split(':');
        let suffix = 'AM';
        hours = parseInt(hours);

        if (hours >= 12) {
            suffix = 'PM';
            if (hours > 12) hours -= 12;
        }
        if (hours === 0) hours = 12; // Midnight edge case
        return `${hours}:${minutes} ${suffix}`;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            sessionStorage.removeItem('successMessage');
        }
    });
</script>


<?php
include('../userpage/footer.php');

?>