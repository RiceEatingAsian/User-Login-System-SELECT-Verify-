<?php
// Start the session at the very beginning of the script
session_start();

// ----------------------------------------------------
// Database Configuration
// !! IMPORTANT: Update these values if they changed !!
// ----------------------------------------------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_experiment_db";

// Function to handle redirection and termination
function redirect_and_exit($location) {
    header("Location: " . $location);
    exit();
}

// 1. Check if the user is already logged in (using session)
if (isset($_SESSION['user_id'])) {
    redirect_and_exit('dashboard.php');
}

// 2. Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and Sanitize Input Data
    $input_email = trim($_POST['email']);
    $input_password = $_POST['password']; 

    if (empty($input_email) || empty($input_password)) {
        $_SESSION['login_error'] = "Email and password are required.";
        redirect_and_exit('login.html');
    }

    // Database Connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("❌ Database connection failed: " . $conn->connect_error);
    }

    // 3. PREPARED STATEMENT for Secure SELECT
    $sql = "SELECT id, name, password_hash FROM users WHERE email = ?";
    
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['login_error'] = "Database error during preparation.";
        redirect_and_exit('login.html');
    }
    
    // Bind the email parameter (s = string)
    $stmt->bind_param("s", $input_email);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $stored_hash = $user['password_hash'];

        // 4. Verify the Password (Crucial Step)
        // NOTE: Since our table update was manual, if you didn't re-register a user 
        // with a hashed password, this verification might fail.
        // For testing, try logging in with the user you registered in Exp 2.
        
        // If the hash is empty (for legacy users who didn't register with a hash), 
        // you might need a simple check, but standard practice is to force reset.
        // For this assignment, we'll assume a hash is present.
        
        if (password_verify($input_password, $stored_hash)) {
            // Login Successful!
            
            // 5. Implement Session Management
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            
            // Unset any previous error messages
            unset($_SESSION['login_error']);
            
            // Redirect to a dashboard or success page
            redirect_and_exit('dashboard.php');

        } else {
            // Password mismatch
            $_SESSION['login_error'] = "Invalid email or password.";
            redirect_and_exit('login.html');
        }

    } else {
        // User not found
        $_SESSION['login_error'] = "Invalid email or password.";
        redirect_and_exit('login.html');
    }

    // Close resources
    $stmt->close();
    $conn->close();

} else {
    // If accessed directly without POST
    $_SESSION['login_error'] = "Please log in using the form.";
    redirect_and_exit('login.html');
}

?>