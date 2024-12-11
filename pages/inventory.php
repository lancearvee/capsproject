<?php
require '../userLogin/db_con.php';

try {
    // Prepare and execute the SQL query
    $sql = "
        SELECT 
            m.medicine_id, 
            m.medicine_name, 
            m.stock_quantity, 
            m.expiration_date, 
            c.category_name 
        FROM medicine m
        LEFT JOIN category c ON m.category_id = c.category_id
    ";
    $stmt = $pdo->query($sql);

    // Check if data exists
    if ($stmt->rowCount() > 0) {
        $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $medicines = [];
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory List</title>

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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inventory List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

 
          <!-- /.card-header -->
          <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Inventory List</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool text-left" data-toggle="modal" data-target="#addEmpModal">
                <h6><i class="fas fa-plus"></i> Add Inventory</h6>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Medicine ID</th>
                  <th>Medicine Name</th>
                  <th>Stock Quantity</th>
                  <th>Expiration Date</th>
                  <th>Category Name</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($medicines)): ?>
                  <?php foreach ($medicines as $medicine): ?>
                    <tr>
                      <td><?= htmlspecialchars($medicine['medicine_id']); ?></td>
                      <td><?= htmlspecialchars($medicine['medicine_name']); ?></td>
                      <td><?= htmlspecialchars($medicine['stock_quantity']); ?></td>
                      <td><?= htmlspecialchars($medicine['expiration_date']); ?></td>
                      <td><?= htmlspecialchars($medicine['category_name']); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">No data available</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
    
<!-- /.content -->
</div>

      <!-- jQuery -->
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
</script>
</body>
</html>