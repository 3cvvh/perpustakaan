<?php
include '../logic/function.php';
function lupa($data){
    global $db;
    $email = $data["email"];
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) === 0){
        echo "<script>alert('Email tidak terdaftar!');</script>";
        return false;
    }
    if(mysqli_num_rows($result) > 0){
        return true;
        exit;
    }
}