<?php
require '../logic/function.php';
if(isset($_POST["submit"])){
    if(lupa($_POST) == true){
        $email = $_POST["email"];
        header("Location: ganti.php?email=$email");
        exit;
    } elseif(lupa($_POST) == false){
        echo "<script>alert('email salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lupa</title>
</head>
<body>
   <form action="" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit" name="submit">Kirim</button>
   </form>
</body>
</html>