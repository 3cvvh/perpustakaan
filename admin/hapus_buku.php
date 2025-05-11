<?php 
$id = $_GET["id"];
include '../logic/fungsi_hapus_buku.php';
if(hapus_buku($id) >0){
    echo "<script>
            alert('Data buku berhasil dihapus!');
            document.location.href = 'buku.php';
          </script>";
} elseif(hapus_buku($id) < 0) {
    echo "<script>
            alert('Data buku gagal dihapus!');
          </script>";
}
?>