<?php
require '../userLogin/db_con.php';

$response = [
    'brand_error' => '',
];

if (isset($_POST['brand_name'])) {
    $brand_name = $_POST['brand_name'];
    $stmt = $pdo->prepare("SELECT * FROM brand WHERE brand_name = :brand_name");
    $stmt->execute(['brand_name' => $brand_name]);
    if ($stmt->rowCount() > 0) {
        $response['brand_error'] = 'Brand name exists.';
    }
}

echo json_encode($response);
?>
