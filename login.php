<?php
session_start();

if (isset($_POST['login'])) {
    $conn = new mysqli("localhost", "root", "", "alumni_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Email not found";
    }

    $conn->close();
}
?>

<?php include 'header.php'; ?>

<title>Alumni Login</title>
<style>
    body { font-family: Arial; background:rgba(20, 134, 109, 0.7); padding: 20px; }
    form { background: #fff; padding: 30px; max-width: 400px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px #007b5e; }
    input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #007b5e; }
    input[type="submit"] { background:rgba(22, 89, 38, 0.71); color: white; cursor: pointer; }
    input[type="submit"]:hover { background:rgb(33, 35, 136); }
    .admin-link {
        display: inline-block;
        margin-top: 15px;
        color: #004aad;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.5s, background-color 0.5s;
    }
    .admin-link:hover {
        color: white;
        background-color: #004aad;
        padding: 8px 16px;
        border-radius: 5px;
    }
</style>


<?php if (!empty($error)) echo "<script>alert('$error');</script>"; ?>

<form action="login.php" method="post">
    <h2>Alumni Login</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="login" value="Login">
    <a href="admin_login.php" class="admin-link">Admin Login</a>
</form>

<?php include 'footer.php'; ?>
