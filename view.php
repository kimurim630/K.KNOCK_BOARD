<?php
include "db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h1><?= $row['title'] ?></h1>
<p><?= $row['content'] ?></p>

<a href="delete.php?id=<?= $row['id'] ?>">삭제</a>
<a href="index.php">목록</a>