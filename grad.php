<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM admin_users WHERE ID = $id");

while ($result = mysqli_fetch_assoc($query)) {
    $res_Uname = $result['username'];
    $res_Email = $result['email'];
}

// Handle the form submission to get data based on ID
$graduateData = null;
if (isset($_POST['search'])) {
    $searchId = intval($_POST['search_id']);
    $graduateQuery = mysqli_query($con, "SELECT * FROM `2024-2025` WHERE ID = $searchId");
    $graduateData = mysqli_fetch_assoc($graduateQuery);
}

// Handle save/update functionality
if (isset($_POST['save'])) {
    $updateId = intval($_POST['id']);
    $lastName = $_POST['last_name'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $department = $_POST['department'];
    $program = $_POST['program'];
    $yearGraduated = $_POST['year_graduated'];
    $contactNumber = $_POST['contact_number'];
    $personalEmail = $_POST['personal_email'];
    $workingStatus = $_POST['working_status'];

    // Update query
    $updateQuery = "UPDATE `2024-2025` SET 
        Last_Name='$lastName', 
        First_Name='$firstName', 
        Middle_Name='$middleName', 
        Department='$department', 
        Program='$program', 
        Year_Graduated='$yearGraduated', 
        Contact_Number='$contactNumber', 
        Personal_Email='$personalEmail', 
        Working_Status='$workingStatus' 
        WHERE ID=$updateId";

    mysqli_query($con, $updateQuery);
    header("Location: grad.php"); // Redirect after saving
}

// Handle delete functionality
if (isset($_POST['delete'])) {
    $deleteId = intval($_POST['id']);
    $deleteQuery = "DELETE FROM `2024-2025` WHERE ID=$deleteId";
    mysqli_query($con, $deleteQuery);
    header("Location: grad.php"); // Redirect after deleting
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Manage Graduates</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">PLMUN Alumni</a></p>
        </div>
        <div class="right-links">
            <?php echo "<a href='edit.php?Id=$id'>Change Profile</a>"; ?>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <main>
        <div class="main-box top">
            <div class="box" style="text-align: center;">
                <p>Hello <b><?php echo $res_Uname; ?></b>, Welcome!</p>
            </div>
        </div>

        <div class="main-box table-container">
            <h2>Manage Graduates</h2>
            <form method="post">
                <label for="search_id">Enter ID to search:</label>
                <input type="number" name="search_id" required>
                <button type="submit" name="search">Search</button>
            </form>

            <?php if ($graduateData): ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $graduateData['ID']; ?>">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo $graduateData['Last_Name']; ?>" required>
                    <label>First Name:</label>
                    <input type="text" name="first_name" value="<?php echo $graduateData['First_Name']; ?>" required>
                    <label>Middle Name:</label>
                    <input type="text" name="middle_name" value="<?php echo $graduateData['Middle_Name']; ?>" required>
                    <label>Department:</label>
                    <input type="text" name="department" value="<?php echo $graduateData['Department']; ?>" required>
                    <label>Program:</label>
                    <input type="text" name="program" value="<?php echo $graduateData['Program']; ?>" required>
                    <label>Year Graduated:</label>
                    <input type="text" name="year_graduated" value="<?php echo $graduateData['Year_Graduated']; ?>" required>
                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" value="<?php echo $graduateData['Contact_Number']; ?>" required>
                    <label>Personal Email:</label>
                    <input type="email" name="personal_email" value="<?php echo $graduateData['Personal_Email']; ?>" required>
                    <label>Working Status:</label>
                    <input type="text" name="working_status" value="<?php echo $graduateData['Working_Status']; ?>" required>
                    <button type="submit" name="save">Save</button>
                    <button type="submit" name="delete">Delete</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
