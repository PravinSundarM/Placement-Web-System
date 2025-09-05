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

// Query 1: List of Registered Students
$sql_students = "SELECT * FROM students";
$result_students = $conn->query($sql_students);

// Query 2: Number of Students Per Department
$sql_department = "SELECT department, COUNT(*) AS student_count FROM students GROUP BY department";
$result_department = $conn->query($sql_department);

// Query 3: Students Who Applied for Jobs
$sql_applied = "SELECT DISTINCT students.student_id, students.name, students.email, students.phone, students.department
                FROM students
                JOIN applications ON students.student_id = applications.student_id";
$result_applied = $conn->query($sql_applied);

// Query 4: Students Selected/Rejected for Jobs
$sql_status = "SELECT students.name, students.email, students.phone, students.department, applications.status
               FROM students
               JOIN applications ON students.student_id = applications.student_id
               WHERE applications.status IN ('Accepted', 'Rejected')";
$result_status = $conn->query($sql_status);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Reports</title>
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

    <h2>List of Registered Students</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
        </tr>
        <?php while ($row = $result_students->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['department']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Number of Students Per Department</h2>
    <table>
        <tr>
            <th>Department</th>
            <th>Student Count</th>
        </tr>
        <?php while ($row = $result_department->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['student_count']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Students Who Applied for Jobs</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
        </tr>
        <?php while ($row = $result_applied->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['department']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <h2>Students Selected/Rejected for Jobs</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result_status->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
