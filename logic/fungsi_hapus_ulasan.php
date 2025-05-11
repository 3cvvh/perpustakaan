<?php
include '../logic/function.php';
function hapus_ulasan($data_post){
    $id = intval($data_post["ulasan_id"]);
    global $db;

    mysqli_query($db, "DELETE FROM ulasanbuku WHERE UlasanID = $id");
    return mysqli_affected_rows($db);
}