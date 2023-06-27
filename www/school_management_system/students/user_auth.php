<?php	
if(!isset($_SESSION['students_id'])){
 header("Location:login.php?error=Login is needed to access student page");	
}

?>