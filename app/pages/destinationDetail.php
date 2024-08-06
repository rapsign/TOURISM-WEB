<?php
include 'app/config/database.php';

// START: Mendapatkan data destinasi berdasarkan slug
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT * FROM destination WHERE slug = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $destination = $result->fetch_assoc();
        $destination_id = $destination['id']; 
        
        // START: Mendapatkan gambar destinasi
        $sql_images = "SELECT images FROM destination_images WHERE destination_id = ?";
        $stmt_images = $conn->prepare($sql_images);
        $stmt_images->bind_param('i', $destination_id);
        $stmt_images->execute();
        $result_images = $stmt_images->get_result();
        $images = [];
        while ($row = $result_images->fetch_assoc()) {
            $images[] = $row['images'];
        }
        $stmt->close();
        $stmt_images->close();
        // END: Mendapatkan gambar destinasi
    } else {
        echo "Destination not found.";
        exit();
    }
} else {
    echo "No slug provided.";
    exit();
}
// END: Mendapatkan data destinasi berdasarkan slug
?>

<!-- START: Detail Destinasi -->
<section style="color:#094067;" id="destinationDetail">
    <div class="container">
        <div class="row mb-3">
            <!-- START: Carousel Gambar Destinasi -->
            <div class="col-12 col-md-6">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (count($images) > 0): ?>
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="card">
                                        <img src="public/assets/images/destinations/<?= !empty($image) ? $image : 'https://via.placeholder.com/1920x1080'; ?>" class="card-img-top img-fluid" alt="destination image" style="height: 575px; object-fit: cover;">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- END: Carousel Gambar Destinasi -->

            <!-- START: Detail Destinasi -->
            <div class="col-12 col-md-6">
                <div class="text-left">
                    <h3><?= $destination['destination_name'] ?></h3>
                </div>
                <div style="color:#ef4565;">
                    <?php if ($destination['best_seller'] == '1'): ?>
                        <p><i class="fa fa-tag mr-1" aria-hidden="true"></i> Best Seller</p>
                    <?php endif; ?>
                    <p><i class="fa fa-map-marker mr-1" aria-hidden="true"></i> <?= $destination['destination_location'] ?></p>
                    <p><i class="fa fa-calendar mr-1" aria-hidden="true"></i> <?= $destination['min_day'] ?>-<?= $destination['max_day'] ?> days</p>
                </div>
                <h4>Rp <?= number_format($destination['destination_price'], 0, ',', '.') ?> / <span class="h6" style="font-weight: normal;">Days</span></h4>
                <button class="btn btn-block btn-primary mt-3" type="button" data-toggle="collapse" data-target="#formCollapse" aria-expanded="false" aria-controls="formCollapse">Order Now</button>
                <div class="collapse" id="formCollapse">
                    <div class="card card-body mt-2">
                        <form method="post" action="app/controller/bookingProcess.php">
                            <div class="row">
                                <div class="col-12 col-sm-6 mb-3">
                                    <label for="fullname">Fullname</label>
                                    <input type="text" class="form-control" name="fullName" placeholder="john doe" required>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                <label for="phone">Phone</label>
                                    <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                <label for="days">Days</label>
                                    <input type="number" class="form-control" name="days" placeholder="Day" required>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="johndoe@gmail.com" required>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                <label for="guest">Guest</label>
                                    <input type="number" class="form-control" name="guest" placeholder="Guest" required>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                <label for="guest">Departure Date</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                                <div class="col-12 mb-3 ml-4">
                                    <input type="checkbox" class="form-check-input" name="transport">
                                    <label class="form-check-label" for="transport">Include Transport ( + Rp <?= number_format($destination['transport_price'], 0, ',', '.') ?> )</label>
                                </div>
                                <div class="col-12 mb-3 ml-4">
                                    <input type="checkbox" class="form-check-input" name="food">
                                    <label class="form-check-label" for="food">Include Food ( + Rp <?= number_format($destination['food_price'], 0, ',', '.') ?>/Guest )</label>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="destination_id" value="<?= $destination['id'] ?>">
                                    <button class="btn btn-block btn-primary" type="submit">Book Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Detail Destinasi -->
        </div>
        <hr>
        
        <!-- START: Destinasi Terkait -->
        <?php
        $sql = "SELECT * FROM destination LIMIT 4";
        $result = $conn->query($sql);
        if ($result->num_rows > 0):
        ?>
        <div class="row">
            <?php while ($related_destination = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <a href="?page=destinationDetail&slug=<?= $related_destination['slug'] ?>">
                        <div class="card" style="position: relative;">
                            <div id="carouselExampleIndicators<?= $related_destination['id'] ?>" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                    $related_destination_id = $related_destination['id'];
                                    $sql_images = "SELECT COUNT(*) as image_count FROM destination_images WHERE destination_id = ?";
                                    $stmt_images = $conn->prepare($sql_images);
                                    $stmt_images->bind_param('i', $related_destination_id);
                                    $stmt_images->execute();
                                    $result_images_count = $stmt_images->get_result()->fetch_assoc();
                                    $image_count = $result_images_count['image_count'];
                                    $stmt_images->close();

                                    for ($i = 0; $i < $image_count; $i++): ?>
                                        <li data-target="#carouselExampleIndicators<?= $related_destination['id'] ?>" data-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></li>
                                    <?php endfor; ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                    $sql_images = "SELECT images FROM destination_images WHERE destination_id = ?";
                                    $stmt_images = $conn->prepare($sql_images);
                                    $stmt_images->bind_param('i', $related_destination_id);
                                    $stmt_images->execute();
                                    $result_images = $stmt_images->get_result();
                                    $related_images = [];
                                    while ($row = $result_images->fetch_assoc()) {
                                        $related_images[] = $row['images'];
                                    }
                                    $stmt_images->close();

                                    foreach ($related_images as $index => $image): ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="public/assets/images/destinations/<?= !empty($image) ? $image : 'https://via.placeholder.com/1920x1080'; ?>" class="d-block w-100 img-fluid" alt="destination image" style="height: 300px; object-fit: cover;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators<?= $related_destination['id'] ?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators<?= $related_destination['id'] ?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <?php if ($related_destination['best_seller'] == '1'): ?>
                                    <span class="badge text-white" style="position: absolute; top: 10px; left: 10px; background-color:#3da9fc;">Best Seller</span>
                                <?php endif; ?>
                                <h4><?= $related_destination['destination_name'] ?></h4>
                                <div class="container my-2">
                                    <div class="row text-center" style="color: #ef4565;">
                                        <div class="col"><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $related_destination['destination_location'] ?></div>
                                        <div class="col"><i class="fa fa-calendar" aria-hidden="true"></i> <?= $related_destination['min_day'] ?>-<?= $related_destination['max_day'] ?> days</div>
                                    </div>
                                </div>
                                <h5 style="color: #5f6c7b;">Rp <?= number_format($related_destination['destination_price'], 0, ',', '.') ?> / <span class="h6" style="font-weight: normal;">Days</span></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        else:
            echo "<p>No destinations found.</p>";
        endif;

        // Pastikan koneksi database hanya ditutup sekali setelah semua operasi selesai
        $conn->close();
        ?>
        <!-- END: Destinasi Terkait -->
    </div>
</section>
<!-- END: Detail Destinasi -->
