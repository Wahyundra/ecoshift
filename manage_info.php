<?php
include 'includes/header.php';
include 'config/database.php';

$message = '';
$edit_announcement = null;

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_announcement']) || isset($_POST['update_announcement'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (isset($_POST['update_announcement'])) {
            $id = $_POST['announcement_id'];
            $sql = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $title, $content, $id);
            if ($stmt->execute()) {
                $message = "Pengumuman berhasil diperbarui.";
            } else {
                $message = "Error: " . $stmt->error;
            }
        } else {
            $sql = "INSERT INTO announcements (title, content) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title, $content);
            if ($stmt->execute()) {
                $message = "Pengumuman berhasil ditambahkan.";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }
    } elseif (isset($_POST['delete_announcement'])) {
        $id = $_POST['announcement_id'];
        $sql = "DELETE FROM announcements WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Pengumuman berhasil dihapus.";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}

// Handle edit request (populate form)
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_announcement = $result->fetch_assoc();
    }
}

// Fetch all announcements
$announcements = [];
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}

?>

<div class="dashboard-content">
    <h3>Kelola Informasi</h3>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="card">
        <h4><?php echo ($edit_announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru'; ?></h4>
        <form method="POST" action="manage_info.php">
            <?php if ($edit_announcement): ?>
                <input type="hidden" name="announcement_id" value="<?php echo $edit_announcement['id']; ?>">
            <?php endif; ?>
            <div class="input-group">
                <label for="title">Judul</label>
                <input type="text" id="title" name="title" value="<?php echo ($edit_announcement) ? htmlspecialchars($edit_announcement['title']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label for="content">Isi Pengumuman</label>
                <textarea id="content" name="content" rows="5" required><?php echo ($edit_announcement) ? htmlspecialchars($edit_announcement['content']) : ''; ?></textarea>
            </div>
            <button type="submit" name="<?php echo ($edit_announcement) ? 'update_announcement' : 'add_announcement'; ?>">
                <?php echo ($edit_announcement) ? 'Perbarui Pengumuman' : 'Tambah Pengumuman'; ?>
            </button>
            <?php if ($edit_announcement): ?>
                <a href="manage_info.php" class="button" style="background-color: #6c757d; text-decoration: none; padding: 10px; border-radius: 4px; color: white; display: inline-block; margin-left: 10px;">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card" style="margin-top: 20px;">
        <h4>Daftar Pengumuman</h4>
        <?php if (!empty($announcements)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $announcement): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($announcement['title']); ?></td>
                            <td><?php echo htmlspecialchars($announcement['content']); ?></td>
                            <td><?php echo htmlspecialchars($announcement['created_at']); ?></td>
                            <td class="action-buttons">
                                <a href="manage_info.php?action=edit&id=<?php echo $announcement['id']; ?>">Edit</a>
                                <form method="POST" action="manage_info.php" style="display: inline-block; margin-left: 5px;">
                                    <input type="hidden" name="announcement_id" value="<?php echo $announcement['id']; ?>">
                                    <button type="submit" name="delete_announcement" onclick="return confirm('Anda yakin ingin menghapus pengumuman ini?');" style="background-color: #e74c3c;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada pengumuman saat ini.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>