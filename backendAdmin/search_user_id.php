<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'] ?? '';

    if (!empty($query)) {
        try {
            $stmt = $pdo->prepare("SELECT patient_id FROM patient_data WHERE patient_id LIKE :query LIMIT 10");
            $stmt->execute(['query' => $query . '%']);
            $results = $stmt->fetchAll();

            echo json_encode($results);
        } catch (PDOException $e) {
            echo json_encode([]);
        }
    } else {
        echo json_encode([]);
    }
}
?>
