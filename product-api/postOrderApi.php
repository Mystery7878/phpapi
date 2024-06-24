<?php
header("Access-Control-Allow-Origin:*");
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

//include database connection
include_once "./db-connect.php";
if ($_SERVER['REQUEST_METHOD']==='POST'){
    // our json data is sent in our request body
    $data = json_decode(file_get_contents("php://input"), false);

    $query = 'SELECT * from orders where product_id = :product_id';
    $fetch_stmt = $pdo->prepare($query);
    $fetch_stmt->bindparam(":product_id",$data->productId);
    $fetch_stmt->execute();
    if($fetch_stmt->rowCount() > 0){
        $query = 'UPDATE orders SET quantity = quantity + 1, total_cost = (quantity) * :price WHERE product_id = :product_id';
        $upd_stmt = $pdo->prepare($query);
        $upd_stmt->bindparam(":price", $data->price); 
        $upd_stmt->bindparam(":product_id", $data->productId); 
        $upd_stmt->execute();
    }else{
        $sql = 'INSERT INTO orders (product_id, quantity, total_cost) VALUES (:productId, 1, :totalCost)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindparam(":productId",$data->productId);
        $stmt->bindparam(":totalCost",$data->price);
        $stmt->execute();
    
        if($stmt->rowCount() > 0){
            echo "Successfully added product";
        }else{
            echo "Failed to add product";
        }
    }


}

?>