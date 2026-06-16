<?php

include "db.php";

$comment_id = $_GET['id'];
$post_id = $_GET['post_id'];

$stmt = $conn->prepare(
"DELETE FROM comments
 WHERE id=? AND post_id=?"
);

$stmt->bind_param("ii", $comment_id,$post_id);
$stmt->execute();

header("Location:view.php?id=".$post_id);
exit;

?>
