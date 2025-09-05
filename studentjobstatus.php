<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Status</title>
    <link rel="stylesheet" type="text/css" href="job.css"> <!-- Link to CSS file -->
</head>
<body>

<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";

$conn = new mysqli($servername, $username, $password, $database);


if (!isset($_SESSION['student_id'])) {
    header("Location: studentlogin.html");
    echo "Please log in to view job statuses.";
    exit;
}

$student_id = $_SESSION['student_id']; // Get logged-in student ID

$query = "SELECT jobs.title, company.name AS company_name, applications.status, applications.applied_at 
          FROM applications 
          JOIN jobs ON applications.job_id = jobs.job_id 
          JOIN company ON jobs.company_id = company.company_id 
          WHERE applications.student_id = ? 
          ORDER BY applications.applied_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Job Status</h2>";
echo "<table border='1'>
<tr>
<th>Job Title</th>
<th>Company</th>
<th>Status</th>
<th>Applied On</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['title']}</td>
    <td>{$row['company_name']}</td>
    <td>{$row['status']}</td>
    <td>{$row['applied_at']}</td>
    </tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>
