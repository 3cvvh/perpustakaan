<?php
$db  = mysqli_connect('localhost', 'root', '', 'perpus_chan');
function sign($post_data){
    global $db;
    $username = htmlspecialchars($post_data['username']);
    $password = htmlspecialchars($post_data['password']);
    $confirm_password = htmlspecialchars($post_data['confirm_password']);
    $email = htmlspecialchars($post_data['email']);
    $nama_lengkap = htmlspecialchars($post_data['nama_lengkap']);
    $alamat = htmlspecialchars($post_data['alamat']);
    $result = mysqli_query($db, "SELECT username from user where username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if($row) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }
    if($password !== $confirm_password) {
        echo "<script>alert('Password dan Confirm Password tidak sama!');</script>";
        return false;
    }
    $result = mysqli_query($db, "SELECT email from user where email = '$email'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query_insert = "INSERT INTO user VALUES('','$username', '$password', '$email', '$nama_lengkap', '$alamat','peminjam')";
    mysqli_query($db, $query_insert);
    return mysqli_affected_rows($db);
}
function lupa($data){
    global $db;
    $email = $data["email"];
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) === 0){
        echo "<script>alert('Email tidak terdaftar!');</script>";
        return false;
    }
    if(mysqli_num_rows($result) > 0){
        return true;
        exit;
    }
}
function select($data){
    global $db;
    $result = mysqli_query($db, $data);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }return $rows;
}
function edit($data_post){
    global $db;
    $id = $data_post["id"];
    $nama_lengkap = $data_post["nama"];
    $email = $data_post["email"]; 
    $alamat = $data_post["alamat"];
    $query = "UPDATE user SET NamaLengkap = '$nama_lengkap', Email = '$email', Alamat = '$alamat' WHERE UserID = $data_post[id]";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
    }
function hapus($id){
    global $db;
    mysqli_query($db, "DELETE from ulasanbuku where UserID = $id");
    mysqli_query($db, "DELETE from user where UserID = $id");
    return mysqli_affected_rows($db);
    }
    function tambah_buku($data_post){
        global $db;
        $judul = htmlspecialchars($data_post["Judul"]);
        $pengarang = htmlspecialchars($data_post["Penulis"]);
        $penerbit = htmlspecialchars($data_post["Penerbit"]);
        $tahun = htmlspecialchars($data_post["TahunTerbit"]);
        $halaman = htmlspecialchars($data_post["Halaman"]);
        $kategori_id = intval($data_post["KategoriID"]);
        $uploud_gambar = uploud($_FILES);
        $deskripsi = htmlspecialchars($data_post["Deskripsi"]);
        if(!$uploud_gambar){
            return false;
        }
        // Insert buku
        $query = "INSERT INTO buku VALUES('','$judul','$halaman','$pengarang','$penerbit','$tahun','$uploud_gambar','$deskripsi')";
        mysqli_query($db, $query);
    
        // Ambil ID buku terakhir yang baru dimasukkan
        $buku_id = mysqli_insert_id($db);
    
        $query_relasi = "INSERT INTO kategoribuku_relasi (KategoriID, BukuID) VALUES ('$kategori_id', '$buku_id')";
        mysqli_query($db, $query_relasi);
    
        return mysqli_affected_rows($db);
    }
    function uploud($gambar){
        $nama_gambar = $gambar["Foto"]["name"];
        $lokasi_gambar = $gambar["Foto"]["tmp_name"];
        $error = $gambar["Foto"]["error"];
        $ukuran_gambar = $gambar["Foto"]["size"];
        $gambar_valid = ['jpg','jfif','png','jpeg'];
        $ekstensi_gambar = explode('.',$nama_gambar);
        $ekstensi_gambar = strtolower(end($ekstensi_gambar));
        if(!in_array($ekstensi_gambar, $gambar_valid)){
            echo "<script>alert('yang anda uploud bukan gambar!');</script>";
            return false;
        }
        $nama_gambar_baru = uniqid();
        $nama_gambar_baru .= '.';
        $nama_gambar_baru .= $ekstensi_gambar;
        move_uploaded_file($lokasi_gambar, 'img/' . $nama_gambar_baru);
        return $nama_gambar_baru;
    }
    function hapus_buku($id){
        global $db;
        mysqli_query($db, "DELETE FROM ulasanbuku WHERE BukuID = $id");
        // Hapus relasi kategori
        mysqli_query($db, "DELETE FROM kategoribuku_relasi WHERE BukuID = $id");
        // Baru hapus buku
        mysqli_query($db, "DELETE FROM buku WHERE BukuID = $id");
      
        return mysqli_affected_rows($db);
    }
    function cari($keyword){
        $query =  "SELECT buku.*, kategoribuku.NamaKategori 
        FROM buku
        LEFT JOIN kategoribuku_relasi ON buku.BukuID = kategoribuku_relasi.BukuID
        LEFT JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.KategoriID
        WHERE buku.Judul LIKE '%$keyword%'
        OR buku.Penulis LIKE '%$keyword%'
        OR buku.Penerbit LIKE '%$keyword%'
        OR kategoribuku.NamaKategori LIKE '%$keyword%'";
        return select($query);
    }
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
    function edit_buku($data_post){
        global $db;
        $id = intval($data_post["id"]);
        $judul = htmlspecialchars($data_post["Judul"]);
        $pengarang = htmlspecialchars($data_post["Penulis"]);
        $penerbit = htmlspecialchars($data_post["Penerbit"]);
        $tahun = htmlspecialchars($data_post["TahunTerbit"]);
        $halaman = htmlspecialchars($data_post["Halaman"]);
        $kategori_id = intval($data_post["KategoriID"]);
        $deskripsi = htmlspecialchars($data_post["Deskripsi"]);
        $foto_lama = htmlspecialchars($data_post["Foto_lama"]);
        $error_upload = $_FILES['Foto']['error'];
        if($error_upload === 4){
            // Jika tidak ada gambar yang diupload, gunakan gambar lama
            $uploud_gambar = $foto_lama;
        }else{
            $uploud_gambar = uploud($_FILES);
            if(!$uploud_gambar){
                // Jika upload gagal, gunakan gambar lama
                $uploud_gambar = $foto_lama;
            }
        }
        // Update buku
        $query = "UPDATE buku SET Judul='$judul', Halaman='$halaman', Penulis='$pengarang', Penerbit='$penerbit', TahunTerbit='$tahun', Foto='$uploud_gambar', Deskripsi='$deskripsi' WHERE BukuID=$id";
        $result = mysqli_query($db, $query);
        if(!$result){
            // Debug error jika query gagal
            die('Query Error: '.mysqli_error($db));
        }
    
        // Update relasi kategori
        $result_relasi = mysqli_query($db, "UPDATE kategoribuku_relasi SET KategoriID=$kategori_id WHERE BukuID=$id");
        if(!$result_relasi){
            die('Relasi Error: '.mysqli_error($db));
        }
    
        return mysqli_affected_rows($db);
    }
?>