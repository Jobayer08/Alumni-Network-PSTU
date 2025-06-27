<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "alumni_db");

// Add new post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("INSERT INTO admin_posts (title, content) VALUES ('$title', '$content')");
}

// Delete post
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM admin_posts WHERE id=$id");
}

$posts = $conn->query("SELECT * FROM admin_posts ORDER BY created_at DESC");
?>

<?php include 'header.php'; ?>
    <title>Admin News</title>
    <style>
        form, table { width: 80%; margin: auto; margin-bottom: 30px; }
        textarea { width: 100%; height: 100px; }
        input[type="text"] { width: 100%; padding: 8px; }
        input[type="submit"] { padding: 10px 20px; margin-top: 10px; background:rgb(0, 0, 0); color: white; border: none; cursor: pointer; }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px;background:rgb(236, 225, 225); }
        th { background:rgb(15, 16, 17); color: white; }
    </style>

    <h1 style="text-align:center;">Post News</h1>

    <form method="post">
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea name="content" placeholder="Write your news/event..." required></textarea>
        <input type="submit" value="Post">
    </form>

    <table>
        <tr><th>Title</th><th>Content</th><th>Posted</th><th>Action</th></tr>
        <?php while ($row = $posts->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['content'])); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this post?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

<?php include 'footer.php'; ?>
