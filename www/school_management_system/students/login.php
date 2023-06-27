<style>
h1{
	margin-top:1%;
	
	}

input{
	width:28%;
	height:6%;
	border-radius:10px;
	padding-left:1%;
	margin-left:7%;
	}
#container{
	margin-top:16%;
	padding-left:37%;
	
	}
	
#breadcrumb{
	height:6%;
	width:100%;
	border:1px solid;
	background:grey;
    margin-top:30px;
	}

.submit{
	width:10%;
	margin-left:16%;
	
	}


</style>


<?php
session_start();

include('../includes/db.php');

if(isset($_POST['submit'])){
	$error =array();
	if(empty($_POST['matric_number'])){
	$error['matric_number'] = "Enter matric number";	
	}
	

if(empty($_POST['hash'])){
	$error['hash'] = "Enter Password";
	}
			
if(empty($error)){
	
	$stmt= $conn->prepare("SELECT * FROM students WHERE matric_number =:mn");
	$stmt->bindParam(":mn",$_POST['matric_number']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);

	
if($stmt->rowCount() >0 &&password_verify($_POST['hash'], $record['hash'])){
	
	$_SESSION['matric_number']= $record['matric_number'];
	$_SESSION['hash']= $record['hash'];
	$_SESSION['students_id']= $record['students_id'];
	
	header("Location:student_dashboard.php");
	
	
	exit();
	
		}else{echo "Either Matric number or Password Incorrect";
					}
			
		
}
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Login</title>
</head>

<body>
<div id="breadcrumb">
<h1 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Login</h1>
</div>

<div id="container">
<form action="" method="post" >

 <?php
if(isset($error['matric_number'])){
		echo "<p style='color:red'>".$error['matric_number']."</p>";;
	}

?>

<p> <input type="matric_number" name="matric_number" placeholder="Please enter Matric number" /> </p>

 <?php
if(isset($error['hash'])){
		echo "<p style='color:red'>".$error['hash']."</p>";;
	}

?>

<p> <input type="password" name="hash" placeholder="Enter password"/> </p>

<input type="submit" class=submit name="submit" value="Login" />


</form>
<div>
</body>
</html>