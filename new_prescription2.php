
<?php require_once 'includes/functions.php' ;

// start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
    }

?>
<?php include 'configuration/database.php'; ?>


<?php 
//first if stmt
 if($_POST)
    {	

print_r ($_POST);			
  
		 }//end of if
		 
	 
 
 ?>




