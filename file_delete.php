<?php
include "db.php";

$file_id = $_GET['id'];
$post_id = $_GET['post_id'];

/* 파일 정보 */
$stmt = $conn->prepare("
    SELECT stored_path
    FROM attachments
    WHERE id=?
");
$stmt->bind_param("i", $file_id);
$stmt->execute();
$file = $stmt->get_result()->fetch_assoc();

/* 실제 파일 삭제 */
if(!empty($file['stored_path'])) {

    $path = __DIR__ . "/" . $file['stored_path'];

    if(file_exists($path)) {
        unlink($path);
    }
}

/* DB 삭제 */
$stmt = $conn->prepare("
    DELETE FROM attachments
    WHERE id=?
");
$stmt->bind_param("i", $file_id);
$stmt->execute();

/* edit 복귀 */
header("Location: edit.php?id=".$post_id);
exit;
?>
