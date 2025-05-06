<?php
session_start();
if(isset($_SESSION['role'])){
    if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas'){
        header("Location: index.php");
        exit;
    } elseif($_SESSION['role'] === 'peminjam'){
        header("Location: katalog.php");
        exit;
    }
}
include '../logic/function.php';
if (!isset($_SESSION['lupa'])) $_SESSION['lupa'] = 0;
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result =  mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if($row > 0){
        if(password_verify($password, $row['Password'])){
            $_SESSION['name'] = $row['NamaLengkap'];
            $_SESSION["role"] = $row["role"];
            $_SESSION['login'] = true;
            $_SESSION['UserID'] = $row['UserID'];
            if ($row['role'] === 'admin' || $row['role'] === 'petugas') {
                header("Location: index.php");
            } elseif ($row['role'] === 'peminjam') {
                header("Location: katalog.php");
            }
            exit;
        }
        $error = true;
    } else {
        $error1 = true;
    }
    $_SESSION['lupa']++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#1e1e1e] min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-4xl bg-white/10 rounded-xl overflow-hidden shadow-lg">

        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-cover bg-center" style="background-image: url('https://i.pinimg.com/736x/eb/f6/a7/ebf6a76ade9d70f00ee54b1d4b3e39f6.jpg');">
            <div class="bg-black/60 w-full h-full flex flex-col justify-center items-center p-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 text-center">Perpustakaan Digital</h1>
                <p class="text-white text-center">Buku Gerbang menuju Pengetahuan</p>
            </div>
        </div>
    
        <div class="w-full md:w-1/2 bg-[#c2bab7] flex flex-col justify-center p-8">
            <h2 class="text-2xl font-bold mb-1 text-gray-800">Hello Again!</h2>
            <p class="mb-6 text-gray-600">Welcome Back</p>
            <?php if(isset($error)): ?>
                <div class="mb-2 text-red-600 text-sm">Password salah</div>
            <?php elseif(isset($error1)): ?>
                <div class="mb-2 text-red-600 text-sm">Username tidak terdaftar</div>
            <?php endif; ?>
            <form action="" method="post" class="space-y-4">
                <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 rounded-full bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 rounded-full bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" name="submit" class="w-full py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">Login</button>
            </form>
            <div class="flex justify-between items-center mt-3">
                <div></div>
                <?php if($_SESSION["lupa"] >= 5): ?>
                    <a href="lupa.php" class="text-xs text-gray-600 hover:underline">Forgot Password?</a>
                <?php endif ?>
            </div>
            <p class="mt-6 text-center text-gray-700 text-sm">Don't have an account? <a href="sign.php" class="text-blue-600 hover:underline">Sign up here</a></p>
        </div>
    </div>
</body>
</html>