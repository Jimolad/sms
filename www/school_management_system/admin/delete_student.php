
<?php
session_start();

include('../includes/db.php');
include('../includes/admin_auth.php');

if(!isset($_GET['students_id'])){
header("Location:manage_student.php");	
exit();	
}
 


$statement = $conn->prepare("DELETE FROM students WHERE students_id=:sid");
$statement->bindParam(":sid",$_GET['students_id']);
$statement->execute();
header("Location:manage_student.php");
exit();

?>
