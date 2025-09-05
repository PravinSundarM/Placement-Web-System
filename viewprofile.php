<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: companylogin.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['id'];

// Fetch company details
$sql = "SELECT * FROM company WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();
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
            background: linear-gradient(135deg, #054034, #807e7e);
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 { color: #333; }
        .profile-details p {
            font-size: 16px;
            margin: 10px 0;
        }
        .profile-details span { font-weight: bold; }
        .btn {
            display: inline-block;
            background: #054034;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover { background: #062d23; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Company Profile</h1>
        <div class="profile-details">
            <p><span>Company Name:</span> <?php echo htmlspecialchars($company['name']); ?></p>
            <p><span>Email:</span> <?php echo htmlspecialchars($company['email']); ?></p>
            <p><span>Company Type:</span> <?php echo htmlspecialchars($company['companytype']); ?></p>
            <p><span>Location:</span> <?php echo htmlspecialchars($company['location']); ?></p>
            <p><span>Company Size:</span> <?php echo htmlspecialchars($company['companysize']); ?></p>
        </div>
        <a href="companyprofile.php" class="btn">Edit Profile</a>
    </div>
</body>
</html>
