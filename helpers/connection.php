<?php


$host ="localhost";
$user = "root";
$pass = "";
$db = "reactEcom"; 
$sport = "3306"; // Port number for MySQL, default is 3306
// Create a connection to the MySQL database

// try {
//     $conn = new mysqli($host, $user, $pass, $db, $sport);
// } catch (Exception $e) {
//     echo "Connection Failed: " . $e->getMessage();
//     die();
// }
// Alternative method using mysqli_connect

$conn = mysqli_connect($host, $user, $pass, $db, $sport);

if (!$conn) {
    echo "Connection Failed";
    die();
}


