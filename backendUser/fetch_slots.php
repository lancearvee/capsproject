<?php
require '../userLogin/db_con.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $selectedDate = $_POST['date'];

    try {
        $stmt = $pdo->prepare("SELECT time_from, time_to, slots FROM time_slots WHERE date = :date");
        $stmt->execute(['date' => $selectedDate]);
        $timeSlots = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $timeSlots]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request',
        'method' => $_SERVER['REQUEST_METHOD'],
        'post_data' => $_POST
    ]);
}
?>
