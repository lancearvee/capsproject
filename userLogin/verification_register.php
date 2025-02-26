<?php
session_start();
require '../userLogin/db_con.php';
require '../vendor/autoload.php';
$errors = [];

function generateUniquePatientID($pdo) {
    do {
        $patient_id = rand(10000, 99999); // Generate a 5-digit random number
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE patient_id = :patient_id");
        $stmt->execute(['patient_id' => $patient_id]);
        $exists = $stmt->fetchColumn() > 0;
    } while ($exists);
    
    return $patient_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = trim($_POST['otp']);
    $email = $_SESSION['email'] ?? '';

    if (empty($otp)) {
        $errors['otp'] = 'OTP cannot be empty';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM temp_users WHERE email = :email AND otp = :otp AND otp_expiry > NOW()");
            $stmt->execute(['email' => $email, 'otp' => $otp]);
            $user = $stmt->fetch();

            if ($user) {
                $patient_id = generateUniquePatientID($pdo);
                $stmt = $pdo->prepare("INSERT INTO users (patient_id, name, email, password) VALUES (:patient_id, :name, :email, :password)");
                $stmt->execute([
                    'patient_id' => $patient_id,
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password']
                ]);

                $stmt = $pdo->prepare("DELETE FROM temp_users WHERE email = :email");
                $stmt->execute(['email' => $email]);

                $_SESSION['verified_email'] = $email;
                header('Location: ../userLogin/login.php');
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
        header('Location: verification_register.php');
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
            <form id="verificationForm" action="verification_register.php" method="POST">
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
            e.preventDefault(); // Prevent the form from submitting immediately

            Swal.fire({
                title: 'Verifying OTP...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit the form after the loading alert is shown
            this.submit();
        });
    </script>
</body>
</html>