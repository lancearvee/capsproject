<?php
require '../userLogin/db_con.php';

$response = [
    'categoryName_error' => '',
];

if (isset($_POST['category_name'])) {
    $category_name = $_POST['category_name'];
    $stmt = $pdo->prepare("SELECT * FROM category WHERE category_name = :category_name");
    $stmt->execute(['category_name' => $category_name]);
    if ($stmt->rowCount() > 0) {
        $response['categoryName_error'] = 'Category name exists.';
    }
}

echo json_encode($response);
?>
