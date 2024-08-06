<?php
include '../../config/database.php';
session_start();

// START: Fungsi untuk menghasilkan slug acak
function generate_random_slug($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
// END: Fungsi untuk menghasilkan slug acak

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination_name = $_POST['destination_name'];
    $destination_price = $_POST['destination_price'];
    $min_day = $_POST['min_day'];
    $max_day = $_POST['max_day'];
    $transport_price = $_POST['transport_price'];
    $food_price = $_POST['food_price'];
    $destination_location = $_POST['destination_location'];
    $best_seller = $_POST['best_seller'];
    $slug = generate_random_slug(); // Generate slug acak
    
    // START: Proses upload gambar
    $image_names = [];
    if (isset($_FILES['images'])) {
        $files = $_FILES['images'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmp_name = $files['tmp_name'][$i];
                $original_name = basename($files['name'][$i]);
                $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
                $new_name = generate_random_slug(12) . '.' . $file_extension; 
                $upload_dir = '../../../public/assets/images/destinations/';
                $file_path = $upload_dir . $new_name;
                if (move_uploaded_file($tmp_name, $file_path)) {
                    $image_names[] = $new_name; 
                }
            }
        }
    }
    // END: Proses upload gambar

    // START: Insert data destinasi ke database
    $sql = "INSERT INTO destination (destination_name, destination_price, min_day, max_day, transport_price, food_price, destination_location, best_seller, slug) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('siiidisis', $destination_name, $destination_price, $min_day, $max_day, $transport_price, $food_price, $destination_location, $best_seller, $slug);

    if ($stmt->execute()) {
        $destination_id = $stmt->insert_id;

        // START: Insert gambar terkait ke database
        if (!empty($image_names)) {
            $sql_images = "INSERT INTO destination_images (destination_id, images) VALUES (?, ?)";
            $stmt_images = $conn->prepare($sql_images);
            foreach ($image_names as $image_name) {
                $stmt_images->bind_param('is', $destination_id, $image_name);
                $stmt_images->execute();
            }
            $stmt_images->close();
        }
        // END: Insert gambar terkait ke database

        $_SESSION['message'] = 'Destination added successfully!';
        $_SESSION['message_type'] = 'success';
        header("Location: ../pages/destination.php"); 
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . htmlspecialchars($conn->error);
        $_SESSION['message_type'] = 'danger';
        header("Location: ../pages/addDestination.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
