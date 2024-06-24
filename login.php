<?php
include('database/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT id, username, password, role, division_id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login_user'] = $row['username'];
            $_SESSION['user_role'] = $row['role'];
            $_SESSION['division_id'] = $row['division_id'];

            if ($row['role'] == 'admin') {
                header("location: admin_dashboard.php");
            } else {
                header("location: user_dashboard.php");
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="vh-100 bg-secondary">
    <div class="container d-flex flex-column h-100">
        <h2 class="text-center fs-1 pt-5">Login</h2>
        <form method="POST" action="login.php" class="d-flex flex-column justify-content-center m-auto h-100 w-75">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required >
            </div>
            <button type="submit" class="btn btn-primary w-25 mt-3">Login</button>
        </form>
    </div>
</body>
</html>
