<?php
$conn = new mysqli("localhost", "root", "", "alumni_db");
$posts = $conn->query("SELECT * FROM admin_posts ORDER BY created_at DESC");
?>

<?php include 'header.php'; ?>

    <title>Alumni News & Events</title>
    <style>
        .post {
            background: #fff; margin: 20px auto; padding: 50px;
            max-width: 700px; box-shadow: 0 0 10px #222222; border-radius: 6px;
        }
        h2 { color:rgb(35, 185, 249); }
        .date { color: #004aad; font-size: 0.9em; }
    </style>

    <h1 style="text-align:center;">Latest News & Events</h1>
    <?php while ($row = $posts->fetch_assoc()): ?>
        <div class="post">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <p class="date">Posted on <?php echo $row['created_at']; ?></p>
            <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
            <a href="view_post.php?id=<?php echo $row['id']; ?>">Read more & Comment</a>

        </div>
    <?php endwhile; ?>

<?php include 'footer.php'; ?>
