<?php
session_start();

if(isset($_GET['section'])){
$section = $_GET['section'];
$_SESSION['section'] = NULL;
$_SESSION['section'] = $section;
}

if(isset($_GET['table'])){
$table = $_GET['table'];
$_SESSION['table'] = NULL;
$_SESSION['table'] = $table;
}

//echo $_SESSION['section'];
header("Location: index.php");
?>