<?php
session_start();
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $time_from = $_POST['time_from'] ?? null;
    $time_to = $_POST['time_to'] ?? null;
    $date = $_POST['date'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if ($time_from && $time_to && $date && $user_id) {
        try {
            $pdo->beginTransaction();

            $appointment_id = generateAppointmentId($pdo);

            $stmt = $pdo->prepare("SELECT patient_id FROM users WHERE id = :user_id");
            $stmt->execute([':user_id' => $user_id]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$patient) {
                throw new Exception('Patient ID not found.');
            }

            $patient_id = $patient['patient_id'];

            $stmt = $pdo->prepare("SELECT family_name, middle_name, given_name, suffix, date_of_birth, gender, province, municipality, barangay, contact_number, email, postal_code, medical_history, 
            heart_disease, any_accident, any_surgery, allergies, cond_med FROM patient_data WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $user_id]);
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user_info) {
                throw new Exception('User information not found.');
            }

            $insertStmt = $pdo->prepare("
                INSERT INTO appointments (appointment_id, patient_id, user_id, time_from, time_to, date, family_name, middle_name, given_name, suffix, date_of_birth, gender, province, municipality, barangay, contact_number, email,
                 postal_code, medical_history, heart_disease, any_accident, any_surgery, allergies, cond_med) 
                VALUES (:appointment_id, :patient_id, :user_id, :time_from, :time_to, :date, :family_name, :middle_name, :given_name, :suffix, :date_of_birth, :gender, :province, :municipality, :barangay, :contact_number, :email,
                 :postal_code, :medical_history, :heart_disease, :any_accident, :any_surgery, :allergies, :cond_med)
            ");
            $insertStmt->execute([
                ':appointment_id' => $appointment_id,
                ':patient_id' => $patient_id,
                ':user_id' => $user_id,
                ':time_from' => $time_from,
                ':time_to' => $time_to,
                ':date' => $date,
                ':family_name' => $user_info['family_name'],
                ':middle_name' => $user_info['middle_name'],
                ':given_name' => $user_info['given_name'],
                ':suffix' => $user_info['suffix'],
                ':date_of_birth' => $user_info['date_of_birth'],
                ':gender' => $user_info['gender'],
                ':province' => $user_info['province'],
                ':municipality' => $user_info['municipality'],
                ':barangay' => $user_info['barangay'],
                ':contact_number' => $user_info['contact_number'],
                ':email' => $user_info['email'],
                ':postal_code' => $user_info['postal_code'],
                ':medical_history' => $user_info['medical_history'],
                ':heart_disease' => $user_info['heart_disease'],
                ':any_accident' => $user_info['any_accident'],
                ':any_surgery' => $user_info['any_surgery'],
                ':allergies' => $user_info['allergies'],
                ':cond_med' => $user_info['cond_med'],
            ]);

            $updateStmt = $pdo->prepare("
                UPDATE time_slots 
                SET slots = slots - 1 
                WHERE time_from = :time_from 
                  AND time_to = :time_to 
                  AND date = :date 
                  AND slots > 0
            ");
            $updateStmt->execute([
                ':time_from' => $time_from,
                ':time_to' => $time_to,
                ':date' => $date,
            ]);

            if ($updateStmt->rowCount() === 0) {
                throw new Exception('No available slots to decrement.');
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input or user not logged in.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

function generateAppointmentId($pdo) {
    do {
        $appointment_id = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT) . 'a';

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_id = :appointment_id");
        $stmt->execute([':appointment_id' => $appointment_id]);
        $exists = $stmt->fetchColumn();
    } while ($exists > 0); 

    return $appointment_id;
}
?>
