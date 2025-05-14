<?php
session_start();
include '../logic/function.php';
include '../logic/fungsi_kembalikan.php';
include '../logic/fungsi_select.php';
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
    <title>Riwayat Peminjaman Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex flex-col">
    <div class="w-full bg-white shadow sticky top-0 z-20">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center bg-blue-100 rounded-full w-14 h-14 border border-blue-200 shadow-sm">
                    <img src="img/Logo.png" alt="Logo" class="h-10 w-10 object-contain" />
                </div>
                <span class="font-bold text-2xl text-blue-900 tracking-wide drop-shadow">PERPUSTAKAAN DIGITAL</span>
            </div>
            <div class="flex gap-8">
                <a href="katalog.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">Katalog</a>
                <a href="koleksi.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">Favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-semibold border-b-2 border-blue-700 pb-1 transition">Peminjaman</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">Hi, <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-9 h-9 border" alt="avatar" />
                <a href="destroy.php" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 font-medium transition shadow">Logout</a>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto w-full mt-10 flex-1">
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
            <h2 class="text-2xl font-bold text-blue-900 mb-6 text-center">Riwayat Peminjaman Buku</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden shadow">
                    <thead>
                        <tr class="bg-blue-700 text-white">
                            <th class="px-4 py-2 text-left">Buku</th>
                            <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                            <th class="px-4 py-2 text-left">Tanggal Kembali</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($peminjaman as $i => $p): ?>
                        <tr class="<?= $i % 2 == 0 ? 'bg-white' : 'bg-blue-50' ?> hover:bg-blue-100 transition">
                            <td class="border-t px-4 py-2 flex items-center gap-3">
                                <img src="img/<?= htmlspecialchars($p['Foto']) ?>" alt="<?= htmlspecialchars($p['Judul']) ?>" class="w-10 h-14 object-cover rounded border shadow" />
                                <span class="font-semibold text-blue-900"><?= htmlspecialchars($p['Judul']) ?></span>
                            </td>
                            <td class="border-t px-4 py-2"><?= $p['TanggalPeminjaman'] ?></td>
                            <td class="border-t px-4 py-2"><?= $p['TanggalPengembalian'] ?></td>
                            <td class="border-t px-4 py-2">
                                <?php if($p['StatusPeminjaman'] == 'dipinjam'): ?>
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Dipinjam</span>
                                <?php else: ?>
                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-16 w-full bg-blue-900 text-white text-center py-6 rounded-t-2xl shadow-inner">
        &copy; 2025 <span class="font-bold">Perpustakaan Digital</span> | Powered by Perpustakaan Digital
    </div>
</body>
</html>