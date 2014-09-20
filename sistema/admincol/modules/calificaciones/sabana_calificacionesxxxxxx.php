<?php require_once('../../Connections/sistemacol.php'); ?>
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
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

//LAPSO 1
$colname_mate1l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate1l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}

//LAPSO 2
$colname_mate1l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate1l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2, "text"));
$mate1l2 = mysql_query($query_mate1l2, $sistemacol) or die(mysql_error());
$row_mate1l2 = mysql_fetch_assoc($mate1l2);
$totalRows_mate1l2 = mysql_num_rows($mate1l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2, "text"));
$mate1l2 = mysql_query($query_mate1l2, $sistemacol) or die(mysql_error());
$row_mate1l2 = mysql_fetch_assoc($mate1l2);
$totalRows_mate1l2 = mysql_num_rows($mate1l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2, "text"));
$mate1l2 = mysql_query($query_mate1l2, $sistemacol) or die(mysql_error());
$row_mate1l2 = mysql_fetch_assoc($mate1l2);
$totalRows_mate1l2 = mysql_num_rows($mate1l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=1  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2, "text"));
$mate1l2 = mysql_query($query_mate1l2, $sistemacol) or die(mysql_error());
$row_mate1l2 = mysql_fetch_assoc($mate1l2);
$totalRows_mate1l2 = mysql_num_rows($mate1l2);
}

//LAPSO 3PRUEBA
$colname_mate1l2p = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate1l2p = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2p = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2p, "text"));
$mate1l2p = mysql_query($query_mate1l2p, $sistemacol) or die(mysql_error());
$row_mate1l2p = mysql_fetch_assoc($mate1l2p);
$totalRows_mate1l2p = mysql_num_rows($mate1l2p);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2p = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2p, "text"));
$mate1l2p = mysql_query($query_mate1l2p, $sistemacol) or die(mysql_error());
$row_mate1l2p = mysql_fetch_assoc($mate1l2p);
$totalRows_mate1l2p = mysql_num_rows($mate1l2p);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2p = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2p, "text"));
$mate1l2p = mysql_query($query_mate1l2p, $sistemacol) or die(mysql_error());
$row_mate1l2p = mysql_fetch_assoc($mate1l2p);
$totalRows_mate1l2p = mysql_num_rows($mate1l2p);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l2p = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l2p, "text"));
$mate1l2p = mysql_query($query_mate1l2p, $sistemacol) or die(mysql_error());
$row_mate1l2p = mysql_fetch_assoc($mate1l2p);
$totalRows_mate1l2p = mysql_num_rows($mate1l2p);
}



//LAPSO 3
$colname_mate1l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate1l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l3, "text"));
$mate1l3 = mysql_query($query_mate1l3, $sistemacol) or die(mysql_error());
$row_mate1l3 = mysql_fetch_assoc($mate1l3);
$totalRows_mate1l3 = mysql_num_rows($mate1l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l3, "text"));
$mate1l3 = mysql_query($query_mate1l3, $sistemacol) or die(mysql_error());
$row_mate1l3 = mysql_fetch_assoc($mate1l3);
$totalRows_mate1l3 = mysql_num_rows($mate1l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l3, "text"));
$mate1l3 = mysql_query($query_mate1l3, $sistemacol) or die(mysql_error());
$row_mate1l3 = mysql_fetch_assoc($mate1l3);
$totalRows_mate1l3 = mysql_num_rows($mate1l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=1  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1l3, "text"));
$mate1l3 = mysql_query($query_mate1l3, $sistemacol) or die(mysql_error());
$row_mate1l3 = mysql_fetch_assoc($mate1l3);
$totalRows_mate1l3 = mysql_num_rows($mate1l3);
}

// DEF MATERIA 1
$colname_mate1def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate1def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1def, "text"));

$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
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
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2, "text"));
$mate2 = mysql_query($query_mate2, $sistemacol) or die(mysql_error());
$row_mate2 = mysql_fetch_assoc($mate2);
$totalRows_mate2 = mysql_num_rows($mate2);
}

//LAPSO 1
$colname_mate2l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate2l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l1, "text"));
$mate2l1 = mysql_query($query_mate2l1, $sistemacol) or die(mysql_error());
$row_mate2l1 = mysql_fetch_assoc($mate2l1);
$totalRows_mate2l1 = mysql_num_rows($mate2l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l1, "text"));
$mate2l1 = mysql_query($query_mate2l1, $sistemacol) or die(mysql_error());
$row_mate2l1 = mysql_fetch_assoc($mate2l1);
$totalRows_mate2l1 = mysql_num_rows($mate2l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l1, "text"));
$mate2l1 = mysql_query($query_mate2l1, $sistemacol) or die(mysql_error());
$row_mate2l1 = mysql_fetch_assoc($mate2l1);
$totalRows_mate2l1 = mysql_num_rows($mate2l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l1, "text"));
$mate2l1 = mysql_query($query_mate2l1, $sistemacol) or die(mysql_error());
$row_mate2l1 = mysql_fetch_assoc($mate2l1);
$totalRows_mate2l1 = mysql_num_rows($mate2l1);
}

//LAPSO 2
$colname_mate2l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate2l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l2, "text"));
$mate2l2 = mysql_query($query_mate2l2, $sistemacol) or die(mysql_error());
$row_mate2l2 = mysql_fetch_assoc($mate2l2);
$totalRows_mate2l2 = mysql_num_rows($mate2l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l2, "text"));
$mate2l2 = mysql_query($query_mate2l2, $sistemacol) or die(mysql_error());
$row_mate2l2 = mysql_fetch_assoc($mate2l2);
$totalRows_mate2l2 = mysql_num_rows($mate2l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l2, "text"));
$mate2l2 = mysql_query($query_mate2l2, $sistemacol) or die(mysql_error());
$row_mate2l2 = mysql_fetch_assoc($mate2l2);
$totalRows_mate2l2 = mysql_num_rows($mate2l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=2  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l2, "text"));
$mate2l2 = mysql_query($query_mate2l2, $sistemacol) or die(mysql_error());
$row_mate2l2 = mysql_fetch_assoc($mate2l2);
$totalRows_mate2l2 = mysql_num_rows($mate2l2);
}

//LAPSO 3
$colname_mate2l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate2l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l3, "text"));
$mate2l3 = mysql_query($query_mate2l3, $sistemacol) or die(mysql_error());

$row_mate2l3 = mysql_fetch_assoc($mate2l3);
$totalRows_mate2l3 = mysql_num_rows($mate2l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l3, "text"));
$mate2l3 = mysql_query($query_mate2l3, $sistemacol) or die(mysql_error());
$row_mate2l3 = mysql_fetch_assoc($mate2l3);
$totalRows_mate2l3 = mysql_num_rows($mate2l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=2 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l3, "text"));
$mate2l3 = mysql_query($query_mate2l3, $sistemacol) or die(mysql_error());
$row_mate2l3 = mysql_fetch_assoc($mate2l3);
$totalRows_mate2l3 = mysql_num_rows($mate2l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=2  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2l3, "text"));
$mate2l3 = mysql_query($query_mate2l3, $sistemacol) or die(mysql_error());
$row_mate2l3 = mysql_fetch_assoc($mate2l3);
$totalRows_mate2l3 = mysql_num_rows($mate2l3);
}

// DEF MATERIA 2
$colname_mate2def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate2def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
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
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3, "text"));
$mate3 = mysql_query($query_mate3, $sistemacol) or die(mysql_error());
$row_mate3 = mysql_fetch_assoc($mate3);
$totalRows_mate3 = mysql_num_rows($mate3);
}

//LAPSO 1
$colname_mate3l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate3l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l1, "text"));
$mate3l1 = mysql_query($query_mate3l1, $sistemacol) or die(mysql_error());
$row_mate3l1 = mysql_fetch_assoc($mate3l1);
$totalRows_mate3l1 = mysql_num_rows($mate3l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l1, "text"));
$mate3l1 = mysql_query($query_mate3l1, $sistemacol) or die(mysql_error());
$row_mate3l1 = mysql_fetch_assoc($mate3l1);
$totalRows_mate3l1 = mysql_num_rows($mate3l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l1, "text"));

$mate3l1 = mysql_query($query_mate3l1, $sistemacol) or die(mysql_error());
$row_mate3l1 = mysql_fetch_assoc($mate3l1);
$totalRows_mate3l1 = mysql_num_rows($mate3l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l1, "text"));
$mate3l1 = mysql_query($query_mate3l1, $sistemacol) or die(mysql_error());
$row_mate3l1 = mysql_fetch_assoc($mate3l1);
$totalRows_mate3l1 = mysql_num_rows($mate3l1);
}

//LAPSO 2
$colname_mate3l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate3l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l2, "text"));
$mate3l2 = mysql_query($query_mate3l2, $sistemacol) or die(mysql_error());
$row_mate3l2 = mysql_fetch_assoc($mate3l2);
$totalRows_mate3l2 = mysql_num_rows($mate3l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l2, "text"));
$mate3l2 = mysql_query($query_mate3l2, $sistemacol) or die(mysql_error());
$row_mate3l2 = mysql_fetch_assoc($mate3l2);
$totalRows_mate3l2 = mysql_num_rows($mate3l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l2, "text"));
$mate3l2 = mysql_query($query_mate3l2, $sistemacol) or die(mysql_error());
$row_mate3l2 = mysql_fetch_assoc($mate3l2);
$totalRows_mate3l2 = mysql_num_rows($mate3l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=3  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l2, "text"));
$mate3l2 = mysql_query($query_mate3l2, $sistemacol) or die(mysql_error());
$row_mate3l2 = mysql_fetch_assoc($mate3l2);
$totalRows_mate3l2 = mysql_num_rows($mate3l2);
}

//LAPSO 3
$colname_mate3l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate3l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l3, "text"));

$mate3l3 = mysql_query($query_mate3l3, $sistemacol) or die(mysql_error());
$row_mate3l3 = mysql_fetch_assoc($mate3l3);
$totalRows_mate3l3 = mysql_num_rows($mate3l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l3, "text"));
$mate3l3 = mysql_query($query_mate3l3, $sistemacol) or die(mysql_error());
$row_mate3l3 = mysql_fetch_assoc($mate3l3);
$totalRows_mate3l3 = mysql_num_rows($mate3l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=3 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l3, "text"));
$mate3l3 = mysql_query($query_mate3l3, $sistemacol) or die(mysql_error());
$row_mate3l3 = mysql_fetch_assoc($mate3l3);
$totalRows_mate3l3 = mysql_num_rows($mate3l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=3  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3l3, "text"));
$mate3l3 = mysql_query($query_mate3l3, $sistemacol) or die(mysql_error());
$row_mate3l3 = mysql_fetch_assoc($mate3l3);
$totalRows_mate3l3 = mysql_num_rows($mate3l3);
}

// DEF MATERIA 3
$colname_mate3def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate3def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
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
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4, "text"));
$mate4 = mysql_query($query_mate4, $sistemacol) or die(mysql_error());
$row_mate4 = mysql_fetch_assoc($mate4);
$totalRows_mate4 = mysql_num_rows($mate4);
}

//LAPSO 1
$colname_mate4l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate4l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l1, "text"));
$mate4l1 = mysql_query($query_mate4l1, $sistemacol) or die(mysql_error());
$row_mate4l1 = mysql_fetch_assoc($mate4l1);
$totalRows_mate4l1 = mysql_num_rows($mate4l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l1, "text"));
$mate4l1 = mysql_query($query_mate4l1, $sistemacol) or die(mysql_error());
$row_mate4l1 = mysql_fetch_assoc($mate4l1);
$totalRows_mate4l1 = mysql_num_rows($mate4l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l1, "text"));

$mate4l1 = mysql_query($query_mate4l1, $sistemacol) or die(mysql_error());
$row_mate4l1 = mysql_fetch_assoc($mate4l1);
$totalRows_mate4l1 = mysql_num_rows($mate4l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l1, "text"));
$mate4l1 = mysql_query($query_mate4l1, $sistemacol) or die(mysql_error());
$row_mate4l1 = mysql_fetch_assoc($mate4l1);
$totalRows_mate4l1 = mysql_num_rows($mate4l1);
}

//LAPSO 2
$colname_mate4l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate4l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l2, "text"));
$mate4l2 = mysql_query($query_mate4l2, $sistemacol) or die(mysql_error());
$row_mate4l2 = mysql_fetch_assoc($mate4l2);
$totalRows_mate4l2 = mysql_num_rows($mate4l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l2, "text"));
$mate4l2 = mysql_query($query_mate4l2, $sistemacol) or die(mysql_error());
$row_mate4l2 = mysql_fetch_assoc($mate4l2);
$totalRows_mate4l2 = mysql_num_rows($mate4l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l2, "text"));
$mate4l2 = mysql_query($query_mate4l2, $sistemacol) or die(mysql_error());
$row_mate4l2 = mysql_fetch_assoc($mate4l2);
$totalRows_mate4l2 = mysql_num_rows($mate4l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=4  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l2, "text"));
$mate4l2 = mysql_query($query_mate4l2, $sistemacol) or die(mysql_error());
$row_mate4l2 = mysql_fetch_assoc($mate4l2);
$totalRows_mate4l2 = mysql_num_rows($mate4l2);
}

//LAPSO 3
$colname_mate4l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate4l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l3, "text"));

$mate4l3 = mysql_query($query_mate4l3, $sistemacol) or die(mysql_error());
$row_mate4l3 = mysql_fetch_assoc($mate4l3);
$totalRows_mate4l3 = mysql_num_rows($mate4l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l3, "text"));
$mate4l3 = mysql_query($query_mate4l3, $sistemacol) or die(mysql_error());
$row_mate4l3 = mysql_fetch_assoc($mate4l3);
$totalRows_mate4l3 = mysql_num_rows($mate4l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=4 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l3, "text"));
$mate4l3 = mysql_query($query_mate4l3, $sistemacol) or die(mysql_error());
$row_mate4l3 = mysql_fetch_assoc($mate4l3);
$totalRows_mate4l3 = mysql_num_rows($mate4l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=4  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4l3, "text"));
$mate4l3 = mysql_query($query_mate4l3, $sistemacol) or die(mysql_error());
$row_mate4l3 = mysql_fetch_assoc($mate4l3);
$totalRows_mate4l3 = mysql_num_rows($mate4l3);
}

// DEF MATERIA 4
$colname_mate4def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate4def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
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
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5, "text"));
$mate5 = mysql_query($query_mate5, $sistemacol) or die(mysql_error());
$row_mate5 = mysql_fetch_assoc($mate5);
$totalRows_mate5 = mysql_num_rows($mate5);
}

//LAPSO 1
$colname_mate5l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate5l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l1, "text"));
$mate5l1 = mysql_query($query_mate5l1, $sistemacol) or die(mysql_error());
$row_mate5l1 = mysql_fetch_assoc($mate5l1);
$totalRows_mate5l1 = mysql_num_rows($mate5l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l1, "text"));
$mate5l1 = mysql_query($query_mate5l1, $sistemacol) or die(mysql_error());
$row_mate5l1 = mysql_fetch_assoc($mate5l1);
$totalRows_mate5l1 = mysql_num_rows($mate5l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l1, "text"));

$mate5l1 = mysql_query($query_mate5l1, $sistemacol) or die(mysql_error());
$row_mate5l1 = mysql_fetch_assoc($mate5l1);
$totalRows_mate5l1 = mysql_num_rows($mate5l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l1, "text"));
$mate5l1 = mysql_query($query_mate5l1, $sistemacol) or die(mysql_error());
$row_mate5l1 = mysql_fetch_assoc($mate5l1);
$totalRows_mate5l1 = mysql_num_rows($mate5l1);
}

//LAPSO 2
$colname_mate5l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate5l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l2, "text"));
$mate5l2 = mysql_query($query_mate5l2, $sistemacol) or die(mysql_error());
$row_mate5l2 = mysql_fetch_assoc($mate5l2);
$totalRows_mate5l2 = mysql_num_rows($mate5l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l2, "text"));
$mate5l2 = mysql_query($query_mate5l2, $sistemacol) or die(mysql_error());
$row_mate5l2 = mysql_fetch_assoc($mate5l2);
$totalRows_mate5l2 = mysql_num_rows($mate5l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l2, "text"));
$mate5l2 = mysql_query($query_mate5l2, $sistemacol) or die(mysql_error());
$row_mate5l2 = mysql_fetch_assoc($mate5l2);
$totalRows_mate5l2 = mysql_num_rows($mate5l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=5  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l2, "text"));
$mate5l2 = mysql_query($query_mate5l2, $sistemacol) or die(mysql_error());
$row_mate5l2 = mysql_fetch_assoc($mate5l2);
$totalRows_mate5l2 = mysql_num_rows($mate5l2);
}

//LAPSO 3
$colname_mate5l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate5l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l3, "text"));

$mate5l3 = mysql_query($query_mate5l3, $sistemacol) or die(mysql_error());
$row_mate5l3 = mysql_fetch_assoc($mate5l3);
$totalRows_mate5l3 = mysql_num_rows($mate5l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l3, "text"));
$mate5l3 = mysql_query($query_mate5l3, $sistemacol) or die(mysql_error());
$row_mate5l3 = mysql_fetch_assoc($mate5l3);
$totalRows_mate5l3 = mysql_num_rows($mate5l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=5 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l3, "text"));
$mate5l3 = mysql_query($query_mate5l3, $sistemacol) or die(mysql_error());
$row_mate5l3 = mysql_fetch_assoc($mate5l3);
$totalRows_mate5l3 = mysql_num_rows($mate5l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=5  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5l3, "text"));
$mate5l3 = mysql_query($query_mate5l3, $sistemacol) or die(mysql_error());
$row_mate5l3 = mysql_fetch_assoc($mate5l3);
$totalRows_mate5l3 = mysql_num_rows($mate5l3);
}

// DEF MATERIA 5
$colname_mate5def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate5def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
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
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6, "text"));
$mate6 = mysql_query($query_mate6, $sistemacol) or die(mysql_error());
$row_mate6 = mysql_fetch_assoc($mate6);
$totalRows_mate6 = mysql_num_rows($mate6);
}

//LAPSO 1
$colname_mate6l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate6l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l1, "text"));
$mate6l1 = mysql_query($query_mate6l1, $sistemacol) or die(mysql_error());
$row_mate6l1 = mysql_fetch_assoc($mate6l1);
$totalRows_mate6l1 = mysql_num_rows($mate6l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l1, "text"));
$mate6l1 = mysql_query($query_mate6l1, $sistemacol) or die(mysql_error());
$row_mate6l1 = mysql_fetch_assoc($mate6l1);
$totalRows_mate6l1 = mysql_num_rows($mate6l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l1, "text"));

$mate6l1 = mysql_query($query_mate6l1, $sistemacol) or die(mysql_error());
$row_mate6l1 = mysql_fetch_assoc($mate6l1);
$totalRows_mate6l1 = mysql_num_rows($mate6l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l1, "text"));
$mate6l1 = mysql_query($query_mate6l1, $sistemacol) or die(mysql_error());
$row_mate6l1 = mysql_fetch_assoc($mate6l1);
$totalRows_mate6l1 = mysql_num_rows($mate6l1);
}

//LAPSO 2
$colname_mate6l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate6l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l2, "text"));
$mate6l2 = mysql_query($query_mate6l2, $sistemacol) or die(mysql_error());
$row_mate6l2 = mysql_fetch_assoc($mate6l2);
$totalRows_mate6l2 = mysql_num_rows($mate6l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l2, "text"));
$mate6l2 = mysql_query($query_mate6l2, $sistemacol) or die(mysql_error());
$row_mate6l2 = mysql_fetch_assoc($mate6l2);
$totalRows_mate6l2 = mysql_num_rows($mate6l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l2, "text"));
$mate6l2 = mysql_query($query_mate6l2, $sistemacol) or die(mysql_error());
$row_mate6l2 = mysql_fetch_assoc($mate6l2);
$totalRows_mate6l2 = mysql_num_rows($mate6l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=6  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l2, "text"));
$mate6l2 = mysql_query($query_mate6l2, $sistemacol) or die(mysql_error());
$row_mate6l2 = mysql_fetch_assoc($mate6l2);
$totalRows_mate6l2 = mysql_num_rows($mate6l2);
}

//LAPSO 3
$colname_mate6l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate6l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l3, "text"));

$mate6l3 = mysql_query($query_mate6l3, $sistemacol) or die(mysql_error());
$row_mate6l3 = mysql_fetch_assoc($mate6l3);
$totalRows_mate6l3 = mysql_num_rows($mate6l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l3, "text"));
$mate6l3 = mysql_query($query_mate6l3, $sistemacol) or die(mysql_error());
$row_mate6l3 = mysql_fetch_assoc($mate6l3);
$totalRows_mate6l3 = mysql_num_rows($mate6l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=6 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l3, "text"));
$mate6l3 = mysql_query($query_mate6l3, $sistemacol) or die(mysql_error());
$row_mate6l3 = mysql_fetch_assoc($mate6l3);
$totalRows_mate6l3 = mysql_num_rows($mate6l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=6  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6l3, "text"));
$mate6l3 = mysql_query($query_mate6l3, $sistemacol) or die(mysql_error());
$row_mate6l3 = mysql_fetch_assoc($mate6l3);
$totalRows_mate6l3 = mysql_num_rows($mate6l3);
}

// DEF MATERIA 6
$colname_mate6def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate6def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
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
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7, "text"));
$mate7 = mysql_query($query_mate7, $sistemacol) or die(mysql_error());
$row_mate7 = mysql_fetch_assoc($mate7);
$totalRows_mate7 = mysql_num_rows($mate7);
}

//LAPSO 1
$colname_mate7l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate7l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l1, "text"));
$mate7l1 = mysql_query($query_mate7l1, $sistemacol) or die(mysql_error());
$row_mate7l1 = mysql_fetch_assoc($mate7l1);
$totalRows_mate7l1 = mysql_num_rows($mate7l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l1, "text"));
$mate7l1 = mysql_query($query_mate7l1, $sistemacol) or die(mysql_error());
$row_mate7l1 = mysql_fetch_assoc($mate7l1);
$totalRows_mate7l1 = mysql_num_rows($mate7l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l1, "text"));

$mate7l1 = mysql_query($query_mate7l1, $sistemacol) or die(mysql_error());
$row_mate7l1 = mysql_fetch_assoc($mate7l1);
$totalRows_mate7l1 = mysql_num_rows($mate7l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l1, "text"));
$mate7l1 = mysql_query($query_mate7l1, $sistemacol) or die(mysql_error());
$row_mate7l1 = mysql_fetch_assoc($mate7l1);
$totalRows_mate7l1 = mysql_num_rows($mate7l1);
}

//LAPSO 2
$colname_mate7l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate7l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l2, "text"));
$mate7l2 = mysql_query($query_mate7l2, $sistemacol) or die(mysql_error());
$row_mate7l2 = mysql_fetch_assoc($mate7l2);
$totalRows_mate7l2 = mysql_num_rows($mate7l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l2, "text"));
$mate7l2 = mysql_query($query_mate7l2, $sistemacol) or die(mysql_error());
$row_mate7l2 = mysql_fetch_assoc($mate7l2);
$totalRows_mate7l2 = mysql_num_rows($mate7l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l2, "text"));
$mate7l2 = mysql_query($query_mate7l2, $sistemacol) or die(mysql_error());
$row_mate7l2 = mysql_fetch_assoc($mate7l2);
$totalRows_mate7l2 = mysql_num_rows($mate7l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=7  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l2, "text"));
$mate7l2 = mysql_query($query_mate7l2, $sistemacol) or die(mysql_error());
$row_mate7l2 = mysql_fetch_assoc($mate7l2);
$totalRows_mate7l2 = mysql_num_rows($mate7l2);
}

//LAPSO 3
$colname_mate7l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate7l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l3, "text"));

$mate7l3 = mysql_query($query_mate7l3, $sistemacol) or die(mysql_error());
$row_mate7l3 = mysql_fetch_assoc($mate7l3);
$totalRows_mate7l3 = mysql_num_rows($mate7l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l3, "text"));
$mate7l3 = mysql_query($query_mate7l3, $sistemacol) or die(mysql_error());
$row_mate7l3 = mysql_fetch_assoc($mate7l3);
$totalRows_mate7l3 = mysql_num_rows($mate7l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=7 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l3, "text"));
$mate7l3 = mysql_query($query_mate7l3, $sistemacol) or die(mysql_error());
$row_mate7l3 = mysql_fetch_assoc($mate7l3);
$totalRows_mate7l3 = mysql_num_rows($mate7l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=7  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7l3, "text"));
$mate7l3 = mysql_query($query_mate7l3, $sistemacol) or die(mysql_error());
$row_mate7l3 = mysql_fetch_assoc($mate7l3);
$totalRows_mate7l3 = mysql_num_rows($mate7l3);
}

// DEF MATERIA 7
$colname_mate7def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate7def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
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
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8, "text"));
$mate8 = mysql_query($query_mate8, $sistemacol) or die(mysql_error());
$row_mate8 = mysql_fetch_assoc($mate8);
$totalRows_mate8 = mysql_num_rows($mate8);
}

//LAPSO 1
$colname_mate8l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate8l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l1, "text"));
$mate8l1 = mysql_query($query_mate8l1, $sistemacol) or die(mysql_error());
$row_mate8l1 = mysql_fetch_assoc($mate8l1);
$totalRows_mate8l1 = mysql_num_rows($mate8l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l1, "text"));
$mate8l1 = mysql_query($query_mate8l1, $sistemacol) or die(mysql_error());
$row_mate8l1 = mysql_fetch_assoc($mate8l1);
$totalRows_mate8l1 = mysql_num_rows($mate8l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l1, "text"));

$mate8l1 = mysql_query($query_mate8l1, $sistemacol) or die(mysql_error());
$row_mate8l1 = mysql_fetch_assoc($mate8l1);
$totalRows_mate8l1 = mysql_num_rows($mate8l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l1, "text"));
$mate8l1 = mysql_query($query_mate8l1, $sistemacol) or die(mysql_error());
$row_mate8l1 = mysql_fetch_assoc($mate8l1);
$totalRows_mate8l1 = mysql_num_rows($mate8l1);
}

//LAPSO 2
$colname_mate8l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate8l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l2, "text"));
$mate8l2 = mysql_query($query_mate8l2, $sistemacol) or die(mysql_error());
$row_mate8l2 = mysql_fetch_assoc($mate8l2);
$totalRows_mate8l2 = mysql_num_rows($mate8l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l2, "text"));
$mate8l2 = mysql_query($query_mate8l2, $sistemacol) or die(mysql_error());
$row_mate8l2 = mysql_fetch_assoc($mate8l2);
$totalRows_mate8l2 = mysql_num_rows($mate8l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l2, "text"));
$mate8l2 = mysql_query($query_mate8l2, $sistemacol) or die(mysql_error());
$row_mate8l2 = mysql_fetch_assoc($mate8l2);
$totalRows_mate8l2 = mysql_num_rows($mate8l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=8  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l2, "text"));
$mate8l2 = mysql_query($query_mate8l2, $sistemacol) or die(mysql_error());
$row_mate8l2 = mysql_fetch_assoc($mate8l2);
$totalRows_mate8l2 = mysql_num_rows($mate8l2);
}

//LAPSO 3
$colname_mate8l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate8l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l3, "text"));

$mate8l3 = mysql_query($query_mate8l3, $sistemacol) or die(mysql_error());
$row_mate8l3 = mysql_fetch_assoc($mate8l3);
$totalRows_mate8l3 = mysql_num_rows($mate8l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l3, "text"));
$mate8l3 = mysql_query($query_mate8l3, $sistemacol) or die(mysql_error());
$row_mate8l3 = mysql_fetch_assoc($mate8l3);
$totalRows_mate8l3 = mysql_num_rows($mate8l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=8 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l3, "text"));
$mate8l3 = mysql_query($query_mate8l3, $sistemacol) or die(mysql_error());
$row_mate8l3 = mysql_fetch_assoc($mate8l3);
$totalRows_mate8l3 = mysql_num_rows($mate8l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=8  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8l3, "text"));
$mate8l3 = mysql_query($query_mate8l3, $sistemacol) or die(mysql_error());
$row_mate8l3 = mysql_fetch_assoc($mate8l3);
$totalRows_mate8l3 = mysql_num_rows($mate8l3);
}

// DEF MATERIA 8
$colname_mate8def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate8def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
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
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9, "text"));
$mate9 = mysql_query($query_mate9, $sistemacol) or die(mysql_error());
$row_mate9 = mysql_fetch_assoc($mate9);
$totalRows_mate9 = mysql_num_rows($mate9);
}

//LAPSO 1
$colname_mate9l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate9l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l1, "text"));
$mate9l1 = mysql_query($query_mate9l1, $sistemacol) or die(mysql_error());
$row_mate9l1 = mysql_fetch_assoc($mate9l1);
$totalRows_mate9l1 = mysql_num_rows($mate9l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l1, "text"));
$mate9l1 = mysql_query($query_mate9l1, $sistemacol) or die(mysql_error());
$row_mate9l1 = mysql_fetch_assoc($mate9l1);
$totalRows_mate9l1 = mysql_num_rows($mate9l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l1, "text"));

$mate9l1 = mysql_query($query_mate9l1, $sistemacol) or die(mysql_error());
$row_mate9l1 = mysql_fetch_assoc($mate9l1);
$totalRows_mate9l1 = mysql_num_rows($mate9l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l1, "text"));
$mate9l1 = mysql_query($query_mate9l1, $sistemacol) or die(mysql_error());
$row_mate9l1 = mysql_fetch_assoc($mate9l1);
$totalRows_mate9l1 = mysql_num_rows($mate9l1);
}

//LAPSO 2
$colname_mate9l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate9l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l2, "text"));
$mate9l2 = mysql_query($query_mate9l2, $sistemacol) or die(mysql_error());
$row_mate9l2 = mysql_fetch_assoc($mate9l2);
$totalRows_mate9l2 = mysql_num_rows($mate9l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l2, "text"));
$mate9l2 = mysql_query($query_mate9l2, $sistemacol) or die(mysql_error());
$row_mate9l2 = mysql_fetch_assoc($mate9l2);
$totalRows_mate9l2 = mysql_num_rows($mate9l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l2, "text"));
$mate9l2 = mysql_query($query_mate9l2, $sistemacol) or die(mysql_error());
$row_mate9l2 = mysql_fetch_assoc($mate9l2);
$totalRows_mate9l2 = mysql_num_rows($mate9l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=9  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l2, "text"));
$mate9l2 = mysql_query($query_mate9l2, $sistemacol) or die(mysql_error());
$row_mate9l2 = mysql_fetch_assoc($mate9l2);
$totalRows_mate9l2 = mysql_num_rows($mate9l2);
}

//LAPSO 3
$colname_mate9l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate9l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l3, "text"));

$mate9l3 = mysql_query($query_mate9l3, $sistemacol) or die(mysql_error());
$row_mate9l3 = mysql_fetch_assoc($mate9l3);
$totalRows_mate9l3 = mysql_num_rows($mate9l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l3, "text"));
$mate9l3 = mysql_query($query_mate9l3, $sistemacol) or die(mysql_error());
$row_mate9l3 = mysql_fetch_assoc($mate9l3);
$totalRows_mate9l3 = mysql_num_rows($mate9l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=9 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l3, "text"));
$mate9l3 = mysql_query($query_mate9l3, $sistemacol) or die(mysql_error());
$row_mate9l3 = mysql_fetch_assoc($mate9l3);
$totalRows_mate9l3 = mysql_num_rows($mate9l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=9  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9l3, "text"));
$mate9l3 = mysql_query($query_mate9l3, $sistemacol) or die(mysql_error());
$row_mate9l3 = mysql_fetch_assoc($mate9l3);
$totalRows_mate9l3 = mysql_num_rows($mate9l3);
}

// DEF MATERIA 9
$colname_mate9def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate9def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
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
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10, "text"));
$mate10 = mysql_query($query_mate10, $sistemacol) or die(mysql_error());
$row_mate10 = mysql_fetch_assoc($mate10);
$totalRows_mate10 = mysql_num_rows($mate10);
}

//LAPSO 1
$colname_mate10l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate10l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l1, "text"));
$mate10l1 = mysql_query($query_mate10l1, $sistemacol) or die(mysql_error());
$row_mate10l1 = mysql_fetch_assoc($mate10l1);
$totalRows_mate10l1 = mysql_num_rows($mate10l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l1, "text"));
$mate10l1 = mysql_query($query_mate10l1, $sistemacol) or die(mysql_error());
$row_mate10l1 = mysql_fetch_assoc($mate10l1);
$totalRows_mate10l1 = mysql_num_rows($mate10l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l1, "text"));

$mate10l1 = mysql_query($query_mate10l1, $sistemacol) or die(mysql_error());
$row_mate10l1 = mysql_fetch_assoc($mate10l1);
$totalRows_mate10l1 = mysql_num_rows($mate10l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l1, "text"));
$mate10l1 = mysql_query($query_mate10l1, $sistemacol) or die(mysql_error());
$row_mate10l1 = mysql_fetch_assoc($mate10l1);
$totalRows_mate10l1 = mysql_num_rows($mate10l1);
}

//LAPSO 2
$colname_mate10l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate10l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l2, "text"));
$mate10l2 = mysql_query($query_mate10l2, $sistemacol) or die(mysql_error());
$row_mate10l2 = mysql_fetch_assoc($mate10l2);
$totalRows_mate10l2 = mysql_num_rows($mate10l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l2, "text"));
$mate10l2 = mysql_query($query_mate10l2, $sistemacol) or die(mysql_error());
$row_mate10l2 = mysql_fetch_assoc($mate10l2);
$totalRows_mate10l2 = mysql_num_rows($mate10l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l2, "text"));
$mate10l2 = mysql_query($query_mate10l2, $sistemacol) or die(mysql_error());
$row_mate10l2 = mysql_fetch_assoc($mate10l2);
$totalRows_mate10l2 = mysql_num_rows($mate10l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=10  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l2, "text"));
$mate10l2 = mysql_query($query_mate10l2, $sistemacol) or die(mysql_error());
$row_mate10l2 = mysql_fetch_assoc($mate10l2);
$totalRows_mate10l2 = mysql_num_rows($mate10l2);
}

//LAPSO 3
$colname_mate10l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate10l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l3, "text"));

$mate10l3 = mysql_query($query_mate10l3, $sistemacol) or die(mysql_error());
$row_mate10l3 = mysql_fetch_assoc($mate10l3);
$totalRows_mate10l3 = mysql_num_rows($mate10l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l3, "text"));
$mate10l3 = mysql_query($query_mate10l3, $sistemacol) or die(mysql_error());
$row_mate10l3 = mysql_fetch_assoc($mate10l3);
$totalRows_mate10l3 = mysql_num_rows($mate10l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=10 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l3, "text"));
$mate10l3 = mysql_query($query_mate10l3, $sistemacol) or die(mysql_error());
$row_mate10l3 = mysql_fetch_assoc($mate10l3);
$totalRows_mate10l3 = mysql_num_rows($mate10l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=10  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10l3, "text"));
$mate10l3 = mysql_query($query_mate10l3, $sistemacol) or die(mysql_error());
$row_mate10l3 = mysql_fetch_assoc($mate10l3);
$totalRows_mate10l3 = mysql_num_rows($mate10l3);
}

// DEF MATERIA 10
$colname_mate10def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate10def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
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
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11, "text"));
$mate11 = mysql_query($query_mate11, $sistemacol) or die(mysql_error());
$row_mate11 = mysql_fetch_assoc($mate11);
$totalRows_mate11 = mysql_num_rows($mate11);
}

//LAPSO 1
$colname_mate11l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate11l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l1, "text"));
$mate11l1 = mysql_query($query_mate11l1, $sistemacol) or die(mysql_error());
$row_mate11l1 = mysql_fetch_assoc($mate11l1);
$totalRows_mate11l1 = mysql_num_rows($mate11l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l1, "text"));
$mate11l1 = mysql_query($query_mate11l1, $sistemacol) or die(mysql_error());
$row_mate11l1 = mysql_fetch_assoc($mate11l1);
$totalRows_mate11l1 = mysql_num_rows($mate11l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l1, "text"));
$mate11l1 = mysql_query($query_mate11l1, $sistemacol) or die(mysql_error());
$row_mate11l1 = mysql_fetch_assoc($mate11l1);
$totalRows_mate11l1 = mysql_num_rows($mate11l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=11  GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l1, "int"));
$mate11l1 = mysql_query($query_mate11l1, $sistemacol) or die(mysql_error());
$row_mate11l1 = mysql_fetch_assoc($mate11l1);
$totalRows_mate11l1 = mysql_num_rows($mate11l1);
}

//LAPSO 2
$colname_mate11l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate11l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l2, "text"));
$mate11l2 = mysql_query($query_mate11l2, $sistemacol) or die(mysql_error());
$row_mate11l2 = mysql_fetch_assoc($mate11l2);
$totalRows_mate11l2 = mysql_num_rows($mate11l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l2, "text"));
$mate11l2 = mysql_query($query_mate11l2, $sistemacol) or die(mysql_error());
$row_mate11l2 = mysql_fetch_assoc($mate11l2);
$totalRows_mate11l2 = mysql_num_rows($mate11l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l2, "text"));
$mate11l2 = mysql_query($query_mate11l2, $sistemacol) or die(mysql_error());
$row_mate11l2 = mysql_fetch_assoc($mate11l2);
$totalRows_mate11l2 = mysql_num_rows($mate11l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=11  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l2, "text"));
$mate11l2 = mysql_query($query_mate11l2, $sistemacol) or die(mysql_error());
$row_mate11l2 = mysql_fetch_assoc($mate11l2);
$totalRows_mate11l2 = mysql_num_rows($mate11l2);
}

//LAPSO 3
$colname_mate11l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate11l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l3, "text"));
$mate11l3 = mysql_query($query_mate11l3, $sistemacol) or die(mysql_error());
$row_mate11l3 = mysql_fetch_assoc($mate11l3);
$totalRows_mate11l3 = mysql_num_rows($mate11l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l3, "text"));
$mate11l3 = mysql_query($query_mate11l3, $sistemacol) or die(mysql_error());
$row_mate11l3 = mysql_fetch_assoc($mate11l3);
$totalRows_mate11l3 = mysql_num_rows($mate11l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=11 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l3, "text"));
$mate11l3 = mysql_query($query_mate11l3, $sistemacol) or die(mysql_error());
$row_mate11l3 = mysql_fetch_assoc($mate11l3);
$totalRows_mate11l3 = mysql_num_rows($mate11l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=11  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11l3, "text"));
$mate11l3 = mysql_query($query_mate11l3, $sistemacol) or die(mysql_error());
$row_mate11l3 = mysql_fetch_assoc($mate11l3);
$totalRows_mate11l3 = mysql_num_rows($mate11l3);
}

// DEF MATERIA 11
$colname_mate11def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate11def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
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
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12, "text"));
$mate12 = mysql_query($query_mate12, $sistemacol) or die(mysql_error());
$row_mate12 = mysql_fetch_assoc($mate12);
$totalRows_mate12 = mysql_num_rows($mate12);
}

//LAPSO 1
$colname_mate12l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate12l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l1, "text"));
$mate12l1 = mysql_query($query_mate12l1, $sistemacol) or die(mysql_error());
$row_mate12l1 = mysql_fetch_assoc($mate12l1);
$totalRows_mate12l1 = mysql_num_rows($mate12l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l1, "text"));
$mate12l1 = mysql_query($query_mate12l1, $sistemacol) or die(mysql_error());
$row_mate12l1 = mysql_fetch_assoc($mate12l1);
$totalRows_mate12l1 = mysql_num_rows($mate12l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l1, "text"));
$mate12l1 = mysql_query($query_mate12l1, $sistemacol) or die(mysql_error());
$row_mate12l1 = mysql_fetch_assoc($mate12l1);
$totalRows_mate12l1 = mysql_num_rows($mate12l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l1, "text"));
$mate12l1 = mysql_query($query_mate12l1, $sistemacol) or die(mysql_error());
$row_mate12l1 = mysql_fetch_assoc($mate12l1);
$totalRows_mate12l1 = mysql_num_rows($mate12l1);
}

//LAPSO 2
$colname_mate12l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate12l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l2, "text"));
$mate12l2 = mysql_query($query_mate12l2, $sistemacol) or die(mysql_error());
$row_mate12l2 = mysql_fetch_assoc($mate12l2);
$totalRows_mate12l2 = mysql_num_rows($mate12l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l2, "text"));
$mate12l2 = mysql_query($query_mate12l2, $sistemacol) or die(mysql_error());
$row_mate12l2 = mysql_fetch_assoc($mate12l2);
$totalRows_mate12l2 = mysql_num_rows($mate12l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l2, "text"));
$mate12l2 = mysql_query($query_mate12l2, $sistemacol) or die(mysql_error());
$row_mate12l2 = mysql_fetch_assoc($mate12l2);
$totalRows_mate12l2 = mysql_num_rows($mate12l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=12  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l2, "text"));
$mate12l2 = mysql_query($query_mate12l2, $sistemacol) or die(mysql_error());
$row_mate12l2 = mysql_fetch_assoc($mate12l2);
$totalRows_mate12l2 = mysql_num_rows($mate12l2);
}

//LAPSO 3
$colname_mate12l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate12l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l3, "text"));
$mate12l3 = mysql_query($query_mate12l3, $sistemacol) or die(mysql_error());
$row_mate12l3 = mysql_fetch_assoc($mate12l3);
$totalRows_mate12l3 = mysql_num_rows($mate12l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l3, "text"));
$mate12l3 = mysql_query($query_mate12l3, $sistemacol) or die(mysql_error());
$row_mate12l3 = mysql_fetch_assoc($mate12l3);
$totalRows_mate12l3 = mysql_num_rows($mate12l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=12 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l3, "text"));
$mate12l3 = mysql_query($query_mate12l3, $sistemacol) or die(mysql_error());
$row_mate12l3 = mysql_fetch_assoc($mate12l3);
$totalRows_mate12l3 = mysql_num_rows($mate12l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=12  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12l3, "text"));
$mate12l3 = mysql_query($query_mate12l3, $sistemacol) or die(mysql_error());
$row_mate1l3 = mysql_fetch_assoc($mate1l3);
$totalRows_mate1l3 = mysql_num_rows($mate1l3);
}

// DEF MATERIA 12
$colname_mate12def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate12def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
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
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13, "text"));
$mate13 = mysql_query($query_mate13, $sistemacol) or die(mysql_error());
$row_mate13 = mysql_fetch_assoc($mate13);
$totalRows_mate13 = mysql_num_rows($mate13);
}

//LAPSO 1
$colname_mate13l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate13l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l1, "text"));
$mate13l1 = mysql_query($query_mate13l1, $sistemacol) or die(mysql_error());
$row_mate13l1 = mysql_fetch_assoc($mate13l1);
$totalRows_mate13l1 = mysql_num_rows($mate13l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l1, "text"));
$mate13l1 = mysql_query($query_mate13l1, $sistemacol) or die(mysql_error());
$row_mate13l1 = mysql_fetch_assoc($mate13l1);
$totalRows_mate13l1 = mysql_num_rows($mate13l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l1, "text"));
$mate13l1 = mysql_query($query_mate13l1, $sistemacol) or die(mysql_error());
$row_mate13l1 = mysql_fetch_assoc($mate13l1);
$totalRows_mate13l1 = mysql_num_rows($mate13l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l1, "text"));
$mate13l1 = mysql_query($query_mate13l1, $sistemacol) or die(mysql_error());
$row_mate13l1 = mysql_fetch_assoc($mate13l1);
$totalRows_mate13l1 = mysql_num_rows($mate13l1);
}

//LAPSO 2
$colname_mate13l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate13l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l2, "text"));
$mate13l2 = mysql_query($query_mate13l2, $sistemacol) or die(mysql_error());
$row_mate13l2 = mysql_fetch_assoc($mate13l2);
$totalRows_mate13l2 = mysql_num_rows($mate13l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l2, "text"));
$mate13l2 = mysql_query($query_mate13l2, $sistemacol) or die(mysql_error());
$row_mate13l2 = mysql_fetch_assoc($mate13l2);
$totalRows_mate13l2 = mysql_num_rows($mate13l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l2, "text"));
$mate13l2 = mysql_query($query_mate13l2, $sistemacol) or die(mysql_error());
$row_mate13l2 = mysql_fetch_assoc($mate13l2);
$totalRows_mate13l2 = mysql_num_rows($mate13l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.orden_asignatura=13  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l2, "text"));
$mate13l2 = mysql_query($query_mate13l2, $sistemacol) or die(mysql_error());
$row_mate13l2 = mysql_fetch_assoc($mate13l2);
$totalRows_mate13l2 = mysql_num_rows($mate13l2);
}

//LAPSO 3
$colname_mate13l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate13l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l3, "text"));
$mate13l3 = mysql_query($query_mate13l3, $sistemacol) or die(mysql_error());
$row_mate13l3 = mysql_fetch_assoc($mate13l3);
$totalRows_mate13l3 = mysql_num_rows($mate13l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l3, "text"));
$mate13l3 = mysql_query($query_mate13l3, $sistemacol) or die(mysql_error());
$row_mate13l3 = mysql_fetch_assoc($mate13l3);
$totalRows_mate13l3 = mysql_num_rows($mate13l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=13 GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l3, "text"));
$mate13l3 = mysql_query($query_mate13l3, $sistemacol) or die(mysql_error());
$row_mate13l3 = mysql_fetch_assoc($mate13l3);
$totalRows_mate13l3 = mysql_num_rows($mate13l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.orden_asignatura=13  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13l3, "text"));
$mate13l3 = mysql_query($query_mate13l3, $sistemacol) or die(mysql_error());
$row_mate13l3 = mysql_fetch_assoc($mate13l3);
$totalRows_mate13l3 = mysql_num_rows($mate13l3);
}

// DEF MATERIA 13
$colname_mate13def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate13def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}



// AGRUPANDO EDUCACION PARA EL TRABAJO

//LAPSO 1
$colname_mate14l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate14l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l1, "text"));
$mate14l1 = mysql_query($query_mate14l1, $sistemacol) or die(mysql_error());
$row_mate14l1 = mysql_fetch_assoc($mate14l1);
$totalRows_mate14l1 = mysql_num_rows($mate14l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l1, "text"));
$mate14l1 = mysql_query($query_mate14l1, $sistemacol) or die(mysql_error());
$row_mate14l1 = mysql_fetch_assoc($mate14l1);
$totalRows_mate14l1 = mysql_num_rows($mate14l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l1, "text"));
$mate14l1 = mysql_query($query_mate14l1, $sistemacol) or die(mysql_error());
$row_mate14l1 = mysql_fetch_assoc($mate14l1);
$totalRows_mate14l1 = mysql_num_rows($mate14l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l1, "text"));
$mate14l1 = mysql_query($query_mate14l1, $sistemacol) or die(mysql_error());
$row_mate14l1 = mysql_fetch_assoc($mate14l1);
$totalRows_mate14l1 = mysql_num_rows($mate14l1);
}

//LAPSO 2
$colname_mate14l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate14l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l2, "text"));
$mate14l2 = mysql_query($query_mate14l2, $sistemacol) or die(mysql_error());
$row_mate14l2 = mysql_fetch_assoc($mate14l2);
$totalRows_mate14l2 = mysql_num_rows($mate14l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l2, "text"));
$mate14l2 = mysql_query($query_mate14l2, $sistemacol) or die(mysql_error());
$row_mate14l2 = mysql_fetch_assoc($mate14l2);
$totalRows_mate14l2 = mysql_num_rows($mate14l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l2, "text"));
$mate14l2 = mysql_query($query_mate14l2, $sistemacol) or die(mysql_error());
$row_mate14l2 = mysql_fetch_assoc($mate14l2);
$totalRows_mate14l2 = mysql_num_rows($mate14l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='educacion_trabajo'  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l2, "text"));
$mate14l2 = mysql_query($query_mate14l2, $sistemacol) or die(mysql_error());
$row_mate14l2 = mysql_fetch_assoc($mate14l2);
$totalRows_mate14l2 = mysql_num_rows($mate14l2);
}

//LAPSO 3
$colname_mate14l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate14l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l3, "text"));
$mate14l3 = mysql_query($query_mate14l3, $sistemacol) or die(mysql_error());
$row_mate14l3 = mysql_fetch_assoc($mate14l3);
$totalRows_mate14l3 = mysql_num_rows($mate14l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l3, "text"));
$mate14l3 = mysql_query($query_mate14l3, $sistemacol) or die(mysql_error());
$row_mate14l3 = mysql_fetch_assoc($mate14l3);
$totalRows_mate14l3 = mysql_num_rows($mate14l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l3, "text"));
$mate14l3 = mysql_query($query_mate14l3, $sistemacol) or die(mysql_error());
$row_mate14l3 = mysql_fetch_assoc($mate14l3);
$totalRows_mate14l3 = mysql_num_rows($mate14l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='educacion_trabajo'  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14l3, "text"));
$mate14l3 = mysql_query($query_mate14l3, $sistemacol) or die(mysql_error());
$row_mate14l3 = mysql_fetch_assoc($mate14l3);
$totalRows_mate14l3 = mysql_num_rows($mate14l3);
}

// DEF MATERIA 14
$colname_mate14def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate14def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}


// AGRUPANDO INSTRUCCION PREMILITAR

//LAPSO 1
$colname_mate17l1 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate17l1 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l1, "text"));
$mate17l1 = mysql_query($query_mate17l1, $sistemacol) or die(mysql_error());
$row_mate17l1 = mysql_fetch_assoc($mate17l1);
$totalRows_mate17l1 = mysql_num_rows($mate17l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l1, "text"));
$mate17l1 = mysql_query($query_mate17l1, $sistemacol) or die(mysql_error());
$row_mate17l1 = mysql_fetch_assoc($mate17l1);
$totalRows_mate17l1 = mysql_num_rows($mate17l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=1 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l1, "text"));
$mate17l1 = mysql_query($query_mate17l1, $sistemacol) or die(mysql_error());
$row_mate17l1 = mysql_fetch_assoc($mate17l1);
$totalRows_mate17l1 = mysql_num_rows($mate17l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s  AND c.lapso=1 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l1, "text"));
$mate17l1 = mysql_query($query_mate17l1, $sistemacol) or die(mysql_error());
$row_mate17l1 = mysql_fetch_assoc($mate17l1);
$totalRows_mate17l1 = mysql_num_rows($mate17l1);
}

//LAPSO 2
$colname_mate17l2 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate17l2 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l2, "text"));
$mate17l2 = mysql_query($query_mate17l2, $sistemacol) or die(mysql_error());
$row_mate17l2 = mysql_fetch_assoc($mate17l2);
$totalRows_mate17l2 = mysql_num_rows($mate17l2);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l2, "text"));
$mate17l2 = mysql_query($query_mate17l2, $sistemacol) or die(mysql_error());
$row_mate17l2 = mysql_fetch_assoc($mate17l2);
$totalRows_mate17l2 = mysql_num_rows($mate17l2);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l2, "text"));
$mate17l2 = mysql_query($query_mate17l2, $sistemacol) or die(mysql_error());
$row_mate17l2 = mysql_fetch_assoc($mate17l2);
$totalRows_mate17l2 = mysql_num_rows($mate17l2);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l2 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=2 AND d.tipo_asignatura='premilitar'  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l2, "text"));
$mate17l2 = mysql_query($query_mate17l2, $sistemacol) or die(mysql_error());
$row_mate17l2 = mysql_fetch_assoc($mate17l2);
$totalRows_mate17l2 = mysql_num_rows($mate17l2);
}

//LAPSO 3
$colname_mate17l3 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate17l3 = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l3, "text"));
$mate17l3 = mysql_query($query_mate17l3, $sistemacol) or die(mysql_error());
$row_mate17l3 = mysql_fetch_assoc($mate17l3);
$totalRows_mate17l3 = mysql_num_rows($mate17l3);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l3, "text"));
$mate17l3 = mysql_query($query_mate17l3, $sistemacol) or die(mysql_error());
$row_mate17l3 = mysql_fetch_assoc($mate17l3);
$totalRows_mate17l3 = mysql_num_rows($mate17l3);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l3, "text"));
$mate17l3 = mysql_query($query_mate17l3, $sistemacol) or die(mysql_error());
$row_mate17l3 = mysql_fetch_assoc($mate17l3);
$totalRows_mate17l3 = mysql_num_rows($mate17l3);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17l3 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND c.lapso=3 AND d.tipo_asignatura='premilitar'  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17l3, "text"));
$mate17l3 = mysql_query($query_mate17l3, $sistemacol) or die(mysql_error());
$row_mate17l3 = mysql_fetch_assoc($mate17l3);
$totalRows_mate17l3 = mysql_num_rows($mate17l3);
}

// DEF MATERIA 14
$colname_mate17def = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate17def = $_GET['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17def, "text"));
$mate17def = mysql_query($query_mate17def, $sistemacol) or die(mysql_error());
$row_mate17def = mysql_fetch_assoc($mate17def);
$totalRows_mate17def = mysql_num_rows($mate17def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17def, "text"));
$mate17def = mysql_query($query_mate17def, $sistemacol) or die(mysql_error());
$row_mate17def = mysql_fetch_assoc($mate17def);
$totalRows_mate17def = mysql_num_rows($mate17def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17def, "text"));
$mate17def = mysql_query($query_mate17def, $sistemacol) or die(mysql_error());
$row_mate17def = mysql_fetch_assoc($mate17def);
$totalRows_mate17def = mysql_num_rows($mate17def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate17def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s AND d.tipo_asignatura='premilitar' GROUP BY a.alumno_id  ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate17def, "text"));
$mate17def = mysql_query($query_mate17def, $sistemacol) or die(mysql_error());
$row_mate17def = mysql_fetch_assoc($mate17def);
$totalRows_mate17def = mysql_num_rows($mate17def);
}


// PROMEDIO DE AÑO
$colname_mate15 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate15 = $_GET['curso_id'];
}

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.def>0 AND b.curso_id = %s  GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.def>0 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.def>0 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.def>0 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}

// lapso en curso 

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapsocurso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapsocurso = mysql_query($query_lapsocurso, $sistemacol) or die(mysql_error());
$row_lapsocurso = mysql_fetch_assoc($lapsocurso);
$totalRows_lapsocurso = mysql_num_rows($lapsocurso);
$lap=$row_lapsocurso['cod'];


// PROMEDIO DE LAPSO
$colname_mate16 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate16 = $_GET['curso_id'];
}

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate16 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.lapso=$lap AND c.def>0 AND b.curso_id = %s  GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate16, "int"));
$mate16 = mysql_query($query_mate16, $sistemacol) or die(mysql_error());
$row_mate16 = mysql_fetch_assoc($mate16);
$totalRows_mate16 = mysql_num_rows($mate16);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate16 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.lapso=$lap AND c.def>0 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate16, "int"));
$mate16 = mysql_query($query_mate16, $sistemacol) or die(mysql_error());
$row_mate16 = mysql_fetch_assoc($mate16);
$totalRows_mate16 = mysql_num_rows($mate16);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate16 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.lapso=$lap AND c.def>0 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate16, "int"));
$mate16 = mysql_query($query_mate16, $sistemacol) or die(mysql_error());
$row_mate16 = mysql_fetch_assoc($mate16);
$totalRows_mate16 = mysql_num_rows($mate16);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate16 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND c.lapso=$lap AND c.def>0 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate16, "int"));
$mate16 = mysql_query($query_mate16, $sistemacol) or die(mysql_error());
$row_mate16 = mysql_fetch_assoc($mate16);
$totalRows_mate16 = mysql_num_rows($mate16);
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodoactual = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodoactual = mysql_query($query_periodoactual, $sistemacol) or die(mysql_error());
$row_periodoactual = mysql_fetch_assoc($periodoactual);
$totalRows_periodoactual = mysql_num_rows($periodoactual);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/form_impresion.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="1200"><tr><td>
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
		<td align="center">
			<h2>SABANA DE CALIFICACIONES </h2>
			<h3>Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?><br>
          A&ntilde;o Escolar <?php echo $row_periodoactual['descripcion']; ?>			
			</h3>
		</td>
</td></tr></table>

<br />
<br />


<table width="1200" ><tr>


<?php // MATERIA 1
?> 
<td align="right">
<table><tr><td>
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid;  " align="center">
NO.
</td>
<td  class="ancho_td_cedula" style="border-bottom:1px solid; border-right:1px solid; " align="center">
CEDULA
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; " align="center" >

APELLIDOS Y NOMBRES

</tr>



<?php $lista=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?></span>
</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
<span class="texto_pequeno_gris">&nbsp;&nbsp;<?php echo $row_mate1['apellido'].", ". $row_mate1['nombre']; ?></span>
</td>

</tr>
<?php } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</td>
</tr></table>
</td>


<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate1l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate1l1['def']==0){ echo "NC";} if(($row_mate1l1['def']>0) and ($row_mate1l1['def']<10)){ echo "0".$row_mate1l1['def'];} if(($row_mate1l1['def']>9) and ($row_mate1l1['def']<=20)){ echo $row_mate1l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate1l1 = mysql_fetch_assoc($mate1l1)); ?>
</table>
</td>

<?php if($totalRows_mate1l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate1l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate1l2['def']==0){ echo "NC";} if(($row_mate1l2['def']>0) and ($row_mate1l2['def']<10)){ echo "0".$row_mate1l2['def'];} if(($row_mate1l2['def']>9) and ($row_mate1l2['def']<=20)){ echo $row_mate1l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate1l2 = mysql_fetch_assoc($mate1l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate1l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate1l3['mate']; ?></b><br />L3</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate1l3['def']==0){ echo "NC";} if(($row_mate1l3['def']>0) and ($row_mate1l3['def']<10)){ echo "0".$row_mate1l3['def'];} if(($row_mate1l3['def']>9) and ($row_mate1l3['def']<=20)){ echo $row_mate1l3['def'];} ?>
</td>
</tr>
<?php } while ($row_mate1l3 = mysql_fetch_assoc($mate1l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>




<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate1def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate1def['def']==0){ echo "NC";} if(($row_mate1def['def']>0) and ($row_mate1def['def']<10)){ echo "0".$row_mate1def['def'];} if(($row_mate1def['def']>9) and ($row_mate1def['def']<=20)){ echo $row_mate1def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate1def = mysql_fetch_assoc($mate1def)); ?>
</table>
</td>




<?php // MATERIA 2
if (($totalRows_mate2>0) and ($row_mate2['tipo_asignatura']=="")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate2l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate2l1['def']==0){ echo "NC";} if(($row_mate2l1['def']>0) and ($row_mate2l1['def']<10)){ echo "0".$row_mate2l1['def'];} if(($row_mate2l1['def']>9) and ($row_mate2l1['def']<=20)){ echo $row_mate2l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate2l1 = mysql_fetch_assoc($mate2l1)); ?>
</table>
</td>

<?php if($totalRows_mate2l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate2l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate2l2['def']==0){ echo "NC";} if(($row_mate2l2['def']>0) and ($row_mate2l2['def']<10)){ echo "0".$row_mate2l2['def'];} if(($row_mate2l2['def']>9) and ($row_mate2l2['def']<=20)){ echo $row_mate2l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate2l2 = mysql_fetch_assoc($mate2l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate2l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate2l3['mate']; ?></b><br />L3</td>

</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate2l3['def']==0){ echo "NC";} if(($row_mate2l3['def']>0) and ($row_mate2l3['def']<10)){ echo "0".$row_mate2l3['def'];} if(($row_mate2l3['def']>9) and ($row_mate2l3['def']<=20)){ echo $row_mate2l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate2l3 = mysql_fetch_assoc($mate2l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate2def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate2def['def']==0){ echo "NC";} if(($row_mate2def['def']>0) and ($row_mate2def['def']<10)){ echo "0".$row_mate2def['def'];} if(($row_mate2def['def']>9) and ($row_mate2def['def']<=20)){ echo $row_mate2def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate2def = mysql_fetch_assoc($mate2def)); ?>
</table>
</td>




<?php } ?>
<?php // MATERIA 3
if (($totalRows_mate3>0) and ($row_mate3['tipo_asignatura']=="")){
?> 

<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate3['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate3l1['def']==0){ echo "NC";} if(($row_mate3l1['def']>0) and ($row_mate3l1['def']<10)){ echo "0".$row_mate3l1['def'];} if(($row_mate3l1['def']>9) and ($row_mate3l1['def']<=20)){ echo $row_mate3l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate3l1 = mysql_fetch_assoc($mate3l1)); ?>
</table>
</td>

<?php if($totalRows_mate3l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate3['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate3l2['def']==0){ echo "NC";} if(($row_mate3l2['def']>0) and ($row_mate3l2['def']<10)){ echo "0".$row_mate3l2['def'];} if(($row_mate3l2['def']>9) and ($row_mate3l2['def']<=20)){ echo $row_mate3l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate3l2 = mysql_fetch_assoc($mate3l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate3l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate3['mate']; ?></b><br />L3</td>

</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate3l3['def']==0){ echo "NC";} if(($row_mate3l3['def']>0) and ($row_mate3l3['def']<10)){ echo "0".$row_mate3l3['def'];} if(($row_mate3l3['def']>9) and ($row_mate3l3['def']<=20)){ echo $row_mate3l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate3l3 = mysql_fetch_assoc($mate3l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate3def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate3def['def']==0){ echo "NC";} if(($row_mate3def['def']>0) and ($row_mate3def['def']<10)){ echo "0".$row_mate3def['def'];} if(($row_mate3def['def']>9) and ($row_mate3def['def']<=20)){ echo $row_mate3def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate3def = mysql_fetch_assoc($mate3def)); ?>
</table>
</td>



<?php } ?>
<?php // MATERIA 4
if (($totalRows_mate4>0) and ($row_mate4['tipo_asignatura']=="")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate4['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate4l1['def']==0){ echo "NC";} if(($row_mate4l1['def']>0) and ($row_mate4l1['def']<10)){ echo "0".$row_mate4l1['def'];} if(($row_mate4l1['def']>9) and ($row_mate4l1['def']<=20)){ echo $row_mate4l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate4l1 = mysql_fetch_assoc($mate4l1)); ?>
</table>
</td>

<?php if($totalRows_mate4l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate4['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate4l2['def']==0){ echo "NC";} if(($row_mate4l2['def']>0) and ($row_mate4l2['def']<10)){ echo "0".$row_mate4l2['def'];} if(($row_mate4l2['def']>9) and ($row_mate4l2['def']<=20)){ echo $row_mate4l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate4l2 = mysql_fetch_assoc($mate4l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate4l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate4['mate']; ?></b><br />L3</td>

</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate4l3['def']==0){ echo "NC";} if(($row_mate4l3['def']>0) and ($row_mate4l3['def']<10)){ echo "0".$row_mate4l3['def'];} if(($row_mate4l3['def']>9) and ($row_mate4l3['def']<=20)){ echo $row_mate4l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate4l3 = mysql_fetch_assoc($mate4l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate4def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate4def['def']==0){ echo "NC";} if(($row_mate4def['def']>0) and ($row_mate4def['def']<10)){ echo "0".$row_mate4def['def'];} if(($row_mate4def['def']>9) and ($row_mate4def['def']<=20)){ echo $row_mate4def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate4def = mysql_fetch_assoc($mate4def)); ?>
</table>
</td>


<?php }?>

<?php // MATERIA 5
if (($totalRows_mate5>0) and ($row_mate5['tipo_asignatura']=="")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate5['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate5l1['def']==0){ echo "NC";} if(($row_mate5l1['def']>0) and ($row_mate5l1['def']<10)){ echo "0".$row_mate5l1['def'];} if(($row_mate5l1['def']>9) and ($row_mate5l1['def']<=20)){ echo $row_mate5l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate5l1 = mysql_fetch_assoc($mate5l1)); ?>
</table>
</td>

<?php if($totalRows_mate5l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate5['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; ">
<?php if($row_mate5l2['def']==0){ echo "NC";} if(($row_mate5l2['def']>0) and ($row_mate5l2['def']<10)){ echo "0".$row_mate5l2['def'];} if(($row_mate5l2['def']>9) and ($row_mate5l2['def']<=20)){ echo $row_mate5l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate5l2 = mysql_fetch_assoc($mate5l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate5l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate5['mate']; ?></b><br />L3</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate5l3['def']==0){ echo "NC";} if(($row_mate5l3['def']>0) and ($row_mate5l3['def']<10)){ echo "0".$row_mate5l3['def'];} if(($row_mate5l3['def']>9) and ($row_mate5l3['def']<=20)){ echo $row_mate5l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate5l3 = mysql_fetch_assoc($mate5l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate5def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate5def['def']==0){ echo "NC";} if(($row_mate5def['def']>0) and ($row_mate5def['def']<10)){ echo "0".$row_mate5def['def'];} if(($row_mate5def['def']>9) and ($row_mate5def['def']<=20)){ echo $row_mate5def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate5def = mysql_fetch_assoc($mate5def)); ?>
</table>
</td>


<?php } ?>

<?php // MATERIA 6
if (($totalRows_mate6>0) and ($row_mate6['tipo_asignatura']=="")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate6['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate6l1['def']==0){ echo "NC";} if(($row_mate6l1['def']>0) and ($row_mate6l1['def']<10)){ echo "0".$row_mate6l1['def'];} if(($row_mate6l1['def']>9) and ($row_mate6l1['def']<=20)){ echo $row_mate6l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate6l1 = mysql_fetch_assoc($mate6l1)); ?>
</table>
</td>

<?php if($totalRows_mate6l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate6['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate6l2['def']==0){ echo "NC";} if(($row_mate6l2['def']>0) and ($row_mate6l2['def']<10)){ echo "0".$row_mate6l2['def'];} if(($row_mate6l2['def']>9) and ($row_mate6l2['def']<=20)){ echo $row_mate6l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate6l2 = mysql_fetch_assoc($mate6l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate6l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate6['mate']; ?></b><br />L3</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate6l3['def']==0){ echo "NC";} if(($row_mate6l3['def']>0) and ($row_mate6l3['def']<10)){ echo "0".$row_mate6l3['def'];} if(($row_mate6l3['def']>9) and ($row_mate6l3['def']<=20)){ echo $row_mate6l3['def'];} ?>
</td>


</tr>
<?php } while ($row_mate6l3 = mysql_fetch_assoc($mate6l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate6def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate6def['def']==0){ echo "NC";} if(($row_mate6def['def']>0) and ($row_mate6def['def']<10)){ echo "0".$row_mate6def['def'];} if(($row_mate6def['def']>9) and ($row_mate6def['def']<=20)){ echo $row_mate6def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate6def = mysql_fetch_assoc($mate6def)); ?>
</table>
</td>

<?php } ?>

<?php // MATERIA 7
if (($totalRows_mate7>0) and ($row_mate7['tipo_asignatura']=="")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate7['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate7l1['def']==0){ echo "NC";} if(($row_mate7l1['def']>0) and ($row_mate7l1['def']<10)){ echo "0".$row_mate7l1['def'];} if(($row_mate7l1['def']>9) and ($row_mate7l1['def']<=20)){ echo $row_mate7l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate7l1 = mysql_fetch_assoc($mate7l1)); ?>
</table>
</td>

<?php if($totalRows_mate7l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate7['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate7l2['def']==0){ echo "NC";} if(($row_mate7l2['def']>0) and ($row_mate7l2['def']<10)){ echo "0".$row_mate7l2['def'];} if(($row_mate7l2['def']>9) and ($row_mate7l2['def']<=20)){ echo $row_mate7l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate7l2 = mysql_fetch_assoc($mate7l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate7l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate7['mate']; ?></b><br />L3</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate7l3['def']==0){ echo "NC";} if(($row_mate7l3['def']>0) and ($row_mate7l3['def']<10)){ echo "0".$row_mate7l3['def'];} if(($row_mate7l3['def']>9) and ($row_mate7l3['def']<=20)){ echo $row_mate7l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate7l3 = mysql_fetch_assoc($mate7l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate7def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate7def['def']==0){ echo "NC";} if(($row_mate7def['def']>0) and ($row_mate7def['def']<10)){ echo "0".$row_mate7def['def'];} if(($row_mate7def['def']>9) and ($row_mate7def['def']<=20)){ echo $row_mate7def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate7def = mysql_fetch_assoc($mate7def)); ?>
</table>
</td>


<?php } ?>

<?php // MATERIA 8
if (($totalRows_mate8>0) and ($row_mate8['tipo_asignatura']=="")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate8['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate8l1['def']==0){ echo "NC";} if(($row_mate8l1['def']>0) and ($row_mate8l1['def']<10)){ echo "0".$row_mate8l1['def'];} if(($row_mate8l1['def']>9) and ($row_mate8l1['def']<=20)){ echo $row_mate8l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate8l1 = mysql_fetch_assoc($mate8l1)); ?>
</table>
</td>

<?php if($totalRows_mate8l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate8['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate8l2['def']==0){ echo "NC";} if(($row_mate8l2['def']>0) and ($row_mate8l2['def']<10)){ echo "0".$row_mate8l2['def'];} if(($row_mate8l2['def']>9) and ($row_mate8l2['def']<=20)){ echo $row_mate8l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate8l2 = mysql_fetch_assoc($mate8l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate8l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate8['mate']; ?></b><br />L3</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate8l3['def']==0){ echo "NC";} if(($row_mate8l3['def']>0) and ($row_mate8l3['def']<10)){ echo "0".$row_mate8l3['def'];} if(($row_mate8l3['def']>9) and ($row_mate8l3['def']<=20)){ echo $row_mate8l3['def'];} ?>
</td>


</tr>
<?php } while ($row_mate8l3 = mysql_fetch_assoc($mate8l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate8def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate8def['def']==0){ echo "NC";} if(($row_mate8def['def']>0) and ($row_mate8def['def']<10)){ echo "0".$row_mate8def['def'];} if(($row_mate8def['def']>9) and ($row_mate8def['def']<=20)){ echo $row_mate8def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate8def = mysql_fetch_assoc($mate8def)); ?>
</table>
</td>
<?php } ?>

<?php // MATERIA 9
if (($totalRows_mate9>0) and (($confi=="bol02") or ($confi=="nor01") or ($confi=="nor02") or ($row_mate11['tipo_asignatura']=="educacion_trabajo") or ($row_mate11['tipo_asignatura']=="premilitar"))){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate9l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate9l1['def']==0){ echo "NC";} if(($row_mate9l1['def']>0) and ($row_mate9l1['def']<10)){ echo "0".$row_mate9l1['def'];} if(($row_mate9l1['def']>9) and ($row_mate9l1['def']<=20)){ echo $row_mate9l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate9l1 = mysql_fetch_assoc($mate9l1)); ?>
</table>
</td>

<?php if($totalRows_mate9l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate9l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate9l2['def']==0){ echo "NC";} if(($row_mate9l2['def']>0) and ($row_mate9l2['def']<10)){ echo "0".$row_mate9l2['def'];} if(($row_mate9l2['def']>9) and ($row_mate9l2['def']<=20)){ echo $row_mate9l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate9l2 = mysql_fetch_assoc($mate9l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate9l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate9l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate9l3['def']==0){ echo "NC";} if(($row_mate9l3['def']>0) and ($row_mate9l3['def']<10)){ echo "0".$row_mate9l3['def'];} if(($row_mate9l3['def']>9) and ($row_mate9l3['def']<=20)){ echo $row_mate9l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate9l3 = mysql_fetch_assoc($mate9l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate9def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate9def['def']==0){ echo "NC";} if(($row_mate9def['def']>0) and ($row_mate9def['def']<10)){ echo "0".$row_mate9def['def'];} if(($row_mate9def['def']>9) and ($row_mate9def['def']<=20)){ echo $row_mate9def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate9def = mysql_fetch_assoc($mate9def)); ?>
</table>
</td>

<?php } ?>

<!--
<?php
if (($totalRows_mate9>0) and ($row_mate9['tipo_asignatura']=="")){
?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate9l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate9l1['def']==0){ echo "NC";} if(($row_mate9l1['def']>0) and ($row_mate9l1['def']<10)){ echo "0".$row_mate9l1['def'];} if(($row_mate9l1['def']>9) and ($row_mate9l1['def']<=20)){ echo $row_mate9l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate9l1 = mysql_fetch_assoc($mate9l1)); ?>
</table>
</td>

<?php if($totalRows_mate9l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate9l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate9l2['def']==0){ echo "NC";} if(($row_mate9l2['def']>0) and ($row_mate9l2['def']<10)){ echo "0".$row_mate9l2['def'];} if(($row_mate9l2['def']>9) and ($row_mate9l2['def']<=20)){ echo $row_mate9l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate9l2 = mysql_fetch_assoc($mate9l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate9l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate9l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate9l3['def']==0){ echo "NC";} if(($row_mate9l3['def']>0) and ($row_mate9l3['def']<10)){ echo "0".$row_mate9l3['def'];} if(($row_mate9l3['def']>9) and ($row_mate9l3['def']<=20)){ echo $row_mate9l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate9l3 = mysql_fetch_assoc($mate9l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate9def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate9def['def']==0){ echo "NC";} if(($row_mate9def['def']>0) and ($row_mate9def['def']<10)){ echo "0".$row_mate9def['def'];} if(($row_mate9def['def']>9) and ($row_mate9def['def']<=20)){ echo $row_mate9def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate9def = mysql_fetch_assoc($mate9def)); ?>
</table>
</td>

<?php } ?>

-->

<?php // MATERIA 10
if (($totalRows_mate10>0) and (($confi=="bol02") or ($confi=="nor02") or ($row_mate11['tipo_asignatura']=="educacion_trabajo") or ($row_mate11['tipo_asignatura']=="premilitar"))){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate10l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate10l1['def']==0){ echo "NC";} if(($row_mate10l1['def']>0) and ($row_mate10l1['def']<10)){ echo "0".$row_mate10l1['def'];} if(($row_mate10l1['def']>9) and ($row_mate10l1['def']<=20)){ echo $row_mate10l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate10l1 = mysql_fetch_assoc($mate10l1)); ?>
</table>
</td>

<?php if($totalRows_mate10l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate10l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate10l2['def']==0){ echo "NC";} if(($row_mate10l2['def']>0) and ($row_mate10l2['def']<10)){ echo "0".$row_mate10l2['def'];} if(($row_mate10l2['def']>9) and ($row_mate10l2['def']<=20)){ echo $row_mate10l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate10l2 = mysql_fetch_assoc($mate10l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate10l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate10l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate10l3['def']==0){ echo "NC";} if(($row_mate10l3['def']>0) and ($row_mate10l3['def']<10)){ echo "0".$row_mate10l3['def'];} if(($row_mate10l3['def']>9) and ($row_mate10l3['def']<=20)){ echo $row_mate10l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate10l3 = mysql_fetch_assoc($mate10l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate10def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate10def['def']==0){ echo "NC";} if(($row_mate10def['def']>0) and ($row_mate10def['def']<10)){ echo "0".$row_mate10def['def'];} if(($row_mate10def['def']>9) and ($row_mate10def['def']<=20)){ echo $row_mate10def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate10def = mysql_fetch_assoc($mate10def)); ?>
</table>
</td>

<?php }?>

<?php
if (($totalRows_mate10>0) and ($row_mate10['tipo_asignatura']=="")){
?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate10l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate10l1['def']==0){ echo "NC";} if(($row_mate10l1['def']>0) and ($row_mate10l1['def']<10)){ echo "0".$row_mate10l1['def'];} if(($row_mate10l1['def']>9) and ($row_mate10l1['def']<=20)){ echo $row_mate10l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate10l1 = mysql_fetch_assoc($mate10l1)); ?>
</table>
</td>

<?php if($totalRows_mate10l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate10l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate10l2['def']==0){ echo "NC";} if(($row_mate10l2['def']>0) and ($row_mate10l2['def']<10)){ echo "0".$row_mate10l2['def'];} if(($row_mate10l2['def']>9) and ($row_mate10l2['def']<=20)){ echo $row_mate10l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate10l2 = mysql_fetch_assoc($mate10l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate10l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate10l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate10l3['def']==0){ echo "NC";} if(($row_mate10l3['def']>0) and ($row_mate10l3['def']<10)){ echo "0".$row_mate10l3['def'];} if(($row_mate10l3['def']>9) and ($row_mate10l3['def']<=20)){ echo $row_mate10l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate10l3 = mysql_fetch_assoc($mate10l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate10def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate10def['def']==0){ echo "NC";} if(($row_mate10def['def']>0) and ($row_mate10def['def']<10)){ echo "0".$row_mate10def['def'];} if(($row_mate10def['def']>9) and ($row_mate10def['def']<=20)){ echo $row_mate10def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate10def = mysql_fetch_assoc($mate10def)); ?>
</table>
</td>

<?php }?>


<?php // MATERIA 11
if (($totalRows_mate11>0) and (($confi=="bol02") or ($confi=="nor02") or ($row_mate11['tipo_asignatura']=="educacion_trabajo") or ($row_mate11['tipo_asignatura']=="premilitar"))){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate11l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate11l1['def']==0){ echo "NC";} if(($row_mate11l1['def']>0) and ($row_mate11l1['def']<10)){ echo "0".$row_mate11l1['def'];} if(($row_mate11l1['def']>9) and ($row_mate11l1['def']<=20)){ echo $row_mate11l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate11l1 = mysql_fetch_assoc($mate11l1)); ?>
</table>
</td>

<?php if($totalRows_mate11l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate11l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate11l2['def']==0){ echo "NC";} if(($row_mate11l2['def']>0) and ($row_mate11l2['def']<10)){ echo "0".$row_mate11l2['def'];} if(($row_mate11l2['def']>9) and ($row_mate11l2['def']<=20)){ echo $row_mate11l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate11l2 = mysql_fetch_assoc($mate11l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate11l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate11l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate11l3['def']==0){ echo "NC";} if(($row_mate11l3['def']>0) and ($row_mate11l3['def']<10)){ echo "0".$row_mate11l3['def'];} if(($row_mate11l3['def']>9) and ($row_mate11l3['def']<=20)){ echo $row_mate11l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate11l3 = mysql_fetch_assoc($mate11l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate11def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate11def['def']==0){ echo "NC";} if(($row_mate11def['def']>0) and ($row_mate11def['def']<10)){ echo "0".$row_mate11def['def'];} if(($row_mate11def['def']>9) and ($row_mate11def['def']<=20)){ echo $row_mate11def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate11def = mysql_fetch_assoc($mate11def)); ?>
</table>
</td>

<?php } ?>

<?php
if (($totalRows_mate11>0) and ($row_mate11['tipo_asignatura']=="")){
?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate11l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate11l1['def']==0){ echo "NC";} if(($row_mate11l1['def']>0) and ($row_mate11l1['def']<10)){ echo "0".$row_mate11l1['def'];} if(($row_mate11l1['def']>9) and ($row_mate11l1['def']<=20)){ echo $row_mate11l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate11l1 = mysql_fetch_assoc($mate11l1)); ?>
</table>
</td>

<?php if($totalRows_mate11l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate11l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate11l2['def']==0){ echo "NC";} if(($row_mate11l2['def']>0) and ($row_mate11l2['def']<10)){ echo "0".$row_mate11l2['def'];} if(($row_mate11l2['def']>9) and ($row_mate11l2['def']<=20)){ echo $row_mate11l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate11l2 = mysql_fetch_assoc($mate11l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate11l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate11l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate11l3['def']==0){ echo "NC";} if(($row_mate11l3['def']>0) and ($row_mate11l3['def']<10)){ echo "0".$row_mate11l3['def'];} if(($row_mate11l3['def']>9) and ($row_mate11l3['def']<=20)){ echo $row_mate11l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate11l3 = mysql_fetch_assoc($mate11l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate11def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate11def['def']==0){ echo "NC";} if(($row_mate11def['def']>0) and ($row_mate11def['def']<10)){ echo "0".$row_mate11def['def'];} if(($row_mate11def['def']>9) and ($row_mate11def['def']<=20)){ echo $row_mate11def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate11def = mysql_fetch_assoc($mate11def)); ?>
</table>
</td>

<?php } ?>

<?php // MATERIA 12
if (($totalRows_mate12>0) and (($confi=="bol02") or ($confi=="nor02") or ($row_mate11['tipo_asignatura']=="educacion_trabajo") or ($row_mate11['tipo_asignatura']=="premilitar"))){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate12l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate12l1['def']==0){ echo "NC";} if(($row_mate12l1['def']>0) and ($row_mate12l1['def']<10)){ echo "0".$row_mate12l1['def'];} if(($row_mate12l1['def']>9) and ($row_mate12l1['def']<=20)){ echo $row_mate12l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate12l1 = mysql_fetch_assoc($mate12l1)); ?>
</table>
</td>

<?php if($totalRows_mate12l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate12l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate12l2['def']==0){ echo "NC";} if(($row_mate12l2['def']>0) and ($row_mate12l2['def']<10)){ echo "0".$row_mate12l2['def'];} if(($row_mate12l2['def']>9) and ($row_mate12l2['def']<=20)){ echo $row_mate12l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate12l2 = mysql_fetch_assoc($mate12l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate12l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate12l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate12l3['def']==0){ echo "NC";} if(($row_mate12l3['def']>0) and ($row_mate12l3['def']<10)){ echo "0".$row_mate12l3['def'];} if(($row_mate12l3['def']>9) and ($row_mate12l3['def']<=20)){ echo $row_mate12l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate12l3 = mysql_fetch_assoc($mate12l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate12def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate12def['def']==0){ echo "NC";} if(($row_mate12def['def']>0) and ($row_mate12def['def']<10)){ echo "0".$row_mate12def['def'];} if(($row_mate12def['def']>9) and ($row_mate12def['def']<=20)){ echo $row_mate12def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate12def = mysql_fetch_assoc($mate12def)); ?>
</table>
</td>

<?php } ?>

<?php
if (($totalRows_mate12>0) and ($row_mate12['tipo_asignatura']=="")){
?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate12l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate12l1['def']==0){ echo "NC";} if(($row_mate12l1['def']>0) and ($row_mate12l1['def']<10)){ echo "0".$row_mate12l1['def'];} if(($row_mate12l1['def']>9) and ($row_mate12l1['def']<=20)){ echo $row_mate12l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate12l1 = mysql_fetch_assoc($mate12l1)); ?>
</table>
</td>

<?php if($totalRows_mate12l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate12l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate12l2['def']==0){ echo "NC";} if(($row_mate12l2['def']>0) and ($row_mate12l2['def']<10)){ echo "0".$row_mate12l2['def'];} if(($row_mate12l2['def']>9) and ($row_mate12l2['def']<=20)){ echo $row_mate12l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate12l2 = mysql_fetch_assoc($mate12l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate12l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate12l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate12l3['def']==0){ echo "NC";} if(($row_mate12l3['def']>0) and ($row_mate12l3['def']<10)){ echo "0".$row_mate12l3['def'];} if(($row_mate12l3['def']>9) and ($row_mate12l3['def']<=20)){ echo $row_mate12l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate12l3 = mysql_fetch_assoc($mate12l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate12def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate12def['def']==0){ echo "NC";} if(($row_mate12def['def']>0) and ($row_mate12def['def']<10)){ echo "0".$row_mate12def['def'];} if(($row_mate12def['def']>9) and ($row_mate12def['def']<=20)){ echo $row_mate12def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate12def = mysql_fetch_assoc($mate12def)); ?>
</table>
</td>

<?php } ?>

<?php // MATERIA 13
if (($totalRows_mate13>0) and ($confi=="bol02") and ($row_mate13['tipo_asignatura']=="educacion_trabajo")){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate13l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate13l1['def']==0){ echo "NC";} if(($row_mate13l1['def']>0) and ($row_mate13l1['def']<10)){ echo "0".$row_mate13l1['def'];} if(($row_mate13l1['def']>9) and ($row_mate13l1['def']<=20)){ echo $row_mate13l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate13l1 = mysql_fetch_assoc($mate13l1)); ?>
</table>
</td>

<?php if($totalRows_mate13l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate13l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate13l2['def']==0){ echo "NC";} if(($row_mate13l2['def']>0) and ($row_mate13l2['def']<10)){ echo "0".$row_mate13l2['def'];} if(($row_mate13l2['def']>9) and ($row_mate13l2['def']<=20)){ echo $row_mate13l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate13l2 = mysql_fetch_assoc($mate13l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate13l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate13l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate13l3['def']==0){ echo "NC";} if(($row_mate13l3['def']>0) and ($row_mate13l3['def']<10)){ echo "0".$row_mate13l3['def'];} if(($row_mate13l3['def']>9) and ($row_mate13l3['def']<=20)){ echo $row_mate13l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate13l3 = mysql_fetch_assoc($mate13l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate13def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate13def['def']==0){ echo "NC";} if(($row_mate13def['def']>0) and ($row_mate13def['def']<10)){ echo "0".$row_mate13def['def'];} if(($row_mate13def['def']>9) and ($row_mate13def['def']<=20)){ echo $row_mate13def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate13def = mysql_fetch_assoc($mate13def)); ?>
</table>
</td>

<?php } ?>

<?php
if (($totalRows_mate13>0) and ($row_mate13['tipo_asignatura']=="")){
?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate13l1['mate']; ?></b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate13l1['def']==0){ echo "NC";} if(($row_mate13l1['def']>0) and ($row_mate13l1['def']<10)){ echo "0".$row_mate13l1['def'];} if(($row_mate13l1['def']>9) and ($row_mate13l1['def']<=20)){ echo $row_mate13l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate13l1 = mysql_fetch_assoc($mate13l1)); ?>
</table>
</td>

<?php if($totalRows_mate13l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate13l2['mate']; ?></b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate13l2['def']==0){ echo "NC";} if(($row_mate13l2['def']>0) and ($row_mate13l2['def']<10)){ echo "0".$row_mate13l2['def'];} if(($row_mate13l2['def']>9) and ($row_mate13l2['def']<=20)){ echo $row_mate13l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate13l2 = mysql_fetch_assoc($mate13l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<?php if($totalRows_mate13l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b><?php echo $row_mate13l3['mate']; ?></b><br />L3</td>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate13l3['def']==0){ echo "NC";} if(($row_mate13l3['def']>0) and ($row_mate13l3['def']<10)){ echo "0".$row_mate13l3['def'];} if(($row_mate13l3['def']>9) and ($row_mate13l3['def']<=20)){ echo $row_mate13l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate13l3 = mysql_fetch_assoc($mate13l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>

<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b><?php echo $row_mate13def['mate']; ?></b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate13def['def']==0){ echo "NC";} if(($row_mate13def['def']>0) and ($row_mate13def['def']<10)){ echo "0".$row_mate13def['def'];} if(($row_mate13def['def']>9) and ($row_mate13def['def']<=20)){ echo $row_mate13def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate13def = mysql_fetch_assoc($mate13def)); ?>
</table>
</td>

<?php } ?>


<?php // MATERIA EDUCACION PARA EL TRABAJO
if ($row_mate14l1['tipo_asignatura']=="educacion_trabajo"){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>EPT</b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate14l1['def']==0){ echo "NC";} if(($row_mate14l1['def']>0) and ($row_mate14l1['def']<10)){ echo "0".$row_mate14l1['def'];} if(($row_mate14l1['def']>9) and ($row_mate14l1['def']<=20)){ echo $row_mate14l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate14l1 = mysql_fetch_assoc($mate14l1)); ?>
</table>
</td>

<?php if($totalRows_mate14l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>EPT</b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate14l2['def']==0){ echo "NC";} if(($row_mate14l2['def']>0) and ($row_mate14l2['def']<10)){ echo "0".$row_mate14l2['def'];} if(($row_mate14l2['def']>9) and ($row_mate14l2['def']<=20)){ echo $row_mate14l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate14l2 = mysql_fetch_assoc($mate14l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate14l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>EPT</b><br />L3</td>


</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate14l3['def']==0){ echo "NC";} if(($row_mate14l3['def']>0) and ($row_mate14l3['def']<10)){ echo "0".$row_mate14l3['def'];} if(($row_mate14l3['def']>9) and ($row_mate14l3['def']<=20)){ echo $row_mate14l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate14l3 = mysql_fetch_assoc($mate14l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b>EPT</b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate14def['def']==0){ echo "NC";} if(($row_mate14def['def']>0) and ($row_mate14def['def']<10)){ echo "0".$row_mate14def['def'];} if(($row_mate14def['def']>9) and ($row_mate14def['def']<=20)){ echo $row_mate14def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate14def = mysql_fetch_assoc($mate14def)); ?>
</table>
</td>
<?php } ?>


<?php // MATERIA PREMILITAR
if ($row_mate17l1['tipo_asignatura']=="premilitar"){
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-left:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>IP</b><br />L1</td>
</tr>

<?php do { ?>
<tr >
<td  align="center" class="ancho_td_nota"  style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; font-size:11px;" align="left" >
<?php if($row_mate17l1['def']==0){ echo "NC";} if(($row_mate17l1['def']>0) and ($row_mate17l1['def']<10)){ echo "0".$row_mate17l1['def'];} if(($row_mate17l1['def']>9) and ($row_mate17l1['def']<=20)){ echo $row_mate17l1['def'];} ?>
</td>
</tr>
<?php } while ($row_mate17l1 = mysql_fetch_assoc($mate17l1)); ?>
</table>
</td>

<?php if($totalRows_mate17l2>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2"  style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>IP</b><br />L2</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate17l2['def']==0){ echo "NC";} if(($row_mate17l2['def']>0) and ($row_mate17l2['def']<10)){ echo "0".$row_mate17l2['def'];} if(($row_mate17l2['def']>9) and ($row_mate17l2['def']<=20)){ echo $row_mate17l2['def'];} ?>
</td>
</tr>
<?php } while ($row_mate17l2 = mysql_fetch_assoc($mate17l2)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<?php if($totalRows_mate17l3>0){?>
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>IP</b><br />L3</td>


</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<?php if($row_mate17l3['def']==0){ echo "NC";} if(($row_mate17l3['def']>0) and ($row_mate17l3['def']<10)){ echo "0".$row_mate17l3['def'];} if(($row_mate17l3['def']>9) and ($row_mate17l3['def']<=20)){ echo $row_mate17l3['def'];} ?>
</td>

</tr>
<?php } while ($row_mate17l3 = mysql_fetch_assoc($mate17l3)); ?>
</table>
</td>
<?} else {?>
&nbsp;
<?php }?>


<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px; background-color:#fffccc;" align="center"><b>IP</b><br />DEF</td>
</tr>
<?php do { ?>
<tr>

<td align="center" class="ancho_td_nota" style="border-bottom:1px solid; border-right:1px solid; font-size:11px; background-color:#fffccc;">
<b>
<?php if($row_mate17def['def']==0){ echo "NC";} if(($row_mate17def['def']>0) and ($row_mate17def['def']<10)){ echo "0".$row_mate17def['def'];} if(($row_mate17def['def']>9) and ($row_mate17def['def']<=20)){ echo $row_mate17def['def'];} ?>
</b>
</td>

</tr>
<?php } while ($row_mate17def = mysql_fetch_assoc($mate17def)); ?>
</table>
</td>
<?php } ?>
<?php // PROMEDIO DE LAPSO
/*
?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>PL</b>
</td>
</tr>
<?php  do { ?>
<tr>
<td class="ancho_td_nota" align="center" width="25" height="25" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<b><?php if($row_mate16['def']==NULL){ echo "NC";} if($row_mate16['def']==0){ echo "NC";} if(($row_mate16['def']>0) and ($row_mate16['def']<=20)){ echo $row_mate16['def'];} ?></b>
</td>
</tr>
<?php } while ($row_mate16 = mysql_fetch_assoc($mate16)); ?>
</table>
</td>
 */?>
<?php // PROMEDIO DE ANO

?> 
<td>
<table>
<tr>
<td class="ancho_td_nota2" style="border-right:1px solid; border-bottom:1px solid; font-size:11px;" align="center"><b>PRO</b>
</td>
</tr>
<?php  do { ?>
<tr>
<td class="ancho_td_nota" align="center" width="25" height="25" style="border-bottom:1px solid; border-right:1px solid; font-size:11px;">
<b><?php if($row_mate15['def']==0){ echo "NC";} if(($row_mate15['def']>0) and ($row_mate15['def']<=20)){ echo $row_mate15['def'];} ?></b>
</td>
</tr>
<?php } while ($row_mate15 = mysql_fetch_assoc($mate15)); ?>
</table>
</td>

<?php // fin consulta
?>
 </tr></table>
<span class="texto_pequeno_gris">Sistema Intersoft para: <b><?php echo $row_colegio['webcol'];?></b></span>





</body>
</html>
