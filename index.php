<?php
include "db.php";

$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h1>게시판</h1>
<a href="write.php">글쓰기</a>
<hr>

<?php while($row = $result->fetch_assoc()) { ?>
    <div>
        <h3>
            <a href="view.php?id=<?= $row['id'] ?>">
                <?= $row['title'] ?>
            </a>
        </h3>
        <small><?= $row['created_at'] ?></small>
    </div>
    <hr>
<?php } ?>