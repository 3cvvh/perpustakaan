<?php
session_start();
include '../logic/function.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['UserID'];
$id_koleksi = $_GET['id'] ?? null;

if ($id_koleksi) {
    global $db;
    $result = mysqli_query($db, "DELETE FROM koleksipribadi WHERE KoleksiID = $id_koleksi AND UserID = $user_id");
    if ($result) {
        // Berhasil
        header("Location: koleksi.php");
        exit;
    } else {
        // Gagal, debug error dari MySQL
        echo "Gagal menghapus koleksi: " . mysqli_error($db);
    }
} else {
    echo "ID koleksi tidak valid.";
}
?>