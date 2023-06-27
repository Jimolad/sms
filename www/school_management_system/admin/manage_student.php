<style>

h3{
	margin-top:1%;
	
	}
		
table{
	width:100%;
	height:40%;
	border:1px solid black;
	margin-top:6%;
	
	}
			
#breadcrumb{
	height:auto;
	width:100%;
	border:1px solid;
	background:grey;	
}	
	
th{
	background-color:grey;
	height:50px;
	}	

tr{
	text-align:center;
	height:70px;
	}
	
		
	
#nav-bar{
	background:white;
	color:black;
	
	}	
	.table{
		
		width:100%;
		height:auto;
		display:block;
		overflow-x:scroll;
	}
	
</style>



<?php
session_start();

include '../includes/db.php';
include '../includes/admin_auth.php';

$fetch = $conn->prepare("SELECT * FROM students ");
$fetch ->execute();

$records = array();

while($row = $fetch->fetch(PDO::FETCH_BOTH)){
	$records[] =$row;
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Student</title>
</head>

<body>

<div id="nav-bar">
<?php include ('../includes/admin_header.php'); ?>
</div>

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Manage Student</h3>
</div>

<div class="table">
<table border="2">
<tr>
	<th>NAME</th>
	<th>MATRIC_NUMBER</th>
    <th>DEPARTMENT</th>
    <th>D_O_B</th>
    <th>GENDER</th>
    <th>EMAIL</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Date</th>
	<th>Time</th>
</tr>

<?php
 //foreach($records as $value){  
 //echo "<h2>".$value['title']."</h2>";
 //}
 $fetchDepartment = $conn->prepare("SELECT * FROM department ");
	$fetchDepartment ->execute();
	
	$departmentRecords = array();
	
	while($roww = $fetchDepartment->fetch(PDO::FETCH_BOTH)){
		$departmentRecords[] =$roww;
	}
	$departmentName = array();
foreach($departmentRecords as $value){
		$departmentName[$value['department_id']] = $value['department_name'];
	}
  ?>

<?php foreach($records as $value): ?>
<tr>
	<td> <?=$value['name']?> </td>
	<td> <?=$value['matric_number']?></td>
   	<td> <?=$departmentName[$value['student_department_id']]?></td>
    <td> <?=$value['d_o_b'] ?></td>
    <td> <?=$value['gender'] ?></td>
    <td> <?=$value['email'] ?></td>
    <td> <a href="edit_student.php?students_id=<?=$value['students_id']?>" style="color:blue;">Edit</a></td>
    <td> <a href="delete_student.php?students_id=<?=$value['students_id']?>" style="color:blue;">Delete</a></td>
    <td> <?=$value['date_created']?></td>
    <td> <?=$value['time_created']?></td>
</tr>

 <?php endforeach; ?>
</table>
</div>
</body>
</html>