<?php
include '../logic/function.php';
if(isset($_POST['submit'])){
    if(sign($_POST) > 0){
        echo "<script>alert('User baru berhasil ditambahkan!');</script>";
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
</head>
<body>
    <h2>Sign Up</h2>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="nama_lengkap">Nama Lengkap:</label><br>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required><br><br>
        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" rows="4" cols="30" required></textarea><br><br>
        <button type="submit" name="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>