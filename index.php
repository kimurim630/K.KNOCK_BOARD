<?php
include "db.php";

$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
</head>
<body>

<h1>게시판</h1>

<a href="write.php">글쓰기</a>

<hr>

<table border="1" width="800">
<tr>
    <th>번호</th>
    <th>제목</th>
    <th>작성자</th>
    <th>작성일</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>
    <td><?= $row['id'] ?></td>

    <td>
        <a href="view.php?id=<?= $row['id'] ?>">
            <?= htmlspecialchars($row['title']) ?>
        </a>
    </td>

    <td><?= htmlspecialchars($row['writer']) ?></td>

    <td><?= $row['created_at'] ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>