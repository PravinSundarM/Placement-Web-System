<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
        }
        .btn {
            display: block;
            width: 200px;
            margin: 10px auto;
            padding: 12px;
            text-align: center;
            background-color: #18bc9c;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .logout-btn {
            background-color: red;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, Admin</h2>
    <a href="student_reports.php" class="btn">Student Reports</a>
    <a href="company_reports.php" class="btn">Company Reports</a>
    <a href="job_reports.php" class="btn">Job Reports</a>
    <a href="application_reports.php" class="btn">Application Reports</a>
    <a href="adminlogout.php" class="btn logout-btn">Logout</a>
</div>

</body>
</html>
