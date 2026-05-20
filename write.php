<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>글쓰기</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>글쓰기</h1>

    <form action="save.php" method="POST">
        <input type="text" name="title" placeholder="제목" required>

        <input type="text" name="writer" placeholder="작성자" required>

        <textarea name="content" rows="10" placeholder="내용" required></textarea>

        <button type="submit">저장</button>
    </form>
</div>
</body>
</html>