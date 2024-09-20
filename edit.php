<?php
session_start();
include("php/config.php");

// Redirect if not logged in
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id'];

// Fetch user information
$query = mysqli_query($con, "SELECT * FROM admin_users WHERE ID = '$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    // If no user is found, redirect or show an error message
    echo "User not found.";
    exit();
}

// Assign user details to variables
$res_Uname = $row['username'];
$res_Email = $row['email'];

// If form is submitted
if (isset($_POST['update'])) {
    $new_username = mysqli_real_escape_string($con, $_POST['username']);
    $new_email = mysqli_real_escape_string($con, $_POST['email']);
    
    // Update user details in the database
    mysqli_query($con, "UPDATE admin_users SET username='$new_username', email='$new_email' WHERE ID='$id'") or die("Update Error");

    // Update session variables
    $_SESSION['username'] = $new_username;
    $_SESSION['valid'] = $new_email;

    // Redirect or show a success message
    echo "Profile updated successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Edit Profile</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Edit Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $res_Email; ?>" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="update" value="Update">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
s