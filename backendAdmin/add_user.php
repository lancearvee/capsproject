<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type'];

    $query = "INSERT INTO users (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)";
    $stmt = $pdo->prepare($query);

    try {
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, ':user_type' => $user_type]);

        session_start();
        $_SESSION['success'] = "User added successfully!";
        echo "<script>sessionStorage.setItem('successMessage', 'User added successfully!'); window.location.href = '../adminpage/users.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
