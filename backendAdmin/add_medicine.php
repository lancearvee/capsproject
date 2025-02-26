<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_id = $_POST['brand_name'];
    $medicine_name = $_POST['medicine_name'];
    $dosage = $_POST['dosage'];
    $gram = $_POST['gram'];
    $price_unit = $_POST['price_unit'];
    $expiry_date = $_POST['expiry_date'];
    $qty_pack = $_POST['qty_pack'];
    $regulatory_app_no = $_POST['regulatory_app_no'];

    try {
        $stmt = $pdo->prepare("SELECT brand_name FROM brand WHERE id = :id");
        $stmt->execute(['id' => $brand_id]);
        $brand = $stmt->fetch();

        if ($brand) {
            $brand_name = $brand['brand_name'];

            $insertStmt = $pdo->prepare("
                INSERT INTO medicine 
                (brand_fk_id, brand_name, medicine_name, dosage, gram, price_unit, expiry_date, qty_pack, regulatory_app_no)
                VALUES 
                (:brand_fk_id, :brand_name, :medicine_name, :dosage, :gram, :price_unit, :expiry_date, :qty_pack, :regulatory_app_no)
            ");
            $insertStmt->execute([
                'brand_fk_id' => $brand_id,
                'brand_name' => $brand_name,
                'medicine_name' => $medicine_name,
                'dosage' => $dosage,
                'gram' => $gram,
                'price_unit' => $price_unit,
                'expiry_date' => $expiry_date,
                'qty_pack' => $qty_pack,
                'regulatory_app_no' => $regulatory_app_no,
            ]);

            session_start();
            $_SESSION['success'] = "Added!";
            echo "<script>sessionStorage.setItem('successMessage', 'Added!'); window.location.href = '../adminpage/medicine.php';</script>";
            exit;
        } else {
            echo "Brand not found!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
