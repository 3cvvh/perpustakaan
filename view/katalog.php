<?php
session_start();
include '../logic/function.php';
include '../logic/fungsi_select.php';
include '../logic/fungsi_cari.php';
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$buku = select("
    SELECT buku.*, kategoribuku.NamaKategori 
    FROM buku
    LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
    LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
");
$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
if(isset($_POST["submit"])){
    $buku = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku</title>
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
                <a href="katalog.php" class="text-blue-900 font-semibold border-b-2 border-blue-700 pb-1 transition">Katalog</a>
                <a href="koleksi.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">Favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">Peminjaman</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">Hi, <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-9 h-9 border" alt="avatar" />
                <a href="destroy.php" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 font-medium transition shadow">Logout</a>
            </div>
        </div>
    </div>
    <div class="w-full bg-gradient-to-r from-blue-400 via-blue-200 to-pink-200 py-14 px-8 flex flex-col items-center relative">
        <div class="backdrop-blur-md bg-white/30 rounded-2xl shadow-lg px-8 py-10 flex flex-col items-center max-w-2xl w-full border border-blue-100">
            <h2 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-2 drop-shadow">Satu Halaman Saja</h2>
            <p class="text-blue-800 text-lg md:text-xl mb-6 font-light drop-shadow">Akan membuatmu lebih pintar setiap hari nya</p>
            <form class="w-full max-w-xl flex items-center gap-2" method="post" action="">
                <input type="text" placeholder="Cari buku yang anda sukai..." class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-200 shadow" name="keyword" autocomplete="off" autofocus />
                <button class="bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow" type="submit" name="submit">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Search
                </button>
            </form>
        </div>
    </div>
    <div class="px-8 mt-8">
        <div class="text-2xl font-bold mb-8 text-blue-900 text-center tracking-wide">Katalog Buku</div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8">
        <?php foreach($buku as $b): ?>
            <div class="flex flex-col bg-white shadow-2xl rounded-2xl p-4 h-[320px] border border-blue-200 transition-transform hover:-translate-y-2 hover:shadow-blue-300 group relative overflow-hidden">
                <div class="flex flex-col items-center w-full flex-1">
                    <div class="relative mb-2">
                        <img src="img/<?= htmlspecialchars($b['Foto']); ?>" alt="<?= htmlspecialchars($b['Judul']); ?>" class="w-24 h-32 object-cover rounded-lg border-2 border-blue-100 shadow-lg transition-transform duration-300 group-hover:scale-105 bg-gray-100" />
                        <span class="absolute top-2 left-2 bg-blue-600 text-white text-[11px] px-2 py-0.5 rounded shadow opacity-90 font-semibold"><?= htmlspecialchars($b['NamaKategori']); ?></span>
                    </div>
                    <div class="font-bold text-center mb-1 text-blue-900 text-sm truncate w-full" title="<?= htmlspecialchars($b['Judul']); ?>">
                        <?= htmlspecialchars($b['Judul']); ?>
                    </div>
                </div>
                <div class="flex flex-col w-full mt-auto">
                    <a href="pinjam.php?id_buku=<?= $b["BukuID"] ?>" class="bg-gradient-to-r from-blue-700 to-blue-400 text-white px-3 py-1.5 rounded-lg hover:from-blue-800 hover:to-blue-500 text-center font-semibold transition shadow flex items-center justify-center gap-1 text-xs mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                        Pinjam Buku
                    </a>
                    <a href="tambah_koleksi.php?id=<?= $b["BukuID"] ?>" class="bg-gradient-to-r from-pink-200 to-pink-100 text-pink-700 px-3 py-1.5 rounded-lg hover:from-pink-300 hover:to-pink-200 text-center font-semibold transition shadow border border-pink-200 flex items-center justify-center gap-1 text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                        Tambahkan ke Koleksi
                    </a>
                </div>
                <div class="absolute inset-0 rounded-2xl border-2 border-blue-400 opacity-0 group-hover:opacity-100 pointer-events-none transition"></div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <div class="mt-auto w-full bg-blue-900 text-white text-center py-6 rounded-t-2xl shadow-inner mt-16">
        &copy; 2025 <span class="font-bold">Perpustakaan Digital</span> | Powered by Perpustakaan Digital
    </div>
</body>
</html>