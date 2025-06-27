<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet"  href="style.css">
<body>
<div class="navbar">
    <div><strong>Alumni Network</strong></div>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="directory.php">Directory</a>
        <a href="profile.php">My Profile</a>
        <a href="search_alumni.php">Search</a>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="admin_dashboard.php">Admin Panel</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </div>
</div>
        </body>
        </head>
        </html>
