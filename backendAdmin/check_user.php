<?php
require '../userLogin/db_con.php';

$response = [
    'name_error' => '',
    'email_error' => ''
];

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->execute(['name' => $name]);
    if ($stmt->rowCount() > 0) {
        $response['name_error'] = 'Username already exists.';
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        $response['email_error'] = 'Email already exists.';
    }
}

echo json_encode($response);
?>
