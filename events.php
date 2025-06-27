<?php
include 'db.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>
</head>
<body>
    <h2>Upcoming Events</h2>
    <?php
    $query = "SELECT * FROM events ORDER BY event_date ASC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<p><strong>Date:</strong> " . $row['event_date'] . "</p>";
        echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";

        if ($user_id) {
            // Check if user already registered
            $eid = $row['id'];
            $check = $conn->query("SELECT id FROM event_registrations WHERE user_id = $user_id AND event_id = $eid");
            if ($check->num_rows > 0) {
                echo "<p style='color:green;'>Already Registered</p>";
            } else {
                echo "<a href='register_event.php?event_id=$eid'>Register</a>";
            }
        } else {
            echo "<p><em>Login to register.</em></p>";
        }

        echo "</div><hr>";
    }
    ?>
</body>
</html>
