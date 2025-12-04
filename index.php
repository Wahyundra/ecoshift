<?php
session_start();

// If user is already logged in, redirect them to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
        exit();
    } else {
        header("Location: dashboard_student.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EcoShift</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/jameco.png">
</head>
<body>
    <div id="loading-screen">
        <img src="assets/img/ecoShift.png" alt="EcoShift Logo" class="logo">
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 0); // Immediate redirect
        });
    </script>
</body>
</html>