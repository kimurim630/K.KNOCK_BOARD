<?php

$conn = new mysqli(
    "localhost",
    "boarduser",
    "1234",
    "boarddb"
);

if($conn->connect_error){
    die("DB 연결 실패");
}

$conn->set_charset("utf8mb4");

?>
