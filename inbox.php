<?php
session_start();
$conn = new mysqli("localhost", "root", "", "alumni_db");

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view messages.");
}

$user_id = $_SESSION['user_id'];

// Get unique senders who have messaged this user
$query = "
    SELECT m.sender_id, u.full_name, m.message, m.created_at
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = ?
    GROUP BY m.sender_id
    ORDER BY MAX(m.created_at) DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Your Inbox</h2>

<?php if ($result->num_rows > 0): ?>
    <div style="max-width:600px;margin:auto;">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="background:#f9f9f9;padding:10px;margin-bottom:10px;border-radius:8px;">
            <p><strong><?= htmlspecialchars($row['full_name']) ?></strong></p>
            <p><?= htmlspecialchars(substr($row['message'], 0, 50)) ?>...</p>
            <p><small><?= $row['created_at'] ?></small></p>
            <a href="chat.php?user_id=<?= $row['sender_id'] ?>">
                <button style="padding:6px 12px;background:#007bff;color:white;border:none;">Reply</button>
            </a>
        </div>
    <?php endwhile; ?>
    </div>
<?php else: ?>
    <p style="text-align:center;">No new messages.</p>
<?php endif; ?>
