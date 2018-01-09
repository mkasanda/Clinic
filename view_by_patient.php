<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>
<?php
// start session for this pasrticular user
    if (!isset($_SESSION)) {
        session_start();
    }
    
    $error="";
    $success="";
    
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
       
        $editFormAction = $_SERVER['PHP_SELF'];
?>

<?php
    if(isset($_POST['MM_search']) && $_POST['MM_search']=="MM_search" && $search!=NULL){
        $searchSQL = "select * from Patient where Patient_Id like '".$_POST['search']."%' || f_name like '".$_POST['search']."%' || l_name like '".$_POST['search']."%'";
        $searchSQLResult = mysql_query($searchSQL) or die(mysql_error());
        $total_num = mysql_num_rows($searchSQLResult);
    }
?>

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Clerk"){
		include 'menu2.php'; 
}
		
   ?>
<?php
    //process search query
if(isset($_POST['MM_search']) && $_POST['MM_search']=="MM_search" && $_POST['search']!=NULL){
    $searchSQL = "select * from Patient where Patient_Id like '".$_POST['search']."%' || f_name like '".$_POST['search']."%' || l_name like '".$_POST['search']."%'";
    $searchSQLResult = mysql_query($searchSQL) or die(mysql_error());
    $total_num = mysql_num_rows($searchSQLResult);
}
?>

<script type="text/javascript">

	$(document).ready(function(){
		window.setTimeout(function hide_msg(){$('#result_msg').hide('slow')}, 15000);
	});
</script>

<fieldset>
    <legend>Payment History</legend>
    <form name="search" method="post" action="<?php echo $editFormAction; ?>">
        <input type="text" name="search" value="" title="Enter Student Name or Student Number" />
        <input type="hidden" name="MM_search" value="MM_search" />
        <input type="submit" name="sib" class="search" value="" title="Patient search" />
    </form>


<?php if(isset($searchSQLResult) && isset($total_num)){?>
    <table border="0" class="gradienttable" width="700" align="center">
        <tr>
                    <th width="100">Patient No.</th>
        	    <th width="250">Name</th>
		    <th width="100">School</th>
		    <th width="250">Department</th>
		    <th width="100">Sex</th>
                    <th width="100">Payments</th>
                </tr>
        <?php while($row_patient = mysql_fetch_array($searchSQLResult)){ ?>
              <tr>
                    <td><a href="viewPatient.php?id=<?php echo $row_patient['Patient_Id']; ?>"><?php echo $row_patient['Patient_Id']; ?></a></td>
                    <td><?php echo $row_patient['f_name']; echo " "; echo $row_patient['l_name']; ?></td>
                    <td><?php echo $row_patient['School']; ?></td>
                    <td><?php echo $row_patient['Department']; ?></td>
                    <td><?php echo $row_patient['Sex']; ?></td>
                    <td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
         <input class='button_to_link' type='submit' value='View All Payments' name='view_student_pay' />
         <input type='hidden' value="<?php echo $row_patient['Patient_Id']; ?>" name='patient_id' />
		 <input type='hidden' value="<?php echo $row_patient['f_name']; ?>" name='first_name' />
		 <input type='hidden' value=<?php echo $row_patient['l_name']; ?> name='last_name' />
		 
         "</form></td>
                </tr>
<?php } ?>
    </table>
        <?php }if(!isset($_POST['view_student_pay'])) {
            echo "<div align=\"center\">No search criteria provided</div>";
        }else if(isset($_POST['view_student_pay'])) {
            $sql = "select id from payment where patient_id='".$_POST['patient_id']."'";
            $check_record = mysql_query($sql);
            if(mysql_num_rows($check_record)> 0){     
         ?>
            <div style="width:600px; font-size:12px; color: #548912"><h4 align="center">Patient ID: <?php echo $_POST['patient_id'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Patient Name: <?php echo $_POST['first_name'];  echo "  ".$_POST['last_name']; ?></h4></div>
            <?php 
                $listSQL = "SELECT f.description, p.date, p.reciept_num, p.amount
                FROM fee f, payment p
                WHERE f.id = p.fee
                AND p.patient_id='".$_POST['patient_id']."'";
                $listResult = mysql_query($listSQL);
            ?>
            <table width="600" cellpadding="0" border="0" align="center" class="gradienttable" >
                <thead>
                    <th width="80">Date</th>
                    <th width="150">Description</th>
                    <th width="150">Reciept No.</th>
                    <th width="170">Amount</th>
                </thead>
                <?php while ($list = mysql_fetch_array($listResult)){ ?>
                <tr>
                    <td><?php echo $list['date']; ?></td>
                    <td><?php echo $list['description']; ?></td>
                    <td><?php echo $list['reciept_num']; ?></td>
                    <td>K <?php echo $list['amount']; ?></td>
                </tr>
                <?php } ?>
            </table><br />
             <a href="payment_history.php?id=<?php echo $_POST['patient_id'];?>&fname=<?php echo $_POST['first_name']; ?>&lname=<?php echo $_POST['last_name']; ?>"><img alt="print" src="img/PrintIcon.jpg" title="Print Records" /></a>
            <?php } ?>
    
        <?php }else
		{
			echo "<h4><img src='images/red-error.gif' />Patient Has No Payment History</h4>";
		} ?>
    
    </fieldset>

<?php include 'configuration/footer.php'; ?>