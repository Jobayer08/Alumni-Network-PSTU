<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Login required.");
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    die("Invalid event.");
}

// ✅ Check if the user is already registered
$check = $conn->prepare("SELECT id FROM event_registrations WHERE user_id = ? AND event_id = ?");
$check->bind_param("ii", $user_id, $event_id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo "<p style='color:red;'>You have already registered for this event.</p>";
    echo "<a href='events.php'>Back to Events</a>";
    exit();
}

// ✅ Proceed with registration
$query = "INSERT INTO event_registrations (event_id, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $event_id, $user_id);

if ($stmt->execute()) {
    header("Location: pay_event.php?event_id=$event_id");
} else {
    echo "Registration failed.";
}
?>
