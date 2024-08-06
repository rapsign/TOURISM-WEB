<?php
include '../../config/database.php';
session_start();

// START: Periksa apakah parameter 'id' ada
if (!isset($_GET['id'])) {
    header("Location: editDestination.php"); 
    exit();
}
// END: Periksa apakah parameter 'id' ada

$id = $_GET['id'];

// START: Ambil data destinasi beserta gambar
$sql = "SELECT d.*, GROUP_CONCAT(di.images) as image_paths
        FROM destination d
        LEFT JOIN destination_images di ON d.id = di.destination_id
        WHERE d.id = ?
        GROUP BY d.id";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
// END: Ambil data destinasi beserta gambar

// START: Periksa apakah data destinasi ada
if ($result->num_rows === 0) {
    header("Location: editDestination.php"); 
    exit();
}

$row = $result->fetch_assoc();
$images = explode(',', $row["image_paths"]);
// END: Periksa apakah data destinasi ada
?>

<?php include '../layout/header.php'; ?>

<section style="color:#094067;">
    <div class="text-center my-5">
        <h3>Edit Destination</h3>
        <p style="color: #5f6c7b;">Update the information of the destination</p>
    </div>

    <div class="container">
        <!-- START: Formulir untuk mengedit destinasi -->
        <form action="../controller/editProcess.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id']; ?>">
            <div class="form-group">
                <label for="destination_name">Destination Name</label>
                <input type="text" class="form-control" id="destination_name" name="destination_name" value="<?= $row['destination_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="destination_price">Price</label>
                <input type="number" class="form-control" id="destination_price" name="destination_price" value="<?= $row['destination_price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="min_day">Min Days</label>
                <input type="number" class="form-control" id="min_day" name="min_day" value="<?= $row['min_day']; ?>" required>
            </div>
            <div class="form-group">
                <label for="max_day">Max Days</label>
                <input type="number" class="form-control" id="max_day" name="max_day" value="<?= $row['max_day']; ?>" required>
            </div>
            <div class="form-group">
                <label for="transport_price">Transport Price</label>
                <input type="number" class="form-control" id="transport_price" name="transport_price" value="<?= $row['transport_price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="food_price">Food Price</label>
                <input type="number" class="form-control" id="food_price" name="food_price" value="<?= $row['food_price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="destination_location">Location</label>
                <input type="text" class="form-control" id="destination_location" name="destination_location" value="<?= $row['destination_location']; ?>" required>
            </div>
            <div class="form-group">
                <label for="best_seller">Best Seller</label>
                <select class="form-control" id="best_seller" name="best_seller">
                    <option value="1" <?= ($row['best_seller'] ? 'selected' : ''); ?>>Yes</option>
                    <option value="0" <?= (!$row['best_seller'] ? 'selected' : ''); ?>>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="images">Update Images (Leave empty if not changing)</label>
                <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                <!-- START: Tampilkan gambar saat ini jika ada -->
                <?php if (count($images) > 0): ?>
                    <div class="mt-3">
                        <strong>Current Images:</strong>
                        <div class="row">
                            <?php foreach ($images as $image): ?>
                                <div class="col-md-2 mb-2">
                                    <img src="../../../public/assets/images/destinations/<?= $image; ?>" class="img-fluid" alt="Current Image" style="height: 150px; object-fit: cover;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-3">
                        <strong>Current Images:</strong>
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <p>no images</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- END: Tampilkan gambar saat ini jika ada -->
            </div>
            <button type="submit" class="btn btn-primary">Update Destination</button>
        </form>
        <!-- END: Formulir untuk mengedit destinasi -->
    </div>
</section>

<?php include '../layout/footer.php'; ?>

<?php
// START: Tutup koneksi database
$stmt->close();
$conn->close();
// END: Tutup koneksi database
?>
