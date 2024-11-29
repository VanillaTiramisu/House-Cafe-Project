<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Pastikan file ini benar

// Mengambil data reservasi
$reservations = mysqli_query($conn, "SELECT * FROM reservations");

if (!$reservations) {
    die("Query gagal: " . mysqli_error($conn));
}
?>
<?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
<div class="alert <?php echo ($_GET['status'] == 'success') ? 'alert-success' : 'alert-error'; ?>">
    <?php echo htmlspecialchars($_GET['message']); ?>
</div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-4xl font-bold text-black mb-6 text-center">Dashboard Reservasi</h1>
            <h2 class="text-lg font-semibold text-gray-600 mb-4">Daftar Reservasi</h2>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Telepon</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal Reservasi</th>
                        <th class="border border-gray-300 px-4 py-2">Pesan</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($reservations && mysqli_num_rows($reservations) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($reservations)): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['id']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['name']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['email']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['phone']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['date']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['message']; ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                            <a href="edit_reservation.php?id=<?php echo $row['id']; ?>" 
                                class="text-blue-500 hover:underline">Edit</a>
                                |
                            <a href="proses_del.php?type=reservation&id=<?php echo $row['id']; ?>" 
                                class="text-red-500 hover:underline">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="border border-gray-300 px-4 py-2 text-center">
                                Tidak ada data reservasi
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="mt-6 flex justify-between">
            <a href="dashboard.html" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
