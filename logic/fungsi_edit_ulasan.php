<?php
include '../logic/function.php';
function edit_ulasan($data) {
    global $db;
    $ulasan_id = intval($data['ulasan_id']);
    $ulasan = htmlspecialchars($data['komen']);
    $rating = intval($data['rating']);
    $query = "UPDATE ulasanbuku SET Ulasan='$ulasan', Rating=$rating WHERE UlasanID=$ulasan_id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}