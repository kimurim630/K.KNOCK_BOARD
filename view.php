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
<title>글보기</title>
</head>
<body>

<h2>
<?= htmlspecialchars($row['title']) ?>
</h2>

<hr>

작성자 :
<?= htmlspecialchars($row['writer']) ?>

<br>

작성일 :
<?= $row['created_at'] ?>

<hr>

<pre>
<?= htmlspecialchars($row['content']) ?>
</pre>

<hr>

<a href="edit.php?id=<?= $row['id'] ?>">
수정
</a>

<a href="delete.php?id=<?= $row['id'] ?>"
onclick="return confirm('삭제하시겠습니까?')">
삭제
</a>

<a href="index.php">
목록
</a>

</body>
</html>