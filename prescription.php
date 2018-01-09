 
	
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
		 $prescription_id = 0;
$count = 1;

foreach ($_POST as $item){	
	
	   $man_no = $_SESSION['man_number'];
 $query = "INSERT INTO prescription ( `Patient_Id`, `Date`, `Prescriber's_Id`, `child_no`, `Handled`) VALUES ('".$_POST['pNumber']."', curdate(), '$man_no', NULL, '0')";
	 	 $result = queryMysql($query);
		 		if( $result){
					echo "prescription successfully added";
					}	   
			 }   //end of for loop
		 }//end of if
		 
 ?>




