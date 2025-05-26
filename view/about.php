<?php
session_start();
$is_logged_in = isset($_SESSION['login']);
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Pengunjung';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Kami</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-blue-700 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Perpustakaan Digital</h1>
            <?php if ($is_logged_in): ?>
                <span class="text-sm">Halo, <?= htmlspecialchars($name); ?>!</span>
            <?php endif; ?>
        </div>
    </header>

    <main class="flex-grow container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-4 text-blue-700">Tentang Kami</h2>
    <p class="text-gray-700 leading-relaxed mb-4">
        Selamat datang di <strong>Perpustakaan Digital</strong> — solusi cerdas untuk membaca, meminjam, dan mengeksplorasi dunia literasi secara online. Kami hadir untuk menghadirkan kemudahan dan kenyamanan dalam mengakses buku dari berbagai kategori, kapan saja dan di mana saja.
    </p>
    <p class="text-gray-700 leading-relaxed mb-4">
        Perpustakaan ini dirancang khusus untuk mendukung proses belajar dan meningkatkan minat baca, baik bagi pelajar, mahasiswa, guru, maupun masyarakat umum. Dengan sistem berbasis web, Anda tidak perlu lagi datang langsung ke perpustakaan untuk meminjam atau mencari buku.
    </p>
    <p class="text-gray-700 leading-relaxed mb-4">
        <strong>Fitur unggulan kami:</strong>
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-6">
        <li>🔍 Menelusuri dan mencari koleksi buku berdasarkan judul, penulis, atau kategori</li>
        <li>📚 Menambahkan buku ke koleksi favorit pribadi</li>
        <li>📝 Memberikan ulasan serta rating buku</li>
        <li>⏳ Meminjam dan mengatur jadwal pengembalian buku secara digital</li>
    </ul>
    <p class="text-gray-700 leading-relaxed">
        Proyek ini dikembangkan oleh aqil, anggono, khaura, dan nafis sebagai bagian dari tugas projek pembuatan website perpustakaan digital, dengan semangat untuk menciptakan inovasi dalam dunia literasi digital. 
        Kami sangat terbuka terhadap kritik dan saran untuk menjadikan platform ini lebih baik.
    </p>
<section class="mt-12">
    <h3 class="text-2xl font-bold text-blue-700 mb-6 text-center">Anggota Kelompok</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition">
            <h4 class="text-lg font-semibold text-gray-800">Muhammad aqil fatahilah</h4>
            <p class="text-gray-600">PM terkeren se alam dunya</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition">
            <h4 class="text-lg font-semibold text-gray-800">Anggono prio kusumo manafe</h4>
            <p class="text-gray-600">Babu nya aqil ganteng</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition">
            <h4 class="text-lg font-semibold text-gray-800">Khaura nazila</h4>
            <p class="text-gray-600">Babu nya aqil ganteng</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition">
            <h4 class="text-lg font-semibold text-gray-800">muhammad nafis faturahman</h4>
            <p class="text-gray-600">Babu nya aqil ganteng</p>
        </div>
    </div>
</section>

    <div class="text-center mt-8">
        <a href="katalog.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            &larr; Kembali ke Beranda
        </a>
    </div>
</main>
    <footer class="bg-blue-800 text-white text-center py-4 mt-10">
        &copy; <?= date('Y'); ?> Perpustakaan Digital. All rights reserved.
    </footer>
</body>
</html>