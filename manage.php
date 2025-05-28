<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("settings.php");
include("header.inc");
include("nav.inc");

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<?php if (isset($_SESSION['username'])): ?>
    <a href="register.php" class="btn">Register HR Manager</a>
<?php endif; ?>


<main class="apply-container">
    <h2>Manage EOIs</h2>

    <form method="post" action="logout.php" style="text-align:right; margin-bottom:20px;">
        <input type="submit" class="btn" value="Logout">
    </form>

    <form method="post" action="manage.php">
        <fieldset>
            <legend>Manage EOIs</legend>

            <p><input type="submit" class="btn" name="action" value="List All EOIs"></p>

            <p>
                <label for="job_ref">Job Reference:</label>
                <input type="text" id="job_ref" name="job_ref">
                <input type="submit" class="btn" name="action" value="Search By Job Reference">
                <input type="submit" class="btn" name="action" value="Delete By Job Reference">
            </p>

            <p>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name">

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name">

                <input type="submit" class="btn" name="action" value="Search By Applicant Name">
            </p>

            <p>
                <label for="eoi_number">EOInumber:</label>
                <input type="number" id="eoi_number" name="eoi_number" min="1">

                <label for="status">New Status:</label>
                <select id="status" name="status">
                    <option value="New">New</option>
                    <option value="Current">Current</option>
                    <option value="Final">Final</option>
                </select>
                <input type="submit" class="btn" name="action" value="Change Status">
            </p>
        </fieldset>
    </form>

    <?php
    function displayResults($result)
    {
        echo "<div class='apply-container'>";
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>EOInumber</th><th>Job Ref</th><th>First</th><th>Last</th><th>Status</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['EOInumber']) . "</td>";
                echo "<td>" . htmlspecialchars($row['job_reference']) . "</td>";
                echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-results'>No EOIs found.</p>";
        }
        echo "</div>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
        $action = $_POST["action"];

        switch ($action) {
            case "List All EOIs":
                $sql = "SELECT * FROM eoi ORDER BY EOInumber ASC";
                $result = mysqli_query($conn, $sql);
                if ($result) displayResults($result);
                else echo "<p>Error: " . mysqli_error($conn) . "</p>";
                break;

            case "Search By Job Reference":
                $job_ref = mysqli_real_escape_string($conn, $_POST["job_ref"]);
                if (empty($job_ref)) {
                    echo "<p>Please enter a job reference number to search.</p>";
                    break;
                }
                $sql = "SELECT * FROM eoi WHERE job_reference = '$job_ref'";
                $result = mysqli_query($conn, $sql);
                if ($result) displayResults($result);
                else echo "<p>Error: " . mysqli_error($conn) . "</p>";
                break;

            case "Delete By Job Reference":
                $job_ref = mysqli_real_escape_string($conn, $_POST["job_ref"]);
                if (empty($job_ref)) {
                    echo "<p>Please enter a job reference number to delete.</p>";
                    break;
                }
                $sql = "DELETE FROM eoi WHERE job_reference = '$job_ref'";
                $result = mysqli_query($conn, $sql);
                echo $result ? "<p>EOIs with job reference '$job_ref' have been deleted.</p>" :
                    "<p>Error: " . mysqli_error($conn) . "</p>";
                break;

            case "Search By Applicant Name":
                $first = mysqli_real_escape_string($conn, $_POST["first_name"]);
                $last = mysqli_real_escape_string($conn, $_POST["last_name"]);

                $conditions = [];
                if (!empty($first)) $conditions[] = "first_name LIKE '%$first%'";
                if (!empty($last))  $conditions[] = "last_name LIKE '%$last%'";

                if (empty($conditions)) {
                    echo "<p>Please enter at least a first or last name to search.</p>";
                    break;
                }

                $where = implode(" AND ", $conditions);
                $sql = "SELECT * FROM eoi WHERE $where";
                $result = mysqli_query($conn, $sql);
                if ($result) displayResults($result);
                else echo "<p>Error: " . mysqli_error($conn) . "</p>";
                break;

            case "Change Status":
                $eoi_num = intval($_POST["eoi_number"]);
                $status = mysqli_real_escape_string($conn, $_POST["status"]);

                if ($eoi_num <= 0) {
                    echo "<p>Please enter a valid EOInumber.</p>";
                    break;
                }

                if (!in_array($status, ["New", "Current", "Final"])) {
                    echo "<p>Invalid status value.</p>";
                    break;
                }

                $sql = "UPDATE eoi SET status = '$status' WHERE EOInumber = $eoi_num";
                $result = mysqli_query($conn, $sql);
                echo ($result && mysqli_affected_rows($conn) > 0)
                    ? "<p>EOInumber $eoi_num status updated to '$status'.</p>"
                    : "<p>No matching record or update failed.</p>";
                break;

            default:
                echo "<p>Invalid action.</p>";
        }
    }

    mysqli_close($conn);
    ?>
</main>

<?php include("footer.inc"); ?>
