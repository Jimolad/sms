<style>	
b{
	color:red;
}

h3{
	margin-top:1%;
	
	}
		
#container{
	padding:24px;
	height:auto;
	
	display:flex;
	justify-content:center;
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
	height:80px;
	}
	
		
table{
	width:70%;
	height:40%;
	border:1px solid black;
	margin-top:6%;
	
	}
	
		
#nav-bar{
	background:white;
	color:black;
	
	}
		@media only screen and (max-width:480px){
#container{
	margin-top:15%;
	margin-left:0%;
	padding-left:5%;
	height:130%;
	
	}
		
	input{
		margin:5px;
	width:90%;
	height:5%;
	border-radius:5px;
	padding-left:10px;
	margin-left:%;
	
	}
	
	p{display:flex;}
	
	select{
	width:90%;
	height:5%;
	border-radius:5px;
	padding-left:10px;
	margin:5px;
	margin-left:%;
	}
	
	#submit{
	padding-left:15%;
	}
	
	button{
	background:#000000;
	color:white;
	width:70%;
	height:4%;
	border-radius:7px;
	margin-top:4%
	}
	
	b{
		color:red;
	}
	
	
	
	
	}

	
</style>

<?php
session_start();

include '../includes/db.php';
include '../includes/admin_auth.php';

$fetch = $conn->prepare("SELECT * FROM staff ");
$fetch ->execute();

$records = array();

while($row = $fetch->fetch(PDO::FETCH_BOTH)){
	$records[] =$row;
}

//var_dump($records);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Manage Staff</title>

</head>

<body>

<div id="nav-bar">
<?php include ('../includes/admin_header.php'); ?>
</div>

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Manage Staff</h3>
</div>

<div id="container">


<table border="2">
<tr>
	<th><b>NAME</b></th>
    <th><b>DEPARTMENT</b></th>
    <th><b>ADDRESS</b></th>
    <th><b>Edit</b></th>
    <th><b>Delete</b></th>
    <th><b>Date</b></th>
	<th><b>Time</b></th>
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
//var_dump($departmentName);
//die;
  ?>

<?php foreach($records as $value): ?>
<tr>
	<td> <?=$value['name']?> </td>
	<td> <?=$departmentName[$value['department_id']]?></td>
    <td> <?=$value['address'] ?></td>
    <td> <a href="edit_staff.php?staff_id=<?=$value['staff_id']?>"  style="color:blue;">Edit</a></td>
    <td> <a href="delete_staff.php?staff_id=<?=$value['staff_id']?>"  style="color:blue;">Delete</a></td>
    <td> <?=$value['date_created']?></td>
    <td> <?=$value['time_created']?></td>
</tr>

 <?php endforeach; ?>
</div>
</body>

</html>