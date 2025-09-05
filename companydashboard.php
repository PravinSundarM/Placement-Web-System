<?php
session_start();
if (!isset($_SESSION['company_id'])) {
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

$company_id = $_SESSION['company_id'];

// Fetch company details
$sql = "SELECT * FROM company WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();
$stmt->close();
$job_sql = "SELECT job_id, title FROM jobs WHERE company_id = ?";
$job_stmt = $conn->prepare($job_sql);
$job_stmt->bind_param("i", $company_id);
$job_stmt->execute();
$job_result = $job_stmt->get_result();

$jobs = [];
while ($row = $job_result->fetch_assoc()) {
    $jobs[] = $row;
}

$job_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

/* Navbar */
.navbar {
    background-color: #2c3e50;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.navbar h1 {
    font-size: 1.5rem;
}

.navbar ul {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar li {
    margin: 0 10px;
}

.navbar a {
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.navbar a:hover {
    color: #18bc9c;
    transition: color 0.3s ease;
}

/* Header */
.header {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #18bc9c, #2c3e50);
    color: white;
}

.header h2 {
    font-size: 2.25rem;
    margin-bottom: 20px;
}

.header p {
    font-size: 1.2rem;
}

/* Main Content */
.main-content {
    display: flex;
    justify-content: center;
    padding: 20px;
}


.card-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
   
.card {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 300px;
    border-top: 5px solid #18bc9c;
    
}

.card h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.card p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 20px;
}

.card .btn {
    display: inline-block;
    padding: 10px 15px;
    background-color: #18bc9c;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.card .btn:hover {
    background-color: #16a085;
    transition: background-color 0.3s ease;
}

/* Footer */
.footer {
    text-align: center;
    padding: 10px 0;
    background-color: #2c3e50;
    color: white;
    font-size: 0.9rem;
    margin-top: 25px;
}

</style>
</head>
<body>
  <nav class="navbar">
<h1> Welcome...!</h1>
</nav>
    <header class="header">
        <h2>Find Young Talents For Your Company</h2>
       
    </header>


    <main class="main-content">
        <div class="card-container">
            
           <div class="card">
                <h3>Company Profile</h3>
                <p>View and update Profile.</p>
                <a href="companyprofile.php" class="btn">Company Profile</a>
            </div>
            <div class="card">
                <h3>Post Job</h3>
                <p>Post the  new Job Opening</p>
                <a href="postjob.php" class="btn">Post Job</a>
            </div>
             <div class="card">
              <h3>View Applicants</h3>
              <p>View applications for your job postings.</p>
              <ul>
                <?php if (!empty($jobs)): ?>
                  <?php foreach ($jobs as $job): ?>
                    <li>
                      <a href="viewapplicants.php?job_id=<?php echo $job['job_id']; ?>" class="btn">
                        Applicants for <?php echo htmlspecialchars($job['title']); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p>No job postings yet.</p>
                <?php endif; ?>
              </ul>
          </div>
            <div class="card">
                <h3>Logout</h3>
                <p>Logout from Company </p>
                <a href="companylogout.php" class="btn">Logout</a>
            </div>
        </div>
    </main>

    <footer class="footer">

<br>
        <p>&copy; 2024 Placement Web System. All rights reserved.</p>
<br>
<br>
    </footer>
</body>
</html>
       