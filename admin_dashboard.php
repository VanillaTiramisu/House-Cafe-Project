<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Menghubungkan ke database

// Mengambil data reservasi
$reservations = mysqli_query($conn, "SELECT * FROM reservations");
$suggestions = mysqli_query($conn, "SELECT * FROM suggestions");

if (isset($_GET['delete_reservation'])) {
    $id = $_GET['delete_reservation'];
    mysqli_query($conn, "DELETE FROM reservations WHERE id = $id");
    header('Location: admin_dashboard.php');
}

if (isset($_GET['delete_suggestion'])) {
    $id = $_GET['delete_suggestion'];
    mysqli_query($conn, "DELETE FROM suggestions WHERE id = $id");
    header('Location: admin_dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Dashboard Admin</h1>
    
    <h2>Reservasi</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Tanggal Reservasi</th>
            <th>Pesan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($reservations)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td>
            <a href="admin_dashboard.php?delete_reservation=<?php echo $row['id']; ?>">Hapus</a>
            <a href="edit_reservation.php?id=<?php echo $row['id']; ?>">Edit</a>
            </td>

            
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Saran</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Saran</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($suggestions)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td>
            <a href="admin_dashboard.php?delete_suggestion=<?php echo $row['id']; ?>">Hapus</a>
            <a href="edit_suggestion.php?id=<?php echo $row['id']; ?>">Edit</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div>
        <a href="admin_logout.php">Logout</a>
    </div>
</body>
</html>