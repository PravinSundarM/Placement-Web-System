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

if (!isset($_SESSION['student_id'])) {
    header("Location: studentlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    $job_id = $_POST['job_id'];
    $student_id = $_SESSION['student_id'];

    // Check if the student already applied for this job
    $check = mysqli_query($conn, "SELECT * FROM applications WHERE job_id='$job_id' AND student_id='$student_id'");
    if (mysqli_num_rows($check) == 0) {
        $apply = mysqli_query($conn, "INSERT INTO applications (job_id, student_id) VALUES ('$job_id', '$student_id')");
        if ($apply) {
            echo "<script>alert('Application Submitted');window.location='viewjob.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Already Applied');window.location='viewjob.php';</script>";
    }
}
?>