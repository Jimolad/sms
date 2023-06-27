<style>

#container{
	margin-left:40%;
	height:40%;
	}
	
table{
	width:40%;
	
	margin-top:3%;
	margin-left:0%;
	}


h2{
	margin-top:8%;	
	}
	
td{
	height:60px;

	}
</style>




<?php
session_start();

include('../includes/db.php');
include('../staff/user_auth.php');
	

$statement =$conn->prepare("SELECT * FROM staff WHERE email = :em");
$statement->bindParam(":em",$_SESSION['email']);
$statement->execute();
$current_users_data = $statement->fetch(PDO::FETCH_BOTH);


$stmt = $conn->prepare("SELECT * FROM department WHERE department_id = :did");
$stmt->bindParam(":did",$current_users_data['department_id']);
$stmt->execute();
$current = $stmt->fetch(PDO::FETCH_BOTH);


if($statement->rowCount()<1){
header("Location:login.php?error=This record doesnt exist on our system");	
	exit();
}

//die(var_dump($_SESSION));

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Staff Dashboard</title>
</head>

<body>
<?php 
include '../staff/header.php';
 ?>
 
<div id="container">

 <?php if (isset($current_users_data['name'])) : ?>
        <h2>Welcome,
        
         <?php echo $current_users_data['name']; ?></h2>
        <table>
            <tr>
                <td>Name:</td>
                <td><?php echo $current_users_data['name']; ?></td>
            </tr>
        
            <tr>
                <td>Department:</td>
                <td><?php echo $current['department_name']; ?></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><?php echo $current_users_data['gender']; ?></td>
            </tr>
             <td>Phone Number:</td>
                <td><?php echo $current_users_data['phone_number']; ?></td>
            </tr>
            
            <tr>
                <td>Email:</td>
                <td><?php echo $current_users_data['email']; ?></td>
            </tr>
        </table>
    <?php endif; ?>

 </div>  
</body>
</html>