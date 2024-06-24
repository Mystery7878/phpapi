<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once "./db-connect.php";


if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['id'])){
        //Sanitize get request
        $GET = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = $GET['id'];
        // Fetch a single product
        $sql = 'SELECT * FROM products WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if an product was found
        if ($product) {
            // Output the product as JSON
            echo json_encode($product);
        } else {
            echo 'product not found.';
        }
    }else{
        // Fetch all products
        $sql = 'SELECT * FROM products';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any product were found
        if ($products) {
            // Output the product as JSON
            echo json_encode($products);
        } else {
            echo 'No product found.';
        }
    }
}else{
    echo 'Method not allowed.';
}



?>