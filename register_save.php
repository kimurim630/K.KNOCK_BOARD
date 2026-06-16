<?php

include "db.php";

session_start();

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


//insert_id 방금 전에 생성된 user_id가져오기
$id = $stmt->insert_id;

$_SESSION['user_id'] = $id;
$_SESSION['username'] = $username;
$catgory = $_GET['category'] ?? 'free';

header("Location:index.php?category=$category");
exit;
?>
