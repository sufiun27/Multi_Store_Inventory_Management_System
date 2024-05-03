<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapseLayouts").addClass("show");
        $("#collapseLayouts_list").addClass("active bg-success");
    });
</script>
<!--#####################################################-->
<div id="layoutSidenav_content">
    <!--exit add employee portion -->
    <!--fetch employee record-->
    <?php

    include '../layoutdbconnection.php'; 
    $empid = $_GET['id'];
    $sql = "SELECT * FROM employee e INNER JOIN department d ON e.d_id = d.d_id where e.e_id = $empid";
    $result = $conn->query($sql);

    // Display employee information in a form for editing

    $row = $result->fetch(PDO::FETCH_ASSOC);
    ?>
    <!---------------------------->
    <main>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-secondary text-white p-3">
                        <!-- update employee information //////////////////////////////////////////////////////////////////////-->
                        <h2 class="mt-5 mb-4">Update Employee Information</h2>
                        <form action="adduser_list_edit_process.php" method="POST">
                            <input type="hidden" name="e_id" value="<?php echo $empid; ?>" required>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['e_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?php echo $row['e_com_id']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="<?php echo $row['e_designation']; ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="mn">Designation</label>
                                <select class="form-control" id="mn" name="mn" required>
                                    <option value="Management">Management</option>
                                    <option value="Non-Management">Non-Management</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control form-control-sm" id="department" name="department">
                                    <option value="" selected disabled>Choose a department</option>
                                    <?php
                                    $selectedDepartment = $row['d_name'];
                                    // Fetch department names from the database
                                    $sql = "SELECT d_id, d_name FROM department";
                                    $result = $conn->query($sql);
                                    // Display department names as options in the select input
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $row['d_id'] . "'";
                                        if ($row['d_name'] == $selectedDepartment) {
                                            echo " selected";
                                        }
                                        echo ">" . $row['d_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <!-- Display success or error message -->
                        <?php
                        if (isset($_GET['value'])) {
                            $message = $_GET['value'] == "Update successfully" ? "bg-success" : "bg-danger";
                            echo "<h4 class=\"$message p-3 m-2 text-center\">" . $_GET['value'] . "</h4>";
                        } else {
                            echo "Update employee information";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--exit add employee portion -->
    <!--###### Footer Part ###############################################-->
    <?php
    include '../template/footer.php';
    ?>
    <!--#####################################################-->
</div>
