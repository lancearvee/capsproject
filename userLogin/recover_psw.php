<?php
session_start();
require '../userLogin/db_con.php';
require '../vendor/autoload.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = $_SESSION['verified_email'] ?? '';

    if (empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $errors['password'] = 'Password must be 8-20 characters long';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (empty($errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE users SET password = :password, otp = NULL, otp_expiry = NULL WHERE email = :email");
            $stmt->execute(['password' => $hashedPassword, 'email' => $email]);

            $_SESSION['success'] = 'Password has been reset successfully';
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            $errors['general'] = "An error occurred: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: recover_psw.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Password</title>
    <link rel="stylesheet" href="../logintemplate/assets/css/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="login-bg">
    <div class="container">
        <div class="auth-wrapper">
            <form id="recoverForm" action="recover_psw.php" method="POST">
                <div class="auth-box">
                    <h4 class="mb-4">Recover Password</h4>

                    <div class="mb-3">
                        <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter new password">
                        <?php if (isset($errors['password'])): ?>
                            <div class="text-danger"><?php echo $errors['password']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div class="text-danger"><?php echo $errors['confirm_password']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('recoverForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            this.submit();
        });
    </script>
</body>
</html>