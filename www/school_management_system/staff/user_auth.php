<?php	
if(!isset($_SESSION['email'])){
 header("Location:login.php?error=Login is needed to access staff page");	
}

?>

