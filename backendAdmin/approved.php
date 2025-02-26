<?php
require '../userLogin/db_con.php';  
require '../mail/approved_appointment.php';    
require '../vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require '../config/smtp_config.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $given_name = $_POST['given_name'];
    $date = $_POST['date'];         
    $location = $_POST['location'];  
    $time_from = $_POST['time_from'];  
    $time_to = $_POST['time_to'];  
    
    try {
        $query = "UPDATE appointments SET status = 'Approved' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        $formattedDate = date('F j, Y', strtotime($date));  

        $formattedTime_time_from = date('g:i A', strtotime($time_from)); 
        $formattedTime_time_to = date('g:i A', strtotime($time_to)); 

        $appointmentDetails = [
            'date' => $formattedDate,
            'time_from' => $formattedTime_time_from,
            'time_to' => $formattedTime_time_to,
            'location' => $location,
        ];

        ob_start();
        include('../mail/approved_appointment.php');  
        $message = ob_get_clean();  

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = $config['smtp_auth'];
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];

        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($email, $given_name);

        $mail->isHTML(true);
        $mail->Subject = 'Appointment Approved';
        $mail->Body = $message;

        $mail->send();
        session_start();
        $_SESSION['success'] = "Approved and email sent!";
        echo "<script>sessionStorage.setItem('successMessage', 'Approved and email sent!'); window.location.href = '../adminpage/pending.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "Status updated, but email could not be sent. Error: {$mail->ErrorInfo}";
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
