<?php
    include '../config/database.php';

    // Mulai pemrosesan POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari POST request
        $invoice_id = intval($_POST['invoice_id']);
        $transfer_date = $_POST['transfer_date'];
        $transfer_amount = floatval($_POST['transfer_amount']);
        $transfer_purpose = $_POST['transfer_purpose'];
        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $notes = $_POST['notes'];

        // Cek apakah invoice_id ada di tabel invoice
        $check_sql = "SELECT id FROM invoice WHERE invoice_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('i', $invoice_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Invoice ID ada, lanjutkan dengan proses penyimpanan
            $sql = "INSERT INTO payment (invoice_id, transfer_date, transfer_amount, transfer_purpose, name, phone, email, notes)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isssssss', $invoice_id, $transfer_date, $transfer_amount, $transfer_purpose, $full_name, $phone, $email, $notes);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Payment confirmation submitted successfully.');
                        window.history.back(); 
                    </script>";
            } else {
                echo "<script>
                        alert('Error submitting payment confirmation.');
                        window.history.back();
                    </script>";
            }
            $stmt->close();
        } else {
            // Invoice ID tidak ditemukan
            echo "<script>
                    alert('Invoice ID not found.');
                    window.history.back();
                </script>";
        }
        
        $check_stmt->close();
        $conn->close();
    }
    // Akhir pemrosesan POST request
?>
