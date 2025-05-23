<?php 
include '../logic/function.php';
function hapus_kategori($id){
    global $db;
    // Hapus relasi kategori-buku
    mysqli_query($db, "DELETE FROM kategoribuku_relasi WHERE KategoriID = '$id'");
    // Hapus kategori
    mysqli_query($db, "DELETE FROM kategoribuku WHERE KategoriID = '$id'");
    return mysqli_affected_rows($db);
}

?>