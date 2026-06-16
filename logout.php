<?php

session_start();

session_unset();
session_destroy();

$category = $_GET['category'];

header("Location: index.php?category=$category");
exit;
