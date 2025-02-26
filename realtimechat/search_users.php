<?php
require '../userLogin/db_con.php';

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $sql = "SELECT id, name FROM users WHERE name LIKE :searchTerm LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['searchTerm' => "%$searchTerm%"]);
    $results = $stmt->fetchAll();

    echo json_encode($results);
}
?>
