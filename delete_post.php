<?php
session_start();
if ($_SESSION['is_admin'] !== true) {
    die("Access denied");
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
$id = intval($_GET['id']);
$conn->query("DELETE FROM admin_posts WHERE id = $id");
header("Location: admin_dashboard.php");
?>
