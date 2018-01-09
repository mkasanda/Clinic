
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
	   $sql= "Select Prescription_Id from prescription order by Prescription_Id desc";
    $presult = mysql_query($sql);
    
    $details = mysql_fetch_array($presult);
	$pNumber=$details['Prescription_Id'];
		 
		  $query = "INSERT INTO `prescription_items` (`Prescription_Id`, `Drug_No`, `Dosage`, `Frequency`, `formulation`) VALUES 								($pNumber, '".$_POST['drug']."', '".$_POST['dosage']."', '".$_POST['frequency']."', '".$_POST['formulation']."')";
	  $result = queryMysql($query) ;
	    
		 
		 $_SESSION['count']=2;
	   
			 }   //end of for loop
			 
			 
	        echo "prescription successfully added";
			
  
		 }//end of if
		 
	 
 
 ?>




