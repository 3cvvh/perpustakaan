<?php
include '../logic/function.php';
include '../logic/fungsi_select.php';
$email = $_GET['email'];
$result = mysqli_query($db, "SELECT * FROM user WHERE Email = '$email'");
$nick = mysqli_fetch_assoc($result);
if(isset($_POST["submit"])){
    $password = htmlspecialchars($_POST["password"]);
    $confirm_password = htmlspecialchars($_POST["confirm_password"]);
    if($password === $nick["Password"]){
        echo "<script>alert('Password tidak boleh sama dengan password sebelumnya!');</script>";
    }
    if($password !== $confirm_password){
        echo "<script>alert('Password dan Confirm Password tidak sama!');</script>";
    }
    if($password === $confirm_password && $password !== $nick["Password"]){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET password = '$password' WHERE Email = '$email'";
        mysqli_query($db, $query);
        echo "<script>alert('Password berhasil diubah!');</script>";
        header("location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <h1><?php echo $nick["Username"] ?></h1>
    <form action="" method="post">
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <button type="submit" name="submit">Ganti</button>
    </form>
</body>
</html>