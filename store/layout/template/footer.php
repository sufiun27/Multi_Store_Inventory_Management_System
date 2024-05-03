<!--######################################################################################################-->
<footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">ASK&copy; Code-Harmony</div>
                            <div>
                            <span> Date Time: <?php
                            date_default_timezone_set('Asia/Dhaka');
                            $defaultDateTime = date('Y-m-d H:i:s');
                            echo $defaultDateTime.' | ';
                            ?></span>    
                            <a href="http://<?php echo $_SESSION['base_url'];?>/store/layout/Privacy_Policy/Privacy_Policy.php">Privacy Policy</a>
                                &middot;
                                <a href="http://<?php echo $_SESSION['base_url'];?>/store/layout/Terms_Conditions/Terms_Conditions.php">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>










