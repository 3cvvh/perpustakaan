<?php
include '../logic/function.php';
function uploud($gambar){
    $nama_gambar = $gambar["Foto"]["name"];
    $lokasi_gambar = $gambar["Foto"]["tmp_name"];
    $error = $gambar["Foto"]["error"];
    $ukuran_gambar = $gambar["Foto"]["size"];
    $gambar_valid = ['jpg','jfif','png','jpeg'];
    $ekstensi_gambar = explode('.',$nama_gambar);
    $ekstensi_gambar = strtolower(end($ekstensi_gambar));
    if(!in_array($ekstensi_gambar, $gambar_valid)){
        echo "<script>alert('yang anda uploud bukan gambar!');</script>";
        return false;
    }
    
    $nama_gambar_baru = uniqid();
    $nama_gambar_baru .= '.';
    $nama_gambar_baru .= $ekstensi_gambar;
    move_uploaded_file($lokasi_gambar, '../view/img/' . $nama_gambar_baru);
    return $nama_gambar_baru;
}