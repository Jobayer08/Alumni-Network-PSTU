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

$user_id = $_SESSION['user_id'];

// Handle post submission
if (isset($_POST['submit_post'])) {
    $content = $conn->real_escape_string($_POST['content']);
    if (!empty($content)) {
        $conn->query("INSERT INTO posts (user_id, content) VALUES ($user_id, '$content')");
    }
}

// Handle post deletion
if (isset($_POST['delete_post'])) {
    $post_id = (int)$_POST['post_id'];
    // Only allow deletion if user owns the post
    $conn->query("DELETE FROM posts WHERE id=$post_id AND user_id=$user_id");
}

// Get posts with user info and post ID
$sql = "SELECT posts.id, posts.content, posts.created_at, users.full_name, posts.user_id 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
?>

<?php include 'header.php'; ?>
<title>Alumni Posts</title>
<style>
    body { font-family: Arial; background:rgba(105, 143, 72, 0.66); padding: 20px; }
    form { background: white; padding: 45px; margin-bottom: 20px; border-radius: 8px; max-width: 600px; margin: auto; box-shadow: 0 0 10px #004aad; }
    textarea { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc; }
    input[type="submit"] { padding: 10px 20px; background:rgba(68, 145, 136, 0.82); color: white; border: none; border-radius: 50px; cursor: pointer; }
    .post { background: white; padding: 45px; margin: 15px auto; max-width: 600px; border-radius: 8px; box-shadow: 0 0 8px #004aad; position: relative; }
    .delete-btn{ background:rgb(193, 63, 76); color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; position: absolute; top: 5px; right: 5px; }
    
</style>

<h2>Share an Update</h2>
<form method="post" action="">
    <textarea name="content" placeholder="Write your post or event here..." required></textarea>
    <input type="submit" name="submit_post" value="Post">
</form>

<h2 style="text-align:center;">Recent Posts</h2>
<?php
if ($result->num_rows > 0) {
    
    while ($post = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<strong>" . htmlspecialchars($post['full_name']) . "</strong><br>";
        echo "<small>" . $post['created_at'] . "</small><br><br>";
        echo nl2br(htmlspecialchars($post['content']));
        // Show delete button only for post owner
        if ($post['user_id'] == $user_id) {
            echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
            echo "<input type='submit' name='delete_post' class='delete-btn' value='Delete'>";
            echo "</form>";
        }

        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;'>No posts yet.</p>";
}
?>



<?php include 'footer.php'; ?>
