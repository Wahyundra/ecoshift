<?php include 'includes/header.php'; ?>
<?php include 'config/database.php'; ?>

<?php
// Set locale to Indonesian for date formatting
setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian_Indonesia.1252');

// Fetch all majors for the major dropdown
$majors = [];
$sql_majors = "SELECT id, major_name FROM majors ORDER BY major_name";
$result_majors = $conn->query($sql_majors);
while ($row = $result_majors->fetch_assoc()) {
    $majors[] = $row;
}

$selected_major_id = isset($_GET['major_id']) ? $_GET['major_id'] : null;
$selected_class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;

// Fetch classes for the class dropdown based on selected major (for initial load)
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
?>

<div class="dashboard-content">
    <h3>Jadwal Membuang Sampah</h3>

    <div class="class-filters">
        <?php
        $sql_majors = "SELECT * FROM majors ORDER BY major_name";
        $result_majors = $conn->query($sql_majors);
        while ($row_major = $result_majors->fetch_assoc()) {
            $is_major_active = (isset($_GET['major_id']) && $_GET['major_id'] == $row_major['id']);
            $class = 'class-button' . ($is_major_active ? ' active' : '');
            echo '<a href="schedule.php?major_id=' . $row_major['id'] . '" class="' . $class . '">' . htmlspecialchars($row_major['major_name']) . '</a>';
        }
        ?>
    </div>

    <?php
    if (isset($_GET['major_id'])) {
        $selected_major_id = $_GET['major_id'];
        $sql_major = "SELECT major_name FROM majors WHERE id = ?";
        $stmt_major = $conn->prepare($sql_major);
        $stmt_major->bind_param("i", $selected_major_id);
        $stmt_major->execute();
        $result_major = $stmt_major->get_result();
        if ($result_major->num_rows > 0) {
            $major = $result_major->fetch_assoc();
            if (strtoupper($major['major_name']) === 'PPLG') {
                echo '<div class="class-filters" style="margin-top: 10px;">';
                $sql_classes = "SELECT * FROM classes WHERE major_id = ? ORDER BY class_name";
                $stmt_classes = $conn->prepare($sql_classes);
                $stmt_classes->bind_param("i", $selected_major_id);
                $stmt_classes->execute();
                $result_classes = $stmt_classes->get_result();
                while ($row_class = $result_classes->fetch_assoc()) {
                    $is_class_active = (isset($_GET['class_id']) && $_GET['class_id'] == $row_class['id']);
                    $class_button_class = 'class-button' . ($is_class_active ? ' active' : '');
                    echo '<a href="schedule.php?major_id=' . $selected_major_id . '&class_id=' . $row_class['id'] . '" class="' . $class_button_class . '">' . htmlspecialchars($row_class['class_name']) . '</a>';
                }
                echo '</div>';
            }
        }
    }?>

    <div class="schedule-display">
        <?php
        if (isset($_GET['major_id'])) {
            $selected_major_id = $_GET['major_id'];
            $selected_class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;

            $sql_schedule = "SELECT schedule.id, schedule.task_date, schedule.status, users.id as user_id, users.name, classes.class_name, schedule.task_description 
                             FROM schedule 
                             JOIN users ON schedule.user_id = users.id 
                             JOIN classes ON users.class_id = classes.id
                             WHERE classes.major_id = ?";
            
            if ($selected_class_id) {
                $sql_schedule .= " AND classes.id = ?";
            }

            $sql_schedule .= " ORDER BY schedule.task_date, users.name";
            
            $stmt_schedule = $conn->prepare($sql_schedule);
            if ($selected_class_id) {
                $stmt_schedule->bind_param("ii", $selected_major_id, $selected_class_id);
            } else {
                $stmt_schedule->bind_param("i", $selected_major_id);
            }
            $stmt_schedule->execute();
            $result_schedule = $stmt_schedule->get_result();

            if ($result_schedule->num_rows > 0) {
                $current_date = '';
                $user_schedule_found = false; // Flag to ensure we only ID the first upcoming schedule
                while ($row_schedule = $result_schedule->fetch_assoc()) {
                    if ($row_schedule['task_date'] != $current_date) {
                        if ($current_date != '') {
                            echo '</ul>';
                        }
                                                $date_timestamp = strtotime($row_schedule['task_date']);
                        echo '<h5>' . strftime('%A, %d %B %Y', $date_timestamp) . '</h5>';
                        echo '<ul>';
                        $current_date = $row_schedule['task_date'];
                    }

                    $is_current_user = (isset($_SESSION['user_id']) && $row_schedule['user_id'] == $_SESSION['user_id']);
                    $is_today = (date('Y-m-d') == $row_schedule['task_date']);
                    $li_class = $is_current_user ? 'class="current-user-schedule"' : '';
                    $li_id = '';

                    // Add ID only for the first upcoming schedule for the user
                    if ($is_current_user && !$user_schedule_found && new DateTime($row_schedule['task_date']) >= new DateTime('today')) {
                        $li_id = 'id="user-schedule-entry"';
                        $user_schedule_found = true; // Set flag so we only ID the first one
                    }

                    echo '<li ' . $li_id . ' ' . $li_class . '>';
                    echo htmlspecialchars($row_schedule['name']) . ' (' . htmlspecialchars($row_schedule['class_name']) . '): ' . htmlspecialchars($row_schedule['task_description']);

                    // Only show the action/status if it's the current user's task for today
                    if ($is_current_user && $is_today) {
                        echo ' - '; // Separator
                        if ($row_schedule['status'] == 'pending') {
                            echo 'Sudah membuang atau belum? <a href="update_schedule_status.php?id=' . $row_schedule['id'] . '">[Sudah]</a>';
                        } elseif ($row_schedule['status'] == 'completed') {
                            echo '<i>(Menunggu verifikasi admin)</i>';
                        } elseif ($row_schedule['status'] == 'verified') {
                            echo '<b>(Tugas terverifikasi)</b>';
                        }
                    }

                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>Tidak ada jadwal untuk filter yang dipilih.</p>';
            }
        } else {
            echo '<p>Pilih jurusan untuk melihat jadwal.</p>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>