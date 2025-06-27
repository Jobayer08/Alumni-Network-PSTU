<?php include 'header.php'; ?>

<title>Alumni Registration</title>
<style>
    body { font-family: Arial; background:rgba(51, 117, 135, 0.9); padding: 20px; }
    form { background: #fff; padding: 25px; max-width: 500px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px #004aad; }
    input, textarea { width: 100%; padding: 5px; margin: 10px 0; border-radius: 5px; border: 1px solid #004aad; }
    input[type="submit"] { background:rgb(2, 102, 209); color: white; cursor: pointer; }
    input[type="submit"]:hover { background:rgb(28, 97, 172); }
</style>

<h2>Alumni Registration</h2>
<form action="register.php" method="post">
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="text" name="father_name" placeholder="Father's Name" required>
    <input type="text" name="mother_name" placeholder="Mother's Name" required>
    <input type="text" name="present_address" placeholder="Present Address" required>
    <input type="text" name="permanent_address" placeholder="Permanent Address" required>
    <input type="text" name="hall_name" placeholder="Hall Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="number" name="graduation_year" placeholder="Graduation Year">
    <input type="text" name="course" placeholder="Faculty">
    <input type="text" name="job_title" placeholder="Job Title">
    <input type="text" name="company" placeholder="Company">
    <textarea name="bio" placeholder="Short Bio"></textarea>
    <input type="submit" name="register" value="Register">
</form>

<?php include 'footer.php'; ?>

<?php
if (isset($_POST['register'])) {
    $conn = new mysqli("localhost", "root", "", "alumni_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $full_name = $conn->real_escape_string($_POST['full_name']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $mother_name = $conn->real_escape_string($_POST['mother_name']);
    $present_address = $conn->real_escape_string($_POST['present_address']);
    $permanent_address = $conn->real_escape_string($_POST['permanent_address']);
    $hall_name = $conn->real_escape_string($_POST['hall_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $graduation_year = $_POST['graduation_year'];
    $course = $conn->real_escape_string($_POST['course']);
    $job_title = $conn->real_escape_string($_POST['job_title']);
    $company = $conn->real_escape_string($_POST['company']);
    $bio = $conn->real_escape_string($_POST['bio']);

    $sql = "INSERT INTO users (full_name, father_name, mother_name, present_address, permanent_address, hall_name, email, password, graduation_year, course, job_title, company, bio)
            VALUES ('$full_name', '$father_name', '$mother_name', '$present_address', '$permanent_address', '$hall_name', '$email', '$password', '$graduation_year', '$course', '$job_title', '$company', '$bio')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
