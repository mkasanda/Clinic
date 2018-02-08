
 <?php
        $db_database = "unza_clinic_prototype";
        $db_host = "localhost";
        $db_username = "rchisebu";
        $db_password = "isabel89";
        ?>
        
        <?php
        $db_server = mysql_connect($db_host, $db_username, $db_password );
        
        if (!$db_server){
        die("Sorry Could not connect to the database" . mysql_error());}
        else 
            {
            mysql_select_db($db_database, $db_server );
			            }       
?>

<div class="main">
<div class="page">

<div class="header">
</div>

