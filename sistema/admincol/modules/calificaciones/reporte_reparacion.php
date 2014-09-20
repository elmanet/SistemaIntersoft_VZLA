' <?php require_once('../../Connections/sistemacol.php'); ?>
<?php
if (!isset($_SESSION)){
@  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../acceso/acceso.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
//AUTORIZACION PARA ENTRAR A LA PAGINA
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../acceso/acceso_error2.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
// fin de la autorizacion
?>
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
if (isset($_GET['curso_id'])) {
  $colname_asignatura = $_GET['curso_id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id AND a.id = %s ", GetSQLValueString($colname_asignatura, "text"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

//MATERIA 1
//nombres
$colname_mate1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

//MATERIA 2
//nombres
$colname_mate2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}

//MATERIA 3
//nombres
$colname_mate3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}

//MATERIA 4
//nombres
$colname_mate4 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate4 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}

//MATERIA 5
//nombres
$colname_mate5 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate5 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}

//MATERIA 6
//nombres
$colname_mate6 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate6 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}

//MATERIA 7
//nombres
$colname_mate7 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate7 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}

//MATERIA 8
//nombres
$colname_mate8 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate8 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}

//MATERIA 9
//nombres
$colname_mate9 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate9 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}

//MATERIA 10
//nombres
$colname_mate10 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate10 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}

//MATERIA 11
//nombres
$colname_mate11 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate11 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}

//MATERIA 12
//nombres
$colname_mate12 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate12 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}

//MATERIA 13
//nombres
$colname_mate13 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate13 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id  AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}



// DEF MATERIA 14
$colname_mate14def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate14def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}


// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate15 = $_GET['curso_id'];
}

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.apellido ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
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
<link href="../../css/form_impresion.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>

<table width="900"><tr><td>
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
		
</td></tr></table>

<br />
<br />


<table width="900">


<?php // MATERIA 1
if (($totalRows_mate1>0)){
?> 
<tr>
<td>
<h3>Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?></h3>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate1['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate1['def']>0) and ($row_mate1['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate1['apellido'].", ". $row_mate1['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate1['def']>0) and ($row_mate1['def']<10)){ echo "0".$row_mate1['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>

<?php // MATERIA 2
if (($totalRows_mate2>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate2['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate2['def']>0) and ($row_mate2['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate2['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate2['apellido'].", ". $row_mate2['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate2['def']>0) and ($row_mate2['def']<10)){ echo "0".$row_mate2['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate2 = mysql_fetch_assoc($mate2)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 3
if (($totalRows_mate3>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate3['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate3['def']>0) and ($row_mate3['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate3['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate3['apellido'].", ". $row_mate3['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate3['def']>0) and ($row_mate3['def']<10)){ echo "0".$row_mate3['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate3 = mysql_fetch_assoc($mate3)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 4
if (($totalRows_mate4>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate4['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate4['def']>0) and ($row_mate4['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate4['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate4['apellido'].", ". $row_mate4['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate4['def']>0) and ($row_mate4['def']<10)){ echo "0".$row_mate4['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate4 = mysql_fetch_assoc($mate4)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 5
if (($totalRows_mate5>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate5['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate5['def']>0) and ($row_mate5['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate5['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate5['apellido'].", ". $row_mate5['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate5['def']>0) and ($row_mate5['def']<10)){ echo "0".$row_mate5['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate5 = mysql_fetch_assoc($mate5)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 6
if (($totalRows_mate6>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate6['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate6['def']>0) and ($row_mate6['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate6['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate6['apellido'].", ". $row_mate6['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate6['def']>0) and ($row_mate6['def']<10)){ echo "0".$row_mate6['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate6 = mysql_fetch_assoc($mate6)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 7
if (($totalRows_mate7>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate7['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate7['def']>0) and ($row_mate7['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate7['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate7['apellido'].", ". $row_mate7['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate7['def']>0) and ($row_mate7['def']<10)){ echo "0".$row_mate7['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate7 = mysql_fetch_assoc($mate7)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 8
if (($totalRows_mate8>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate8['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate8['def']>0) and ($row_mate8['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate8['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate8['apellido'].", ". $row_mate8['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate8['def']>0) and ($row_mate8['def']<10)){ echo "0".$row_mate8['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate8 = mysql_fetch_assoc($mate8)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 9
if (($totalRows_mate9>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate9['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate9['def']>0) and ($row_mate9['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate9['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate9['apellido'].", ". $row_mate9['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate9['def']>0) and ($row_mate9['def']<10)){ echo "0".$row_mate9['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate9 = mysql_fetch_assoc($mate9)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 10
if (($totalRows_mate10>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate10['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate10['def']>0) and ($row_mate10['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate10['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate10['apellido'].", ". $row_mate10['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate10['def']>0) and ($row_mate10['def']<10)){ echo "0".$row_mate10['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate10 = mysql_fetch_assoc($mate10)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 11
if (($totalRows_mate11>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate11['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate11['def']>0) and ($row_mate11['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate11['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate11['apellido'].", ". $row_mate11['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate11['def']>0) and ($row_mate11['def']<10)){ echo "0".$row_mate11['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate11 = mysql_fetch_assoc($mate11)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 12
if (($totalRows_mate12>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate12['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate12['def']>0) and ($row_mate12['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate12['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate12['apellido'].", ". $row_mate12['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate12['def']>0) and ($row_mate12['def']<10)){ echo "0".$row_mate12['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate12 = mysql_fetch_assoc($mate12)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>


<?php // MATERIA 13
if (($totalRows_mate13>0)){
?> 
<tr>
<td>
<table><tr><td colspan="4" align="center">
<hr />
<h4>Reporte de <?php echo $row_mate13['nombre_mate']; ?></h4>

</td>
</tr>
<tr>
<td  class="ancho_td_no"  align="center">
NO.
</td>
<td  class="ancho_td_cedula"  align="center">
CEDULA
</td>
<td  class="ancho_td_nombre"  align="center" >
APELLIDOS Y NOMBRES
</td>
<td  class="ancho_td_nota2" style="font-size:10px"  align="center" >
DEF
</td>
</tr>



<?php $lista=1; do 
if (($row_mate13['def']>0) and ($row_mate13['def']<10))
{ ?>
<tr >

<td class="ancho_td_no3"  align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3"  align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate13['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate13['apellido'].", ". $row_mate13['nombre']; ?></span>
</td>
<td  class="ancho_td_nota" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<b><?php if(($row_mate13['def']>0) and ($row_mate13['def']<10)){ echo "0".$row_mate13['def'];} ?></b></span>
</td>

</tr>
<?php } while ($row_mate13 = mysql_fetch_assoc($mate13)); ?>
</td>
</tr></table>
</td>
</tr>
<?php } ?>





<?php // fin consulta
?>
</table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>





</body>
</center>
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
