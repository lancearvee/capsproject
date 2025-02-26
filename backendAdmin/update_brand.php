<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $category_id = $_POST['category_name']; 
    $brand_name = $_POST['brand_name'];
    $supplier = $_POST['supplier'];

    try {
        $stmt = $pdo->prepare("SELECT category_name FROM category WHERE id = :category_id");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch();

        if ($category) {
            $category_name = $category['category_name'];

            $updateStmt = $pdo->prepare("UPDATE brand SET cat_fk_id = :category_id, category_name = :category_name, brand_name = :brand_name, supplier = :supplier WHERE id = :id");
            $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $updateStmt->bindParam(':category_name', $category_name); 
            $updateStmt->bindParam(':brand_name', $brand_name);
            $updateStmt->bindParam(':supplier', $supplier);
            $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $updateStmt->execute();

            session_start();
            $_SESSION['success'] = "Updated!";
            echo "<script>sessionStorage.setItem('successMessage', 'Updated!'); window.location.href = '../adminpage/brand.php';</script>";
            exit;
        } else {
            echo "Category not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
