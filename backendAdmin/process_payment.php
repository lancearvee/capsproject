<?php
require '../userLogin/db_con.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    try {
        $sql = "INSERT INTO payment_data (
            appointment_fk_id, payment_date, fullname, address, contact,
            lab_test, lab_payment, lab_bill, check_payment, check_bill,
            med_payment, med_bill, total, payment, bill_change, user_id, appointment_id, walkIn_id
        ) VALUES (
            :appointment_fk_id, :payment_date, :fullname, :address, :contact,
            :lab_test, :lab_payment, :lab_bill, :check_payment, :check_bill,
            :med_payment, :med_bill, :total, :payment, :bill_change, :user_id, :appointment_id, :walkIn_id
        )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':appointment_fk_id' => $data['appointment_fk_id'],
            ':payment_date' => $data['payment_date'],
            ':fullname' => $data['fullname'],
            ':address' => $data['address'],
            ':contact' => $data['contact'],
            ':lab_test' => $data['lab_test'],
            ':lab_payment' => $data['lab_payment'],
            ':lab_bill' => $data['lab_bill'],
            ':check_payment' => $data['check_payment'],
            ':check_bill' => $data['check_bill'],
            ':med_payment' => $data['med_payment'],
            ':med_bill' => $data['med_bill'],
            ':total' => $data['total'],
            ':payment' => $data['payment'],
            ':bill_change' => $data['bill_change'],
            ':user_id' => $data['user_id'],
            ':appointment_id' => $data['appoint_id'],
            ':walkIn_id' => $data['walkIn_id']
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Payment successfully inserted!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
