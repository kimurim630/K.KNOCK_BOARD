<?php
include "db.php";
$category = $_GET['category'] ?? 'free';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>글쓰기</title>
</head>
<body>

<h2>글쓰기</h2>

<!-- 파일은 그냥 전달 안 됨 그래서 enctype이 필요, multipart는 여러 형식 통합해서 전달, form-data는 이진 형식으로 전달 -->
<form action="save.php" method="post" enctype="multipart/form-data">

<input type="hidden" name="category" value="<?= $category ?>">

제목<br>
<input type="text" name="title" size="50"><br><br>

내용<br>
<textarea name="content"
rows="10"
cols="60"></textarea><br><br>

파일<br>
<input type="file" name="attachments[]" multiple>

<input type="submit" value="등록">

</form>

</body>
</html>
