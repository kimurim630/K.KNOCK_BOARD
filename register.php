<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>회원/데이터 입력</title>
</head>
<body>

<h2>입력 폼</h2>

<form action="register_save.php" method="post">

    <!-- username 입력 -->  
    사용자 이름<br>
    <input type="text" name="username" required>
    <br><br>

    <!-- password 입력 -->
    비밀번호<br>
    <input type="password" name="password" required>
    <br><br>

    <!-- submit 버튼 -->
    <input type="submit" value="저장">

</form>

<hr>
