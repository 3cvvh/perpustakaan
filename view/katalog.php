<?php
session_start();
include '../logic/function.php';
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>katalog</title>
</head>
<body>
    <h1>ini katalog</h1>
</body>
</html>