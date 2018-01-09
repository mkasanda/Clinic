<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php';
require_once 'includes/functions.php' ;
 ?>
<?php
    // start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
        
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
    }
        

    
    $editFormAction = $_SERVER['PHP_SELF'];
    $error="";
    $success="";
?>

<?php 
$pNumber=0;
if(isset($_POST['search'])){
    
    //call first patient for
    $pick_next_patientSQL = "SELECT p.Patient_Id, p.f_name, p.l_name, p.Type, pa.time_in,pa.date 
        FROM patient_queue pa, Patient p 
        WHERE pa.patient_id = p.Patient_Id AND pa.status =0 
        ORDER BY pa.time_in 
        LIMIT 0 , 1";
    $pick_next_patientResult = mysql_query($pick_next_patientSQL);
    $num = mysql_num_rows($pick_next_patientResult);
    $details = mysql_fetch_array($pick_next_patientResult);
	$pNumber=$details['Patient_Id'];
    
//pull medicall history for called patient
    $medical_historySQL = "select p.f_name,p.l_name,pd.date,pd.bp,pd.temp,pd.weight,
            pd.diagnosis
            from Patient p, Patient_Diagnosis pd 
            where p.Patient_Id = pd.patient_id 
            and pd.patient_id='".$details['Patient_Id']."'";
        
        $medical_historySQLResult = mysql_query($medical_historySQL) or die("Cannot retrieve mH");
} ?>


<?php 

//call next available patient
   if(isset($_POST['next']) && ($_POST["MM_next"] == "nextPatient")){
    $updateSQL = "update patient_queue set time_out='".date("H:i")."', status='1' where patient_id='".$_POST['patient_no']."' and time_in='".$_POST['time_in']."'";
    $updateResult = mysql_query($updateSQL) or die(mysql_error());
        
    
    $pick_next_patientSQL = "SELECT p.Patient_Id, p.f_name, p.l_name, p.Type, pa.time_in,pa.date 
        FROM patient_queue pa, Patient p 
        WHERE pa.patient_id = p.Patient_Id AND pa.status ='0' 
        ORDER BY pa.time_in 
        LIMIT 0 , 1";
    $pick_next_patientResult = mysql_query($pick_next_patientSQL);
    $num = mysql_num_rows($pick_next_patientResult);
    $details = mysql_fetch_array($pick_next_patientResult);
	
    
    //pull medicall history for called patient
    $medical_historySQL = "select p.f_name,p.l_name,pd.date,pd.bp,pd.temp,pd.weight,
            pd.diagnosis,pd.patient_id
            from Patient p, Patient_Diagnosis pd 
            where p.Patient_Id = pd.patient_id 
            and pd.patient_id='".$details['Patient_Id']."'";
        
        $medical_historySQLResult = mysql_query($medical_historySQL) or die("Cannot retrieve mH");
    
} ?>

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Clerk"){
		include 'menu2.php'; 
}
		
    ?>
<div id="botBody">
    
<script type="text/javascript" >
  $(document).ready(function()
    {
        $(".view_history").click(function(){
            $("#show_history").toggle('slow');
            $("#medical_form").hide('slow');
			 $("#prescription_form").hide('slow');
        });
        
        $(".show_medical").click(function(){
            $("#medical_form").toggle('slow');
            $("#show_history").hide('slow');
			 $("#prescription_form").hide('slow');
        });
		
		     $(".show_prescription").click(function(){
		    $("#prescription_form").toggle('slow');
            $("#medical_form").hide('slow');
            $("#show_history").hide('slow');			
        });
        
        //load date from JQuery
        window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"date",
			dateFormat:"%d-%m-%Y"
		});
	};
    });
</script>


<script type="text/javascript">
    $(function(){
        $(".submit").click(function(){
            
           var bp = $("#bp").val();
           var temp = $("#temp").val(); 
           var weight = $("#weight").val(); 
           var patient_no = $("#patient_no").val(); 
           var complaints = $("#complaints").val(); 
           var date = $("#date").val();
           
           $.ajax({
               type: "POST",
               url: "newRecord.php",
               data: {bp:bp,temp:temp,weight:weight,complaints:complaints,date:date,patient_no:patient_no},
               success: function(data,textStatus,xhr){
                  alert(data);
               },
               error:function(xhr,textStatus,error){
           
                alert(error);
               }
               
               
               
               
           });
           return false;
        });
    });
</script>

<?php $_SESSION['count'] = 0; //added by Reuben to send prescription data ?>
<script type="text/javascript">
    $(function(){
        $(".submit_prescription").click(function(){
	    
	      var dose = "#dosage"+1;
		 
		  
	   
	 
           var dosage = $(dose).val(); 
		   var pNumber = $("#patient_num").val(); ;
			
           $.ajax({
               type: "POST",
               url: "prescription.php",
               data: {pNumber:pNumber},
               success: function(data,textStatus,xhr){
                  alert(data);
               },
               error:function(xhr,textStatus,error){
           
                alert(error);
               }});
			   
			
	 for(i=1; i<=5; i++){
           var form = "#formulation"+i;
           var drg = "#drug"+i; 
           var freq = "#frequency"+i; 
           var dose = "#dosage"+i;
		  
	   
	  if (($(form).val()!= "") &&  ($(drg).val() !="") && ($(freq).val() != "" )&& ($(dose).val()!="")&&($(drg).val() !="default"))  
	  { var formulation = $(form).val();
           var drug = $(drg).val(); 
           var frequency = $(freq).val(); 
           var dosage = $(dose).val(); 			
			
           $.ajax({
               type: "POST",
               url: "new_prescription.php",
               data: {formulation:formulation,drug:drug,frequency:frequency,dosage:dosage},
               success: function(data,textStatus,xhr){
                  //alert(data);
               },
               error:function(xhr,textStatus,error){
           
               // alert(error);
               }});
	  }
			   } //end for-loop
	  
			   //end for-loop
		

           return false;
        });
    });
</script>




    <fieldset>
        <legend>Pick Next Patient</legend>
        <form action="<?php echo $editFormAction; ?>" method="POST" name="addUser" id="addUser_form" enctype="multipart/form-data">
            <?php if(!isset($details)){ ?>
            <input type="submit" name="search" value="Call Patient" class="button" />
        </form> 
            <?php }else if($details && $num == 1){ ?>
        <form action="<?php echo $editFormAction; ?>" method="POST" name="addUser" id="addUser_form" enctype="multipart/form-data">
            <table>
                 <tr>
                <td width="113" align="right">Firstname</td>
                <td width="198" align="left">
               <input type="text" name="fname" value="<?php echo $details['f_name']; ?>" tabindex="1" readonly="readonly" />
            </td>
            <td width="145" align="right">Lastname</td>
               <td width="178" align="left">
                 <input type="text" name="lname" value="<?php echo $details['l_name']; ?>" tabindex="2" readonly="readonly" />
               </td>
            </tr>
            <tr>
                <td align="right">Type</td>
                <td align="left">
                    <input type="text" name="othernames" id="othernames" value="<?php echo $details['Type']; ?>" tabindex="3" readonly="readonly"  />
                </td>
                    <td width="145" align="right">Patient No.</td>
                     <td width="178" align="left">
                 <input type="text" name="patient_no" value="<?php echo $details['Patient_Id']; ?>" tabindex="3" readonly="readonly" />
                 </td>
            </tr>
            <tr>
                <td align="right">Queued At:</td>
                <td align="left">
                    <input type="text" name="time_in" id="othernames" value="<?php echo $details['time_in']; ?>" tabindex="3" readonly="readonly"  />
                </td>
                    <td width="145" align="right">On:</td>
                     <td width="178" align="left">
                 <input type="text" name="date" value="<?php echo $details['date']; ?>" tabindex="3" readonly="readonly" />
                 </td>
            </tr>
            <tr></tr><tr></tr>
            <tr>
                <input type="hidden" name="MM_next" value="nextPatient" />
                <td><input type="submit" name="next" value="Call Next Patient" class="button" /></td>
                <td><b>OR</b></td>
                <td title="View Medical History" >
                      <input name="view_history"  type="checkbox" name="show_history" class="view_history" /> <b>Medical History</b>
                </td>
            </tr>
           
            
            </table>
            <br />
               
       <div id="show_history" style="display: none;">
                        <table border="0" class="gradienttable" width="760" align="center">
            <tr>
                <th width="90">Date</th>
                <th width="70">BP Reading</th>
                <th width="80">Temp Reading</th>
                <th width="50">Weight</th>
                <th width="300">Diagnosis</th>
                
            </tr>
            <?php while($medical_history = mysql_fetch_array($medical_historySQLResult)){ ?>
            <tr>
                <td><?php echo $medical_history['date']; ?></td>
                <td><?php echo $medical_history['bp']; ?></td>
                <td><?php echo $medical_history['temp']; ?></td>
                <td><?php echo $medical_history['weight']; ?></td>
                <td><?php echo $medical_history['diagnosis']; ?></td>
                
            </tr>
            
            <?php } ?>
        </table>
           <br />
           <table>
               <tr>
                <td title="View Medical History" >
                      <input name="view_history"  type="checkbox" name="show_medical_form" class="show_medical" /> <b>New Medical Record</b>
                </td>
            </tr>
           </table>
     </div>
      <div id="medical_form" style="display: none;">
          <fieldset>
              <legend>New Medical Record</legend>
        <form name="form" method="post">
          <table>
            <tr>
             <td width="113" align="right">Blood Pressure:</td>
            <td width="198" align="left">
               <input type="text" id="bp" style="width: 60px;" />
            </td>
            
                <td width="113" align="right">Temperature:</td>
                <td width="198" align="left">
               <input type="text" id="temp" style="width: 60px;" />
            </td>
            </tr>
            <tr>
              <td align="right" title="Format of Date is YYYY-MM-DD">Date:</td>
              <td align="left"  title="Format of Date is YYYY-MM-DD" >
              <input  type="text" name="date" id="date" readonly="readonly" /></td>
              
              <td width="113" align="right">Weight:</td>
                <td width="198" align="left">
               <input type="text" id="weight" style="width: 60px;" />
            </td>
            </tr>
            <tr>
                <td width="113" align="right">Diagnosis:</td>
                <td width="198" align="left">
                    <textarea style="width: 300px; height: 80px;" id="complaints"></textarea>
            </td>
            <td width="113" align="right">Patient No.:</td>
            <td width="198" align="left">
               <input type="text" id="patient_no" value="<?php echo $pNumber ?>" />
               
            </td>
            
            </tr>
            <tr></tr><tr></tr>
            
            <tr>
                <td colspan="3"><input type="submit" value="Add New Record" class="submit"/>
                <span class="error" style="display:none"> Please Enter Valid Data</span>
                <span class="success" style="display:none"> Record added Successfully</span></td>
            <td title="Issue Prescription" >
            <input name="issue_prescription"  type="checkbox" name="show_prescription_form" class="show_prescription" /> <b>Issue Prescription</b>
             </td>
            </tr>
          </table>
            
       </form>
</fieldset>
         
     </div>      
             
       <div id="prescription_form" style="display: none;">
          <fieldset>
              <legend>Issue Prescription</legend>
        <form name="form" method="post">
          <table>
            <tr><td> No. </td><td>Formulation</td><td> Drug </td> <td> Frequency </td> <td>Dosage</td> 
            </tr>
            <?php 
  
   for ($k=1; $k<=5; $k++){
	      $formulation = "formulation".$k;
		  $drg= "drug".$k;
		  
echo "<tr><td>$k.</td> <td><input type=\"text\""."name="."\"$formulation\""." id=".$formulation."></td> <td><select id=".$drg." name="."\"$drg\""."><option value=\"default\"> Select </option>";

 $query = "SELECT  item_id, item_name FROM pharmacy_stock where type = 'drugs'";	 	
		$result = queryMysql($query);
		 
		if($result){
		 $rows = mysql_num_rows($result);
		 
		 for($j=0; $j<$rows; $j++)
		 {
		$row = mysql_fetch_row($result);
		echo "<option value = \"$row[0]\"> $row[1] </option>";
		
		 }
		 
		}
		$dose = "dosage".$k;
		$freq = "frequency".$k;
echo
		" <td><input type='text' name='$freq' id=".$freq." > </td> <td><input type='text' name='$dose' id=".$dose." > </td></tr>";
   }
   ?>
   <tr>
   <td colspan="5"> <input type="submit" value="Submit Prescription" class="submit_prescription"/> 
   <input type="hidden" value="<?php echo $pNumber ; ?>" id="patient_num" />
   <td>
   <tr>
   
          </table>
            
       </form>
</fieldset>
         
     </div>
            
            
        </form>
        <?php }  else {
                echo "<img src='img/red-error.gif' />"."  No Patients In Queue Currently";
            } ?>
    </fieldset>
</div>

<?php include 'configuration/footer.php'; ?>