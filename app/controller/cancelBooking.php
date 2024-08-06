<?php
include '../config/database.php';

// START: Memeriksa apakah parameter 'invoice_id' ada dalam POST request
if (isset($_POST['invoice_id'])) {
    $invoice_id = intval($_POST['invoice_id']); // Mengambil ID invoice dan memastikan dalam format integer

    // START: Menghapus data invoice dari database
    $sql = "DELETE FROM invoice WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $invoice_id);

    if ($stmt->execute()) {
        $message = "Invoice deleted successfully."; // Pesan sukses
    } else {
        $message = "Error deleting invoice."; // Pesan gagal
    }
    // END: Menghapus data invoice dari database

    $stmt->close(); // Menutup statement
    $conn->close(); // Menutup koneksi database

    // START: Mengalihkan pengguna dan menampilkan pesan
    echo '<script type="text/javascript">';
    echo 'alert("' . addslashes($message) . '");'; 
    echo 'window.location.href = "../../?page=home";';
    echo '</script>';

    exit();
    // END: Mengalihkan pengguna dan menampilkan pesan

} else {
    // START: Menampilkan pesan jika tidak ada ID invoice yang disediakan
    $message = "No invoice ID provided.";
    echo '<script type="text/javascript">';
    echo 'alert("' . addslashes($message) . '");'; 
    echo 'window.location.href = "../../?page=home";';
    echo '</script>';
    exit();
    // END: Menampilkan pesan jika tidak ada ID invoice yang disediakan
}
?>
