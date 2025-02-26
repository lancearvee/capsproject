<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    try {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            $sql = "UPDATE users SET name = :name, email = :email, password = :password, user_type = :user_type WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':user_type' => $user_type,
                ':id' => $id
            ]);
        } else {
            $sql = "UPDATE users SET name = :name, email = :email, user_type = :user_type WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':user_type' => $user_type,
                ':id' => $id
            ]);
        }

        session_start();
        $_SESSION['success'] = "User updated successfully.";
        echo "<script>sessionStorage.setItem('successMessage', 'User updated successfully.'); window.location.href = '../adminpage/users.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error updating user: " . $e->getMessage();
    }
}
?>