<?php

include('../custom/functions.php');

header('Content-Type: application/json');
header('Access-Controll-Allowed-Methode: GET');

// to test the method

$method = $_SERVER["REQUEST_METHOD"];

if($method == "GET"){
    $list = getList();
    echo $list;
}else{
    $response = [
        'status' => 405,
        'message' => $method. 'method not allowed',
    ];
    header("HTTP/1.0 405 Method not allowed");
    echo json_encode($response);
}


?>