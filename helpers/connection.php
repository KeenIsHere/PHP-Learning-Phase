<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "react_ecom";
$port = 3306;

$con=mysqli_connect($host, $user, $pass, $db, $port);

if(!$con){
    echo "Connection failed";
    die();
}
