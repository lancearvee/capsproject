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

$sql = "SELECT id, time_from, time_to, date, family_name, middle_name, given_name, suffix, date_of_birth, gender, province, municipality, barangay, contact_number, email, postal_code, medical_history FROM appointments WHERE status = 'Cancelled'";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $appointments = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header" style="display: flex; align-items: center;">
            <h3 class="card-title">Cancelled Appointments</h3>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Schedule</th>
                            <th>Date</th>
                            <th>Province</th>
                            <th>Municipality</th>
                            <th>Barangay</th>
                            <th>Contact Number</th>
                            <th>Medical History</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td>
                                <?php
                                $time_from = date('h:i A', strtotime($appointment['time_from']));
                                $time_to = date('h:i A', strtotime($appointment['time_to']));
                                echo $time_from . ' - ' . $time_to;
                                ?>
                            </td>
                            <td>
                                <?php
                                $date = date('F j, Y', strtotime($appointment['date'])); 
                                echo $date;
                                ?>
                            </td>
                            <td><?php echo $appointment['province']; ?></td>
                            <td><?php echo $appointment['municipality']; ?></td>
                            <td><?php echo $appointment['barangay']; ?></td>
                            <td><?php echo $appointment['contact_number']; ?></td>
                            <td><?php echo $appointment['medical_history']; ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-<?php echo $appointment['id']; ?>">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">
                                    <i class="fas fa-check"></i> 
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for each appointment -->
                        <div class="modal fade" id="modal-<?php echo $appointment['id']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <?php if (!empty($appointment['given_name'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Firstname:</strong> <?php echo $appointment['given_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['middle_name'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Middlename:</strong> <?php echo $appointment['middle_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['family_name'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Lastname:</strong> <?php echo $appointment['family_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['suffix'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Suffix:</strong> <?php echo $appointment['suffix']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['gender'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Sex:</strong> <?php echo $appointment['gender']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['date_of_birth'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Date of Birth:</strong> <?php echo $appointment['date_of_birth']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['email'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Email:</strong> <?php echo $appointment['email']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['postal_code'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Postal Code:</strong> <?php echo $appointment['postal_code']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
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
include('../adminpage/footer.php');
?>