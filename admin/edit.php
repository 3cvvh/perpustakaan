<?php
session_start();
include '../logic/fungsi_edit.php';
include '../logic/fungsi_select.php';

$id = $_GET["id"];
$aduh_gantengnya = select("SELECT * FROM user WHERE UserID = $id")[0];

if (isset($_POST["submit"])) {
    if (edit($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
    } elseif (edit($_POST) < 0) {
        echo "<script>
                alert('Data gagal diubah!');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Data User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-orange-200">
        <h1 class="text-3xl font-bold text-orange-600 mb-6 text-center">Edit Data User</h1>
        <form action="" method="post" class="space-y-5">
            <input type="hidden" name="id" value="<?php echo $aduh_gantengnya["UserID"] ?>">

            <div>
                <label class="block text-sm font-semibold text-orange-600 mb-1" for="nama">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="<?php echo $aduh_gantengnya["NamaLengkap"] ?>"
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-4 py-2 border border-orange-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-orange-600 mb-1" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo $aduh_gantengnya["Email"] ?>"
                    placeholder="Masukkan email"
                    class="w-full px-4 py-2 border border-orange-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-orange-600 mb-1" for="alamat">Alamat</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    placeholder="Masukkan alamat lengkap"
                    class="w-full px-4 py-2 border border-orange-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition"
                    required
                ><?php echo $aduh_gantengnya["Alamat"] ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-orange-600 mb-1" for="role">Role</label>
                <select
                    id="role"
                    name="role"
                    class="w-full px-4 py-2 border border-orange-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-500 transition bg-white"
                    required
                >
                    <option name="role" value="<?php echo $aduh_gantengnya["role"]; ?>" disabled selected>
                        <?php echo "Role saat ini: " . $aduh_gantengnya["role"]; ?>
                    </option>
                    <option value="Admin" <?php if($aduh_gantengnya["role"] == "Admin") echo "selected"; ?>>Admin</option>
                    <option value="Petugas" <?php if($aduh_gantengnya["role"] == "Petugas") echo "selected"; ?>>Petugas</option>
                    <option value="Siswa" <?php if($aduh_gantengnya["role"] == "Siswa") echo "selected"; ?>>Siswa</option>
                </select>
            </div>
            <div class="text-center pt-2">
                <button
                    type="submit"
                    name="submit"
                    class="bg-gradient-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 text-white font-bold px-8 py-2 rounded-lg shadow-lg transition duration-300"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</body>
</html>