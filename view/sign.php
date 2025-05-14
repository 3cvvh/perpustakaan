<?php
include '../logic/function.php';
include '../logic/fungsi_sign.php';
if(isset($_POST['submit'])){
    if(sign($_POST) > 0){
        echo "<script>alert('User baru berhasil ditambahkan!');window.location='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('User baru gagal ditambahkan!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"/>
    <style>
        .glass {
            background: rgba(255,255,255,0.15);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.18);
        }
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translatey(0px);}
            50% { transform: translatey(-15px);}
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#232526] via-[#414345] to-[#232526] min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-4xl glass rounded-3xl overflow-hidden shadow-2xl border border-white/20 animate-fade-in">
        <!-- Left: Image & Title -->
        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=800&q=80');">
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative z-10 flex flex-col justify-center items-center p-10">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Logo" class="w-20 h-20 mb-4 floating drop-shadow-lg">
                <h1 class="text-4xl font-extrabold text-white mb-2 text-center drop-shadow-lg tracking-wide">Perpustakaan Digital</h1>
                <p class="text-white text-lg text-center font-medium mb-4">Buku adalah jendela pendidikan</p>
            </div>
        </div>
        <!-- Right: Register Form -->
        <div class="w-full md:w-1/2 bg-white/80 flex flex-col justify-center p-10 relative">
            <div class="absolute top-4 right-4">
                <svg class="w-8 h-8 text-blue-600 animate-spin-slow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-dasharray="40 40" /></svg>
            </div>
            <h2 class="text-3xl font-extrabold mb-2 text-gray-800 tracking-tight">Buat Akun Baru</h2>
            <p class="mb-6 text-gray-600 text-base">Daftar untuk mulai menjelajah koleksi buku digital kami.</p>
            <form action="" method="post" class="space-y-5 mt-2">
                <div class="relative">
                    <input type="text" name="nama_lengkap" placeholder="Full Name" required class="w-full px-12 py-3 rounded-full bg-gray-200/90 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition placeholder-gray-400 text-gray-800 font-medium">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </span>
                </div>
                <div class="relative">
                    <input type="email" name="email" placeholder="Email Address" required class="w-full px-12 py-3 rounded-full bg-gray-200/90 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition placeholder-gray-400 text-gray-800 font-medium">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </span>
                </div>
                <div class="relative">
                    <input type="text" name="username" placeholder="Username" required class="w-full px-12 py-3 rounded-full bg-gray-200/90 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition placeholder-gray-400 text-gray-800 font-medium">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 01-8 0"></path><circle cx="12" cy="7" r="4"></circle><path d="M6 21v-2a4 4 0 014-4h0a4 4 0 014 4v2"></path></svg>
                    </span>
                </div>
                <div class="relative">
                    <input type="password" name="password" placeholder="Password" required class="w-full px-12 py-3 rounded-full bg-gray-200/90 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition placeholder-gray-400 text-gray-800 font-medium">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-2V9a6 6 0 10-12 0v6a2 2 0 002 2h8a2 2 0 002-2z"></path></svg>
                    </span>
                </div>
                <div class="relative">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full px-12 py-3 rounded-full bg-gray-200/90 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition placeholder-gray-400 text-gray-800 font-medium">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-2V9a6 6 0 10-12 0v6a2 2 0 002 2h8a2 2 0 002-2z"></path></svg>
                    </span>
                </div>
                <div class="relative">
                    <input type="text" name="alamat" placeholder="Alamat" required class="w-full px-12 py-3 rounded-full bg-gray-200/90 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition placeholder-gray-400 text-gray-800 font-medium">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243a1 1 0 001.414-1.414z"></path><circle cx="10.5" cy="10.5" r="7.5"></circle></svg>
                    </span>
                </div>
                <button type="submit" name="submit" class="w-full py-3 rounded-full bg-gradient-to-r from-blue-600 to-blue-400 text-white font-bold text-lg shadow-lg hover:from-blue-700 hover:to-blue-500 transition-all duration-200 transform hover:scale-105">Register</button>
            </form>
            <p class="mt-8 text-center text-gray-700 text-sm">Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline font-semibold">Login di sini</a></p>
            <div class="flex justify-center mt-6">
                <span class="text-xs text-gray-400">© <?= date('Y') ?> Perpustakaan Digital</span>
            </div>
        </div>
    </div>
    <script>
        // Fade-in animation
        document.querySelector('.animate-fade-in')?.classList.add('opacity-0');
        setTimeout(() => {
            document.querySelector('.animate-fade-in')?.classList.remove('opacity-0');
            document.querySelector('.animate-fade-in')?.classList.add('transition-opacity', 'duration-700', 'opacity-100');
        }, 100);
    </script>
</body>
</html>