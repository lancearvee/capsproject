<?php
session_start(); 

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from adminlte.io/themes/v3/pages/tables/data.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jan 2025 09:06:23 GMT -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thyroid Health and Wellness</title>
  <link rel="shortcut icon" type="image/x-icon" href="../assets/image/logo.png">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admintemplate/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../admintemplate/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../admintemplate/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../admintemplate/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="../admintemplate/dist/css/adminlte.min2167.css?v=3.2.0">

  <style>
    .swal2-modal {
      max-width: 350px !important; 
      max-height: 300px !important;
    }
  .swal2-icon {
    font-size: 8px; 
    }
  </style>
<script data-cfasync="false" nonce="bb239b14-1d14-49aa-aa6f-e9e23e28a692">try{(function(w,d){!function(a,b,c,d){if(a.zaraz)console.error("zaraz is loaded twice");else{a[c]=a[c]||{};a[c].executed=[];a.zaraz={deferred:[],listeners:[]};a.zaraz._v="5848";a.zaraz._n="bb239b14-1d14-49aa-aa6f-e9e23e28a692";a.zaraz.q=[];a.zaraz._f=function(e){return async function(){var f=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:f})}};for(const g of["track","set","debug"])a.zaraz[g]=a.zaraz._f(g);a.zaraz.init=()=>{var h=b.getElementsByTagName(d)[0],i=b.createElement(d),j=b.getElementsByTagName("title")[0];j&&(a[c].t=b.getElementsByTagName("title")[0].text);a[c].x=Math.random();a[c].w=a.screen.width;a[c].h=a.screen.height;a[c].j=a.innerHeight;a[c].e=a.innerWidth;a[c].l=a.location.href;a[c].r=b.referrer;a[c].k=a.screen.colorDepth;a[c].n=b.characterSet;a[c].o=(new Date).getTimezoneOffset();if(a.dataLayer)for(const k of Object.entries(Object.entries(dataLayer).reduce(((l,m)=>({...l[1],...m[1]})),{})))zaraz.set(k[0],k[1],{scope:"page"});a[c].q=[];for(;a.zaraz.q.length;){const n=a.zaraz.q.shift();a[c].q.push(n)}i.defer=!0;for(const o of[localStorage,sessionStorage])Object.keys(o||{}).filter((q=>q.startsWith("_zaraz_"))).forEach((p=>{try{a[c]["z_"+p.slice(7)]=JSON.parse(o.getItem(p))}catch{a[c]["z_"+p.slice(7)]=o.getItem(p)}}));i.referrerPolicy="origin";i.src="../../../../cdn-cgi/zaraz/sd0d9.js?z="+btoa(encodeURIComponent(JSON.stringify(a[c])));h.parentNode.insertBefore(i,h)};["complete","interactive"].includes(b.readyState)?zaraz.init():a.addEventListener("DOMContentLoaded",zaraz.init)}}(w,d,"zarazData","script");window.zaraz._p=async bs=>new Promise((bt=>{if(bs){bs.e&&bs.e.forEach((bu=>{try{const bv=d.querySelector("script[nonce]"),bw=bv?.nonce||bv?.getAttribute("nonce"),bx=d.createElement("script");bw&&(bx.nonce=bw);bx.innerHTML=bu;bx.onload=()=>{d.head.removeChild(bx)};d.head.appendChild(bx)}catch(by){console.error(`Error executing script: ${bu}\n`,by)}}));Promise.allSettled((bs.f||[]).map((bz=>fetch(bz[0],bz[1]))))}bt()}));zaraz._p({"e":["(function(w,d){})(window,document)"]});})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script></head>
<body class="sidebar-mini sidebar-closed sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      

      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../userLogin/logout.php" role="button" >
            <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>

      
      
    </ul>
  </nav>
  <!-- /.navbar -->

  

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a  class="brand-link">
      <img src="../assets/image/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../adminpage/dashboard.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item">
            <a href="../adminpage/staff.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'staff.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Clinic Staff</p>
            </a>
          </li>
          <?php endif; ?>


          <li class="nav-item">
            <a href="../adminpage/patient.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'patient.php') ? 'active' : ''; ?>" class="nav-link">
            <i class="nav-icon fas fa-user-injured"></i>
                <p>Patient</p>
            </a>
            </a>
          </li>

          <li class="nav-item <?php echo (in_array(basename($_SERVER['REQUEST_URI']), ['pending.php', 'complete_appoinment.php', 'approved.php', 'cancelled_appointment.php'])) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo (in_array(basename($_SERVER['REQUEST_URI']), ['pending.php', 'complete_appoinment.php', 'approved.php' , 'cancelled_appointment.php'])) ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                    Appointment
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="../adminpage/pending.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'pending.php') ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../adminpage/approved.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'approved.php') ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Approved</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../adminpage/complete_appoinment.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'complete_appoinment.php') ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Completed</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../adminpage/cancelled_appointment.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'cancelled_appointment.php') ? 'active' : ''; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cancelled</p>
                    </a>
                </li>
            </ul>
        </li>


          <li class="nav-item">
            <a href="../adminpage/schedule.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'schedule.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-clock"></i>
                <p>Schedule</p>
            </a>
            </a>
          </li>

          <li class="nav-item">
            <a href="../adminpage/prescription.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'prescription.php') ? 'active' : ''; ?>" class="nav-link">
            <i class="nav-icon fas fa-prescription"></i>
                <p>Prescription</p>
            </a>
            </a>
          </li>

          <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item <?php echo (in_array(basename($_SERVER['REQUEST_URI']), ['medical_cert.php', 'refferal_cert.php', 'medicine.php'])) ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo (in_array(basename($_SERVER['REQUEST_URI']), ['medical_cert.php', 'refferal_cert.php', 'medicine.php'])) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-certificate"></i>
                  <p>
                  Certificates
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="../adminpage/medical_cert.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'medical_cert.php') ? 'active' : ''; ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Medical Certificate</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../adminpage/refferal_cert.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'refferal_cert.php') ? 'active' : ''; ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Refferal Letter</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../adminpage/medicine.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'medicine.php') ? 'active' : ''; ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Medicine</p>
                      </a>
                  </li>
              </ul>
          </li>
          <?php endif; ?>


          <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item <?php echo (in_array(basename($_SERVER['REQUEST_URI']), ['category.php', 'brand.php', 'medicine.php'])) ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo (in_array(basename($_SERVER['REQUEST_URI']), ['category.php', 'brand.php', 'medicine.php'])) ? 'active' : ''; ?>">
                  <i class="nav-icon fas fa-boxes"></i>
                  <p>
                  Inventory
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="../adminpage/category.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'category.php') ? 'active' : ''; ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Category</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../adminpage/brand.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'brand.php') ? 'active' : ''; ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Brand</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="../adminpage/medicine.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'medicine.php') ? 'active' : ''; ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Medicine</p>
                      </a>
                  </li>
              </ul>
          </li>
          <?php endif; ?>


          <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item">
            <a href="../adminpage/payment_record.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'payment_record.php') ? 'active' : ''; ?>" class="nav-link">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>Payment Record</p>
            </a>
            </a>
          </li>
          <?php endif; ?>

          <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item">
          <a href="../adminpage/users.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'users.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user"></i>
                <p>Users</p>
            </a>
            </a>
          </li>
          <?php endif; ?>

          <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item">
          <a href="../adminpage/chat_bot.php" class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'chat_bot.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-comments"></i>
                <p>ChatBot</p>
            </a>
            </a>
          </li>
          <?php endif; ?>

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>