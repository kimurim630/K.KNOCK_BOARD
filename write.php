<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>글쓰기</title>
</head>
<body>

<h2>글쓰기</h2>

<form action="save.php" method="post">

작성자<br>
<input type="text" name="writer"><br><br>

제목<br>
<input type="text" name="title" size="50"><br><br>

내용<br>
<textarea name="content"
rows="10"
cols="60"></textarea><br><br>

<input type="submit" value="등록">

</form>

</body>
</html>