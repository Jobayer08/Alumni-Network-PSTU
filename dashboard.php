<?php
session_start();
if (!isset($_SESSION['user_id']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php'; ?>

<div class="wrapper">
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?> </h1>
        
        <ul>
            <li><a href="profile.php">View / Edit Profile</a></li>
            <li><a href="search_alumni.php">Search Alumni</a></li>
            <li><a href="news.php">Read Alumni News</a></li>
            <li><a href="events.php">View Events</a></li>
            <li><a href="posts.php">General post</a></li>
             <li><a href="inbox.php">Inbox</a></li>
            <li><a href="contact.php">Admin Contact</a></li>
            <li><a href="change_password.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>


<?php include 'footer.php'; ?>
