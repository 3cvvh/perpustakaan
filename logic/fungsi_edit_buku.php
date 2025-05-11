<?php
include '../logic/function.php';
function edit_buku($data_post){
    global $db;
    $id = intval($data_post["id"]);
    $judul = htmlspecialchars($data_post["Judul"]);
    $pengarang = htmlspecialchars($data_post["Penulis"]);
    $penerbit = htmlspecialchars($data_post["Penerbit"]);
    $tahun = htmlspecialchars($data_post["TahunTerbit"]);
    $halaman = htmlspecialchars($data_post["Halaman"]);
    $kategori_id = intval($data_post["KategoriID"]);
    $deskripsi = htmlspecialchars($data_post["Deskripsi"]);
    $foto_lama = htmlspecialchars($data_post["Foto_lama"]);
    $error_upload = $_FILES['Foto']['error'];
    if($error_upload === 4){
        // Jika tidak ada gambar yang diupload, gunakan gambar lama
        $uploud_gambar = $foto_lama;
    }else{
        $uploud_gambar = uploud($_FILES);
        if(!$uploud_gambar){
            // Jika upload gagal, gunakan gambar lama
            $uploud_gambar = $foto_lama;
        }
    }
    // Update buku
    $query = "UPDATE buku SET Judul='$judul', Halaman='$halaman', Penulis='$pengarang', Penerbit='$penerbit', TahunTerbit='$tahun', Foto='$uploud_gambar', Deskripsi='$deskripsi' WHERE BukuID=$id";
    $result = mysqli_query($db, $query);
    if(!$result){
        // Debug error jika query gagal
        die('Query Error: '.mysqli_error($db));
    }

    // Update relasi kategori
    $result_relasi = mysqli_query($db, "UPDATE kategoribuku_relasi SET KategoriID=$kategori_id WHERE BukuID=$id");
    if(!$result_relasi){
        die('Relasi Error: '.mysqli_error($db));
    }

    return mysqli_affected_rows($db);
}