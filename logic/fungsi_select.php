<?php
include '../logic/function.php';
function select($data){
    global $db;
    $result = mysqli_query($db, $data);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }return $rows;
}
