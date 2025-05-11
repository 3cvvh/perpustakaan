<?php
include '../logic/function.php';
function hapus($id){
    global $db;
    mysqli_query($db, "DELETE from koleksipribadi where UserID = $id");
    mysqli_query($db, "DELETE from peminjaman where UserID = $id");
    mysqli_query($db, "DELETE from ulasanbuku where UserID = $id");
    mysqli_query($db, "DELETE from user where UserID = $id");
    return mysqli_affected_rows($db);
    }