<!DOCTYPE html>
<html>
<head>
  <title>Company Names</title>
</head>
<body>
  <form action="process.php" method="post">
    <label for="company">Select a company:</label>
    <select name="company" id="company">
      <?php
        include 'connection.php';

        // Fetch company names from the database
        $sql = "SELECT name FROM companies";
        $result = $conn->query($sql);

        // Display company names as options in the select input
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
          }
        }

        // Close the database connection
        $conn->close();
      ?>
    </select>
    <br><br>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
