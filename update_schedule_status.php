<?php
session_start();
include 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if schedule ID is provided
if (!isset($_GET['id'])) {
    header("Location: schedule.php?error=invalid_id");
    exit();
}

$schedule_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Verify that the schedule entry belongs to the current user before updating
$sql_verify = "SELECT * FROM schedule WHERE id = ? AND user_id = ?";
$stmt_verify = $conn->prepare($sql_verify);
$stmt_verify->bind_param("ii", $schedule_id, $user_id);
$stmt_verify->execute();
$result_verify = $stmt_verify->get_result();

if ($result_verify->num_rows > 0) {
    // The schedule entry is valid and belongs to the user, so update it
    $sql_update = "UPDATE schedule SET status = 'completed' WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $schedule_id);
    
    if ($stmt_update->execute()) {
        // Redirect back to the schedule page with a success message
        header("Location: schedule.php?message=status_updated");
        exit();
    } else {
        // Handle update error
        header("Location: schedule.php?error=update_failed");
        exit();
    }
} else {
    // The user is trying to update a schedule that is not theirs
    header("Location: schedule.php?error=unauthorized");
    exit();
}
?>