<?php
require '../userLogin/db_con.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $date = $_POST['date'];

    $sql = "SELECT * FROM appointments WHERE user_id = :user_id AND date = :date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userId, ':date' => $date]);

    $existingAppointment = $stmt->fetch();

    if ($existingAppointment) {
        echo json_encode([
            'success' => false,
            'message' => 'You are already appointed for this date. Check your appointments'
        ]);
        exit;
    }

    $sql = "SELECT * FROM time_slots WHERE date = :date"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':date' => $date]);
    $slots = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $slots
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in.'
    ]);
}
?>
