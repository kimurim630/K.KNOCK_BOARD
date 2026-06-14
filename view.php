<?php

session_start();
include "db.php";

$id = $_GET['id'];

$sql = "
SELECT
    p.*,
    u.username
FROM posts p
JOIN users u
ON p.author_id = u.id
WHERE p.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$comment_sql = "
SELECT
    c.*,
    u.username
FROM comments c
JOIN users u
ON c.author_id = u.id
WHERE c.post_id = ?
ORDER BY c.id ASC
";

$stmt = $conn->prepare($comment_sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$comments = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>글보기</title>
</head>
<body>

<h2>
<?= htmlspecialchars($row['title']) ?>
</h2>

<hr>

작성자 :
<?= htmlspecialchars($row['username']) ?>

<br>

작성일 :
<?= $row['created_at'] ?>

<hr>

<pre>
<?= htmlspecialchars($row['content']) ?>
</pre>

<hr>

<?php if(isset($_SESSION['user_id']) && $row['author_id'] == $_SESSION['user_id']) { ?>

<a href="edit.php?id=<?= $row['id'] ?>">
수정
</a>

<a href="delete.php?id=<?= $row['id'] ?>"
onclick="return confirm('삭제하시겠습니까?')">
 삭제
</a>

<?php } ?>

<a href="index.php">
 목록
</a>


<?php if($comments->num_rows > 0) { ?>

<h3>댓글</h3>

<?php while($comment = $comments->fetch_assoc()) { ?>

<div
style="
border:1px solid #ccc;
padding:10px;
margin-bottom:10px;
">

<strong>
<?= htmlspecialchars($comment['username']) ?>
</strong>

<br><br>

<?= nl2br(htmlspecialchars($comment['content'])) ?>

<br><br>

<small>
<?= $comment['created_at'] ?>
</small>

</div>

<hr>

<?php }} ?>

<!-- ===================== -->
<!-- 댓글 목록 끝 -->
<!-- ===================== -->

<?php if(isset($_SESSION['user_id']) && $row['author_id'] == $_SESSION['user_id']) { ?>

<h3>댓글 작성</h3>

<form action="comment_save.php" method="post">

    <!-- 현재 게시글 번호 -->
    <input
        type="hidden"
        name="post_id"
        value="<?= $id ?>">
    댓글 내용<br>

    <textarea
        name="content"
        rows="5"
        cols="60"
        required></textarea>

    <br><br>

    <input
        type="submit"
        value="댓글 등록">

</form>
<?php } ?>

</body>
</html>

