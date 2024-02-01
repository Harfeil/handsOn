<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdId = $_POST['product_id'];
    $quant = $_POST['product_quant'];
    $user_id = $_POST['customer_name'];
    $currentDateTime = $_POST['orderDate'];

    try {
        // Use the function to get a PDO connection
        $conn = connectDB();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO orderTable (user_id, prod_id, quantity, date) VALUES (:userId, :prodId, :quant, :dateToday)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $user_id);
        $stmt->bindParam(':prodId', $pdId);
        $stmt->bindParam(':quant', $quant);
        $stmt->bindParam(':dateToday', $currentDateTime);
        $stmt->execute();

        // Redirect back to the user data page after successful insertion
        header("Location: ../order.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Always close the connection
        if ($conn) {
            $conn = null;
        }
    }
}
?>
