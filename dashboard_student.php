<?php include 'includes/header.php'; ?>
<?php
include 'config/database.php';

// Check if it's the student's schedule today
$is_piket_day = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $today = date('Y-m-d');

    $sql_check_schedule = "SELECT COUNT(*) as count FROM schedule WHERE user_id = ? AND task_date = ?";
    $stmt_check = $conn->prepare($sql_check_schedule);
    $stmt_check->bind_param("is", $user_id, $today);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check && $row_check['count'] > 0) {
        $is_piket_day = true;
    }
    $stmt_check->close();
}

$welcome_message = $is_piket_day ? "Hari ini adalah jadwal membuang sampah anda, tolong segera di  buang sampahnya" : "Hari ini bukan jadwal piket anda";
?>

<div class="dashboard-content">
    <div class="hero-section">
        <div class="welcome-container">
            <div class="welcome-left">
                <h3>Selamat datang <?php echo htmlspecialchars($_SESSION['name']); ?></h3>
                <h2><strong><?php echo $welcome_message; ?></strong></h2>
                
                <div class="welcome-buttons">
                    <a href="schedule.php" class="btn-welcome">Lihat Jadwal </a>
                    <a href="reports.php" class="btn-welcome">Lapor Sampah Menumpuk</a>
                </div>
            </div>
            <div class="welcome-right">
                <img src="assets/img/buang sampah.jpg" alt="Ilustrasi Membuang Sampah" class="welcome-logo">
            </div>
        </div>
    </div>

    <div class="schedule-image-section">
        <div class="schedule-image-left">
            <img src="assets/img/jadwalweek.jpg" alt="Jadwal Mingguan" class="schedule-image">
        </div>
        <div class="schedule-image-right">
            <div class="weekly-schedule-header">
                <h3>Jadwal Harian</h3>
                <?php
                    // Set locale to Indonesian
                    setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian_Indonesia.1252');
                    $today_day_name = strftime('%A'); // Get full day name in Indonesian
                ?>
                <div class="current-day"><?php echo $today_day_name; ?></div>
            </div>

            <div class="today-schedule">
                <h4>Siswa yang Bertugas Hari Ini</h4>
                <?php
                $today_date = date('Y-m-d');
                $sql = "SELECT u.name, c.class_name, s.task_description
                        FROM schedule s
                        JOIN users u ON s.user_id = u.id
                        JOIN classes c ON u.class_id = c.id
                        WHERE s.task_date = ?
                        ORDER BY c.class_name, u.name";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $today_date);
                $stmt->execute();
                $result = $stmt->get_result();
                $num_rows = $result->num_rows;

                if ($num_rows > 0) {
                    echo '<div id="today-schedule-list" class="collapsible-list">';
                    echo '<ul>';
                    while($row = $result->fetch_assoc()) {
                        echo '<li><strong>' . htmlspecialchars($row['name']) . '</strong> (' . htmlspecialchars($row['class_name']) . ') - ' . htmlspecialchars($row['task_description']) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    if ($num_rows > 5) { // Only show button if more than 5 students
                        echo '<button id="toggle-today-schedule" class="toggle-button">Lihat Semuanya</button>';
                    }
                } else {
                    echo "<p>Tidak ada jadwal piket untuk hari ini.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 40px;">
        <h4>Pengumuman Terbaru</h4>
        <?php
        $sql_announcements = "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 3";
        $result_announcements = $conn->query($sql_announcements);

        if ($result_announcements->num_rows > 0) {
            while($row = $result_announcements->fetch_assoc()) {
                echo "<div><h5>" . htmlspecialchars($row["title"]) . "</h5><p>" . htmlspecialchars($row["content"]) . "</p><hr></div>";
            }
        } else {
            echo "<p>Tidak ada pengumuman saat ini.</p>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
