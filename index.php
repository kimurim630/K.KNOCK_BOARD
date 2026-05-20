<?php
include 'db.php';
$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($conn,$sql);
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

        <?php
        -- 게시글 출력
        while ($row = mysqli_fetch_assoc($result))
        {
        ?>
            <h3><?php echo $row['title'];></h3>
            <p><?php ehco $row['content'];></p>
            <small><?php ehco $row['created_at'];></small>
            <hr>
        <?php
        }
        ?>
    </body>
</html>


