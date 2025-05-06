<?php
session_start();
include '../logic/function.php';
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
                document.location.href = 'katalog.php';
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
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <form method="post" class="bg-white p-8 rounded shadow w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Form Peminjaman Buku</h2>
        <?php if(!empty($alert)) echo "<div class='mb-2 text-red-600'>$alert</div>"; ?>
        <div class="mb-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <label class="block mb-1">Tanggal Pengembalian</label>
            <input type="date" name="tanggal_kembali" required class="border rounded w-full p-2" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
        </div>
        <button type="submit" name="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">Pinjam Buku</button>
    </form>
</body>
</html>