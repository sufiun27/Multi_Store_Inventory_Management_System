<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "hlfs");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['searchInput'])) {
    $searchInput = $_POST['searchInput'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM department WHERE d_name LIKE '%$searchInput%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Display the options
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<p class="option">' . $row['d_name'] . '</p>';
            //echo '<p class="option">' . $row['d_full_name'] . '</p>';
            //$depname=$row['d_full_name'];
            
        }
    } else {
        echo "No options found.";
    }

    // Close database connection
    mysqli_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form action="submit_form.php" method="POST">
        <input type="text" id="searchInput" name="searchInput" placeholder="Type here...">
        <div id="feedback"></div>
        <div id="searchResults"></div>
        <button type="submit">Submit</button>
       
    </form>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                var searchInput = $(this).val();
                $('#feedback').text(searchInput);

                if (searchInput.length > 0) {
                    $.ajax({
                        url: '<?php echo $_SERVER["PHP_SELF"]; ?>',
                        type: 'POST',
                        data: { searchInput: searchInput },
                        success: function(response) {
                            $('#searchResults').html(response);
                        }
                    });
                } else {
                    $('#searchResults').empty();
                }
            });

            $('#searchResults').on('click', '.option', function() {
                var selectedOption = $(this).text();
                $('#searchInput').val(selectedOption);
                $('#searchResults').empty();
            });
        });
    </script>
</body>
</html>
