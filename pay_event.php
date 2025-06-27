<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Login required.");
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $method = $_POST['payment_method'];
    $ref = uniqid('ref_');

    $insert = "INSERT INTO payments (user_id, event_id, amount, payment_status) VALUES (?, ?, ?, 'paid')";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("iid", $user_id, $event_id, $amount);
    $stmt->execute();

    $update = "UPDATE event_registrations SET payment_status='paid', payment_reference=?, payment_method=?, amount_paid=? WHERE user_id=? AND event_id=?";
    $stmt2 = $conn->prepare($update);
    $stmt2->bind_param("ssdii", $ref, $method, $amount, $user_id, $event_id);
    $stmt2->execute();

    header("Location: receipt.php?ref=$ref");
    exit;
}
?>

<form method="POST">
    <h3>Pay for Event</h3>
    <label>Amount (৳):</label>
    <input type="number" name="amount" required><br><br>

    <label>Payment Method:</label>
    <select name="payment_method" required>
        <option value="bKash">bKash</option>
        <option value="Nagad">Nagad</option>
        <option value="Rocket">Rocket</option>
    </select><br><br>

    <button type="submit">Pay Now</button>
</form>
