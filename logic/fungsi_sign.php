<?php 
include '../logic/function.php';
function sign($post_data){
    global $db;
    $username = htmlspecialchars($post_data['username']);
    $password = htmlspecialchars($post_data['password']);
    $confirm_password = htmlspecialchars($post_data['confirm_password']);
    $email = htmlspecialchars($post_data['email']);
    $nama_lengkap = htmlspecialchars($post_data['nama_lengkap']);
    $alamat = htmlspecialchars($post_data['alamat']);
    $result = mysqli_query($db, "SELECT username from user where username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if($row) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }
    if($password !== $confirm_password) {
        echo "<script>alert('Password dan Confirm Password tidak sama!');</script>";
        return false;
    }
    $result = mysqli_query($db, "SELECT email from user where email = '$email'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query_insert = "INSERT INTO user VALUES('','$username', '$password', '$email', '$nama_lengkap', '$alamat','peminjam')";
    mysqli_query($db, $query_insert);
    return mysqli_affected_rows($db);
}