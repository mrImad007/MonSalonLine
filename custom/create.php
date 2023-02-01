<?php
include('../custom/functions.php');

header('Content-Type: application/json');
header('Access-Controll-Allowed-Methode: POST');
    // to test the method

    $method = $_SERVER["REQUEST_METHOD"];

    if($method == "POST"){
        $inserted = json_decode(file_get_contents("php://input"),true);

        if(empty($inserted)){
            $storedData = insertProducts($_POST);
        }else{
            $storedData = insertProducts($inserted);
        }
        echo $storedData;

    }else{
        $response = [
            'status' => 405,
            'message' => $method. ' Method is not allowed',
        ];
        header("HTTP/1.0 405 GET Method is not allowed");
        echo json_encode($response);
    }


?>/Applications/XAMPP/xamppfiles/htdocs/Api-project/custom/create.php