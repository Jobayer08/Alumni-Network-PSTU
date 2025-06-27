<?php
session_start();
$conn = new mysqli("localhost", "root", "", "alumni_db");

$post_id = intval($_GET['id'] ?? 0);

// Fetch post
$post = $conn->query("SELECT * FROM admin_posts WHERE id=$post_id")->fetch_assoc();
if (!$post) {
    die("Post not found");
}

// Add comment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $comment = $conn->real_escape_string($_POST['comment']);
    $conn->query("INSERT INTO comments (post_id, user_id, comment) VALUES ($post_id, $user_id, '$comment')");
}

// Fetch comments
$comments = $conn->query("SELECT comments.comment, comments.created_at, users.full_name 
                          FROM comments JOIN users ON comments.user_id = users.id 
                          WHERE post_id = $post_id ORDER BY comments.created_at DESC");
?>

<?php include 'header.php'; ?>

    <title><?php echo $post['title']; ?></title>
    <style>
        .container { max-width: 700px; margin: auto; padding: 20px; background: #fff; }
        .comment-box { margin-top: 30px; }
        .comment { margin-bottom: 15px; padding: 10px; background:rgb(233, 226, 226); border-radius: 60px; }
        .meta { font-size: 0.9em; color: #555; }
        textarea { width: 100%; padding: 10px; }
        input[type="submit"] { margin-top: 10px; padding: 8px 20px; color:#004aad;  }
    </style>

    <div class="container">
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <p><i>Posted on <?php echo $post['created_at']; ?></i></p>

        <div class="comment-box">
            <h3>Comments</h3>

            <?php while ($c = $comments->fetch_assoc()): ?>
                <div class="comment">
                    <div class="meta"><strong><?php echo htmlspecialchars($c['full_name']); ?></strong> on <?php echo $c['created_at']; ?></div>
                    <p><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
                </div>
            <?php endwhile; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="post">
                    <textarea name="comment" required placeholder="Write a comment..."></textarea>
                    <input type="submit" value="Comment">
                </form>
            <?php else: ?>
                <p><a href="login.php">Log in</a> to comment.</p>
            <?php endif; ?>
        </div>
    </div>

<?php include 'footer.php'; ?>

