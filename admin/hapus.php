<?php 
// Ambil id user dari parameter GET
$id = $_GET["id"];
// Import fungsi hapus user
include '../logic/fungsi_hapus.php';
// Jika hapus berhasil
if(hapus($id) >0){
    echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'index.php';
          </script>";
// Jika hapus gagal
} elseif(hapus($id) < 0) {
    echo "<script>
            alert('Data gagal dihapus!');
          </script>";
}
?>