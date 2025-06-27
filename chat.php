<?php
session_start();
$conn = new mysqli("localhost", "root", "", "alumni_db");
$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['user_id'];

// Get receiver's name
$user = $conn->query("SELECT full_name FROM users WHERE id = $receiver_id")->fetch_assoc();

// Get conversation
$messages = $conn->query("
    SELECT * FROM messages 
    WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) 
       OR (sender_id = $receiver_id AND receiver_id = $sender_id)
    ORDER BY created_at ASC
");
?>

<h2>Chat with <?= htmlspecialchars($user['full_name']) ?></h2>

<div style="max-width:600px;margin:auto;background:#f4f4f4;padding:10px;border-radius:8px;">
<?php while ($msg = $messages->fetch_assoc()): ?>
    <p><strong><?= $msg['sender_id'] == $sender_id ? 'You' : $user['full_name'] ?>:</strong> 
    <?= htmlspecialchars($msg['message']) ?> 
    <br><small><?= $msg['created_at'] ?></small></p>
<?php endwhile; ?>
</div>

<form method="post" action="send_message.php" style="max-width:600px;margin:auto;margin-top:10px;">
    <input type="hidden" name="receiver_id" value="<?= $receiver_id ?>">
    <textarea name="message" required placeholder="Type your message..." style="width:100%;padding:8px;"></textarea>
    <button type="submit" style="padding:8px 16px;background:#007bff;color:white;border:none;">Send</button>
</form>
