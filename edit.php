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

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>수정</title>
</head>
<body>

<h2>글 수정</h2>

<form action="update.php" method="post">

<input type="hidden"
name="id"
value="<?= $row['id'] ?>">

작성자<br>

<input type="text"
name="writer"
value="<?= htmlspecialchars($row['writer']) ?>">

<br><br>

제목<br>

<input type="text"
name="title"
size="50"
value="<?= htmlspecialchars($row['title']) ?>">

<br><br>

내용<br>

<textarea
name="content"
rows="10"
cols="60"><?= htmlspecialchars($row['content']) ?></textarea>

<br><br>

<input type="submit"
value="수정하기">

</form>

</body>
</html>