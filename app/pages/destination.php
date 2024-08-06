<?php
    // Ambil data destinasi dan gambar dari database
    $sql = "SELECT d.*, GROUP_CONCAT(di.images) as image_paths
            FROM destination d
            LEFT JOIN destination_images di ON d.id = di.destination_id
            GROUP BY d.id";
    $result = $conn->query($sql);

    $destinations = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $destinations[] = $row;
        }
    }
?>
<!-- START: Bagian destinasi -->
<section style="background-color: #d8edfe; color:#094067" id="destination">
    <div class="container">
        <!-- START: Judul dan deskripsi -->
        <div class="text-center my-5">
            <h3>Destination of choice</h3>
            <p style="color: #5f6c7b;">We offer several interesting destinations</p>
        </div>
        <!-- END: Judul dan deskripsi -->
        
        <div class="row align-items-center">
            <?php foreach ($destinations as $destination): ?>
                <!-- START: Card destinasi -->
                <div class="col-md-6 mb-4">
                    <a href="?page=destinationDetail&slug=<?= $destination['slug'] ?>">
                        <div class="card" style="border: none; position: relative;">
                            <div id="carousel<?= $destination['id'] ?>" class="carousel slide" data-ride="carousel">
                                <!-- START: Indikator carousel -->
                                <ol class="carousel-indicators">
                                    <?php
                                    $images = explode(',', $destination['image_paths']);
                                    foreach ($images as $index => $image): ?>
                                        <li data-target="#carousel<?= $destination['id'] ?>" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                                    <?php endforeach; ?>
                                </ol>
                                <!-- END: Indikator carousel -->
                                
                                <!-- START: Item carousel -->
                                <div class="carousel-inner">
                                    <?php foreach ($images as $index => $image) { 
                                        $activeClass = ($index === 0) ? 'active' : ''; ?>
                                        <div class="carousel-item <?= $activeClass; ?>">
                                            <img src="public/assets/images/destinations/<?= $image ?>" class="d-block w-100" alt="Image" style="height: 300px; object-fit: cover;">
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- END: Item carousel -->
                                
                                <!-- START: Kontrol carousel -->
                                <a class="carousel-control-prev" href="#carousel<?= $destination['id'] ?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel<?= $destination['id'] ?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                <!-- END: Kontrol carousel -->
                            </div>
                            <div class="card-body text-center">
                                <!-- START: Badge Best Seller -->
                                <?php if ($destination['best_seller'] == '1'): ?>
                                    <span class="badge text-white" style="position: absolute; top: 10px; left: 10px; background-color:#3da9fc;">Best Seller</span>
                                <?php endif; ?>
                                <!-- END: Badge Best Seller -->
                                
                                <h4><?= $destination['destination_name'] ?></h4>
                                <div class="container my-2">
                                    <div class="row text-center" style="color: #ef4565;">
                                        <div class="col"><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $destination['destination_location'] ?></div>
                                        <div class="col"><i class="fa fa-calendar" aria-hidden="true"></i> <?= $destination['min_day'] ?>-<?= $destination['max_day'] ?> days</div>
                                    </div>
                                </div>
                                <h5 style="color: #5f6c7b;">Rp <?= number_format($destination['destination_price'], 0, '.', '.') ?> / <span class="h6" style="font-weight: normal;">Days</span></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- END: Card destinasi -->
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- END: Bagian destinasi -->