<?php
require '../userLogin/db_con.php';
session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    try {
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'Cancelled' WHERE id = :appointment_id AND user_id = :user_id");
        
        $stmt->execute([
            'appointment_id' => $appointment_id,
            'user_id' => $user_id
        ]);

            session_start();
            $_SESSION['success'] = "Appointment Cancelled!";
            echo "<script>sessionStorage.setItem('successMessage', 'Appointment Cancelled!'); window.location.href = '../userpage/my_appointments.php';</script>";
            exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No appointment ID provided.";
}
?>
