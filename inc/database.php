<?php

$host = 'mysql:host=localhost; dbname=api';
$root = 'root';
$password = '';

$base = new PDO($host,$root,$password);
$base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
// database connected

if(!$base){
    die("There's an error, connection failed");
}

?>