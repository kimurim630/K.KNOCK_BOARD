<?php
$conn = mysqli_connect(
	"localhost",
	"root",
	"20060813",
	"board_db",
);

if (!$conn) {
	die("DB 연결실패");
}
?>
