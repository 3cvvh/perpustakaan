<?php 
include '../logic/function.php';
function tambah_ulasan($data_post){
    global $db;
    $ulasan = mysqli_real_escape_string($db, $_POST['komen']);
    $rating = intval($_POST['rating']);
    $user_id = $_SESSION["UserID"];
    $buku_id = intval($_GET["id_buku"]);
    $query = "INSERT INTO ulasanbuku (UserID, BukuID, Ulasan, Rating) VALUES ('$user_id', '$buku_id', '$ulasan', '$rating')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}