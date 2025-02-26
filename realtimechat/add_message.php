<?php
require '../userLogin/db_con.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['answer']) && !empty($_POST['answer'])) {
        $question = trim($_POST['question']); 
        $answer = trim($_POST['answer']); 

        $sql = "INSERT INTO chatbot (question, answer) VALUES (:question, :answer)"; // Change 'chatbot' to the correct table name

        try {
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':question', $question, PDO::PARAM_STR);
            $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['success'] = "Message Added!";
                echo "<script>sessionStorage.setItem('successMessage', 'Message Added!'); window.location.href = '../adminpage/chat_bot.php';</script>";
                exit;
            } else {
                echo "Error: Could not add message.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Both Question and Answer fields are required.";
    }
}
?>
