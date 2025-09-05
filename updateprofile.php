<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from logged-in session
if (!isset($_SESSION['student_id'])) {
    header("Location: studentlogin.php"); // Redirect to login if not logged in
    exit();
}
$student_id = $_SESSION['student_id'];

// Fetch student details
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

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $roll_no = $_POST['roll_no'];
    $dob = $_POST['dob'];
    $batch = $_POST['batch'];
    $department = $_POST['department'];
   
    // Check if a new resume file is uploaded
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $resume_dir = "student/";
        $resume_file = $resume_dir . basename($_FILES['resume']['name']);
        move_uploaded_file($_FILES['resume']['tmp_name'], $resume_file);

        // Update resume path in the database
        $update_sql = "UPDATE students SET name = ?, email = ?, phone = ?, roll_no = ?, dob = ?, batch = ?, department = ?,  resume = ? WHERE student_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssssssi", $name, $email, $phone, $roll_no, $dob, $batch, $department, $resume_file, $student_id);
    } else {
        // Update profile without changing resume
        $update_sql = "UPDATE students SET name = ?, email = ?, phone = ?,roll_no = ?, dob = ?, batch = ?, department = ? WHERE student_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssssi", $name, $email, $phone, $roll_no, $dob, $batch, $department,  $student_id);
    }

    if ($update_stmt->execute()) {
        echo "Profile updated successfully.";
         // Refresh the page to show updated details
    } else {
        echo "Error updating profile: " . $update_stmt->error;
    }
    $update_stmt->close();
}

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
            background-color:rgb(118, 168, 152);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
    
        }
        .container {
           
            background: #fff;
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details p, .profile-details form label {
            font-size: 16px;
            margin: 10px 0;
        }
        .profile-details span {
            font-weight: bold;
        }
        .profile-details form input, .profile-details form select, .profile-details form button {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .profile-details form button {
            background: #054034;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .profile-details form button:hover {
            background: #04662c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Profile</h1>
        <div class="profile-details">
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                <label for="phone">Phone number</label>
                <input type="phone" id="email" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                <label for="roll_no">Roll No</label>
                <input type="text" id="roll_no" name="roll_no" value="<?php echo htmlspecialchars($student['roll_no']); ?>" required>
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
                <label for="batch">Batch</label>
                <input type="text" id="batch" name="batch" value="<?php echo htmlspecialchars($student['batch']); ?>" required>
                <label for="department">Department</label>
                <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($student['department']); ?>" required>
                
                <label for="resume">Upload New Resume</label>
                <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx">
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
