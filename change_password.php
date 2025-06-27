<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['change'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current hashed password
    $result = $conn->query("SELECT password FROM users WHERE id = $user_id");
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if (!password_verify($old_password, $hashed_password)) {
        $message = "Old password is incorrect!";
    } elseif ($new_password !== $confirm_password) {
        $message = "New passwords do not match!";
    } else {
        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $conn->query("UPDATE users SET password='$new_hashed' WHERE id=$user_id");
        $message = "Password changed successfully!";
    }
}
?>

<?php include 'header.php'; ?>

    <title>Change Password</title>
    <style>
        body { font-family: Arial; background: #f8f9fa; padding: 20px; }
        form { background: white; padding: 45px; max-width: 400px; margin:auto ; box-shadow: 0 0 10px #007b5e; border-radius: 10px; }
        input { width: 100%; margin: 10px 0; padding: 8px;  border: 1px solid #ccc; box-shadow:0 0 5px rgba(69, 159, 119, 0.8) }
        input[type="submit"] { background:rgb(136, 66, 141); color: white; border: none; cursor: pointer; }
        .message { color: red; text-align: center; }
    </style>

    <h2 style="text-align:center;">Change Password</h2>
    <form method="post">
        <input type="password" name="old_password" placeholder="Old Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <input type="submit" name="change" value="Change Password">
        <div class="message"><?php echo $message; ?></div>
    </form>

<?php include 'footer.php'; ?>
