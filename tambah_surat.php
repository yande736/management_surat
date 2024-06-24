<?php
session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'user') {
    header("location: login.php");
    exit;
}

include('database/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $division_id = $_SESSION['division_id'];
    $status = 'pending';

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 900000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "pdf" && $fileType != "docx" && $fileType != "doc") {
        echo "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOCX & DOC files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_name = basename($_FILES["file"]["name"]);
            $date_created = date("Y-m-d H:i:s");

            $sql = "INSERT INTO letters (division_id, status, file_name, date_created) VALUES ('$division_id', '$status', '$file_name', '$date_created')";
            
            if (mysqli_query($conn, $sql)) {
                header("Location: user_dashboard.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Surat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <h2>Tambah Surat</h2>
        <form method="POST" action="tambah_surat.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Upload File</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Surat</button>
            <a href="user_dashboard.php" class="btn btn-info">Kembali</a>
        </form>
    </div>
</body>
</html>
