<?php

include "db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT *
FROM attachments
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$file =
    $stmt
    ->get_result()
    ->fetch_assoc();

header(
    "Content-Disposition: attachment; filename=\"" .
    $file['original_name'] .
    "\""
);

readfile($file['stored_path']);

exit;
