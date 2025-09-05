
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

// Validate Job ID
if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
    echo "<script>alert('Invalid Job ID!'); window.location='companydashboard.php';</script>";
    exit();
}

$job_id = intval($_GET['job_id']);

// Fetch applicants for the selected job
$sql = "SELECT students.name, students.email, students.phone, students.department, students.resume, applications.status, applications.id AS application_id
        FROM applications
        JOIN students ON applications.student_id = students.student_id
        WHERE applications.job_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applicants</title>
    <style>
       <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        text-align: center;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #333;
        margin-top: 20px;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background: white;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color:  #18bc9c;
        color: white;
        font-size: 16px;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #e9ecef;
        transition: 0.3s;
    }

    .status-pending {
        color: orange;
        font-weight: bold;
    }

    .status-selected {
        color: green;
        font-weight: bold;
    }

    .status-rejected {
        color: red;
        font-weight: bold;
    }

    .accept-btn, .reject-btn {
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        margin: 2px;
    }

    .accept-btn {
        background-color: #28a745;
        color: white;
    }

    .accept-btn:hover {
        background-color: #218838;
    }

    .reject-btn {
        background-color: #dc3545;
        color: white;
    }

    .reject-btn:hover {
        background-color: #c82333;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

    </style>
</head>
<body>

    <center><h3>APPLICANTS FOR JOB                   <a href="deletejob.php?job_id=<?php echo $job_id; ?>" 
   onclick="return confirm('Are you sure you want to delete this job? This will remove all applications related to this job.');" 
   style="display: inline-block; padding: 10px 15px; background-color: red; color: white; text-decoration: none; border-radius: 5px;">
   Delete Job
</a></h3></center>


   
    <table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
        <th>Resume</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><?php echo htmlspecialchars($row['department']); ?></td>
       <td><a href="/placementsystems/student/<?php echo basename($row['resume']); ?>" target="_blank">View Resume</a></td>


        <td><?php echo htmlspecialchars($row['status']); ?></td>
        <td>
            <a href="updatestatus.php?application_id=<?php echo $row['application_id']; ?>&status=Accepted" class="accept-btn">Accept</a>   
            <a href="updatestatus.php?application_id=<?php echo $row['application_id']; ?>&status=Rejected" class="reject-btn">Reject</a>
           
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>

