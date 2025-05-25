<?php
// process_eoi.php

include("settings.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize function
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Sanitize and assign all fields
$job_ref      = clean_input($_POST["job_ref"]);
$first_name   = clean_input($_POST["first_name"]);
$last_name    = clean_input($_POST["last_name"]);
$dob          = clean_input($_POST["dob"]);
$gender       = clean_input($_POST["gender"]);
$street       = clean_input($_POST["street_address"]);
$suburb       = clean_input($_POST["suburb"]);
$state        = clean_input($_POST["state"]);
$postcode     = clean_input($_POST["postcode"]);
$email        = clean_input($_POST["email"]);
$phone        = clean_input($_POST["phone"]);
$skills       = isset($_POST["skills"]) ? $_POST["skills"] : [];
$other_skills = clean_input($_POST["other_skills"]);

// Server-side validation
$errors = [];

if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref)) $errors[] = "Invalid job reference.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) $errors[] = "Invalid first name.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) $errors[] = "Invalid last name.";
if (!in_array($state, ["VIC", "NSW", "QLD", "NT", "WA", "SA", "TAS", "ACT"])) $errors[] = "Invalid state.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Invalid postcode.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Invalid phone number.";

// Simple postcode-state match (example: VIC should start with 3)
$state_prefix = [
    "VIC" => ["3", "8"],
    "NSW" => ["1", "2"],
    "QLD" => ["4", "9"],
    "NT"  => ["0"],
    "WA"  => ["6"],
    "SA"  => ["5"],
    "TAS" => ["7"],
    "ACT" => ["0"]
];
if (!in_array(substr($postcode, 0, 1), $state_prefix[$state])) {
    $errors[] = "Postcode does not match selected state.";
}

// Show errors
if (count($errors) > 0) {
    echo "<h2>Submission Error</h2><ul>";
    foreach ($errors as $error) echo "<li>$error</li>";
    echo "</ul><p><a href='apply.php'>Go back</a></p>";
    exit();
}

// Skills (up to 4)
$skill1 = isset($skills[0]) ? $skills[0] : "";
$skill2 = isset($skills[1]) ? $skills[1] : "";
$skill3 = isset($skills[2]) ? $skills[2] : "";
$skill4 = isset($skills[3]) ? $skills[3] : "";

// Create table if not exists
$table_sql = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    job_reference VARCHAR(5),
    first_name VARCHAR(20),
    last_name VARCHAR(20),
    dob DATE,
    gender VARCHAR(10),
    street_address VARCHAR(40),
    suburb VARCHAR(40),
    state VARCHAR(3),
    postcode VARCHAR(4),
    email VARCHAR(100),
    phone VARCHAR(20),
    skill1 VARCHAR(50),
    skill2 VARCHAR(50),
    skill3 VARCHAR(50),
    skill4 VARCHAR(50),
    other_skills TEXT,
    status VARCHAR(10) DEFAULT 'New'
)";
mysqli_query($conn, $table_sql);

// Insert EOI
$insert_sql = "INSERT INTO eoi (
    job_reference, first_name, last_name, dob, gender, street_address,
    suburb, state, postcode, email, phone,
    skill1, skill2, skill3, skill4, other_skills
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $insert_sql);
mysqli_stmt_bind_param($stmt, "ssssssssssssssss", 
    $job_ref, $first_name, $last_name, $dob, $gender, $street,
    $suburb, $state, $postcode, $email, $phone,
    $skill1, $skill2, $skill3, $skill4, $other_skills);

if (mysqli_stmt_execute($stmt)) {
    $eoi_number = mysqli_insert_id($conn);
    echo "<h2>Application Received!</h2>";
    echo "<p>Thank you, <strong>$first_name</strong>. Your EOInumber is <strong>$eoi_number</strong>.</p>";
} else {
    echo "<p>Database error. Please try again later.</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
