<style>
h1{
	margin-top:1%;
	
	}

input{
	width:28%;
	height:6%;
	border-radius:5px;
	padding-left:1%;
	margin-left:7%;
	}
	
#container{
	margin-top:16%;
	padding-left:37%;
	
	}
	
#breadcrumb{
	height:auto;
	width:100%;
	border:1px solid;
	background:grey;
    margin-top:1%;
	}

.submit{
	width:auto;
	margin-left:18%;
	
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
	$encrypted = password_hash($_POST['hash'],PASSWORD_BCRYPT);
	try{
	$stmt= $conn->prepare("SELECT * FROM admin WHERE email=:em");
	$stmt->bindParam(":em",$_POST['email']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);
	
if($stmt->rowCount() >0 &&password_verify($_POST['hash'], $record['hash_id'])){
	
	$_SESSION['admin_id']= $record['admin_id'];
	$_SESSION['admin_name']= $record['name'];
	
	header("Location:admin_dashboard.php?success=You have successfully logged in");
	exit();
	}else{
	header( $errorMsg = "Either email or password is incorrect");
		}
	}catch (PDOException $e) {
		echo "error: " . $e->getMessage();
}

}
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
</head>

<body>
<div id="breadcrumb">
<h1 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Login</h1>
</div>
<div id="container">  
<form action="" method="post" >

<?php if(isset($errorMsg)) { ?>
        <p style="color: red;"><?php echo $errorMsg; ?></p>
    <?php } ?>

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
<p><input type="password" name="hash" placeholder="Enter password"/> </p>

 <input type="submit" class=submit name ="submit" value="Login" />
</form>
</div>
</body>
</html>