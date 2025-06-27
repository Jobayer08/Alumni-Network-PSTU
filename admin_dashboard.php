<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
$result = $conn->query("SELECT * FROM users WHERE is_admin = 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(239, 233, 236);
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: white;
        }

        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background-color:rgb(133, 64, 64);
            color: white;
            font-size: 16px;
        }

        tr:hover {
            background-color:rgba(174, 162, 132, 0.88);
        }

        a.delete {
            color:rgb(71, 75, 160);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.5s;
        }

        a.delete:hover {
            color:rgb(228, 19, 19);
        }

        .nav-links {
            margin-top: 30px;
            text-align: center;
        }

        .nav-links ul {
            list-style-type: none;
            padding: 0;
        }

        .nav-links li {
            display: inline-block;
            margin: 0 15px;
        }

        .nav-links a {
            text-decoration: none;
            color: #007bff;
            font-size: 17px;
            transition: color 0.5s, border-bottom 0.5s;
            border-bottom: 2px solid transparent;
            padding-bottom: 4px;
        }

        .nav-links a:hover {
            color:rgb(86, 70, 152);
            border-bottom: 2px solid rgb(115, 65, 149);
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['full_name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td>
                    <a class="delete" href="delete_user.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="nav-links">
        <ul>
            <li><a href="view_messages.php">View Feedback Messages</a></li>
            <li><a href="admin_posts.php">Publish News</a></li>
            <li><a href="admin_add_event.php">Event</a></li>
            <li><a href="view_event_registrations.php">View Event Registrations</a></li>
            <li><a href="search_alumni.php">Search Alumni</a></li>
            <li><a href="manage_users.php">Users Info</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
