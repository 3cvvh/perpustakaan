<?php 
include '../logic/function.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}
$user_id = $_SESSION['UserID']; // pastikan session ini ada
$babi = select("SELECT * FROM koleksipribadi WHERE UserID=$user_id");
var_dump($babi);
?>