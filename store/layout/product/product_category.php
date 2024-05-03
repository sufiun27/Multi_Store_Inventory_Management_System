<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts1").addClass("show");
        $("#collapseLayouts1_category").addClass("active bg-success");
    });
</script>
<style>
    td, th {
        font-size: 12px;
        font-weight: bold;
    }
</style>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div id="message">
                <?php
                if (isset($_GET['value'])) {
                    $message = $_GET['value'];
                    echo $message;
                }
                ?>
            </div>
            <script>
                setTimeout(function() {
                    var messageElement = document.getElementById('message');
                    if (messageElement) {
                        messageElement.style.display = 'none';
                    }
                }, 3000);
            </script>

            <?php
            include '../layoutdbconnection.php';
            $section = $_SESSION['section'];
            $sql = "SELECT c.c_active, c.c_id, c.c_name, COALESCE(i.total_item, 0) as total_item
                    FROM category_item c 
                    LEFT JOIN (
                        SELECT c_id, COUNT(i_id) as total_item FROM item GROUP BY c_id
                    ) i
                    ON c.c_id = i.c_id
                    Where c.section = '$section'
                    ORDER BY c.c_name ASC
                    ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Total Item</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>
                            <td>' . $row["c_name"] . '</td>
                            <td>' . $row["total_item"] . '</td>';

                            if ($row["c_active"] == 1) {
                                echo '<td class="text-success">Active
                                    <a href="product_category_deactive.php?id=' . $row["c_id"] . '" class="btn btn-warning btn-xs">X</a>
                                    </td>';
                            } else {
                                echo '<td class="text-danger">Deactive
                                    <a href="product_category_active.php?id=' . $row["c_id"] . '" class="btn btn-success btn-xs">Ok</a>
                                    </td>';
                            }

                            echo '<td>
                            <a href="product_category_edit.php?id=' . $row["c_id"] . '" class="btn btn-primary btn-xs">Edit</a>
                            <a href="product_category_delete.php?id=' . $row["c_id"] . '" class="btn btn-danger btn-xs">X</a>
                            </td>
                            </tr>';
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
       
    </main>


<?php
include '../template/footer.php';
?>
