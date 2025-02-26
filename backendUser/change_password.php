<?php
session_start();
require '../userLogin/db_con.php';

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'User not authenticated.';
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (strlen($new_password) < 8 || strlen($new_password) > 20) {
        $response['message'] = 'Password must be 8-20 characters long.';
        echo json_encode($response);
        exit();
    }

    if ($new_password !== $confirm_password) {
        $response['message'] = 'New passwords do not match.';
        echo json_encode($response);
        exit();
    }

    $query = "SELECT password FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($current_password, $user['password'])) {
        if (password_verify($new_password, $user['password'])) {
            $response['message'] = 'New password cannot be the same as the old password.';
            echo json_encode($response);
            exit();
        }

        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
        $update_query = "UPDATE users SET password = :password WHERE id = :user_id";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->bindParam(':password', $hashedPassword);
        $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Password changed successfully.';
        } else {
            $response['message'] = 'Failed to change password.';
        }
    } else {
        $response['message'] = 'Current password is incorrect.';
    }
}

echo json_encode($response);
?>