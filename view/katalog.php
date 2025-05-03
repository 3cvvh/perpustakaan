<?php
session_start();
include '../logic/function.php';
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
<body class="bg-white min-h-screen flex flex-col">
    <div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2">
            <div class="flex items-center gap-2">
                <img src="img/Logo.png" alt="Logo" class="h-16 w-16" />
                <span class="font-bold text-lg text-blue-900">PERPUSTAKAAN DIGITAL</span>
            </div>
            <div class="flex gap-8">
                <a href="#" class="text-blue-900 font-medium border-b-2 border-blue-700 pb-1">katalog</a>
                <a href="#" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">favorit</a>
                <a href="#" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">pinjaman</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">hi <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-8 h-8 border" alt="avatar" />
                <button class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"><a href="destroy.php">logout</a></button>
            </div>
        </div>
    </div>
    <div class="w-full bg-gradient-to-r from-blue-200 to-pink-200 py-12 px-8 flex flex-col items-center relative">
        <h2 class="text-4xl font-light text-white mb-2">Satu halaman saja</h2>
        <p class="text-white text-lg mb-6">akan membuatmu lebih pintar setiap hari nya</p>
        <form class="w-full max-w-xl flex items-center gap-2" method="post" action="">
            <input type="text" placeholder="Cari buku yang anda sukai..." class="flex-1 px-4 py-2 rounded border border-gray-300 focus:outline-none" name="keyword" autocomplete="off" autofocus />
            <button class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800" type="submit" name="submit">Search</button>
        </form>
    </div>
    <div class="px-8 mt-8">
        <div class="text-lg font-semibold mb-4 text-blue-900"></div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        <?php foreach($buku as $b): ?>
<div class="flex flex-col justify-between items-center bg-white shadow rounded p-4 h-full min-h-[320px]">
    <div class="flex flex-col items-center w-full">
        <img src="img/<?= htmlspecialchars($b['Foto']); ?>" alt="<?= htmlspecialchars($b['Judul']); ?>" class="w-28 h-40 object-cover rounded mb-2" />
        <div class="font-medium text-center mb-1"><?= htmlspecialchars($b['Judul']); ?></div>
        <div class="text-xs text-gray-500 mb-2"><?= htmlspecialchars($b['NamaKategori']); ?></div>
    </div>
    <a href="pinjam.php?id_buku=<?php echo $b["BukuID"] ?>" class="bg-blue-700 text-white px-4 py-1 rounded hover:bg-blue-800 w-full mt-4 text-center block">pinjam</a>
</div>
<?php endforeach; ?>
</div>
        </div>
    </div>
    <div class="mt-auto w-full bg-blue-900 text-white text-center py-4">
        &copy; 2025 perpustakaan digital | Powered by perpustakaan digital
    </div>
</body>
</html>