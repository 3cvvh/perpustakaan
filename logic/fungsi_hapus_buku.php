<?php
include '../logic/function.php';
function hapus_buku($id){
    global $db;
    mysqli_query($db, "DELETE FROM ulasanbuku WHERE BukuID = $id");
    // Hapus relasi kategori
    mysqli_query($db, "DELETE FROM kategoribuku_relasi WHERE BukuID = $id");
    // Hapus data peminjaman terkait buku
    mysqli_query($db, "DELETE FROM peminjaman WHERE BukuID = $id");
    // Hapus data koleksi pribadi terkait buku
    mysqli_query($db, "DELETE FROM koleksipribadi WHERE BukuID = $id");
    // Baru hapus buku
    mysqli_query($db, "DELETE FROM buku WHERE BukuID = $id");
  
    return mysqli_affected_rows($db);
}