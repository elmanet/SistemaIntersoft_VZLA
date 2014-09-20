<?php require_once('../inc/conexion.inc.php'); ?>
<?php
// CONSULTA SQL
$colname_alumno = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_alumno = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT a.gid, b.nombre, b.apellido, b.cedula, e.descripcion, f.nombre as anio FROM jos_users a, jos_alumno_info b, jos_alumno_curso c, jos_curso d, jos_seccion e, jos_anio_nombre f WHERE a.id=b.joomla_id AND b.alumno_id=c.alumno_id AND c.curso_id=d.id AND d.seccion_id=e.id AND d.anio_id=f.id AND a.username = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

// FIN DE LA CONSULTA SQL 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
</head>
<center>
<body>


</body>
</center>
</html>
<?php
mysql_free_result($alumno);
?>
