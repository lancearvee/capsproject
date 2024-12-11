<?php
 
include('../userLogin/db_con.php');

 
if (isset($_POST['municipalities'])) {
    $municipalities = explode(',', $_POST['municipalities']);

    $placeholders = str_repeat('?,', count($municipalities) - 1) . '?';
    $query = "SELECT id FROM municipalities WHERE name IN ($placeholders)";

    if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param(str_repeat('s', count($municipalities)), ...$municipalities);

        $stmt->execute();

        $result = $stmt->get_result();
        $municipality_id = [];
        while ($row = $result->fetch_assoc()) {
            $municipality_id[] = $row['id'];
        }

        if (count($municipality_id) > 0) {
            // Prepare query to get phone numbers from patients based on municipality_ids
            $placeholders = str_repeat('?,', count($municipality_id) - 1) . '?';
            $phoneQuery = "SELECT phone_number FROM patients WHERE municipality_id IN ($placeholders)";
            
            if ($phoneStmt = $conn->prepare($phoneQuery)) {
                // Bind the municipality_ids to the phone query
                $phoneStmt->bind_param(str_repeat('i', count($municipality_id)), ...$municipality_id);

                // Execute the query
                $phoneStmt->execute();
                
                // Fetch the phone numbers
                $phoneResult = $phoneStmt->get_result();
                $phoneNumbers = [];
                while ($row = $phoneResult->fetch_assoc()) {
                    $phoneNumbers[] = $row['phone_number'];
                }
 
                echo json_encode(['phoneNumbers' => $phoneNumbers]);
 
                $phoneStmt->close();
            }
        } else {
            echo json_encode(['phoneNumbers' => []]);  
        }

  
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Message</title>
  <link rel="stylesheet" href="../css/message.css ">

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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Message Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Message</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Message Campaign</h3>
                    </div>
                    <form action="send-message.php" method="POST">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="campaign-name">Campaign Name</label>
                                    <input type="text" class="form-control" id="campaign-name" name="campaign-name" placeholder="Enter campaign name" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="assign-user">Assign User</label>
                                    <input type="text" class="form-control" id="assign-user" name="assign-user" placeholder="Enter user to assign">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="start-date">Start Date</label>
                                    <input type="date" class="form-control" id="start-date" name="start-date" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone-number">Phone Number</label>
                                    <textarea class="form-control" id="phone-number" name="phone-number" placeholder="Enter phone numbers" rows="4"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Municipality</label>
                                    <div class="municipality-buttons">
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Calapan City" onclick="filterMunicipality('Calapan City')">Calapan City</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Baco" onclick="filterMunicipality('Baco')">Baco</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="San Teodoro" onclick="filterMunicipality('San Teodoro')">San Teodoro</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Puerto Galera" onclick="filterMunicipality('Puerto Galera')">Puerto Galera</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Naujan" onclick="filterMunicipality('Naujan')">Naujan</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Victoria" onclick="filterMunicipality('Victoria')">Victoria</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Socorro" onclick="filterMunicipality('Socorro')">Socorro</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Pola" onclick="filterMunicipality('Pola')">Pola</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Pinamalayan" onclick="filterMunicipality('Pinamalayan')">Pinamalayan</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Gloria" onclick="filterMunicipality('Gloria')">Gloria</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Bansud" onclick="filterMunicipality('Bansud')">Bansud</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Bongabong" onclick="filterMunicipality('Bongabong')">Bongabong</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Roxas" onclick="filterMunicipality('Roxas')">Roxas</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Mansalay" onclick="filterMunicipality('Mansalay')">Mansalay</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Bulalacao" onclick="filterMunicipality('Bulalacao')">Bulalacao</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="San Jose Occidental" onclick="filterMunicipality('San Jose Occidental')">San Jose Occidental</button>
                                    <button type="button" class="btn btn-secondary municipality-btn" data-value="Mamburao Occidental" onclick="filterMunicipality('Mamburao Occidental')">Mamburao Occidental</button>

                                    </div>
                                    <input type="hidden" id="selected-municipalities" name="municipalities" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Enter message" rows="4" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <button type="button" class="btn btn-secondary btn-block">Message 1</button>
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="button" class="btn btn-secondary btn-block">Message 2</button>
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="button" class="btn btn-secondary btn-block">Message 3</button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="run-from">Run From</label>
                                    <input type="date" class="form-control" id="run-from" name="run-from">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="run-until">Run Until</label>
                                    <input type="date" class="form-control" id="run-until" name="run-until">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">Send</button>
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
  bsCustomFileInput.init();
});

let selectedMunicipalities = [];

    function filterMunicipality(municipality) {
        // Toggle selection of municipality
        const index = selectedMunicipalities.indexOf(municipality);
        if (index === -1) {
            selectedMunicipalities.push(municipality);  
        } else {
            selectedMunicipalities.splice(index, 1);  
        }
        
 
        document.getElementById('selected-municipalities').value = selectedMunicipalities.join(',');

 
        fetchPhoneNumbers();
    }

    function fetchPhoneNumbers() {
        // Create the data object
        const data = new FormData();
        data.append('municipalities', selectedMunicipalities.join(','));
 
        fetch('../userLogin/db_con.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(data => {
 
            const phoneNumbers = data.phoneNumbers || [];
            document.getElementById('phone-number').value = phoneNumbers.join('\n');
        })
        .catch(error => console.error('Error:', error));
    }
 </script>
</body>
</html>
