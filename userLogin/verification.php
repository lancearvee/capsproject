<?php
session_start();
require '../userLogin/db_con.php';
require '../vendor/autoload.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = trim($_POST['otp']);
    $email = $_SESSION['email'] ?? '';

    if (empty($otp)) {
        $errors['otp'] = 'OTP cannot be empty';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND otp = :otp AND otp_expiry > NOW()");
            $stmt->execute(['email' => $email, 'otp' => $otp]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['verified_email'] = $email;
                header('Location: recover_psw.php');
                exit();
            } else {
                $errors['otp'] = 'Invalid or expired OTP';
            }
        } catch (PDOException $e) {
            $errors['general'] = "An error occurred: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: verification.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="../logintemplate/assets/css/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="login-bg">
    <div class="container">
        <div class="auth-wrapper">
            <form id="verificationForm" action="verification.php" method="POST">
                <div class="auth-box">
                    <h4 class="mb-4">Verify OTP</h4>

                    <div class="mb-3">
                        <label class="form-label" for="otp">OTP <span class="text-danger">*</span></label>
                        <input type="text" id="otp" class="form-control" name="otp" placeholder="Enter OTP">
                        <?php if (isset($errors['otp'])): ?>
                            <div class="text-danger"><?php echo $errors['otp']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Verify</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
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