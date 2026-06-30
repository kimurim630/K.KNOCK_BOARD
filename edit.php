<?php
include "db.php";

$id = $_GET['id'];

/* 게시글 */
$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

/* 첨부파일 */
$stmt = $conn->prepare("
    SELECT * FROM attachments WHERE post_id=?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$attachments = $stmt->get_result();
?>

<h2>글 수정</h2>

<form action="update.php" method="post" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $row['id'] ?>">

제목<br>
<input type="text" name="title"
value="<?= htmlspecialchars($row['title']) ?>"><br><br>

내용<br>
<textarea name="content">
<?= htmlspecialchars($row['content']) ?>
</textarea><br><br>

<hr>

<!-- 기존 파일 -->
<h3>현재 첨부파일</h3>

<?php while($file = $attachments->fetch_assoc()) { ?>

    <?= htmlspecialchars($file['original_name']) ?>

    <a href="file_delete.php?id=<?= $file['id'] ?>&post_id=<?= $row['id'] ?>"
       onclick="return confirm('삭제하시겠습니까?')"
       style="color:red;">
       [삭제]
    </a>

    <br>

<?php } ?>

<hr>

<!-- 새 파일 추가 -->
<h3>파일 추가</h3>

<input type="file" name="attachments[]" multiple>

<br><br>
<p>
  <strong>첨부파일 변경</strong>
  <span style="color:gray; font-size:12px;">
    첨부파일 변경시 현재 첨부파일 모두 지워짐
  </span>
</p>

<input type="file" name="attachments[]" multiple>

<br><br>

<button type="submit">수정하기</button>

</form>
