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

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: studentlogin.php");
    exit();
}

// Fetch job listings from the database
$sql = "SELECT jobs.*, company.name AS company_name 
        FROM jobs 
        JOIN company ON jobs.company_id = company.company_id 
        ORDER BY jobs.posted_date DESC";;
$result = mysqli_query($conn, $sql);

// If student applies for a job
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    $student_id = $_SESSION['student_id'];
    $job_id = $_POST['job_id'];

    // Check if the student already applied for the job
    $check_sql = "SELECT * FROM applications WHERE student_id = '$student_id' AND job_id = '$job_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('You have already applied for this job!');</script>";
    } else {
        // Insert application into database
        $apply_sql = "INSERT INTO applications (student_id, job_id, status) VALUES ('$student_id', '$job_id', 'Pending')";
        if (mysqli_query($conn, $apply_sql)) {
            echo "<script>alert('Job application submitted successfully!');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Jobs</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.job-container {
    border: 1px solid #ddd;
    padding: 20px;
    margin: 20px auto;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    max-width: 700px;
}

.job-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.job-title {
    font-size: 22px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 10px;
}

.job-details p {
    font-size: 16px;
    margin: 5px 0;
    color: #555;
}

.job-details strong {
    color: #333;
}

.job-description {
    white-space: pre-wrap;
    color: #444;
    font-size: 15px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.apply-button {
    display: block;
    width: 100%;
    background-color: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease;
}

.apply-button:hover {
    background-color: #0056b3;
}

.apply-button:disabled {
    background-color: #ccc;
    cursor: default;
}

/* Responsive Design */
@media (max-width: 768px) {
    .job-container {
        padding: 15px;
        margin: 10px;
    }

    .job-title {
        font-size: 20px;
    }

    .job-details p {
        font-size: 14px;
    }

    .apply-button {
        font-size: 14px;
        padding: 10px;
    }
}
</style>

       
</head>
<body>
    <h2>Available Jobs</h2>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
            <h3><?php echo $row['title']; ?></h3>
            <p><strong>Company:</strong> <?php echo $row['company_name']; ?></p>
            <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
            <p><strong>Vacancies:</strong> <?php echo $row['vacancies']; ?></p>
            <p><strong>Job Type:</strong> <?php echo $row['job_type']; ?></p>
            <p><strong>Salary:</strong> <?php echo $row['salary_range']; ?></p>
            <p><strong>Experience Level:</strong> <?php echo $row['experience_level']; ?></p>
            <p><strong>Deadline:</strong> <?php echo $row['deadline']; ?></p>
            <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
            <p><strong>Description:</strong> <?php echo $row['description']; ?></p>

            <form action=applyjob.php method="POST">
            <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">

            <button type="submit" name="apply">Apply Now</button>
            </form>
        </div>
    <?php } ?>

</body>
</html>
 

