<link rel="stylesheet" type="text/css" href="../css/style.css"/>


<?php
session_start();
include("../includes/admin_auth.php");
include'../includes/db.php';

if(isset($_POST['submit'])){

	$err=array();
	
	
	if(empty($_POST['name'])){
		$err['name'] ="Please Enter Name";
	}
	
	if(empty($_POST['student_department_id'])){
		$err['student_department_id'] ="Please Enter Department";
	} 
	
	if(empty($_POST['d_o_b'])){
		$err['d_o_b'] ="Enter Date Of Birth";
	}
	
	if(empty($_POST['gender'])){
		$err['gender'] ="Select Gender";
	}
	
	if(empty($_POST['student_email'])){
		$err['student_email']	="Enter Your Email";
	}
	
	if(empty($_POST['hash'])){
		$err['hash'] ="Create Password";
	}
			
	if(empty($err)){
	
		$encrypted = password_hash($_POST['hash'],PASSWORD_BCRYPT);
		$matric= "HIS"."/".rand(10,99)."/".rand(100,999)."/".(2023);
		$stmt = $conn->prepare("INSERT INTO students VALUES (NULL,:nm,:mn,:sdi,:dob,:gnd,:se,:hsh,NOW(),NOW())");
		$data = array(
			":nm"=>$_POST['name'],
			":mn"=>$matric,
			":sdi"=>$_POST['student_department_id'],
			":dob"=>$_POST['d_o_b'],
			":gnd"=>$_POST['gender'],
			":se"=>$_POST['student_email'],
			":hsh"=>$encrypted
		);
	$stmt ->execute($data);
	
	
header("location:admin_dashboard.php");	
	exit();	
		
				
	}
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Student</title>
</head>

<body>
<div id="nav-bar">
<?php include ('../includes/admin_header.php'); ?>
</div>

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Create Student</h3>
</div>

<div id="container"> 

<form action="" method="POST" class="form">
<?php
if(isset($_GET['err'])){
echo"<p style='color:red'>".$_GET['error']."</p>";	
}

if(isset($_GET['success'])){
echo"<p style='color:green'>".$_GET['success']."</p>";	
}
?>

<div class="form-one">

<?php
if(isset($err['name'])){
		echo "<p style='color:red'>".$err['name']."</p>";
	}

?>

<input type="text" name="name" placeholder="Student name" />


<?php
if(isset($err['student_department_id'])){
		echo "<p style='color:red'>".$err['student_department_id']."</p>";
	}

?>
      <select name="student_department_id">
    <?php
    $select = $conn->prepare("SELECT * FROM department");
    $select->execute();
     echo "<option value=''> -- Select Department -- </option>";
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . $row['department_id'] . "' $selected>" . $row['department_name'] . "</option>";
    }
    ?>
</select>
 
<?php if (isset($errors['department_id'])): ?>
    <span style="color: red"><?= $errors['department_id'] ?></span><br />
<?php endif; ?>




<?php
if(isset($err['d_o_b'])){
		echo "<p style='color:red'>".$err['d_o_b']."</p>";
	}
?>
 <input type="date" class="date" name="d_o_b" />

</div>


<div class="form-one form-one-two">

<?php
if(isset($err['gender'])){
		echo "<p style='color:red'>".$err['gender']."</p>";
	}

?>

<select name="gender">
	<option disabled selected> --Select Gender-- </option>
	<option value="Male">Male</option>
	<option value="Female">Female</option>
</select>


<?php
if(isset($err['student_email'])){
		echo "<p style='color:red'>".$err['student_email']."</p>";;
	}

?>

<input type="text" class="email" name="student_email" placeholder="Email" />
 
 
 <?php
if(isset($err['hash'])){
		echo "<p style='color:red'>".$err['hash']."</p>";;
	}

?>

<input type="password" class="pass" name="hash" placeholder="Create password"/>

</div>


<div id="submit"> 
<button type="submit" name="submit"> create </button>
</div>

</form>
</div>
</body>
</html>