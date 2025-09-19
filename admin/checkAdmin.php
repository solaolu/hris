<?php
session_start();

//if ($_SESSION['adminLogged']!="true") header("location: adminlogin.php");
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
$admin_companyID=$_SESSION["user__info"]['companyID'];
?>