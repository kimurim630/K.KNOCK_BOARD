<?php

session_start();
include "db.php";

//주소로 보내서 GET

$id = $_GET['id'];
$edit_id = $_GET['edit_id'] ?? null;
$category = $_GET['category'] ?? 'free';

//mysql문을 만들어서 변수 전달 + 작동
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
$edit_id = $_GET['edit_id'] ?? null;

//첨부파일
$attachment_sql = "
SELECT *
FROM attachments
WHERE post_id = ?
";

$stmt = $conn->prepare($attachment_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$attachments = $stmt->get_result();
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

<h4>첨부파일</h4>

<?php while($file = $attachments->fetch_assoc()) { ?>


    <a href="download.php?id=<?= $file['id'] ?>">
        <?= htmlspecialchars($file['original_name']) ?>
    </a>

    <br>

<?php } ?>

<?php if(isset($_SESSION['user_id']) && $row['author_id'] == $_SESSION['user_id']) { ?>

<a href="edit.php?id=<?= $row['id'] ?>">
수정
</a>

<a href="delete.php?id=<?= $row['id'] ?>"
onclick="return confirm('삭제하시겠습니까?')">
 삭제
</a>

<?php } ?>

<a href="index.php?category=<?= htmlspecialchars($category)?>">
 목록
</a>


<?php if($comments->num_rows > 0) { ?>

<h3>댓글</h3>

<?php while($row = $comments->fetch_assoc()) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

<?php if($edit_id == $row['id']) { ?>

        <!--  수정  -->
        <form action="comment_update.php" method="post">

            <input type="hidden" name="comment_id" value="<?= $row['id'] ?>">
            <input type="hidden" name="post_id" value="<?= $id ?>">

            <textarea name="content" rows="4" cols="60"><?= htmlspecialchars(trim($row['content'])) ?></textarea>

            <br>

            <input type="submit" value="댓글 수정">
            <a href="view.php?id=<?= $id ?>">취소</a>

        </form>

<?php } else { ?>

        <!--  일반 -->
        <p><?= htmlspecialchars($row['content']) ?></p>

        <small>
            작성자: <?= htmlspecialchars($row['username']) ?>
        </small>

        <br>

        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['author_id']) { ?>
            <a href="view.php?id=<?= $id ?>&edit_id=<?= $row['id'] ?>">
                [수정]
            </a>

            <a href="comment_delete.php?id=<?= $row['id'] ?>&post_id=<?= $id ?>"
               onclick="return confirm('삭제할까요?');">
                [삭제]
            </a>
        <?php } ?>

<?php } ?>

    </div>
<?php } ?>
<?php } ?>

<!-- ===================== -->
<!-- 댓글 목록 끝 -->
<!-- ===================== -->

<?php if(isset($_SESSION['user_id'])) { ?>

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

