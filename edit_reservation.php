<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Koneksi ke database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data reservasi berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM reservations WHERE id = $id");
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    $reservation = mysqli_fetch_assoc($result);
    if (!$reservation) {
        die("Data tidak ditemukan.");
    }

    // Update data ketika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        $updateQuery = "UPDATE reservations SET name='$name', email='$email', phone='$phone', date='$date', message='$message' WHERE id=$id";
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: reservasi.php");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: reservasi.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Reservasi</h1>
            <?php if (isset($error)): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Nama</label>
                    <input type="text" name="name" id="name" value="<?php echo $reservation['name']; ?>" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $reservation['email']; ?>" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-medium">Telepon</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $reservation['phone']; ?>" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-medium">Tanggal</label>
                    <input type="date" name="date" id="date" value="<?php echo $reservation['date']; ?>" class="w-full border border-gray-300 rounded-lg p-2">
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700 font-medium">Pesan</label>
                    <textarea name="message" id="message" class="w-full border border-gray-300 rounded-lg p-2"><?php echo $reservation['message']; ?></textarea>
                </div>
                <div class="flex justify-between">
                    <a href="reservasi.php" class="text-gray-700 hover:text-gray-900 underline">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
