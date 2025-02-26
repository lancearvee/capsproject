<?php
require '../userLogin/db_con.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        $query = "DELETE FROM staff WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                    sessionStorage.setItem('successMessage', 'Staff deleted successfully!');
                    window.location.href = '../adminpage/staff.php'; // Or your page URL
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
