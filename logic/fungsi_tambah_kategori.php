<?php
include '../logic/function.php';
function tambah_kategori($data_post){
    global $db;
    $kategori = $_POST['nama_kategori'];
    $query = "INSERT INTO kategoribuku VALUES ('','$kategori')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
?>