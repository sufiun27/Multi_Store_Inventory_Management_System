<?php
session_start();
$_SESSION['company'] = 'demo';
header("Location: http://10.3.13.87/storehl/store/layout/start/");
?>