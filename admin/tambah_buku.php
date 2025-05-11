<?php
session_start();
include '../logic/fungsi_tambah_buku.php';
include '../logic/fungsi_select.php';
include '../logic/fungsi_uploud.php';
$kategori = select("SELECT * FROM kategoribuku");
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
    header("Location: katalog.php");
    exit;
}
if(isset($_POST["submit"])){
    if(tambah_buku($_POST) > 0){
        echo "<script>
                alert('Data berhasil ditambahkan!');
              </script>";
    } elseif(tambah_buku($_POST) < 0) {
        echo "<script>
                alert('Data gagal ditambahkan!');
              </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah_buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<form class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow" method="post" action="" enctype="multipart/form-data">
    <h2 class="text-2xl font-bold mb-6">Tambah Buku</h2>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Judul">Judul</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="text" name="Judul" id="Judul" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Penulis">Penulis</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="text" name="Penulis" id="Penulis" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Penerbit">Penerbit</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="text" name="Penerbit" id="Penerbit" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="TahunTerbit">Tahun Terbit</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="number" name="TahunTerbit" id="TahunTerbit" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Halaman">Jumlah Halaman</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="number" name="Halaman" id="Halaman" min="1" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="KategoriID">Kategori</label>
        <select class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" name="KategoriID" id="KategoriID" required>
            <option value="">Pilih Kategori</option>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['KategoriID']; ?>"><?= htmlspecialchars($k['NamaKategori']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Deskripsi">Deskripsi</label>
        <textarea class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" name="Deskripsi" id="Deskripsi" rows="4" required></textarea>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Foto">Foto</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="file" name="Foto" id="Foto">
    </div>
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" type="submit" name="submit">Simpan</button>
</form>
</body>
</html>
