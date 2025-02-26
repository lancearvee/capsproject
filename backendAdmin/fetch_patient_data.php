<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'] ?? '';

    if (!empty($patient_id)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM patient_data WHERE patient_id = :patient_id LIMIT 1");
            $stmt->execute(['patient_id' => $patient_id]);
            $data = $stmt->fetch();

            if ($data) {
                echo json_encode($data);
            } else {
                echo json_encode([]);
            }
        } catch (PDOException $e) {
            echo json_encode([]);
        }
    } else {
        echo json_encode([]);
    }
}
?>
