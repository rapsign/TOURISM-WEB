<?php
include '../../config/database.php';

// START: Cek apakah metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice_id = $_POST['invoice_id'];

    // START: Hapus data booking dari tabel invoice
    $sql = "DELETE FROM invoice WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $invoice_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Booking berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Terjadi kesalahan saat menghapus booking.';
        $_SESSION['message_type'] = 'danger';
    }

    $stmt->close(); // Tutup statement
    $conn->close(); // Tutup koneksi database

    header('Location: ../pages/booking.php');
    exit();
    // END: Hapus data booking dari tabel invoice
} else {
    header('Location: ../pages/booking.php');
    exit();
    // END: Cek apakah metode request adalah POST
}
?>
