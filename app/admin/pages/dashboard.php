<?php 
    // Menyertakan file header dan koneksi database
    include '../layout/header.php'; 
    include '../../config/database.php';

    // START: Query untuk menghitung jumlah destinasi
    $sqlDestination = "SELECT COUNT(*) AS total FROM destination";
    $resultDestination = $conn->query($sqlDestination);
    $rowDestination = $resultDestination->fetch_assoc();
    $destinationCount = $rowDestination['total'];
    // END: Query untuk menghitung jumlah destinasi

    // START: Query untuk menghitung jumlah booking
    $sqlBooking = "SELECT COUNT(*) AS total FROM invoice";
    $resultBooking = $conn->query($sqlBooking);
    $rowBooking = $resultBooking->fetch_assoc();
    $bookingCount = $rowBooking['total'];
    // END: Query untuk menghitung jumlah booking

    // START: Query untuk menghitung total pendapatan untuk invoice yang telah dibayar
    $sqlIncome = "SELECT SUM(total) AS total_income FROM invoice WHERE paid = 1";
    $resultIncome = $conn->query($sqlIncome);
    $rowIncome = $resultIncome->fetch_assoc();
    $totalIncome = number_format($rowIncome['total_income'], 0, ',', '.'); // Format totalIncome dengan pemisah ribuan
    // END: Query untuk menghitung total pendapatan untuk invoice yang telah dibayar
?>
<section style="color:#094067;">
    <div class="container">
        <div class="row my-5">
            <!-- START: Kartu Destinasi -->
            <div class="col-md-4 mb-4">
                <a href="destination.php" style="color:#094067; text-decoration:none;">
                    <div class="card" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-bottom:solid 5px #3da9fc;">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0">DESTINATIONS</h5>
                                    <h3><?= $destinationCount ?></h3> <!-- Menampilkan jumlah destinasi -->
                                </div>
                                <i class="fa fa-map mx-3" aria-hidden="true" style="font-size:4em;"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END: Kartu Destinasi -->

            <!-- START: Kartu Booking -->
            <div class="col-md-4 mb-4">
                <a href="booking.php" style="color:#094067; text-decoration:none;">
                    <div class="card" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-bottom:solid 5px #3da9fc;">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0">BOOKING</h5>
                                    <h3><?= $bookingCount ?></h3> <!-- Menampilkan jumlah booking -->
                                </div>
                                <i class="fa fa-ticket mx-3" aria-hidden="true" style="font-size:4em;"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END: Kartu Booking -->

            <!-- START: Kartu Pendapatan -->
            <div class="col-md-4 mb-4">
                <div class="card" style="border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-bottom:solid 5px #3da9fc;">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="mt-0">INCOME</h5>
                                <h3><?= $totalIncome ?></h3> <!-- Menampilkan total pendapatan -->
                            </div>
                            <i class="fa fa-credit-card mx-3" aria-hidden="true" style="font-size:4em;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Kartu Pendapatan -->
        </div>
    </div>
</section>
<?php include '../layout/footer.php'; ?>
