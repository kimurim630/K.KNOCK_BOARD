<?php
include "db.php";
session_start();

//post요청일때만 처리
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $password = $_POST['password'];

	//where을 이용해서 id검색
    $sql = "SELECT * FROM users WHERE username = '$id'";
    $result = $conn->query($sql);

    $user = $result->fetch_assoc();

        //2. 아이디가 없을 경우
    if(!$user) {
        echo "<script>
                alert('아이디가 존재하지 않습니다.');
                history.back();
              </script>";
        exit;
    }
	// 3. 비밀번호 확인
    if($user['password'] != $password) {
        echo "<script>
                alert('비밀번호가 틀렸습니다.');
                history.back();
              </script>";
        exit;
    }

        //4. 로그인 성공 → 세션 저장
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];


       // 5. 메인으로 이동

    header("Location: index.php");
    exit;
}
?>

<!-- 로그인 폼 -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>로그인</title>
</head>
<body>

<h2>로그인</h2>

<form method="post">

아이디<br>
<input type="text" name="id" required>

<br><br>

비밀번호<br>
<input type="password" name="password" required>

<br><br>

<input type="submit" value="로그인">

</form>

</body>
</html>
