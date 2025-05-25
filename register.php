<?php
// register.php
include("settings.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Show the form if not submitted yet
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register HR Manager</title>
    </head>
    <body>
        <h2>Register New HR Manager</h2>
        <form method="post" action="register.php">
            <p>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </p>
            <input type="submit" value="Register">
        </form>
    </body>
    </html>
    <?php
    exit();
}

// Otherwise, process the form submission
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Create the users table if it doesn't exist
$table_sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    login_attempts INT DEFAULT 0,
    last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $table_sql);

// Sanitize and validate input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$username = clean_input($_POST["username"]);
$password = $_POST["password"];

if (empty($username) || empty($password)) {
    echo "<p>Please fill in both fields.</p>";
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert into the users table
$stmt = mysqli_prepare($conn, "INSERT INTO users (username, password_hash) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $username, $password_hash);

if (mysqli_stmt_execute($stmt)) {
    echo "<p>Registration successful! <a href='login.php'>Click here to log in</a>.</p>";
} else {
    echo "<p>Error: That username may already exist.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
