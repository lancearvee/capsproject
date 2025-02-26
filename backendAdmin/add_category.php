<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['category_name']) && !empty($_POST['category_name'])) {
        $categoryName = trim($_POST['category_name']); 

        $sql = "INSERT INTO category (category_name) VALUES (:category_name)";

        try {
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['success'] = "Category Added!";
                echo "<script>sessionStorage.setItem('successMessage', 'Category Added!'); window.location.href = '../adminpage/category.php';</script>";
                exit;
            } else {
                echo "Error: Could not add category.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Category name is required.";
    }
}
?>
