<?php
include("settings.php");

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Database connection successful!";
}

mysqli_close($conn);
?>
