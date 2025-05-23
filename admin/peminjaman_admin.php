<?php
// Mulai session untuk autentikasi
session_start();
// Import fungsi select data dari database
include '../logic/fungsi_select.php';
// Jika tombol kembalikan ditekan
if (isset($_POST['kembali'])) {
    // Import fungsi kembalikan buku
    include '../logic/fungsi_kembalikan.php';
    $id = $_POST["id"];
    // Jika kembalikan berhasil
    if (kembalikan($id) > 0) {
        echo "<script>alert('Buku berhasil dikembalikan!');</script>";
        echo "<script>location='peminjaman_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengembalikan buku!');</script>";
    }
}
// Cek apakah user sudah login, jika belum redirect ke login
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
// Cek role user, hanya admin/petugas yang boleh akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
    header("Location: katalog.php");
    exit;
}
// Ambil data peminjaman beserta relasi user dan buku
$peminjaman = select("SELECT * FROM peminjaman 
    INNER JOIN user ON peminjaman.UserID = user.UserID 
    INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
");
$user = select("SELECT * FROM user");
$buku = select("SELECT * FROM buku");
// Tambahkan ambil data kategori
$kategori = select("SELECT * FROM kategoribuku");
// Ambil nama admin dari session
$admin_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-50 to-gray-100 min-h-screen text-gray-800">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center h-16 items-center relative">
                <a href="../view/katalog.php" class="flex items-center text-orange-600 font-extrabold text-2xl tracking-wide drop-shadow-lg">
                    <svg class="h-9 w-9 mr-2 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path>
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
                    </svg>
                    Perpustakaan
                </a>
                <div class="hidden sm:-my-px sm:flex space-x-8 absolute left-4">
                    <a href="index.php" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-base font-semibold transition-all duration-200 hover:bg-orange-100">User</a>
                    <a href="peminjaman_admin.php" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-base font-semibold transition-all duration-200 hover:bg-orange-100">Peminjaman</a>
                    <a href="buku.php" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-base font-semibold transition-all duration-200 hover:bg-orange-100">Buku</a>
                    <a href="kategori.php" class="text-gray-700 hover:text-orange-600 px-3 py-2 rounded-md text-base font-semibold transition-all duration-200 hover:bg-orange-100">Kategori</a>
                </div>
                <div class="flex items-center absolute right-4">
                    <span class="hidden sm:block mr-4 text-gray-700 font-medium">Hi, <?php echo $admin_name; ?></span>
                    <a href="../view/destroy.php" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-5 py-2 rounded-lg text-base font-bold shadow transition-all duration-200">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <header class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-orange-600 mb-2 drop-shadow">Data Peminjaman</h1>
        <p class="text-gray-600 text-lg">Kelola dan pantau status peminjaman buku perpustakaan di sini.</p>
    </header>
    <section class="max-w-7xl mx-auto px-4 mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="bg-orange-100 rounded-full p-3 mb-2">
                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m-4-5v9"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold text-gray-800">
                <span id="bukuCount"><?php echo count($buku) ?></span>
            </div>
            <div class="text-gray-500">Total Buku</div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="bg-orange-100 rounded-full p-3 mb-2">
                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 4h6"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold text-gray-800">
                <?php echo count($peminjaman); ?>
            </div>
            <div class="text-gray-500">Total Peminjaman</div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="bg-orange-100 rounded-full p-3 mb-2">
                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold text-gray-800">
                <span id="userCount"><?php echo count($user) ?></span>
            </div>
            <div class="text-gray-500">Total User</div>
        </div>
        <!-- Tambahkan kartu total kategori -->
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="bg-orange-100 rounded-full p-3 mb-2">
                <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
            </div>
            <div class="text-2xl font-bold text-gray-800">
                <span id="kategoriCount"><?php echo count($kategori) ?></span>
            </div>
            <div class="text-gray-500">Total Kategori</div>
        </div>
    </section>
    <div class="max-w-7xl mx-auto px-4 pb-10">
        <div class="overflow-x-auto rounded-xl shadow-lg bg-white">
            <table class="min-w-full bg-white rounded-xl overflow-hidden">
                <thead class="bg-gradient-to-r from-orange-100 to-orange-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-orange-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-orange-700 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-orange-700 uppercase tracking-wider">Tanggal Peminjaman</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-orange-700 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-orange-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-orange-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100">
                    <?php
                    $no = 1;
                    foreach ($peminjaman as $u): ?>
                    <tr class="hover:bg-orange-50 transition-all duration-150">
                        <td class="px-6 py-4 whitespace-nowrap font-semibold"><?php echo $no++?></td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold"><?php echo $u["NamaLengkap"]; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $u["TanggalPeminjaman"]; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $u["Judul"]; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($u["StatusPeminjaman"] === "dipinjam"): ?>
                                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-xs">Belum Dikembalikan</span>
                            <?php else: ?>
                                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs">Dikembalikan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($u["StatusPeminjaman"] == "dipinjam"): ?>
                                <form action="" method="post" >
                                    <input type="hidden" name="id" value="<?= $u['PeminjamanID'] ?>">
                                    <button type="submit" name="kembali" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition-all duration-200 hover:from-red-600 hover:to-red-700">Kembalikan</button>
                                </form>
                            <?php else: ?>
                                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs">Selesai</span>
                            <?php endif; ?>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>