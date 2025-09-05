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

// Query 1: List of Registered Companies
$sql_companies = "SELECT * FROM company";
$result_companies = $conn->query($sql_companies);

// Query 2: Number of Job Postings by Each Company
$sql_job_postings = "SELECT company.name, COUNT(jobs.job_id) AS total_jobs
                     FROM company
                     LEFT JOIN jobs ON company.company_id = jobs.company_id
                     GROUP BY company.company_id";
$result_job_postings = $conn->query($sql_job_postings);

// Query 3: Companies with the Highest Hiring Rate
$sql_hiring_rate = "SELECT company.name, COUNT(applications.id) AS total_hired
                    FROM company
                    JOIN jobs ON company.company_id = jobs.company_id
                    JOIN applications ON jobs.job_id = applications.job_id
                    WHERE applications.status = 'Accepted'
                    GROUP BY company.company_id
                    ORDER BY total_hired DESC
                    LIMIT 10"; // Top 10 companies with the highest hiring rate
$result_hiring_rate = $conn->query($sql_hiring_rate);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Reports</title>
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

    <h2>List of Registered Companies</h2>
    <table>
        <tr>
            <th>Company ID</th>
            <th>Company Name</th>
            <th>Email</th>
        </tr>
        <?php while ($row = $result_companies->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['company_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Number of Job Postings by Each Company</h2>
    <table>
        <tr>
            <th>Company Name</th>
            <th>Number of Job Postings</th>
        </tr>
        <?php while ($row = $result_job_postings->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['total_jobs']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Top 10 Companies with Highest Hiring Rate</h2>
    <table>
        <tr>
            <th>Company Name</th>
            <th>Number of Students Hired</th>
        </tr>
        <?php while ($row = $result_hiring_rate->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['total_hired']; ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
