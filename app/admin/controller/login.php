<?php
session_start(); // Mulai sesi
include '../../config/database.php'; // Koneksi ke database
// START: Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password']; 
// END: Cek apakah request method adalah POST

    // START: Query untuk mengambil data user dari database
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) { 
            $_SESSION['loggedin'] = true;  
            $_SESSION['user_id'] = $user['id'];  
            header('Location: ../pages/dashboard.php');  
            exit();  
        } else {
            header('Location: ../index.php?error=Invalid email or password'); 
            exit();  
        }
    } else {
        header('Location: ../index.php?error=Invalid email or password');  
        exit();  
    }
    // END: Query untuk mengambil data user dari database
// START: Jika request method bukan POST
} else {  
    header('Location: ../index.php');  
    exit();  
}
// END: Jika request method bukan POST
?>
