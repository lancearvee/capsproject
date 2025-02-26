<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_id = $_POST['id'];
    $brand_id = $_POST['brand_name'];  
    $medicine_name = $_POST['medicine_name'];
    $dosage = $_POST['dosage'];
    $gram = $_POST['gram'];
    $price_unit = $_POST['price_unit'];
    $expiry_date = $_POST['expiry_date'];
    $qty_pack = $_POST['qty_pack'];
    $regulatory_app_no = $_POST['regulatory_app_no'];

    $query = "SELECT brand_name FROM brand WHERE id = :brand_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':brand_id', $brand_id);
    $stmt->execute();
    $brand = $stmt->fetch();

    if ($brand) {
        $brand_name = $brand['brand_name'];

        $update_query = "UPDATE medicine SET
                            brand_fk_id = :brand_id,
                            brand_name = :brand_name,
                            medicine_name = :medicine_name,
                            dosage = :dosage,
                            gram = :gram,
                            price_unit = :price_unit,
                            expiry_date = :expiry_date,
                            qty_pack = :qty_pack,
                            regulatory_app_no = :regulatory_app_no
                        WHERE id = :medicine_id";

        $stmt = $pdo->prepare($update_query);
        $stmt->bindParam(':brand_id', $brand_id);
        $stmt->bindParam(':brand_name', $brand_name);
        $stmt->bindParam(':medicine_name', $medicine_name);
        $stmt->bindParam(':dosage', $dosage);
        $stmt->bindParam(':gram', $gram);
        $stmt->bindParam(':price_unit', $price_unit);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':qty_pack', $qty_pack);
        $stmt->bindParam(':regulatory_app_no', $regulatory_app_no);
        $stmt->bindParam(':medicine_id', $medicine_id);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['success'] = "Success!";
            echo "<script>sessionStorage.setItem('successMessage', 'Success!'); window.location.href = '../adminpage/medicine.php';</script>";
            exit;
        } else {
            echo "Error updating medicine.";
        }
    } else {
        echo "Brand not found.";
    }
}
?>
