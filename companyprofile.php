<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";
$conn = new mysqli($servername, $username, $password, $database);

// Check if the user is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: companylogin.php");
    exit();
}

// Get company ID from session
$company_id = $_SESSION['company_id'];

// Query to fetch company details
$sql = "SELECT * FROM company WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $company = $result->fetch_assoc();
} else {
    echo "Company not found";
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
    <title>Company Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Company Profile</h1>
        <div class="profile-details">
            <p><span>Name:</span> <?php echo htmlspecialchars($company['name']); ?></p>
            <p><span>Email:</span> <?php echo htmlspecialchars($company['email']); ?></p>
            <p><span>Company Type:</span> <?php echo htmlspecialchars($company['companytype']); ?></p> 
            <p><span>Location:</span> <?php echo htmlspecialchars($company['location']); ?></p>
        </div>
<p><a href="updatecompanyprofile.php" style="display: inline-block; padding: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Edit Profile</a></p>
    </div>
</body>
</html>