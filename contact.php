<?php
$conn = new mysqli("localhost", "root", "", "alumni_db");
$message = "";

if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $content = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$content')";
    if ($conn->query($sql) === TRUE) {
        $message = "Message sent successfully!";
    } else {
        $message = "Something went wrong!";
    }
}
?>

<?php include 'header.php'; ?>

    <title>Contact Us</title>
    <style>
        body { font-family: Arial; background:rgb(231, 224, 224); padding: 20px; }
        form { background: white; padding: 20px; max-width: 500px; margin: auto; box-shadow: 0 0 10px #004aad; border-radius: 10px; }
        input, textarea { width: 100%; margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 5px rgba(56, 65, 160, 0.88) }
        input[type="submit"] { background:rgb(88, 70, 145); color: white; border: none; cursor: pointer; }
        .message { text-align: center; color: green; }
    </style>


<h2 style="text-align:center;">Contact Us</h2>

<form method="post">
    <input type="text" name="name" placeholder="Your name" required>
    <input type="email" name="email" placeholder="Your email" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="message" placeholder="Your message..." required></textarea>
    <input type="submit" name="submit" value="Send Message">
    <div class="message"><?php echo $message; ?></div>
</form>

<?php include 'footer.php'; ?>
