<style>

#container{
	flex-direction:column;
	align-items:center;
	display:flex;
	}
	
table{
	width:35%;
	height:30%;
	
	margin-top:4%;
	margin-left:5px;
	}

h2{
	margin-top:3%;	
	}
	td{
		font-size:24px;	
	}

</style>

<?php
session_start();

include('../includes/db.php');
include('../students/user_auth.php');


//die(var_dump($current));	

$statement =$conn->prepare("SELECT * FROM students WHERE students_id = :students_id");
$statement->bindParam(":students_id",$_SESSION['students_id']);
$statement->execute();

$current_users_data = $statement->fetch(PDO::FETCH_BOTH);

$stmt = $conn->prepare("SELECT * FROM department WHERE department_id = :did");
$stmt->bindParam(":did",$current_users_data['student_department_id']);
$stmt->execute();
$current = $stmt->fetch(PDO::FETCH_BOTH);

if($statement->rowCount()<1){
header("Location:login.php?error=This record doesnt exist on our system");	
	exit();
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Dashboard</title>
</head>

	<?php include ('../students/header.php'); ?>
    
<body>

<div id="container">

 <?php if (isset($current_users_data['name'])) : ?>
        <h2 id="h2">Welcome, <?php echo $current_users_data['name']; ?></h2>
        <table>
            <tr>
                <td>Name:</td>
                <td><?php echo $current_users_data['name']; ?></td>
            </tr>
            <tr>
                <td>Matric Number:</td>
                <td><?php echo $current_users_data['matric_number']; ?></td>
            </tr>
            <tr>
                <td>Department:</td>
                <td><?php echo $current['department_name']; ?></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><?php echo $current_users_data['gender']; ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $current_users_data['email']; ?></td>
            </tr>
        </table>
    <?php endif; ?>
    <br>
    
    </div>
</body>
</html>