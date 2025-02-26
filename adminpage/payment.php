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

$tLevel = isset($_GET['t_level']) ? $_GET['t_level'] : 'N/A';
$billAmount = isset($_GET['bill_amount']) ? $_GET['bill_amount'] : '0.00';
$appointmentId = isset($_GET['appointment_id']) ? $_GET['appointment_id'] : '';
$familyName = isset($_GET['family_name']) ? $_GET['family_name'] : '';
$middleName = isset($_GET['middle_name']) ? $_GET['middle_name'] : '';
$givenName = isset($_GET['given_name']) ? $_GET['given_name'] : '';
$suffix = isset($_GET['suffix']) ? $_GET['suffix'] : '';
$province = isset($_GET['province']) ? $_GET['province'] : '';
$municipality = isset($_GET['municipality']) ? $_GET['municipality'] : '';
$barangay = isset($_GET['barangay']) ? $_GET['barangay'] : '';
$contactNumber = isset($_GET['contact_number']) ? $_GET['contact_number'] : '';
$appointmentId = isset($_GET['appointment_id']) ? $_GET['appointment_id'] : '';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
$appoint_id = isset($_GET['appoint_id']) ? $_GET['appoint_id'] : '';
$walkIn_id = isset($_GET['walkIn_id']) ? $_GET['walkIn_id'] : '';

$medicines = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM prescription WHERE appointment_fk_id = :appointment_id");
    $stmt->execute([':appointment_id' => $appointmentId]);

    $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "An error occurred while fetching the medicines: " . $e->getMessage();
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

          <!-- /.card-header -->
          <div class="card-body">
            <!-- First Table -->
            <table class="table table-bordered" style="margin-bottom: 20px; font-size: 12px; height: auto; width: 30%;">
              <thead>
                <tr>
                  <th style="width: 200px; font-size: 20px;" colspan="2">STATEMENT</th> <!-- Header added -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="font-size: 15px;">ID</td>
                  <!-- Assuming these are separate <td>s in a table row -->
                  <td style="font-size: 15px;">
                      <span id="appoint_id"><?php echo $appoint_id; ?></span> 
                      <span id="walkIn_id"><?php echo $walkIn_id; ?></span>
                  </td>



                </tr>
                <tr>
                  <td style="font-size: 15px;">Statement Date</td>
                  <td style="font-size: 15px;" id="payment_date"><?php echo date('F j, Y'); ?></td>
                </tr>
                
                <tr>
                  <td style="font-size: 15px;">Patient ID</td>
                  <td style="font-size: 15px; display: none;" id="user_id"><?php echo $user_id; ?></td>
                  <td style="font-size: 15px;"><?php echo $patient_id; ?></td>
                  <td style="font-size: 15px; display: none;" id="appointment_fk_id"><?php echo $appointmentId; ?></td>

                </tr>
              </tbody>
            </table>

            <!-- Second Table -->
            <table class="table table-bordered" style="margin-bottom: 20px; font-size: 12px; height: auto; width: 40%;">
              <thead>
                <tr>
                  <th style="width: 200px; font-size: 20px;" colspan="2">BILL TO:</th> <!-- Header added -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="font-size: 15px;">Patient Name</td>
                  <td style="font-size: 15px;" id="fullname"><?php echo htmlspecialchars($givenName . ' ' . $middleName . ' ' . $familyName . ' ' . $suffix); ?></td>
                </tr>
                <tr>
                  <td style="font-size: 15px;">Patient Address</td>
                  <td style="font-size: 15px;" id="address"><?php echo htmlspecialchars($province  . ', ' . $municipality  . ', ' . $barangay); ?></td>
                </tr>
                <tr>
                  <td style="font-size: 15px;">Patient Phone No.</td>
                  <td style="font-size: 15px;" id="contact"><?php echo htmlspecialchars($contactNumber); ?></td>
                </tr>
              </tbody>
            </table>

            <!-- Third Table (modified to 4 columns) -->
            <table class="table table-bordered" style="margin-bottom: 20px; font-size: 12px; height: auto; width: 70%;">
              <thead>
                <tr>
                  <th colspan="4" style="font-size: 20px;">PAYMENT BREAKDOWN</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th style="font-size: 15px;">Payment Date</th>
                  <th style="font-size: 15px;">Payment Description</th>
                  <th style="font-size: 15px;">Payment Type</th>
                  <th style="font-size: 15px;">Bill Amount</th>
                </tr>
                <tr>
                  <td style="font-size: 15px;"><?php echo date('F j, Y'); ?></td> <!-- Payment Date (current date) -->
                  <td style="font-size: 15px;" id="lab_test">Lab Test (<?php echo $tLevel; ?>)</td>
                  <td style="font-size: 15px;" id="lab_payment" ondblclick="editDropdown(this)">Cash</td>
                  <td style="font-size: 15px;" id="lab_bill" ondblclick="editCell(this)"></td>
                <tr>
                  <td style="font-size: 15px;"></td>
                  <td style="font-size: 15px;">Check Up</td>
                  <td style="font-size: 15px;" id="check_payment" ondblclick="editDropdown(this)">Cash</td>
                  <td style="font-size: 15px;" id="check_bill" ondblclick="editCell(this)"></td> 
                </tr>
                <tr>
                  <td style="font-size: 15px;"></td>
                  <td style="font-size: 15px;">Medicine</td>
                  <td style="font-size: 15px;" id="med_payment" ondblclick="editDropdown(this)">Cash</td>
                  <td style="font-size: 15px;" id="med_bill"><?php echo number_format($billAmount, 2); ?></td> <!-- Display the Bill Amount -->
                </tr>
              </tbody>
              <tfoot>
                    <tr>
                        <td style="font-size: 15px;" colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td style="font-size: 15px;" id="total" colspan="3"></td> <!-- Total Bill -->
                    </tr>
                    <tr>
                        <td style="font-size: 15px;" colspan="3" class="text-right"><strong>Payment:</strong></td>
                        <td style="font-size: 15px;" id="payment" colspan="3" ondblclick="editCell(this)"></td> <!-- Total Bill -->
                    </tr>
                    <tr>
                        <td style="font-size: 15px;" colspan="3" class="text-right"><strong>Change:</strong></td>
                        <td style="font-size: 15px;" id="bill_change" colspan="3" ondblclick="editCell(this)"></td> <!-- Total Bill -->
                    </tr>
                </tfoot>
            </table>

            <!-- Fourth Table (Prescription) -->
            <table class="table table-bordered" style="font-size: 12px; height: auto;">
              <thead>
                <tr>
                  <th colspan="7" style="font-size: 20px;">PRESCRIPTION</th> <!-- Header added -->
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th style="font-size: 15px;">Medicine Name</th>
                  <th style="font-size: 15px;">Brand Name</th>
                  <th style="font-size: 15px;">Dosage</th>
                  <th style="font-size: 15px;">Gram/ML</th>
                  <th style="font-size: 15px;">Remarks</th>
                </tr>
                <?php foreach ($medicines as $medicine): ?>
                <tr>
                    <td style="font-size: 15px;"><?php echo htmlspecialchars($medicine['medicine_name']); ?></td>
                    <td style="font-size: 15px;"><?php echo htmlspecialchars($medicine['brand_name']); ?></td>
                    <td style="font-size: 15px;"><?php echo htmlspecialchars($medicine['dosage']); ?></td>
                    <td style="font-size: 15px;">
                        <?php 
                            echo htmlspecialchars($medicine['gram']) . ' ' . 
                            ($medicine['dosage'] == 'Liquid' ? 'ml' : 'mg'); 
                        ?>
                    </td>
                    <td style="font-size: 15px;" id="remarks" ondblclick="editCell(this)"></td>
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
            appointment_fk_id: document.getElementById("appointment_fk_id").innerText,
            appoint_id: document.getElementById("appoint_id").innerText,
            walkIn_id: document.getElementById("walkIn_id").innerText,
            user_id: document.getElementById("user_id").innerText,
            payment_date: paymentDate,
            fullname: document.getElementById("fullname").innerText,
            address: document.getElementById("address").innerText,
            contact: document.getElementById("contact").innerText,
            lab_test: document.getElementById("lab_test").innerText,
            lab_payment: document.getElementById("lab_payment").innerText,
            lab_bill: parseFloat(document.getElementById("lab_bill").innerText) || 0,
            check_payment: document.getElementById("check_payment").innerText,
            check_bill: parseFloat(document.getElementById("check_bill").innerText) || 0,
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
                fetch("../backendAdmin/process_payment.php", {
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
                        window.location.href = "../adminpage/approved.php";
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

  function editDropdown(cell) {
    const currentText = cell.innerText;  
    const dropdown = 
      `<select class="form-control">
        <option value="Cash" ${currentText === 'Cash' ? 'selected' : ''}>Cash</option>
        <option value="Gcash" ${currentText === 'Gcash' ? 'selected' : ''}>Gcash</option>
      </select>`;
    cell.innerHTML = dropdown;

    const selectField = cell.querySelector("select");
    selectField.focus();  

    selectField.addEventListener("blur", function() {
      const selectedValue = selectField.value;
      cell.innerHTML = selectedValue; 
    });

    selectField.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        const selectedValue = selectField.value;
        cell.innerHTML = selectedValue;
      }
    });
  }

  function updateTotal() {
    const labTestBill = parseFloat(document.getElementById("lab_bill").innerText) || 0;
    const checkUpBill = parseFloat(document.getElementById("check_bill").innerText) || 0;
    const medicineBill = parseFloat(document.getElementById("med_bill").innerText) || 0;
    const paymentTotal = parseFloat(document.getElementById("payment").innerText) || 0;

    const totalBill = labTestBill + checkUpBill + medicineBill;
    document.getElementById("total").innerText = totalBill.toFixed(2);

    const bill_change = paymentTotal - totalBill;
    document.getElementById("bill_change").innerText = bill_change >= 0 ? bill_change.toFixed(2) : "0.00";
  }

  updateTotal();
</script>



<?php
include('../adminpage/footer.php');
?>