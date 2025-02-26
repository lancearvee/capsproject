<?php
session_start();
require '../userLogin/db_con.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $errors = [];

    if (empty($email)) {
        $errors['email'] = 'Email cannot be empty';
    }
    if (empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    switch ($user['user_type']) {
                        case 'admin':
                            $_SESSION['admin_id'] = $user['id'];
                            header('Location: ../adminpage/dashboard.php');
                            exit();
                        case 'user':
                            $_SESSION['user_id'] = $user['id'];
                            header('Location: ../userpage/home.php');
                            exit();
                        case 'staff':
                            $_SESSION['staff_id'] = $user['id'];
                            header('Location: ../adminpage/dashboard.php');
                            exit();
                        default:
                            $errors['general'] = 'Invalid user type';
                    }
                } else {
                    $errors['password'] = 'Incorrect password';
                }
            } else {
                $errors['email'] = 'Email not found';
            }
        } catch (PDOException $e) {
            $errors['general'] = "An error occurred: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = ['email' => $email, 'password' => $password]; 
        header('Location: ../userLogin/login.php');
        exit();
    }

    // if (!empty($errors)) {
    //     $_SESSION['errors'] = $errors;
    //     $_SESSION['old'] = ['email' => $email]; 
    //     header('Location: ../userLogin/landing.php#loginModal');
    //     exit();
    // }
}
?>
