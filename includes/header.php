<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoShift</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/jameco.png">
</head>
<body>
<?php if ($_SESSION['role'] == 'student'): ?>
    <div class="navbar">
        <div class="logo-container">
            <img src="assets/img/jameco.png" alt="Jameco Logo" class="logo">
            <h2><a href="dashboard_student.php" style="text-decoration: none; color: inherit;">EcoShift</a></h2>
            <button class="hamburger-menu" aria-label="Toggle navigation">&#9776;</button>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="dashboard_student.php">Beranda</a></li>
                <li><a href="schedule.php">Jadwal Piket</a></li>
                <li><a href="reports.php">Laporan Sampah</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
<?php else: ?>
    <div class="navbar admin-navbar">
        <div class="logo-container">
            <img src="assets/img/jameco.png" alt="Jameco Logo" class="logo">
            <h2>EcoShift Admin</h2>
            <button class="hamburger-menu" aria-label="Toggle navigation">&#9776;</button>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="dashboard_admin.php">Dashboard</a></li>
                <li><a href="manage_schedule.php">Manajemen Jadwal</a></li>

                <li><a href="review_reports.php">Tinjauan Laporan</a></li>
                <li><a href="manage_info.php">Kelola Info</a></li>
                <li><a href="manage_classes.php">Kelola Kelas</a></li>
            </ul>
            <div class="user-info">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="content">
<?php endif; ?>