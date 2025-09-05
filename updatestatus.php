 <?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: companylogin.php");
    exit();
}

// Validate GET parameters
if (!isset($_GET['application_id']) || !isset($_GET['status'])) {
    echo "<script>alert('Invalid request!');window.location='companydashboard.php';</script>";
    exit();
}

$id = $_GET['application_id'];
$status = $_GET['status'];

// Ensure status is valid
if (!in_array($status, ['Accepted', 'Rejected'])) {
    echo "<script>alert('Invalid status update!');window.location='companydashboard.php';</script>";
    exit();
}

// Update application status
$sql = "UPDATE applications SET status='$status' WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    mysqli_query($conn, "COMMIT");  // Ensure changes are saved
    echo "<script>alert('Application status updated successfully!');window.location='companydashboard.php';</script>";
} else {
    echo "Error updating status: " . mysqli_error($conn);
}
?>
