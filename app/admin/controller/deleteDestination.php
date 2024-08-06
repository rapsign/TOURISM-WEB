<?php
include '../../config/database.php';
session_start(); 

// START: Cek apakah parameter 'id' ada di query string
if (!isset($_POST['id'])) {
    $_SESSION['message'] = 'Invalid request.';
    header("Location: ../pages/destination.php"); 
    exit();
}
// END: Cek apakah parameter 'id' ada di query string

$id = $_POST['id'];

// START: Hapus gambar terkait dari sistem file
$sql = "SELECT images FROM destination_images WHERE destination_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = "../../../public/assets/images/destinations/" . $row['images'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
// END: Hapus gambar terkait dari sistem file

// START: Hapus data gambar dari database
$sql = "DELETE FROM destination_images WHERE destination_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
// END: Hapus data gambar dari database

// START: Hapus data destinasi dari database
$sql = "DELETE FROM destination WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    $_SESSION['message_type'] = 'success'; 
    $_SESSION['message'] = 'Destination deleted successfully!';
} else {
    $_SESSION['message_type'] = 'danger'; 
    $_SESSION['message'] = 'Error deleting destination: ' . $stmt->error;
}
// END: Hapus data destinasi dari database

$stmt->close(); // Tutup statement
$conn->close(); // Tutup koneksi database

header("Location: ../pages/destination.php"); 
exit();
?>
