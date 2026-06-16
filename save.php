<?php
session_start();
include "db.php";

$title = $_POST['title'];
$author_id = $_SESSION['user_id'];
$content = $_POST['content'];
$category = $_POST['category'];

$stmt = $conn->prepare(
"INSERT INTO posts(title,author_id,content,category)
 VALUES(?,?,?,?)"
);

$stmt->bind_param(
"siss",
$title,
$author_id,
$content,
$category
);

$stmt->execute();


//게시글 번호
$post_id = $conn->insert_id;

//파일 개수
$count =
    count($_FILES['attachments']['name']);

for($i = 0; $i < $count; $i++)
{
    
        //업로드 오류가 있으면 건너뜀
    if($_FILES['attachments']['error'][$i] != 0)
    {
        continue;
    }


        //원본 파일명
    $original_name =
        $_FILES['attachments']['name'][$i];


        //파일 크기
    $size_bytes =
        $_FILES['attachments']['size'][$i];

 
        //서버 저장 파일명
    $stored_name =
        uniqid() . "_" . $original_name;


       // 실제 저장 경로
    $stored_path =
        "uploads/" . $stored_name;


        //uploads 폴더로 이동
    move_uploaded_file(
        $_FILES['attachments']['tmp_name'][$i],
        $stored_path
    );


       // DB 저장
    $stmt = $conn->prepare("
    INSERT INTO attachments
    (
        post_id,
        original_name,
        stored_path,
        size_bytes
    )
    VALUES
    (
        ?, ?, ?, ?
    )
    ");

    $stmt->bind_param(
        "issi",
        $post_id,
        $original_name,
        $stored_path,
        $size_bytes
    );

    $stmt->execute();
}


header("Location:index.php?category=$category");
exit;
?>
