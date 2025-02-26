<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $fullname = $_POST['fullname']; // Full name entered in the form
    $payment_date = $_POST['date']; // The date of payment
    $med_cert_bill = $_POST['med_cert_bill']; // The medical certificate bill
    $payment = $_POST['payment']; // The payment made by the user
    $bill_change = $_POST['change']; // The change from the payment
    $address = 'N/A'; // Default address
    $walkIn_id = 'Medical Cert';
    
    // Calculate total (same as med_cert_bill in your case)
    $total = $med_cert_bill;

    try {
        // Prepare the SQL insert statement
        $stmt = $pdo->prepare("INSERT INTO payment_data (fullname, payment_date, med_cert_bill, total, bill_change, payment, address, walkIn_id) 
                               VALUES (:fullname, :payment_date, :med_cert_bill, :total, :bill_change, :payment, :address, :walkIn_id)");

        // Bind the parameters to the query
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':payment_date', $payment_date);
        $stmt->bindParam(':med_cert_bill', $med_cert_bill);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':bill_change', $bill_change);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':payment', $payment);
        $stmt->bindParam(':walkIn_id', $walkIn_id);

        // Execute the statement
        $stmt->execute();

        // Redirect or show a success message
        session_start();
        $_SESSION['success'] = "Payment Recorded!";
        echo "<script>sessionStorage.setItem('successMessage', 'Payment Recorded!'); window.location.href = '../adminpage/medical_cert.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
