<?php
require '../userLogin/db_con.php';
  
$sql = "SELECT p.id, p.last_name, p.first_name, p.middle_name, p.contact_number, p.email, m.name AS municipality 
FROM patients p
LEFT JOIN municipalities m ON p.municipality_id = m.id";
$stmt = $pdo->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Patient List</title>
  <link rel="stylesheet" href="../assets/css/addp.css">

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

  <!-- #region -->  
  <li class="nav-item dropdown">
        <a class="nav-link"  href="../pages/message.php">
          <i class="far fa-comments"></i>
        </a>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="navigation">
  
    <button onclick="resetFilter()">All</button>
 
    <select onchange="filterMunicipality(this.value)">
        <option value="">Select Municipality</option>
        <option value="Calapan City">Calapan City</option>
        <option value="Baco">Baco</option>
        <option value="San Teodoro">San Teodoro</option>
        <option value="Puerto Galera">Puerto Galera</option>
        <option value="Naujan">Naujan</option>
        <option value="Victoria">Victoria</option>
        <option value="Socorro">Socorro</option>
        <option value="Pola">Pola</option>
        <option value="Pinamalayan">Pinamalayan</option>
        <option value="Gloria">Gloria</option>
        <option value="Bansud">Bansud</option>
        <option value="Bongabong">Bongabong</option>
        <option value="Roxas">Roxas</option>
        <option value="Mansalay">Mansalay</option>
        <option value="Bulalacao">Bulalacao</option>
        <option value="San Jose Occidental">San Jose Occidental</option>
        <option value="Mamburao Occidental">Mamburao Occidental</option>
    </select>
</div>

    </section>

    <!-- Patient List Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Patient List</h3>
                            <div class="card-tools">
                                <!-- Register Here Button -->
                                
                                <button type="button" class="btn btn-tool text-left" data-toggle="modal" data-target="#addEmpModal">
                                    <h6><i class="fas fa-plus"></i> Add Patients </h6>
                                </button>
                            </div>
                        </div>

                        <!-- Card Body with Table -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                              
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fullname</th>
                                        <th>Municipality</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($stmt)): ?>
                                        <?php foreach ($stmt as $data): ?>
                                            <tr class="patient-row" data-municipality="<?= htmlspecialchars($data['municipality']) ?>">
                                             <td><?= htmlspecialchars($data['id']) ?></td>
                                                <td><?= htmlspecialchars($data['last_name'] . ', ' . $data['first_name'] . ' ' . $data['middle_name']) ?></td>
                                                <td><?= htmlspecialchars($data['municipality']) ?></td>
                                                <td><?= htmlspecialchars($data['contact_number']) ?></td>
                                                <td><?= htmlspecialchars($data['email']) ?></td>
                                                <td>
                                                    <!-- Action buttons -->
                                                    <div class="btn-cs">
                                                    <button 
                                                          class="btn btn-sm btn-warning edit-btn" 
                                                          data-id="<?= htmlspecialchars($data['id']) ?>" 
                                                          data-toggle="modal" 
                                                          data-target="#updatePatientModal">
                                                          <i class="fas fa-edit"></i> Edit
                                                        </button>

                                                    <button class="btn btn-sm btn-danger delete-btn" data-id="<?= htmlspecialchars($data['id']) ?>">
                                                      <i class="fas fa-trash"></i>Delete
                                                  </button>

                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">No records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php
// include_once('../partials/footer.php');
include_once('../modals/add-patient.php');
include_once('../modals/update-patient.php');
 
?>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2024 <a href="https://adminlte.io">PMS</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function filterMunicipality(selectedMunicipality) {
       
        const rows = document.querySelectorAll('.patient-row');
        
      
        rows.forEach(row => {
            const municipality = row.getAttribute('data-municipality');
            if (municipality === selectedMunicipality) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none';  
            }
        });
    }

    function resetFilter() {
    const rows = document.querySelectorAll('.patient-row');
    rows.forEach(row => {
        row.style.display = '';   
    });
}

      // Add User record
$('#addpatient').submit(function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Information',
          text: "Are you sure you want to add this records?",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, save it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url: '../api/api_user.php?add_patient',
              type: 'post',
              processData: false,
              contentType: false,
              data: new FormData(this)
            }).then(function(response) {
              if(response.success){
                Swal.fire('Success!', response.message, 'success')
                 $('#addpatient')[0].reset();
                 $('#addEmpModal').modal('hide');
                window.close();
              }else{
                Swal.fire('Warning!', response.message, 'warning')
              }

            })
          }
        })
      });

      
  $('.edit-btn').on('click', function () {
    var id = parseInt($(this).data('id'));  
    console.log(id);  

    if (id) {
      $.ajax({
        url: '../api/api_user.php',
        type: 'GET',
        dataType: 'json',
        data: { user_id: id },  
        beforeSend: function () {
          Swal.fire({
            title: 'Loading...',
            text: 'Fetching user data...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading(),
          });
        },
        success: function (response) {
          if (response.success && response.data) {
            $('#patient_id').val(response.data.id);
            $('#last_name').val(response.data.last_name);
            $('#first_name').val(response.data.first_name);
            $('#middle_name').val(response.data.middle_name);
            $('#date_of_birth').val(response.data.date_of_birth);
            $('#gender').val(response.data.gender);
            $('#municipality_id').val(response.data.municipality_id);
            $('#contact_number').val(response.data.contact_number);
            $('#email').val(response.data.email);
            $('#address').val(response.data.address);
            $('#city').val(response.data.city);
            $('#state').val(response.data.state);
            $('#postal_code').val(response.data.postal_code);
            $('#medical_history').val(response.data.medical_history);
            $('#allergies').val(response.data.allergies);
            $('#tendency_to_bleed').val(response.data.tendency_to_bleed);
            $('#high_blood_pressure').val(response.data.high_blood_pressure);
            $('#diabetic').val(response.data.diabetic);
            $('#t3_level').val(response.data.t3_level);
            $('#t4_level').val(response.data.t4_level);
            $('#tsh_level').val(response.data.tsh_level);
            $('#symptoms').val(response.data.symptoms);
            $('#additional_notes').val(response.data.additional_notes);
            
            Swal.close();
            $('#updatePatientModal').modal('show');
          } else {
            Swal.fire('Error!', response.message || 'No data found for this ID.', 'warning');
          }
        },
        error: function () {
          Swal.fire('Error!', 'Failed to retrieve user data.', 'error');
        },
      });
    } else {
      Swal.fire('Error!', 'No ID provided.', 'error');
    }
});

 
$('#updatePatientForm').on('submit', function (e) {
    e.preventDefault(); 

    // Get the form data
    var formData = $(this).serialize();  

    // Send the data to the server  
    $.ajax({
        url: '../api/api_user.php?update_patient_data',
        type: 'POST',
        dataType: 'json',
        data: formData, // Send the serialized form data
        beforeSend: function () {
            Swal.fire({
                title: 'Updating...',
                text: 'Updating user data...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });
        },
        success: function (response) {
            if (response.success) {
                Swal.fire('Success!', 'User data updated successfully.', 'success');
                $('#viewupdateUserModal').modal('hide');  // Close the modal after successful update
            } else {
                Swal.fire('Error!', response.message || 'Failed to update data.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error!', 'Failed to update the record. Please try again later.', 'error');
        }
    });
});

 

       // DELETE STAFF
       $(document).on('click', '.delete-btn', function (e) {
    e.preventDefault();

    const row = $(this).closest('tr'); // Get the table row of the clicked button
    const userId = $(this).data('id'); // Get user ID from the button's data attribute
    const municipalityName = row.find('td:nth-child(3)').text(); // Adjust index for municipality name column

    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete the patient from ${municipalityName}. This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../api/api_user.php',
                type: 'DELETE',
                contentType: 'application/json',
                data: JSON.stringify({ user_id: userId }), // Send the user ID as JSON
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.message, 'success');
                        row.remove(); // Remove the row from the table
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'An unexpected error occurred.', 'error');
                },
            });
        }
    });
});


</script>
</body>
</html>
