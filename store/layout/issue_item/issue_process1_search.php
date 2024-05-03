<?php
$serverName = "BDAPPSS02V\SQLEXPRESS";
$database = "hlfs";
$username = "sa";
$password = "sa@123";


try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT i_name FROM item WHERE i_name LIKE :search";
    $stmt = $conn->prepare($query);
    $stmt->execute(array(':search' => '%' . $search . '%'));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo '<select name="item" id="item" onclick="minimizeMenu()">';
        foreach ($result as $row) {
            echo '<option value="' . $row['i_name'] . '">' . $row['i_name'] . '</option>';
        }
        echo '</select>';
    } else {
        echo "<p>No results found.</p>";
    }
    
}
?>