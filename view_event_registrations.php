<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

$conn = new mysqli("localhost", "root", "", "alumni_db");

// Query to get event registrations with user and event info
$sql = "SELECT er.id, u.full_name, u.email, e.title AS event_title, e.event_date, er.registered_at 
        FROM event_registrations er
        JOIN users u ON er.user_id = u.id
        JOIN events e ON er.event_id = e.id
        ORDER BY er.registered_at asc";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Registrations</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 8px #ccc; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Event Registrations</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Attendee Name</th>
            <th>Email</th>
            <th>Event Title</th>
            <th>Event Date</th>
            <th>Registration Time</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['event_title']) ?></td>
            <td><?= $row['event_date'] ?></td>
            <td><?= $row['registered_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="download_pdf.php?event_id=<?= $row['id'] ?>" target="_blank">
    Download PDF
</a>

</body>
</html>
