<?php
include "db.php";

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

/* ------------------------
   1. 게시글 수정
------------------------ */
$stmt = $conn->prepare("
    UPDATE posts
    SET title = ?, content = ?
    WHERE id = ?
");
$stmt->bind_param("ssi", $title, $content, $id);
$stmt->execute();


/* =========================================================
   2. 첨부파일 처리 (전체 교체 방식)
   - 파일이 하나라도 있으면 기존 전부 삭제 후 재업로드
========================================================= */
if (
    isset($_FILES['attachments']) &&
    isset($_FILES['attachments']['name'])
) {

    $count = count($_FILES['attachments']['name']);

    $hasFile = false;

    /* 먼저 실제 유효 파일 있는지 체크 */
    for ($i = 0; $i < $count; $i++) {
        if (
            $_FILES['attachments']['error'][$i] === 0 &&
            $_FILES['attachments']['name'][$i] !== ""
        ) {
            $hasFile = true;
            break;
        }
    }

    /* 파일이 있을 때만 기존 삭제 + 재업로드 */
    if ($hasFile) {

        /* ------------------------
           2-1 기존 파일 조회
        ------------------------ */
        $stmt = $conn->prepare("
            SELECT * FROM attachments
            WHERE post_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $old_files = $stmt->get_result();

        /* ------------------------
           2-2 실제 파일 삭제
        ------------------------ */
        while ($file = $old_files->fetch_assoc()) {

            $path = __DIR__ . "/" . $file['stored_path'];

            if (file_exists($path)) {
                unlink($path);
            }
        }

        /* ------------------------
           2-3 DB 삭제
        ------------------------ */
        $stmt = $conn->prepare("
            DELETE FROM attachments
            WHERE post_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();


        /* ------------------------
           2-4 새 파일 업로드
        ------------------------ */
        for ($i = 0; $i < $count; $i++) {

            if (
                $_FILES['attachments']['error'][$i] !== 0 ||
                $_FILES['attachments']['name'][$i] === ""
            ) {
                continue;
            }

            $original_name = $_FILES['attachments']['name'][$i];

            $stored_name = uniqid() . "_" . $original_name;
            $stored_path = "uploads/" . $stored_name;

            move_uploaded_file(
                $_FILES['attachments']['tmp_name'][$i],
                $stored_path
            );

            $size_bytes = $_FILES['attachments']['size'][$i];

            $stmt = $conn->prepare("
                INSERT INTO attachments
                (post_id, original_name, stored_path, size_bytes)
                VALUES (?, ?, ?, ?)
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
}


/* ------------------------
   3. 완료 후 이동
------------------------ */
header("Location: view.php?id=" . $id);
exit;

?>
