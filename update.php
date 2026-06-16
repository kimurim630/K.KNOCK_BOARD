<?php

include "db.php";

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

$stmt = $conn->prepare(
"UPDATE posts
 SET title=?,
     content=?
 WHERE id=?"
);

$stmt->bind_param(
"ssi",
$title,
$content,
$id
);

$stmt->execute();

//파일 확인
if(
    isset($_FILES['attachments']) &&
    count($_FILES['attachments']['name']) > 0 &&
    $_FILES['attachments']['name'][0] != ""
)
{
$stmt = $conn->prepare("
SELECT *
FROM attachments
WHERE post_id = ?
");

//서버에 저장된 파일 삭제
$stmt->bind_param("i", $id);
$stmt->execute();

$old_files = $stmt->get_result();

while($file = $old_files->fetch_assoc())
{
    if(file_exists($file['stored_path']))
    {
        unlink($file['stored_path']);
    }
}
//데이터베이스에서 삭제
$stmt = $conn->prepare("
DELETE FROM attachments
WHERE post_id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

$count =
    count($_FILES['attachments']['name']);

for($i = 0; $i < $count; $i++)
{
    if($_FILES['attachments']['error'][$i] != 0)
    {
        continue;
    }

    $original_name =
        $_FILES['attachments']['name'][$i];

    $stored_name =
        uniqid() . "_" . $original_name;

    $stored_path =
        "uploads/" . $stored_name;

    move_uploaded_file(
        $_FILES['attachments']['tmp_name'][$i],
        $stored_path
    );

    $size_bytes =
        $_FILES['attachments']['size'][$i];

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
        $id,
        $original_name,
        $stored_path,
        $size_bytes
    );

    $stmt->execute();
}
}

header("Location:view.php?id=".$id);
exit;

?>
