<?php
$id = $_GET['id'];
include '../logic/fungsi_hapus_koleksi.php';
session_start();
include '../logic/function.php';
if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}
$user_id = $_SESSION['UserID']; 
if (!$user_id || !$id) {
    header("Location: koleksi.php?koleksi=error");
    exit;
}
if( hapus_koleksi($id) > 0){
    header("Location: koleksi.php?koleksi=berhasil");
    exit;
}else{
    header("Location: koleksi.php?koleksi=gagal");
    exit;
}
?>