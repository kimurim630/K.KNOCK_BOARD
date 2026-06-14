<?php

session_start();

include "db.php";

$sql = "
SELECT
    p.*,
    u.username
FROM posts p
JOIN users u 
ON p.author_id = u.id
ORDER BY p.id DESC
";
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

<?php if(isset($_SESSION['user_id'])) { ?>

    <div>
        <a href="logout.php">
            로그아웃
        </a><br>
	<a href="write.php">
	글쓰기
	</a>

    </div>

<?php } else { ?>

    <div>

        <a href="login.php">
            로그인
        </a>

        |

        <a href="register.php">
            회원가입
        </a>

    </div>

<?php } ?>

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

    <td><?= htmlspecialchars($row['username']) ?></td>

    <td><?= $row['created_at'] ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>
