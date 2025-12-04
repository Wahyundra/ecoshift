<?php
session_start();
include 'config/database.php';

$error = '';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'student') {
        header("Location: dashboard_student.php");
        exit();
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST['nis'];
    $password_input = $_POST['password'];

    if (empty($nis) || empty($password_input)) {
        $error = "NIS dan Nama Kelas tidak boleh kosong.";
    } else {
        $sql = "SELECT * FROM users WHERE nis = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nis);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // IMPORTANT: This is for demonstration only. Passwords should be hashed in a real application.
            if ($password_input === $user['password']) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header("Location: dashboard_admin.php");
                    exit();
                } else {
                    header("Location: dashboard_student.php");
                    exit();
                }
            } else {
                // Password incorrect
                $error = "Password yang Anda masukkan salah.";
            }
        } else {
            // User not found
            $error = "NIS yang Anda masukkan tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EcoShift</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/jameco.png">
</head>
<body>
    <div id="loading-screen">
        <img src="assets/img/ecoShift.png" alt="EcoShift Logo" class="logo">
    </div>
    <div class="login-container">
        <form method="POST" action="login.php">
            <img src="assets/img/jameco.png" alt="EcoShift Logo" class="logo">
            <h2>Login EcoShift</h2>
            <?php if (!empty($error)) { echo "<p class='error'>". htmlspecialchars($error) ."</p>"; } ?>
            <div class="input-group">
                <label for="nis">NIS</label>
                <input type="text" id="nis" name="nis" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>
