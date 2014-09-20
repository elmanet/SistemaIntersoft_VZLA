<?php
	 require_once('../inc/conexion_sinsesion.inc.php');
    
   $ced_alumno = $_POST["ced_alumno"];
	mysql_select_db($database_sistemacol, $sistemacol);
	$query_Recordset1 = "SELECT * FROM jos_alumno_preinscripcion WHERE ced_alumno= $ced_alumno";
	$Recordset1 = mysql_query($query_Recordset1, $sistemacol) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);

	mysql_select_db($database_sistemacol, $sistemacol);
	$query_Recordset2 = "SELECT * FROM jos_alumno_info WHERE cedula= $ced_alumno";
	$Recordset2 = mysql_query($query_Recordset2, $sistemacol) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if ((mysql_num_rows($Recordset1)>0) or (mysql_num_rows($Recordset2)>0)) {
echo 	1;

}
else {
echo 0;


}
?>