
<?php require_once 'includes/functions.php' ;
      require_once "configuration/header.php";
    
     
      
      // start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
    }

?>

<?php include 'configuration/database.php'; ?>
      


<?php 
//require_once 'includes/userprofile.php';
?>
        

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Clerk"){
		include 'menu2.php'; 
}
		
    ?>
    
    <?php
		//validate that user has logged in first, if not redirect to the login page
    $restrictGoTo = "index.php";
        if (!((isset($_SESSION['username'])))) {   
            $qsChar = "?";
            $referrer = $_SERVER['PHP_SELF'];
            if (strpos($restrictGoTo, "?")) $qsChar = "&";
            if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
              $referrer .= "?" . $_SERVER['QUERY_STRING'];
            $restrictGoTo = $restrictGoTo. $qsChar . "accesscheck=" . urlencode($referrer);
            header("Location: ". $restrictGoTo); 
            exit;
        }
    
    ?>

<fieldset>
<legend>Pending Prescription</legend>

 <?php
 
 echo "<br/>";
 
    $queryName = "SELECT f_name, l_name, Type, pc.prescription_id, date, (year(curdate())-year(dob)) as age , pc.patient_id FROM Patient p, prescription pc WHERE pc.patient_id = p.patient_id and pc.handled = 0 ";
        
		$result1 = queryMysql($queryName);
				
	$resultName = mysql_num_rows($result1);
		if($resultName==0){
			
echo<<<_END
	
	  <div id="head" >
                        <table border="0" class="gradienttable" width="760" align="center">
            <tr>
                <th width="90" height = "50">Currently there are no pending prescritions!</th>               
                
            </tr>    
        </table>	
	 </div>
_END;

			}
		else {
echo<<<_END
	
	  <div id="head" >
                        <table border="0" class="gradienttable" width="760" align="center">
            <tr>
                <th width="90" height = "50">Please click on the name to see the prescription.</th>               
                
            </tr>    
        </table>	
	 </div>
_END;
	//echo "<div>" . "<br/>"."</div>";
	
	
echo<<<_END
 
<form method = "post"  action = "pending_prescription.php" >
_END;
			for($i=0; $i<$resultName; ++$i )
			{
     $num = $i+1;
$row = mysql_fetch_row($result1);

 
echo <<<_END
		   <input type="button" name="search" value="$num:$row[0] $row[1]" class="button" onclick="toggle($row[3])";/>
_END;

echo "<div  id = \"$row[3]\" style=\"display:none;\"> ";

echo <<<_TAB
  
	<table  class="gradienttable" cellpadding="20px">
	
	   <tr>
                <th width = "300" height = "30">Name : $row[0] $row[1] </th>
                <th width = "200">Category : $row[2]</th>
                <th width = "200">Date : $row[4]</th>
                <th width = "150">Age : $row[5] yrs </th>
                <th width = "200">Prescription Id : $row[3]</th>
            </tr>
			</table>
_TAB;
 
 echo "<br/>";
 
echo <<<_TAB
	<table  class="gradienttable" cellpadding="20px">
	
	   <tr>
                <th width = "100" height = "40">Formulation   </th>
                <th width = "150">Drug </th>
                <th width = "100">Dosage </th>
                <th width = "100">Frequence </th>
                <th width = "100">Given </th>
				 <th width = "100">Quantity </th>
            </tr>
			
_TAB;
 $queryDetails = "SELECT DISTINCT  dosage, frequency, formulation, item_name, item_id FROM  prescription_items pi, pharmacy_stock ps, prescription pc WHERE            pi.prescription_id = '$row[3]' and ps.item_id = pi.drug_no  ";
 

$result2 = queryMysql($queryDetails);

$resultDetails = mysql_num_rows($result2);
		
	
			for($j=0; $j<$resultDetails; ++$j )
			{
$rowd = mysql_fetch_row($result2);
$drug_no[] = $rowd[4];
echo <<<_END
    				
			<tr>
                <td >$rowd[2]  </td>
                <td >$rowd[3] </td>
                <td >$rowd[0]  </td>
                <td >$rowd[1]  </td>
                <td >Y <input type = "radio" name = "$j" value = "yes"/> No <input type = "radio" name = "$j" value = "no"/>  </td>
				 <td ><input type ="text" name = "quantity" size = "2px"> </td>
            </tr>
			
			
_END;
		       }

echo <<<_END
<tr><td colspan = "6"> <input type= "submit" value = 'Done'><td></tr>
 </table> 
<div id = "button" style = " position:relative; left :50px;" >
<input type= "hidden" name = 'update' value = 'yes'>
<input type= "hidden" name = 'prescription_id' value = '$row[3]'>
<input type= "hidden" name = 'patient_id' value = '$row[6]'>
<input type= "hidden" name = 'total_drugs' value = '$resultDetails'>
</div>
</form>
_END;
			echo  ""."</div>";
			echo "<div>" . "<br/>"."</div>";
			}			
		}
		
    ?>       
    
    
    <script type="text/javascript" language="javascript"> 
    
  function toggle(id){
	 var e = document.getElementById(id);
	  if (e.style.display=="block"){
		  e.style.display="none";
		  }
		  else  {
			  e.style.display="block";
			  }
	  
	  }
    </script>  	

<?php 

    if(isset($_POST['update'])&&isset($_POST['prescription_id']))
	{
	  $id = get_post('prescription_id');
      $queryUpdate = "update prescription set handled = 1 where prescription_id = '$id'";
	  if (queryMysql($queryUpdate))
	  {
	  echo "This prescription of $id has been done";
	  echo "update successful";
	   }
		 $resultTotal = get_post('total_drugs');//get the total number of drugs given to a patient
		 
       for ($t =0; $t<$resultTotal; $t++){
		   if (isset($_POST[$t])&&($_POST[$t]=="yes")){
			  
			   $quantity = get_post('quantity');//quantity given to patient
			   $drgn = $drug_no[$t];
			   $query_amount = "select charge_per_unit from pharmacy_stock where item_id = $drgn";
			   $result_amount = queryMysql($query_amount );
			   $row_amount = mysql_fetch_row($result_amount);
			   $amount = $row_amount[0];
			   $cost = $amount * $quantity ;
			   $pid = get_post('prescription_id');
			   
			   //iterm name to be entered on a payment ticket
			    $item_name = get_post('drug');
				
			  $updatePres = "update prescription_items set given = 'yes', cost = '$cost', quantity = '$quantity' where prescription_id                 = $pid and drug_no = $drgn ";
			  $result_update_pres =  queryMysql($updatePres);
			   $updateDisp = "update dispensary set quantity_in_stock = quantity_in_stock - $quantity  where drug_no = $drgn ";
			  $result_update_disp =  queryMysql($updateDisp);
			  
				
			   if($result_update_disp&&$result_update_pres){
				   echo "<div>Update Successful</div>";
				   }
		      }
			   
			  
			   elseif(isset($_POST[$t])&&($_POST[$t]=="no"))
			   {
				     $pid = get_post('prescription_id');
				     $drgn = $drug_no[$t];
				   $query_not_given ="update prescription_items set given = 'no'  where prescription_id = $pid and drug_no = $drgn ";
				   queryMysql($query_not_given);
				   }
		   }		   
		  //reload the page 
		   header('Location: pending_prescription.php');
		    }
?>
	

 
 
</fieldset>
<?php require_once "configuration/footer.php"; ?>
