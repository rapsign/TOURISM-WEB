<?php include '../layout/header.php'; ?>
<?php include '../../config/database.php'; ?>
<section style="color:#094067;">
    <!-- START : Bagian Judul -->
    <div class="text-center my-5">
        <h3>Add New Destination</h3>
        <p>fill out the form below to add a destination</p>
    </div>
      <!-- END : Bagian Judul -->
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
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- START: Formulir untuk menambah destinasi baru -->
                <form action="../controller/addProcess.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="destination_name">Destination Name</label>
                        <input type="text" class="form-control" id="destination_name" name="destination_name" placeholder="example  Raja Ampat" required>
                    </div>
                    <div class="form-group">
                        <label for="destination_price">Price</label>
                        <input type="number" class="form-control" id="destination_price" name="destination_price" placeholder="example 1000000" required>
                    </div>
                    <div class="form-group">
                        <label for="min_day">Min Days</label>
                        <input type="number" class="form-control" id="min_day" name="min_day" placeholder="example 1" required>
                    </div>
                    <div class="form-group">
                        <label for="max_day">Max Days</label>
                        <input type="number" class="form-control" id="max_day" name="max_day" placeholder="example 5" required>
                    </div>
                    <div class="form-group">
                        <label for="transport_price">Transport Price</label>
                        <input type="number" class="form-control" id="transport_price" name="transport_price" placeholder="example 100000" required>
                    </div>
                    <div class="form-group">
                        <label for="food_price">Food Price</label>
                        <input type="number" class="form-control" id="food_price" name="food_price" placeholder="example 50000" required>
                    </div>
                    <div class="form-group">
                        <label for="destination_location">Location</label>
                        <input type="text" class="form-control" id="destination_location" name="destination_location" placeholder="example Lombok" required>
                    </div>
                    <div class="form-group">
                        <label for="best_seller">Best Seller</label>
                        <select class="form-control" id="best_seller" name="best_seller">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="images">Images (Upload multiple images)</label>
                        <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Destination</button>
                </form>
                <!-- END: Formulir untuk menambah destinasi baru -->
            </div>
        </div>
    </div>
</section>
<?php include '../layout/footer.php'; ?>
