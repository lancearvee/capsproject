<?php
require '../userLogin/db_con.php';

if (isset($_GET['term'])) {
    $term = $_GET['term'] . '%';

    $query = "SELECT id, brand_name, medicine_name, dosage, gram, price_unit, 
                     DATE_FORMAT(expiry_date, '%M %d, %Y') AS expiry_date, stock_qty 
              FROM medicine 
              WHERE medicine_name LIKE :term";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':term', $term, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $formattedResults = [];
    foreach ($results as $row) {
        $expiryDate = new DateTime($row['expiry_date']);
        $currentDate = new DateTime();
        $expired = $expiryDate < $currentDate ? 'Expired' : '';

        $formattedResults[] = [
            'id' => $row['id'],
            'brand_name' => $row['brand_name'],
            'medicine_name' => $row['medicine_name'],
            'dosage' => $row['dosage'],
            'gram' => $row['gram'],
            'price_unit' => $row['price_unit'],
            'expiry_date' => $row['expiry_date'], 
            'expired' => $expired, // Add expired status
            'stock_qty' => $row['stock_qty'] 
        ];
    }


    echo json_encode($formattedResults);
}
?>
