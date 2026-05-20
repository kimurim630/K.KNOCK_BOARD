<?php
include 'config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>게시글 보기</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1><?= htmlspecialchars($post['title']) ?></h1>

    <p><strong>작성자:</strong> <?= htmlspecialchars($post['writer']) ?></p>
    <p><strong>작성일:</strong> <?= $post['created_at'] ?></p>

    <hr>

    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    <hr>

    <a href="index.php">목록</a>
    |
    <a href="delete.php?id=<?= $post['id'] ?>"
       onclick="return confirm('삭제하시겠습니까?')">
       삭제
    </a>
</div>
</body>
</html>