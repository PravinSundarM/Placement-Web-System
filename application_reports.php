<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

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

// Query 1: Number of Applications Per Job
$sql_applications_per_job = "SELECT jobs.title, company.name AS company_name, COUNT(applications.id) AS total_applications
                             FROM applications
                             JOIN jobs ON applications.job_id = jobs.job_id
                             JOIN company ON jobs.company_id = company.company_id
                             GROUP BY jobs.job_id
                             ORDER BY total_applications DESC";
$result_applications_per_job = $conn->query($sql_applications_per_job);

// Query 2: Status Breakdown (Pending, Accepted, Rejected)
$sql_status_breakdown = "SELECT status, COUNT(id) AS total FROM applications GROUP BY status";
$result_status_breakdown = $conn->query($sql_status_breakdown);

// Query 3: Total Applications by Each Student
$sql_applications_per_student = "SELECT students.name, students.email, COUNT(applications.id) AS total_applications
                                 FROM applications
                                 JOIN students ON applications.student_id = students.student_id
                                 GROUP BY students.student_id
                                 ORDER BY total_applications DESC";
$result_applications_per_student = $conn->query($sql_applications_per_student);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-top: 20px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #18bc9c;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

    <h2>Number of Applications Per Job</h2>
    <table>
        <tr>
            <th>Job Title</th>
            <th>Company Name</th>
            <th>Total Applications</th>
        </tr>
        <?php while ($row = $result_applications_per_job->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
            <td><?php echo $row['total_applications']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Application Status Breakdown</h2>
    <table>
        <tr>
            <th>Status</th>
            <th>Total Applications</th>
        </tr>
        <?php while ($row = $result_status_breakdown->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo $row['total']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Total Applications by Each Student</h2>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Email</th>
            <th>Total Applications</th>
        </tr>
        <?php while ($row = $result_applications_per_student->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo $row['total_applications']; ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
