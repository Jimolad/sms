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
    margin-top:1%;
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
	if(empty($_POST['email'])){
	$error['email'] = "Enter Email";	
	}
	
	

if(empty($_POST['hash'])){
	$error['hash'] = "Enter Password";
	}
			
if(empty($error)){
	
	$stmt= $conn->prepare("SELECT * FROM staff WHERE email =:em");
	$stmt->bindParam(":em",$_POST['email']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);
	
if($stmt->rowCount() >0 &&password_verify($_POST['hash'], $record['hash'])){
	
	$_SESSION['email']= $record['email'];
	$_SESSION['hash']= $record['hash'];
	$_SESSION['staff_id']= $record['staff_id'];
	
	
	header("Location:staff_dashboard.php");
	exit();
	
		}else{echo "Either Email or Password Incorrect";
					}
		
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff Login</title>
</head>

<body>
<div id="breadcrumb">
<h1 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Login</h1>
</div>

<div id="container">
<form action="" method="post" >

 <?php
if(isset($error['email'])){
		echo "<p style='color:red'>".$error['email']."</p>";;
	}

?>
<p> <input type="email" name="email" placeholder="Please enter Email" /> </p>

 <?php
if(isset($error['hash'])){
		echo "<p style='color:red'>".$error['hash']."</p>";;
	}

?>
<p> <input type="password" name="hash"  placeholder="Enter password" /> </p>

<input type="submit" class=submit name="submit" value="Login" />
</form>

</body>
</div>
</html>