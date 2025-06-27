<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
$msg = "";

if (isset($_POST['submit'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $date = $_POST['event_date'];
    $location = $conn->real_escape_string($_POST['location']);

    $sql = "INSERT INTO events (title, description, event_date, location) VALUES ('$title', '$desc', '$date', '$location')";
    if ($conn->query($sql)) {
        $msg = "Event added successfully!";
    } else {
        $msg = "Error adding event.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <style>
        body { font-family: Arial; padding: 20px; background:rgb(236, 236, 236); }
        form { background: white; padding: 30px; max-width: 500px; margin: auto; border-radius: 8px; box-shadow: 0 0 8px rgb(164, 63, 145); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; box-shadow: 0 0 4px rgb(164, 63, 145);}
        input[type="submit"] { background:rgba(141, 69, 94, 0.73); color: white; border: none; cursor: pointer; }
        .msg { text-align: center; color: green; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Add New Event</h2>
    <form method="post">
        <input type="text" name="title" placeholder="Event Title" required>
        <textarea name="description" placeholder="Event Description" required></textarea>
        <input type="date" name="event_date" required>
        <input type="text" name="location" placeholder="Event Location" required>
        <input type="submit" name="submit" value="Add Event">
        <div class="msg"><?php echo $msg; ?></div>
    </form>
</body>
</html>
