<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "./db-connect.php";


if($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Fetch all orders
        $sql = 'SELECT 
    orders.id AS order_id,
    orders.quantity,
    orders.total_cost,
    products.name AS product_name,
    products.price
FROM 
    orders
JOIN 
    products ON orders.product_id = products.id;
';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any order were found
        if ($orders) {
            // Output the order as JSON
            echo json_encode($orders);
        } else {
            echo json_encode([]);
        }
    } else{
    echo 'Method not allowed.';
}



?>