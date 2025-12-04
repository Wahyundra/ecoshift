<?php include 'includes/header.php'; ?>
<?php include 'config/database.php'; // Include database connection ?>

<div class="dashboard-content">
    <div class="datetime-container">
        <span id="live-date"></span>
        <span id="live-time"></span>
    </div>

    <h3>Dashboard Admin</h3>

    <div class="card">
        <div class="weekly-schedule-header">
            <h3>Jadwal Mingguan</h3>
            <?php
                // Set locale to Indonesian
                setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian_Indonesia.1252');
                $today_day_name = strftime('%A'); // Get full day name in Indonesian
            ?>
            <div class="current-day"><?php echo $today_day_name; ?></div>
        </div>

        <div class="today-schedule" style="margin-top: 20px;">
            <h4>Siswa yang Bertugas Hari Ini</h4>
            <?php
            $today_date = date('Y-m-d');
            $sql = "SELECT u.name, c.class_name
                    FROM schedule s
                    JOIN users u ON s.user_id = u.id
                    JOIN classes c ON u.class_id = c.id
                    WHERE s.task_date = ?
                    ORDER BY c.class_name, u.name";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $today_date);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead><tr><th>Nama Siswa</th><th>Kelas</th></tr></thead>';
                echo '<tbody>';
                while($row = $result->fetch_assoc()) {
                    echo '<tr><td>' . htmlspecialchars($row['name']) . '</td><td>' . htmlspecialchars($row['class_name']) . '</td></tr>';
                }
                echo '</tbody></table>';
            } else {
                echo "<p>Tidak ada siswa yang bertugas hari ini.</p>";
            }
            ?>
        </div>
    </div>


<?php
// Fetch stats for the dashboard
// Count new garbage reports
$sql_reports = "SELECT COUNT(*) as count FROM reports WHERE status = 'new'";
$result_reports = $conn->query($sql_reports);
$new_reports_count = $result_reports->fetch_assoc()['count'];

// Calculate picket compliance for today
$today_date_for_compliance = date('Y-m-d');

// 1. Get total students scheduled for today
$sql_total_today = "SELECT COUNT(*) as total FROM schedule WHERE task_date = ?";
$stmt_total = $conn->prepare($sql_total_today);
$stmt_total->bind_param("s", $today_date_for_compliance);
$stmt_total->execute();
$total_count = $stmt_total->get_result()->fetch_assoc()['total'];

// 2. Get students who have completed or been verified today
$sql_completed_today = "SELECT COUNT(*) as completed FROM schedule WHERE task_date = ? AND (status = 'completed' OR status = 'verified')";
$stmt_completed = $conn->prepare($sql_completed_today);
$stmt_completed->bind_param("s", $today_date_for_compliance);
$stmt_completed->execute();
$completed_count = $stmt_completed->get_result()->fetch_assoc()['completed'];

// 3. Calculate percentage
if ($total_count > 0) {
    $compliance_percentage = ($completed_count / $total_count) * 100;
} else {
    $compliance_percentage = 100; // If no one is scheduled, compliance is 100%
}
?>
    <div class="card">
        <div class="stats-panel">
            <div class="stat-card">
                <h4>Laporan Sampah Menumpuk</h4>
                <p><?php echo $new_reports_count; ?></p>
            </div>
            <div class="stat-card">
                <h4>Kepatuhan Piket</h4>
                <p><?php echo round($compliance_percentage); ?>%</p>
            </div>
        </div>
    </div>



</div>

<?php include 'includes/footer.php'; ?>
