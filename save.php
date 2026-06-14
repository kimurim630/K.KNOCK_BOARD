<?php

session_start();
include "db.php";

$title = $_POST['title'];
$author_id = $_SESSION['user_id'];
$content = $_POST['content'];

$stmt = $conn->prepare(
"INSERT INTO posts(title,author_id,content)
 VALUES(?,?,?)"
);

$stmt->bind_param(
"sis",
$title,
$author_id,
$content
);

$stmt->execute();

header("Location:index.php");
exit;
?>
