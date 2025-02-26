<?php
require '../userLogin/db_con.php';

header('Content-Type: application/json');

try {
    $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

    if ($searchQuery) {
        // Search users by name
        $stmt = $pdo->prepare("SELECT id, name FROM users WHERE name LIKE :searchQuery LIMIT 10");
        $stmt->execute(['searchQuery' => "%$searchQuery%"]);
    } else {
        // Fetch all users (default behavior)
        $stmt = $pdo->query("SELECT id, name FROM users LIMIT 20");
    }

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
