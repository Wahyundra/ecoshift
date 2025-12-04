<?php
include 'includes/header.php';
include 'config/database.php';

$message = '';

// Handle damage report submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_damage_report'])) {
    $reporter_id = $_SESSION['user_id'];
    $reporter_name = $_POST['reporter_name'];
    $reporter_class = $_POST['reporter_class'];
    $location = $_POST['location'];
    $damage_type = "Sampah Menumpuk"; // Hardcoded as per user request
    $photo_path = 'uploads/placeholder.jpg'; // Default photo

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        // Create uploads directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid('', true) . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_path = $target_file;
        }
    }

    $sql_insert_report = "INSERT INTO reports (reporter_id, reporter_name, reporter_class, damage_type, location, photo, status) VALUES (?, ?, ?, ?, ?, ?, 'new')";
    $stmt_insert_report = $conn->prepare($sql_insert_report);
    $stmt_insert_report->bind_param("isssss", $reporter_id, $reporter_name, $reporter_class, $damage_type, $location, $photo_path);

    if ($stmt_insert_report->execute()) {
        $message = "Kamu berhasil melaporkan sampah menumpuk.";
    } else {
        $message = "Error: " . $stmt_insert_report->error;
    }
}

// Fetch damage report history for current user
$report_history = [];
$sql_report_history = "SELECT r.report_date, r.damage_type, r.location, r.status, r.reporter_name, r.reporter_class 
                     FROM reports r 
                     WHERE r.reporter_id = ? ORDER BY r.report_date DESC";
$stmt_report_history = $conn->prepare($sql_report_history);
$stmt_report_history->bind_param("i", $_SESSION['user_id']);
$stmt_report_history->execute();
$result_report_history = $stmt_report_history->get_result();
while ($row = $result_report_history->fetch_assoc()) {
    $report_history[] = $row;
}

?>

<div class="dashboard-content">
    <h3>Laporan Sampah Menumpuk</h3>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="tabs">
        <button class="tab-button active" onclick="openTab(event, 'damage-report')">Lapor Sampah Menumpuk</button>
    </div>

    <div id="damage-report" class="tab-content active">
        <div class="card">
            <h4>Formulir Lapor Sampah Menumpuk</h4>
            <form method="POST" action="reports.php" enctype="multipart/form-data">
                <?php
                // Fetch current user's class name to pre-fill the input
                $current_user_id = $_SESSION['user_id'];
                $sql_current_user_class = "SELECT c.class_name FROM users u JOIN classes c ON u.class_id = c.id WHERE u.id = ?";
                $stmt_current_user_class = $conn->prepare($sql_current_user_class);
                $stmt_current_user_class->bind_param("i", $current_user_id);
                $stmt_current_user_class->execute();
                $result_current_user_class = $stmt_current_user_class->get_result();
                $current_user_class_info = $result_current_user_class->fetch_assoc();
                $prefill_class_name = $current_user_class_info ? htmlspecialchars($current_user_class_info['class_name']) : '';
                ?>
                <div class="input-group">
                    <p>Nama pelapor <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong> dari kelas <strong><?php echo $prefill_class_name; ?></strong></p>
                    <input type="hidden" name="reporter_name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>">
                    <input type="hidden" name="reporter_class" value="<?php echo $prefill_class_name; ?>">
                </div>

                <div class="input-group">
                    <label for="location">Lokasi Detail</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="input-group">
                    <label for="photo">Unggah Foto Bukti</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                <button type="submit" name="submit_damage_report">Lapor Sampah Menumpuk</button>
            </form>
        </div>

        <div class="card">
            <h4>Riwayat Laporan Sampah Menumpuk Saya</h4>
            <?php if (!empty($report_history)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal Lapor</th>
                            <th>Pelapor</th>
                            <th>Kelas</th>
                            <th>Jenis Laporan</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report_history as $report): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($report['report_date']); ?></td>
                                <td><?php echo htmlspecialchars($report['reporter_name']); ?></td>
                                <td><?php echo htmlspecialchars($report['reporter_class']); ?></td>
                                <td><?php echo htmlspecialchars($report['damage_type']); ?></td>
                                <td><?php echo htmlspecialchars($report['location']); ?></td>
                                <td><?php echo htmlspecialchars($report['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada riwayat laporan sampah menumpuk.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>