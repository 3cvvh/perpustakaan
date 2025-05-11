<?php
include '../logic/function.php';
function peminjaman($buku_id, $user_id){
    global $db;
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = mysqli_real_escape_string($db, $_POST['tanggal_kembali']);
    $status = 'dipinjam';
    $query = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman)
              VALUES ('$user_id', '$buku_id', '$tanggal_pinjam', '$tanggal_kembali', '$status')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}