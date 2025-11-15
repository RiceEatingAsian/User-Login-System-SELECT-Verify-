<?php
// Start the session
session_start();

// Check if the user is NOT logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect unauthenticated users back to the login page
    $_SESSION['login_error'] = "You must log in to view this page.";
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e9ecef; display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .dashboard-card { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); width: 400px; text-align: center; }
        h1 { color: #28a745; margin-bottom: 20px; }
        p { color: #6c757d; font-size: 1.1em; }
        .logout-btn { background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-top: 30px; font-size: 16px; text-decoration: none; display: inline-block; transition: background-color 0.3s; }
        .logout-btn:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="dashboard-card">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>🎉 You are successfully logged in and viewing the protected dashboard.</p>
        <p>Your User ID is: <code><?php echo htmlspecialchars($_SESSION['user_id']); ?></code></p>
        
        <a href="logout.php" class="logout-btn">Log Out</a>
    </div>
</body>
</html>