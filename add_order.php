<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 600px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        a {
            color: #4caf50;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        #customer_name{
            width: 600px;
            height:35px;
        }
    </style>
</head>
<body>

<?php
    include 'includes/db_connection.php';

    try {
        $name = $_GET["product_name"];
        $prodId = $_GET["product_id"];
        $conn = connectDB();

        $sqlReq = "SELECT id, name as user_name FROM users";
        $stmt = $conn->prepare($sqlReq);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

<div id="container">
    <h2 style="text-align: center;">Add Order</h2>

    <form action="includes/insert_order.php" method="post">
        <input type="text" name = "product_id" value = "<?php echo $prodId; ?>" hidden>
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" value = "<?php echo $name; ?>">

        <label for="product_stocks">Quantity:</label>
        <input type="number" name="product_quant" id="product_quant" value="<?php echo $userData['id']; ?>">

        <label for="customer_name">Customer Name:</label>
        <select name="customer_name" id="customer_name">
        <?php
                while ($userData) {
                    echo "<option value='" . $userData['id'] . "'>" . $userData['user_name'] . "</option>";
                    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                }
        ?>
        </select><br><br>
        <label for="date">Select Date</label>
        <input type="Date" name = "orderDate">

        <div class="button-container">
            <button type="submit">Add Order</button>
        </div>
    </form>

    <div class="button-container">
        <a href="product.php">Back to Product List</a>
    </div>
<?php
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        if ($conn) {
            $conn = null;
        }
    }
?>
</div>

</body>
</html>
