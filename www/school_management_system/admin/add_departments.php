<style>	
h3{
	margin-top:1%;
	
	}
	
input{
	width:auto;
	height:50px;
	border-radius:5px;
	padding-left:20px;
	}
	
.enter{
	height:30px;
	width:auto;
	background:grey;
	}
	
table{
	width:70%;
	height:50%;
	border:1px solid black;
	}
	
	
#container{
	margin-top:5%;
	padding-left:30%;
	}	
	
	
#nav-bar{
	background:white;
	color:black;
	}
	
		
#breadcrumb{
	height:auto;
	width:100%;
	border:1px solid;
	background:grey;	
}

th{
	background-color:grey;
	}

tr{
	text-align:center;
	}

@media( max-width:720px){
	.size {
		font-size:240%;
		}
	}

</style>



<?php
session_start();
include '../includes/db.php';
include '../includes/admin_auth.php';

$errors = array();

if (isset($_POST['submit'])) {
    if (empty($_POST['department_name'])) {
        $errors['department_name'] = "Enter Department";
    }
    
    $departmentName = $_POST['department_name'];
    $statement = $conn->prepare("SELECT * FROM department WHERE department_name = :dn");
    $statement->bindParam(":dn", $departmentName);
    $statement->execute();
    $count = $statement->rowCount();
    
    if ($count > 0) {
        $errors['department_name'] = "Department already exists";
    }

    if (empty($errors)) {
        try {
            $statement = $conn->prepare("INSERT INTO department VALUES (NULL, :dn, NOW(), NOW())");
            $statement->bindParam(":dn", $departmentName);
            $statement->execute();
        
            header("location:add_departments.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            // Uncomment the following line for debugging purposes
            // echo $e->getTraceAsString();
        }
    }
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Departments</title>
</head>

<body>
<div id= "nav-bar">
<?php include ('../includes/admin_header.php'); ?>
</div>

<div id="breadcrumb">
<h3 style="color:black; font-size:25px; font-family:'Times New Roman', Times, serif"; align="center";>Add Department</h3>
</div>
<div id="container">

<form action="" method="post">

<?php if (isset($errors['department_name'])) { ?>
            <p style="color: red;"><?php echo $errors['department_name']; ?></p>
        <?php } ?>
		
		
<p><input type="text" name="department_name" placeholder="Department Name" /><p>

<input type="submit" class="enter" name="submit" value="Enter" />
</form>
<br/>
<table border="2">
<tr>
    <th>Department Name</th>
    <th>Date Created</th>
    <th>Time Created</th>
</tr>
<?php
$select =$conn->prepare("SELECT * FROM department");
$select->execute();
while($row = $select->fetch(PDO::FETCH_BOTH)){
echo "<tr>";
echo "<td>".$row['department_name']."</td>";	
echo "<td>".$row['date_created']."</td>";
echo "<td>".$row['time_created']."</td>";
echo"</tr>";
	}

?>

</table>
</form>
</div>
</body>
</html>