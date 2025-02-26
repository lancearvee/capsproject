<?php
require '../userLogin/db_con.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        $query = "DELETE FROM medicine WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                    sessionStorage.setItem('successMessage', 'Deleted!');
                    window.location.href = '../adminpage/medicine.php'; // Or your page URL
                  </script>";
            exit;
        } else {
            echo "Error deleting user.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "User ID not provided.";
}
?>
