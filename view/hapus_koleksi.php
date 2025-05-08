<?php
$id = $_GET['id'];
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
    echo "<script>alert('koleksi berhasil dihapus!');</script>";
    header("Location: koleksi.php?koleksi=success");
    exit;
}else{
    echo "<script>alert('koleksi gagal dihapus!');</script>";
    header("Location: koleksi.php?koleksi=error");
    exit;
}
?>