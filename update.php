<?php

include "db.php";

$id = $_POST['id'];
$title = $_POST['title'];
$writer = $_POST['writer'];
$content = $_POST['content'];

$stmt = $conn->prepare(
"UPDATE posts
 SET title=?,
     writer=?,
     content=?
 WHERE id=?"
);

$stmt->bind_param(
"sssi",
$title,
$writer,
$content,
$id
);

$stmt->execute();

header("Location:view.php?id=".$id);

?>