<?php
include 'includes/header.php';
include 'config/database.php';

$message = '';

// Handle major actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['major_action'])) {
    if ($_POST['major_action'] == 'add') {
        $major_name = $_POST['major_name'];
        $sql = "INSERT INTO majors (major_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $major_name);
        if ($stmt->execute()) {
            $message = "Jurusan berhasil ditambahkan.";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}

// Handle class actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_action'])) {
    if ($_POST['class_action'] == 'add') {
        $class_name = $_POST['class_name'];
        $major_id = $_POST['major_id'];
        $sql = "INSERT INTO classes (class_name, major_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $class_name, $major_id);
        if ($stmt->execute()) {
            $message = "Kelas berhasil ditambahkan.";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}

// Fetch majors and classes
$majors = [];
$sql_majors = "SELECT * FROM majors ORDER BY major_name";
$result_majors = $conn->query($sql_majors);
while ($row = $result_majors->fetch_assoc()) {
    $majors[] = $row;
}

$classes = [];
$sql_classes = "SELECT c.id, c.class_name, m.major_name FROM classes c JOIN majors m ON c.major_id = m.id ORDER BY m.major_name, c.class_name";
$result_classes = $conn->query($sql_classes);
while ($row = $result_classes->fetch_assoc()) {
    $classes[] = $row;
}

?>

<div class="dashboard-content">
    <h3>Manajemen Jurusan dan Kelas</h3>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="card">
        <h4>Tambah Jurusan Baru</h4>
        <form method="POST" action="manage_classes.php">
            <input type="hidden" name="major_action" value="add">
            <div class="input-group">
                <label for="major_name">Nama Jurusan</label>
                <input type="text" id="major_name" name="major_name" required>
            </div>
            <button type="submit">Tambah Jurusan</button>
        </form>
    </div>

    <div class="card" style="margin-top: 20px;">
        <h4>Tambah Kelas Baru</h4>
        <form method="POST" action="manage_classes.php">
            <input type="hidden" name="class_action" value="add">
            <div class="input-group">
                <label for="class_name">Nama Kelas</label>
                <input type="text" id="class_name" name="class_name" required>
            </div>
            <div class="input-group">
                <label for="major_id">Pilih Jurusan</label>
                <select id="major_id" name="major_id" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <?php foreach ($majors as $major): ?>
                        <option value="<?php echo $major['id']; ?>"><?php echo htmlspecialchars($major['major_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Tambah Kelas</button>
        </form>
    </div>

    <div class="card" style="margin-top: 20px;">
        <h4>Daftar Jurusan</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($majors as $major): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($major['major_name']); ?></td>
                        <td>
                            <a href="#">Edit</a> | <a href="#" onclick="return confirm('Anda yakin ingin menghapus jurusan ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-top: 20px;">
        <h4>Daftar Kelas</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                        <td><?php echo htmlspecialchars($class['major_name']); ?></td>
                        <td>
                            <a href="#">Edit</a> | <a href="#" onclick="return confirm('Anda yakin ingin menghapus kelas ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
