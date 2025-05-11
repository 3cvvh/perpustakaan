<?php 
$id = $_GET["id"];
include '../logic/fungsi_hapus.php';
if(hapus($id) >0){
    echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'index.php';
          </script>";
} elseif(hapus($id) < 0) {
    echo "<script>
            alert('Data gagal dihapus!');
          </script>";
}
?>