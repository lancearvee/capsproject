<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

        do {
            $patient_id = str_pad(mt_rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            $stmt = $pdo->prepare("SELECT id FROM users WHERE patient_id = ?");
            $stmt->execute([$patient_id]);
        } while ($stmt->fetch());

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, patient_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $patient_id]);
        $user_id = $pdo->lastInsertId();

        $family_name = $_POST['family_name'];
        $middle_name = $_POST['middle_name'];
        $given_name = $_POST['given_name'];
        $suffix = $_POST['suffix'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $province = $_POST['province'];
        $municipality = $_POST['municipality'];
        $barangay = $_POST['barangay'];
        $contact_number = $_POST['contact_number'];
        $postal_code = $_POST['postal_code'];
        $allergies = $_POST['allergies'];
        $heart_disease = $_POST['heart_disease'];
        $any_accident = $_POST['any_accident'];
        $cond_med = $_POST['cond_med'];
        $any_surgery = $_POST['any_surgery'];
        $medical_history = $_POST['medical_history'];
        $email = $email;

        $contact_number = '+63' . ltrim($contact_number, '0');

        $stmt = $pdo->prepare("INSERT INTO patient_data (user_id, patient_id, family_name, middle_name, given_name, suffix, date_of_birth, gender, province, municipality, barangay, contact_number, postal_code, allergies, heart_disease, any_accident, cond_med, any_surgery, medical_history, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $patient_id, $family_name, $middle_name, $given_name, $suffix, $date_of_birth, $gender, $province, $municipality, $barangay, $contact_number, $postal_code, $allergies, $heart_disease, $any_accident, $cond_med, $any_surgery, $medical_history, $email]);

        session_start();
        $_SESSION['success'] = "Success";
        echo "<script>sessionStorage.setItem('successMessage', 'Success'); window.location.href = '../adminpage/patient.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    die("Invalid request.");
}
?>
