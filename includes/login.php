<?php 
       if (!isLoggedIn()){
		 header('Location: ../index.php');
		   }
		   
		   else{
			   $username = $_SESSION['username'];
                $password = $_SESSION['password'];
			   }

?>