<?php include 'configuration/database.php'; ?>
<?php
if($_POST){
    
    $paymentSQL="insert into payment(fee,amount,date,recieved_by,reciept_num,patient_id) values('".$_POST['fee']."','".$_POST['amount']."','".date('d'.'-'.'m'.'-'.'Y')."','".$_POST['recieved_by']."','".$_POST['reciept_no']."','".$_POST['patient_no']."')";
        $payment_result = mysql_query($paymentSQL);
       
        
        if(mysql_error()){
            echo mysql_error();
            unset($_POST);
        }  else {
            echo "Payment Made Successively!!";
        }

     
    
   // print_r($_POST);
}
?>
