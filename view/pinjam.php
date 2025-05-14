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
$comments = select("SELECT u.UlasanID, u.Ulasan, u.Rating, us.NamaLengkap 
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
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen">
    <div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2">
            <div class="flex items-center gap-2">
                <img src="img/Logo.png" alt="Logo" class="h-10 w-10" />
                <span class="font-bold text-lg text-blue-900">PERPUSTAKAAN DIGITAL</span>
            </div>
            <div class="flex gap-8">
                <a href="katalog.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">katalog</a>
                <a href="koleksi.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">peminjaman</a>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">hi <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-8 h-8 border" alt="avatar" />
                <a href="destroy.php" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">logout</a>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-10 flex flex-col md:flex-row gap-10">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full md:w-96 flex flex-col items-center border border-blue-100">
            <img src="img/<?= htmlspecialchars($data_buku['Foto']) ?>" alt="<?= htmlspecialchars($data_buku['Judul']) ?>" class="w-44 h-64 object-cover rounded-lg mb-6 border shadow" />
            <a href="pinjam_buku.php?id=<?php echo $id_buku?>" class="w-full bg-blue-700 text-white py-2 rounded-lg mb-3 text-center font-semibold hover:bg-blue-800 transition">Pinjam Buku</a>
            <a href="tambah_koleksi.php?id=<?php echo $id_buku ?>" class="w-full flex items-center justify-center gap-2 border border-blue-700 text-blue-700 py-2 rounded-lg text-center font-semibold hover:bg-blue-50 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Tambah ke Koleksi Favorit
            </a>
        </div>
        <div class="flex-1 bg-white rounded-xl shadow-lg p-10 border border-blue-100">
            <?php if(!empty($alert)) echo $alert; ?>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div>
                    <h2 class="text-3xl font-bold text-blue-900 mb-2"><?= htmlspecialchars($data_buku['Judul']) ?></h2>
                    <div class="text-gray-700 mb-3"><?= htmlspecialchars($data_buku['Deskripsi']) ?></div>
                    <div class="text-base text-gray-500 mb-2">Penulis: <span class="font-semibold"><?= htmlspecialchars($data_buku['Penulis']) ?></span></div>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-6">
                <div class="border rounded-lg p-3 text-center bg-blue-50">
                    <div class="text-xs text-gray-500">Penerbit</div>
                    <div class="font-semibold"><?= htmlspecialchars($data_buku['Penerbit']) ?></div>
                </div>
                <div class="border rounded-lg p-3 text-center bg-blue-50">
                    <div class="text-xs text-gray-500">Tahun Terbit</div>
                    <div class="font-semibold"><?= htmlspecialchars($data_buku['TahunTerbit']) ?></div>
                </div>
                <div class="border rounded-lg p-3 text-center bg-blue-50">
                    <div class="text-xs text-gray-500">Halaman</div>
                    <div class="font-semibold"><?= htmlspecialchars($data_buku['halaman']) ?></div>
                </div>
                <div class="border rounded-lg p-3 text-center bg-blue-50">
                    <div class="text-xs text-gray-500">Kategori</div>
                    <div class="flex flex-wrap gap-1 justify-center">
                        <?php foreach($data_kate['NamaKategori'] as $kat): ?>
                            <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded text-xs"><?= ($kat) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <div class="font-bold text-lg mb-4 text-blue-900">Ulasan & Komentar</div>
                <div class="space-y-6">
                <?php foreach($comments as $c): ?>
                    <div class="flex items-start gap-4 bg-blue-50 rounded-lg p-4 shadow-sm">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($c['NamaLengkap']) ?>" class="w-10 h-10 rounded-full border" alt="avatar" />
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-blue-800"><?= htmlspecialchars($c['NamaLengkap']) ?></span>
                                <div class="flex">
                                    <?php foreach(range(1,5) as $i): ?>
                                        <svg class="w-4 h-4 <?= $i <= $c['Rating'] ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20"><polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36"/></svg>
                                    <?php endforeach; ?>
                                </div>
                                <?php if($c['NamaLengkap'] == $peminjam_name): ?>
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
                <form class="border rounded-xl p-6 mt-8 bg-blue-50 shadow" id="commentForm" method="post" action="">
                    <textarea class="w-full border rounded p-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-200" rows="3" placeholder="Tulis ulasan di sini..." name="komen" id="komenInput"></textarea>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-sm text-gray-500">Rating Anda:</span>
                        <div class="flex gap-1" id="starRating">
                            <?php for($i=1;$i<=5;$i++): ?>
                                <svg data-star="<?= $i ?>" class="w-6 h-6 text-gray-300 hover:text-yellow-400 cursor-pointer star transition" fill="currentColor" viewBox="0 0 20 20"><polygon points="10,1 12.59,7.36 19.51,7.36 13.97,11.63 16.56,17.99 10,13.72 3.44,17.99 6.03,11.63 0.49,7.36 7.41,7.36"/></svg>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="0" />
                        <input type="hidden" name="ulasan_id" id="ulasanIdInput" value="" />
                    </div>
                    <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition" name="submit">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-16 w-full bg-blue-900 text-white text-center py-5 rounded-t-xl shadow-inner">
        &copy; 2025 Perpustakaan Digital &mdash; Powered by Perpustakaan Digital
    </div>
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