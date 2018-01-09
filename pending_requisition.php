
<?php require_once 'includes/functions.php' ;
      require_once "configuration/header.php";
    
     
      
      // start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
    }

?>
<?php include 'configuration/database.php'; ?>

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Clerk"){
		include 'menu2.php'; 
}
		
    ?>


<fieldset>
<legend>Pending Requisition</legend>
 	

 <?php
 
  
    $queryName = "select f_name, l_name, requistion_id, date_requisitioned from Requisition r, users s where r.handled = 0 and r.requisitioned_by=s.man_no";
        
		$result1 = queryMysql($queryName);
				
	$resultName = mysql_num_rows($result1);
		if($resultName==0){
echo "<div id=\"head\" style =\"text-shadow: 0px 0px 20px rgba(0,0,0,5); color : blue; background-color:#CF3;box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 5px; width:100; border: 1px solid blue;\";> 
	<table  >
    		<tr>
                 <td> <h2>Currently there are not Requisitions Pending!</h2>
                 </td>
       		</tr>
    </table>  
	 </div>";

			}
		else {
	echo "<div id=\"head\" style =\"text-shadow: 0px 0px 20px rgba(0,0,0,5); color : blue; background-color:#CF3;box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 5px; width:100; border: 1px solid blue;\";> 
	<table  >
    		<tr>
                 <td> <h2>Please click on the number to see the requisition.</h2>
                 </td>
       		</tr>
    </table>  
	 </div>";
	echo "<div>" . "<br/>"."</div>";		
			for($i=0; $i<$resultName; ++$i )
			{
     $num = $i+1;
$row = mysql_fetch_row($result1);

echo "<div  id=\"name\" onclick=\"toggle($row[2]);\"  style=\" color : blue; background-color:#CF3; border: 1px solid blue; box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 10px;\">";
 echo "<table> <tr> <td>  Requisition :</td><td>  $num</td>  </tr> </table> </div>";

echo "<div  id = \"$row[2]\" style=\"display:none;  color : blue; background-color:#CF3; border: 1px solid blue; box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 10px;\"> ";
echo  "___________________________________________________";
echo <<<_TAB
  <form method = "post"  action = "pending_requisition.php">
	<table width = "300px" >
    		<tr>
                 <td> <p> Requisitioned By : $row[0] $row[1] </p> 
                   	   <p> Requisition Id  : $row[2] </p>
                       <p> Date Issued: $row[3] </p>
                 </td>
       		</tr>
    </table>  
_TAB;
echo  "___________________________________________________";
 $queryDetails = "select distinct item_name, quantity_required, rt.item_no from requistion_items rt, pharmacy_stock p where p.item_id=rt.item_no and rt.requistion_id = $row[2]";
 

$result2 = queryMysql($queryDetails);

$resultDetails = mysql_num_rows($result2);
		
	
			for($j=0; $j<$resultDetails; ++$j )
			{
$rowd = mysql_fetch_row($result2);
 $itemDetails [] = $rowd[2]; 
echo <<<_END
	<table>
    		<tr>
			     <td>  
				       <p> Item : $rowd[0] </p> 
                   	   <p> Amount Required : $rowd[1] </p>                       
                 </td>   <td> &nbsp&nbsp&nbsp    </td> <td> <p> Given </p>  
					   <p> Y <input type = "radio" name = "$j" value = "yes"/> No <input type = "radio" name = "$j" value = "no"/> </p> 	   
                 </td>
				 <td><p>Quantity</p>
				 <p><input type ="text" name = "quantity" size = "2px"></p>
				 </td>
       		</tr>
    </table>  
_END;
echo "-------------------------------------------------------------------------" . "<br/>";
		       }
echo <<<_END
<input type= "hidden" name = 'update' value = 'yes'>
<input type= "hidden" name = 'requisition_id' value = '$row[2]'>
<input type= "hidden" name = 'total_items' value = '$resultDetails'>
<input type= "submit" value = 'Done'>
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

    if(isset($_POST['update'])&&isset($_POST['requisition_id']))
	{
	  $id = get_post('requisition_id');
      $queryUpdate = "update requisition set handled = 1 where requistion_id = '$id'";
	  if (queryMysql($queryUpdate)){
	  echo "This prescription of $id has been done";
	  echo "update successful $id";
	  // header('Location: http://localhost/emr/pending_requisition.php');
	   }
	   
	   $resultTotal = get_post('total_items');//get the total number of drugs given to a patient
		 
       for ($t =0; $t<$resultTotal; $t++){
		   if (isset($_POST[$t])&&($_POST[$t]=="yes")){
			  
			   $quantity = get_post('quantity');//quantity given to patient
			   $itn = $itemDetails[$t];
			   $rid = get_post('requisition_id');
			   				
	 $updatePres = "UPDATE requistion_items SET Quantity_Issued = $quantity, status = 1 WHERE requistion_id = $rid and Item_No = $itn";
			  $result_update_pres =  queryMysql($updatePres);
			  echo "1";
			   $updateDisp = "update dispensary set quantity_in_stock = quantity_in_stock + $quantity  where drug_no = $itn ";
			  $result_update_disp =  queryMysql($updateDisp);
			    echo "2";
			  $updatePharm = "UPDATE pharmacy_stock SET Quantity_In_Stock=Quantity_In_Stock - $quantity WHERE item_id=$itn ";
				$result_update_pharm =  queryMysql($updatePharm);
				  echo "3";
			   if($result_update_disp&&$result_update_pres&&$result_update_pharm ){
				   echo "<div>Update Successful</div>";
				   }
		      }			  
		elseif(isset($_POST[$t])&&($_POST[$t]=="no"))
			   {
				     $pid = get_post('requisition_id');
				     $drgn = $drug_no[$t];
		  $updatePres = "UPDATE requistion_items SET Quantity_Issued = 0, status = 1 WHERE requistion_id = $rid and Item_No = $itn";
			  $result_update_pres =  queryMysql($updatePres);
				   }
		   	   
		  //reload the page 
		   header('Location: pending_prescription.php');
		    }
	  }
	  
	  
?>
	
       </fieldset>
<?php require_once "configuration/footer.php"; ?>
