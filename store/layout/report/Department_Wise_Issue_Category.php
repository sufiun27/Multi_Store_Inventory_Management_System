<!--### Header Part ##################################################-->
<?php
include '../template/header.php';

include './db/db.php';
include 'Department_Wise_Issue_Class_Category.php';
?>
<style>
    td{font-size: 12px;}
</style>
<!--#####################################################-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Add 'show' class to the element with ID "collapseLayouts2"
    $(document).ready(function() {
        $("#collapsePages_report").addClass("show");
        $("#pagesCollapseError").addClass("show");
        $("#Department_Wise_Issue_Category").addClass("active bg-success");
    });
</script>



<!--#####################################################-->
<div id="layoutSidenav_content">
    <main >
        <div class="container-fluid px-4">
            <!--body#####################################################-->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //////////////////////////////////////////

                //////////////////////////////////////////
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $item_name = $_POST['item_name'];
                $department = $_POST['department'];
                $obj= new DateWiseReceive();
                if( !empty($start_date) and !empty($end_date)){
                    $reportData=$obj->DateWiseNameReceiveReport($item_name,$department,$start_date,$end_date);
                }elseif (empty($start_date) and empty($end_date)){
                    $reportData=$obj->ReceiveReport($department,$item_name);
                   // print_r($reportData);
                }
            }
            ?>
            <!-------------------------------------------------->
            <?php
            //print_r($reportData);
            require 'vendor/autoload.php';

            if (isset($reportData)) {


                // Export the report to an Excel file
                $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $rowNumber = 1;

                // Set headers in the Excel file
                $headers = ['Department', 'Category', 'Item', 'Quantity', 'Sys Price', 'Avg Price', 'Total Price', 'Percentage'];
                $columnNumber = 1;
                foreach ($headers as $header) {
                    $sheet->setCellValueByColumnAndRow($columnNumber, $rowNumber, $header);
                    $columnNumber++;
                }

                // Set data in the Excel file
                $rowNumber = 2;
                foreach ($reportData as $row) {
                    $columnNumber = 1;
                    foreach ($row as $cellData) {
                        $sheet->setCellValueByColumnAndRow($columnNumber, $rowNumber, $cellData);
                        $columnNumber++;
                    }
                    $rowNumber++;
                }

                // Save the Excel file
                $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $filename = 'Category_Wise_Department_Issue.xlsx';
                $writer->save($filename);
            }
            ?>
            <!----------------------------------------------------------->

            <b><span class="text-success">Department Wise Issue ( Category ) Cost</span></b>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <label for="start_date">Start Date:</label>
                <input type="datetime-local" name="start_date" >

                <label for="end_date">End Date:</label>
                <input type="datetime-local" name="end_date" >

                <label for="department">Select a Department:</label>
                <select name="department" id="department">
                    <?php

                    $obj_dep= new DateWiseReceive();
                    // Retrieve department names from the database
                    $Department=$obj_dep->DepartmentsName();
                    ?>
                    <option value="">  </option>
                    <?php foreach ($Department as $row): ?>
                    <option value="<?php echo $row["d_name"]; ?>"> <?php echo $row["d_name"]; ?> </option>
                    <?php endforeach; ?>
                </select>

                <label for="item_name">Category Name:</label>
                <select name="item_name" id="item_name">
                    <?php
                    $Item=$obj_dep->ItemsName();
                    ?>
                    <option value="">  </option>
                    <?php foreach ($Item as $row): ?>
                        <option value="<?php echo $row["c_name"]; ?>"> <?php echo $row["c_name"]; ?> </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Generate Report">
                <span><a href="<?php echo $filename; ?>"><i class="fas fa-file-export"></i> Export</a></span>

            </form>

<!-------------------------------------------------------------------------->

<!------------------------------------------------------------------------>

<!----------------------------------------------------------------------------------->
            <style>
                #customers {
                    font-family: Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 2px;
                }

                #customers tr:nth-child(even){background-color: #f2f2f2;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {
                    padding-top: 2px;
                    padding-bottom: 2px;
                    text-align: left;
                    background-color: #04AA6D;
                    color: white;
                }
            </style>
<!----------------------------------------------------------------------------------->
            <?php if(isset($reportData)): ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Department Wise (Category) Cost
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Department</th>
                            <th>Category</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Sys Price</th>
                            <th>Avg Price</th>
                            <th>Total Price</th>
                            <th>Percentage</th>
                        </tr>
                        </thead>>

                    <?php foreach ($reportData as $row): ?>
                        <tr>
                            <td><?php echo $row['d_name']; ?></td>
                            <td><?php echo $row['c_name']; ?></td>
                            <td><?php echo $row['i_name']; ?></td>

                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['system_price']; ?></td>
                            <td><?php echo $row['avg_price']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
                            <td><?php echo $row['percentage']; ?></td>


                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php endif; ?>




            <!--#####################################################-->
        </div>
    </main>


<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->