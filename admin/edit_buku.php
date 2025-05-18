<?php
// Ambil id buku dari parameter GET
$id = $_GET["id"];
// Import fungsi select data dari database
include '../logic/fungsi_select.php';
// Import fungsi edit buku
include '../logic/fungsi_edit_buku.php';
// Import fungsi upload file
include '../logic/fungsi_uploud.php';
// Ambil semua kategori buku dari database
$kategori = select("SELECT * FROM kategoribuku");
// Ambil relasi kategori buku saat ini
$relasi = select("SELECT KategoriID FROM kategoribuku_relasi WHERE BukuID = $id");
// Ambil KategoriID yang sedang dipakai buku
$KategoriID_sekarang = $relasi ? $relasi[0]['KategoriID'] : '';
// Ambil data buku yang akan diedit
$aduh_gantengnya = select("SELECT * FROM buku where BukuID = $id")[0];
// Jika form disubmit
if(isset($_POST["submit"])){
    $result = edit_buku($_POST);
    if($result !== false){
        echo "<script>
                alert('Data berhasil diubah!');
                window.location.href = 'buku.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Data gagal diubah!');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<form class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow" method="post" action="" enctype="multipart/form-data">
    <h2 class="text-2xl font-bold mb-6">Tambah Buku</h2>
    <input type="hidden" name="id" value="<?= htmlspecialchars($aduh_gantengnya['BukuID']) ?>">
    <input type="hidden" name="Foto_lama" value="<?= htmlspecialchars($aduh_gantengnya['Foto']) ?>">
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Judul">Judul</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="text" name="Judul" id="Judul" required value="<?= htmlspecialchars($aduh_gantengnya['Judul']) ?>">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Penulis">Penulis</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="text" name="Penulis" id="Penulis" required value="<?= htmlspecialchars($aduh_gantengnya['Penulis']) ?>">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Penerbit">Penerbit</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="text" name="Penerbit" id="Penerbit" required value="<?= htmlspecialchars($aduh_gantengnya['Penerbit']) ?>">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="TahunTerbit">Tahun Terbit</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="number" name="TahunTerbit" id="TahunTerbit" required value="<?= htmlspecialchars($aduh_gantengnya['TahunTerbit']) ?>">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Halaman">Jumlah Halaman</label>
        <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="number" name="Halaman" id="Halaman" min="1" required value="<?= htmlspecialchars($aduh_gantengnya['halaman']) ?>">
    </div>
    <div class="mb-4">
    <label class="block text-gray-700 mb-2" for="KategoriID">Kategori</label>
    <select class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" name="KategoriID" id="KategoriID" required>
    <option value="">Pilih Kategori</option>
    <?php foreach($kategori as $k): ?>
        <option value="<?= $k['KategoriID']; ?>" <?= ($k['KategoriID'] == $KategoriID_sekarang) ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['NamaKategori']); ?>
        </option>
    <?php endforeach; ?>
</select>
</div>
<div class="mb-4">
        <label class="block text-gray-700 mb-2" for="Deskripsi">Deskripsi</label>
        <textarea class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" name="Deskripsi" id="Deskripsi" rows="4" required><?php echo $aduh_gantengnya["Deskripsi"]?></textarea>
    </div>
<div class="mb-4">
    <label class="block text-gray-700 mb-2" for="Foto">Foto</label>
    <input class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" type="file" name="Foto" id="Foto" accept="image/*">
        <img src="../view/img/<?php echo htmlspecialchars($aduh_gantengnya['Foto']) ?>" alt="Preview Foto" class="mt-2 max-h-48 rounded shadow border">
</div>
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" type="submit" name="submit">Simpan</button>
</form>
</body>
</html>