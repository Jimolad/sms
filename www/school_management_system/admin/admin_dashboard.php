<style> 
a{text-decoration:black; color:black;}

a:hover{color:black; background-color:skyblue;}

	
	
#nav-bar{
	background:white;
	color:black;
	}

</style>




<?php
session_start();
	
include'../includes/db.php';
include '../includes/admin_auth.php';	

$stmt=$conn->prepare("SELECT * FROM admin WHERE admin_id = :admin_id");
$stmt->bindParam(":admin_id",$_SESSION['admin_id']);
$stmt->execute();

$row=$stmt->fetch();



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Dashboard</title>
</head>

<body>

<div id="nav-bar">
<?php 
include ('../includes/admin_header.php');
?>
</div>

<h2 style="color:black; font-size:28px; font-family:'Times New Roman', Times, serif">Welcome </h2>
<p style="color:black; font-size:25px; font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif">Name : <?=$row['name'] ?></p>

</body>
</body>
</html>