<?php
session_start(); // Start the session first

// Include the database configuration file
$path = $_SERVER['DOCUMENT_ROOT'] . '/capstone/userLogin/db_con.php';
if (file_exists($path)) {
    include($path);
} else {
    die('Error: Unable to include the database configuration file at ' . $path);
}

// Check if the user is logged in
$user_id = $_SESSION['admin_id'] ?? null;

if (!$user_id) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit; // Prevent further script execution
}

if(isset($_POST['update'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $admin_id]);
 
   

   $old_pass = $_POST['old_pass'];
   $previous_pass = md5($_POST['previous_pass']);
   $previous_pass = filter_var($previous_pass, FILTER_SANITIZE_STRING);
   $new_pass = md5($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = md5($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if(!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($previous_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_password->execute([$confirm_pass, $admin_id]);
         $message[] = 'password has been updated!';
      }
   }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<?php
    $sql = "SELECT COUNT(*) AS total_patients FROM patients";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$totalPatients = $result['total_patients'];
?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $totalPatients; ?></h3>
            <p>Total Patient</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="../pages/patient-list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px"></sup></h3>
                <p>Today Patient</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="../pages/patient-list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>
                <p>Total Appointment</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="../pages/appointment-list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>
                <p>Total Prescription</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="../pages/prescription.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <?php
            $sql = "SELECT SUM(amount) AS total_payment FROM paymentrecord";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_payment = $result['total_payment'] ?? 0;

            $total_payment_formatted = number_format($total_payment, 2);
          ?>
        <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
        <div class="inner">
            <h3><?php echo $total_payment_formatted; ?></h3>
            <p>Total Payment</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>
        <a href="../pages/payment-list.php" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>


          <!-- ./col -->
        </div>
        
        <!-- /.row -->
        <!-- Main row -->
        <?php
    // Fetch total patients
    $sql = "SELECT COUNT(*) AS total_patients FROM patients";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalPatients = $result['total_patients'];

    // Fetch payment data for bar chart
    $sql = 'SELECT 
            date(payment_date) AS year_of_payment,
            COUNT(*) AS total_payment
            FROM paymentrecord
            GROUP BY date(payment_date)
            ORDER BY year_of_payment';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $year = [];
    $number_of_student = [];
    foreach ($result as $v) {
        $year[] = $v['year_of_payment'];
        $number_of_student[] = $v['total_payment'];
    }
?>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Total Patients -->
      <div class="col-lg-3 col-6">
        
          <div class="inner">
            
            
          </div>
          <div class="icon">
            
          </div>
         
        </div>
      </div>
      <!-- Other statistics -->
      <!-- Add more boxes here as required -->
    </div>

    <!-- Charts Section -->
    <div class="row" style="width: 2000px;">
      <!-- Bar Chart -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bar Chart Test</h5>
            <canvas id="barChart" style="max-height: 400px;"></canvas>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new Chart(document.querySelector('#barChart'), {
                  type: 'bar',
                  data: {
                    labels: <?php echo json_encode($year); ?>,
                    datasets: [{
                      label: 'Payments',
                      data: <?php echo json_encode($number_of_student); ?>,
                      backgroundColor: 'rgba(255, 99, 132, 0.2)',
                      borderColor: 'rgb(255, 99, 132)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  }
                });
              });
            </script>
          </div>
        </div>
      </div>

     
</section>

                  
          
          <section class="col-lg-5 connectedSortable">
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    
                  </div>
                  <!-- ./col -->    
                  <div class="col-4 text-center">
                    
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                   
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2024 <a href="https://pms.com">PMS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>

<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/pages/dashboard.js"></script>
</body>
<script>
function updatePatientCount() {
  fetch('total_patients.php')
    .then(response => response.text())
    .then(data => {
     
      document.querySelector('.small-box .inner h3').textContent = data;
    })
    .catch(error => console.error('Error fetching patient count:', error));
}
 
</script>
</html>
