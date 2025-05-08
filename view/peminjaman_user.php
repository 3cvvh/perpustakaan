<?php
session_start();
include '../logic/function.php';
$userId = $_SESSION['UserID'];
$peminjaman = select("SELECT p.*, b.Judul, b.Foto 
    FROM peminjaman p 
    JOIN buku b ON p.BukuID = b.BukuID 
    WHERE p.UserID = $userId 
    ORDER BY p.PeminjamanID DESC");
    if(isset($_POST["submit"])){
     if(kembalikan($_POST) > 0){
        echo "<script>alert('Buku berhasil dikembalikan');</script>";
        header("Location: peminjaman_user.php");
        exit;
     }else{
        echo "<script>alert('Buku gagal dikembalikan');</script>";
     }
    }
    $peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>peminjaman_user</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2">
            <div class="flex items-center gap-2">
                <img src="img/Logo.png" alt="Logo" class="h-16 w-16" />
                <span class="font-bold text-lg text-blue-900">PERPUSTAKAAN DIGITAL</span>
            </div>
            <div class="flex gap-8">
            <a href="katalog.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">katalog</a>
                <a href="koleksi.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-medium border-b-2 border-blue-700 pb-1">peminjaman</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">hi <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-8 h-8 border" alt="avatar" />
                <button class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"><a href="destroy.php">logout</a></button>
            </div>
        </div>
    </div>
<table class="min-w-full border border-gray-300 rounded-lg overflow-hidden shadow-lg mt-8">
  <thead>
    <tr class="bg-blue-700 text-white">
      <th class="px-4 py-2 text-left">Buku</th>
      <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
      <th class="px-4 py-2 text-left">Tanggal Kembali</th>
      <th class="px-4 py-2 text-left">Status</th>
      <th class="px-4 py-2 text-left">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($peminjaman as $i => $p): ?>
    <tr class="<?= $i % 2 == 0 ? 'bg-white' : 'bg-gray-100' ?> hover:bg-blue-50 transition">
      <td class="border-t px-4 py-2"><?= $p['Judul'] ?></td>
      <td class="border-t px-4 py-2"><?= $p['TanggalPeminjaman'] ?></td>
      <td class="border-t px-4 py-2"><?= $p['TanggalPengembalian'] ?></td>
      <td class="border-t px-4 py-2">
        <?php if($p['StatusPeminjaman'] == 'dipinjam'): ?>
          <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs ">Dipinjam</span>
        <?php else: ?>
          <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Selesai</span>
        <?php endif; ?>
      </td>
      <td class="border-t px-4 py-2">
        <?php if($p['StatusPeminjaman'] == 'dipinjam'): ?>
          <form method="post" action="">
            <input type="hidden" name="id" value="<?= $p['PeminjamanID'] ?>">
            <button name="submit" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow">Kembalikan</button>
          </form>
        <?php elseif($p['StatusPeminjaman'] == 'selesai'): ?>
          <span class="text-green-600 font-semibold">Selesai</span>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</body>
</html>