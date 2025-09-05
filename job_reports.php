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

// Query 1: List of All Job Openings
$sql_all_jobs = "SELECT jobs.job_id, jobs.title, jobs.description, jobs.posted_date, company.name AS company_name
                 FROM jobs
                 JOIN company ON jobs.company_id = company.company_id";
$result_all_jobs = $conn->query($sql_all_jobs);

// Query 2: Jobs with the Most Applicants
$sql_top_jobs = "SELECT jobs.title, company.name AS company_name, COUNT(applications.id) AS total_applicants
                 FROM jobs
                 JOIN company ON jobs.company_id = company.company_id
                 JOIN applications ON jobs.job_id = applications.job_id
                 GROUP BY jobs.job_id
                 ORDER BY total_applicants DESC
                 LIMIT 10"; // Top 10 jobs with the most applicants
$result_top_jobs = $conn->query($sql_top_jobs);

// Query 3: Jobs with No Applications
$sql_no_applications = "SELECT jobs.title, company.name AS company_name
                        FROM jobs
                        JOIN company ON jobs.company_id = company.company_id
                        LEFT JOIN applications ON jobs.job_id = applications.job_id
                        WHERE applications.id IS NULL";
$result_no_applications = $conn->query($sql_no_applications);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Reports</title>
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

    <h2>List of All Job Openings</h2>
    <table>
        <tr>
            <th>Job ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Posted Date</th>
            <th>Company Name</th>
        </tr>
        <?php while ($row = $result_all_jobs->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['job_id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo $row['posted_date']; ?></td>
            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Top 10 Jobs with Most Applicants</h2>
    <table>
        <tr>
            <th>Job Title</th>
            <th>Company Name</th>
            <th>Total Applicants</th>
        </tr>
        <?php while ($row = $result_top_jobs->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
            <td><?php echo $row['total_applicants']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Jobs with No Applications</h2>
    <table>
        <tr>
            <th>Job Title</th>
            <th>Company Name</th>
        </tr>
        <?php while ($row = $result_no_applications->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
