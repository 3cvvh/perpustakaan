<?php
include '../logic/function.php';
function kembalikan($id){
    global $db;
    $tanggal_kembali = date('Y-m-d');
    $query_update = "UPDATE peminjaman SET StatusPeminjaman = 'selesai', TanggalPengembalian = '$tanggal_kembali' WHERE PeminjamanID = $id";
    mysqli_query($db, $query_update);
    return mysqli_affected_rows($db);
}