<?php require_once 'includes/functions.php' ;
      require_once 'configuration/header.php';
?>
<?php
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
<legend>Search Prescription</legend>



<form action="search_prescription.php" method="post">
<p> <h2> Search for a Prescription </h2> </p>
<p> <h4> Please enter the last name or surname  </h4> </p>
<input type="text" name="search"  />
<input type="submit" value="Search"  />
</form>

<?php
       if(isset($_POST['search'])) {
         $search_id = get_post('search');
		   
    $queryName = "SELECT f_name, l_name, type, pc.prescription_id, date, (year(curdate())-year(dob)) as age , pc.patient_id FROM Patient p, prescription pc WHERE pc.patient_id = p.patient_id and p.l_name = '$search_id'";
        
		$result1 = queryMysql($queryName);
				
	$resultName = mysql_num_rows($result1);
		if($resultName==0){
			
echo "<div id=\"head\" style =\"text-shadow: 0px 0px 20px rgba(0,0,0,5); color : blue; background-color:#CF3;box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 5px; width:100; border: 1px solid blue;\";> 
	<table  >
    		<tr>
                 <td> <h2>Sorry no results matches you search</h2>
                 </td>
       		</tr>
    </table>  
	 </div>";

			}
		else {
	
	echo " <h2>Please click on the name to see the prescription.</h2>";
	 
	 	echo "<div>" . "<br/>"."</div>";	
 
for($i=0; $i<$resultName; ++$i )
			{
     $num = $i+1;
$row = mysql_fetch_row($result1);

echo "<div  id=\"name\" onclick=\"toggle($row[3]);\"  style=\" color : blue; background-color:#CF3; border: 1px solid blue; box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 10px;\">";
 echo "<table> <tr> <td>  $num:</td> <td> $row[0]</td> <td> $row[1]</td> </tr> </table> </div>";

echo "<div  id = \"$row[3]\" style=\"display:none;  color : blue; background-color:#CF3; border: 1px solid blue; box-shadow: 0px 0px 20px rgba(0,0,0,5); border-radius: 10px;\"> ";
echo  "___________________________________________________";
echo <<<_TAB
  
	<table width = "300px" >
    		<tr>
                 <td> <p> Name : $row[0] $row[1] </p> 
                   	   <p> Category : $row[2] </p>
                       <p> Date : $row[4] </p>
					   <p> Age : $row[5] yrs </p>
                 </td>
                 <td> <p> Prescription Id : $row[3] </p>   	   
                 </td>
       		</tr>
    </table>  
_TAB;
echo  "___________________________________________________";
 $queryDetails = "SELECT DISTINCT  dosage, frequency, formulation, item_name, item_id, handled FROM  prescription_items pi, pharmacy_stock ps, prescription pc WHERE pi.prescription_id = '$row[3]' and ps.item_id = pi.drug_no  ";
 

$result2 = queryMysql($queryDetails);

$resultDetails = mysql_num_rows($result2);
		
	
	  for($j=0; $j<$resultDetails; ++$j )
	      {
$rowd = mysql_fetch_row($result2);
$drug_no[] = $rowd[4];
echo <<<_END
	<table cellspacing = "20px">
    		<tr>
                 <td>  <p> Formulation  : $rowd[2] </p> 
				       <p> Drug : $rowd[3] </p> 
                   	   <p> Dosage : $rowd[0] </p>
                       <p> Frequence : $rowd[1] </p>			   
                 </td>
       		</tr>
    </table>  
_END;
echo "-------------------------------------------------------------------------" . "<br/>";
		       }

			echo  ""."</div>";
			echo "<div>" . "<br/>"."</div>";
			}			
		}
		
	}
    ?>

      </fieldset>
<?php require_once "configuration/footer.php"; ?>

