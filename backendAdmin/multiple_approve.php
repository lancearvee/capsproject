<?php
require '../userLogin/db_con.php';  
require '../mail/approved_appointment.php';    
require '../vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require '../config/smtp_config.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointments = json_decode(file_get_contents('php://input'), true);
    
    foreach ($appointments as $appointment) {
        $id = $appointment['id'];
        $email = $appointment['email'];
        $given_name = $appointment['given_name'];
        $date = $appointment['date'];         
        $location = $appointment['location'];  
        $time_from = $appointment['time_from'];  
        $time_to = $appointment['time_to'];  

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

        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Appointments approved and emails sent']);
    exit;
}
?>

