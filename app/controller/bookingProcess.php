<?php
include '../config/database.php';

// START: Memeriksa apakah metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // START: Mengambil data dari form
    $name           = $_POST['fullName'];
    $phone          = $_POST['phone'];
    $days           = $_POST['days'];
    $email          = $_POST['email'];
    $guest          = $_POST['guest'];
    $booking_date   = date('Y-m-d');                        // Tanggal booking saat ini
    $departure_date = $_POST['date'];
    $transport      = isset($_POST['transport']) ? 1 : 0;   // Mengatur apakah transportasi dipilih
    $food           = isset($_POST['food']) ? 1 : 0;        // Mengatur apakah makanan dipilih
    $destination_id = $_POST['destination_id'];
    $paid           = 0;                                    // Status pembayaran awal
    $invoice_id     = random_int(10000000, 99999999);       // Membuat ID invoice acak
    $status         = 0;                                    // Status awal

    // START: Memeriksa apakah guest lebih dari 0
    if ($guest <= 0) {
        echo "<script>
                alert('Guest number must be greater than 0');
                window.history.back();
              </script>";
        exit();
    }
    // END: Memeriksa apakah guest lebih dari 0

    // START: Memeriksa apakah days lebih dari 0
    if ($days <= 0) {
        echo "<script>
                alert('Number of days must be greater than 0');
                window.history.back();
              </script>";
        exit();
    }
    // END: Memeriksa apakah days lebih dari 0

    // START: Memeriksa apakah departure date tidak sebelum booking date
    if (strtotime($departure_date) < strtotime($booking_date)) {
        echo "<script>
                alert('Departure date cannot be before booking date');
                window.history.back();
              </script>";
        exit();
    }
    // END: Memeriksa apakah departure date tidak sebelum booking date

    // START: Mengambil informasi destinasi dari database
    $destination_sql = "SELECT destination_price, transport_price, food_price, max_day FROM destination WHERE id = ?";
    $destination_stmt = $conn->prepare($destination_sql);
    $destination_stmt->bind_param('i', $destination_id);
    $destination_stmt->execute();
    $destination_result = $destination_stmt->get_result();
    $destination = $destination_result->fetch_assoc();
    // END: Mengambil informasi destinasi dari database

    // START: Mengecek apakah destinasi ditemukan
    if (!$destination) {
        echo "Destination not found.";
        exit();
    }
    // END: Mengecek apakah destinasi ditemukan

    $destination_price = $destination['destination_price'];
    $transport_price = $destination['transport_price'];
    $food_price = $destination['food_price'];
    $total_cost = $destination_price * $days * $guest;

    // START: Menghitung biaya tambahan untuk transportasi dan makanan
    if ($transport) {
        $total_cost += $transport_price;
    }
    if ($food) {
        $total_cost += $food_price * $guest;
    }
    // END: Menghitung biaya tambahan untuk transportasi dan makanan

    // START: Mengecek apakah jumlah hari melebihi batas maksimum
    if ($days > $destination['max_day']) {
        echo "<script>
                alert('Past the appointed day');
                window.history.back();
              </script>";
        exit();
    }
    // END: Mengecek apakah jumlah hari melebihi batas maksimum

    // START: Menyimpan data booking ke dalam database
    $sql = "INSERT INTO invoice (invoice_id, name, email, phone, booking_date, guest, days, transport, food, departure_date, destination_id, paid, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssssss', $invoice_id, $name, $email, $phone, $booking_date, $guest, $days, $transport, $food, $departure_date, $destination_id, $paid, $total_cost, $status);
    if ($stmt->execute()) {
        echo "<script>
                alert('Booking Successfully');
                window.location.href = '../pages/invoice.php?invoice_id=$invoice_id&email=$email';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    // END: Menyimpan data booking ke dalam database

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
