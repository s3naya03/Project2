<?php
// login.php
session_start();
include("settings.php");

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $current_time = time();
        $last_attempt = strtotime($user['last_attempt']);
        $lockout_time = 10 * 60; // 10 minutes

        // Check if locked out
        if ($user['login_attempts'] >= 3 && ($current_time - $last_attempt) < $lockout_time) {
            $remaining = $lockout_time - ($current_time - $last_attempt);
            echo "<p>Account locked. Try again in " . ceil($remaining / 60) . " minutes.</p>";
        } else {
            if (password_verify($password, $user['password_hash'])) {
                // Successful login
                $_SESSION['username'] = $user['username'];

                // Reset login attempts
                $reset = "UPDATE users SET login_attempts = 0 WHERE username = ?";
                $reset_stmt = mysqli_prepare($conn, $reset);
                mysqli_stmt_bind_param($reset_stmt, "s", $username);
                mysqli_stmt_execute($reset_stmt);

                header("Location: manage.php");
                exit();
            } else {
                // Failed login
                $update = "UPDATE users SET login_attempts = login_attempts + 1, last_attempt = NOW() WHERE username = ?";
                $fail_stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($fail_stmt, "s", $username);
                mysqli_stmt_execute($fail_stmt);
                echo "<p>Invalid credentials.</p>";
            }
        }
    } else {
        echo "<p>User not found.</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Login</title>
</head>
<body>
    <h2>HR Manager Login</h2>
    <form method="post" action="login.php">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </p>
        <input type="submit" value="Login">
    </form>
</body>
</html>
