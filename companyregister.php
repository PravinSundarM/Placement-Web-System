<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "placementsystems";

$conn = new mysqli($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $companytype=$_POST['companytype'];
    $location = $_POST['location'];
    $sql = "INSERT INTO company(name, email, password,companytype,location) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss",$name, $email, $password,$companytype,$location);

    if ($stmt->execute()) {
       $_SESSION['company_id'] = $stmt->insert_id;
        echo "<script>alert('Registration successful!');window.location.href='companydashboard.php';</script>";
       
        exit;
    } else {
        echo "<script>alert('Error: Email already exists.');</script>";
    }
$stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>company Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background :linear-gradient(135deg, #054034, #807e7e);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height:100vh;
        }
        .registration-form {
            background: #fff;
            padding: 40px;
            border-radius: 50px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
            width: 350px;
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
<body>
    <form class="registration-form" action="companyregister.php" method="POST">
        <h2>Company Registration</h2> 
        <input type="text" name="name" placeholder="Company Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="companytype" required>
            <option value="" disabled selected>Company Type</option>
            <option value="Software Company">Software Company</option>
            <option value="Development">Development Company</option>
            <option value="Account&Finance company">Finance Company</option>
            <option value="Edtech company">Edtech Company</option>
            <option value="Others">Others</option>
        </select>
        <input type="text" name="location" placeholder="Location" required>
        <button type="submit">Register</button>
        <p>Have already registered?</p>
        
<!-- Use an anchor tag for navigation instead of a button -->
<a href="companylogin.php">
    <button type="button">Login</button>
</a>

    </form>
</body>
</html>                                                                                                                                                        