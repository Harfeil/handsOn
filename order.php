<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Products</title>
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

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .add-button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-button {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 6px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div id="container">
    <h2 style="text-align: center;">Order List</h2>

<?php
include 'includes/db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $sql = "SELECT orderTable.order_id as order_id, users.name as user_name, products.product_name as product_name, orderTable.date as order_date FROM orderTable INNER JOIN users ON orderTable.user_id = users.id INNER JOIN products ON orderTable.prod_id = products.product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Date</th>
                </tr>";
        foreach ($result as $row) {
            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['user_name']}</td>
                    <td>{$row['product_name']}</td>
                    <td>{$row['order_date']}</td>
                </tr>";
        }
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if ($conn) {
        $conn = null;
    }
}
?>

<div class="button-container">
    <a href="product.php" class="add-button">Add Order</a>
</div>

</div>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            let orderBtn = document.querySelectorAll('.order-button');
           let editBtn = document.querySelectorAll('.edit-button');

           editBtn.forEach(function(row) {
                row.addEventListener('click', function() {
                    let id = this.getAttribute('data-productId');
                    window.location.href = "edit_product.php?edit_product_id="+id;
                });
            });
            orderBtn.forEach(function(row) {
                row.addEventListener('click', function() {
                    let id = this.getAttribute('data-productId');
                    let name = this.getAttribute('data-productName');
                    window.location.href = "add_order.php?product_id="+id+"&product_name="+name;
                });
            });

            
        });
</script>
</body>
</html>
