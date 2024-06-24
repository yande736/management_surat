<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'admin') {
    header("location: login.php");
    exit;
}

include('database/db.php');

// Menentukan jumlah surat yang ditampilkan per halaman
$per_page = 5;

// Mengambil nomor halaman dari parameter GET, defaultnya halaman 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $per_page;

// Kueri SQL untuk mengambil data surat dengan limit dan offset
$sql = "SELECT letters.id, letters.letter_number, letters.status, letters.file_name, DATE_FORMAT(letters.date_created, '%d-%m-%Y') AS date_created, division.name as division_name 
        FROM letters 
        JOIN division ON letters.division_id = division.id
        ORDER BY letters.id DESC
        LIMIT $start_from, $per_page";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include admin sidebar -->
            <div class="col-2">
                <?php include('layout/admin_sidebar.php'); ?>
            </div>
            <!-- Main content -->
            <div class="col-10">
                <h1 class="py-4">Admin Dashboard</h1>
                <hr class="mb-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Tanggal Diterima</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $start_from + 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . ($row['status'] == 'approved' ? $row['letter_number'] : 'Pending Approval') . "</td>";
                            echo "<td>" . $row['division_name'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td><a href='uploads/" . $row['file_name'] . "' target='_blank'>" . $row['file_name'] . "</a></td>";
                            echo "<td>" . $row['date_created'] . "</td>";
                            echo "<td>";
                            echo "<form action='delete_surat.php' method='post' style='display:inline-block; margin-left: 5px;'>";
                            echo "<input type='hidden' name='letter_id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='delete' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this letter?\");'><i class='bx bx-trash'></i></button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Navigasi Halaman -->
                <?php
                // Kueri untuk menghitung jumlah total surat
                $sql_count = "SELECT COUNT(*) AS total FROM letters";
                $result_count = mysqli_query($conn, $sql_count);
                $row_count = mysqli_fetch_assoc($result_count);
                $total_surat = $row_count['total'];
                $total_pages = ceil($total_surat / $per_page);

                // Menampilkan navigasi halaman jika lebih dari satu halaman
                if ($total_pages > 1) {
                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='admin_dashboard.php?page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
