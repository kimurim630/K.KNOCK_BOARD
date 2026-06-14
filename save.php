<?php

include "db.php";

$title = $_POST['title'];
$writer = $_POST['writer'];
$content = $_POST['content'];

$stmt = $conn->prepare(
"INSERT INTO posts(title,writer,content)
 VALUES(?,?,?)"
);

$stmt->bind_param(
"sss",
$title,
$writer,
$content
);

$stmt->execute();

header("Location:index.php");

?>