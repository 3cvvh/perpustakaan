<?php
session_start();
include '../logic/function.php';
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
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
    <!-- Header -->
    <div class="w-full bg-white shadow flex items-center justify-between px-8 py-4">
        <div class="flex items-center gap-2">
            <img src="../assets/logo.png" alt="Logo" class="h-8 w-8" />
            <span class="font-bold text-lg text-blue-900">PERPUSTAKAAN DIGITAL</span>
        </div>
        <div class="flex gap-8">
            <a href="#" class="text-blue-900 font-medium border-b-2 border-blue-700 pb-1">katalog</a>
            <a href="#" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">favorit</a>
            <a href="#" class="text-blue-900 font-medium hover:border-b-2 hover:border-blue-700 pb-1">pinjaman</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-gray-700">hi user019</span>
            <img src="https://ui-avatars.com/api/?name=User019" class="rounded-full w-8 h-8 border" alt="avatar" />
            <button class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700"><a href="destroy.php">logout</a></button>
        </div>
    </div>
    <!-- Banner -->
    <div class="w-full bg-gradient-to-r from-blue-200 to-pink-200 py-12 px-8 flex flex-col items-center relative">
        <h2 class="text-4xl font-light text-white mb-2">Satu halaman saja</h2>
        <p class="text-white text-lg mb-6">akan membuatmu lebih pintar setiap hari nya</p>
        <form class="w-full max-w-xl flex items-center gap-2">
            <input type="text" placeholder="How to make money" class="flex-1 px-4 py-2 rounded border border-gray-300 focus:outline-none" />
            <button class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">Search</button>
        </form>
    </div>
    <!-- Section Fantasy -->
    <div class="px-8 mt-8">
        <div class="text-lg font-semibold mb-4 text-blue-900">Fantasy</div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <!-- Contoh buku, nanti bisa di-loop dari database -->
            <div class="flex flex-col items-center bg-white shadow rounded p-4">
                <img src="cover1.jpg" alt="Buku 1" class="w-28 h-40 object-cover rounded mb-2" />
                <div class="font-medium text-center mb-2">Judul Buku</div>
                <button class="bg-blue-700 text-white px-4 py-1 rounded hover:bg-blue-800 w-full">pinjam</button>
            </div>
            <!-- ... -->
        </div>
    </div>
    <!-- Section Buku Trending -->
    <div class="px-8 mt-10">
        <div class="text-lg font-semibold mb-4 text-blue-900">Buku Trending</div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <div class="flex flex-col items-center bg-white shadow rounded p-4">
                <img src="cover3.jpg" alt="Buku 3" class="w-28 h-40 object-cover rounded mb-2" />
                <div class="font-medium text-center mb-2">Judul Buku</div>
                <button class="bg-blue-700 text-white px-4 py-1 rounded hover:bg-blue-800 w-full">pinjam</button>
            </div>
            <!-- ... -->
        </div>
    </div>
    <!-- Footer -->
    <div class="mt-auto w-full bg-blue-900 text-white text-center py-4">
        &copy; 2025 perpustakaan digital | Powered by perpustakaan digital
        <div class="mt-2 flex justify-center gap-4">
            <a href="#" class="hover:text-blue-300"><i class="fab fa-facebook"></i></a>
            <a href="#" class="hover:text-blue-300"><i class="fab fa-twitter"></i></a>
            <a href="#" class="hover:text-blue-300"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="hover:text-blue-300"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
    <!-- Font Awesome for icons (optional) -->
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
</body>
</html>