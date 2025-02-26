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

$walkInId = isset($_GET['walkIn_id']) ? htmlspecialchars($_GET['walkIn_id']) : null;
$billAmount = isset($_GET['bill_amount']) ? htmlspecialchars($_GET['bill_amount']) : '0.00';

if ($walkInId) {
    $query = $pdo->prepare("SELECT * FROM prescription WHERE walkIn_id = :walkIn_id");
    $query->execute([':walkIn_id' => $walkInId]);
    $prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    $prescriptions = [];
}
?>

<style>
  @media print {
    #insertPaymentBtn {
      display: none;
    }
    td, th {
      padding: 10px !important;  
      height: 20px !important;  
      vertical-align: middle !important; 
    }
    tr {
      height: 20px !important; 
    }
  }
</style>


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
                    <!-- Header: Logo and Title -->
                    <div class="header" style="text-align: center; padding: 20px;">
                        <img src="../assets/image/logo.png" alt="Logo" style="max-width: 100px; height: auto; display: block; margin: 0 auto;">
                        <h1 style="font-size: 24px; margin-top: 10px;">Thyroid Health and Wellness</h1>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Statement Table -->
                        <table class="table table-bordered" style="margin-bottom: 20px; font-size: 12px; width: 30%;">
                            <thead>
                                <tr>
                                    <th colspan="2" style="font-size: 20px;">STATEMENT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 15px;">Statement Date</td>
                                    <td style="font-size: 15px;" id="payment_date"><?php echo date('F j, Y'); ?></td>
                                    <td style="font-size: 15px; display: none;" id="walkInId"><?php echo $walkInId; ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Bill To Table -->
                        <table class="table table-bordered" style="margin-bottom: 20px; font-size: 12px; width: 40%;">
                            <thead>
                                <tr>
                                    <th colspan="2" style="font-size: 20px;">BILL TO:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 15px;">Patient Name</td>
                                    <td style="font-size: 15px;" id="fullname" ondblclick="editCell(this)"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px;">Patient Phone No.</td>
                                    <td style="font-size: 15px;" id="contact" ondblclick="editCell(this)"></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Payment Breakdown Table -->
                        <table class="table table-bordered" style="margin-bottom: 20px; font-size: 12px; width: 70%;">
                            <thead>
                                <tr>
                                    <th colspan="4" style="font-size: 20px;">PAYMENT BREAKDOWN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Payment Date</th>
                                    <th>Payment Description</th>
                                    <th>Payment Type</th>
                                    <th>Bill Amount</th>
                                </tr>
                                <tr>
                                    <td><?php echo date('F j, Y'); ?></td>
                                    <td>Medicine</td>
                                    <td id="med_payment">Cash</td>
                                    <td id="med_bill" ondblclick="editCell(this)"><?php echo number_format($billAmount, 2); ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                    <td id="total"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Payment:</strong></td>
                                    <td id="payment" ondblclick="editCell(this)"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Change:</strong></td>
                                    <td id="bill_change" ondblclick="editCell(this)"></td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Prescription Table -->
                        <table class="table table-bordered" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th colspan="7" style="font-size: 20px;">PRESCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Brand Name</th>
                                    <th>Dosage</th>
                                    <th>Gram</th>
                                    <th>Price per unit</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                </tr>
                                <?php foreach ($prescriptions as $prescription): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prescription['medicine_name']); ?></td>
                                    <td><?php echo htmlspecialchars($prescription['brand_name']); ?></td>
                                    <td><?php echo htmlspecialchars($prescription['dosage']); ?></td>
                                    <td><?php echo htmlspecialchars($prescription['gram']); ?></td>
                                    <td><?php echo number_format($prescription['price_unit'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($prescription['quantity']); ?></td>
                                    <td id="remarks" ondblclick="editCell(this)"><?php echo isset($prescription['remarks']) ? htmlspecialchars($prescription['remarks']) : ''; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Button to Process Payment -->
                        <div style="text-align: right; padding-top: 30px;">
                            <button id="insertPaymentBtn" class="btn btn-success">Process Payment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);
            sessionStorage.removeItem('successMessage');
        }
    });

    document.getElementById("insertPaymentBtn").addEventListener("click", function () {
        const paymentDate = new Date().toISOString().split('T')[0]; 

        const data = {
            payment_date: paymentDate,
            fullname: document.getElementById("fullname").innerText,
            contact: document.getElementById("contact").innerText,
            walkInId: document.getElementById("walkInId").innerText,
            med_payment: document.getElementById("med_payment").innerText,
            med_bill: parseFloat(document.getElementById("med_bill").innerText) || 0,
            total: parseFloat(document.getElementById("total").innerText) || 0,
            payment: parseFloat(document.getElementById("payment").innerText) || 0,
            bill_change: parseFloat(document.getElementById("bill_change").innerText) || 0,
        };

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to proceed with the payment?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("../backendAdmin/processPay_alone.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((result) => {
                    if (result.success) {
                        sessionStorage.setItem('successMessage', result.message);
                        window.location.href = "../adminpage/prescription.php";
                    } else {
                        alert("Failed to insert payment: " + result.error);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
            }
        });
    });
</script>


<script>
  function editCell(cell) {
    const currentText = cell.innerText;
    cell.innerHTML = `<input type="text" class="form-control" value="${currentText}">`;
    const inputField = cell.querySelector("input");

    inputField.focus();

    inputField.addEventListener("blur", function() {
      const newValue = inputField.value;
      cell.innerHTML = newValue;
      updateTotal();
    });

    inputField.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        const newValue = inputField.value;
        cell.innerHTML = newValue;
        updateTotal();
      }
    });
  }

  function updateTotal() {
    const medicineBill = parseFloat(document.getElementById("med_bill").innerText) || 0;
    const paymentTotal = parseFloat(document.getElementById("payment").innerText) || 0;

    const totalBill = medicineBill;
    document.getElementById("total").innerText = totalBill.toFixed(2);

    const bill_change = paymentTotal - totalBill;
    document.getElementById("bill_change").innerText = bill_change >= 0 ? bill_change.toFixed(2) : "0.00";
  }

  updateTotal();
</script>




<?php
include('../adminpage/footer.php');
?>