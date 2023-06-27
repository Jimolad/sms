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

if(isset($_GET['staff_id'])){
$staff_id =$_GET['staff_id'];	

}else{
	header("Location:manage_staff.php");
}



$statement= $conn->prepare("SELECT * FROM staff WHERE staff_id=:sid");
$statement->bindParam(":sid",$staff_id);
$statement->execute();

$record= $statement->fetch(PDO::FETCH_BOTH);
if($statement->rowCount()< 1){
header("location:edit_staff.php");	
exit();
}

if(isset($_POST['submit'])){
	
	$error = array();
	
	if(empty($_POST['name'])){
		$error['name'] = "NAME";
	}
	
	if(empty($_POST['department_id'])){
		$error['department_id'] = "DEPARTMENT";
	}
	
	if(empty($_POST['address'])){
		$error['address'] = "ADDRESS";
	}
	
	if(empty($_POST['email'])){
		$error['email'] = "EMAIL";
	}
	
	if(empty($error)){
		$statement=$conn->prepare("UPDATE staff SET name=:nm,department_id=:did,address=:add,email=:em WHERE staff_id=:sid");
	$statement->bindParam(":nm",$_POST['name']);
	$statement->bindParam(":did",$_POST['department_id']);
	$statement->bindParam(":add",$_POST['address']);
	$statement->bindParam(":em",$_POST['email']);
	
	$statement->bindParam(":sid",$staff_id);
		
	$statement->execute();
		

	header("Location:manage_staff.php");
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
<br />
<div id="container">
 <form action="" method="post">
 <p>Name</p>
        <input type="text" name="name" placeholder="Name" value="<?= $record['name'] ?>" /><br />
        <?php if(isset($errors['name'])): ?>
            <span style="color: red"><?= $errors['name'] ?></span><br />
        <?php endif; ?>
 
 <p>Department</p>       

       <select name="department_id">
    <?php
    $select = $conn->prepare("SELECT * FROM department");
    $select->execute();
    
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
        $selected = ($row['staff_name'] == $record['department_id']) ? 'selected' : '';
        echo "<option value='" . $row['department_id'] . "' $selected>" . $row['department_name'] . "</option>";
    }
    ?>
</select><br />
 

<?php if (isset($errors['department_id'])): ?>
    <span style="color: red"><?= $errors['department_id'] ?></span><br />
<?php endif; ?>

   <p>Address</p> 
    <input type="text" name="address" placeholder="address" value="<?= $record['address'] ?>" /><br />
<?php if(isset($errors['address'])): ?>
    <span style="color: red"><?= $errors['address'] ?></span><br />
<?php endif; ?>


<p>Email</p>
 <input type="text" name="email" placeholder="email" value="<?= $record['email'] ?>" /><br />
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
