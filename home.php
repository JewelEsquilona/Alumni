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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Admin Panel</title>
    <style>
        .toggleable-table {
            display: none; /* Hide tables by default */
            margin-top: 10px;
        }
        .toggle-header {
            cursor: pointer;
            background-color: #f1f1f1;
            padding: 10px;
            border: 1px solid #ddd;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
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

        <!-- Joined Graduates Table Section -->
        <div class="main-box table-container">
            <h2>Batch 2024-2025 Graduates</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumni ID</th>
                        <th>Student Number</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Department</th>
                        <th>Program</th>
                        <th>Year Graduated</th>
                        <th>Contact Number</th>
                        <th>Personal Email</th>
                        <th>Working Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Join the two tables based on Alumni_ID_Number
                    $result = mysqli_query($con, "
                        SELECT g.*, ws.Working_Status 
                        FROM `2024-2025` g 
                        LEFT JOIN `2024-2025_ws` ws 
                        ON g.Alumni_ID_Number = ws.Alumni_ID_Number
                    ");

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row['ID']."</td>";
                        echo "<td>".$row['Alumni_ID_Number']."</td>";
                        echo "<td>".$row['Student_Number']."</td>";
                        echo "<td>".$row['Last_Name']."</td>";
                        echo "<td>".$row['First_Name']."</td>";
                        echo "<td>".$row['Department']."</td>";
                        echo "<td>".$row['Program']."</td>";
                        echo "<td>".$row['Year_Graduated']."</td>";
                        echo "<td>".$row['Contact_Number']."</td>";
                        echo "<td>".$row['Personal_Email']."</td>";
                        echo "<td>".$row['Working_Status']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
