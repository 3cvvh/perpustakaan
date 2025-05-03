<?php 
$id = $_GET["id"];
include '../logic/function.php';
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