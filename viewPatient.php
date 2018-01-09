<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>
<?php include 'configuration/form_validation.php'; ?>
<?php include 'configuration/pagination.php'; ?>
<?php
// start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
    }
    
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
        
        //retrieve patients details
        $list_patientSQL = "select * from Patient where Patient_Id='".$_REQUEST['id']."'";
        $list_patientSQLResult = mysql_query($list_patientSQL);
        $details = mysql_fetch_array($list_patientSQLResult);
        
        //fetch medical history for particular patient
        $medical_historySQL = "select p.f_name,p.l_name,pd.date,pd.bp,pd.temp,pd.weight,
            pd.diagnosis
            from Patient p, Patient_Diagnosis pd 
            where p.Patient_Id = pd.patient_id 
            and pd.patient_id='".$_REQUEST['id']."'";
        
        $medical_historySQLResult = mysql_query($medical_historySQL) or die("Cannot retrieve mH");
        
        
        //create session for user to be queued
        $_SESSION['patient_id']=$_REQUEST['id'];
		
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Clerk"){
		include 'menu2.php'; 
}
		
   
    ?>

<style type="text/css">
.nodis
{
	display:none;
}
</style>
<script type="text/javascript">
 $(document).ready(function(){
     $(".toggle_patient_form").click(function(){
         $("#patient_form").toggle("slow");
         $("#diagonosis_form").hide("slow");
     });
     $(".toggle_diagonosis_form").click(function(){
         $("#diagonosis_form").toggle("slow");
         $("#patient_form").hide("slow");
     });
 });
</script>

<script type="text/javascript">
    $(function(){
        $(".queue_patient").click(function(){
            var patient_no = $("#patient_no").val();
            
            $.ajax({
               type: "POST",
               url: "queue_patient.php",
               data:{patient_no:patient_no},
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

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Medical_Officer"){
		include 'menu2.php'; 
}
		
    ?>
<br/>
   
<fieldset>
   
    <br/><br/>
    <div >
        
        <div style="font-size:18px; text-align:center; margin-bottom:8px;" class="toggle_patient_form" ><a href="#" style="text-decoration:none;">Patient Information</a></div>

<div id="patient_form" class="nodis">
    <fieldset>
        <legend>Patient Information</legend>
    <form method="post" name="form">
        <table width="665" height="48">
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
                <td align="right">Othername</td>
                <td align="left">
                    <input type="text" name="othernames" id="othernames" value="<?php echo $details['o_name']; ?>" tabindex="3" readonly="readonly"  />
                </td>
                    <td width="145" align="right">Patient No.</td>
                     <td width="178" align="left">
                 <input type="text" name="patient_no" value="<?php echo $details['Patient_Id']; ?>" tabindex="3" readonly="readonly" id="patient_no" />
                 </td>
            </tr>
            <tr>
                <td width="145" align="right">School/Unit</td>
                <td width="178" align="left">
                 <input type="text" name="school" value="<?php echo $details['School']; ?>" tabindex="4" readonly="readonly" />
                 </td>
                 
                 <td width="145" align="right">Department</td>
                 <td width="178" align="left">
                 <input type="text" name="department" value="<?php echo $details['Department']; ?>" tabindex="5" readonly="readonly" />
                 </td>
            </tr>
            <tr>
                <td align="right" >Date Of Birth</td> 
                <td align="left" >
              <input type="text" name="dob" id="date" tabindex="6" value="<?php echo $details['DOB']; ?>" readonly="readonly" />
              </td>
              
              <td align="right">Sex</td>
              <td align="left"><input type="text" name="sex" id="date" tabindex="6" value="<?php echo $details['Sex']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
             <td align="right">Type</td>
              <td><input type="text" name="type" id="date" tabindex="6" value="<?php echo $details['Type']; ?>" readonly="readonly" /></td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" value="Queue Patient" class="queue_patient" />
                </td>
            </tr>
        </table>
</form>
</fieldset>
</div>
        <br/>
<div style="font-size:18px; text-align:center; margin-bottom:8px;" class="toggle_diagonosis_form" ><a href="#" style="text-decoration:none;" >Medical History</a></div>
    <div id="diagonosis_form" class="nodis">
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
    </div>
<br />
                
                <form style="text-align:center" action="searchForPatient.php" method="post">
                <input type="submit" value="Finish" class="button" name="end_patient_search"   /></form> 

</div>
</fieldset>
<?php include 'configuration/footer.php'; ?>
   
       




        
  


 