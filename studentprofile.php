


<?php
session_start();


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";
$conn = new mysqli($servername, $username, $password, $database);

// Get student ID from logged in session
$student_id = $_SESSION['student_id'];

// Query using student_id
$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found";
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(118, 168, 152);
        }
        .container {
            max-width: 600px;
            margin: 10px auto;
            justify-content:center;
            padding: 100px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details p {
            font-size: 16px;
            margin: 10px 0;
        }
        .profile-details span {
            font-weight: bold;
        }
        .update-btn {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .update-btn a {
            text-decoration: none;
            padding: 10px 20px;
            background: #054034;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .update-btn a:hover {
            background: #04662c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Profile</h1>
        <div class="profile-details">
            <p><span>Name:</span> <?php echo htmlspecialchars($student['name']); ?></p>
            <p><span>Email:</span> <?php echo htmlspecialchars($student['email']); ?></p>
            <p><span>Roll No:</span> <?php echo htmlspecialchars($student['roll_no']); ?></p>
            <p><span>Date of Birth:</span> <?php echo htmlspecialchars($student['dob']); ?></p>
            <p><span>Batch:</span> <?php echo htmlspecialchars($student['batch']); ?></p>
            <p><span>Department:</span> <?php echo htmlspecialchars($student['department']); ?></p>
           
            <p><span>Resume:</span> 
                <a href="<?php echo htmlspecialchars($student['resume']); ?>" target="_blank">View Resume</a>
            </p>
        </div>
     <div class="update-btn">
            <a href="updateprofile.php">Update Profile</a>
        </div>
    </div>
</body>
</html>

