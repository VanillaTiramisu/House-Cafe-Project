<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include 'db.php'; // Menghubungkan ke database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Eksekusi query untuk menghapus data
    $query = "DELETE FROM reservations WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: reservasi.php?status=success&message=Reservasi berhasil dihapus');
        exit();
    } else {
        header('Location: reservasi.php?status=error&message=Terjadi kesalahan saat menghapus reservasi');
        exit();
    }
} else {
    header('Location: reservasi.php?status=error&message=ID tidak valid');
    exit();
}
?>
