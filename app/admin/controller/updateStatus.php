<?php
include '../../config/database.php';
session_start();

// START: Cek jika permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // START: Cek jika parameter 'invoice_id' dan 'new_status' ada
    if (isset($_POST['invoice_id']) && isset($_POST['new_status'])) {
        $invoice_id = intval($_POST['invoice_id']);
        $new_status = intval($_POST['new_status']);

        // START: Update status trip di database
        $updateSql = "UPDATE invoice SET status = ? WHERE invoice_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $new_status, $invoice_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Trip status updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update trip status.";
            $_SESSION['message_type'] = "danger";
        }

        $stmt->close();
        // END: Update status trip di database
    } else {
        $_SESSION['message'] = "Invalid input.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: ../pages/booking.php");
    exit();
}
// END: Cek jika permintaan adalah POST

$conn->close();
?>
