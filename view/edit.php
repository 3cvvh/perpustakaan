<?php
session_start();
include '../logic/function.php';
$id = $_GET["id"];
$aduh_gantengnya = select("SELECT * FROM user WHERE UserID = $id")[0];
if(isset($_POST["submit"])){
    if(edit($_POST) > 0){
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
    } elseif(edit($_POST) < 0) {
        echo "<script>
                alert('Data gagal diubah!');
              </script>";
    }
}
var_dump($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit page</title>
</head>
<body>
    <form action="" method="post">
        <label>Nama Lengkap</label><br>
        <input type="hidden" name="id" value="<?php echo $aduh_gantengnya["UserID"] ?>">
        <input type="text" name="nama" value="<?php echo $aduh_gantengnya["NamaLengkap"]  ?>"><br><br>
        <label>Email</label><br>
        <input type="email" name="email" value="<?php echo $aduh_gantengnya["Email"] ?>"><br><br>
        <label>Alamat</label><br>
        <textarea name="alamat"><?php echo $aduh_gantengnya["Alamat"] ?></textarea><br><br>
        <button type="submit" name="submit">Simpan</button>
    </form>
</body>
</html>