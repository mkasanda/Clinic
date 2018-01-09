<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>
<?php include 'configuration/form_validation.php'; ?>
<?php include 'configuration/pagination.php'; ?>
<?php
// start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $error="";
    $success="";
    $editFormAction = $_SERVER['PHP_SELF'];
    
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

<?php if(isset($_POST['queue_patient'])){
    //pull current online users
    $med_officer = "select * from users where status='1'";
    $med_officerResult = mysql_query($med_officer) or die();
    
} ?>


<?php 
    //queue patient
if ((isset($_POST["MM_queue"])) && ($_POST["MM_queue"] == "queuePatient")) {
    $queue_patient = "insert into patient_queue (patient_id,time_in,date,status,man_no) values('".$_SESSION['patient_id']."','".  date("H:i")."','".date("Y-m-d")."','0','".$_POST['med_officer']."')";
    $queue_patientResult = mysql_query($queue_patient);
    
    if(mysql_error()){
            unset($_POST);
            $error="<img src='img/red-error.gif' />".mysql_error();
        }else{
            $success = "<img src='img/green-ok.gif' />"."Patient Queued Succesfully!!";
        }
}
?>

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Medical_Officer"){
		include 'menu2.php'; 
        }	
    ?>
<div id="botBody">
    <fieldset>
        <legend>Queue Patient</legend>
        <?php echo ($error==""?"<h4 class=\"green\">".$success."</h4>":"<h4>".$error."</h4>"); ?>
        <form action="<?php echo $editFormAction; ?>" method="POST" >
            <table width="665" height="48">
                <tr>
                    <td width="113" align="right">Select Medical Officer:</td>
                    <td width="198" align="left">
                        <select name="med_officer">
                            <?php
                                while ($list_medRow = mysql_fetch_array($med_officerResult)){
                            ?>
                            <option value="<?php echo $list_medRow['man_no']; ?>"><?php echo $list_medRow['f_name']; echo " "; echo $list_medRow['l_name']; ?></option>
                            <?php } ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    
			 <tr><td colspan="20"><input type="submit" value="Queue Patient" name="submit" align="center"></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>

<?php include 'configuration/footer.php'; ?>