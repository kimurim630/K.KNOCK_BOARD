<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "board_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}
?>