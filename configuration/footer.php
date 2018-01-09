<?php include 'configuration/database.php'; 
if (!isset($_SESSION)) {
        session_start();
    }
    ?>
<div id="footer">
                <br>
                <p id="footerText" class="reallySmallText">
                    <a href="http:://www.unza.zm">Rights Reserved UNZA Clinic</a>
                    &nbsp;&nbsp;::&nbsp;
                    <font href="mailto:a@yahoo.com" style="color:green;"> &copy 2013</font></a>&nbsp</p>
                <p id="footerText">
                     <?php if(isset($_SESSION['username'])) {?>
                         <a href="EditUser.php" title="Edit Your Info">Account</a> | <a href="logout.php?doLogout=true" title="Edit Your Info">Logout</a>
                     <?php }?>
                         <?php if(isset($_SESSION['role'])){
							 if($_SESSION['role'] == 'Admin' ){ ?>
                         | <a href="sys_log.php">Sys Activity</a>
                         <?php }}?>
                </p>
            </div>
        </div>
    </body>
</html>
