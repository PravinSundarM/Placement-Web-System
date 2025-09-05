<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'placementsystems');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT student_id, password FROM students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($student_id, $db_password);
    $stmt->fetch();

    if ($password === $db_password) {
        $_SESSION['student_id'] = $student_id;  // ✅ Correctly store student_id
        echo "<script>alert('Login Successful!'); window.location.href='studenthome.php';</script>";
    } else {
        echo "<script>alert('Invalid Credentials!');</script>";
    }
} else {
    echo "<script>alert('User not found!');</script>";
}

$stmt->close();
$conn->close();
?>
