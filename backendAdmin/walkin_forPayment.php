<?php
require '../userLogin/db_con.php';
date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tLevel = $_POST['t_level']; 
    $user_id = $_POST['user_id']; 
    $patient_id = $_POST['patient_id']; 
    $medicineTotal = 0;
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    
    try {
        $pdo->beginTransaction();

        $walkIn_id = generateWalkInId($pdo);
        $insertAppointments = $pdo->prepare("
        INSERT INTO appointments (
            user_id,
            walkIn_id,
            family_name,
            middle_name,
            given_name,
            suffix,
            date_of_birth,
            gender,
            province,
            municipality,
            barangay,
            contact_number,
            email,
            postal_code,
            allergies,
            heart_disease,
            any_accident,
            cond_med,
            any_surgery,
            medical_history,
            status,
            patient_id,
            date_completed,
            date,
            time_to
        ) VALUES (
            :user_id,
            :walkIn_id,
            :family_name,
            :middle_name,
            :given_name,
            :suffix,
            :date_of_birth,
            :gender,
            :province,
            :municipality,
            :barangay,
            :contact_number,
            :email,
            :postal_code,
            :allergies,
            :heart_disease,
            :any_accident,
            :cond_med,
            :any_surgery,
            :medical_history,
            :status,
            :patient_id,
            :date_completed,
            :date,
            :time_to
        )
        ");

        $insertAppointments->execute([
        ':walkIn_id' => $walkIn_id,
        ':user_id' => $_POST['user_id'],
        ':family_name' => $_POST['family_name'],
        ':middle_name' => $_POST['middle_name'],
        ':given_name' => $_POST['given_name'],
        ':suffix' => $_POST['suffix'],
        ':date_of_birth' => $_POST['date_of_birth'],
        ':gender' => $_POST['gender'],
        ':province' => $_POST['province'],
        ':municipality' => $_POST['municipality'],
        ':barangay' => $_POST['barangay'],
        ':contact_number' => $_POST['contact_number'],
        ':email' => $_POST['email'],
        ':postal_code' => $_POST['postal_code'],
        ':allergies' => $_POST['allergies'],
        ':heart_disease' => $_POST['heart_disease'],
        ':any_accident' => $_POST['any_accident'],
        ':cond_med' => $_POST['cond_med'],
        ':any_surgery' => $_POST['any_surgery'],
        ':medical_history' => $_POST['medical_history'],
        ':patient_id' => $_POST['patient_id'],
        ':status' => 'Completed',
        ':date_completed' => date('Y-m-d'),
        ':date' => $currentDate,
        ':time_to' => $currentTime
        ]);

        // Get the inserted appointment ID
        $appointmentId = $pdo->lastInsertId();

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = '../results_images/'; 
            $imageFileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '.' . $imageFileType;
            $targetFilePath = $targetDir . $uniqueFileName;
        
            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imageFileName = $uniqueFileName; // Store only the filename in DB
            } else {
                $imageFileName = null; // Handle error if needed
            }
        } else {
            $imageFileName = null; // No file uploaded
        }

        $insertCheckLab = $pdo->prepare("
            INSERT INTO check_lab (
                appointment_fk_id,
                user_id,
                heart_pulse,
                tendency_bleed,
                diabetic,
                oxg_saturation,
                symptoms,
                temp,
                height,
                blood_pressure,
                weight,
                sugar_rate,
                family_med_history,
                respiratory_rate,
                tsh_level,
                known_thyroid_conditions,
                thyroid_cond_desc,
                current_thy_med,
                t_level,
                date_check,
                image
            ) VALUES (
                :appointment_fk_id,
                :user_id,
                :heart_pulse,
                :tendency_bleed,
                :diabetic,
                :oxg_saturation,
                :symptoms,
                :temp,
                :height,
                :blood_pressure,
                :weight,
                :sugar_rate,
                :family_med_history,
                :respiratory_rate,
                :tsh_level,
                :known_thyroid_conditions,
                :thyroid_cond_desc,
                :current_thy_med,
                :t_level,
                :date_check,
                :image
            )
        ");
        $insertCheckLab->execute([
            ':appointment_fk_id' => $appointmentId,
            ':user_id' => $_POST['user_id'],
            ':heart_pulse' => $_POST['heart_pulse'],
            ':tendency_bleed' => $_POST['tendency_bleed'],
            ':diabetic' => $_POST['diabetic'],
            ':oxg_saturation' => $_POST['oxg_saturation'],
            ':symptoms' => $_POST['symptoms'],
            ':temp' => $_POST['temp'],
            ':height' => $_POST['height'],
            ':blood_pressure' => $_POST['blood_pressure'],
            ':weight' => $_POST['weight'],
            ':sugar_rate' => $_POST['sugar_rate'],
            ':family_med_history' => $_POST['family_med_history'],
            ':respiratory_rate' => $_POST['respiratory_rate'],
            ':tsh_level' => $_POST['tsh_level'],
            ':known_thyroid_conditions' => $_POST['known_thyroid_conditions'],
            ':thyroid_cond_desc' => $_POST['thyroid_cond_desc'],
            ':current_thy_med' => $_POST['current_thy_med'],
            ':t_level' => $_POST['t_level'],
            ':date_check' => date('Y-m-d'),
            ':image' => $imageFileName // Store only the filename
        ]);
        

        if (isset($_POST['medicines']) && is_array(json_decode($_POST['medicines']))) {
            $medicines = json_decode($_POST['medicines'], true); 

            $insertPrescription = $pdo->prepare("
                INSERT INTO prescription (
                    appointment_fk_id,
                    brand_name,
                    medicine_name,
                    dosage,
                    gram,
                    price_unit,
                    quantity
                ) VALUES (
                    :appointment_fk_id,
                    :brand_name,
                    :medicine_name,
                    :dosage,
                    :gram,
                    :price_unit,
                    :quantity
                )
            ");

            foreach ($medicines as $medicine) {
                $insertPrescription->execute([
                    ':appointment_fk_id' => $appointmentId,
                    ':brand_name' => $medicine['brand_name'],
                    ':medicine_name' => $medicine['medicine_name'],
                    ':dosage' => $medicine['dosage'],
                    ':gram' => $medicine['gram'],
                    ':price_unit' => $medicine['price_unit'],
                    ':quantity' => $medicine['quantity']
                ]);
                
                $updateStockQty = $pdo->prepare("
                    UPDATE medicine
                    SET stock_qty = stock_qty - :quantity
                    WHERE id = :id
                ");
                $updateStockQty->execute([
                    ':id' => $medicine['id'],
                    ':quantity' => $medicine['quantity']
                ]);

                $medicineTotal += $medicine['price_unit'] * $medicine['quantity'];
            }
        }

        $pdo->commit();
        header("Location: ../adminpage/payment.php?t_level=$tLevel&bill_amount=$medicineTotal&appointment_id=$appointmentId&family_name=" 
        . urlencode($_POST['family_name']) . "&middle_name=" . urlencode($_POST['middle_name']) . "&given_name=" 
        . urlencode($_POST['given_name']) . "&suffix=" . urlencode($_POST['suffix']) . "&province=" . urlencode($_POST['province']) 
        . "&municipality=" . urlencode($_POST['municipality']) . "&barangay=" . urlencode($_POST['barangay']) . "&contact_number=" 
        . urlencode($_POST['contact_number']) . "&user_id=" . urlencode($user_id) . "&patient_id=" . urlencode($patient_id)
        . "&walkIn_id=" . urlencode($walkIn_id));
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "An error occurred: " . $e->getMessage();
    }
}

function generateWalkInId($pdo) {
    do {
        // Generate a 6-digit number
        $number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        // Append 'w' to the number
        $walkIn_id = $number . 'w';
        
        // Check if the walkIn_id already exists in the database
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE walkIn_id = :walkIn_id");
        $stmt->execute([':walkIn_id' => $walkIn_id]);
        $count = $stmt->fetchColumn();
    } while ($count > 0); // Repeat if the walkIn_id already exists

    return $walkIn_id;
}
?>
