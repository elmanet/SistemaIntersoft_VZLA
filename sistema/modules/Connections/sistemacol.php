<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sistemacol = "localhost";
$database_sistemacol = "colegionline";
$username_sistemacol = "root";
$password_sistemacol = "g4l4p4gos";
$sistemacol = mysql_connect($hostname_sistemacol, $username_sistemacol, $password_sistemacol) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
