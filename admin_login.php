<?php
session_start();
$conn = new mysqli("localhost", "root", "", "alumni_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND is_admin=1 LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['is_admin'] = true;

        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<?php include 'header.php'; ?>
 

<div class="login-container">
    <div class="login-form">
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <h2>Admin Login</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Admin Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</div>


<?php include 'footer.php'; ?>
