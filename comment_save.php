<?php

session_start();
include "db.php";


    //폼에서 넘어온 데이터

$post_id = $_POST['post_id'];
$author_id = $_SESSION['user_id'];
$content = $_POST['content'];

/*
    댓글 저장
*/
$stmt = $conn->prepare(
"
INSERT INTO comments
(
    post_id,
    author_id,
    content
)
VALUES
(
    ?, ?, ?
)
"
);

$stmt->bind_param(
    "iis",
    $post_id,
    $author_id,
    $content
);

$stmt->execute();


//    저장 후 원래 게시글로 이동

header(
    "Location:view.php?id=".$post_id
);

exit;
