<?php
// Include Composer's autoload file
require '../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_auth' => true,
    'smtp_username' => 'lancearveealgire@gmail.com',    // Replace with your Gmail email
    'smtp_password' => 'rfedvgoxqbcwquaj',      // Replace with your Gmail app password
    'smtp_secure' => PHPMailer::ENCRYPTION_STARTTLS,
    'smtp_port' => 587,
    'from_email' => 'lancearveealgire@gmail.com',      // Replace with your Gmail email
    'from_name' => 'Thyroid Health and Wellness Center',
];
