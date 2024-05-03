<?php
include 'authorization.php';
?>

<?php
class UserInformation extends Dbh {
    public function information() {
        $pdo = $this->connect();
        $query = "SELECT [db_name] FROM [dbo].[dbinfo]";

        try {
            $stmt = $pdo->query($query);
            $row = $stmt->fetchAll();
            return $row;
        } catch (PDOException $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    public function roleInformation() {
        $pdo = $this->connect();
        $query = "SELECT [role] FROM [dbo].[role]";
        try {
            $stmt = $pdo->query($query);
            $row = $stmt->fetchAll();
            return $row;
        } catch (PDOException $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());

        }
    }

    public function usersRecords() {
        $pdo = $this->connect();
        $query = "SELECT * FROM [dbo].[user]";
        try {
            $stmt = $pdo->query($query);
            $row = $stmt->fetchAll();
            return $row;
        } catch (PDOException $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }
}


///__user information__///

?>
<?php
$userinfo=new UserInformation();
$db_info=$userinfo->information();
//__role information__///
$roleinfo=$userinfo->roleInformation();
//__users records__///
$users=$userinfo->usersRecords();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        /* Add nth-child styling for the table rows */
        /* Alternate background colors for even and odd rows */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        a{
            color: black;
        }
    </style>
</head>
<body style="background-color: rgba(255,182,193,0.65)">

<div class="container" style="background-color: pink">

<div class="row m-2">
    <div class="col-10"></div>
    <div class="col-2 text-right">
        <a class="btn btn-danger" href="http://<?php echo $_SESSION['base_url'];?>/logout/logout.php">Logout</a>
    </div>
</div>

<div class="row ">
    <div class="col-1 btn btn-warning"><a href="fashion.php">Fashion</a></div>
    <div class="col-1 btn btn-success"><a href="brands.php">Brands</a></div>
    <div class="col-1 btn btn-warning"><a href="intimate.php">Intimate</a></div>
    <div class="col-1 btn btn-success"><a href="diva.php">Diva</a></div>
    <div class="col-1 btn btn-warning"><a href="legend.php">Legend</a></div>
    <div class="col-1 btn btn-success"><a href="heritage.php">Heritage</a></div>
    <div class="col-1 btn btn-info"><a href="demo.php">Demo</a></div>
</div>
 


    <div class="row">
        <div class="col-6" style="background-color: rgba(221,160,221,0.73)">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form onsubmit="return validateForm()" method="post" action="store.php">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Enter password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" required>
                            </div>
                            <div class="form-group">
                                <label for="userRole">User Role</label>
                                <select name="userRole" class="form-control" id="userRole" required>
                                    <?php
                                    foreach ($roleinfo as $row) {
                                        echo '<option value="'.$row['role'].'">'.$row['role'].'</option>';
                                    }
                                    ?>

                                    <!-- Add more roles as needed -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <select name="location" class="form-control" id="location" required>

                                   <?php
                                   foreach ($db_info as $row) {
                                       echo'<option value="'.$row['db_name'].'">'.$row['db_name'].'</option>';
                                   }
                                   ?>

                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <?php
        // Assuming you have the $users array with user information.
        // For demonstration purposes, let's assume $users is an array of associative arrays containing user data.

        // Pagination settings
        $recordsPerPage = 20;
        $totalRecords = count($users);
        $totalPages = ceil($totalRecords / $recordsPerPage);

        // Get the current page from the query parameter
        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $current_page = max(1, min($current_page, $totalPages));

        // Calculate the starting index and ending index of the records to display on the current page
        $startIndex = ($current_page - 1) * $recordsPerPage;
        $endIndex = min($startIndex + $recordsPerPage - 1, $totalRecords - 1);

        // Slice the $users array to get the records for the current page
        $usersOnCurrentPage = array_slice($users, $startIndex, $recordsPerPage);
        ?>

        <div class="col-6">
            <div class="col-12">
                <div class="container mt-5">
                    <h4>User Information</h4>
                    <table class="table table-bordered table-sm bg-light">
                        <thead>
                        <tr class="bg-success">
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Section</th>
                            <th>Location</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usersOnCurrentPage as $row): ?>
                            <tr>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['section']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                            <li class="page-item <?php echo ($page === $current_page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>

    </div>

</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        if (password !== confirmPassword) {
            alert("Password and Confirm Password do not match!");
            return false; // Prevent form submission
        }
        if (password.length < 8) {
            alert("Password must be at least 8 characters long!");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
</body>
</html>
