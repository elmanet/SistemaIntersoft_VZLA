<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sistemacol = "localhost";
$database_sistemacol = "coleaup_bd";
$username_sistemacol = "coleaup_bd";
$password_sistemacol = "g4l4p4goS2012";
$sistemacol = mysql_pconnect($hostname_sistemacol, $username_sistemacol, $password_sistemacol) or trigger_error(mysql_error(),E_USER_ERROR); 
?>