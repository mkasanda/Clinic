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
<legend>Reports </legend>


<form action="report.php"  method="post">
<input type="hidden" value="yes" name="report">
<input type="submit" value="Dispensary Report">
</form>

<?php
 
    if (isset($_POST['report'])){
		echo  "<div id='dispensary'>";
		$query = "select item_name, d.quantity_in_stock, description from dispensary d, pharmacy_stock ps where ps.item_id = d.drug_no";
		$result = queryMysql($query);
		if($result){
			echo "<tr> <tr><h2>Dispensary Stock Report</h2></tr><tr> ";
			echo "<table border=\".5px\" cellspacing=\"8\" cellpadding=\"\" >
			
<td>No.</td><td>Name</td> <td>Quantity</td> <td>Description</td> <tr> ";
			
			
			$rows = mysql_num_rows($result);
			for ($i=0; $i<$rows; $i++){
				$no = $i+1;
			$row = mysql_fetch_row($result);
		echo "	<tr> 
<td>$no.</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>
</tr>";
			 } echo "</table>";
			}
			echo "</div>";
		echo "<table style=\"left:100;\"><tr align=\"center\"><td colspan='6'> <input type=\"button\" onclick=\"print_page('dispensary')\" value=\"print\"/></td></tr></table>";
		}
?>



<br/><br/><br/>
<form action="report.php"  method="post">
<input type="hidden" value="yes" name="stock">
<input type="submit" value="Pharmacy Report">
</form>

<?php

    if (isset($_POST['stock'])){
		
		$query = "select item_name, ps.quantity_in_stock, description, source, date_received from pharmacy_stock_information psi, pharmacy_stock ps, dispensary d where ps.item_id = psi.item_id and ps.item_id = d.drug_no";
		$result = queryMysql($query);
		if($result){
			echo  "<div id='pharmacy'>";
			echo "<tr> <tr><h2>Pharmacy Stock Report</h2></tr>";
			echo "<table border=\"1px\" cellspacing=\"8\" cellpadding=\"0\">

<td>No.</td><td>Name</td> <td>Quantity</td> <td>Description</td> <td>Source</td> <td>Date Received</td><tr> ";
			
			
			$rows = mysql_num_rows($result);
			for ($i=0; $i<$rows; $i++){
				$no=($i+1);
			$row = mysql_fetch_row($result);
		echo "	<tr> 
<td>$no.</td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td>
</tr>";

			 }
			
			  echo "</table>";
			  
			  echo "</div>";
 echo "<table style=\"left:100;\"><tr align=\"center\"><td colspan='6'> <input type=\"button\" onclick=\"print_page('pharmacy')\" value=\"print\"/></td></tr></table>";
			}
			
		}
?>
</div>
<div id="head" style="display:none";>  
   <table width="300"> <tr align="center"><td> <img src="img/edited unza logo.png" alt="Unza Logo" width="90" height="100"/> </td></tr></table>
  <h1>The University of Zambia Clinic</h1>  

</div>

<div id="foot" style="display:none">
<?php
 echo "<br/>Date: ". date("l F jS, Y");
 echo "<br/>Time: ".date("g:ia", time());
?>
</div>


<div>
<script language="javascript">
 function  print_page(id){
    var head = document.getElementById('head');
	 var header = head.innerHTML;
	   var foot = document.getElementById('foot');
	 var footer = foot.innerHTML;
	 var report =document.getElementById(id);
	var page = report.innerHTML;
	var pwin = window.open('','print_content', 'width=600, height = 600');
	
   pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">' + header + page + footer+ '</body></html>');
  pwin.document.close();
 
   setTimeout(function(){pwin.close();},1000);

	}
 </script></div>


  </fieldset>
<?php require_once "configuration/footer.php"; ?>

