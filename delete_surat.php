<?php
include('database/db.php');
session_start();

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'admin') {
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $letter_id = mysqli_real_escape_string($conn, $_POST['letter_id']);

    // Fetch the file name to delete the file from the server
    $sql = "SELECT file_name FROM letters WHERE id='$letter_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $file_name = $row['file_name'];
    $file_path = "uploads/" . $file_name;

    // Delete the letter from the database
    $sql = "DELETE FROM letters WHERE id='$letter_id'";
    if (mysqli_query($conn, $sql)) {
        // Delete the file from the server
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
