<?php
include '../logic/function.php';
function edit($data_post){
    global $db;
    $id = $data_post["id"];
    $nama_lengkap = $data_post["nama"];
    $email = $data_post["email"]; 
    $alamat = $data_post["alamat"];
    $query = "UPDATE user SET NamaLengkap = '$nama_lengkap', Email = '$email', Alamat = '$alamat' WHERE UserID = $data_post[id]";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
    }
    