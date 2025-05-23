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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .fade-in {
            animation: fadeIn 1s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .bg-illustration {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png'), linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%);
            background-size: auto, cover;
        }
        /* Hover animation for form card */
        .card-hover {
            transition: transform 0.25s cubic-bezier(.4,2,.6,1), box-shadow 0.25s;
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.025) rotate(-1deg);
            box-shadow: 0 12px 32px 0 rgba(59,130,246,0.18), 0 1.5px 8px 0 rgba(99,102,241,0.10);
        }
        /* Optional: subtle button bounce on hover */
        .btn-animate {
            transition: transform 0.18s cubic-bezier(.4,2,.6,1), box-shadow 0.18s;
        }
        .btn-animate:hover {
            transform: scale(1.07) translateY(-2px);
            box-shadow: 0 6px 18px 0 rgba(59,130,246,0.18);
        }
    </style>
</head>
<body class="bg-illustration min-h-screen flex flex-col">
    <div class="absolute inset-0 pointer-events-none z-0">
        <svg class="absolute right-0 top-0 opacity-20" width="400" height="400" fill="none" viewBox="0 0 400 400">
            <circle cx="320" cy="80" r="120" fill="#3b82f6"/>
        </svg>
        <svg class="absolute left-0 bottom-0 opacity-10" width="300" height="300" fill="none" viewBox="0 0 300 300">
            <circle cx="80" cy="220" r="100" fill="#6366f1"/>
        </svg>
    </div>
    <div class="w-full bg-white shadow mb-10 relative z-10">
        <div class="max-w-2xl mx-auto flex items-center justify-center gap-4 px-4 py-3">
            <div class="flex items-center justify-center bg-blue-100 rounded-full w-16 h-16 border-2 border-blue-300 shadow-lg">
                <img src="img/Logo.png" alt="Logo" class="h-12 w-12 object-contain" />
            </div>
            <span class="font-extrabold text-3xl text-blue-900 tracking-wide drop-shadow">PERPUSTAKAAN DIGITAL</span>
        </div>
    </div>
    <div class="flex-1 flex items-center justify-center relative z-10">
        <form method="post" class="fade-in card-hover bg-white bg-opacity-95 p-10 rounded-3xl shadow-2xl w-full max-w-lg border border-blue-100 ring-2 ring-blue-200/30 backdrop-blur-md">
            <h2 class="text-3xl font-extrabold mb-8 text-blue-800 text-center tracking-tight">Form Peminjaman Buku</h2>
            <?php if(!empty($alert)) echo "<div class='mb-2 text-red-600'>$alert</div>"; ?>
            <div class="mb-8">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <label class="block mb-3 font-semibold text-gray-700 text-lg">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_kembali" required class="border-2 border-blue-200 rounded-xl w-full p-4 text-lg focus:outline-none focus:ring-4 focus:ring-blue-200 transition" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                <p class="text-xs text-gray-500 mt-2">Pilih tanggal pengembalian minimal besok.</p>
            </div>
            <button type="submit" name="submit" class="btn-animate w-full flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                Pinjam Buku
            </button>
        </form>
    </div>
</body>
</html>