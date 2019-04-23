<?php 

$servername = "localhost:3306";
$username = "robiso";
$password = "rakmaccabi";
$dbname = "robiso_hatikva";



$conn = new mysqli($servername, $username, $password, $dbname);

mysqli_query($conn,"set character_set_client='utf8'");
mysqli_query($conn,"set character_set_results='utf8'");
mysqli_query($conn ,"set collation_connection='utf8'");
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



?>