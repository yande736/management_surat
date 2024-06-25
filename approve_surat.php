<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'admin') {
    header("location: login.php");
    exit;
}

include('database/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $letter_id = $_POST['letter_id'];

    $sql = "SELECT division_id, date_created FROM letters WHERE id='$letter_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $division_id = $row['division_id'];
    $date_created = $row['date_created'];
    $month = date('m', strtotime($date_created));
    $year = date('Y', strtotime($date_created));

    // mengambil data nama divisi
    $sql = "SELECT name FROM division WHERE id='$division_id'";
    $result = mysqli_query($conn, $sql);
    $division = mysqli_fetch_assoc($result)['name'];

    $sql = "SELECT COUNT(*) as count FROM letters WHERE division_id='$division_id' AND YEAR(date_created)='$year' AND MONTH(date_created)='$month'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_fetch_assoc($result)['count'] + 1;

    // Generate nomor surat
    $letter_number = sprintf("%03d/%s/%02d/%04d", $count, $division, $month, $year);

    // Update surat status dan nomor
    $sql = "UPDATE letters SET status='approved', letter_number='$letter_number' WHERE id='$letter_id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Fetch pending letters for approval
$sql = "SELECT letters.id, letters.file_name, division.name as division_name, letters.date_created 
        FROM letters
        JOIN division ON letters.division_id = division.id 
        WHERE letters.status='pending'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Surat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="py-5">Approve Surat</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>File</th>
                    <th>Divisi</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td><a href='uploads/" . $row['file_name'] . "' target='_blank'>" . $row['file_name'] . "</a></td>";
                    echo "<td>" . $row['division_name'] . "</td>";
                    echo "<td>" . date('d-m-Y', strtotime($row['date_created'])) . "</td>";
                    echo "<td>";
                    echo "<form action='approve_surat.php' method='post'>";
                    echo "<input type='hidden' name='letter_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-info">Kembali</a>
    </div>
</body>
</html>
