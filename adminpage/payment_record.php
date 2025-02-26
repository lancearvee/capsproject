<?php
include('../adminpage/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$admin_id = $_SESSION['admin_id'];
?>
<?php

require '../userLogin/db_con.php'; 

$sql = "SELECT * FROM payment_data";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $payments = $stmt->fetchAll();

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
            <h3 class="card-title">Records of Payments</h3>
            </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Online or Walk in ID</th>
                            <th>Fullname</th>
                            <th>Payment Date</th>
                            <th>Lab Test</th>
                            <th>Lab Test Bill</th>
                            <th>Check Up Bill</th>
                            <th>Medicine Bill</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Bill Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                        <tr>
                            <td><?php echo $payment['appointment_id']; ?><?php echo $payment['walkIn_id']; ?></td>
                            <td><?php echo $payment['fullname']; ?></td>
                            <td><?php echo date('F j, Y', strtotime($payment['payment_date'])); ?></td>
                            <td><?php echo !empty($payment['lab_test']) ? $payment['lab_test'] : 'None'; ?></td>
                            <td><?php echo !empty($payment['lab_bill']) ? $payment['lab_bill'] : 'None'; ?></td>
                            <td><?php echo !empty($payment['check_bill']) ? $payment['check_bill'] : 'None'; ?></td>
                            <td><?php echo !empty($payment['med_payment']) ? $payment['med_payment'] : 'None'; ?></td>
                            <td><?php echo !empty($payment['total']) ? '₱' . number_format($payment['total'], 2) : 'None';?></td>
                            <td><?php echo !empty($payment['payment']) ? '₱' . number_format($payment['payment'], 2) : 'None';?></td>
                            <td><?php echo !empty($payment['bill_change']) ? '₱' . number_format($payment['bill_change'], 2) : 'None';?></td>
                        </tr>
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