<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "alumni_db");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Don't delete admins
    $isAdmin = $conn->query("SELECT is_admin FROM users WHERE id = $id")->fetch_assoc();
    if ($isAdmin && $isAdmin['is_admin'] == 1) {
        die("You cannot delete an admin.");
    }

    // Delete related data
    $conn->query("DELETE FROM messages WHERE sender_id = $id OR receiver_id = $id");
    $conn->query("DELETE FROM payments WHERE user_id = $id");
    $conn->query("DELETE FROM event_registrations WHERE user_id = $id");
    $conn->query("DELETE FROM comments WHERE user_id = $id");
     $conn->query("DELETE FROM contact_messages WHERE id = $id");
      $conn->query("DELETE FROM posts WHERE user_id = $id");
    // Add more if needed (e.g., posts, comments, etc.)

    // Finally, delete the user
    $conn->query("DELETE FROM users WHERE id = $id");
}

header("Location: admin_dashboard.php");
exit();
