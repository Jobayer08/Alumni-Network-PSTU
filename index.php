
<?php
session_start();

if (isset($_SESSION['user_id']) || isset($_SESSION['is_admin'] )) {
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: dashboard.php"); 
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PSTU Alumni Network</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('1.webp') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 0px 20px rgba(65, 65, 65, 0.2);
        }

       

         .container p {
         color:#ffffff; 
              }

        a.button {
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
        }
        .login-btn {
            background: rgb(44, 193, 78);
        }
        .register-btn {
            background: rgb(11, 77, 87);
        }
    </style>
</head>
<body>

<div class="container">
   <h1 style="color: darkblue;font-size: 32px;
    text-shadow: 1px 1px 2px gray;">Welcome to the PSTU Alumni Network</h1>
<p style="color:rgb(229, 229, 241); font-size: 15px;
    line-height: 1.5; background: rgb(14, 16, 15);">This is a platform where alumni can connect, share updates, and stay in touch with their university community.</p>

    <p style="margin-top: 40px;">
        <a href="login.php" class="button login-btn">Login</a>
        <a href="register.php" class="button register-btn">Register</a>
    </p>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
