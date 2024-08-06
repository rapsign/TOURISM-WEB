<?php
// START: Informasi koneksi database
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "wonderful_indonesia"; 

// START: Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// START: Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// END: Mengecek koneksi
// END: Membuat koneksi ke database
?>
