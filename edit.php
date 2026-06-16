<?php

include "db.php";

$id = $_GET['id'];

$stmt = $conn->prepare(
"SELECT * FROM posts WHERE id=?"
);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

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
<title>수정</title>
</head>
<body>

<h2>글 수정</h2>

<form action="update.php" method="post" enctype="multipart/form-data">

<input type="hidden"
name="id"
value="<?= $row['id'] ?>">

<br><br>

제목<br>

<input type="text"
name="title"
size="50"
value="<?= htmlspecialchars($row['title']) ?>">

내용<br>

<textarea
name="content"
rows="10"
cols="60"><?= htmlspecialchars($row['content']) ?></textarea>

<br><br>
첨부파일 변경<br>

<input
    type="file"
    name="attachments[]"
    multiple>

<br><br>현재 첨부파일<br>

<?php while($file = $attachments->fetch_assoc()) { ?>

    <?= htmlspecialchars($file['original_name']) ?>

    <br>

<?php } ?>
<br><br>

<input type="submit"
value="수정하기">

</form>

</body>
</html>
