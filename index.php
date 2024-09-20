<?php
session_start();
include("php/config.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Select from the correct table (admin_users)
    $result = mysqli_query($con, "SELECT * FROM admin_users WHERE email='$email' AND password='$password'") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        $_SESSION['valid'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['ID']; // Assuming ID is the primary key in admin_users
        // Redirect after successful login
        header("Location: home.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        echo "<div class='message'>
            <p>Wrong Email or Password</p>
        </div><br>";
        echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
    }
}

// Success message for registration
if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
    echo "<div class='message'>
            <p>Registration successful! Please log in.</p>
          </div> <br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
