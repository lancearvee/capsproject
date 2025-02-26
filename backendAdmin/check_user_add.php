<?php
require '../userLogin/db_con.php';

if (isset($_POST['field']) && isset($_POST['value'])) {
    $field = $_POST['field']; 
    $value = $_POST['value'];

    if (!in_array($field, ['name', 'email'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE $field = :value");
    $stmt->execute(['value' => $value]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        if ($field === 'name') {
            echo json_encode(['status' => 'exists', 'message' => 'Username already taken']);
        } else {
            echo json_encode(['status' => 'exists', 'message' => 'Email already taken']);
        }
    } else {
        echo json_encode(['status' => 'available', 'message' => '']);
    }
}
?>
