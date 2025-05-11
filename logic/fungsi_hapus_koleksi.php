<?php
include '../logic/function.php';
function hapus_koleksi($id){
    global $db;
    mysqli_query($db, "DELETE FROM koleksipribadi WHERE BukuID = $id");
    return mysqli_affected_rows($db);
}