<?php include '../layout/header.php'; ?>
<?php include '../../config/database.php'; ?>
<section style="color:#094067;">
    <div class="text-center my-5">
        <h3>Destination</h3>
        <p style="color: #5f6c7b;">All Destination We Have</p>
    </div>
    <div class="container">
    <?php if (isset($_SESSION['message'])): ?>
        <!-- START: Tampilkan pesan notifikasi jika ada -->
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
        <!-- END: Tampilkan pesan notifikasi jika ada -->
    <?php endif; ?>
    <a href="addDestination.php" class="btn btn-primary btn-sm my-5"><i class="fa fa-plus"></i> Add</a>
        <div class="row">
            <?php
                try {
                    // START: Ambil data destinasi dan gambar
                    $sql = "SELECT d.*, GROUP_CONCAT(di.images) as image_paths
                            FROM destination d
                            LEFT JOIN destination_images di ON d.id = di.destination_id
                            GROUP BY d.id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $images = explode(',', $row["image_paths"]);
                            ?>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <?php if (count($images) > 0) { ?>
                                        <!-- START: Carousel untuk gambar destinasi -->
                                        <div id="carousel<?= $row['id']; ?>" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php foreach ($images as $index => $image) { 
                                                    $activeClass = ($index === 0) ? 'active' : ''; ?>
                                                    <div class="carousel-item <?= $activeClass; ?>">
                                                        <img src="../../../public/assets/images/destinations/<?= $image; ?>" class="d-block w-100" alt="Image" style="height: 400px; object-fit: cover;">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a class="carousel-control-prev" href="#carousel<?= $row['id']; ?>" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carousel<?= $row['id']; ?>" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                        <!-- END: Carousel untuk gambar destinasi -->
                                    <?php } else { ?>
                                        <img src="https://via.placeholder.com/1080x1080" class="card-img-top" alt="No image available" style="height: 200px; object-fit: cover;">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><?= $row["destination_name"]; ?></h5>
                                        <table class="table table-bordered table-bordered-custom">
                                            <tbody>
                                                <tr>
                                                    <th>Price</th>
                                                    <td>Rp <?= number_format($row["destination_price"], 0, '.', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Days</th>
                                                    <td><?= $row["min_day"] . "-" . $row["max_day"]; ?> Days</td>
                                                </tr>
                                                <tr>
                                                    <th>Transport Price</th>
                                                    <td>Rp <?= number_format($row["transport_price"], 0, '.', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Food Price</th>
                                                    <td>Rp <?= number_format($row["food_price"], 0, '.', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td><?= $row["destination_location"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Best Seller</th>
                                                    <td><?= ($row["best_seller"] ? 'Yes' : 'No'); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-end">
                                            <a href="editDestination.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-edit"></i> Edit</a>
                                            <!--START: Formulir penghapusan dengan konfirmasi -->
                                            <form action="../controller/deleteDestination.php" method="post" onsubmit="return confirmDelete()">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            <!--END: Formulir penghapusan dengan konfirmasi -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else {
                        echo "<div class='col-12 text-center'>No destinations found</div>";
                    }
                } catch (mysqli_sql_exception $e) {
                    // START: Tampilkan pesan kesalahan jika ada
                    echo "<div class='col-12'>Error: " . $e->getMessage() . "</div>";
                    // END: Tampilkan pesan kesalahan jika ada
                }
                $conn->close();
            ?>
        </div>
    </div>
</section>
<?php include '../layout/footer.php'; ?>
