<?php

if((isset($_GET['patient_id']) && isset($_GET['search'])&& $_GET['search'] == "sear") || isset($_POST['id'])||(isset($_GET['id'])&&isset($_GET['f']))){
        if(isset($_GET['patient_id']))
            $id =$_GET['patient_id'];
        if(isset($_POST['id']))
            $id = isset($_POST['id']);
        if(isset($_REQUEST['id']))
            $id=$_GET['id'];
        $sql = "SELECT * FROM Patient WHERE Patient_Id='".$id."'";
        $result1 = mysql_query($sql);
        
        if(mysql_num_rows($result1) > 0){
            $list_result1 = mysql_fetch_assoc($result1);
            $fname= $list_result1['f_name'];
            $lname = $list_result1['l_name'];
            $id = $list_result1['Patient_Id'];
        }else{
            $fname="";
            $lname="";
            $id="";
            $error = "<img src='images/red-error.gif' />Patient NOT found!";
        }
    }

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "makePayment")) {
        $paymentSQL="insert into payment(fee,amount,date,recieved_by,reciept_num,patient_id) values('".$_POST['fee']."','".$_POST['amount']."','".date('d'.'-'.'m'.'-'.'Y')."','".$_POST['received_by']."','".$_POST['receipt_no']."','".$_POST['id']."')";
        $payment_result = mysql_query($paymentSQL);
        $error=mysql_error();
        
        if($error!="") {
            $error="<img src='img/red-error.gif' />".$error;
        }
        if(mysql_affected_rows() > 0 ){
            $success="<img src='img/green-ok.gif' />Payment successfully made!";
        }
        
        $school_name = "University of Zambia";
        $school_type = "Clinic System";
        $school_address = "Box 30226, Lusaka";
        $school_phone = "+260-211845754 ";
        $school_email = "info_clinic@unza.zm";
        $school_motto = "Service and Excellence";
        
        
        
    }
?>

<script type="text/javascript" >
function printPage()
{
   var html="<html>";
   html+= document.getElementById('print').innerHTML;
   html+="</html>";

   var printWin = window.open('','','left=0,top=0,width=1,height=1,toolbar=0,scrollbars=0,status  =0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>

<style>
	 h2{
		 font-size:11px;
		 line-height:22px;
		 color:#333;
		 font-weight:normal;
		 background-color:inherit;
		 font:normal 14px/14px "Times New Roman", Times, serif, Helvetica, sans-serif;
	 }
	 h2 span{
	     display:block;
		 font:normal 28px/28px "Times New Roman", Times, serif, Helvetica, sans-serif;
		 color:#111;
		 background-color:inherit;
	 }
	 table tr td {
		 padding:2px 5px;
	 }
</style>

<div id="print">
    <img src="img/unzaLogo.jpg" />
    <?php
    //header information
        $header="<div align=\"center\">".
        "<h2><span>".$school_name." ".
		$school_type."</span><br />".
		"Address: ".$school_address.
		"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
		"Phone: ".$school_phone."<br />".
		"Email: ".$school_email."<br />".
		"Motto: <i>".$school_motto."</i><br />".
		"<br /><b>Payment Reciept </b></h2>".
        "</div>";
        echo $header;
    ?>
    
    <table width="300" height="80">
        <tr>
            <td align="right">Number: <?php echo $_POST['receipt_no']; ?></td>
        </tr>
        <tr>
            <td align="left">Recieved with thanks from: <?php $_POST['fname']; ?></td>
        </tr>
        <tr>
            <td align="left">Client Number: <?php echo $_POST['id']; ?></td>
        </tr>
        <tr>
            <td align="left">Paying for: <?php echo $_POST['fee']; ?></td>
        </tr>
        <tr>
            <td align="left">Amount: <?php echo $_POST['amount']; ?></td>
        </tr>
        <tr>
            <td align="left">Date: <?php echo date('d'.'-'.'m'.'-'.'Y'); ?></td>
        </tr>
    </table>
    
    <code>
<br /><br /><br />
<center>Authority Stamp:.........................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature:...................</center><br />
</code>
</div>
<a href="makePayment.php">Back to Payments</a>    <input type="submit" class="button" onclick="printPage()" value="Print Reciept" />
