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
<legend> New Stock </legend>

<form action="new_stock.php" method="post">
<table>
<tr align="center">
	<td colspan="2"><h2>Please Enter the Stock Details</h2></td>
</tr>
<tr>
 <td>Name : </td><td><?php 		  
echo "<select name=\"item\"><option value=\"default\"> Select </option>";
 $query = "SELECT  item_id, item_name FROM pharmacy_stock";	 	
		$result = queryMysql($query);		 
		if($result){
		 $rows = mysql_num_rows($result);		 
		 for($j=0; $j<$rows; $j++)
		 {
		$row = mysql_fetch_row($result);
		echo "<option value = '$row[0]'> $row[1] </option>";
		 }
		  }
   ?></td>
</tr>
 <tr>
	<td>Source : </td><td><input  type = "text" name="source"></td>
</tr>
<tr>
	<td>Date Received : (yyyy-mm-dd)</td><td><input  type = "text" name="date_received"></td>
</tr>
<tr>
	<td>Batch No. : </td><td><input  type = "text" name="batch_no"></td>
</tr>
<tr>
	<td>Quantity Received : </td><td><input  type = "text" name="quantity_received"></td>
</tr>
<tr>
	<td>Goods Received Note : </td><td><input  type = "text" name="goods_received_note"></td>
</tr>
<tr align="center">
<td colspan="2"><input  type = "submit", value="Enter"> <in</td>
</tr>
</table>
 </form>
 
<?php 
 if(isset($_POST['item']) && 
 isset($_POST['source'])&& 
 isset($_POST['date_received'])&& isset($_POST['batch_no'])&&
 isset($_POST['quantity_received'])&&isset($_POST['goods_received_note']))
 {
	 echo "form is being processed";
	 $item = get_post('item');
	 $source = get_post('source');
	 $date_received = get_post('date_received');
	 $quantity_received = get_post('quantity_received');
	 $batch_no = get_post('batch_no');
	 $goods_received_note = get_post('goods_received_note');
	  $staff_id = $_SESSION['man_no'];
	 	
$query = "INSERT INTO `pharmacy_stock_information`(`Item_Id`, `Batch_No`, `Source`, `Quantity_Recieved`, `Date_Received`, `Item_Received_By`, `Good_Received_Note_No`) VALUES ( '$item','$batch_no','$source','$quantity_received','$date_received' ,'$staff_id', '$goods_received_note')";
$queryUpdate = "UPDATE `pharmacy_stock` SET `Quantity_In_Stock`=Quantity_In_Stock + $quantity_received WHERE item_id = $item ";
		$resultUpdate= queryMysql($queryUpdate);
		$result = queryMysql($query);
			
		if(!($result&&$queryUpdate)){
		echo "Some fields were blank";
			}
			
		else {
		   
		   echo " sucessfully entered";
			
			}
		}
 ?>
 
 </fieldset>
<?php require_once "configuration/footer.php"; ?>

