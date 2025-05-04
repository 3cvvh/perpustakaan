<?php
include '../logic/function.php';
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
</head>
<body class="bg-[#1e1e1e] min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-4xl bg-white/10 rounded-xl overflow-hidden shadow-lg">
        <!-- Left: Image & Title -->
        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=800&q=80');">
            <div class="bg-black/60 w-full h-full flex flex-col justify-center items-center p-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 text-center">Perpustakaan Digital</h1>
                <p class="text-white text-center">Buku adalah jendela pendidikan</p>
            </div>
        </div>
        <!-- Right: Register Form -->
        <div class="w-full md:w-1/2 bg-[#ededed] flex flex-col justify-center p-8">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Hello!</h2>
            <p class="mb-6 text-gray-500">Sign Up to Get Started</p>
            <form action="" method="post" class="space-y-4">
                <input type="text" name="nama_lengkap" placeholder="Full Name" required class="w-full px-4 py-2 rounded-full bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="email" name="email" placeholder="Email Address" required class="w-full px-4 py-2 rounded-full bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 rounded-full bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 rounded-full bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full px-4 py-2 rounded-full bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="text" name="alamat" placeholder="Alamat" required class="w-full px-4 py-2 rounded-full bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" name="submit" class="w-full py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">Register</button>
            </form>
            <p class="mt-4 text-center text-gray-600">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a></p>
        </div>
    </div>
</body>
</html>