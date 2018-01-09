<?php include 'configuration/database.php'; ?>
<?php

    if($_POST){
        mysql_query("insert into Patient_Diagnosis(bp,temp,weight,date,patient_id,diagnosis) values('".$_POST['bp']."','".$_POST['temp']."','".$_POST['weight']."'
            ,'".$_POST['date']."','".$_POST['patient_no']."','".$_POST['complaints']."')");
        if(mysql_error()){
            echo mysql_error();
            unset($_POST);
        }  else {
            echo "New Record was added Successively!!";
        }
    }
  
 

//if($_REQUEST['set'] == 1){
   // header("location:landing.php");
//}



?>