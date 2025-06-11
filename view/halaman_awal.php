<?php 
include_once '../logic/fungsi_select.php';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-200 via-orange-100 to-indigo-300 min-h-screen">
    <!-- Header & Navbar -->
    <header class="bg-white/90 shadow-lg rounded-b-3xl px-8 py-5 flex items-center justify-between sticky top-0 z-10 backdrop-blur">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 shadow">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 17V5a2 2 0 0 0-2-2H6.5A2.5 2.5 0 0 0 4 5.5v14" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="font-extrabold text-2xl text-indigo-700 tracking-wide drop-shadow">PERPUSTAKAAN</span>
        </div>
        <nav class="space-x-6 text-gray-600 font-medium">
            <a href="login.php"
               class="inline-flex items-center gap-2 font-semibold px-7 py-2.5 rounded-full bg-gradient-to-r from-orange-400 via-pink-400 to-indigo-500 text-white shadow-xl border-2 border-white
                      hover:from-indigo-600 hover:to-orange-400 hover:scale-110 hover:shadow-orange-200 hover:text-yellow-100 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-pink-200
                      ring-offset-2 ring-offset-orange-100"
               style="box-shadow: 0 8px 32px 0 rgba(255,140,0,0.15), 0 1.5px 8px 0 rgba(79,70,229,0.10);">
                <svg class="w-6 h-6 text-white opacity-90 drop-shadow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-8 0v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <span class="tracking-wide text-base font-bold drop-shadow">Login</span>
            </a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="flex flex-col md:flex-row items-center justify-between px-8 py-20 max-w-6xl mx-auto">
        <div class="md:w-1/2 mb-12 md:mb-0">
            <h2 class="text-5xl md:text-6xl font-extrabold text-indigo-700 mb-3 drop-shadow-lg">PERPUSTAKAAN DIGITAL</h2>
            <h3 class="text-2xl font-semibold text-orange-400 mb-6">Temukan Buku Favoritmu!</h3>
            <p class="text-gray-700 mb-8 text-lg leading-relaxed">
                Selamat datang di <span class="font-bold text-indigo-600">Perpustakaan Digital</span>. Temukan ribuan koleksi buku, majalah, dan referensi lainnya secara online. Mudah, cepat, dan gratis untuk semua anggota!
            </p>
            <a href="login.php" class="inline-block bg-gradient-to-r from-indigo-500 to-orange-400 hover:from-orange-400 hover:to-indigo-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                Mulai Jelajah
            </a>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <div class="relative group">
                <img src="https://i.pinimg.com/736x/66/67/e1/6667e1dcb4fd59ce21429d2e068200ee.jpg" alt="Perpustakaan" class="rounded-3xl shadow-2xl w-[350px] md:w-[420px] border-4 border-white group-hover:scale-105 transition-transform duration-300">
                <!-- Floating cards (simulasi UI) -->
                <div class="absolute top-4 left-4 bg-white/90 rounded-xl shadow-xl px-5 py-3 flex items-center gap-3 backdrop-blur group-hover:-translate-y-2 transition">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 20h9" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 4v16m0 0H3m9 0a9 9 0 1 0 0-18 9 9 0 0 0 0 18z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-indigo-600 font-semibold text-base">Buku Baru</span>
                </div>
                <div class="absolute bottom-4 right-4 bg-white/90 rounded-xl shadow-xl px-5 py-3 flex items-center gap-3 backdrop-blur group-hover:translate-y-2 transition">
                    <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-yellow-600 font-semibold text-base">Pinjam Sekarang</span>
                </div>
                <!-- Extra visual: floating books -->
                <div class="absolute -top-8 right-10 animate-bounce">
                    <svg class="w-10 h-10 text-orange-300 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="6" width="18" height="12" rx="2" />
                        <path d="M3 6l9 6 9-6" fill="white" fill-opacity="0.5"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Preview Buku Section -->
    <?php
    // Ambil data buku dari database
    $buku = select("SELECT * FROM buku LIMIT 6");
    // Gambar default jika tidak ada cover
    $default_cover = "https://img.freepik.com/free-vector/flat-design-library-concept_23-2149079486.jpg?w=740";
    ?>
    <section class="max-w-6xl mx-auto px-6 py-12">
        <h2 class="text-3xl font-extrabold text-indigo-700 mb-8 text-center drop-shadow-lg tracking-wide">Preview Buku Populer</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            <?php foreach($buku as $b): ?>
            <div class="bg-white/95 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 p-5 flex flex-col items-center group hover:-translate-y-2 border border-orange-100 relative overflow-hidden
                hover:ring-4 hover:ring-orange-200 hover:bg-gradient-to-br hover:from-orange-50 hover:to-indigo-50">
                <div class="w-32 h-48 mb-4 overflow-hidden rounded-xl shadow-lg border-2 border-indigo-100 group-hover:scale-110 transition-transform duration-300 bg-gray-100 relative">
                    <?php
                    $cover = (!empty($b["Foto"]) && file_exists("img/" . $b["Foto"])) ? "img/" . $b["Foto"] : "https://img.freepik.com/free-vector/flat-design-library-concept_23-2149079486.jpg?w=740";
                    ?>
                    <img src="<?php echo $cover; ?>" alt="<?php echo htmlspecialchars($b['Judul']); ?>" class="object-cover w-full h-full group-hover:blur-[1.5px] group-hover:brightness-90 transition-all duration-300">
                    <span class="absolute top-2 left-2 bg-orange-400/90 text-white text-xs font-bold px-2 py-1 rounded shadow group-hover:scale-110 transition-transform">
                        <?php echo isset($b['Kategori']) ? htmlspecialchars($b['Kategori']) : 'Buku'; ?>
                    </span>
                    <!-- Hover overlay effect -->
                    <div class="absolute inset-0 bg-indigo-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <svg class="w-10 h-10 text-orange-400 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-bold text-lg text-indigo-700 mb-1 text-center group-hover:text-orange-500 transition"><?php echo htmlspecialchars($b['Judul']); ?></h3>
                <div class="flex flex-col items-center text-sm mb-2">
                    <span class="text-gray-500 italic">Penulis: <span class="font-semibold text-indigo-600"><?php echo htmlspecialchars($b['Penulis']); ?></span></span>
                    <span class="text-gray-400">Penerbit: <span class="font-medium"><?php echo htmlspecialchars($b['Penerbit']); ?></span></span>
                </div>
                <span class="inline-block bg-gradient-to-r from-orange-100 to-orange-200 text-orange-600 text-xs font-semibold px-3 py-1 rounded-full mb-1 shadow group-hover:scale-110 transition-transform">
                    Terbit: <?php echo htmlspecialchars($b['TahunTerbit']); ?>
                </span>
                <!-- Decorative floating icon on hover -->
                <div class="absolute -top-4 -right-4 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <svg class="w-8 h-8 text-orange-200 animate-spin-slow" fill="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="6" width="18" height="12" rx="2" />
                        <path d="M3 6l9 6 9-6" fill="white" fill-opacity="0.5"/>
                    </svg>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Info Section -->
    <section class="max-w-5xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">
        <div class="bg-white/80 rounded-2xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
            <svg class="w-10 h-10 text-indigo-500 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 20h9" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 4v16m0 0H3m9 0a9 9 0 1 0 0-18 9 9 0 0 0 0 18z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h4 class="font-bold text-lg text-indigo-700 mb-1">Koleksi Lengkap</h4>
            <p class="text-gray-600 text-center">Lebih dari 10.000 buku, majalah, dan referensi digital tersedia untuk Anda.</p>
        </div>
        <div class="bg-white/80 rounded-2xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
            <svg class="w-10 h-10 text-orange-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h4 class="font-bold text-lg text-orange-500 mb-1">Akses Mudah</h4>
            <p class="text-gray-600 text-center">Buka dan pinjam buku kapan saja, di mana saja, langsung dari perangkat Anda.</p>
        </div>
        <div class="bg-white/80 rounded-2xl shadow-lg p-6 flex flex-col items-center hover:shadow-2xl transition">
            <svg class="w-10 h-10 text-indigo-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 8v4l3 3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h4 class="font-bold text-lg text-indigo-500 mb-1">24 Jam</h4>
            <p class="text-gray-600 text-center">Layanan perpustakaan digital tersedia 24 jam nonstop untuk seluruh anggota.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-gray-500 py-8 mt-10">
        &copy; <?php echo date('Y'); ?> <span class="font-semibold text-indigo-600">Perpustakaan Digital</span>. All rights reserved.
    </footer>
</body>
</html>
