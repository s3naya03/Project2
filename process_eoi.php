<?php
include("header.inc");
include("nav.inc");


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

include("settings.php");

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("<main class='container error-box'><p>Connection failed: " . mysqli_connect_error() . "</p></main>");
}

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

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

$errors = [];

if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref)) $errors[] = "Invalid job reference.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) $errors[] = "Invalid first name.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) $errors[] = "Invalid last name.";
if (!in_array($state, ["VIC", "NSW", "QLD", "NT", "WA", "SA", "TAS", "ACT"])) $errors[] = "Invalid state.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Invalid postcode.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Invalid phone number.";

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

if (in_array("Other", $skills) && empty($other_skills)) {
    $errors[] = "You selected 'Other skills' but did not specify them.";
}

echo "<main class='job-details-container'>";
if (count($errors) > 0) {
    echo "<div class='error-box'>";
    echo "<h2>Submission Error</h2><ul>";
    foreach ($errors as $error) echo "<li>$error</li>";
    echo "</ul><p><a href='apply.php' class='btn'>Go back</a></p>";
    echo "</div>";
    echo "</main>";
    include("footer.inc");
    exit();
}

$skill1 = $skills[0] ?? "";
$skill2 = $skills[1] ?? "";
$skill3 = $skills[2] ?? "";
$skill4 = $skills[3] ?? "";

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
    echo "<div class='confirmation-box'>";
    echo "<h2>Application Received!</h2>";
    echo "<p>Thank you, <strong>$first_name</strong>. Your EOInumber is <strong>$eoi_number</strong>.</p>";
    echo "<a href='jobs.php' class='btn'>Return to Jobs</a>";
    echo "</div>";
} else {
    echo "<div class='error-box'><p>Database error. Please try again later.</p></div>";
}
echo "</main>";

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
</main>
