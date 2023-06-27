<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<?php
session_start();
include("../includes/admin_auth.php");
include'../includes/db.php';

if(isset($_POST['submit'])){
	$error=array();
	

	if(empty($_POST['name'])){
		$error['name']	="Please Enter Name";
	}
	
	if(empty($_POST['department'])){
		$error['department'] ="Please Enter Department";
	}
	
	if(empty($_POST['address'])){
		$error['address'] ="Enter Address";
	}
	
	if(empty($_POST['gender'])){
		$error['gender'] ="Select Gender";
	}
	
	if(empty($_POST['d_o_b'])){
		$error['d_o_b'] ="Enter Date Of Birth";
	}
		if(empty($_POST['phone_number'])){
		$error['phone_number'] ="Enter Phone Number";
	}
	
	if(empty($_POST['email_address'])){
		$error['email_address']	="Enter Your Email";
	}
	
	if(empty($_POST['hash'])){
		$error['hash'] ="Create Password";
	}
	
	if(empty($error)){		
		$encrypted = password_hash($_POST['hash'],PASSWORD_BCRYPT);
		$stmt =$conn->prepare("INSERT INTO staff VALUES (NULL,:nm,:dpt,:adr,:gnd,:dob,:phn,:em,:hsh,NOW(),NOW())");
		$data = array(
		
			
			 ":nm"=>$_POST['name'],
			 ":dpt"=>$_POST['department'],
			 ":adr"=>$_POST['address'],
			 ":gnd"=>$_POST['gender'],
			 ":dob"=>$_POST['d_o_b'],
			 ":phn"=>$_POST['phone_number'],
			 ":em"=>$_POST['email_address'],
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Staff</title>


</head>

<body>
<div id="nav-bar">
<div id="nav-bar-one">
	<?php include ('../includes/admin_header.php'); ?>
</div>
<div Id="nav-bar-two">
	<div class="nav-op1"></div>
    <div class="nav-op1 op12"></div>
    <div class="nav-op1 op13"></div>
</div>
</div>

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Create Staff</h3>
</div>
<div id="container">  
 
<form action="" method="POST" class="form">

 <div class="form-one">
 
 <?php
 if(isset($error['name'])){
		echo "<p style='color:red';>".$error['name']."</p>";;
	}
?>

 <input type="text" name="name" placeholder="staff name" /> 


 
<?php
if(isset($error['address'])){
		echo "<p style='color:red'>".$error['address']."</p>";;
	}
?>

<input type="text" name="address" placeholder="enter address" /> 


 <?php
if(isset($error['phone_number'])){
		echo "<p style='color:red'>".$error['phone_number']."</p>";
	}
?>

<input type="text" class="phonenumber" name="phone_number" placeholder="enter phone" />


<?php
if(isset($error['d_o_b'])){
		echo "<p style='color:red'>".$error['d_o_b']."</p>";;
	}
?>
 <input type="date"  class="date" name="d_o_b" /> 




 </div>
 <div class="form-one form-one-two">
 
 	
<?php
if(isset($error['gender'])){
		echo "<p style='color:red'>".$error['gender']."</p>";;
	}
?>

<select name="gender">
<option disabled selected> --Select Gender-- </option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>


 
 <?php
if(isset($error['department'])){
	echo "<p style='color:red'>".$error['department']."</p>";
	}
?>
	
<select name="department">
 
    <?php
    $select = $conn->prepare("SELECT * FROM department");
    $select->execute();
    echo "<option value=''> -- Select Department </option>";
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . $row['department_id'] . "' $selected>" . $row['department_name'] . "</option>";
    }
    ?>
</select>
 
<?php 
if (isset($errors['department_id'])): ?>
    <span style="color: red"><?php echo $errors['department_id'] ?></span><br />
<?php endif; ?>


<?php
if(isset($error['email_address'])){
		echo "<p style='color:red'>".$error['email_address']."</p>";
	}
?>

<input type="text" class="email" name="email_address" placeholder="enter email" /> 


 
<?php
if(isset($error['hash'])){
		echo "<p style='color:red'>".$error['hash']."</p>";
	}
?>

<input type="password" class="pass" name="hash" placeholder="create password"/>


 
 </div>
 
 <div id="submit">
<button type="submit" name="submit"> create </button>
</div>

</form>
</div>
 
</body>
</html>