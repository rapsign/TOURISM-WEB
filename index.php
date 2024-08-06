<?php
    include 'app/config/database.php'; // START: Menyertakan file konfigurasi database
    include 'app/layout/header.php'; // START: Menyertakan header halaman

    $page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Menentukan halaman yang akan ditampilkan berdasarkan parameter 'page'

    // START: Redirect ke halaman admin jika page adalah 'admin'
    if ($page === 'admin') {
        header('Location: app/admin');
        exit(); // Hentikan eksekusi script
    }
    // END: Redirect ke halaman admin

    // START: Menentukan halaman yang akan ditampilkan
    switch ($page) {
        case 'home':
            include 'app/pages/home.php'; // Menampilkan halaman utama
            break;
        case 'destination':
            include 'app/pages/destination.php'; // Menampilkan halaman tujuan
            break;
        case 'destinationDetail':
            include 'app/pages/destinationDetail.php'; // Menampilkan detail tujuan
            break;
        case 'gallery':
            echo '<script src="public/assets/js/refresh.js"></script>'; 
            include 'app/pages/gallery.php'; // Menampilkan galeri
            break;
        case 'about':
            include 'app/pages/about.php'; // Menampilkan halaman tentang
            break;
        case 'contact':
            include 'app/pages/contact.php'; // Menampilkan halaman kontak
            break;
        case 'paymentConfirmation':
            include 'app/pages/paymentConfirmation.php'; // Menampilkan halaman konfirmasi pembayaran
            break;
        case 'checkBooking':
            include 'app/pages/checkBooking.php'; // Menampilkan halaman cek booking
            break;
        default:
            include 'app/pages/404.php'; // Menampilkan halaman 404 jika halaman tidak ditemukan
            break;
    }
    // END: Menentukan halaman yang akan ditampilkan

    include 'app/layout/footer.php'; // START: Menyertakan footer halaman
?>
