
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
    <style>
/* General Styles */
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
    padding: 40px 10px;
    background: linear-gradient(135deg, #18bc9c, #2c3e50);
    color: white;
}

.header h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
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
        <h2>Your Gateway to Opportunities</h2>
        <p>Search for jobs, update your profile, and manage your career journey.</p>
    </header>


    <main class="main-content">
        <div class="card-container">
            <div class="card">
                <h3>Search Jobs</h3>
                <p>Find your dream job from top companies.</p>
                <a href="viewjob.php" class="btn">Explore Jobs</a>
            </div>
            <div class="card">
                <h3>My Profile</h3>
                <p>View and update your personal information.</p>
                <a href="studentprofile.php" class="btn">View Profile</a>
            </div>
            <div class="card">
                <h3>Job Status</h3>
                <p>Status For Applied Jobs</p>
                <a href="studentjobstatus.php" class="btn">View Job Status</a>
            </div>
            <div class="card">
                <h3>Logout</h3>
                <p>End your session securely.</p>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Placement Web System. All rights reserved.</p>
    </footer>
</body>
</html>




