<?php
include '../layout/header.php';
include '../../config/database.php';

// START: Cek apakah ada parameter 'invoice_id' yang diterima dari URL
if (isset($_GET['invoice_id'])) {
    $invoice_id = intval($_GET['invoice_id']);
    
    // START: Query untuk mengambil data booking berdasarkan 'invoice_id'
    $bookingSql = "SELECT i.*, d.destination_name FROM invoice i 
                   JOIN destination d ON i.destination_id = d.id 
                   WHERE i.invoice_id = ?";
    $stmt = $conn->prepare($bookingSql);
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    $bookingResult = $stmt->get_result();
    // END: Query untuk mengambil data booking berdasarkan 'invoice_id'

    // START: Cek apakah data booking ditemukan
    if ($bookingResult->num_rows === 0) {
        // Jika 'invoice_id' tidak ditemukan, tampilkan pesan error
        echo '<div class="container mt-5">
                <div class="alert alert-danger" role="alert">
                    Invalid invoice ID or invoice not found.
                </div>
              </div>';
    } else {
        $booking = $bookingResult->fetch_assoc();

        // START: Query untuk mengambil data pembayaran berdasarkan 'invoice_id'
        $paymentSql = "SELECT * FROM payment WHERE invoice_id = ?";
        $stmt = $conn->prepare($paymentSql);
        $stmt->bind_param("i", $invoice_id);
        $stmt->execute();
        $paymentResult = $stmt->get_result();
        // END: Query untuk mengambil data pembayaran berdasarkan 'invoice_id'
        
        // START: Cek apakah form konfirmasi pembayaran dikirimkan
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
            // Query untuk memperbarui status pembayaran dan booking
            $updateSql = "UPDATE invoice SET paid = 1, status = 1 WHERE invoice_id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("i", $invoice_id);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Invoice confirmed successfully!";
                $_SESSION['message_type'] = "success";
                header("Location: " . $_SERVER['PHP_SELF'] . "?invoice_id=" . $invoice_id);
                exit();
            } else {
                $_SESSION['message'] = "Failed to confirm invoice.";
                $_SESSION['message_type'] = "danger";
            }
        }
        // END: Cek apakah form konfirmasi pembayaran dikirimkan
        ?>
        <div class="container mt-5">
            <!-- START: Tampilkan pesan notifikasi -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            <?php endif; ?>
            <!-- END: Tampilkan pesan notifikasi -->
            <h2>PAYMENT DETAIL FOR INVOICE #<?= $invoice_id; ?></h2>
            <div class="card my-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-center">Booking Information</h4>
                        <!-- START: Tampilkan status pembayaran -->
                        <?php if ($booking['paid'] == 0): ?>
                            <div class="badge badge-danger text-white badge-pill p-2">Unpaid</div>
                        <?php else: ?>
                            <div class="badge badge-success badge-pill text-white p-2">Paid</div>
                        <?php endif; ?>
                        <!-- END: Tampilkan status pembayaran -->
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>Booking ID</th>
                            <td>#<?= $booking['invoice_id']; ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?= $booking['name']; ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $booking['email']; ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= $booking['phone']; ?></td>
                        </tr>
                        <tr>
                            <th>Destination</th>
                            <td><?= $booking['destination_name']; ?></td>
                        </tr>
                        <tr>
                            <th>Booking Date</th>
                            <td><?= date("d F Y", strtotime($booking['booking_date'])); ?></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><?= "Rp " . number_format($booking['total'], 0, ',', '.'); ?></td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <a href="booking.php" class="btn btn-primary">Back to Bookings</a>
                <!-- START: Tampilkan tombol konfirmasi pembayaran jika belum dibayar dan data pembayaran tersedia -->
                <?php if ($booking['paid'] == 0 && $paymentResult->num_rows > 0): ?>
                <form method="POST" action="">
                    <input type="hidden" name="invoice_id" value="<?= $invoice_id; ?>">
                    <button type="submit" name="confirm" class="btn btn-success">Confirm Payment</button>
                </form>
                <?php endif; ?>
                <!-- END: Tampilkan tombol konfirmasi pembayaran jika belum dibayar dan data pembayaran tersedia -->
            </div>
        </div>
        <div class="container-fluid">
            <div class="card my-5">
                <div class="card-body">
                    <h4 class="text-center">Payment Confirmation</h4>
                    <?php
                    // START: Tampilkan detail pembayaran jika ada
                    if ($paymentResult->num_rows > 0) {
                        echo '
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3 text-center">
                                <thead class="text-white" style="background-color: #094067;">
                                    <tr>
                                        <th scope="col">Transfer Date</th>
                                        <th scope="col">Transfer Amount</th>
                                        <th scope="col">Transfer Purpose</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while ($payment = $paymentResult->fetch_assoc()) {
                            $amountFormatted = "Rp " . number_format($payment['transfer_amount'], 0, ',', '.');
                            echo "<tr>
                                    <td>" . date("d F Y", strtotime($payment['transfer_date'])) . "</td>
                                    <td>{$amountFormatted}</td>
                                    <td>{$payment['transfer_purpose']}</td>
                                    <td>{$payment['name']}</td>
                                    <td>{$payment['phone']}</td>
                                    <td>{$payment['email']}</td>
                                    <td class='text-justify'>{$payment['notes']}</td>
                                  </tr>";
                        }
                        echo '</tbody>
                              </table>
                              </div>';
                    } else {
                        // Jika tidak ada data pembayaran, tampilkan pesan
                        echo '<p class="text-center">No payment details available.</p>';
                    }
                    // END: Tampilkan detail pembayaran jika ada
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    // END: Cek apakah data booking ditemukan
} else {
    // Jika 'invoice_id' tidak diterima dari URL, tampilkan pesan error
    echo '<div class="container mt-5">
            <div class="alert alert-danger" role="alert">
                Invoice ID is missing.
            </div>
          </div>';
}
// END: Cek apakah ada parameter 'invoice_id' yang diterima dari URL

// Tutup koneksi database
$conn->close();
include '../layout/footer.php';
?>
