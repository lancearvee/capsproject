<?php

require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'check_slots') {
        $date = $_POST['date'];

        $stmt = $pdo->prepare("SELECT time_from, time_to, slots FROM time_slots WHERE date = :date");
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        $slots = $stmt->fetchAll();

        if ($slots) {
            echo json_encode(['found' => true, 'slots' => $slots]);
        } else {
            echo json_encode(['found' => false]);
        }
        exit; 

    } elseif ($action === 'get_events') {
        $events = [];
        
        $stmt = $pdo->prepare("SELECT DISTINCT date FROM time_slots WHERE slots > 0");
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $events[] = ['date' => $row['date']]; 
        }

        echo json_encode($events);
    } 
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'save_slots') {
        $date = $_POST['date'];
        $slotsData = json_decode($_POST['slots_data'], true);

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO time_slots (date, time_from, time_to, slots) VALUES (:date, :time_from, :time_to, :slots)");

            foreach ($slotsData as $slot) {
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':time_from', $slot['time_from']);
                $stmt->bindParam(':time_to', $slot['time_to']);
                $stmt->bindParam(':slots', $slot['slots']);
                $stmt->execute();
            }

            $pdo->commit();

            session_start();
            $_SESSION['success'] = "Slot Added!";

            echo "<script>sessionStorage.setItem('successMessage', 'Slot Added!'); window.location.href = '../adminpage/schedule.php';</script>";
            exit;

        } catch (Exception $e) {
            $pdo->rollBack();
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
