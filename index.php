<?php

session_start();

include "db.php";

// ?? : 왼쪽값이 존재하고 NULL이 아니면 왼쪽 아니면 오른쪽
$category = $_GET['category'] ?? 'free';

$sort = $_GET['sort'] ?? 'desc';

if($sort == 'asc') $order = 'ASC';
else $order = 'DESC';


$sql = "SELECT posts.*, users.username
FROM posts
JOIN users
ON posts.author_id = users.id ";

$where = "";
$params = [];
$types = "";

$title_search = $_GET['title_search'] ?? '';
$user_search  = $_GET['user_search'] ?? '';

if($title_search != "")
{
    $where .= "WHERE posts.title LIKE ? ";
    $params[] = "%" . $title_search . "%";
    $types .= "s";
}

if($user_search != "")
{
    if($where == "")
        $where .= "WHERE users.username LIKE ? ";
    else
        $where .= "AND users.username LIKE ? ";

    $params[] = "%" . $user_search . "%";
    $types .= "s";
}

if($where=="") $sql = $sql . $where . "WHERE category = ? " . "ORDER BY posts.id $order";
else $sql = $sql . $where . "AND category = ? " . "ORDER BY posts.id $order";
$stmt = $conn->prepare($sql);
$types .= "s";
$params[] = $category;
//... 배열을 풀어서 전달
    $stmt->bind_param($types,...$params);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
</head>
<body>


<?php if($category=='free') { ?>
<h1>자유 게시판</h1>
<?php } else { ?>
<h1>공지 게시판</h1>
<?php } ?>

<a href="index.php?category=free">자유게시판</a>
<a href="index.php?category=notice">공지게시판</a>

<?php if(isset($_SESSION['user_id'])) { ?>

    <div>
	 현재 사용자 : 
        <?= htmlspecialchars($_SESSION['username']) ?>
        <br>
        <a href="logout.php?category=<?= htmlspecialchars($category)?>">
            로그아웃
        </a><br>
	<a href="write.php?category=<?= htmlspecialchars($category)?>">
	글쓰기
	</a>

    </div>

<?php } else { ?>

    <div>
<!-- htmlspecialchars 코드로 취급될 수 있는 부분을 일반문자로 사용할 수 있게 해주는 명령어 -->
        <a href="login.php?category=<?= htmlspecialchars($category)?>">
            로그인
        </a>

        |

        <a href="register.php?category=<?= htmlspecialchars($category)?>">
            회원가입
        </a>

    </div>

<?php } ?>
<!-- 검색 폼 inline-block은 내용만큼만 공간차지, 원래 블럭은 한 줄 전체 차지 -->

<form method="get" style="display:inline-block;">
   제목 검색 :

    <input
        type="text"
        name="title_search"
        value="<?= htmlspecialchars($_GET['title_search'] ?? '') ?>">

유저 검색 :
    <input
        type="text"
        name="user_search"
        value="<?= htmlspecialchars($_GET['user_search'] ?? '') ?>">

    <input
        type="submit"
        value="검색">
    <input
        type="hidden"
        name="sort"
        value="<?=  htmlspecialchars($_GET['sort'] ?? 'desc')?>">
<input type ="hidden" name="category" value="<?= htmlspecialchars($category)?>">


</form>

<!-- 정렬 폼 -->
<form method="get" style="display:inline-block;">
    <input
        type="hidden"
        name="title_search"
        value="<?= htmlspecialchars($_GET['title_search'] ?? '') ?>">
<input
        type="hidden"
        name="user_search"
        value="<?= htmlspecialchars($_GET['user_search'] ?? '') ?>">
            <input
        type="hidden"
        name="sort"
        value="<?=  htmlspecialchars($_GET['sort'] ?? 'desc')?>">
        <input type ="hidden" name="category" value="<?= htmlspecialchars($category)?>">
<?php if(($_GET['sort'] ?? 'desc') != 'desc') { ?>
    <input
        type="hidden"
        name="sort"
        value="desc">

    <input
        type="submit"
        value="오래된 순">

<?php } else { ?>

    <input
        type="hidden"
        name="sort"
        value="asc">

    <input
        type="submit"
        value="최신 순">

<?php } ?>
</form>

<br>

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
        <a href="view.php?id=<?= $row['id'] ?>?category=<?= htmlspecialchars($category)?>">
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
