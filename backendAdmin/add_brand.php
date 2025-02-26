<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat_fk_id = $_POST['category_name'];  
    $supplier = $_POST['supplier']; 
    $brand_name = $_POST['brand_name'];  

    try {
        $stmt = $pdo->prepare("
            SELECT category_name FROM category WHERE id = :cat_fk_id
        ");
        $stmt->execute([':cat_fk_id' => $cat_fk_id]);
        $category = $stmt->fetch();

        if ($category) {
            $category_name = $category['category_name'];

            $insertStmt = $pdo->prepare("
                INSERT INTO brand (cat_fk_id, category_name, supplier, brand_name) 
                VALUES (:cat_fk_id, :category_name, :supplier, :brand_name)
            ");
            $insertStmt->execute([
                ':cat_fk_id' => $cat_fk_id,
                ':category_name' => $category_name, 
                ':supplier' => $supplier,
                ':brand_name' => $brand_name
            ]);

            session_start();
            $_SESSION['success'] = "Brand Added!";
            echo "<script>sessionStorage.setItem('successMessage', 'Brand Added!'); window.location.href = '../adminpage/brand.php';</script>";
            exit;
        } else {
            echo "Category not found for the given ID.";
        }
    } catch (PDOException $e) {
        echo "Error inserting category: " . $e->getMessage();
    }
}
?>
