<?php
session_start(); 

ob_start();
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themewagon.github.io/Thyroid/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 Jan 2025 05:36:53 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Thyroid Health and Wellness</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../assets/image/logo.png" rel="icon">
  <link href="../usertemplate/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/" rel="preconnect">
  <link href="https://fonts.gstatic.com/" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../usertemplate/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../usertemplate/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../usertemplate/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../usertemplate/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../usertemplate/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../usertemplate/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>

  <!-- Main CSS File -->
  <link href="../usertemplate/assets/css/main.css" rel="stylesheet">

  <link rel="stylesheet" href="../logintemplate/assets/fonts/remix/remixicon.css">
  <!-- =======================================================
  * Template Name: Thyroid
  * Template URL: https://bootstrapmade.com/Thyroid-free-medical-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<style>
    @media (min-width: 1024px) {
    .appointment-link {
        display: none !important;
    }
}

.swal2-modal {
      max-width: 350px !important; 
      max-height: 300px !important;
    }
.swal2-icon {
      font-size: 8px; 
    }
</style>


<body class="index-page">

  <header id="header" class="header sticky-top">


    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="" class="logo d-flex align-items-center me-auto">
          <h1 class="sitename">Thyroid Health and Wellness</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="../userpage/home.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'home.php') ? 'active' : ''; ?>" >Home<br></a></li>
            <li><a href="../userpage/my_appointments.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'my_appointments.php') ? 'active' : ''; ?>">My Appointments</a></li>
            <li><a href="../userpage/messages.php" class="<?php echo (basename($_SERVER['REQUEST_URI']) == 'messages.php') ? 'active' : ''; ?>">Messages</a></li>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="../userpage/my_account.php">My Account</a></li>
                <li><a href="../userpage/security.php">Security</a></li>
                <li><a href="../userLogin/logout.php">Logout</a></li>
            </ul>
        </li>
            <li class="appointment-link">
                <a data-toggle="modal" data-target="#appointmentModal" role="button">Make an Appointment</a>
            </li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" data-toggle="modal" data-target="#appointmentModal" role="button">Make an Appointment</a>
      </div>
    </div>
  </header>