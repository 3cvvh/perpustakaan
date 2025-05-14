<?php
session_start();
include '../logic/function.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['UserID'];
$buku_id = $_GET['id'] ?? null;

if ($buku_id) {
    global $db;
    $cek = mysqli_query($db, "SELECT * FROM koleksipribadi WHERE UserID = $user_id AND BukuID = $buku_id");

    if (mysqli_num_rows($cek) === 0) {
        mysqli_query($db, "INSERT INTO koleksipribadi (UserID, BukuID) VALUES ($user_id, $buku_id)");
    }

    header("Location: koleksi.php");
    exit;
} else {
    echo "ID buku tidak valid.";
}
?>