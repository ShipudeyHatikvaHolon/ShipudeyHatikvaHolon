<?php
require_once 'configur.php';

// ADD TABLE ORDER TO THE DATA BASE

$tableName = filter_input(INPUT_GET, 'tableName');
$dateTime = filter_input(INPUT_GET, 'dateTime');
$phone = filter_input(INPUT_GET, 'phone');
$name = filter_input(INPUT_GET, 'name');

if( !empty($tableName) && !empty($dateTime) && !empty($phone) && !empty($name) ) {
    $sql = "INSERT INTO tableorders (id, tableName, `name`, `phone`, `datetime`, createdAt)
                        VALUES('', '$tableName', '$name', '$phone', '$dateTime', NOW())";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo 'sucess';
    }else {
        echo 'failed';
    }
}