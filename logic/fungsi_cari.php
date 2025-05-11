<?php 
include '../logic/function.php';
function cari($keyword){
    $query =  "SELECT buku.*, kategoribuku.NamaKategori 
    FROM buku
    LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
    LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
    WHERE buku.Judul LIKE '%$keyword%'
    OR buku.Penulis LIKE '%$keyword%'
    OR buku.Penerbit LIKE '%$keyword%'
    OR kategoribuku.NamaKategori LIKE '%$keyword%'";
    return select($query);
}