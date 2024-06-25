<!-- dibuat oleh
I Gede Rino Saputra
A.A Sagung Mas Pradnya Praniswari
I Gusti Ajung Bagus Ogastya Avatara Rayna
I Wayan Adit Saputra
Ni Putu Satiya Pramita Sari
I Gede Bagus Agastya Mahadipta
I Made Wira Wardana
I Komang Lanag Adiwijaya
-->

# Sistem Manajemen Surat

Sistem Manajemen Surat adalah aplikasi web yang dirancang untuk mengelola surat masuk dan keluar, dengan fitur untuk mengunggah, mengedit, menghapus, dan mengesahkan surat. Aplikasi ini juga menyediakan fitur paginasi untuk mengelola tampilan surat yang panjang.

## Fitur Utama

- **Autentikasi**: Login untuk admin dan pengguna.
- **Manajemen Surat**: Tambah, hapus, dan setujui surat.
- **Upload File**: Mengunggah surat dengan drag-and-drop menggunakan Dropzone.js.
- **Paginasi**: Menampilkan surat dengan paginasi untuk mempermudah navigasi.
- **Dashboard Terpisah**: Dashboard untuk admin dan pengguna dengan hak akses berbeda.
- **Sidebar**: Sidebar navigasi untuk akses cepat ke fitur utama.

## Persyaratan

- PHP 7.4 atau lebih baru
- MySQL 5.7 atau lebih baru
- XAMPP atau server web serupa
- Composer (untuk mengelola dependensi PHP)

## Instalasi

1. **Clone repositori ini:**

   ```bash
   git clone https://github.com/yande736/management_surat.git
   ```

2. **Navigasi ke direktori proyek:**

   ```bash
   cd management_surat
   ```

3. **Instal dependensi dengan Composer:**

   ```bash
   composer install
   ```

4. **Buat database baru di MySQL:**

   ```sql
   CREATE DATABASE surat_db;
   ```

5. **Import struktur database dan data awal:**

   Import file `surat_db.sql` yang ada di dalam direktori proyek ke database `surat_db`.

6. **Konfigurasi database:**

   Buka file `database/db.php` dan sesuaikan pengaturan database dengan konfigurasi lokal Anda:

   ```php
   <?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "surat_db";

   $conn = new mysqli($servername, $username, $password, $dbname);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

## Menjalankan Aplikasi

1. **Jalankan XAMPP atau server web serupa dan pastikan Apache serta MySQL aktif.**

2. **Akses aplikasi melalui browser:**

   ```bash
   http://localhost/management_surat
   ```

3. **Login ke aplikasi:**

   - **Admin**:

     - Username: admin
     - Password: admin

   - **User**:
     - Username: KaryawanFinace
     - Password: finace123

## Struktur Direktori

- `database/db.php`: Konfigurasi koneksi database.
- `layout/admin_sidebar.php`: Sidebar untuk admin.
- `layout/user_sidebar.php`: Sidebar untuk pengguna.
- `admin_dashboard.php`: Dashboard utama untuk admin.
- `user_dashboard.php`: Dashboard utama untuk pengguna.
- `approve_surat.php`: Halaman untuk mengesahkan surat oleh admin.
- `delete_surat.php`: Fungsi untuk menghapus surat.
- `uploads/`: Direktori tempat menyimpan file surat yang diunggah.

## Fitur Tambahan

### Paginasi

Menampilkan maksimal 5 surat per halaman dengan paginasi:

- **Query dengan Paginasi:**

  ```php
  $per_page = 5;
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start_from = ($current_page - 1) * $per_page;

  $sql = "SELECT ... LIMIT $start_from, $per_page";
  ```

- **Navigasi Halaman:**

  ```php
  for ($i = 1; $i <= $total_pages; $i++) {
      echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='admin_dashboard.php?page=$i'>$i</a></li>";
  }
  ```

## Kontribusi

Kontribusi sangat diterima! Silakan fork repositori ini dan ajukan pull request dengan perubahan Anda.

<!-- INSTITUT TEKNOLOGI DAN BISNIS STIKOM BALI -->
<!-- 2024 -->
