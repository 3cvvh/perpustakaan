<?php
session_start();
include '../logic/function.php';
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas') {
    header("Location: katalog.php");
    exit;
}
$user = select("SELECT * FROM user");
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Guest';
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
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-8">Welcome to Admin Dashboard <?php echo $admin_name ?></h1>
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
                            <a href="#" class="text-blue-500 hover:underline">Edit</a> |
                            <a href="#" class="text-red-500 hover:underline">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>