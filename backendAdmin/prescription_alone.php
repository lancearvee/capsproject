<?php
require '../userLogin/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicineTotal = 0;

    try {
        $pdo->beginTransaction();

        $getLastWalkInId = $pdo->query("SELECT MAX(walkIn_id) AS last_id FROM prescription");
        $lastId = $getLastWalkInId->fetch(PDO::FETCH_ASSOC)['last_id'] ?? 0;
        $walkInId = $lastId + 1;

        if (isset($_POST['medicines']) && is_array(json_decode($_POST['medicines']))) {
            $medicines = json_decode($_POST['medicines'], true); 

            $insertPrescription = $pdo->prepare("
                INSERT INTO prescription (
                    walkIn_id,
                    brand_name,
                    medicine_name,
                    dosage,
                    gram,
                    price_unit,
                    quantity
                ) VALUES (
                    :walkIn_id,
                    :brand_name,
                    :medicine_name,
                    :dosage,
                    :gram,
                    :price_unit,
                    :quantity
                )
            ");

            foreach ($medicines as $medicine) {
                $insertPrescription->execute([
                    ':walkIn_id' => $walkInId,
                    ':brand_name' => $medicine['brand_name'],
                    ':medicine_name' => $medicine['medicine_name'],
                    ':dosage' => $medicine['dosage'],
                    ':gram' => $medicine['gram'],
                    ':price_unit' => $medicine['price_unit'],
                    ':quantity' => $medicine['quantity']
                ]);
                
                $updateStockQty = $pdo->prepare("
                    UPDATE medicine
                    SET stock_qty = stock_qty - :quantity
                    WHERE id = :id
                ");
                $updateStockQty->execute([
                    ':id' => $medicine['id'],
                    ':quantity' => $medicine['quantity']
                ]);

                $medicineTotal += $medicine['price_unit'] * $medicine['quantity'];
            }
        }

        $pdo->commit();

        header("Location: ../adminpage/payment_alone.php?walkIn_id=$walkInId&bill_amount=$medicineTotal");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "An error occurred: " . $e->getMessage();
    }
}

?>
