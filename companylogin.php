<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";

$conn = new mysqli($servername, $username, $password, $database);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    echo "<pre>Debugging Output:</pre>";

    // Check if email exists in the database
    $sql = "SELECT * FROM company WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error in SQL prepare: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
        echo "<pre>Stored Hashed Password: " . $company['password'] . "</pre>";
        echo "<pre>Entered Password: " . $password . "</pre>";

        // Verify the entered password
        if (password_verify($password, $company['password'])) {
            $_SESSION['company_id'] = $company['company_id'];
            echo "<script>alert('Login Successful...!'); window.location.href='companydashboard.php';</script>";
            exit();
        } else {
            echo "<pre>password_verify() failed!</pre>";
        }
    } else {
        echo "<pre>Email not found in database!</pre>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST" action="">
        <h2>Company Login</h2>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>                                                                     