<?php
require '../userLogin/db_con.php';

// Fetch questions and answers
$query = "SELECT * FROM chatbot ORDER BY id ASC"; // Adjust the table name if needed
$stmt = $pdo->prepare($query);
$stmt->execute();
$questions_answers = $stmt->fetchAll();

// Return the results as JSON
echo json_encode($questions_answers);
?>
