<?php

require '../userLogin/db_con.php';

session_start();

$currentPage = basename($_SERVER['PHP_SELF']); 

if (isset($_SESSION['user_id']) && $currentPage != 'home.php') {
  header('Location: ../userpage/home.php');
  exit();
} elseif (isset($_SESSION['admin_id']) && $currentPage != 'dashboard.php') {
  header('Location: ../adminpage/dashboard.php');
  exit();
} elseif (isset($_SESSION['staff_id']) && $currentPage != 'dashboard.php') {
  header('Location: ../adminpage/dashboard.php');
  exit();
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thyroid</title>

    <!-- Meta -->
    <meta name="description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:title" content="Admin Templates - Dashboard Templates">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <link rel="shortcut icon" href="../assets/image/logo.png">

    <!-- *************
            ************ CSS Files *************
        ************* -->
    <link rel="stylesheet" href="../logintemplate/assets/fonts/remix/remixicon.css">
    <link rel="stylesheet" href="../logintemplate/assets/css/main.min.css">

  </head>

  <body class="login-bg">

    <!-- Container starts -->
    <div class="container">

      <!-- Auth wrapper starts -->
      <div class="auth-wrapper">
        <!-- Form starts -->
        <form action="../backendAuth/login_process.php" method="POST">

          <div class="auth-box">
           

            <h4 class="mb-4">Login</h4>

            <div class="mb-3">
              <label class="form-label" for="email">Your email <span class="text-danger">*</span></label>
              <input type="text" id="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($old['email'] ?? '', ENT_QUOTES); ?>">
              <?php if (isset($errors['email'])): ?>
                <div class="text-danger"><?php echo $errors['email']; ?></div>
              <?php endif; ?>
            </div>

            <div class="mb-2">
              <label class="form-label" for="password">Your password <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" id="password" class="form-control" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($old['password'] ?? '', ENT_QUOTES); ?>">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                  <i class="ri-eye-line text-primary"></i>
                </button>
              </div>
              <?php if (isset($errors['password'])): ?>
                <div class="text-danger"><?php echo $errors['password']; ?></div>
              <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end mb-3">
              <a href="reset_psw.php" class="text-decoration-underline">Forgot password?</a>
            </div>

            <div class="mb-3 d-grid gap-2">
              <button type="submit" class="btn btn-primary">Login</button>
              <a href="../userLogin/register.php" class="btn btn-secondary">Not registered? Signup</a>
            </div>

          </div>

        </form>
        <!-- Form ends -->

      </div>
      <!-- Auth wrapper ends -->

    </div>
    <!-- Container ends -->
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var passwordButton = document.querySelector('.input-group button i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordButton.classList.remove('ri-eye-line');
                passwordButton.classList.add('ri-eye-off-line');
            } else {
                passwordInput.type = 'password';
                passwordButton.classList.remove('ri-eye-off-line');
                passwordButton.classList.add('ri-eye-line');
            }
        }
    </script>
  </body>

</html>