<?php
require '../userLogin/db_con.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffix = $_POST['suffix'];
    $sex = $_POST['sex'];
    $province = $_POST['province'] ?: null; 
    $municipality = $_POST['municipality'] ?: null;
    $barangay = $_POST['barangay'] ?: null;
    $civil_status = $_POST['civil_status'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];

    $sql = "UPDATE staff SET 
                firstname = :firstname, 
                middlename = :middlename, 
                lastname = :lastname, 
                suffix = :suffix, 
                sex = :sex, 
                civil_status = :civil_status, 
                position = :position, 
                email = :email, 
                contact_no = :contact_no";

    if ($province !== null) {
        $sql .= ", province = :province";
    }
    if ($municipality !== null) {
        $sql .= ", municipality = :municipality";
    }
    if ($barangay !== null) {
        $sql .= ", barangay = :barangay";
    }

    $sql .= " WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':suffix', $suffix);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':civil_status', $civil_status);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contact_no', $contact_no);

        if ($province !== null) {
            $stmt->bindParam(':province', $province);
        }
        if ($municipality !== null) {
            $stmt->bindParam(':municipality', $municipality);
        }
        if ($barangay !== null) {
            $stmt->bindParam(':barangay', $barangay);
        }

        $stmt->execute();

        session_start();
        $_SESSION['success'] = "Staff Edited!";
        echo "<script>sessionStorage.setItem('successMessage', 'Staff Edited!'); window.location.href = '../adminpage/staff.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
