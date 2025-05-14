<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "perpus_chan";
// Create connection
$db  = mysqli_connect($server,$username,$password,$database);
// Check connection
if (!$db) {
    echo"apalah ini";
}


?>