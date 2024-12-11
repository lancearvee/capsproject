<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>.
    <link rel="stylesheet" href="../assets/css/appt.css">

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini  layout-fixed">
    <div class="wrapper">
    

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../pages/admin.php" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

 
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
       
    </ul>
  </nav>
  <!-- /.navbar -->
 

 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../pages/admin.php" class="brand-link">
      <img src="../assets/image/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin </span>
    </a>    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         
        <div class="info">
          <a href="../pages/admin.php" class="d-block">Patient Management System</a>
        </div>
      </div>

       <!-- Sidebar Menu -->
       <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../pages/admin.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>

                    <li class="nav-item">
        <a href="../pages/staff.php" class="nav-link">
          <!-- Replace the icon with an image -->
          <img src="../assets/image/Medical Doctor.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">  
          <p>
            Clinic Staff
            <!-- <i class="fas fa-angle-left right"></i> -->
            <span class="badge badge-info right"></span>
          </p>
        </a> 
      </ul>
      </li>

          <li class="nav-item">
          <a href="../pages/patient-list.php" class="nav-link">
    <!-- Replace the icon with an image -->
    <img src="../assets/image/Straitjacket.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
    <p>
      Patient
      <!-- <i class="fas fa-angle-left right"></i> -->
      <span class="badge badge-info right"></span>
    </p>
  </a>
      
  <li class="nav-item">
            <a href="#" class="nav-link">
            <img src="../assets/image/Timesheet.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
            <p>
                Appointment
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../pages/appointment-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Appointment List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../pages/edit-appointment.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Appointment</p>
                </a>
              </li>     
            </ul>
          </li>
  
  <li class="nav-item">
          <a href="../pages/prescription.php" class="nav-link">
    <!-- Replace the icon with an image -->
    <img src="../assets/image/Pill Bottle.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
    <p>
      Presciption
      <i ></i>
      <span class="badge badge-info right"></span>
    </p>
  </a>
       
  <li class="nav-item">
          <a href="../pages/inventory.php" class="nav-link">
    <!-- Replace the icon with an image -->
    <img src="../assets/image/Sell Stock.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
    <p>
      Inventory
      <i></i>
      <span class="badge badge-info right"></span>
    </p>
  </a>
       
  <li class="nav-item">
          <a href="../pages/payment-list.php" class="nav-link">
    <!-- Replace the icon with an image -->
    <img src="../assets/image/Coins.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
    <p>
      Payment Record
      <i ></i>
      <span class="badge badge-info right"></span>
    </p>
  </a>
       
  <li class="nav-item">
          <a href="../pages/reports.php" class="nav-link">
    <!-- Replace the icon with an image -->
    <img src="../assets/image/Business Report.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
    <p>
      Reports
      <!-- <i class="fas fa-angle-left right"></i> -->
      <span class="badge badge-info right"></span>
    </p>
  </a>
  <li class="nav-item">
          <a href="../pages/user.php" class="nav-link">
    <!-- Replace the icon with an image -->
    <img src="../assets/image/User Shield.png" alt="Doctor Logo" class="nav-icon fas fa-copy" style="width: 20px; height: 20px; margin-right: 8px;">
    <p>
        Users
      <!-- <i class="fas fa-angle-left right"></i> -->
      <span class="badge badge-info right"></span>
    </p>
  </a>

  <li class="nav-item">
  <a href="../userLogin/logout.php" class="nav-link">
    <i class="nav-icon fas fa-sign-out-alt"></i>
    <p>Logout</p>
  </a>
</li>

            </ul>
          </li>   
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  
  <section class="schedule-container">
    <h1>Thyroid Health And Wellness Center</h1>

    <label for="date-picker">Select Date:</label>
    <input type="date" id="date-picker" name="date-picker" value="2024-11-15">

    <h2 id="selected-date"> </h2>

    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Available Slots</th>
                <th>In Percentage</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="schedule-table-body">
            <!-- Schedule Rows will be populated dynamically -->
        </tbody>
    </table>
</section>

<!-- Modal for editing -->
<div id="edit-modal" style="display: none;">
    <h3>Edit Schedule</h3>
    <label for="edit-time">Time:</label>
    <input type="text" id="edit-time">
<div>
    <label for="edit-slots">Available Slots:</label>
    <input type="number" id="edit-slots">
</div>
<div>
    <label for="edit-max-slots">Max Slots:</label>
    <input type="number" id="edit-max-slots" value="10">
    </div>
    <label for="edit-percentage">Percentage:</label>
    <input type="text" id="edit-percentage" disabled>
<div>
    <button id="save-btn">Save</button>
    <button id="cancel-btn">Cancel</button>
    </div>
</div>

<script>
    // Modal elements
    const editModal = document.getElementById('edit-modal');
    const editTime = document.getElementById('edit-time');
    const editSlots = document.getElementById('edit-slots');
    const editMaxSlots = document.getElementById('edit-max-slots');
    const editPercentage = document.getElementById('edit-percentage');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    // Schedule data stored in memory (persisted for each date)
    const schedules = {};

    // Initialize schedule rows
    const scheduleTimes = [
        "09:00 AM", "10:00 AM", "11:00 AM", "12:00 PM", "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM", "05:00 PM"
    ];

    function renderSchedule(date) {
        const tbody = document.getElementById('schedule-table-body');
        tbody.innerHTML = ''; // Clear the table before rendering new data

        // Check if there is stored schedule data for the selected date
        const scheduleData = schedules[date] || {};

        scheduleTimes.forEach((time) => {
            const availableSlots = scheduleData[time]?.slots || 10;
            const maxSlots = scheduleData[time]?.maxSlots || 10;
            const percentage = scheduleData[time]?.percentage || '100%';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><button class="time-btn">${time}</button></td>
                <td><span class="available-slots">${availableSlots}</span></td>
                <td><span class="percentage">${percentage}</span></td>
                <td><button class="edit-btn">Edit</button></td>
            `;
            tbody.appendChild(row);

            // Add event listener to the edit button
            row.querySelector('.edit-btn').addEventListener('click', function () {
                // Pre-fill modal with current values
                editTime.value = time;
                editSlots.value = availableSlots;
                editMaxSlots.value = maxSlots;
                editPercentage.value = percentage;

                // Show modal
                editModal.style.display = 'block';

                // Calculate percentage when available slots or max slots are edited
                function calculatePercentage() {
                    const slots = parseInt(editSlots.value);
                    const maxSlotsValue = parseInt(editMaxSlots.value);
                    const percentageValue = (slots / maxSlotsValue) * 100;
                    editPercentage.value = percentageValue.toFixed(2) + '%';
                }

                // Listen to changes in available slots and max slots
                editSlots.addEventListener('input', calculatePercentage);
                editMaxSlots.addEventListener('input', calculatePercentage);

                // Save the edited data
                saveBtn.onclick = function () {
                    // Save changes to the schedule for the selected date
                    schedules[date] = schedules[date] || {};
                    schedules[date][time] = {
                        time: editTime.value,
                        slots: parseInt(editSlots.value),
                        maxSlots: parseInt(editMaxSlots.value),
                        percentage: editPercentage.value
                    };

                    // Update the table with the new values
                    row.querySelector('.available-slots').textContent = editSlots.value;
                    row.querySelector('.percentage').textContent = editPercentage.value;

                    // Close the modal
                    editModal.style.display = 'none';
                };

                // Cancel the editing
                cancelBtn.onclick = function () {
                    // Close the modal without saving
                    editModal.style.display = 'none';
                };
            });
        });
    }

    // Update the selected date display when a user selects a new date
    document.getElementById('date-picker').addEventListener('change', function () {
        var selectedDate = this.value;
        var options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
        var formattedDate = new Date(selectedDate).toLocaleDateString('en-US', options);

        // Update the content of the h2 with the new date
        document.getElementById('selected-date').textContent = formattedDate;

        // Render the schedule for the selected date
        renderSchedule(selectedDate);
    });

    // Set the default date and render the initial schedule
    window.onload = function () {
        const defaultDate = document.getElementById('date-picker').value;
        renderSchedule(defaultDate);
        // Also, set the default date display text
        document.getElementById('selected-date').textContent = new Date(defaultDate).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });
    };
</script>

  </div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/assets/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>

</body>
</html>