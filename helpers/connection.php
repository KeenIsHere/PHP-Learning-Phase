<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");

$host = "localhost";
$user = "root";
$pass = "";
$db = "react_ecom";
$port = 3306;

$con = mysqli_connect($host, $user, $pass, $db, $port);

if (!$con) {
    echo "Connection failed";
    die();
}
