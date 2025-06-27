<?php
session_start();
$conn = new mysqli("localhost", "root", "", "alumni_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $conn->real_escape_string($_POST['message']);

    $conn->query("INSERT INTO messages (sender_id, receiver_id, message) VALUES ($sender_id, $receiver_id, '$message')");
    header("Location: chat.php?user_id=$receiver_id");
    exit();
}
?>
