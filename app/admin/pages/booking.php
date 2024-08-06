<!-- Menyertakan file header dan koneksi database -->
<?php include '../layout/header.php'; ?>
<?php include '../../config/database.php'; ?>

<section style="color:#094067;">
    <!-- START: Bagian Judul -->
    <div class="text-center my-5">
        <h3>Booking</h3>
        <p style="color: #5f6c7b;">All Bookings We Have</p>
    </div>
    <!-- END: Bagian Judul -->

    <!-- START: Pemberitahuan -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        ?>
    <?php endif; ?>
    <!-- END: Pemberitahuan -->

    <!-- START: Tabel Booking -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="bookingTable">
                    <thead class="text-center text-white" style="background-color: #094067;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Booking ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Departure Date</th>
                            <th scope="col">Booking Date</th>
                            <th scope="col">Guest</th>
                            <th scope="col">Days</th>
                            <th scope="col">Transport</th>
                            <th scope="col">Food</th>
                            <th scope="col">Payment Staus</th>
                            <th scope="col">Total</th>
                            <th scope="col">Trip Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- START: Ambil dan Tampilkan Data Booking -->
                        <?php
                       $sql = "SELECT i.*, d.destination_name FROM invoice i 
                                JOIN destination d ON i.destination_id = d.id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $index = 1;
                            while ($row = $result->fetch_assoc()) {
                                // Status Pembayaran
                                $paidStatus = ($row['paid'] == 1) ? '<span class="badge badge-success badge-pill p-2">Paid</span>' : '<span class="badge badge-danger badge-pill p-2">Unpaid</span>';
                                // Status Makanan
                                $foodStatus = ($row['food'] == 1) ? '<span class="badge badge-success badge-pill p-2">include</span>' : '<span class="badge badge-danger badge-pill p-2">exclude</span>';
                                // Status Transportasi
                                $transportStatus = ($row['transport'] == 1) ? '<span class="badge badge-success badge-pill p-2">include</span>' : '<span class="badge badge-danger badge-pill p-2">exclude</span>';
                                // Status Perjalanan
                                switch ($row['status']) {
                                    case 0:
                                        $tripStatus = '<span class="badge badge-warning badge-pill p-2">Waiting Payment</span>';
                                        break;
                                    case 1:
                                        $tripStatus = '<span class="badge badge-primary badge-pill p-2">Confirmed</span>';
                                        break;
                                    case 2:
                                        $tripStatus = '<span class="badge badge-info badge-pill p-2">in Process</span>';
                                        break;
                                    case 3:
                                        $tripStatus = '<span class="badge badge-success badge-pill p-2">Completed</span>';
                                        break;
                                    default:
                                        $tripStatus = '<span class="badge badge-secondary badge-pill p-2">Unknown</span>';
                                        break;
                                }
                                $totalFormatted = "Rp " . number_format($row['total'], 0, ',', '.');
                                $bookingDateFormatted = date("d F Y", strtotime($row['booking_date']));
                                $departureDateFormatted = date("d F Y", strtotime($row['departure_date']));
                                echo "<tr>
                                    <th scope='row'>{$index}</th>
                                    <td>#{$row['invoice_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['destination_name']}</td>
                                    <td>{$departureDateFormatted}</td>
                                    <td>{$bookingDateFormatted}</td>
                                    <td>{$row['guest']} Guest</td>
                                    <td>{$row['days']} days</td>
                                    <td>{$transportStatus}</td>
                                    <td>{$foodStatus}</td>
                                    <td>{$paidStatus}</td>
                                    <td>{$totalFormatted}</td>
                                    <td>{$tripStatus}</td>
                                    <td>
                                        <a href='viewPayment.php?invoice_id={$row['invoice_id']}' class='btn btn-info btn-sm mb-2'><i class='fa fa-pencil' aria-hidden='true'></i></a>";
                                        echo "<form method='POST' action='../controller/deleteBooking.php' class='d-inline'>
                                                <input type='hidden' name='invoice_id' value='{$row['invoice_id']}'>
                                                <button type='submit' class='btn btn-danger btn-sm mb-2' onclick='return confirm(\"Are you sure you want to delete this booking??\")'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                                </button>
                                            </form>";
                                    if ($row['status'] == 1 || $row['status'] == 2) {
                                        echo "<form method='POST' action='../controller/updateStatus.php' class='d-inline '>
                                                <input type='hidden' name='invoice_id' value='{$row['invoice_id']}'>
                                                <select name='new_status' class='form-control form-control-sm' onchange='this.form.submit()'>
                                                    <option value=''>Trip Status</option>
                                                    <option value='2'>In Process</option>
                                                    <option value='3'>Completed</option>
                                                </select>
                                            </form> 
                                    </td></tr>";
                                    }
                    
                                $index++;
                            }
                        } 
                        // END: Ambil dan Tampilkan Data Booking

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END: Tabel Booking -->
</section>

<?php include '../layout/footer.php'; ?>
