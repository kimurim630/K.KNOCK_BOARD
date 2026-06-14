<?php

$conn = new mysqli(
    "localhost",
    "root",
    "비밀번호",
    "boarddb"
);

if($conn->connect_error){
    die("DB 연결 실패");
}

$conn->set_charset("utf8mb4");

?>