<?php
session_start();
include '../logic/function.php';

if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}

$user_id = $_SESSION['UserID']; // pastikan session ini ada
$buku_id = $_GET['id'];

if (!$user_id || !$buku_id) {
    header("Location: view/pinjam.php?id_buku=$buku_id&koleksi=error");
    exit;
}

// Cek apakah sudah ada di koleksi
$cek = select("SELECT * FROM koleksipribadi WHERE UserID=$user_id AND BukuID=$buku_id");
if ($cek) {
    header("Location: view/pinjam.php?id_buku=$buku_id&koleksi=exists");
    exit;
}

// Insert ke koleksi
$query = "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ($user_id, $buku_id)";
if (mysqli_query($db, $query)) {
    header("Location: koleksi.php?koleksi=success");
} else {
    header("Location: view/pinjam.php?id_buku=$buku_id&koleksi=error");
}
exit;
?>