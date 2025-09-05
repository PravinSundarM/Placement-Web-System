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

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id=$_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $roll_no = $_POST['roll_no'];
    $dob = $_POST['dob'];
    $batch = $_POST['batch'];
    $department = $_POST['department'];

    // Validate required fields
    if (empty($department)) {
        die("Department is required.");
    }

    // Handle file upload
    $resume = $_FILES['resume'];
    $resume_name = $resume['name'];
    $resume_tmp = $resume['tmp_name'];
    $resume_folder = "student/" . basename($resume_name);
   
if (!is_dir("student")) {
        mkdir("student", 0777, true); // Create the directory if it doesn't exist
    }


    if (move_uploaded_file($resume_tmp, $resume_folder)) {
        // Insert into database
        $sql = "INSERT INTO students (student_id,name, email, phone, password, roll_no, dob, batch, resume,department) VALUES (?,?, ?, ?, ?, ?, ?, ?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssssss",$student_id, $name, $email, $phone, $password, $roll_no, $dob, $batch, $resume_folder,$department);

        if ($stmt->execute()) {
            // Set session and redirect to profile page
            $_SESSION['student_id'] = $stmt->insert_id; // Get the last inserted ID
            header("Location: studenthome.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Failed to upload resume.";
    }
}
$conn->close();
?>
