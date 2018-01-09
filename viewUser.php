<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>

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

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Medical_Officer"){
		include 'menu2.php'; 
}
		
    ?>

<?php
//retrieve users information from DB
    $list_userSQL = "select * from users where man_no='".$_REQUEST['id']."'";
    $list_user_result = mysql_query($list_userSQL);
    $details = mysql_fetch_array($list_user_result);
?>

<?php
    //commit if user clicks button
	if ((isset($_POST["MM_edit"])) && ($_POST["MM_edit"] == "editUser")) {
            $user_editSQL = "update users set f_name='".$_POST['fname']."', l_name='".$_POST['lname']."',role='".$_POST['role']."', username='".$_POST['username']."', password=md5('".$_POST['password']."') where man_no='".$_POST['man_num']."'";
            $user_editResult = mysql_query($user_editSQL);
            $error = (mysql_error());
            
            //capture any errors
		if($error!=""){
                    unset($_POST);
                    $error="<img src='img/red-error.gif' />".$error;
                }
                $success = "<img src='img/green-ok.gif' />User details edited Suucessively!";
        }
?>

<fieldset>
    <legend>User Personal information</legend>
    <?php echo ($error==""?"<h4 class=\"green\">".$success."</h4>":"<h4>".$error."</h4>"); ?>
    <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
        <table width="665" height="48">
            <tr>
                <td width="113" align="right">Firstname</td>
                <td width="198" align="left">
                    <input type="text" name="fname"  tabindex="1" value="<?php echo $details['f_name']; ?>" /></td>
              <td width="145" align="right">Lastname</td>
              <td width="178" align="left">
                  <input type="text" name="lname" value="<?php echo $details['l_name']; ?>" tabindex="2" />
              </td>
            </tr>
            <tr>
                <td align="right">Man No.</td>
                <td align="left"> <input type="text" name="man_num" value="<?php echo $details['man_no']; ?>" /></td>
                <td align="right">Role</td>
                <td align="left"> <input type="text" name="role" value="<?php echo $details['role']; ?>" /></td>
            </tr>
            <tr>
                <td align="right">Username</td>
                <td align="left"><input type="text" name="username" value="<?php echo $details['username']; ?>" /></td>
                <td align="right">Password</td>
                <td align="left"><input type="password" name="password" /></td>
            </tr>
            <input type="hidden" name="MM_edit" value="editUser" />
			 <tr><td colspan="20"><input class="button" type="submit" value="Edit/Save User" name="submit"></td></tr>
        </table>
    </form>
</fieldset>

<?php include 'configuration/footer.php'; ?>
