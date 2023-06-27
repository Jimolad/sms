<style>

h3{
	margin-top:1%;
	
	}
p{
	margin-top:2%;
	
	}
	
			
#breadcrumb{
	height:50px;
	width:100%;
	background:grey;
	margin-top:2%;	
}

	
input{
	width:30%;
	height:50px;
	border-radius:5px;

	}

	
select{
	width:30%;
	height:50px;
	border-radius:5px;
	padding-left:10px;

	}

	
#container{
	margin-top:10px;
	
	width:100%;
	height:auto;
	flex-direction:column;
	align-items:center;
	display:flex;
	}

	
button{
	border-radius:5px;
	background:skyblue;
	width:100px;
	height:30px;
	
	}

table{
	width:60%;
	height:100px;
	border:3px solid black;

	text-align:center;

	}

tr{
	height:50px;
	
	}

.a:hover{color:black; background-color:skyblue; 
}

.a{text-decoration:white; color:black;
}

</style>



<?php
session_start();
include('../includes/db.php');
include('../staff/user_auth.php');

$error ="";

if (isset($_POST['submit'])){
	
if(empty($_POST['add_courses'])){
	$error['add_courses'] = "Enter Course Name";
	}
	
if(empty($_POST['course_content'])){
	$error['course_content'] = "Enter Course Content";
	}
	
if(empty($_POST['department_id'])){
	$error['department_id'] = "Enter Department";
	}
	//die(var_dump($_POST,$error['course_content']));
	
	$statement=$conn->prepare("SELECT * FROM add_courses WHERE course_name = :cn");
	$statement->bindParam(":cn",$_POST['add_courses']);

	
	$statement->execute();
	$COUNT=$statement->fetch(PDO::FETCH_BOTH);
		//die(var_dump($_SESSION));
		
		
		if ($COUNT>0){
			$error['add_courses'] = "course name already exist";
			
		}
else{	
try{ 
	

	$statement=$conn->prepare("INSERT INTO add_courses VALUES(NULL,:cn,:ccn,:did,:cd,NOW(),NOW())");
	$statement->bindParam(":cn",$_POST['add_courses']);
	$statement->bindParam(":ccn",$_POST['course_content']);
	$statement->bindParam(":cd",$_SESSION['staff_id']);
	$statement->bindParam(":did",$_POST['department_id']);
		$statement->execute();
	
header("location:add_courses.php");
exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

}
}
$statement =$conn->prepare("SELECT * FROM staff WHERE email = :em");
$statement->bindParam(":em",$_SESSION['email']);
$statement->execute();
$current = $statement->fetch(PDO::FETCH_BOTH);
//die(var_dump($_SESSION));
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Courses</title>
</head>

<body>

<?php 
include '../staff/header.php';
 ?>

<div id="container"> 

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Add courses below</h3>
</div>



 <?php if(!empty($error['add_courses'])) { ?>
        <p style="color: red;"><?php echo $error['add_courses']; ?></p>
    <?php } ?>
    
    
<form action="" method="post">


<p>Course Name<p>
<input type="text" name="add_courses" />


<?php if(!empty($error['course_content'])) { ?>
        <p style="color: red;"><?php echo $error['course_content']; ?></p>
    <?php } ?>

<p>Course content<p>
<textarea rows="10"  cols="45"  name="course_content"></textarea>


<?php if(!empty($error['department_id'])) { ?>
        <p style="color: red;"><?php echo $error['department_id']; ?></p>
    <?php } ?>
<p>Department</p>
<?php
$select =$conn->prepare("SELECT * FROM department WHERE department_id= :id");
$select->bindParam(":id",$current['department_id']);
$select->execute();
?>
	
<select name="department_id">
<?php
	while($row = $select->fetch(PDO::FETCH_BOTH)){ ?>
 <option value="<?php echo $row['department_id']; ?> "><?php echo $row['department_name']; ?> </option>
	
	<?php } ?>
</select></br></br>

<button type="submit" name="submit"> create </button>

</form>

<?php 

$fetch = $conn->prepare("SELECT * FROM add_courses WHERE created_by=:cb");
$fetch ->bindParam(":cb",$_SESSION['staff_id']);
$fetch ->execute();

$records = array();

while($row = $fetch->fetch(PDO::FETCH_BOTH)){
	$records[] =$row;
}

?></br>
<table border="2">
<tr>
	<th>Course Name</th>
	<th>Course ID</th>
    <th>Course Content</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Date Published</th>
	<th>Time Published</th>
</tr>


<?php foreach($records as $value): ?>
<tr>
	<td> <?=$value['course_name']?> </td>
	<td> <?=$value['department_id']?></td>
    <td> <?=$value['course_content']?> </td>
    <td class="a" > <a href="edit_course.php?course_id=<?=$value['course_id']?>">Edit</a></td>
    <td class="a"> <a href="delete_courses.php?course_id=<?=$value['course_id']?>">Delete</a></td>
    <td> <?=$value['date_created']?></td>
    <td> <?=$value['time_created']?></td>
</tr>

 <?php endforeach;?>
 </table>
 </div>
</body>
</html>