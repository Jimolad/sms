<style>

#container{
	
	width:100%;
	height:auto;
	display:flex;
	flex-direction:column;
	align-items:center;
	}


h3{
	margin-top:1%;
	
	}	
	
	
table{
	width:50%;
	height:20%;
	border:1px solid black;
	
	}
		
#breadcrumb{
	height:6%;
	width:100%;
	border:1px solid;
	background:grey;
	margin-top:24px;	
}
	
th{
	background-color:grey;
	height:50px;
	}	

tr{
	text-align:center;
	height:70px;
	}
	
	
</style>




















<?php 

session_start();
include('../includes/db.php');
include('../students/user_auth.php');


$statement =$conn->prepare("SELECT * FROM students WHERE students_id = :students_id");
$statement->bindParam(":students_id",$_SESSION['students_id']);
$statement->execute();
$current_users_data = $statement->fetch(PDO::FETCH_BOTH);


?>
<?php include ('../students/header.php'); ?>


<div id="container">

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>View course</h3>
</div>

<?php
$fetch = $conn->prepare("SELECT * FROM add_courses WHERE department_id = :did ");
$fetch->bindParam(":did", $current_users_data['student_department_id']);
$fetch->execute();

$records = array();

while($row = $fetch->fetch(PDO::FETCH_BOTH)){
	$records[] =$row;
}

?></br>
<table border="2">
<tr>
	<th>Course Name</th>
    <th>Course Content</th>
    <th>Date Published</th>
	<th>Time Published</th>
</tr>


<?php foreach($records as $value): ?>
<tr>
	<td> <?=$value['course_name']?> </td>
    <td> <?=$value['course_content']?> </td>
    <td> <?=$value['date_created']?></td>
    <td> <?=$value['time_created']?></td>
</tr>

 <?php endforeach;?>
 </table>
 </div>
</body>
</html>
