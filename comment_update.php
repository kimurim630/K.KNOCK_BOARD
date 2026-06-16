<?php
session_start();
include "db.php";

$post_id = $_POST['post_id'];
$comment_id = $_POST['comment_id'];
$content = trim($_POST['content']);

// 기존 댓글 조회 (권한 확인)
$stmt = $conn->prepare("
SELECT author_id FROM comments WHERE id = ?
");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// 업데이트
$stmt = $conn->prepare("
UPDATE comments SET content = ? WHERE id = ?
");
$stmt->bind_param("si", $content, $comment_id);
$stmt->execute();

// 원래 게시글로 이동
header("Location: view.php?id=".$post_id ?? '');
exit;
?>
