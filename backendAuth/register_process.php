<?php
session_start();
require '../userLogin/db_con.php';
require '../userLogin/mailer.php'; // Include PHPMailer configuration

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $errors['password'] = "Password must be 8-20 characters long.";
    }

    if (empty($errors)) {
        try {
            // Check if email or username already exists in the users table
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR name = :name");
            $stmt->execute(['email' => $email, 'name' => $name]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $errors['name'] = "Username already exists.";
                $errors['email'] = "Email address already exists.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $otp = rand(100000, 999999);
                $stmt = $pdo->prepare("INSERT INTO temp_users (name, email, password, otp, otp_expiry) VALUES (:name, :email, :password, :otp, DATE_ADD(NOW(), INTERVAL 10 MINUTE))");
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'otp' => $otp
                ]);

                $subject = "Thyroid Health and Wellness Clinic - Email Verification OTP";
                $body = "
                    <html>
                    <head>
                        <title>Email Verification OTP</title>
                    </head>
                    <body>
                        <h2>Thyroid Health and Wellness Clinic</h2>
                        <p>Dear {$name},</p>
                        <p>Thank you for registering. Please use the following OTP to verify your email address:</p>
                        <h3>{$otp}</h3>
                        <p>This OTP is valid for 10 minutes.</p>
                        <p>If you did not register, please ignore this email or contact our support team.</p>
                        <p>Thank you,<br>Thyroid Health and Wellness Clinic</p>
                    </body>
                    </html>
                ";

                if (sendMail($email, $subject, $body)) {
                    $_SESSION['email'] = $email;
                    header('Location: ../userLogin/verification_register.php');
                    exit();
                } else {
                    $errors['general'] = 'Failed to send email';
                    error_log('Failed to send email to ' . $email);
                }
            }
        } catch (PDOException $e) {
            $errors['general'] = "Error: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = ['name' => $name, 'email' => $email, 'password' => $password];
        header('Location: ../userLogin/register.php');
        exit();
    }
}
?>