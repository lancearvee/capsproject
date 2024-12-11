<?php
require '../../userLogin/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "INSERT INTO patients (first_name, last_name, middle_name, date_of_birth, gender, municipality_id, contact_number, email, address, city, state, postal_code, medical_history) 
            VALUES (:first_name, :last_name, :middle_name, :date_of_birth, :gender, :municipality_id, :contact_number, :email, :address, :city, :state, :postal_code, :medical_history)";
    $stmt = $pdo->prepare($sql);

    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'middle_name' => $_POST['middle_name'],
        'date_of_birth' => $_POST['date_of_birth'],
        'gender' => $_POST['gender'],
        'municipality_id' => $_POST['municipality_id'],
        'contact_number' => $_POST['contact_number'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'postal_code' => $_POST['postal_code'],
        'medical_history' => $_POST['medical_history']
    ];

    // Try to execute the query
    try {
        $stmt->execute($data);
      
        echo "Patient record inserted successfully!"  ;
       
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  } 
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Patients</title>
  <link rel="stylesheet" href="../../css/.css ">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Home</a>
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
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index.php" class="brand-link">
      <img src="../../image/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin </span>
    </a>

   <!-- Sidebar -->
   <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         
        <div class="info">
          <a href="../../index.php" class="d-block">Patient Management System</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
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
                <a href="../../index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Doctor
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../../pages/doctor/doctor-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Doctor List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../pages/doctor/add-doctor.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Doctor</p>
                </a>
              </li>  
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Patient
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../../pages/patient/patient-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Patient List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../pages/patient/add-patient.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Patient</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
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
                <a href="../../pages/appointment/appointment-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Appointment List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../pages/appointment/edit-appointment.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Appointment</p>
                </a>
              </li>     
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Prescription
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../../pages/prescription/print-prescription.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prescription</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Schedule
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../../pages/schedule/schedule-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Schedule List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../pages/schedule/add-schedule.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Schedule</p>
                </a>
              </li>     
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Inventory
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../../pages/inventory/inventory-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventory</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../pages/inventory/add-medicine.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Medicine</p>
                </a>
              </li>     
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Payment Record
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="../../pages/payment-record/paymentrecord-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment Record List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../pages/payment-record/add-payment-record.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Payment Record</p>
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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Patient Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Patients</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
   
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thyroid Lab Result</h3>
                    </div>
                    <form action="#" method="POST">
                        <div class="card-body">
                            <!-- Thyroid Level Measurements -->
                            <fieldset>
                                <legend>Thyroid Level Measurements</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="t3-level">T3 Level (ng/dL):</label>
                                        <select class="form-control" id="t3-level" name="t3-level">
                                            <option value="" disabled selected>-- Select --</option>
                                            <option value="low">Low</option>
                                            <option value="normal">Normal</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="t4-level">T4 Level (μg/dL):</label>
                                        <input type="text" class="form-control" id="t4-level" name="t4-level" placeholder="Enter T4 Level">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="tsh-level">TSH Level (mIU/L):</label>
                                        <input type="text" class="form-control" id="tsh-level" name="tsh-level" placeholder="Enter TSH Level">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Symptoms -->
                            <fieldset>
                                <legend>Symptoms</legend>
                                <div class="form-group">
                                    <label for="symptoms">Describe any symptoms related to thyroid health (e.g., fatigue, weight changes, temperature sensitivity):</label>
                                    <textarea class="form-control" id="symptoms" name="symptoms" rows="4"></textarea>
                                </div>
                            </fieldset>

                            <!-- Medical History -->
                            <fieldset>
                                <legend>Medical History</legend>
                                <div class="form-group">
                                    <label>Do you have any known thyroid conditions?</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="yes" name="thyroid-condition" value="yes">
                                        <label for="yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="no" name="thyroid-condition" value="no">
                                        <label for="no" class="form-check-label">No</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="medical-history">Provide details:</label>
                                    <textarea class="form-control" id="medical-history" name="medical-history" rows="3" placeholder="Provide details..."></textarea>
                                </div>
                            </fieldset>

                            <!-- Current Medications -->
                            <fieldset>
                                <legend>Current Medications</legend>
                                <div class="form-group">
                                    <label for="medications">List any current medications:</label>
                                    <textarea class="form-control" id="medications" name="medications" rows="3" placeholder="List any current medications..."></textarea>
                                </div>
                            </fieldset>

                            <!-- Additional Notes -->
                            <fieldset>
                                <legend>Additional Notes</legend>
                                <div class="form-group">
                                    <label for="additional-notes">Any additional information:</label>
                                    <textarea class="form-control" id="additional-notes" name="additional-notes" rows="3" placeholder="Any additional information..."></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


        
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

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
