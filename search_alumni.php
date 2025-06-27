<?php
session_start();
$conn = new mysqli("localhost", "root", "", "alumni_db");

$results = [];
if (isset($_GET['search'])) {
    $keyword = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT id, full_name, course, graduation_year, permanent_address, present_address, job_title, company, profile_picture 
            FROM users 
            WHERE full_name LIKE '%$keyword%' 
               OR course LIKE '%$keyword%' 
               OR graduation_year LIKE '%$keyword%'
               OR present_address LIKE '%$keyword%'
               OR permanent_address LIKE '%$keyword%'";
    $results = $conn->query($sql);
}
?>

<?php include 'header.php'; ?>

<title>Search Alumni</title>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background: #f4f4f4;
    }
    form {
        text-align: center;
        margin-bottom: 20px;
    }
    input[type="text"] {
        padding: 10px;
        width: 300px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    input[type="submit"] {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .card {
        background: white;
        padding: 15px;
        margin: 20px auto;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 0 8px #ccc;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    .card-content {
        flex: 1;
    }
    .card h3 {
        margin: 0 0 10px;
    }
    .card p {
        margin: 5px 0;
    }
    .message-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 12px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
    .message-btn:hover {
        background: #218838;
    }
</style>

<h2 style="text-align:center;">Search Alumni</h2>

<form method="get">
    <input type="text" name="search" placeholder="Enter name, course, Location or year..." required>
    <input type="submit" value="Search">
</form>

<?php if ($results && $results->num_rows > 0): ?>
    <?php while ($row = $results->fetch_assoc()): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($row['profile_picture']) ?>" alt="Profile Picture">
            <div class="card-content">
                <h3><?= htmlspecialchars($row['full_name']) ?></h3>
                <p><strong>Course:</strong> <?= htmlspecialchars($row['course']) ?></p>
                <p><strong>Year:</strong> <?= htmlspecialchars($row['graduation_year']) ?></p>
                 <p><strong>Permanent address :</strong> <?= htmlspecialchars($row['permanent_address']) ?></p>
                 <p><strong>Present address :</strong> <?= htmlspecialchars($row['present_address']) ?></p>
                <p><strong>Job:</strong> <?= htmlspecialchars($row['job_title']) ?> at <?= htmlspecialchars($row['company']) ?></p>
                <a class="message-btn" href="chat.php?user_id=<?= $row['id'] ?>">Message</a>
            </div>
        </div>
    <?php endwhile; ?>
<?php elseif (isset($_GET['search'])): ?>
    <p style="text-align:center;">No alumni found matching your search.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
