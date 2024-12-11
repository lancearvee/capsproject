<?php
// Include the database connection file
include '../userLogin?db_con.php';

if (isset($_GET['payment_from']) && isset($_GET['payment_to'])) {
    $from = $_GET['payment_from'];
    $to = $_GET['payment_to'];

    // Log for debugging
    error_log("Fetching payments from $from to $to");

    $query = $conn->prepare("SELECT * FROM paymentrecord WHERE payment_date BETWEEN ? AND ?");
    $query->bind_param("ss", $from, $to);
    $query->execute();
    $result = $query->get_result();

    $payments = [];
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }

    // Log the results
    error_log("Payments fetched: " . json_encode($payments));

    echo json_encode($payments);
}

?>
