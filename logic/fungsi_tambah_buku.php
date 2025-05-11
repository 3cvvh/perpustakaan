<?php
include '../logic/function.php';
function tambah_buku($data_post){
    global $db;
    $judul = htmlspecialchars($data_post["Judul"]);
    $pengarang = htmlspecialchars($data_post["Penulis"]);
    $penerbit = htmlspecialchars($data_post["Penerbit"]);
    $tahun = htmlspecialchars($data_post["TahunTerbit"]);
    $halaman = htmlspecialchars($data_post["Halaman"]);
    $kategori_id = intval($data_post["KategoriID"]);
    $uploud_gambar = uploud($_FILES);
    $deskripsi = htmlspecialchars($data_post["Deskripsi"]);
    if(!$uploud_gambar){
        return false;
    }
    // Insert buku
    $query = "INSERT INTO buku VALUES('','$judul','$halaman','$pengarang','$penerbit','$tahun','$uploud_gambar','$deskripsi')";
    mysqli_query($db, $query);

    // Ambil ID buku terakhir yang baru dimasukkan
    $buku_id = mysqli_insert_id($db);

    $query_relasi = "INSERT INTO kategoribuku_relasi (KategoriID, BukuID) VALUES ('$kategori_id', '$buku_id')";
    mysqli_query($db, $query_relasi);

    return mysqli_affected_rows($db);
}