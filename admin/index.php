<?php
session_start();
include '../logic/fungsi_select.php';
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
    header("Location: katalog.php");
    exit;
}
$user = select("SELECT * FROM user");
$admin_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center h-16 items-center relative">
                <a href="#" class="flex items-center text-orange-500 font-bold text-xl">
                    <svg class="h-8 w-8 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path>
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
                    </svg>
                    Perpustakaan
                </a>
                <div class="hidden sm:-my-px sm:flex space-x-8 absolute left-4">
                    <a href="index.php" class="text-gray-700 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium">user</a>
                    <a href="peminjaman_admin.php" class="text-gray-700 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium">peminjaman</a>
                    <a href="buku.php" class="text-gray-700 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium">buku</a>
                </div>
                <div class="flex items-center absolute right-4">
                    <span class="hidden sm:block mr-4 text-gray-600">Hi, <?php echo $admin_name; ?></span>
                    <a href="../view/destroy.php" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-semibold transition">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($user as $u): ?>
                    <tr class="hover:bg-orange-100">
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $u["NamaLengkap"]; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $u["Email"]; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $u["Alamat"]; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="edit.php?id=<?php echo $u["UserID"];?>" class="text-blue-500 hover:underline">Edit</a> |
                            <a href="hapus.php?id=<?php echo $u["UserID"]; ?>" class="text-red-500 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>