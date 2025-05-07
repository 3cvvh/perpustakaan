<?php 
include '../logic/function.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: view/login.php");
    exit;
}
$user_id = $_SESSION['UserID'];
$babi = select("SELECT * FROM koleksipribadi WHERE UserID=$user_id");
$peminjam_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>koleksi_user</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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
                <span class="text-gray-700">hi <?php echo $peminjam_name; ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo $peminjam_name; ?>" class="rounded-full w-8 h-8 border" alt="avatar" />
                <button class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"><a href="destroy.php">logout</a></button>
            </div>
        </div>
    </div>
</body>
</html>