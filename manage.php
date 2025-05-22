

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Manage EOIs</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        fieldset { width: 90%; }
        input[type=text], input[type=number], select { margin-right: 10px; }
    </style>
</head>
<body>
<h1>Manage EOIs</h1>

<form method="post" action="manage.php">
  <fieldset>
    <legend>Manage EOIs</legend>

    <p><input type="submit" name="action" value="List All EOIs"></p>

    <p>
      <label for="job_ref">Job Reference:</label>
      <input type="text" id="job_ref" name="job_ref">
      <input type="submit" name="action" value="Search By Job Reference">
      <input type="submit" name="action" value="Delete By Job Reference">
    </p>

    <p>
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name">

      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name">

      <input type="submit" name="action" value="Search By Applicant Name">
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
      <input type="submit" name="action" value="Change Status">
    </p>
  </fieldset>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    switch ($action) {
        case "List All EOIs":
            $sql = "SELECT * FROM eoi ORDER BY EOInumber ASC";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                displayResults($result);
            } else {
                echo "<p>Error: " . mysqli_error($conn) . "</p>";
            }
            break;

        case "Search By Job Reference":
            $job_ref = mysqli_real_escape_string($conn, $_POST["job_ref"]);
            if (empty($job_ref)) {
                echo "<p>Please enter a job reference number to search.</p>";
                break;
            }
            $sql = "SELECT * FROM eoi WHERE job_reference = '$job_ref' ORDER BY EOInumber ASC";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                displayResults($result);
            } else {
                echo "<p>Error: " . mysqli_error($conn) . "</p>";
            }
            break;

        case "Search By Applicant Name":
            $first = mysqli_real_escape_string($conn, $_POST["first_name"]);
            $last = mysqli_real_escape_string($conn, $_POST["last_name"]);
            $conditions = [];

            if (!empty($first)) {
                $conditions[] = "first_name LIKE '%$first%'";
            }
            if (!empty($last)) {
                $conditions[] = "last_name LIKE '%$last%'";
            }

            if (count($conditions) === 0) {
                echo "<p>Please enter at least a first name or last name to search.</p>";
                break;
            }

            $where = implode(" AND ", $conditions);
            $sql = "SELECT * FROM eoi WHERE $where ORDER BY EOInumber ASC";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                displayResults($result);
            } else {
                echo "<p>Error: " . mysqli_error($conn) . "</p>";
            }
            break;

        case "Delete By Job Reference":
            $job_ref = mysqli_real_escape_string($conn, $_POST["job_ref"]);
            if (empty($job_ref)) {
                echo "<p>Please enter a job reference number to delete.</p>";
                break;
            }
            $sql = "DELETE FROM eoi WHERE job_reference = '$job_ref'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<p>All EOIs with job reference '$job_ref' deleted successfully.</p>";
            } else {
                echo "<p>Error deleting EOIs: " . mysqli_error($conn) . "</p>";
            }
            break;

        case "Change Status":
            $eoi_num = intval($_POST["eoi_number"]);
            $status = mysqli_real_escape_string($conn, $_POST["status"]);

            if ($eoi_num <= 0) {
                echo "<p>Please enter a valid EOInumber.</p>";
                break;
            }

            if (!in_array($status, ['New', 'Current', 'Final'])) {
                echo "<p>Invalid status selected.</p>";
                break;
            }

            $sql = "UPDATE eoi SET status = '$status' WHERE EOInumber = $eoi_num";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo "<p>Status of EOInumber $eoi_num changed to $status successfully.</p>";
                } else {
                    echo "<p>No EOI found with EOInumber $eoi_num.</p>";
                }
            } else {
                echo "<p>Error updating status: " . mysqli_error($conn) . "</p>";
            }
            break;

        default:
            echo "<p>Unknown action.</p>";
    }
}

mysqli_close($conn);

function displayResults($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>EOInumber</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Status</th></tr>";
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
        echo "<p>No EOIs found.</p>";
    }
}
?>

