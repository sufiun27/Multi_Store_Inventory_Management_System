


<?php
session_start();
function runsqlchart($sql) {
    include '../../../hostingDBinfo.php';

    $db=$_SESSION['company'];
    
    try {
        $conn = new PDO("sqlsrv:Server=$servername;Database=$db", $username, $password);

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query($sql);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array

        $conn = null;
        return $data;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Fetch item names and balances
$sql = "SELECT i_name, qty_balance FROM balance";
$data = runsqlchart($sql);

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
