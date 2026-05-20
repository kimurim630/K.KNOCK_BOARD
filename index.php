<?php
include 'db.php';
$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($conn,$sql);
?>

