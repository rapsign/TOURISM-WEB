<?php
    // Menghubungkan ke database
    include '../config/database.php';

    // START: Mengambil parameter dari URL
    $invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : 0;
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    // END: Mengambil parameter dari URL

    // START: Validasi ID dan Email
    if ($invoice_id === 0) {
        echo "<script>alert('Invalid invoice ID.'); window.history.back();</script>";
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address.'); window.history.back();</script>";
        exit();
    }
     // END: Validasi ID dan Email

    // START: Query untuk mengambil data invoice
    $sql = "SELECT i.*, d.destination_price, d.transport_price, d.food_price, d.destination_name
            FROM invoice i
            JOIN destination d ON i.destination_id = d.id
            WHERE i.invoice_id = ? AND i.email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $invoice_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Invoice not found or email mismatch.'); window.history.back();</script>";
        exit();
    }
    // END: Query untuk mengambil data invoice

    // START: Mengambil data invoice dari hasil query
    $invoice = $result->fetch_assoc();
    $name = $invoice['name'];
    $days = $invoice['days'];
    $phone = $invoice['phone'];
    $guest = $invoice['guest'];
    $booking_date = $invoice['booking_date'];
    $departure_date = $invoice['departure_date'];
    $destination_id = $invoice['destination_id'];
    $paid = $invoice['paid'];
    $total = $invoice['total'];
    $destination_name = $invoice['destination_name'];
    $destination_price = $invoice['destination_price'];
    $transport_price = $invoice['transport_price'];
    $food_price = $invoice['food_price'];
    $transport = $invoice['transport'] ? 'Include' : 'Exclude';
    $food = $invoice['food'] ? 'Include' : 'Exclude';
    // END: Mengambil data invoice dari hasil query

    function format_currency($amount) {  // Function format mata uang
        return 'Rp. ' . number_format($amount, 0, ',', '.');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <link rel="stylesheet" href="../../public/assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <!-- START: Invoice-->
    <div class="d-flex justify-content-center">
        <div class="card w-100 w-md-75" style="border: none;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>INVOICE</h1>
                    <h4>
                        <?php if ($paid): ?>
                            <div class="badge badge-success">Paid</div>
                        <?php else: ?>
                            <div class="badge badge-danger">Unpaid</div>
                        <?php endif; ?>
                    </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul style="list-style-type: none; padding-left: 0;">
                            <p><strong>Booking Date:</strong> <?= date('d F Y', strtotime($booking_date)); ?></p>
                            <li><strong>BOOKED BY</strong></li>
                            <li><strong>Name:</strong> <?= $name; ?></li>
                            <li><strong>Email:</strong> <?= $email; ?></li>
                            <li><strong>Phone:</strong> <?= $phone; ?></li>
                            <li><strong>Guest:</strong> <?= $guest; ?></li>
                            <li><strong>Departure Date:</strong> <?= date('d F Y', strtotime($departure_date)); ?></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead style="background-color: #094067; color: #fffffe;">
                            <tr>
                                <th>Invoice ID</th>
                                <th>Destination</th>
                                <th>Days</th>
                                <th>Transport</th>
                                <th>Food</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#<?= $invoice_id; ?></td>
                                <td><?= $destination_name; ?></td>
                                <td><?= $days; ?> days</td>
                                <td><?= $transport; ?></td>
                                <td><?= $food; ?></td>
                                <td><?= format_currency($total); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="text-right">
                    <h3>
                        <strong>Total</strong>: <?= format_currency($total); ?>
                    </h3>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <?php if (!$paid): ?>
                        <a href="../../?page=paymentConfirmation&invoice_id=<?= $invoice_id; ?>&total=<?= $total; ?>" type="button" class="btn btn-success btn-sm mr-2">Pay</a>
                    <?php endif; ?>
                        <a href="../controller/generatePdf.php?invoice_id=<?= $invoice_id; ?>&email=<?= urlencode($email); ?>" type="button" class="btn btn-primary btn-sm mr-2">Download PDF</a>
                    <?php if (!$paid): ?>
                        <form action="../controller/cancelBooking.php" method="post"  id="cancelForm">
                            <input type="hidden" name="invoice_id" value="<?= $invoice_id; ?>">
                            <button type="submit" class="btn btn-danger btn-sm mr-2 " onclick="confirmCancel(event)">Cancel</button>
                        </form>
                    <?php endif; ?>
                        <a href="../../?page=home" type="button" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Invoice-->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        // START: Konfirmasi sebelum membatalkan
        function confirmCancel(event) {
            event.preventDefault(); 

            var result = confirm("Are you sure you want to cancel?");
            if (result) {
                document.getElementById("cancelForm").submit(); 
            }
        }
        // END: Konfirmasi sebelum membatalkan
    </script>
</body>
</html>

<?php
    $conn->close();  // Menutup koneksi database
?>
