<?php
session_start();
include('../includes/db.php');
include('../includes/admin_auth.php');

if(!isset($_GET['staff_id'])){
header("Location:manage_staff.php");	
exit();	
}

$statement= $conn->prepare("DELETE FROM staff WHERE staff_id=:sid");
$statement->bindParam(":sid",$_GET['staff_id']);
$statement->execute();
header("location:manage_staff.php");
exit();


?>