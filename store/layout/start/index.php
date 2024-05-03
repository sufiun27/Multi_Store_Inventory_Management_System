<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!--### Header Part ##################################################-->
<?php
include '../template/header.php';
?>
<!--#####################################################-->

<!--#####page redirect###########################################################################################################################################################-->
<?php



if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // Redirect the user to the login page or display an error message
    header("Location: ../../logout/logout.php");
    exit();
  }
  
?>
<!--DB ################################################################################################################################################################-->

<?php
function runsql($sql) {
    include '../../../hostingDBinfo.php';
    $db = $_SESSION['company'];

    try {
        $conn = new PDO("sqlsrv:Server=$servername;Database=$db", $username, $password);

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->query($sql);

        // Fetch and return the result
        $value = $stmt->fetchColumn();
        $conn = null;
        return $value;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

$sql = "SELECT COUNT(e_name) FROM employee";
$value = runsql($sql);
echo "total employee is: ".$value;
?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><marquee> 
                            Established in 1992, we have been providing quality fashion lingerie and swimwear to major global retailers for over two decades.
                            We take pride in our excellence in offering reliable services from product design to manufacturing and in achieving the best quality 
                            at a competitive price. Today, Hop Lun employs more than 23,000 people. We have 12 manufacturing 
                            facilities located across 3 countries together with a centralized pre-production office and logistics centre.
                            </marquee></li>
                        </ol>

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Uncomplete Receive Items:</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            <?php
                                            $sql = "SELECT COUNT(ip.p_id)
                                FROM item_purchase ip
                                INNER JOIN (
                                    SELECT p_id, SUM(p_recive_qty) AS total_received_qty
                                    FROM tem_purchase_recive
                                    GROUP BY p_id
                                ) AS tpr ON ip.p_id = tpr.p_id
                                WHERE ip.p_req_qty > tpr.total_received_qty";
                                            $value = runsql($sql);
                                            echo $value[0][0]; 
                                            /////////////////
                                           
                                            
                                            ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Total Unreceived Items:</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            <?php
                                            $sql = "SELECT COUNT(ip.p_id)
                                FROM item_purchase ip                                
                                WHERE ip.p_request = 1 AND ip.p_recive = 0";
                                            $value = runsql($sql);
                                            echo $value[0][0]; ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Stock Out Items</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            <?php
                                            $sql = "SELECT COUNT(i.i_id)
                                                       from item i 
                                                Left JOIN balance b ON i.i_id = b.i_id             
                                                       WHERE b.qty_balance < i.stock_out_reminder_qty";
                                            $value = runsql($sql);
                                            //$Stock_out_qty= $value[0][0];
                                            print_r($value); ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Total Unaccept Item : </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            <?php
                                            $sql = "SELECT COUNT(ip.p_id)
                                FROM item_purchase ip                                
                                WHERE ip.p_request = 0 ";
                                            $value = runsql($sql);
                                            echo $value[0][0]; ?>
                                        </a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
<!--                            <div class="col-xl-6">-->
<!--                                <div class="card mb-4">-->
<!--                                    <div class="card-header">-->
<!--                                        <i class="fas fa-chart-area me-1"></i>-->
<!--                                        Area Chart Example-->
<!--                                    </div>-->
<!--                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <!-- <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Balance Chart
                                    </div>
                                    <div class="card-body">

                                        <div style="width: 80%; margin: 0 auto;">
                                            <canvas id="itemBalanceChart"></canvas>
                                        </div>
                                       <?php include '../../../test/balancechart.php'?>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div>

                        <!--here is the problem-->
                        <!--//////////////////////////////////-->
                        
                        <?php
                        $db = $_SESSION['company'];
                        $serverName = "BDAPPSS02V\\SQLEXPRESS";
                        $connectionInfo = array(
                            "Database" => $db,
                            "UID" => "sa",
                            "PWD" => "sa@123"
                        );

                        try {
                            $conn = new PDO("sqlsrv:Server=$serverName;Database=$db", "sa", "sa@123");
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            session_start();
                            $section=$_SESSION['section'];
                            if($_SESSION['table']=='short'){ 
                            $query = "SELECT TOP(50) b.c_name, b.i_name, 
                            b.total_item_purchase, 
                            b.total_item_issue, 
                            b.total_item_purchase_price, 
                           b.total_item_issue_price, 
                            b.qty_balance, 
                            b.item_issue_avg_price
                       FROM balance b
                       INNER JOIN item i ON i.i_id = b.i_id 
                       INNER JOIN item_purchase ip ON ip.i_id = i.i_id
                       WHERE i.section = '$section'
                       ORDER BY ip.p_request_accept_datetime DESC
                      ";
                            }
                            if($_SESSION['table']=='all'){ 
                                $query = "SELECT b.c_name, b.i_name, 
                                b.total_item_purchase, 
                                b.total_item_issue, 
                                b.total_item_purchase_price, 
                               b.total_item_issue_price, 
                                b.qty_balance, 
                                b.item_issue_avg_price
                           FROM balance b
                          
                           INNER JOIN item i ON i.i_id = b.i_id 
                           INNER JOIN item_purchase ip ON ip.i_id = i.i_id

                           WHERE i.section = '$section'
                           ORDER BY ip.p_request_accept_datetime DESC
                           
                          ";
                                }
                            
                            $stmt = $conn->query($query);

                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $conn = null; // Close the connection
                        } catch (PDOException $e) {
                            echo "Connection could not be established: " . $e->getMessage();
                        }
                    ?>



                       <style>
                        th{
                            font-size: 12px;
                        }
                        td{
                            font-size: 10px;
                        }
                       </style>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Category </th>
                                            <th>Item</th>
                                            <th>Total Purchase</th>
                                            <th>Total Issue</th>
                                            <th>Total Purchase Price</th>
                                            <th>Total Issue Price</th>
                                            <th>Balance</th>
                                            <th>Issue Avg Price</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Category </th>
                                            <th>Item</th>
                                            <th>Total Purchase</th>
                                            <th>Total Issue</th>
                                            <th>Total Purchase Price</th>
                                            <th>Total Issue Price</th>
                                            <th>Balance</th>
                                            <th>Issue Avg Price</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php

                                    // for($i=0;$i<3000;$i++){
                                    //     echo '
                                    //     <tr>
                                    //         <th>Category </th>
                                    //         <th>Item</th>
                                    //         <th>Total Purchase</th>
                                    //         <th>Total Issue</th>
                                    //         <th>Total Purchase Price</th>
                                    //         <th>Total Issue Price</th>
                                    //         <th>Balance</th>
                                    //         <th>Issue Avg Price</th>
                                    //     </tr>
                                    //     ';
                                    // }
                                   
                                    foreach ($data as $row) {
                                        echo '<tr>';
                                        foreach ($row as $cell) {
                                            echo '<td>' . $cell . '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/////////////////////////////////////-->




                    </div>
                </main>

                
<!--###### Footer Part ###############################################-->
<?php
include '../template/footer.php';
?>
<!--#####################################################-->