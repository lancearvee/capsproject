<?php
require '../userLogin/db_con.php';

if (isset($_GET['sender_id']) && isset($_GET['receiver_id'])) {
    $senderId = (int)$_GET['sender_id']; // Cast to integer
    $receiverId = (int)$_GET['receiver_id']; // Cast to integer

    // Validate sender and receiver IDs
    if (!filter_var($senderId, FILTER_VALIDATE_INT) || !filter_var($receiverId, FILTER_VALIDATE_INT)) {
        echo json_encode(['error' => 'Invalid sender or receiver ID']);
        exit;
    }

    // Debugging output
    error_log("Sender ID: $senderId, Receiver ID: $receiverId");

    try {
        // Fetch messages where sender and receiver match
        $query = "SELECT 
                    messages.*, 
                    users.name AS sender_name 
                  FROM messages 
                  INNER JOIN users ON messages.sender_id = users.id
                  WHERE (sender_id = :senderId AND receiver_id = :receiverId) 
                     OR (sender_id = :receiverId AND receiver_id = :senderId)
                  ORDER BY timestamp ASC";

        $stmt = $pdo->prepare($query);
        
        // Execute the query with parameters
        $stmt->execute([
            ':senderId' => $senderId,
            ':receiverId' => $receiverId
        ]);

        $messages = $stmt->fetchAll();

        // Return messages as JSON
        echo json_encode($messages);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}
?>
