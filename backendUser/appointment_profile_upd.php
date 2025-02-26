<?php
require '../userLogin/db_con.php'; 
session_start();

include('../userpage/locations.php');

$user_id = $_SESSION['user_id'];

$sqlPatientId = "SELECT patient_id FROM users WHERE id = :user_id";
$stmtPatientId = $pdo->prepare($sqlPatientId);
$stmtPatientId->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmtPatientId->execute();
$patientData = $stmtPatientId->fetch();

if ($patientData) {
    $patient_id = $patientData['patient_id'];
} else {
    $patient_id = null; // or handle if the patient_id is not found
}

$sql = "SELECT * FROM patient_data WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$userData = $stmt->fetch();

if (!$userData) {
    $userData = [
        'family_name' => '',
        'given_name' => '',
        'middle_name' => '',
        'suffix' => '',
        'date_of_birth' => '',
        'province' => '',
        'municipality' => '',
        'barangay' => '',
        'contact_number' => '',
        'email' => '',
        'postal_code' => '',
        'medical_history' => '',
        'heart_disease' => '',
        'any_accident' => '',
        'any_surgery' => '',
        'allergies' => '',
        'cond_med' => '',
        'patient_id' => $patient_id,
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $family_name = $_POST['family_name'];
    $given_name = $_POST['given_name'];
    $middle_name = $_POST['middle_name'];
    $suffix = $_POST['suffix'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $postal_code = $_POST['postal_code'];
    $medical_history = $_POST['medical_history'];
    $heart_disease = $_POST['heart_disease'];
    $any_accident = $_POST['any_accident'];
    $any_surgery = $_POST['any_surgery'];
    $allergies = $_POST['allergies'];
    $cond_med = $_POST['cond_med'];

    try {
        $checkSql = "SELECT COUNT(*) FROM patient_data WHERE user_id = :user_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $checkStmt->execute();
        $exists = $checkStmt->fetchColumn();

        if ($exists) {
            $updateFields = [
                "family_name = :family_name",
                "given_name = :given_name",
                "middle_name = :middle_name",
                "suffix = :suffix",
                "date_of_birth = :date_of_birth",
                "gender = :gender",
                "contact_number = :contact_number",
                "email = :email",
                "postal_code = :postal_code",
                "medical_history = :medical_history",
                "heart_disease = :heart_disease",
                "any_accident = :any_accident",
                "any_surgery = :any_surgery",
                "allergies = :allergies",
                "cond_med = :cond_med",
                "patient_id = :patient_id"
            ];

            if (!empty($province)) {
                $updateFields[] = "province = :province";
            }
            if (!empty($municipality)) {
                $updateFields[] = "municipality = :municipality";
            }
            if (!empty($barangay)) {
                $updateFields[] = "barangay = :barangay";
            }

            $updateSql = "UPDATE patient_data SET " . implode(', ', $updateFields) . " WHERE user_id = :user_id";
            $stmt = $pdo->prepare($updateSql);

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':family_name', $family_name, PDO::PARAM_STR);
            $stmt->bindParam(':given_name', $given_name, PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
            $stmt->bindParam(':medical_history', $medical_history, PDO::PARAM_STR);
            $stmt->bindParam(':heart_disease', $heart_disease, PDO::PARAM_STR);
            $stmt->bindParam(':any_accident', $any_accident, PDO::PARAM_STR);
            $stmt->bindParam(':any_surgery', $any_surgery, PDO::PARAM_STR);
            $stmt->bindParam(':allergies', $allergies, PDO::PARAM_STR);
            $stmt->bindParam(':cond_med', $cond_med, PDO::PARAM_STR);
            $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);

            if (!empty($province)) {
                $stmt->bindParam(':province', $province, PDO::PARAM_INT);
            }
            if (!empty($municipality)) {
                $stmt->bindParam(':municipality', $municipality, PDO::PARAM_INT);
            }
            if (!empty($barangay)) {
                $stmt->bindParam(':barangay', $barangay, PDO::PARAM_INT);
            }
        } else {
            $insertSql = "INSERT INTO patient_data (
                            user_id, family_name, given_name, middle_name, suffix, 
                            date_of_birth, gender, province, municipality, barangay, 
                            contact_number, email, postal_code, medical_history,
                            heart_disease, any_accident,
                            any_surgery, allergies, cond_med, patient_id
                          ) VALUES (
                            :user_id, :family_name, :given_name, :middle_name, :suffix, 
                            :date_of_birth, :gender, :province, :municipality, :barangay, 
                            :contact_number, :email, :postal_code, :medical_history,
                            :heart_disease, :any_accident,
                            :any_surgery, :allergies, :cond_med, :patient_id
                          )";
            $stmt = $pdo->prepare($insertSql);

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':family_name', $family_name, PDO::PARAM_STR);
            $stmt->bindParam(':given_name', $given_name, PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':suffix', $suffix, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':province', $province, PDO::PARAM_INT);
            $stmt->bindParam(':municipality', $municipality, PDO::PARAM_INT);
            $stmt->bindParam(':barangay', $barangay, PDO::PARAM_INT);
            $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
            $stmt->bindParam(':medical_history', $medical_history, PDO::PARAM_STR);
            $stmt->bindParam(':heart_disease', $heart_disease, PDO::PARAM_STR);
            $stmt->bindParam(':any_accident', $any_accident, PDO::PARAM_STR);
            $stmt->bindParam(':any_surgery', $any_surgery, PDO::PARAM_STR);
            $stmt->bindParam(':allergies', $allergies, PDO::PARAM_STR);
            $stmt->bindParam(':cond_med', $cond_med, PDO::PARAM_STR);
            $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        }
        $stmt->execute();

        header('Location: ../userpage/appointment.php'); 
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
