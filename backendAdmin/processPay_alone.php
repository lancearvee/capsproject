<?php
require '../userLogin/db_con.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    try {
        $sql = "INSERT INTO payment_data (
            payment_date, fullname, contact,
            med_payment, med_bill, total, payment, bill_change,
            walkIn_id
        ) VALUES (
            :payment_date, :fullname, :contact,
            :med_payment, :med_bill, :total, :payment, :bill_change,
            :walkIn_id
        )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':payment_date' => $data['payment_date'],
            ':fullname' => $data['fullname'],
            ':contact' => $data['contact'],
            ':med_payment' => $data['med_payment'],
            ':med_bill' => $data['med_bill'],
            ':total' => $data['total'],
            ':payment' => $data['payment'],
            ':bill_change' => $data['bill_change'],
            ':walkIn_id' => $data['walkInId'],
        ]);

        echo json_encode(['success' => true, 'message' => 'Payment successfully inserted!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
?>
