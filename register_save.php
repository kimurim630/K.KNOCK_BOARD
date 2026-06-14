<?php

include "db.php";

//trim을 이용해서 앞의 공백 제거
$username = trim($_POST['username']);
$password = $_POST['password'];

//empty로 닉네임이 비어있는지 확인
if(empty($username)) 
{
    echo "닉네임을 입력하세요.";
    exit;
}

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if($user) 
{
        echo "<script>
                alert('동일한 아이디가 존재합니다.');
                history.back();
              </script>";
        exit;
}

$stmt = $conn->prepare(
"INSERT INTO users(username,password)
 VALUES(?,?)"
);

$stmt->bind_param(
"ss",
$username,
$password
);

$stmt->execute();


header("Location:index.php");
exit;
?>
