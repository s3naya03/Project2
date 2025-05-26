<?php include("header.inc"); ?>
<?php include("nav.inc"); ?>
<?php include("settings.php"); ?>

<main class="container">
  <h2>Available Jobs</h2>

  <?php
  $conn = mysqli_connect($host, $user, $password, $database);
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT * FROM jobs";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<article class='job-card'>";
          echo "<h3>{$row['title']}</h3>";
          echo "<p><strong>Reference:</strong> {$row['reference']}</p>";
          echo "<p><strong>Company:</strong> {$row['company']}</p>";
          echo "<p><strong>Location:</strong> {$row['location']}</p>";
          echo "<p><strong>Salary:</strong> {$row['salary']}</p>";
          echo "<p><strong>Reports To:</strong> {$row['reports_to']}</p>";
          echo "<p>{$row['overview']}</p>";
          echo "<h4>Responsibilities</h4><ul>";

          foreach (explode("\n", $row['responsibilities']) as $item) {
              echo "<li>" . htmlspecialchars($item) . "</li>";
          }

          echo "</ul><h4>Required</h4><ul>";

          foreach (explode("\n", $row['requirements']) as $item) {
              echo "<li>" . htmlspecialchars($item) . "</li>";
          }

          echo "</ul><h4>Preferred</h4><ul>";

          foreach (explode("\n", $row['preferred']) as $item) {
              echo "<li>" . htmlspecialchars($item) . "</li>";
          }

          echo "</ul><a href='apply.php?ref={$row['reference']}' class='btn'>Apply</a>";
          echo "</article>";
      }
  } else {
      echo "<p>No jobs available at this time.</p>";
  }

  mysqli_close($conn);
  ?>
</main>

<?php include("footer.inc"); ?>
