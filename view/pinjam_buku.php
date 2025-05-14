<?php
session_start();
include '../logic/function.php';
include '../logic/fungsi_peminjaman.php';
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
$id = $_GET["id"];
$user_id = $_SESSION["UserID"];
if(isset($_POST["submit"])){
    if(peminjaman($id, $user_id) > 0){
        echo "<script>
                alert('Buku berhasil dipinjam!');
                document.location.href = 'peminjaman_user.php';
              </script>";
    } elseif(peminjaman($id, $user_id) < 0) {
        echo "<script>
                alert('Buku gagal dipinjam!');
              </script>";
    }
}
 ?>
 <!DOCTYPE html>
<html>
<head>
    <title>Form Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex flex-col">
    <div class="w-full bg-white shadow mb-10">
        <div class="max-w-2xl mx-auto flex items-center justify-center gap-4 px-4 py-3">
            <div class="flex items-center justify-center bg-blue-100 rounded-full w-14 h-14 border border-blue-200 shadow-sm">
                <img src="img/Logo.png" alt="Logo" class="h-10 w-10 object-contain" />
            </div>
            <span class="font-bold text-2xl text-blue-900 tracking-wide">PERPUSTAKAAN DIGITAL</span>
        </div>
    </div>
    <div class="flex-1 flex items-center justify-center">
        <form method="post" class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-blue-100">
            <h2 class="text-2xl font-bold mb-6 text-blue-900 text-center">Form Peminjaman Buku</h2>
            <?php if(!empty($alert)) echo "<div class='mb-2 text-red-600'>$alert</div>"; ?>
            <div class="mb-6">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <label class="block mb-2 font-medium text-gray-700">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_kembali" required class="border rounded-lg w-full p-3 focus:outline-none focus:ring-2 focus:ring-blue-200" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                <p class="text-xs text-gray-500 mt-1">Pilih tanggal pengembalian minimal besok.</p>
            </div>
            <button type="submit" name="submit" class="w-full flex items-center justify-center gap-2 bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Pinjam Buku
            </button>
        </form>
    </div>
</body>
</html>