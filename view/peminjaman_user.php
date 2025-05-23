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
    <div class="w-full bg-white/70 backdrop-blur-md shadow sticky top-0 z-20 border-b border-blue-100">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center bg-blue-100 rounded-full w-14 h-14 border border-blue-200 shadow-sm">
                    <img src="img/Logo.png" alt="Logo" class="h-10 w-10 object-contain" />
                </div>
                <span class="font-bold text-2xl text-blue-900 tracking-wide drop-shadow">PERPUSTAKAAN DIGITAL</span>
            </div>
            <nav class="flex gap-4 md:gap-8">
                <a href="katalog.php"
                   class="relative font-medium px-5 py-2 rounded-xl transition-all duration-200
                          text-blue-900
                          hover:bg-blue-100/80 hover:text-blue-900 hover:shadow-lg hover:scale-105
                          after:absolute after:left-1/2 after:-translate-x-1/2 after:bottom-1 after:w-0 after:h-0.5 after:bg-blue-400 after:rounded-full after:transition-all after:duration-300
                          active:scale-95
                          ">
                    <span class="relative z-10">Katalog</span>
                    <span class="absolute left-1/2 -translate-x-1/2 bottom-0 w-0 group-hover:w-2/3 h-0.5 bg-blue-400 rounded-full transition-all duration-300"></span>
                </a>
                <a href="koleksi.php"
                   class="relative font-medium px-5 py-2 rounded-xl transition-all duration-200
                          text-blue-900
                          hover:bg-pink-100/80 hover:text-pink-700 hover:shadow-lg hover:scale-105
                          after:absolute after:left-1/2 after:-translate-x-1/2 after:bottom-1 after:w-0 after:h-0.5 after:bg-pink-400 after:rounded-full after:transition-all after:duration-300
                          active:scale-95
                          ">
                    <span class="relative z-10">Favorit</span>
                    <span class="absolute left-1/2 -translate-x-1/2 bottom-0 w-0 group-hover:w-2/3 h-0.5 bg-pink-400 rounded-full transition-all duration-300"></span>
                </a>
                <a href="peminjaman_user.php"
                   class="relative font-semibold px-5 py-2 rounded-xl transition-all duration-200
                          text-blue-900 bg-blue-100/80 shadow border-b-2 border-blue-700
                          hover:bg-blue-200/80 hover:text-blue-900 hover:shadow-lg hover:scale-105
                          after:absolute after:left-1/2 after:-translate-x-1/2 after:bottom-1 after:w-0 after:h-0.5 after:bg-blue-700 after:rounded-full after:transition-all after:duration-300
                          active:scale-95
                          ">
                    <span class="relative z-10">Peminjaman</span>
                    <span class="absolute left-1/2 -translate-x-1/2 bottom-0 w-2/3 h-0.5 bg-blue-700 rounded-full transition-all duration-300"></span>
                </a>
            </nav>
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">Hi, <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-9 h-9 border" alt="avatar" />
                <a href="destroy.php"
                   onclick="return confirm('Yakin ingin logout?');"
                   class="bg-red-600 text-white px-4 py-1 rounded transition-all duration-200 shadow
                          hover:bg-red-700 hover:shadow-lg hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-400">
                    Logout
                </a>
            </div>
        </div>
    </div>
    <div class="max-w-6xl mx-auto w-full mt-10 flex-1">
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
            <h2 class="text-2xl font-bold text-blue-900 mb-6 text-center">Riwayat Peminjaman Buku</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden shadow-lg bg-white">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white">
                            <th class="px-6 py-3 text-left font-bold uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-left font-bold uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left font-bold uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left font-bold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($peminjaman as $i => $p): ?>
                        <tr class="<?= $i % 2 == 0 ? 'bg-white' : 'bg-blue-50' ?> transition-all duration-300 hover:bg-blue-100 hover:scale-[1.01] hover:shadow-md group cursor-pointer">
                            <td class="border-t px-6 py-3 flex items-center gap-3">
                                <img src="img/<?= htmlspecialchars($p['Foto']) ?>" alt="<?= htmlspecialchars($p['Judul']) ?>" class="w-12 h-16 object-cover rounded-lg border shadow group-hover:ring-2 group-hover:ring-blue-300 transition-all duration-300" />
                                <span class="font-semibold text-blue-900 group-hover:text-blue-700 transition-colors duration-300"><?= htmlspecialchars($p['Judul']) ?></span>
                            </td>
                            <td class="border-t px-6 py-3 text-gray-700 group-hover:text-blue-800 transition-colors duration-300"><?= $p['TanggalPeminjaman'] ?></td>
                            <td class="border-t px-6 py-3 text-gray-700 group-hover:text-blue-800 transition-colors duration-300"><?= $p['TanggalPengembalian'] ?></td>
                            <td class="border-t px-6 py-3">
                                <?php if($p['StatusPeminjaman'] == 'dipinjam'): ?>
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold shadow-sm group-hover:bg-yellow-200 transition-all duration-300">Dipinjam</span>
                                <?php else: ?>
                                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold shadow-sm group-hover:bg-green-200 transition-all duration-300">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="flex-1"></div>
    <!-- Footer: gunakan hanya satu, versi redesign -->
    <footer class="w-full bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white py-0 border-t-4 border-blue-500 mt-16 shadow-inner animate-fade-in-down relative overflow-hidden">
        <!-- Glassmorphism effect -->
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-800/70 via-blue-700/60 to-blue-900/80 backdrop-blur-md"></div>
        <div class="relative max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8 px-6 py-10 z-10">
            <!-- Left: Logo & Brand -->
            <div class="flex items-center gap-4 mb-6 md:mb-0">
                <div class="bg-white/80 rounded-2xl p-2 shadow-xl border-4 border-blue-400/40 hover:scale-105 transition-transform duration-200">
                    <img src="img/logo smk 7 (2).png" alt="Logo Sekolah" class="h-16 w-16 rounded-2xl object-contain shadow-lg" />
                </div>
                <span class="font-extrabold text-2xl md:text-3xl tracking-wider drop-shadow-lg bg-gradient-to-r from-blue-200 via-blue-100 to-blue-300 bg-clip-text text-transparent">Perpustakaan Digital</span>
            </div>
            <!-- Center: Navigation & Social -->
            <div class="flex flex-col md:items-center gap-4">
                <div class="flex gap-6 mb-2 md:mb-0">
                    <a href="https://sekolah-anda.sch.id/about" target="_blank"
                        class="relative font-semibold text-base px-5 py-2 rounded-xl bg-white/20 hover:bg-blue-700 hover:text-white transition-all duration-300 shadow-lg border border-blue-300/30 hover:border-blue-200 underline underline-offset-4 decoration-blue-200 scale-100 hover:scale-105 active:scale-95">
                        <span class="inline-block transition-transform duration-300 group-hover:translate-x-1">About</span>
                    </a>
                    <a href="https://sekolah-anda.sch.id" target="_blank" aria-label="Website"
                        class="relative font-semibold text-base px-5 py-2 rounded-xl bg-white/20 hover:bg-blue-700 hover:text-white transition-all duration-300 shadow-lg border border-blue-300/30 hover:border-blue-200 scale-100 hover:scale-105 active:scale-95">
                        <span class="inline-block transition-transform duration-300 group-hover:translate-x-1">Website</span>
                    </a>
                </div>
                <div class="flex gap-5 mt-1 justify-center">
                    <a href="https://instagram.com/sekolahanda" target="_blank" aria-label="Instagram"
                        class="group hover:scale-110 transition-transform duration-300 bg-white/20 rounded-full p-2 shadow border border-blue-200/30 hover:bg-pink-100/20 hover:shadow-xl hover:border-pink-300">
                        <svg class="w-8 h-8 transition-colors duration-300 group-hover:text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" fill="none"/>
                            <circle cx="12" cy="12" r="5" stroke="currentColor" fill="none"/>
                            <circle cx="17" cy="7" r="1.5" fill="currentColor"/>
                        </svg>
                    </a>
                    <a href="https://sekolah-anda.sch.id" target="_blank" aria-label="Website"
                        class="group hover:scale-110 transition-transform duration-300 bg-white/20 rounded-full p-2 shadow border border-blue-200/30 hover:bg-blue-100/20 hover:shadow-xl hover:border-blue-300">
                        <svg class="w-8 h-8 transition-colors duration-300 group-hover:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" fill="none"/>
                            <ellipse cx="12" cy="12" rx="4" ry="10" stroke="currentColor" fill="none"/>
                            <line x1="2" y1="12" x2="22" y2="12" stroke="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- Right: Copyright -->
            <div class="text-xs text-blue-100/90 mt-6 md:mt-0 md:text-right w-full md:w-auto font-medium">
                <div class="mb-1">
                    &copy; 2025 <span class="font-bold text-blue-200">Perpustakaan Digital</span>
                </div>
                <span class="opacity-80">Powered by <span class="font-semibold text-blue-200">Perpustakaan Digital</span></span>
            </div>
        </div>
        <!-- Decorative gradient circles -->
        <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-gradient-to-br from-blue-400/30 to-blue-700/10 rounded-full blur-3xl"></div>
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-gradient-to-tr from-blue-300/20 to-blue-900/30 rounded-full blur-2xl"></div>
    </footer>
</body>
</html>