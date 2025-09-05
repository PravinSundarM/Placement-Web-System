<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: companylogin.php");
    exit();
}

$company_id = $_SESSION['company_id'];

// Validate Job ID
if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
    echo "<script>alert('Invalid Job ID!'); window.location='companydashboard.php';</script>";
    exit();
}

$job_id = intval($_GET['job_id']);

// Check if the job belongs to the logged-in company
$check_sql = "SELECT company_id FROM jobs WHERE job_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $job_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();
$job = $check_result->fetch_assoc();

if (!$job || $job['company_id'] != $company_id) {
    echo "<script>alert('Unauthorized: You can only delete your own job postings!'); window.location='companydashboard.php';</script>";
    exit();
}

// Delete applications first (to maintain referential integrity)
$delete_applications_sql = "DELETE FROM applications WHERE job_id = ?";
$delete_applications_stmt = $conn->prepare($delete_applications_sql);
$delete_applications_stmt->bind_param("i", $job_id);
$delete_applications_stmt->execute();

// Delete the job
$delete_job_sql = "DELETE FROM jobs WHERE job_id = ?";
$delete_job_stmt = $conn->prepare($delete_job_sql);
$delete_job_stmt->bind_param("i", $job_id);
$delete_job_stmt->execute();

// Redirect to dashboard with a success message
echo "<script>alert('Job deleted successfully!'); window.location='companydashboard.php';</script>";

$delete_applications_stmt->close();
$delete_job_stmt->close();
$conn->close();
?>
