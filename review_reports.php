<?php
include 'includes/header.php';
include 'config/database.php';

$message = '';

// Handle actions from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = $_POST['report_id'];
    $action = $_POST['action'];

    if ($action == 'update') {
        $new_status = $_POST['new_status'];
        $sql_update = "UPDATE reports SET status = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $new_status, $report_id);
        if ($stmt_update->execute()) {
            $message = "Status laporan berhasil diperbarui.";
        } else {
            $message = "Error updating status: " . $stmt_update->error;
        }
    } elseif ($action == 'delete') {
        // Optional: Delete associated photo file first
        // $sql_photo = "SELECT photo FROM reports WHERE id = ?";
        // $stmt_photo = $conn->prepare($sql_photo);
        // $stmt_photo->bind_param("i", $report_id);
        // $stmt_photo->execute();
        // $result_photo = $stmt_photo->get_result();
        // if ($result_photo->num_rows > 0) {
        //     $row_photo = $result_photo->fetch_assoc();
        //     if (file_exists($row_photo['photo']) && $row_photo['photo'] != 'uploads/placeholder.jpg') {
        //         unlink($row_photo['photo']);
        //     }
        // }

        $sql_delete = "DELETE FROM reports WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $report_id);
        if ($stmt_delete->execute()) {
            $message = "Laporan berhasil dihapus.";
        } else {
            $message = "Error deleting report: " . $stmt_delete->error;
        }
    }
}

// Fetch all reports
$sql = "SELECT r.id, r.report_date, r.damage_type, r.location, r.photo, r.status, r.reporter_name, r.reporter_class
        FROM reports r
        ORDER BY r.report_date DESC";

$result = $conn->query($sql);
$reports = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}

$status_options = ['new', 'in_progress', 'done'];

?>

<div class="dashboard-content">
    <h3>Tinjauan Laporan Sampah Menumpuk</h3>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="card">
        <h4>Daftar Laporan</h4>
        <?php if (!empty($reports)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Lapor</th>
                        <th>Pelapor</th>
                        <th>Kelas</th>
                        <th>Lokasi</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <form method="POST" action="review_reports.php">
                                <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">
                                <td><?php echo htmlspecialchars($report['report_date']); ?></td>
                                <td><?php echo htmlspecialchars($report['reporter_name']); ?></td>
                                <td><?php echo htmlspecialchars($report['reporter_class']); ?></td>
                                <td><?php echo htmlspecialchars($report['location']); ?></td>
                                <td>
                                    <?php if ($report['photo'] && $report['photo'] != 'uploads/placeholder.jpg'): ?>
                                        <a href="<?php echo htmlspecialchars($report['photo']); ?>" target="_blank">
                                            <img src="<?php echo htmlspecialchars($report['photo']); ?>" alt="Foto Sampah" style="width: 50px; height: auto; border-radius: 4px;">
                                        </a>
                                    <?php else: ?>
                                        Tidak Ada
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <select name="new_status">
                                        <?php foreach ($status_options as $status): ?>
                                            <option value="<?php echo $status; ?>" <?php echo ($report['status'] == $status) ? 'selected' : ''; ?>><?php echo ucfirst(str_replace('_', ' ', $status)); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="action-buttons">
                                    <button type="submit" name="action" value="update">Update</button>
                                    <button type="submit" name="action" value="delete" onclick="return confirm('Anda yakin ingin menghapus laporan ini secara permanen?');" style="background-color: #e74c3c;">Hapus</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada laporan kerusakan yang ditemukan.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>