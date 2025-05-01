<?php
session_start();
include '../logic/function.php';
if (!isset($_SESSION['lupa'])) {
    $_SESSION['lupa'] = 0;
}
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        if(password_verify($password, $row['password'])){
            $_SESSION['admin_name'] = $row['username'];
            $_SESSION["role"] = $row["role"];
            if ($row['role'] === 'admin') {
                $_SESSION['login'] = true;
                header("Location: index.php"); // Redirect ke halaman admin
            } elseif ($row['role'] === 'petugas') {
                $_SESSION['login'] = true;
                header("Location: index.php"); // Redirect ke halaman petugas
            } elseif ($row['role'] === 'peminjam') {
                $_SESSION['login'] = true;
                header("Location: katalog.php"); // Redirect ke halaman peminjam
            }
            exit;
        }
       $error=true;
    } $error1=true;
    $_SESSION['lupa']++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
<?php
if(isset($error)){
    echo 'password salah';
}elseif(isset($error1)){
    echo 'username tidak terdaftar';
}
?>
    <h1>Welcome to the Login Page</h1>
    <h2>Login</h2>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="sign.php">Sign up here</a></p>
    <?php if($_SESSION["lupa"] >= 5): ?>
        <p><a href="lupa.php">lupa password?</a></p>
    <?php endif ?>
</body>
</html>