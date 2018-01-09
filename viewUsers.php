<?php include 'configuration/header.php'; ?>
<?php include 'configuration/database.php'; ?>
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
        
        //pagination variables
        $currentPage = $_SERVER["PHP_SELF"];
        $maxRows_Users = 10;
		$pageNum_Users = 0;
		if (isset($_GET['pageNum_Users'])) {
			$pageNum_Users = $_GET['pageNum_Users'];
		}
			$startRow_Users = $pageNum_Users * $maxRows_Users;
        
        //pull users from the database
        $viewUserSQL = "select * from users";
        $query_limit_Users = sprintf("%s LIMIT %d, %d", $viewUserSQL, $startRow_Users, $maxRows_Users);
        $Users = mysql_query($query_limit_Users) or die(mysql_error());
        $row_Users = mysql_fetch_assoc($Users);
        
      
		//$totalPages_Users = ceil($totalRows_Users/$maxRows_Users)-1;

?>

<?php 
    if ($_SESSION['role'] == 'Admin'){
		include 'menu.php';
	}elseif($_SESSION['role'] == "Medical_Officer"){
		include 'menu2.php'; 
}
		
    ?>
    
    <div>
		<h3>System information Users</h3>
		
		<table border="0" class="gradienttable" width="700" align="center">
			<tr>
				<th width="100">Username</th>
				<th width="100">Man Number</th>
				<th width="100">Name</th>
				<th width="100">Access Level</th>
				<th width="100">Edit</th>
				<th width="100">Delete</th>
			</tr>
			<?php do{ ?>
				<tr>
					 <td><?php echo $row_Users['username']; ?></td>
					 <td><?php echo $row_Users['man_no']; ?></td>
					 <td><?php echo $row_Users['f_name']; ?></td>
					 <td><?php echo $row_Users['role']; ?></td>
					 <td><a href="edit_user.php?id=<?php echo $row_Users['man_no']?>">Edit</a></td>
					 <td><a href="deleteUser.php?id=<?php echo $row_Users['man_no']?>">Delete</a></td>
				</tr>
			<?php } while ($row_Users = mysql_fetch_assoc($Users));?>
                                <tr><td colspan="7" align="right">
                                       <?php echo mysql_num_rows($Users); ?> System Registered Users
                  </td></tr>
		</table>
                
               <br/><br/>
    </div>
    
<?php include 'configuration/footer.php'; ?>
