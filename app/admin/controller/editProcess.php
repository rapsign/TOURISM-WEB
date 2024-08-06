<?php
include '../../config/database.php';
session_start(); // START: Mulai sesi

function generate_random_slug($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // START: Cek apakah request method adalah POST
    $id = $_POST['id'];
    $destination_name = $_POST['destination_name'];
    $destination_price = $_POST['destination_price'];
    $min_day = $_POST['min_day'];
    $max_day = $_POST['max_day'];
    $transport_price = $_POST['transport_price'];
    $food_price = $_POST['food_price'];
    $destination_location = $_POST['destination_location'];
    $best_seller = $_POST['best_seller'];

    // START: Proses upload gambar
    $image_names = [];
    if (isset($_FILES['images'])) {
        $files = $_FILES['images'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmp_name = $files['tmp_name'][$i];
                $file_extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $random_name = generate_random_slug(12) . '.' . $file_extension;
                $upload_dir = '../../../public/assets/images/destinations/'; 
                $file_path = $upload_dir . $random_name;
                if (move_uploaded_file($tmp_name, $file_path)) {
                    $image_names[] = $random_name; 
                }
            }
        }
    }
    $image_names_str = implode(',', $image_names); // END: Proses upload gambar

    $sql = "UPDATE destination SET 
                destination_name = ?, 
                destination_price = ?, 
                min_day = ?, 
                max_day = ?, 
                transport_price = ?, 
                food_price = ?, 
                destination_location = ?, 
                best_seller = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('siiidisii', $destination_name, $destination_price, $min_day, $max_day, $transport_price, $food_price, $destination_location, $best_seller, $id);

    if ($stmt->execute()) { // START: Cek jika eksekusi berhasil
        if (!empty($image_names_str)) { // START: Proses penyimpanan gambar jika ada
            $sql_images = "INSERT INTO destination_images (destination_id, images) VALUES (?, ?)";
            $stmt_images = $conn->prepare($sql_images);
            $stmt_images->bind_param('is', $id, $image_names_str);
            $stmt_images->execute();
        } // END: Proses penyimpanan gambar jika ada

        $_SESSION['message'] = 'Destination updated successfully!';
        $_SESSION['message_type'] = 'success'; 

        header("Location: ../pages/destination.php"); 
        exit();
    } else { // END: Cek jika eksekusi gagal
        $_SESSION['message'] = 'Error: ' . $conn->error;
        $_SESSION['message_type'] = 'danger';

        header("Location: ../pages/editDestination.php?id=" . $id);
        exit();
    }

    $stmt->close(); // Tutup statement
    $conn->close(); // Tutup koneksi database
}
?>
