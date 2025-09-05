<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";

// Connect to MySQL database using mysqli (compatible with old & new PHP versions)
$conn = mysqli_connect($servername, $username, $password, $database);

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = ""; // To store error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = md5($password); // MD5 hashing for compatibility

    // Prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Fetch the stored password from the database
    $sql = "SELECT * FROM company WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $company = mysqli_fetch_assoc($result);

        echo "<pre>Debugging: Stored Password = " . $company['password'] . "</pre>";
        echo "<pre>Debugging: Entered Password (Hashed) = " . $hashed_password . "</pre>";

        // Compare stored password with hashed password
        if ($company['password'] === $hashed_password) {
            $_SESSION['company_id'] = $company['company_id'];
            echo "<script>alert('Login Successful!'); window.location.href='companydashboard.php';</script>";
            exit();
        } else {
            $error = "Incorrect Password!";
        }
    } else {
        $error = "Email not found in database!";
    }
}

mysqli_close($conn);
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
        <?php if (!empty($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
