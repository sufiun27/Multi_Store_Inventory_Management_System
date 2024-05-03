<form>
  <input type="text" id="searchInput" onkeyup="getData()" placeholder="Search">
</form>
<div id="results"></div>




<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hlfs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data based on search query
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT d_name FROM department WHERE d_name LIKE '%$query%";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>".$row['d_name']."</p>";
        }
    } else {
        echo "No results found.";
    }
}

$conn->close();
?>











<script>
function getData() {
    var input = document.getElementById('searchInput').value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('results').innerHTML = this.responseText;
        }
    };
    xmlhttp.open('GET', 'your_php_script.php?query=' + input, true);
    xmlhttp.send();
}
</script>
