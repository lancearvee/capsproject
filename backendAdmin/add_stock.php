<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'] ?? null;
    $quantity_times = $_POST['quantity_times'] ?? null; 
    $qty_pack = $_POST['qty_pack'];
    $stock_qty = $_POST['stock_qty'];

    if (empty($quantity_times) && !empty($quantity)) {
        $new_stock_qty = $stock_qty + $quantity;
    } elseif (empty($quantity) && !empty($quantity_times)) {
        $new_stock_qty = $stock_qty + ($quantity_times * $qty_pack);
    } else {
        echo "Please provide either quantity_times or quantity.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE medicine SET stock_qty = :new_stock_qty WHERE id = :id");
        $stmt->execute([
            ':new_stock_qty' => $new_stock_qty,
            ':id' => $id
        ]);
        session_start();
        $_SESSION['success'] = "Success!";
        echo "<script>sessionStorage.setItem('successMessage', 'Success!'); window.location.href = '../adminpage/medicine.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error updating stock: " . $e->getMessage();
    }
}
?>
