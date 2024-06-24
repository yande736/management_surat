<?php
session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'user') {
    header("location: login.php");
    exit;
}

include('database/db.php');

$division_id = $_SESSION['division_id'];

$sql = "SELECT letters.id, letters.letter_number, letters.status, letters.file_name, letters.date_created, DATE_FORMAT(letters.date_created, '%m') AS month, DATE_FORMAT(letters.date_created, '%Y') AS year, division.name as division_name 
        FROM letters 
        JOIN division ON letters.division_id = division.id 
        WHERE letters.division_id = '$division_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include user sidebar -->
            <div class="col-2">
                <?php include('layout/user_sidebar.php'); ?>
            </div>
            <!-- Main content -->
            <div class="col-10">
                <h1 class="py-4">User Dashboard</h1>
                <hr class="mb-5">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . ($row['status'] == 'approved' ? $row['letter_number'] : 'Pending Approval') . "</td>";
                            echo "<td>" . $row['division_name'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td><a href='uploads/" . $row['file_name'] . "' target='_blank'>" . $row['file_name'] . "</a></td>";
                            echo "<td>" . date('d-m-Y', strtotime($row['date_created'])) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="tambah_surat.php" class="btn btn-primary text-end">Tambah Surat</a>
            </div>
        </div>
    </div>
</body>
</html>