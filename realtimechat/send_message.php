<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = $_POST['receiver_id'] ?? null;
    $message = $_POST['message'] ?? null;
    $sender_id = $_POST['sender_id'] ?? null;

    if ($receiver_id && $message && $sender_id) {
        try {
            $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                'sender_id' => $sender_id, // Use the sender_id passed from JS
                'receiver_id' => $receiver_id,
                'message' => $message
            ]);

            echo json_encode(['status' => 'success', 'message' => 'Message sent.']);
        } catch (Exception $e) {
            error_log('Database error: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Receiver ID, message, and sender ID are required.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
