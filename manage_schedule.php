<?php
include 'includes/header.php';
include 'config/database.php';

$message = '';
$edit_schedule = null;

// Get selected major and class from URL
$selected_major_id = isset($_GET['major_id']) ? $_GET['major_id'] : null;
$selected_class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;

// Fetch majors for dropdown
$majors = [];
$sql_majors = "SELECT id, major_name FROM majors ORDER BY major_name";
$result_majors = $conn->query($sql_majors);
while ($row = $result_majors->fetch_assoc()) {
    $majors[] = $row;
}

// Fetch classes for dropdown based on selected major
$classes = [];
if ($selected_major_id) {
    $sql_classes = "SELECT id, class_name FROM classes WHERE major_id = ? ORDER BY class_name";
    $stmt_classes = $conn->prepare($sql_classes);
    $stmt_classes->bind_param("i", $selected_major_id);
    $stmt_classes->execute();
    $result_classes = $stmt_classes->get_result();
    while ($row = $result_classes->fetch_assoc()) {
        $classes[] = $row;
    }
}

// Handle verification request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'verify') {
    $schedule_id_to_verify = $_POST['schedule_id'];
    $sql_verify_task = "UPDATE schedule SET status = 'verified' WHERE id = ?";
    $stmt_verify = $conn->prepare($sql_verify_task);
    $stmt_verify->bind_param("i", $schedule_id_to_verify);
    if ($stmt_verify->execute()) {
        $message = "Tugas berhasil diverifikasi.";
    } else {
        $message = "Error: Gagal memverifikasi tugas.";
    }
}

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $schedule_id = $_GET['id'];
    $sql_delete = "DELETE FROM schedule WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $schedule_id);
    if ($stmt_delete->execute()) {
        $message = "Jadwal berhasil dihapus. Perubahan akan terlihat di halaman Beranda siswa.";
    } else {
        $message = "Error menghapus jadwal: " . $stmt_delete->error;
    }
    header("Location: manage_schedule.php?major_id=" . $selected_major_id . "&class_id=" . $selected_class_id . "&message=" . urlencode($message));
    exit();
}

// Handle edit request (populate form)
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $schedule_id = $_GET['id'];
    $sql_edit = "SELECT s.id, s.user_id, s.task_date, s.task_description, u.class_id, c.major_id
                 FROM schedule s 
                 JOIN users u ON s.user_id = u.id
                 JOIN classes c ON u.class_id = c.id
                 WHERE s.id = ?";
    $stmt_edit = $conn->prepare($sql_edit);
    $stmt_edit->bind_param("i", $schedule_id);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    if ($result_edit->num_rows > 0) {
        $edit_schedule = $result_edit->fetch_assoc();
        // Set selected major and class for form to correctly load users
        $selected_major_id = $edit_schedule['major_id'];
        $selected_class_id = $edit_schedule['class_id'];
    }
}




// Handle monthly schedule generation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_monthly_schedule'])) {
    $start_date_str = $_POST['start_date'];
    $task_description_monthly = $_POST['task_description_monthly'];
    $start_offset = isset($_POST['start_student_offset']) ? (int)$_POST['start_student_offset'] - 1 : 0;
    if ($start_offset < 0) {
        $start_offset = 0;
    }

    $start_date = new DateTime($start_date_str);
    $end_date = (new DateTime($start_date_str))->modify('+1 month -1 day'); // Schedule for one month

    // Fetch all students grouped by class
    $students_by_class = [];
    $sql_all_students = "SELECT u.id, u.name, u.class_id, c.class_name FROM users u JOIN classes c ON u.class_id = c.id WHERE u.role = 'student' ORDER BY u.class_id, u.name";
    $result_all_students = $conn->query($sql_all_students);
    while ($row = $result_all_students->fetch_assoc()) {
        $students_by_class[$row['class_id']][] = $row;
    }

    // Initialize pointers for student rotation
    $class_student_pointers = [];
    foreach ($students_by_class as $class_id => $students_in_class) {
        if (!empty($students_in_class)) {
            $class_student_pointers[$class_id] = $start_offset % count($students_in_class);
        } else {
            $class_student_pointers[$class_id] = 0;
        }
    }

    $current_date = clone $start_date;
    $generated_count = 0;

    while ($current_date <= $end_date) {
        // Skip weekends (Saturday=6, Sunday=0)
        if ($current_date->format('N') >= 6) { // 6 for Saturday, 7 for Sunday (ISO-8601 numeric representation of the day of the week)
            $current_date->modify('+1 day');
            continue;
        }

        foreach ($students_by_class as $class_id => $students_in_class) {
            if (empty($students_in_class)) {
                continue; // Skip if no students in class
            }

            $num_students_in_class = count($students_in_class);
            $num_to_assign = min(2, $num_students_in_class);

            for ($i = 0; $i < $num_to_assign; $i++) {
                $student_index = ($class_student_pointers[$class_id] + $i) % $num_students_in_class;
                $selected_student = $students_in_class[$student_index];

                // Insert into schedule
                $sql_insert_schedule = "INSERT INTO schedule (user_id, task_date, task_description) VALUES (?, ?, ?)";
                $stmt_insert_schedule = $conn->prepare($sql_insert_schedule);
                $task_date_str = $current_date->format('Y-m-d');
                $stmt_insert_schedule->bind_param("iss", $selected_student['id'], $task_date_str, $task_description_monthly);
                $stmt_insert_schedule->execute();
                $stmt_insert_schedule->close();
                $generated_count++;
            }

            // Move pointer for next rotation for the class
            if ($num_students_in_class > 0) {
                $class_student_pointers[$class_id] = ($class_student_pointers[$class_id] + $num_to_assign) % $num_students_in_class;
            }
        }
        $current_date->modify('+1 day');
    }

    $message = "Jadwal bulanan berhasil digenerate. Total " . $generated_count . " jadwal ditambahkan.";
    header("Location: manage_schedule.php?message=" . urlencode($message));
    exit();
}

// Handle delete all schedules request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all_schedules'])) {
    // First, delete from task_verifications (child table)
    $sql_delete_verifications = "DELETE FROM task_verifications";
    if ($conn->query($sql_delete_verifications)) {
        // Then, delete from schedule (parent table)
        $sql_delete_schedule = "DELETE FROM schedule";
        if ($conn->query($sql_delete_schedule)) {
            $message = "Semua jadwal dan verifikasi terkait berhasil dihapus.";
        } else {
            $message = "Error menghapus jadwal: " . $conn->error;
        }
    } else {
        $message = "Error menghapus verifikasi tugas: " . $conn->error;
    }
    header("Location: manage_schedule.php?message=" . urlencode($message));
    exit();
}

// Get message from URL if redirected
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}

// Fetch classes for dropdown
$classes = [];
$sql_classes = "SELECT id, class_name FROM classes ORDER BY class_name";
$result_classes = $conn->query($sql_classes);
while ($row = $result_classes->fetch_assoc()) {
    $classes[] = $row;
}

// Fetch users for dropdown
$users = [];
if ($selected_class_id) {
    $sql_users = "SELECT id, name FROM users WHERE class_id = ? AND role = 'student' ORDER BY name";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("i", $selected_class_id);
    $stmt_users->execute();
    $result_users = $stmt_users->get_result();
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch existing schedules
$schedules = [];
$sql_schedules = "SELECT s.id, s.task_date, s.task_description, u.name as nama_siswa, c.class_name 
                  FROM schedule s
                  JOIN users u ON s.user_id = u.id
                  JOIN classes c ON u.class_id = c.id";

if ($selected_class_id) {
    $sql_schedules .= " WHERE c.id = ?";
}

$sql_schedules .= " ORDER BY s.task_date ASC, c.class_name, u.name";
$stmt = $conn->prepare($sql_schedules);

if ($selected_class_id) {
    $stmt->bind_param("i", $selected_class_id);
}

$stmt->execute();
$result_schedules = $stmt->get_result();
while ($row = $result_schedules->fetch_assoc()) {
    $schedules[] = $row;
}

?>

<div class="dashboard-content">
    <h3>Manajemen Jadwal</h3>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>



    <div class="card" style="margin-top: 20px;">
        <h4>Generate Jadwal Bulanan Otomatis</h4>
        <form method="POST" action="manage_schedule.php">
            <div class="input-group">
                <label for="start_date">Tanggal Mulai Jadwal</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="input-group">
                <label for="start_student_offset">Mulai dengan absen berapa</label>
                <input type="number" id="start_student_offset" name="start_student_offset" value="1" min="1" required>
            </div>
            <div class="input-group">
                <label for="task_description_monthly">Deskripsi Tugas Bulanan</label>
                <input type="text" id="task_description_monthly" name="task_description_monthly" value="Membuang sampah" required>
            </div>
            <button type="submit" name="generate_monthly_schedule">Generate Jadwal</button>
        </form>
    </div>




    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4>Daftar Jadwal</h4>
            <div style="display: flex; align-items: center; gap: 10px;">
                <button id="toggleScheduleBtn" style="padding: 8px 15px; border-radius: 4px; cursor: pointer; background-color: #f1f1f1; border: 1px solid #ddd; color: black;">Lihat Semuanya</button>
                <form method="GET" action="manage_schedule.php" id="filter-form" style="margin-bottom: 0;">
                    <select name="class_id" onchange="this.form.submit()" style="padding: 8px; border-radius: 4px;">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>" <?php echo ($selected_class_id == $class['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['class_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <form method="POST" action="manage_schedule.php" onsubmit="return confirm('Anda yakin ingin menghapus SEMUA jadwal? Tindakan ini tidak dapat dibatalkan!');" style="margin-bottom: 0;">
                    <button type="submit" name="delete_all_schedules" style="background-color: #e74c3c; padding: 8px 15px; border-radius: 4px; color: white; border: none; cursor: pointer;">Hapus Semua Jadwal</button>
                </form>
            </div>
        </div>
        <div id="scheduleListContainer" class="collapsible-list">
            <?php if (!empty($schedules)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Deskripsi Tugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($schedule['task_date']); ?></td>
                                <td><?php echo htmlspecialchars($schedule['nama_siswa']); ?></td>
                                <td><?php echo htmlspecialchars($schedule['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($schedule['task_description']); ?></td>
                                <td>
                                    <a href="manage_schedule.php?action=edit&id=<?php echo $schedule['id']; ?>&class_id=<?php echo $selected_class_id; ?>">Edit</a> |
                                    <a href="manage_schedule.php?action=delete&id=<?php echo $schedule['id']; ?>&class_id=<?php echo $selected_class_id; ?>" onclick="return confirm('Anda yakin ingin menghapus jadwal ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada jadwal yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Fetch tasks for verification
    $tasks_for_verification = [];
    $sql_tasks = "SELECT s.id, s.task_date, u.name as nama_siswa, c.class_name
                  FROM schedule s
                  JOIN users u ON s.user_id = u.id
                  JOIN classes c ON u.class_id = c.id
                  WHERE s.status = 'completed'
                  ORDER BY s.task_date ASC";
    $result_tasks = $conn->query($sql_tasks);
    if ($result_tasks) {
        while ($row = $result_tasks->fetch_assoc()) {
            $tasks_for_verification[] = $row;
        }
    }
    ?>
    <div class="card" style="margin-top: 20px;">
        <h4>Verifikasi Tugas Siswa</h4>
        <?php if (!empty($tasks_for_verification)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks_for_verification as $task): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['task_date']); ?></td>
                            <td><?php echo htmlspecialchars($task['nama_siswa']); ?></td>
                            <td><?php echo htmlspecialchars($task['class_name']); ?></td>
                            <td>
                                <form method="POST" action="manage_schedule.php" style="display: inline;">
                                    <input type="hidden" name="schedule_id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="action" value="verify">Verifikasi</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada tugas yang perlu diverifikasi saat ini.</p>
        <?php endif; ?>
    </div>

</div>

<?php include 'includes/footer.php'; ?>