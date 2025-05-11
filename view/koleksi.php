<?php 
include '../logic/function.php';
include '../logic/fungsi_select.php';
include '../logic/fungsi_hapus_koleksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}
$user_id = $_SESSION['UserID'];
$aduhai = select("SELECT buku.*
FROM koleksipribadi
JOIN buku ON koleksipribadi.BukuID = buku.BukuID
WHERE koleksipribadi.UserID = $user_id;");
$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
if (isset($_GET['koleksi'])) {
    if ($_GET['koleksi'] == 'success') {
        echo "<script>alert('Berhasil menambahkan koleksi');</script>";
    } elseif ($_GET['koleksi'] == 'error') {
        echo "<script>alert('Gagal menambahkan koleksi');</script>";
    }
}
    if (isset($_GET['koleksi'])) {
        if ($_GET['koleksi'] == 'berhasil') {
            echo "<script>alert('Berhasil menghapus koleksi');</script>";
        } elseif ($_GET['koleksi'] == 'gagal') {
            echo "<script>alert('Gagal menghapus koleksi');</script>";
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Koleksi User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <div class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-2">
            <div class="flex items-center gap-2">
                <img src="img/Logo.png" alt="Logo" class="h-16 w-16" />
                <span class="font-bold text-lg text-blue-900">PERPUSTAKAAN DIGITAL</span>
            </div>
            <div class="flex gap-8">
                <a href="katalog.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">katalog</a>
                <a href="koleksi.php" class="text-blue-900 font-medium border-b-2 border-blue-700 pb-1">favorit</a>
                <a href="peminjaman_user.php" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">peminjaman</a>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">hi <?php echo htmlspecialchars($peminjam_name); ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($peminjam_name); ?>" class="rounded-full w-8 h-8 border" alt="avatar" />
                <button class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"><a href="destroy.php">logout</a></button>
            </div>
        </div>
    </div>

    <main class="flex-grow max-w-7xl mx-auto p-4">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Koleksi Favorit Saya</h1>
        <div class="border border-dashed border-gray-400 rounded p-6 text-gray-500">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($aduhai as $item): ?>
                <div class="bg-white rounded shadow p-4 flex flex-col items-center">
                    <img src="img/<?php echo htmlspecialchars($item["Foto"]); ?>" alt="Book Cover" class="w-32 h-40 object-cover mb-4 rounded" />
                    <h2 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($item["Judul"]); ?></h2>
                    <p class="text-gray-600"><?php echo htmlspecialchars($item["Penulis"]); ?></p>
                    <a href="hapus_koleksi.php?id=<?php echo urlencode($item['BukuID']); ?>" class="mt-4 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>
