<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'] ?? null;
    $middlename = $_POST['middlename'] ?? null;
    $lastname = $_POST['lastname'] ?? null;
    $suffix = $_POST['suffix'] ?? null;
    $sex = $_POST['sex'] ?? null;
    $province = $_POST['province'] ?? null;
    $municipality = $_POST['municipality'] ?? null;
    $barangay = $_POST['barangay'] ?? null;
    $civil_status = $_POST['civil_status'] ?? null;
    $position = $_POST['position'] ?? null;
    $email = $_POST['email'] ?? null;
    $contact_no = $_POST['contact_no'] ?? null;

    if (empty($firstname) || empty($lastname) || empty($sex) || empty($email)) {
        die("Required fields are missing.");
    }

    $sql = "INSERT INTO staff 
            (firstname, middlename, lastname, suffix, sex, province, municipality, barangay, civil_status, position, email, contact_no) 
            VALUES 
            (:firstname, :middlename, :lastname, :suffix, :sex, :province, :municipality, :barangay, :civil_status, :position, :email, :contact_no)";

    try {
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':suffix', $suffix);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':municipality', $municipality);
        $stmt->bindParam(':barangay', $barangay);
        $stmt->bindParam(':civil_status', $civil_status);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact_no', $contact_no);

        $stmt->execute();

        session_start();
        $_SESSION['success'] = "Staff Added!";
        echo "<script>sessionStorage.setItem('successMessage', 'Staff Added!'); window.location.href = '../adminpage/staff.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
