<?php 
// Ambil id buku dari parameter GET
$id = $_GET["id"];
// Import fungsi hapus buku
include '../logic/fungsi_hapus_buku.php';
// Jika hapus buku berhasil
if(hapus_buku($id) >0){
    echo "<script>
            alert('Data buku berhasil dihapus!');
            document.location.href = 'buku.php';
          </script>";
// Jika hapus buku gagal
} elseif(hapus_buku($id) < 0) {
    echo "<script>
            alert('Data buku gagal dihapus!');
          </script>";
}
?>