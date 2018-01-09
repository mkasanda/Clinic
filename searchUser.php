<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>
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

//process search query
if(isset($_POST['MM_search']) && $_POST['MM_search']=="MM_search" && $_POST['search']!=NULL){
    $searchSQL = "select * from users where man_no like '".$_POST['search']."%' || f_name like '".$_POST['search']."%' || l_name like '".$_POST['search']."%' || username like '".$_POST['search']."%'";
    $searchSQLResult = mysql_query($searchSQL) or die(mysql_error());
    $total_num = mysql_num_rows($searchSQLResult);
}

//end patient serach
if(isset($_POST['end_patient_search'])){
    $success = "<img src='img/green-ok.gif' />Search Done!";
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
        <legend>Search For User</legend>
        <?php echo (@$success!=""?"<h4 id='result_msg' class=\"green\" id='result_msg'>".@$success."</h4>":""); ?>
        <form action="<?php echo $editFormAction; ?>" method="POST" name="addUser" id="addUser_form" enctype="multipart/form-data">
            
            <input type="text" name="search" value="" />
            <input type="hidden" name="MM_search" value="MM_search" />
            <input type="submit" name="sib" class="search" value="" title="Patient Search" />
        </form>
        
        <?php if(isset($searchSQLResult) && isset($total_num)){?>
        <table border="0" class="gradienttable" width="700" align="center">
                <tr>
                    <th width="250">Man No.</th>
        	    <th width="250">Name</th>
		    <th width="250">Access level</th>
		    <th width="250">Username</th>
                   
                </tr>
                <?php while($row_patient = mysql_fetch_array($searchSQLResult)){ ?>
                <tr>
                    <td><a href="viewUser.php?id=<?php echo $row_patient['man_no']; ?>"><?php echo $row_patient['man_no']; ?></a></td>
                    <td><?php echo $row_patient['f_name']; echo " "; echo $row_patient['l_name']; ?></td>
                    <td><?php echo $row_patient['role']; ?></td>
                    <td><?php echo $row_patient['username']; ?></td>
                    
                </tr>
                 <?php } ?>
        </table>
        <?php }else{
            echo "<div align=\"center\">No search criteria provided</div>";
        } ?>
        
    </fieldset>
</div>
<?php include 'configuration/footer.php'; ?>