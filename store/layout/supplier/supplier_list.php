<?php
include '../template/header.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#collapseLayouts0").addClass("show");
        $("#collapseLayouts0_list").addClass("active bg-success");
    });
</script>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class=".bg-light .bg-gradient  p-3">
                <?php
                if (isset($_GET['value'])) {
                    $message = $_GET['value'];
                    echo '<div id="message" class="bg-warning">' . $message . '</div>';
                    echo '<script>
                        setTimeout(function() {
                            document.getElementById("message").style.display = "none";
                        }, 3000);
                    </script>';
                }
                ?>

                <h5 class="mt-5 mb-4 text-light">Supplier list</h5>

                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Replace with your SQL Server connection information
                $serverName = "BDAPPSS02V\\SQLEXPRESS";
                $db = $_SESSION['company'];

                $connectionInfo = array(
                    "Database" => $db,
                    "Uid" => "sa",
                    "PWD" => "sa@123"
                );

                try {
                    $conn = new PDO("sqlsrv:Server=$serverName;Database=$db", "sa", "sa@123");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $section = $_SESSION['section'];
                    $site= $_SESSION['site'] ;
                    $sql = "SELECT * FROM supplier  ORDER BY s_add_datetime DESC";
                    $query = $conn->query($sql);

                    if ($query) {
                        echo '<table class="table bg-light">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contract</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';

                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>
                            <td>' . $row["s_name"] . '</td>
                            <td>' . $row["s_phone"] . '</td>
                            <td>' . $row["s_email"] . '</td>
                            <td>' . $row["s_address"] . '</td>';

                            if ($row["s_active"] == 1) {
                                echo '<td class="text-success">
                                <i class="fa-solid fa-check"></i>
                                <a href="supplier_deactive.php?id=' . $row["s_id"] . '" class="btn btn-warning btn-sm"><i class="fa-solid fa-xmark"></i></a>
                            </td>';
                            } else {
                                echo '<td class="text-danger">
                                <i class="fa-solid fa-xmark"></i>
                                <a href="supplier_active.php?id=' . $row["s_id"] . '" class="btn btn-success btn-sm"><i class="fa-solid fa-check"></i></a>
                            </td>';
                            }

                            echo '<td>
                            <a href="supplier_edit.php?id=' . $row["s_id"] . '" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="supplier_delete.php?id=' . $row["s_id"] . '" class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></a>
                        </td>
                        </tr>';
                        }

                        echo '</tbody></table>';
                    } else {
                        echo "No options found.";
                    }

                    $conn = null;
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                ?>
                <div id="valueDiv" class="bg-success h3"></div>
                <script>
                    const urlParams = new URLSearchParams(window.location.search);
                    const value = urlParams.get('value');
                    document.getElementById('valueDiv').innerText = value;
                    setTimeout(function () {
                        document.getElementById('valueDiv').innerText = '';
                    }, 3000);
                </script>
                <?php
                include '../template/footer.php';
                ?>
            </div>
        </div>
    </main>
</div>
