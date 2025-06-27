<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
$users = $conn->query("SELECT id, full_name, email, course, graduation_year FROM users ORDER BY id asc");
?>

<?php include 'header.php'; ?>

    <title>Manage Users</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 8px #ccc; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>

    <h2>All Registered Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Year</th>
        </tr>
        <?php while($row = $users->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td><?= htmlspecialchars($row['graduation_year']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

<?php include 'footer.php'; ?>
