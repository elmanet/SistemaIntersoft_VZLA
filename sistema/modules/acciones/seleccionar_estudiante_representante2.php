<?php require_once('../../Connections/sistemacol.php'); ?>

<?php
// VALIDACION DE VERSION DE PHP
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);

$colname_asignatura = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_asignatura = $_GET['alumno_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id AND a.id = %s", GetSQLValueString($colname_asignatura, "text"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

$colname_mate1 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate1 = $_GET['alumno_id'];
}
$confi=$row_confip['codfor'];
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}


$colname_mate2 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate2 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}


$colname_mate3 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate3 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}


$colname_mate4 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate4 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}

$colname_mate5 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate5 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}

$colname_mate6 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate6 = $_GET['alumno_id'];

}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}


$colname_mate7 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate7 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}

$colname_mate8 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate8 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}

$colname_mate9 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate9 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}

$colname_mate10 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate10 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}

$colname_mate11 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate11 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}


$colname_mate12 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate12 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}

$colname_mate13 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate13 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT a.nombre, a.apellido, c.def, d.tipo_asignatura, e.iniciales as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}

// AGRUPANDO EDUCACION PARA EL TRABAJO
$colname_mate14 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate14 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate14, "text"));
$mate14 = mysql_query($query_mate14, $sistemacol) or die(mysql_error());
$row_mate14 = mysql_fetch_assoc($mate14);
$totalRows_mate14 = mysql_num_rows($mate14);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate14, "text"));
$mate14 = mysql_query($query_mate14, $sistemacol) or die(mysql_error());
$row_mate14 = mysql_fetch_assoc($mate14);
$totalRows_mate14 = mysql_num_rows($mate14);
}

// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_mate15 = $_GET['alumno_id'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND c.lapso=1 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.alumno_id = %s AND c.lapso=1 GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<body>

<center>
<table class="ancho_tabla4de"><tr>
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>

            	<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="left">
                 	<tr>
                    		<td align="left" valign="bottom" style="font-size:25px"><?php echo $row_colegio['nomcol']; ?></td>
                	</tr>
                	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  	</tr>
                  	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  	</tr>
                  </table>
		
		</td>
		</tr>
		<tr>
		<td align="center" colspan="2">
			<h1>REPORTE DE CALIFICACIONES DE 1ER LAPSO</h1>
			
		</td>
</tr></table>


<table ><tr>

<?php // MATERIA 1
?> 
<td>
<table><tr><td>
<tr>
<td width="400" style="border-bottom:1px solid; border-right:1px solid;">
<b>APELLIDO Y NOMBRES</b>
</td>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate1['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr><td  style="border-right:1px solid; border-bottom:1px solid;" >
<?php echo $row_mate1['apellido'].", ". $row_mate1['nombre']; ?>
</td>
<td  align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate1['def']==0){ echo "NP";} if(($row_mate1['def']>0) and ($row_mate1['def']<10)){ echo "0".$row_mate1['def'];} if(($row_mate1['def']>9) and ($row_mate1['def']<=20)){ echo $row_mate1['def'];} ?>

</td>
</tr>
<?php } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</td>
</tr></table>
</td>


<?php // MATERIA
if (($totalRows_mate2>0) and ($row_mate2['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate2['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate2['def']==0){ echo "NP";} if(($row_mate2['def']>0) and ($row_mate2['def']<10)){ echo "0".$row_mate2['def'];} if(($row_mate2['def']>9) and ($row_mate2['def']<=20)){ echo $row_mate2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate2 = mysql_fetch_assoc($mate2)); ?>
</td>
</tr></table>
</td>
<?php } ?>
<?php // MATERIA
if (($totalRows_mate3>0) and ($row_mate3['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate3['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate3['def']==0){ echo "NP";} if(($row_mate3['def']>0) and ($row_mate3['def']<10)){ echo "0".$row_mate3['def'];} if(($row_mate3['def']>9) and ($row_mate3['def']<=20)){ echo $row_mate3['def'];} ?>
</td>
</tr>
<?php } while ($row_mate3 = mysql_fetch_assoc($mate3)); ?>
</td>
</tr></table>
</td>
<?php } ?>
<?php // MATERIA
if (($totalRows_mate4>0) and ($row_mate4['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate4['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate4['def']==0){ echo "NP";} if(($row_mate4['def']>0) and ($row_mate4['def']<10)){ echo "0".$row_mate4['def'];} if(($row_mate4['def']>9) and ($row_mate4['def']<=20)){ echo $row_mate4['def'];} ?>
</td>
</tr>
<?php } while ($row_mate4 = mysql_fetch_assoc($mate4)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate5>0) and ($row_mate5['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate5['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate5['def']==0){ echo "NP";} if(($row_mate5['def']>0) and ($row_mate5['def']<10)){ echo "0".$row_mate5['def'];} if(($row_mate5['def']>9) and ($row_mate5['def']<=20)){ echo $row_mate5['def'];} ?>
</td>
</tr>
<?php } while ($row_mate5 = mysql_fetch_assoc($mate5)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate6>0) and ($row_mate6['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate6['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate6['def']==0){ echo "NP";} if(($row_mate6['def']>0) and ($row_mate6['def']<10)){ echo "0".$row_mate6['def'];} if(($row_mate6['def']>9) and ($row_mate6['def']<=20)){ echo $row_mate6['def'];} ?>
</td>
</tr>
<?php } while ($row_mate6 = mysql_fetch_assoc($mate6)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate7>0) and ($row_mate7['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate7['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate7['def']==0){ echo "NP";} if(($row_mate7['def']>0) and ($row_mate7['def']<10)){ echo "0".$row_mate7['def'];} if(($row_mate7['def']>9) and ($row_mate7['def']<=20)){ echo $row_mate7['def'];} ?>
</td>
</tr>
<?php } while ($row_mate7 = mysql_fetch_assoc($mate7)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate8>0) and ($row_mate8['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate8['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate8['def']==0){ echo "NP";} if(($row_mate8['def']>0) and ($row_mate8['def']<10)){ echo "0".$row_mate8['def'];} if(($row_mate8['def']>9) and ($row_mate8['def']<=20)){ echo $row_mate8['def'];} ?>
</td>
</tr>
<?php } while ($row_mate8 = mysql_fetch_assoc($mate8)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate9>0) and ($row_mate9['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate9['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate9['def']==0){ echo "NP";} if(($row_mate9['def']>0) and ($row_mate9['def']<10)){ echo "0".$row_mate9['def'];} if(($row_mate9['def']>9) and ($row_mate9['def']<=20)){ echo $row_mate9['def'];} ?>
</td>
</tr>
<?php } while ($row_mate9 = mysql_fetch_assoc($mate9)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate10>0) and ($row_mate10['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate10['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate10['def']==0){ echo "NP";} if(($row_mate10['def']>0) and ($row_mate10['def']<10)){ echo "0".$row_mate10['def'];} if(($row_mate10['def']>9) and ($row_mate10['def']<=20)){ echo $row_mate10['def'];} ?>
</td>
</tr>
<?php } while ($row_mate10 = mysql_fetch_assoc($mate10)); ?>
</td>
</tr></table>
</td>
<?php }?>

<?php // MATERIA
if (($totalRows_mate11>0) and ($row_mate11['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate11['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate11['def']==0){ echo "NP";} if(($row_mate11['def']>0) and ($row_mate11['def']<10)){ echo "0".$row_mate11['def'];} if(($row_mate11['def']>9) and ($row_mate11['def']<=20)){ echo $row_mate11['def'];} ?>
</td>
</tr>
<?php } while ($row_mate11 = mysql_fetch_assoc($mate11)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate12>0) and ($row_mate12['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate12['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate12['def']==0){ echo "NP";} if(($row_mate12['def']>0) and ($row_mate12['def']<10)){ echo "0".$row_mate12['def'];} if(($row_mate12['def']>9) and ($row_mate12['def']<=20)){ echo $row_mate12['def'];} ?>
</td>
</tr>
<?php } while ($row_mate12 = mysql_fetch_assoc($mate12)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA
if (($totalRows_mate13>0) and ($row_mate13['tipo_asignatura']=="")){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b><?php echo $row_mate13['mate']; ?></b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate13['def']==0){ echo "NP";} if(($row_mate13['def']>0) and ($row_mate13['def']<10)){ echo "0".$row_mate13['def'];} if(($row_mate13['def']>9) and ($row_mate13['def']<=20)){ echo $row_mate13['def'];} ?>
</td>
</tr>
<?php } while ($row_mate13 = mysql_fetch_assoc($mate13)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // MATERIA EDUCACION PARA EL TRABAJO
if ($row_mate14['tipo_asignatura']=="educacion_trabajo"){
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b>EPT</b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate14['def']==0){ echo "NP";} if(($row_mate14['def']>0) and ($row_mate14['def']<10)){ echo "0".$row_mate14['def'];} if(($row_mate14['def']>9) and ($row_mate14['def']<=20)){ echo $row_mate14['def'];} ?>
</td>
</tr>
<?php } while ($row_mate14 = mysql_fetch_assoc($mate14)); ?>
</td>
</tr></table>
</td>
<?php } ?>

<?php // PROMEDIO DE LAPSO

?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<b>PROM</b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate15['def']==0){ echo "NP";} if(($row_mate15['def']>0) and ($row_mate15['def']<10)){ echo "0".$row_mate15['def'];} if(($row_mate15['def']>9) and ($row_mate15['def']<=20)){ echo $row_mate15['def'];} ?>
</td>
</tr>
<?php } while ($row_mate15 = mysql_fetch_assoc($mate15)); ?>
</td>
</tr></table>
</td>



<?php // fin consulta
?>
 </tr></table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
</center>


</body>
</html>
<?php
mysql_free_result($asignatura);
mysql_free_result($confip);
mysql_free_result($mate1);
mysql_free_result($mate2);
mysql_free_result($mate3);
mysql_free_result($mate4);
mysql_free_result($mate5);
mysql_free_result($mate6);
mysql_free_result($mate7);
mysql_free_result($mate8);
mysql_free_result($mate9);
mysql_free_result($mate10);
mysql_free_result($mate11);
mysql_free_result($mate12);
mysql_free_result($mate13);
mysql_free_result($mate14);
mysql_free_result($mate15);

mysql_free_result($colegio);

?>
