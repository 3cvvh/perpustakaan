<?php
session_start();
include '../logic/fungsi_hapus_ulasan.php';
include '../logic/function.php';
include '../logic/fungsi_select.php';
include '../logic/fungsi_tambah_ulasan.php';
include '../logic/fungsi_edit_ulasan.php';
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
$alert = '';
if(isset($_POST['submit'])) {
    if (!empty($_POST['ulasan_id'])) {
        // Edit ulasan
        if(edit_ulasan($_POST) > 0) {
            header("Location: pinjam.php?id_buku=" . $_GET['id_buku'] . "&success=3");
            exit;
        } else {
            $alert = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">Ulasan gagal diedit!</div>';
        }
    } else {
        // Tambah ulasan baru
        if(tambah_ulasan($_POST) > 0) {
            header("Location: pinjam.php?id_buku=" . $_GET['id_buku'] . "&success=1");
            exit;
        } else {
            $alert = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">Komentar gagal ditambahkan!</div>';
        }
    }
}
if (isset($_GET['success']) && $_GET['success'] == 3) {
    $alert = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-center">Ulasan berhasil diedit!</div>';
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $alert = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-center">Komentar berhasil ditambahkan!</div>';
}
if (isset($_GET['success']) && $_GET['success'] == 2) {
    $alert = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-center">Ulasan berhasil dihapus!</div>';
}
$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
$id_buku = $_GET["id_buku"];
$kategori = select("SELECT kb.NamaKategori 
    FROM kategoribuku_relasi kr
    JOIN kategoribuku kb ON kr.KategoriID = kb.KategoriID
    WHERE kr.BukuID = $id_buku");
    $data_kate['NamaKategori'] = array_column($kategori, 'NamaKategori');
$data_buku = select("SELECT * FROM buku WHERE BukuID = $id_buku")[0];
$comments = select("SELECT u.UlasanID, u.Ulasan, u.Rating, us.username 
    FROM ulasanbuku u 
    JOIN user us ON u.UserID = us.UserID 
    WHERE u.BukuID = $id_buku
    ORDER BY u.UlasanID DESC");

if(isset($_POST['delete_ulasan'])) {
    $hapus_result = hapus_ulasan($_POST);
    if ($hapus_result > 0){
        $alert = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-center">Ulasan berhasil dihapus!</div>';
        header("Location: pinjam.php?id_buku=" . $_GET['id_buku'] . "&success=2");
        exit;
    } else {
        $alert = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">Ulasan gagal dihapus!</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-30px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.7s cubic-bezier(0.4,0,0.2,1) both;
        }
        .hover-card:hover {
            box-shadow: 0 10px 32px 0 rgba(59,130,246,0.15), 0 1.5px 4px 0 rgba(59,130,246,0.08);
            transform: translateY(-4px) scale(1.03);
            border-color: #2563eb;
        }
        .hover-badge:hover {
            filter: brightness(1.1) drop-shadow(0 2px 6px #60a5fa55);
            transform: scale(1.08);
        }
        .hover-info:hover {
            background: linear-gradient(90deg,#dbeafe 0,#f0f9ff 100%);
            border-color: #60a5fa;
            transform: scale(1.04);
        }
        /* Animasi baru */
        .animate-pop {
            animation: pop 0.4s cubic-bezier(.36,1.64,.44,.98);
        }
        @keyframes pop {
            0% { transform: scale(0.7);}
            80% { transform: scale(1.08);}
            100% { transform: scale(1);}
        }
        .glow-hover:hover {
            box-shadow: 0 0 0 4px #3b82f6, 0 2px 8px 0 #60a5fa55;
            border-color: #3b82f6;
        }
        .star-animate:hover {
            animation: star-bounce 0.5s;
        }
        @keyframes star-bounce {
            0% { transform: scale(1);}
            30% { transform: scale(1.3);}
            60% { transform: scale(0.9);}
            100% { transform: scale(1);}
        }
        /* Hover animasi untuk tombol Pinjam Buku dan Tambah Koleksi */
        .btn-animate {
            transition: transform 0.2s cubic-bezier(.36,1.64,.44,.98), box-shadow 0.2s;
        }
        .btn-animate:hover {
            transform: scale(1.06) translateY(-2px) rotate(-1deg);
            box-shadow: 0 6px 24px 0 #60a5fa44;
            z-index: 1;
        }
        /* Animasi untuk tombol submit ulasan */
        .btn-ulasan-animate {
            transition: transform 0.18s cubic-bezier(.36,1.64,.44,.98), box-shadow 0.18s;
        }
        .btn-ulasan-animate:active,
        .btn-ulasan-animate.sending {
            transform: scale(0.96) rotate(-2deg);
            box-shadow: 0 2px 12px 0 #60a5fa44;
        }
        /* Animasi textarea saat mengetik */
        .textarea-animate:focus {
            box-shadow: 0 0 0 3px #60a5fa55;
            border-color: #2563eb;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        /* Modal styles */
        .modal-bg {
            background: rgba(30,41,59,0.7);
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-img {
            max-width: 90vw;
            max-height: 85vh;
            border-radius: 1rem;
            box-shadow: 0 8px 40px 0 #1e293b88;
            border: 4px solid #fff;
            background: #fff;
            animation: fade-in-down 0.4s;
        }
        .modal-bg[hidden] { display: none !important; }
        .modal-close-btn {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: #fff;
            border-radius: 9999px;
            box-shadow: 0 2px 8px #0002;
            border: none;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 60;
            transition: background 0.2s;
        }
        .modal-close-btn:hover {
            background: #f87171;
            color: #fff;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex flex-col">
    <div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2">
            <div class="flex items-center gap-2">
                <img src="img/Logo.png" alt="Logo" class="h-10 w-10" />
                <span class="font-bold text-lg text-blue-900">PERPUSTAKAAN DIGITAL</span>
            </div>
            <div class="flex gap-8">
                <a href="katalog.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">katalog</a>
                <a href="koleksi.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1 transition">peminjaman</a>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">hi <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-8 h-8 border" alt="avatar" />
                <a href="destroy.php" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">logout</a>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-10 flex flex-col md:flex-row gap-10 flex-1">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full md:w-96 flex flex-col items-center border border-blue-100 hover-card transition duration-300 animate-fade-in-down">
            <img id="coverBuku" src="img/<?= htmlspecialchars($data_buku['Foto']) ?>" alt="<?= htmlspecialchars($data_buku['Judul']) ?>" class="w-44 h-64 object-cover rounded-lg mb-6 border shadow transition-transform duration-300 hover:scale-105 glow-hover cursor-pointer" style="cursor:pointer" />
            <a href="pinjam_buku.php?id=<?php echo $id_buku?>" class="w-full bg-gradient-to-r from-blue-700 to-blue-500 text-white py-2 rounded-lg mb-3 text-center font-semibold hover:from-blue-800 hover:to-blue-600 transition animate-pop btn-animate">Pinjam Buku</a>
            <a href="tambah_koleksi.php?id=<?php echo $id_buku ?>" class="w-full flex items-center justify-center gap-2 border border-blue-700 text-blue-700 py-2 rounded-lg text-center font-semibold hover:bg-blue-50 hover:text-blue-900 transition shadow-sm animate-pop btn-animate">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Tambah ke Koleksi Favorit
            </a>
        </div>
        <div class="flex-1 bg-white rounded-xl shadow-lg p-10 border border-blue-100 hover-card transition duration-300 animate-fade-in-down">
            <?php if(!empty($alert)) echo $alert; ?>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <!-- Badge kategori -->
                    <div class="flex flex-wrap gap-2 mb-2">
                        <?php if(empty($data_kate['NamaKategori'])): ?>
                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold shadow hover-badge transition duration-200 animate-pop">Tidak ada kategori</span>
                        <?php else: ?>
                        <?php foreach($data_kate['NamaKategori'] as $kat): ?>
                            <span class="bg-gradient-to-r from-blue-400 to-blue-700 text-white px-3 py-1 rounded-full text-xs font-semibold shadow hover-badge transition duration-200 animate-pop"><?= htmlspecialchars($kat) ?></span>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <h2 class="text-4xl font-extrabold text-blue-900 mb-1 drop-shadow animate-fade-in-down"><?= htmlspecialchars($data_buku['Judul']) ?></h2>
                    <div class="text-base text-blue-700 mb-3 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/><path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/></svg>
                        <?= htmlspecialchars($data_buku['Penulis']) ?>
                    </div>
                    <div class="text-gray-700 mb-3 transition-opacity duration-700 hover:opacity-80"><?= htmlspecialchars($data_buku['Deskripsi']) ?></div>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-6">
                <div class="border rounded-lg p-4 text-center bg-gradient-to-br from-blue-50 to-blue-100 shadow flex flex-col items-center hover-info transition duration-300 animate-pop">
                    <svg class="w-6 h-6 mb-1 text-blue-400 animate-spin-slow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22h11a2.5 2.5 0 0 0 2.5-2.5V6a2 2 0 0 0-2-2h-1V2h-8v2h-1a2 2 0 0 0-2 2v13.5z"/></svg>
                    <div class="text-xs text-gray-500">Penerbit</div>
                    <div class="font-semibold"><?= htmlspecialchars($data_buku['Penerbit']) ?></div>
                </div>
                <div class="border rounded-lg p-4 text-center bg-gradient-to-br from-blue-50 to-blue-100 shadow flex flex-col items-center hover-info transition duration-300 animate-pop">
                    <svg class="w-6 h-6 mb-1 text-blue-400 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                    <div class="text-xs text-gray-500">Tahun Terbit</div>
                    <div class="font-semibold"><?= htmlspecialchars($data_buku['TahunTerbit']) ?></div>
                </div>
                <div class="border rounded-lg p-4 text-center bg-gradient-to-br from-blue-50 to-blue-100 shadow flex flex-col items-center hover-info transition duration-300 animate-pop">
                    <svg class="w-6 h-6 mb-1 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M8 2v4M16 2v4"/></svg>
                    <div class="text-xs text-gray-500">Halaman</div>
                    <div class="font-semibold"><?= htmlspecialchars($data_buku['halaman']) ?></div>
                </div>
                <div class="border rounded-lg p-4 text-center bg-gradient-to-br from-blue-50 to-blue-100 shadow flex flex-col items-center hover-info transition duration-300 animate-pop">
                    <svg class="w-6 h-6 mb-1 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20l9-5-9-5-9 5 9 5z"/><path d="M12 12V4"/></svg>
                    <div class="text-xs text-gray-500">Kategori</div>
                    <div class="flex flex-wrap gap-1 justify-center">
                        <?php if(empty($data_kate['NamaKategori'])): ?>
                            <span class="bg-gray-200 text-gray-800 px-2 py-0.5 rounded text-xs">Tidak ada kategori</span>
                        <?php else: ?>
                        <?php foreach($data_kate['NamaKategori'] as $kat): ?>
                            <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded text-xs"><?= ($kat) ?></span>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <div class="font-extrabold text-2xl mb-6 text-blue-900 flex items-center gap-2">
                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2"/><rect x="7" y="2" width="10" height="6" rx="2"/></svg>
                    Ulasan & Komentar
                </div>
                <div class="space-y-6 border border-blue-100 rounded-xl bg-blue-50/60 p-6 shadow-inner">
                <?php foreach($comments as $c): ?>
                    <div class="flex items-start gap-4 bg-blue-50 rounded-lg p-4 shadow-sm hover-card transition duration-300 animate-pop">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($c['username']) ?>" class="w-10 h-10 rounded-full border" alt="avatar" />
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-blue-800"><?= htmlspecialchars($c['username']) ?></span>
                                <div class="flex">
                                    <?php foreach(range(1,5) as $i): ?>
                                        <svg class="w-4 h-4 <?= $i <= $c['Rating'] ? 'text-yellow-400' : 'text-gray-300' ?> star-animate transition" fill="currentColor" viewBox="0 0 20 20"><polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36"/></svg>
                                    <?php endforeach; ?>
                                </div>
                                <?php if($c['username'] == $peminjam_name): ?>
                                <form method="post" class="inline">
                                    <input type="hidden" name="ulasan_id" value="<?= $c['UlasanID'] ?>">
                                    <button name="submit_edit" type="button" onclick="editUlasan('<?= htmlspecialchars($c['Ulasan']) ?>', <?= $c['Rating'] ?>, <?= $c['UlasanID'] ?>)" class="text-blue-600 text-xs ml-2 hover:underline">Edit</button>
                                </form>
                                <form method="post" class="inline" onsubmit="return confirmDeleteUlasan(event, this);">
                                    <input type="hidden" name="ulasan_id" value="<?= $c['UlasanID'] ?>">
                                    <button type="submit" name="delete_ulasan" class="text-red-600 text-xs ml-1 hover:underline">Hapus</button>
                                </form>
                                <?php endif; ?>
                            </div>
                            <div class="text-gray-700"><?= htmlspecialchars($c['Ulasan']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <form class="border rounded-xl p-6 mt-8 bg-blue-50 shadow animate-pop" id="commentForm" method="post" action="">
                    <textarea class="w-full border rounded p-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-200 textarea-animate" rows="3" placeholder="Tulis ulasan di sini..." name="komen" id="komenInput"></textarea>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-sm text-gray-500">Rating Anda:</span>
                        <div class="flex gap-1" id="starRating">
                            <?php for($i=1;$i<=5;$i++): ?>
                                <svg data-star="<?= $i ?>" class="w-6 h-6 text-gray-300 hover:text-yellow-400 cursor-pointer star transition star-animate" fill="currentColor" viewBox="0 0 20 20"><polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36"/></svg>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="0" />
                        <input type="hidden" name="ulasan_id" id="ulasanIdInput" value="" />
                    </div>
                    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition animate-pop btn-ulasan-animate" name="submit" id="btnUlasan">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal untuk cover buku -->
    <div id="modalCover" class="modal-bg" hidden>
        <button class="modal-close-btn" id="closeModalCover" aria-label="Tutup">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImgCover" src="img/<?= htmlspecialchars($data_buku['Foto']) ?>" alt="<?= htmlspecialchars($data_buku['Judul']) ?>" class="modal-img" />
    </div>
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
                    <a href="https://sekolah-anda.sch.id/about" target="_blank" class="relative font-semibold text-base px-4 py-1 rounded-full bg-white/10 hover:bg-blue-600/40 transition shadow hover:shadow-lg border border-blue-300/30 hover:border-blue-200 underline underline-offset-4 decoration-blue-200">About</a>
                    <a href="https://sekolah-anda.sch.id" target="_blank" aria-label="Website" class="relative font-semibold text-base px-4 py-1 rounded-full bg-white/10 hover:bg-blue-600/40 transition shadow hover:shadow-lg border border-blue-300/30 hover:border-blue-200">Website</a>
                </div>
                <div class="flex gap-5 mt-1 justify-center">
                    <a href="https://instagram.com/sekolahanda" target="_blank" aria-label="Instagram" class="hover:scale-110 hover:text-pink-400 transition-transform duration-200 bg-white/10 rounded-full p-2 shadow border border-blue-200/30 hover:bg-pink-100/10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" fill="none"/>
                            <circle cx="12" cy="12" r="5" stroke="currentColor" fill="none"/>
                            <circle cx="17" cy="7" r="1.5" fill="currentColor"/>
                        </svg>
                    </a>
                    <a href="https://sekolah-anda.sch.id" target="_blank" aria-label="Website" class="hover:scale-110 hover:text-blue-300 transition-transform duration-200 bg-white/10 rounded-full p-2 shadow border border-blue-200/30 hover:bg-blue-100/10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
    <script>
    // bintang rating
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#starRating .star');
        const ratingInput = document.getElementById('ratingInput');
        let currentRating = 0;

        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', () => {
                highlightStars(idx + 1);
            });
            star.addEventListener('mouseleave', () => {
                highlightStars(currentRating);
            });
            star.addEventListener('click', () => {
                currentRating = idx + 1;
                ratingInput.value = currentRating;
                highlightStars(currentRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach((star, i) => {
                if (i < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Animasi tombol submit saat diklik
        const btnUlasan = document.getElementById('btnUlasan');
        if (btnUlasan) {
            btnUlasan.addEventListener('mousedown', function() {
                btnUlasan.classList.add('sending');
            });
            btnUlasan.addEventListener('mouseup', function() {
                btnUlasan.classList.remove('sending');
            });
            btnUlasan.addEventListener('mouseleave', function() {
                btnUlasan.classList.remove('sending');
            });
        }

        // Animasi textarea saat mengetik
        const komenInput = document.getElementById('komenInput');
        if (komenInput) {
            komenInput.addEventListener('input', function() {
                komenInput.classList.add('textarea-animate');
            });
            komenInput.addEventListener('blur', function() {
                komenInput.classList.remove('textarea-animate');
            });
        }

        // Modal cover buku
        const cover = document.getElementById('coverBuku');
        const modal = document.getElementById('modalCover');
        const modalImg = document.getElementById('modalImgCover');
        const closeModal = document.getElementById('closeModalCover');
        if (cover && modal && modalImg && closeModal) {
            cover.addEventListener('click', function() {
                modal.removeAttribute('hidden');
            });
            closeModal.addEventListener('click', function() {
                modal.setAttribute('hidden', true);
            });
            modal.addEventListener('click', function(e) {
                if (e.target === modal) modal.setAttribute('hidden', true);
            });
            // Optional: close modal with ESC
            document.addEventListener('keydown', function(e) {
                if (!modal.hasAttribute('hidden') && (e.key === 'Escape' || e.key === 'Esc')) {
                    modal.setAttribute('hidden', true);
                }
            });
        }
    });

    // Tambahkan fungsi untuk mengisi form saat klik edit
    function editUlasan(ulasan, rating, ulasanId) {
        document.getElementById('komenInput').value = ulasan;
        document.getElementById('ratingInput').value = rating;
        document.getElementById('ulasanIdInput').value = ulasanId;
        // Highlight bintang sesuai rating
        const stars = document.querySelectorAll('#starRating .star');
        stars.forEach((star, i) => {
            if (i < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    </script>
</body>
</html>