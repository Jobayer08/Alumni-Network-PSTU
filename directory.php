<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search filter
$search = "";
$where = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where = "WHERE full_name LIKE '%$search%' OR course LIKE '%$search%' OR graduation_year LIKE '%$search%'";
}

$sql = "SELECT full_name, course, graduation_year, job_title, company, bio FROM users $where ORDER BY graduation_year DESC";
$result = $conn->query($sql);
?>

<?php include 'header.php'; ?>
    <title>Alumni Directory</title>
    <style>
        body { font-family: Arial; background: #eef1f5; padding: 20px; }
        form { text-align: center; margin-bottom: 20px; }
        input[type="text"] { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 5px; }
        input[type="submit"] { padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        input[type="submit"]:hover { background: #0056b3; }
        .card { background: white; padding: 15px; margin: 15px auto; max-width: 600px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logout, .profile-link { text-align: center; margin-top: 20px; }
    </style>

    <h2>Alumni Directory</h2>

    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by name, course, or year" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h3>" . htmlspecialchars($row['full_name']) . "</h3>";
            echo "<p><strong>Course:</strong> " . htmlspecialchars($row['course']) . "</p>";
            echo "<p><strong>Graduation Year:</strong> " . htmlspecialchars($row['graduation_year']) . "</p>";
            echo "<p><strong>Job:</strong> " . htmlspecialchars($row['job_title']) . " at " . htmlspecialchars($row['company']) . "</p>";
            echo "<p><strong>Bio:</strong> " . nl2br(htmlspecialchars($row['bio'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='text-align:center;'>No results found.</p>";
    }
    ?>

   

<?php include 'footer.php'; ?>
