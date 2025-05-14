<?php 
include '../logic/function.php';
include '../logic/fungsi_select.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}

$user_id = $_SESSION['UserID'];

$favorit = select("
    SELECT koleksipribadi.KoleksiID, buku.*
    FROM koleksipribadi 
    JOIN buku ON koleksipribadi.BukuID = buku.BukuID
    WHERE koleksipribadi.UserID = $user_id

");

$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Favorit Saya</title>
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
                <a href="koleksi.php" class="text-blue-900 font-semibold border-b-2 border-blue-700 pb-1 transition">Favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">Peminjaman</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">Hi, <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-9 h-9 border" alt="avatar" />
                <a href="destroy.php" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 font-medium transition shadow">Logout</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-8">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2 tracking-wide drop-shadow">Koleksi Favorit Saya</h1>
            <p class="text-gray-600 text-lg">Daftar buku yang telah Anda tambahkan ke favorit. Anda dapat menghapus buku dari koleksi ini kapan saja.</p>
        </div>
        <?php if (count($favorit) > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php foreach($favorit as $b): ?>
                <div class="bg-white p-5 rounded-2xl shadow-xl flex flex-col items-center transition-transform hover:-translate-y-2 hover:shadow-2xl border border-blue-100 group relative overflow-hidden">
                    <div class="relative mb-3">
                        <img src="img/<?= htmlspecialchars($b['Foto']); ?>" alt="<?= htmlspecialchars($b['Judul']); ?>" class="w-28 h-40 object-cover rounded-lg border-2 border-blue-100 shadow-lg transition-transform duration-300 group-hover:scale-105 bg-gray-100" />
                        <span class="absolute top-2 right-2 bg-blue-600 text-white text-xs px-2 py-0.5 rounded shadow font-semibold opacity-90">Favorit</span>
                    </div>
                    <h2 class="font-bold text-center text-blue-900 mb-1 text-base truncate w-full" title="<?= htmlspecialchars($b['Judul']); ?>"><?= htmlspecialchars($b['Judul']); ?></h2>
                    <p class="text-xs text-gray-500 text-center mb-3"><?= htmlspecialchars($b['Penulis']); ?></p>
                    <div class="flex gap-3 mt-auto w-full">
                        <a href="pinjam.php?id_buku=<?= $b['BukuID']; ?>" class="flex-1 bg-gradient-to-r from-blue-700 to-blue-400 text-white px-3 py-1.5 rounded-lg hover:from-blue-800 hover:to-blue-500 text-center font-semibold transition shadow text-xs flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                            Pinjam Buku
                        </a>
                        <a href="hapus_koleksi.php?id=<?= $b['KoleksiID']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="flex-1 bg-gradient-to-r from-red-100 to-red-200 text-red-700 px-3 py-1.5 rounded-lg hover:from-red-200 hover:to-red-300 text-center font-semibold transition shadow border border-red-200 flex items-center justify-center gap-1 text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                            Hapus
                        </a>
                    </div>
                    <div class="absolute inset-0 rounded-2xl border-2 border-blue-400 opacity-0 group-hover:opacity-100 pointer-events-none transition"></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="flex flex-col items-center mt-20">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="Empty" class="w-32 h-32 mb-4 opacity-60">
                <p class="text-gray-600 text-lg text-center">Belum ada buku favorit.<br>Tambahkan buku ke favorit dari halaman katalog.</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="flex-1"></div>
    <footer class="w-full bg-blue-900 text-white text-center py-6 rounded-t-2xl shadow-inner mt-0">
        &copy; 2025 <span class="font-bold">Perpustakaan Digital</span> | Powered by Perpustakaan Digital
    </footer>
</body>
</html>