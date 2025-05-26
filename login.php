<?php
session_start();
include("settings.php");

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

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
        $lockout_time = 10 * 60;

        if ($user['login_attempts'] >= 3 && ($current_time - $last_attempt) < $lockout_time) {
            $remaining = $lockout_time - ($current_time - $last_attempt);
            $message = "Account locked. Try again in " . ceil($remaining / 60) . " minutes.";
        } else {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['username'] = $user['username'];
                $reset = "UPDATE users SET login_attempts = 0 WHERE username = ?";
                $reset_stmt = mysqli_prepare($conn, $reset);
                mysqli_stmt_bind_param($reset_stmt, "s", $username);
                mysqli_stmt_execute($reset_stmt);
                header("Location: manage.php");
                exit();
            } else {
                $update = "UPDATE users SET login_attempts = login_attempts + 1, last_attempt = NOW() WHERE username = ?";
                $fail_stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($fail_stmt, "s", $username);
                mysqli_stmt_execute($fail_stmt);
                $message = "Invalid credentials.";
            }
        }
    } else {
        $message = "User not found.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<?php include("header.inc"); ?>
<?php include("nav.inc"); ?>

<main class="container" style="max-width: 500px; margin: 3rem auto; padding: 2rem; background-color: #f9f9f9; border-radius: 10px;">
    <h2 style="text-align: center;">HR Manager Login</h2>
    <?php if (!empty($message)) echo "<p style='color:red; text-align:center;'>$message</p>"; ?>
    <form method="post" action="login.php">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required style="width: 100%; padding: 8px;">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required style="width: 100%; padding: 8px;">
        </p>
        <p style="text-align: center;">
            <button type="submit" class="btn">Login</button>
        </p>
    </form>
</main>

<?php include("footer.inc"); ?>
