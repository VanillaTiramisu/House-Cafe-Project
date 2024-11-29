<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Menghubungkan ke database

// Periksa apakah ID tersedia
if (isset($_GET['type']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type'];

    // Query berdasarkan tipe (reservasi atau saran)
    if ($type === 'reservation') {
        $query = "SELECT * FROM reservations WHERE id = $id";
    } elseif ($type === 'suggestion') {
        $query = "SELECT * FROM suggestions WHERE id = $id";
    } else {
        die("Tipe data tidak valid.");
    }

    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data tidak ditemukan.");
    }
} else {
    die("ID tidak valid.");
}

// Jika tombol konfirmasi ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type === 'reservation') {
        $delete_query = "DELETE FROM reservations WHERE id = $id";
    } elseif ($type === 'suggestion') {
        $delete_query = "DELETE FROM suggestions WHERE id = $id";
    }

    if (mysqli_query($conn, $delete_query)) {
        if ($type === 'reservation') {
            header('Location: reservasi.php?status=success&message=Reservasi berhasil dihapus');
        } elseif ($type === 'suggestion') {
            header('Location: saran.php?status=success&message=Saran berhasil dihapus');
        }
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .container h1 {
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }
        .btn-secondary {
            background: #95a5a6;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Konfirmasi Hapus</h1>
    <p>Apakah Anda yakin ingin menghapus data berikut?</p>

    <table>
        <tr>
            <th>Nama:</th>
            <td><?php echo htmlspecialchars($data['name']); ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo htmlspecialchars($data['email']); ?></td>
        </tr>
        <?php if ($type === 'reservation'): ?>
        <tr>
            <th>Tanggal Reservasi:</th>
            <td><?php echo htmlspecialchars($data['date']); ?></td>
        </tr>
        <tr>
            <th>Pesan:</th>
            <td><?php echo htmlspecialchars($data['message']); ?></td>
        </tr>
        <?php elseif ($type === 'suggestion'): ?>
        <tr>
            <th>Saran:</th>
            <td><?php echo htmlspecialchars($data['message']); ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <form method="POST">
        <button type="submit" class="btn btn-danger">Hapus</button>
        <a href="<?php echo ($type === 'reservation') ? 'reservasi.php' : 'saran.php'; ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
