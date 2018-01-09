<?php include 'configuration/database.php'; ?>
<?php

    if($_POST){
        $queue_patient = "insert into patient_queue (patient_id,time_in,date,status) values('".$_POST['patient_no']."','".  date("H:i")."','".date("m-d-y")."','0')";
        $queue_patientResult = mysql_query($queue_patient);
    
    if(mysql_error()){
            echo mysql_error();
            unset($_POST);
            
        }else{
            echo "Patient Queued Succesfully!!";
        }

    }
?>
