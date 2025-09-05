<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";

$conn = new mysqli($servername, $username, $password, $database);
// Redirect if the company is not logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: companylogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_id = $_SESSION['company_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $vacancies = intval($_POST['vacancies']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $budget_type = mysqli_real_escape_string($conn, $_POST['budget_type']);
    $salary_range = mysqli_real_escape_string($conn, $_POST['salary_range']);
    $experience_level = mysqli_real_escape_string($conn, $_POST['experience_level']);
    $deadline = $_POST['deadline'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Insert job posting into the database
    $sql = "INSERT INTO jobs (company_id, title, category, vacancies, job_type, budget_type, salary_range, experience_level, deadline, description, location) 
            VALUES ('$company_id', '$title', '$category', '$vacancies', '$job_type', '$budget_type', '$salary_range', '$experience_level', '$deadline', '$description', '$location')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Job Posted Successfully');window.location='companydashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            background :linear-gradient(135deg, #054034, #807e7e);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height:140vh;
        }
        .registration-form {
            background: #fff;
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .registration-form h2 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }
        .registration-form input,
        .registration-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .registration-form button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .registration-form button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<div class="registration-form"">
    <h2>Post Jobs</h2>
    <form method="post">
        <label for="title">Job Title:</label> 
        <input type="text" id="title" name="title" required>

        <label for="category">Category:</label> 
        <input type="text" id="category" name="category" required>

        <label for="vacancies">Vacancies:</label> 
        <input type="number" id="vacancies" name="vacancies" required>

        <label for="job_type">Job Type:</label> 
        <select id="job_type" name="job_type">
            <option>Full Time</option>
            <option>Part Time</option>
        </select>

        <label for="budget_type">Budget Type:</label> 
        <select id="budget_type" name="budget_type">
            <option>Fixed Salary</option>
            <option>Salary Range</option>
            <option>Negotiable</option>
        </select>

        <label for="salary_range">Salary Range:</label> 
        <input type="text" id="salary_range" name="salary_range">

        <label for="experience_level">Experience Level:</label> 
        <input type="text" id="experience_level" name="experience_level">

        <label for="Eligibility">Eligibility:</label> 
        <input type="text" id="eligibility" name="eligibility">

        
        <label for="deadline">Deadline:</label> 
        <input type="date" id="deadline" name="deadline">

        <label for="location">Location:</label> 
        <input type="text" id="location" name="location">

        <label for="description">Description:</label> 
        <textarea id="description" name="description"></textarea>

        <br>
        <br>    
        <button type="submit">Post Job</button>
    </form>
</div>

</body>
</html>
