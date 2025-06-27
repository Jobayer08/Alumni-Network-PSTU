<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$picture_path = $user['profile_picture'];

if (isset($_POST['update'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $mother_name = $conn->real_escape_string($_POST['mother_name']);
    $present_address = $conn->real_escape_string($_POST['present_address']);
    $permanent_address = $conn->real_escape_string($_POST['permanent_address']);
    $hall_name = $conn->real_escape_string($_POST['hall_name']);
    $graduation_year = $_POST['graduation_year'];
    $course = $conn->real_escape_string($_POST['course']);
    $job_title = $conn->real_escape_string($_POST['job_title']);
    $company = $conn->real_escape_string($_POST['company']);
    $bio = $conn->real_escape_string($_POST['bio']);

    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }

        $file_name = basename($_FILES['profile_picture']['name']);
        $target_file = $target_dir . time() . "_" . $file_name;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $picture_path = $target_file;
        }
    }

    $sql = "UPDATE users SET 
        full_name='$full_name',
        father_name='$father_name',
        mother_name='$mother_name',
        present_address='$present_address',
        permanent_address='$permanent_address',
        hall_name='$hall_name',
        graduation_year='$graduation_year',
        course='$course',
        job_title='$job_title',
        company='$company',
        bio='$bio',
        profile_picture='$picture_path'
        WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['full_name'] = $full_name;
        echo "<script>alert('Profile updated successfully!');</script>";
        $result = $conn->query("SELECT * FROM users WHERE id=$user_id LIMIT 1");
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('Update failed!');</script>";
    }
}
?>

<?php include 'header.php'; ?>

<title>My Profile</title>
<style>
    body { font-family: Arial; background:rgba(47, 166, 142, 0.83); padding: 20px; }
    form { background:#ffffff; padding: 25px; max-width: 600px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px #ff6f61; }
    input, textarea { width: 100%; padding: 8px; margin: 10px 0; border-radius: 5px; border: 1px solid #ff6f61; }
    input[type="submit"] { background:rgba(62, 73, 134, 0.81); color: white; cursor: pointer; }
    input[type="submit"]:hover { background:rgba(54, 7, 206, 0.8); }
    .logout { text-align: center; margin-top: 20px; }
    img { display: block; margin: 0 auto 15px; }
</style>

<h2 style="text-align:center;">My Profile</h2>

<?php if (!empty($user['profile_picture'])): ?>
    <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture" width="150" height="150" style="border-radius: 50%;">
<?php endif; ?>

<form method="post" action="" enctype="multipart/form-data">
    <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
    <input type="text" name="father_name" value="<?php echo $user['father_name']; ?>" placeholder="Father's Name" required>
    <input type="text" name="mother_name" value="<?php echo $user['mother_name']; ?>" placeholder="Mother's Name" required>
    <input type="text" name="present_address" value="<?php echo $user['present_address']; ?>" placeholder="Present Address" required>
    <input type="text" name="permanent_address" value="<?php echo $user['permanent_address']; ?>" placeholder="Permanent Address" required>
    <input type="text" name="hall_name" value="<?php echo $user['hall_name']; ?>" placeholder="Hall Name" required>
    <input type="number" name="graduation_year" value="<?php echo $user['graduation_year']; ?>">
    <input type="text" name="course" value="<?php echo $user['course']; ?>">
    <input type="text" name="job_title" value="<?php echo $user['job_title']; ?>">
    <input type="text" name="company" value="<?php echo $user['company']; ?>">
    <textarea name="bio"><?php echo $user['bio']; ?></textarea>

    <label>Profile Picture:</label>
    <input type="file" name="profile_picture" accept="image/*">

    <input type="submit" name="update" value="Update Profile">
</form>

<?php include 'footer.php'; ?>
