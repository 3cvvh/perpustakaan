<?php
include '../logic/function.php';
include '../logic/fungsi_select.php';
function lupa($data){
    global $db;
    $email = $data["email"];
    $result = mysqli_query($db, "SELECT * FROM user WHERE Email = '$email'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}