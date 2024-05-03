

<?php
if (session_status() === PHP_SESSION_NONE) {
    // Start the session
    session_start();
    // Perform any other session initialization or setup here
}
////DB connection////////////
class Dbh
{
    private $host = "BDAPPSS02V\SQLEXPRESS"; // Update the SQL Server hostname or IP
    private $user = "sa";
    private $pass = "sa@123";
    private $db_name = "inventoryuser";

    public function __construct()
    {
        //$this->db_name = $_SESSION['company'];
    }

    protected function connect()
    {
        $dsn = "sqlsrv:Server=" . $this->host . ";Database=" . $this->db_name;
        try {
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            // Handle connection errors
            die("Connection failed: " . $e->getMessage());
        }
    }
}

///////////////////
class AuthCsrf extends Dbh
{
    public function authenticate($token, $uid)
    {
        $pdo = $this->connect();
        $query = "SELECT csrf FROM user_token WHERE u_id = :uid ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        //echo $stmt->errorInfo();
        $row = $stmt->fetch();
        if($row['csrf'] == $token)
        {
            return true;
        }
        else
        {
            return false;
        }



    }
}

$token = $_SESSION['csrf_token'];
$uid = $_SESSION['uid'];
$auth = new AuthCsrf();
if ($auth->authenticate($token, $uid)) {
    $_SESSION['csrf_index']=true;
} else {
    header("Location: http:10.3.13.87/storehl/");
    $_SESSION['csrf_index']=false;
}


?>





<!--################################################################################################################################################################-->

<?php

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // Redirect the user to the login page or display an error message
    header("Location: http://localhost:8080/storehl/");
    exit();
  }
  
?>
<?php 
    date_default_timezone_set('Asia/Dhaka');
    $defaultDateTime = date('Y-m-d H:i:s');
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="inventory management system" />
        <meta name="author" content="Abu Sufiun || email: abusufiun27@gmail.com" />
        <title>Hop Lun</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- bootstrap CDN-->
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
<style>

</style>

</head> 
    <!-- <body class="sb-nav-fixed" style="background: rgba(245, 39, 183, 0.20);"> -->
    <body class="sb-nav-fixed" 
    style=" background-image: url('http://drive.google.com/uc?export=view&id=1AkCiOQwLURrVukCTWFdhQ6vJv-ihIZx_'); 
    background-color: rgb(255, 255, 230); 
    background-size: cover; 
    height: 100vh; 
        width: 100vw;
    background-position: center;">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark " >
            <!-- Navbar Brand-->
            <?php
            $default_url=$_SESSION['base_url'];
            $extra_url='store/layout/start/';
            ?>
            <div style="background-color: rgb(255, 204, 255); border-radius: 5px; text-align: center;" >
                <a class="navbar-brand ps-3 text-dark" href="<?php echo "http://$default_url/$extra_url"; ?>">
                <b>Hop Lun</b>
                </a>
            </div>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            
            <div class="input-group">
                
                <h4 class="text-white"> <?php echo $_SESSION['username']; ?> ( <?php echo $_SESSION['company']; ?> )</h4>
                
                
            
            
            </div>
            <!--
                
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                
                -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="http://<?php echo $_SESSION['base_url'];?>/logout/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark " id="sidenavAccordion" >
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/start/">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading"> <span class="btn btn-success btn-xs"><?php echo $_SESSION['section'] ?></span>
                                    <span>Mode-</span>
                                    <?php
                                    if($_SESSION['table']=='short'){
                                        echo '<a href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?table=short"><button class="btn btn-success btn-xs">Soft</button></a>';
                                        echo '<a href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?table=all"><button class="btn btn-secondary btn-xs">Deep</button></a>';
                                                                   
                                    }elseif($_SESSION['table']=='all'){
                                        echo '<a href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?table=all"><button class="btn btn-warning btn-xs">Deep</button></a>';
                                        echo '<a href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?table=short"><button class="btn btn-secondary btn-xs">Soft</button></a>'; 
                                    }
                                    ?>
                                    
                                    <?php
                                     if($_SESSION['role']=='super_admin' || $_SESSION['role']=='group_admin'){
                                        //echo $_SESSION['username'];
                                        echo '
                                        <a class="btn btn-info btn-xs" href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?section=GEN111">GEN</a>
                                        <a class="btn btn-info btn-xs" href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?section=ELE111">MEC</a>
                                        <a class="btn btn-info btn-xs" href="http://'.$_SESSION['base_url'].'/store/layout/start/change_role.php?section=ELE222">ELE</a>
                                        ';
                                    }
                                    ?>
                            </div>
                             
                            
                                    <?php
                                     if($_SESSION['role']=='super_admin'){
                                        //echo $_SESSION['username'];
                                        echo '
                                        <a class="btn btn-info" href="http://10.3.13.87/storehl/super_admin/index.php">Admin Panel</a>
                                        ';
                                    }
                                    ?>

                           
                           
                            <?php if($_SESSION['role']=='admin'||$_SESSION['role']=='super_admin' || $_SESSION['role']=='group_admin'){ ?>
                            <!--add customer///////////////////////////////////////////--->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Registration
                                    
                                        
                                        
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                    <nav id="add_customer" class="sb-sidenav-menu-nested nav ">
                                    <!-- <a id="collapseLayouts_search" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/add_customer/adduser_search.php">Search</a> -->
                                        <a id="collapseLayouts_add" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/add_customer/adduser.php">Add Emp</a>
                                        <a id="collapseLayouts_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/add_customer/adduser_list.php">List Emp</a>
                                        <a id="collapseLayouts_add_department" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/add_customer/adddepartment.php">Add Departments</a>
                                        <a id="collapseLayouts_department" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/add_customer/adduser_Department_list.php">Departments</a>
                                        
                                    </nav>
                                </div>
                                <?php } ?>
                                
                            <!--add suppliers////////////////////////////////////////-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts0" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Supplier
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts0" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav id="add_customer" class="sb-sidenav-menu-nested nav ">
                                <a id="collapseLayouts0_search" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/supplier/supplier_search.php">Search</a>
                                    <a id="collapseLayouts0_add" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/supplier/supplier_add.php">Add</a>
                                    <a id="collapseLayouts0_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/supplier/supplier_list.php">List</a>
                                    
                                </nav>
                            </div>

                                 <!--product section-->  
                                 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Product
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                    <a id="collapseLayouts1_search" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/product/Product_search.php">Search</a>
                                        <a id="collapseLayouts1_add" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/product/product_add.php">Add</a>
                                        <a id="collapseLayouts1_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/product/product_list.php">List</a>
                                        <a id="collapseLayouts1_stock_out_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/product/Product_stock_out_list.php">Stock Out List</a>
                                        
                                        <a id="collapseLayouts1_add_category" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/product/product_add_catagory_1.php">Add Category</a>
                                        <a id="collapseLayouts1_category" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/product/Product_category.php">Category</a>
                                    </nav>
                                </div>

                            <!--admin can only access this portion -->
                           
                           <?php
                            if ($_SESSION['role'] == 'admin'){
                                //below section will appare under echo here
                                echo '
                                <!-----Admin can only access this portion --------------------------------------------------------------------------------->
                            
                                ';
                            }
                            ?>
                            

                            <!-------------------------------------------------------------------------------->
                            <a class="nav-link collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Purchase Product
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse " id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav ">
                                    
                                    <a id="collapseLayouts2_add" class="nav-link " href="http://<?php echo $_SESSION['base_url'];?>/store/layout/purchase_product/purchase_item_process.php">Purchase</a>
                                    <a id="collapseLayouts2_list" class="nav-link " href="http://<?php echo $_SESSION['base_url'];?>/store/layout/purchase_product/purchase_list.php">Purchase List</a>
                                    <a id="collapseLayouts2_return" class="nav-link " href="http://<?php echo $_SESSION['base_url'];?>/store/layout/purchase_product/return_list.php">Return List</a>
                                    <!-- <a id="collapseLayouts2_search" class="nav-link " href="http://<?php //echo $_SESSION['base_url'];?>/store/layout/purchase_product/purchase_list_search.php">Search</a> -->
                                    <!-- <a id="collapseLayouts2_accept_list" class="nav-link" href="http://<?php //echo $_SESSION['base_url'];?>/store/layout/purchase_product/purchase_list_accept.php">Accept list</a>
                                    <a id="collapseLayouts2_recive_list" class="nav-link" href="http://<?php //echo $_SESSION['base_url'];?>/store/layout/purchase_product/purchase_list_recive.php">Recive list</a> -->
                                </nav>
                            </div>
                            <!-------------------------------------------------------------------------------->
                            <!-------------------------------------------------------------------------------->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Issue Item
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a id="collapseLayouts3_add" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/issue_item/issue.php">Issue</a>
                                    <a id="collapseLayouts3_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/issue_item/issue_list.php">Issue List</a>

                                   <!--
                                    <a id="collapseLayouts3_deactivate" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/issue_item/issue_list_deactive.php">Deactivated List</a>
                                   -->

                                    <a id="collapseLayouts3_search" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/issue_item/issue_search.php">Search</a>
                                </nav>
                            </div>
                            <!-------------------------------------------------------------------------------->

                            <!-------------------------------------------------------------------------------->
                            <?php if ($_SESSION['role'] == 'super_admin_null'){?>
                            
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts4" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Stock Transfer
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a id="collapseLayouts4_add" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/stock_transfer/issue.php">Issue</a>
                                    <a id="collapseLayouts4_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/stock_transfer/issue_list.php">Issue List</a>

                                   <!--
                                    <a id="collapseLayouts3_deactivate" class="nav-link" href="http://<?php //echo $_SESSION['base_url'];?>/store/layout/issue_item/issue_list_deactive.php">Deactivated List</a>
                                   -->

                                    <a id="collapseLayouts4_search" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/stock_transfer/issue_search.php">Search</a>
                                </nav>
                            </div>

                            <?php } ?>
                            <!-------------------------------------------------------------------------------->

                            <!-------------------------------------------------------------------------------->
                            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'super_admin' || $_SESSION['role']=='group_admin'){?>
                            
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts4" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Item Return
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a id="collapseLayouts4_add" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/item_return/issue.php">Return Issue Items</a>
                                    <a id="collapseLayouts4_list" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/item_return/return_list.php">Return List</a>
                                   </nav>
                            </div>

                            <?php } ?>
                            <!-------------------------------------------------------------------------------->

                            
                            
                            <!--exit add customer portin-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages_report" aria-expanded="false" aria-controls="collapsePages_report">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Report
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages_report" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseStoreReport" aria-expanded="false" aria-controls="pagesCollapseStoreReport">
                                        Store
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseStoreReport" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a id="dateWiseRecive" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/report/Date_Wise_Receive.php">Date Wise Receive</a>
                                            <a id="dateWiseIssue" class="nav-link " href="http://<?php echo $_SESSION['base_url'];?>/store/layout/report/Date_Wise_Issue.php">Date Wise Issue</a>
                                            <a id="Invoice_wise_Balance_Items" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/report/Invoice_wise_Balance_Items.php">Invoice Wise Balance Items (Purchase)</a>
                                            <a id="Balance_Items" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/report/Balance_Items.php">Balance Items</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Department
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a id="Department_Wise_Issue" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/report/Department_Wise_Issue.php">Department Wise (Item) Cost</a>
                                            <a id="Department_Wise_Issue_Category" class="nav-link" href="http://<?php echo $_SESSION['base_url'];?>/store/layout/report/Department_Wise_Issue_Category.php">Department Wise (Category) Cost</a>

                                        </nav>
                                    </div>

                                    

                                    
                                </nav>
                            </div>

<!--                            <div class="sb-sidenav-menu-heading">Addons</div>-->
<!--                            <a class="nav-link" href="http://--><?php //echo $_SESSION['base_url'];?><!--/store/layout/chart/chart.php">-->
<!--                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>-->
<!--                                Charts-->
<!--                            </a>-->
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer ">
                        <div class="small">Log in as: <?php echo $_SESSION['role']."(".$_SESSION['email'].")" ;?></div>
                        Inventory Management System
                    </div>
                </nav>
            </div>
<!--################################################################################################################################################################-->
