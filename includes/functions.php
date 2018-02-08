 <?php
    function get_post($var){
        return mysql_real_escape_string($_POST[$var]);
    } 
	
	function queryMysql($query){
			$result = mysql_query($query) or die(mysql_error());
          return $result;
			}
			
			function isLoggedIn(){
				
				if(isset($_SESSION['username'] )&& isset ($_SESSION ['password']))
				{
				  return true;
				}
				
				else {
					return false;
					}
				
				}
				
function destroySession()
{
    $_SESSION=array();
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
    session_destroy();

}

?>


