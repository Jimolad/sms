<style>

#container{
	
	padding:24px;
	height:auto;
	
display:flex;
	justify-content:center;
	}

p{
	color:black; 
	font-size:20px; 
	font-family:Times New Roman, Times, serif;
	 align="center";
	}

input{
	width:70%;
	height:50px;
	border-radius:5px;
	margin-bottom:20px;
		
	padding right:20%;
	}
	
		
select{
width:70%;
	height:50px;
	border-radius:5px;
	margin-bottom:20px;
	}

form{
	width:50%;
	
	}


#update{
	width:35%;
	display:flex;
	justify-content:center;
	padding-left:16%;
	}


</style>







<?php
session_start();
include '../includes/db.php';
include '../includes/admin_auth.php';

if(isset($_GET['students_id'])){
$students_id =$_GET['students_id'];	

}else{
	header("Location:manage_student.php");
}
$statement= $conn->prepare("SELECT * FROM students");
$statement->execute();
$select= array();
while($row = $statement->fetch(PDO::FETCH_BOTH)){
	$select[]=$row;
}


$statement= $conn->prepare("SELECT * FROM students WHERE students_id=:sid");
$statement->bindParam(":sid",$students_id);
$statement->execute();

$record= $statement->fetch(PDO::FETCH_BOTH);
if($statement->rowCount()< 1){
header("location:edit_student.php");	
exit();
}

if(isset($_POST['submit'])){
	$error = array();
	
	if(empty($_POST['name'])){
		$error['name'] = "Enter Name";
	}
	
	if(empty($_POST['matric_number'])){
		$error['matric_number'] = "Enter Matric";
	}
	
	if(empty($_POST['student_department_id'])){
		$error['student_department_id'] = "Department";
	}
	if(empty($_POST['d_o_b'])){
		$error['d_o_b'] = "D_O_B";
	}
	if(empty($_POST['gender'])){
		$error['gender'] = "Gender";
	}
	if(empty($_POST['email'])){
		$error['email'] = "Email";
	}
	
	if(empty($error)){
		//die(var_dump($_POST['student_department_id']));
		$statement=$conn->prepare("UPDATE students SET name=:nm,matric_number=:mn,student_department_id=:sdi,d_o_b=:dob,gender=:gnd,email=:em WHERE students_id=:sid");
	$statement->bindParam(":nm",$_POST['name']);
	$statement->bindParam(":mn",$_POST['matric_number']);
	$statement->bindParam(":sdi",$_POST['student_department_id']);
	$statement->bindParam(":dob",$_POST['d_o_b']);
	$statement->bindParam(":gnd",$_POST['gender']);
	$statement->bindParam(":em",$_POST['email']);
	$statement->bindParam(":sid",$students_id);
		
	$statement->execute();
		

	header("Location:manage_student.php");
	exit();
}	
	
	}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Student</title>
</head>

<body>
<div id="container">
<br />
 <form action="" method="post">
 <p>Name</p>
        <input type="text" name="name" placeholder="Name" value="<?= $record['name'] ?>" /><br />
        <?php if(isset($errors['name'])): ?>
            <span style="color: red"><?= $errors['name'] ?></span><br />
        <?php endif; ?>

<p>Matric Number</p>
        <input type="text" name="matric_number" placeholder="Matric Number" value="<?= $record['matric_number'] ?>" /><br />
        <?php if(isset($errors['matric_number'])): ?>
            <span style="color: red"><?= $errors['matric_number'] ?></span><br />
        <?php endif; ?>

<p>Department</p>
       <select name="student_department_id">
    <?php
    $select = $conn->prepare("SELECT * FROM department");
    $select->execute();
    
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
        $selected = ($row['department_name'] == $record['student_department_id']) ? 'selected' : '';
        echo "<option value='" . $row['department_id'] . "' $selected>" . $row['department_name'] . "</option>";
    }
    ?>
</select><br />

<?php if (isset($errors['student_department_id'])): ?>
    <span style="color: red"><?= $errors['student_department_id'] ?></span><br />
<?php endif; ?>

    <p>Date of Birth</p>
    <input type="text" name="d_o_b" placeholder="D_O_B" value="<?= $record['d_o_b'] ?>" /><br />
<?php if(isset($errors['d_o_b'])): ?>
    <span style="color: red"><?= $errors['d_o_b'] ?></span><br />
<?php endif; ?>

<p>Gender</p>
<input type="text" name="gender" placeholder="Gender" value="<?= $record['gender'] ?>" /><br />
<?php if(isset($errors['gender'])): ?>
    <span style="color: red"><?= $errors['gender'] ?></span><br />
<?php endif; ?>


<p>Email</p>
<input type="text" name="email" placeholder="Email" value="<?= $record['email'] ?>" /><br />
<?php if(isset($errors['email'])): ?>
    <span style="color: red"><?= $errors['email'] ?></span><br />
<?php endif; ?>

<br />

<div id="update">
<input type="submit"  name="submit" value="Update" />
</div>

</form>
</div>
</body>
</html>
