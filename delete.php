<?php

include "db.php";

$id = $_GET['id'];

$stmt = $conn->prepare(
"DELETE FROM comments
 WHERE post_id=?"
);
$stmt->bind_param("i",$id);
$stmt->execute();

$stmt = $conn->prepare(
"DELETE FROM attachments
 WHERE post_id=?"
);

$stmt->bind_param("i",$id);
$stmt->execute();


$stmt = $conn->prepare(
"DELETE FROM posts
 WHERE id=?"
);

$stmt->bind_param("i",$id);
$stmt->execute();



header("Location:index.php");

?>
