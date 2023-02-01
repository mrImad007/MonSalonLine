<?php
include('../inc/database.php');


function getList(){
    global $base;

    $query = "SELECT * FROM `products` ";
    $exe = $base->prepare($query);
    $exe->execute();

    $count = $exe->rowCount();
    
    if(!$exe){

        $response = [
            'status' => 500,
            'message' => 'No products found',
        ];

        header("HTTP/1.0 500 No products found");
        return json_encode($response);
    }else{
        if($count>0){

            $result = $exe->fetchAll(PDO::FETCH_ASSOC);

            $response = [
                'status' => 200,
                'message' => 'List fetched successfully',
                'data' => $result,
            ];
    
            header("HTTP/1.0 200 List fetched successfully");
            return json_encode($response);
        }else{
            $response = [
                'status' => 404,
                'message' => 'No products found',
            ];
    
            header("HTTP/1.0 404 No products found");
            return json_encode($response);
        }
    }
}

// eroor message
function error422($message){

    $response = [
        'status' => 422,
        'message' => $message,
    ];

    header("HTTP/1.0 500 Unprocessable entity");
    return json_encode($response);
    exit();
}

// insert function
function insertProducts($inserted){
    global $base;
    
    $name = $base->quote($inserted['name']);
    $price = $base->quote($inserted['price']);
    $category = $base->quote($inserted['category']);

    if(empty(trim($name))){
        return error422('you need to enter the product name');
    }elseif(empty(trim($price))){
        return error422('you need to enter the product price');
    }elseif(empty(trim($category))){
        return error422('you need to enter the product category');
    }else{
        $query = "INSERT INTO `products` (`id`, `Pimage`, `Pname`, `Pprice`, `Pcategory`) VALUES (NULL, NULL, '$name', '$price', '$category')";
        $exe = $base->prepare($query);
        $exe->execute();

        if($exe){
            $response = [
                'status' => 200,
                'message' => 'Product inserted successfully',
            ];
    
            header("HTTP/1.0 200 Product inserted successfully");
            return json_encode($response);

        }else{

            $response = [
                'status' => 500,
                'message' => 'No products found',
            ];
    
            header("HTTP/1.0 500 No products found");
            return json_encode($response);
        }
    }
}
?>