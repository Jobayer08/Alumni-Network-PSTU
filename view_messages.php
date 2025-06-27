<?php
session_start();
if (!isset($_SESSION['is_admin']) ||$_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at asc");
?>

<?php include 'header.php'; ?>
    <title>View Messages</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 8px #ccc; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>

    <h2>Contact Form Submissions</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Sender</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php include 'footer.php'; ?>

