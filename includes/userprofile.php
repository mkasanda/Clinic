
<?php 
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];

echo "<img src=\"userimages/$username.jpg\" alt=\"Picture\"  border=\"1\" height=\"90px\" width=\"90px\">";
$query = "SELECT f_name, l_name, department_id FROM security s, staff st WHERE s.username = '$username' AND s.password = '$password' AND s.man_no = st.man_no";
$result = queryMysql($query);
$row = mysql_fetch_row($result);
$n1 = ucfirst(strtolower($row[0]));
$n2 = ucfirst(strtolower($row[1]));
 $_SESSION['department_id']=$row[2];
echo "<br/>"."Hi , $n1  $n2";
?>
<form action="logout.php" method="post">
<input type="submit", value="Logout">
 </form>