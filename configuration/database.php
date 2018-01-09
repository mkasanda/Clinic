<?php
$host="localhost"; // Host name
$username="root"; // Mysql username
$password="malama"; // Mysql password
$db_name="Unza_Clinic_Prototype"; // Database name

//Connect to server and select database
$connection = @mysql_connect($host, $username, $password) or die(mysql_error());

$db = @mysql_select_db($db_name, $connection) or die(mysql_error());

?>
