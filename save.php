<?php
include 'config.php';

$title = $_POST['title'];
$writer = $_POST['writer'];
$content = $_POST['content'];

$sql = "INSERT INTO posts (title, writer, content)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $writer, $content);
$stmt->execute();

header("Location: index.php");
?>