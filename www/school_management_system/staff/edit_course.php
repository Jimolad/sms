<style>
	
input{
	width:30%;
	height:50px;
	border-radius:5px;
	padding-left:10px;
	}

	
#container{
	margin-top:100px;
	padding-left:30%;
	
	}

button{
	border-radius:5px;
	background:skyblue;
	width:100px;
	height:30px;
	}



</style>


<?php
session_start();
include '../includes/db.php';
include '../staff/user_auth.php';

if(isset($_GET['course_id'])){
$add_courses =$_GET['course_id'];	

}else{
	header("Location:add_courses.php");
	exit();
}

$statement= $conn->prepare("SELECT * FROM add_courses WHERE course_id=:adc");
$statement->bindParam(":adc",$add_courses);
$statement->execute();

$record= $statement->fetch(PDO::FETCH_BOTH);

if($statement->rowCount()< 1){
header("location:edit_course.php?");	
exit();
}



if(isset($_POST['submit'])){
	$error = array();
	
	if(empty($_POST['course_name'])){
		$error['course_name'] = "Course Name is required";
	}
	
	if(empty($_POST['course_content'])){
		$error['course_content'] = "Course Content is required";
	}
	
	if(empty($_POST['department_id'])){
		$error['department_id'] = "department is required";
	}
//die(var_dump($_POST));
	if(empty($error)){
		
		$statement=$conn->prepare("UPDATE add_courses SET course_name=:con,course_content=:cnn,department_id=:did WHERE course_id=:adc");
	$statement->bindParam(":con",$_POST['course_name']);
	$statement->bindParam(":cnn",$_POST['course_content']);
	$statement->bindParam(":did",$_POST['department_id']);
	
	$statement->bindParam(":adc",$add_courses);
		
	$statement->execute();
	
	header("Location:add_courses.php");
	exit();
}	
	
	}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Course</title>
</head>

<body>

<div id="container">
<br />
 <form action="" method="post">
 
<p><h3 style="color:black; font-size:20px; font-family:'Times New Roman', Times, serif";>Course name</h3><p>
        <input type="text" name="course_name" placeholder="Course Name" value="<?= $record['course_name'] ?>" /><br />
        <?php if(isset($errors['course_name'])): ?>
            <span style="color: red"><?= $errors['course_name'] ?></span><br />
        <?php endif; ?>
  

 <p><h3 style="color:black; font-size:20px; font-family:'Times New Roman', Times, serif";>Course content</h3><p>   
 
    <textarea rows="10" cols="50" name="course_content"><?= $record['course_content'] ?></textarea>
<?php if(isset($errors['course_content'])): ?>
    <span style="color: red"><?= $errors['course_content'] ?></span><br />
<?php endif; ?>

<br /><br/>

<button type="submit" name="submit"> Update </button>
</form>
</div>
</body>
</html>
