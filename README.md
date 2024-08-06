# WONDERFUL INDONESIA

Wonderful Indonesia adalah aplikasi berbasis web yang menyediakan berbagai informasi dan layanan terkait destinasi wisata, termasuk pemesanan, konfirmasi pembayaran, dan pengecekan booking. Aplikasi ini dibangun menggunakan bahasa pemrograman PHP native.

## Fitur

- Home: Halaman utama dengan informasi umum.
- Destination: Menampilkan daftar destinasi wisata.
- Gallery: Galeri foto destinasi wisata.
- About: Informasi tentang aplikasi atau organisasi.
- Contact: Formulir kontak untuk komunikasi.
- Payment Confirmation: Konfirmasi pembayaran untuk pemesanan.
- Check Booking: Memeriksa status booking.

## Variabel Lingkungan

Untuk menjalankan proyek ini, Anda perlu menambahkan variabel lingkungan berikut ke dalam project:

- PHP 7.4 atau lebih baru
- MySQL 5.7 atau lebih baru
- Bootstrap 4.6
- jQuery 3.5
- Popper.js 2.5.2
- Font Awesome v4

## Instalasi

### Setup Folder

1. **Buka folder `htdocs`:**

   - Lokasi biasanya di `C:\xampp\htdocs` (Windows) atau `/opt/lampp/htdocs` (Linux).

2. **Buat folder:**

   - Di `htdocs`, klik kanan dan pilih `New Folder` (Windows) atau gunakan perintah `mkdir New Folder` di terminal (Linux).

3. **Pindahkan atau salin konten:**
   - Pindahkan atau salin semua file dan folder yang diperlukan ke dalam folder yang sudah dibuat.

### Setup Database

- Buat database baru di MySQL.
- Impor file SQL dari direktori `public/assets/database/` untuk membuat tabel yang diperlukan.

### Konfigurasi Database

- Edit `config.php` untuk menyesuaikan pengaturan database.

### Jalankan Aplikasi

- Jika menggunakan server lokal, pastikan Apache/Nginx dan MySQL berjalan.
- Akses aplikasi melalui browser dengan URL yang sesuai, misal http://localhost/VSGA/.

## Struktur Proyek

- `index.php`: Halaman utama dan pengelola routing.
- `config/`: Konfigurasi database.
- `controller/`: Berisi logika aplikasi, seperti konfirmasi pembayaran dan pembatalan booking.
- `pages/`: Halaman-halaman seperti Home, Destination, Gallery, About, Contact, Payment Confirmation, Check Booking, dan Destination Detail.
- `assets/`: Berisi file CSS, JavaScript, dan gambar.
- `admin/`: Berisi semua yang berhubungan dengan admin sebagai pengelola web.

## Admin

Untuk masuk sebagai admin, kunjungi link ini: `http://localhost/VSGA/?page=admin`. Anda akan diarahkan ke halaman login admin.

Akun Admin default:

- Email: admin@gmail.com
- Password: admin

## License

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

[Wonderful Indonesia](https://www.indonesia.travel/gb/en/indtravel-bio.html)

## Authors

- [@Rinaldi A Prayuda](https://github.com/rapsign)

## 🔗 Links

[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://rinaldi-a-prayuda.vercel.app/)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/rinaldi-a-prayuda-523a0a2b3/)

## Notes\*

Aplikasi web ini dibuat hanya untuk pelatihan VSGA yang diadakan oleh Digitalent Kominfo.
