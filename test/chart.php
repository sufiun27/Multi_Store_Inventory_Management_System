<!DOCTYPE html>
<html>
<head>
    <title>Item Balance Chart</title>
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div style="width: 80%; margin: 0 auto;">
    <canvas id="itemBalanceChart"></canvas>
</div>

<?php
function runsql($sql) {
    include '../hostingDBinfo.php';
    $conn = new mysqli($servername, $username, $password, 'hlfs');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($sql);

    if ($result === false) {
        die("Error in SQL query: " . $conn->error);
    }

    $data = array(); // Create an array to store the data

    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Add each row to the data array
    }

    $conn->close();
    return $data;
}

// Fetch item names and balances
$sql = "SELECT i_name, qty_balance FROM balance";
$data = runsql($sql);

// Separate the data into two arrays for item names and item balances
$itemNames = array();
$itemBalances = array();
foreach ($data as $row) {
    $itemNames[] = $row['i_name'];
    $itemBalances[] = $row['qty_balance'];
}
?>

<script>
    // Create a bar chart
    var ctx = document.getElementById('itemBalanceChart').getContext('2d');
    var itemBalanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($itemNames); ?>,
            datasets: [{
                label: 'Item Balance',
                data: <?php echo json_encode($itemBalances); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Set your desired bar color
                borderColor: 'rgba(75, 192, 192, 1)', // Set your desired border color
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
</script>
</body>
</html>
