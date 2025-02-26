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

<?php
require '../userLogin/db_con.php';

try {
    // Query to count users where user_type is 'user'
    $stmt = $pdo->prepare("SELECT COUNT(*) AS user_count FROM users WHERE user_type = :user_type");
    $stmt->execute(['user_type' => 'user']);
    $result = $stmt->fetch();

    // Store the count in a variable
    $userCount = $result['user_count'];

    // Query to count distinct medicine_name groups
    $stmt2 = $pdo->prepare("SELECT COUNT(DISTINCT medicine_name) AS medicine_group_count FROM medicine");
    $stmt2->execute();
    $result2 = $stmt2->fetch();

    // Store the medicine group count in a variable
    $medicineGroupCount = $result2['medicine_group_count'];

    // Query to count rows in the patient_data table
    $stmt3 = $pdo->prepare("SELECT COUNT(*) AS patient_count FROM patient_data");
    $stmt3->execute();
    $result3 = $stmt3->fetch();

    // Store the patient data count in a variable
    $patientCount = $result3['patient_count'];

    // Query to count completed appointments where user_id is not null or empty
    $stmt4 = $pdo->prepare("SELECT COUNT(*) AS completed_appointments_count FROM appointments WHERE status = :status AND user_id IS NOT NULL AND user_id != ''");
    $stmt4->execute(['status' => 'Completed']);
    $result4 = $stmt4->fetch();

    // Store the completed appointments count in a variable
    $completedAppointmentsCount = $result4['completed_appointments_count'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

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
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">
                    <?php echo $userCount; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-capsules"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Types Medicines</span>
                <span class="info-box-number"><?php echo $medicineGroupCount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Patients</span>
                <span class="info-box-number"><?php echo $patientCount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Completed Appointments</span>
                <span class="info-box-number"><?php echo $completedAppointmentsCount; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php
include('../adminpage/footer.php');
?>