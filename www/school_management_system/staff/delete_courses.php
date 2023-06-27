<?php
session_start();

include('../includes/db.php');
include('../includes/admin_auth.php');

if(!isset($_GET['course_id'])){
header("location:add_courses.php");	
exit();	
}
 


$statement = $conn->prepare("DELETE FROM add_courses WHERE course_id=:cid");
$statement->bindParam(":cid",$_GET['course_id']);
$statement->execute();
header("location:add_courses.php");
exit();

?>
