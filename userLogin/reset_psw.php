<?php
session_start();
require '../userLogin/db_con.php';
require '../userLogin/mailer.php'; // Include PHPMailer configuration

require '../vendor/autoload.php'; 
 

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $errors['email'] = 'Email cannot be empty';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
 

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                $otp = rand(100000, 999999);
                $stmt = $pdo->prepare("UPDATE users SET otp = :otp, otp_expiry = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = :email");
                $stmt->execute(['otp' => $otp, 'email' => $email]);

                $subject = "Thyroid Health and Wellness Clinic - Password Reset OTP";
                $body = "
                    <html>
                    <head>
                        <title>Password Reset OTP</title>
                    </head>
                    <body>
                        <h2>Thyroid Health and Wellness Clinic</h2>
                        <p>Dear {$user['name']},</p>
                        <p>We received a request to reset your password. Please use the following OTP to reset your password:</p>
                        <h3>{$otp}</h3>
                        <p>This OTP is valid for 10 minutes.</p>
                        <p>If you did not request a password reset, please ignore this email or contact our support team.</p>
                        <p>Thank you,<br>Thyroid Health and Wellness Clinic</p>
                    </body>
                    </html>
                ";

                if (sendMail($email, $subject, $body)) {
                    $_SESSION['email'] = $email;
                    header('Location: verification.php');
                    exit();
                } else {
                    
                    $errors['general'] = 'Failed to send email';
                    error_log('Failed to send email to ' . $email);
                }
            } else {
                $errors['email'] = 'Email not found';
            }
        } catch (PDOException $e) {
            $errors['general'] = "An error occurred: " . $e->getMessage();
            error_log('Database error: ' . $e->getMessage());
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: reset_psw.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../logintemplate/assets/css/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="login-bg">
    <div class="container">
        <div class="auth-wrapper">
            <form id="resetForm" action="reset_psw.php" method="POST">
                <div class="auth-box">
                    <h4 class="mb-4">Reset Password</h4>

                    <div class="mb-3">
                        <label class="form-label" for="email">Your email <span class="text-danger">*</span></label>
                        <input type="text" id="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                        <?php if (isset($errors['email'])): ?>
                            <div class="text-danger"><?php echo $errors['email']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Send OTP</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('resetForm').addEventListener('submit', function(e) {
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