<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
if (!isset($_SESSION)){
  session_start();
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


//FIN CONSULTA
mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);

//ASIGNATURAS PROFESORES
$colname_profe_mate = "-1";
if (isset($_POST['curso_id'])) {
  $colname_profe_mate = $_POST['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_profe_mate = sprintf("SELECT * FROM jos_asignatura a, jos_asignatura_nombre b, jos_docente c WHERE a.asignatura_nombre_id=b.id AND a.docente_id=c.id AND a.tipo_asignatura='' AND a.curso_id=%s ORDER BY a.orden_asignatura ASC", GetSQLValueString($colname_profe_mate, "int"));
$profe_mate = mysql_query($query_profe_mate, $sistemacol) or die(mysql_error());
$row_profe_mate = mysql_fetch_assoc($profe_mate);
$totalRows_profe_mate = mysql_num_rows($profe_mate);

// consultas de ept
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept1 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept1 = mysql_query($query_mate_ept1, $sistemacol) or die(mysql_error());
$row_mate_ept1 = mysql_fetch_assoc($mate_ept1);
$totalRows_mate_ept1 = mysql_num_rows($mate_ept1);

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept2 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept2 = mysql_query($query_mate_ept2, $sistemacol) or die(mysql_error());
$row_mate_ept2 = mysql_fetch_assoc($mate_ept2);
$totalRows_mate_ept2 = mysql_num_rows($mate_ept2);

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept3 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept3 = mysql_query($query_mate_ept3, $sistemacol) or die(mysql_error());
$row_mate_ept3 = mysql_fetch_assoc($mate_ept3);
$totalRows_mate_ept3 = mysql_num_rows($mate_ept3);

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept4 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept4 = mysql_query($query_mate_ept4, $sistemacol) or die(mysql_error());
$row_mate_ept4 = mysql_fetch_assoc($mate_ept4);
$totalRows_mate_ept4 = mysql_num_rows($mate_ept4);




$colname_asignatura = "-1";
if (isset($_POST['curso_id'])) {
  $colname_asignatura = $_POST['curso_id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id AND a.id = %s ", GetSQLValueString($colname_asignatura, "text"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

$tipo_cedula=$_POST['tipoc'];
//MATERIA 1
//nombres
$colname_mate1 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1 = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id  AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
} 


//LAPSO 1
$colname_mate1l1 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1l1 = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}

// DEF MATERIA 1
$colname_mate1def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id     AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}


// DEF MATERIA 2
$colname_mate2def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate2def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}


// DEF MATERIA 3
$colname_mate3def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate3def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}

// DEF MATERIA 4
$colname_mate4def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate4def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}

// DEF MATERIA 5
$colname_mate5def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate5def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}


// DEF MATERIA 6
$colname_mate6def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate6def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}


// DEF MATERIA 7
$colname_mate7def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate7def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}


// DEF MATERIA 8
$colname_mate8def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate8def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);

}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}


// DEF MATERIA 9
$colname_mate9def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate9def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id    AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}


// DEF MATERIA 10
$colname_mate10def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate10def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}


// DEF MATERIA 11
$colname_mate11def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate11def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}


// DEF MATERIA 12
$colname_mate12def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate12def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}


// DEF MATERIA 13
$colname_mate13def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate13def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}


// AGRUPANDO EDUCACION PARA EL TRABAJO


// DEF MATERIA 14
$colname_mate14def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate14def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id   AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}


// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate15 = $_POST['curso_id'];
}

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id  AND b.curso_id = %s  GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id  AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id  AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id  AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
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
<script>
function todos_ept1(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept1"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept2(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept2"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept3(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept3"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept4(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept4"){
elemento.checked = chkbox.checked
}
}
}
}
</script>

</head>
<body>
<center>
<?php if($totalRows_mate1>0){?>
<table width="740"><tr><td>
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>

            	<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="left">
                 	<tr>
                    		<td align="left" valign="bottom" style="font-size:20px"><?php echo $row_colegio['nomcol']; ?></td>
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
			
		</td>
</td></tr></table>



<h3>Definitivas de A&ntilde;o Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?></h3>
<table width="740"><tr>


<?php // MATERIA 1
?> 

<form action="<?php echo $editFormAction; ?>" method="POST" name="form">

<td>

<table><tr><td>
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
NO.
</td>
<td  class="ancho_td_cedula" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
CEDULA
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
APELLIDOS Y NOMBRES
</td>
</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;">
&nbsp;&nbsp;<span class="texto_pequeno_gris"><?php echo $row_mate1['apellido'].", ".$row_mate1['nombre']; ?></span>
</td>

</tr>
<?php $i++; $lista ++; } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</table>
</td>

<?php if($totalRows_mate1def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate1def['mate']; ?>
</td>
</tr>
<?php $i=1; do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm1'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate1def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate1def['def']==0){echo "<b>N</b>"; } if(($row_mate1def['def']>0) and ($row_mate1def['def']<10)){ echo "0".$row_mate1def['def']; } if($row_mate1def['def']>9){echo $row_mate1def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate1def = mysql_fetch_assoc($mate1def)); ?>
</table>
</td>
<?php } ?>

<?php if($totalRows_mate2def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate2def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm2'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate2def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate2def['def']==0){echo "<b>N</b>"; } if(($row_mate2def['def']>0) and ($row_mate2def['def']<10)){ echo "0".$row_mate2def['def']; } if($row_mate2def['def']>9){echo $row_mate2def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate2def = mysql_fetch_assoc($mate2def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate3def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate3def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm3'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate3def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate3def['def']==0){echo "<b>N</b>"; } if(($row_mate3def['def']>0) and ($row_mate3def['def']<10)){ echo "0".$row_mate3def['def']; } if($row_mate3def['def']>9){echo $row_mate3def['def']; }?></span>
</td>

</tr>
<?php  $i++; } while ($row_mate3def = mysql_fetch_assoc($mate3def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate4def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate4def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm4'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate4def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate4def['def']==0){echo "<b>N</b>"; } if(($row_mate4def['def']>0) and ($row_mate4def['def']<10)){ echo "0".$row_mate4def['def']; } if($row_mate4def['def']>9){echo $row_mate4def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate4def = mysql_fetch_assoc($mate4def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate5def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate5def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm5'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate5def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate5def['def']==0){echo "<b>N</b>"; } if(($row_mate5def['def']>0) and ($row_mate5def['def']<10)){ echo "0".$row_mate5def['def']; } if($row_mate5def['def']>9){echo $row_mate5def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate5def = mysql_fetch_assoc($mate5def)); ?>
</table>
</td>
<?php  } ?>


<?php if($totalRows_mate6def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
<?php echo $row_mate6def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm6'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate6def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate6def['def']==0){echo "<b>N</b>"; } if(($row_mate6def['def']>0) and ($row_mate6def['def']<10)){ echo "0".$row_mate6def['def']; } if($row_mate6def['def']>9){echo $row_mate6def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate6def = mysql_fetch_assoc($mate6def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate7def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate7def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm7'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate7def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate7def['def']==0){echo "<b>N</b>"; } if(($row_mate7def['def']>0) and ($row_mate7def['def']<10)){ echo "0".$row_mate7def['def']; } if($row_mate7def['def']>9){echo $row_mate7def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate7def = mysql_fetch_assoc($mate7def)); ?>
</table>
</td>
<?php }?>


<?php if($totalRows_mate8def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate8def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm8'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate8def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate8def['def']==0){echo "<b>N</b>"; } if(($row_mate8def['def']>0) and ($row_mate8def['def']<10)){ echo "0".$row_mate8def['def']; } if($row_mate8def['def']>9){echo $row_mate8def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate8def = mysql_fetch_assoc($mate8def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate9def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate9def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<input type="hidden"  name="<?php echo 'm9'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate9def['def']; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate9def['def']==0){echo "<b>N</b>"; } if(($row_mate9def['def']>0) and ($row_mate9def['def']<10)){ echo "0".$row_mate9def['def']; } if($row_mate9def['def']>9){echo $row_mate9def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate9def = mysql_fetch_assoc($mate9def)); ?>
</table>
</td>
<?php  } ?>


<?php if($totalRows_mate10def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate10def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm10'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate10def['def']; ?>"/>
<input type="hidden"  name="<?php echo 't10'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate10def; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate10def['def']==0){echo "<b>N</b>"; } if(($row_mate10def['def']>0) and ($row_mate10def['def']<10)){ echo "0".$row_mate10def['def']; } if($row_mate10def['def']>9){echo $row_mate10def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate10def = mysql_fetch_assoc($mate10def)); ?>
</table>
</td>
<?php  } ?>


<?php if($totalRows_mate11def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate11def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm11'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate11def['def']; ?>"/>
<input type="hidden"  name="<?php echo 't11'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate11def; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate11def['def']==0){echo "<b>N</b>"; } if(($row_mate11def['def']>0) and ($row_mate11def['def']<10)){ echo "0".$row_mate11def['def']; } if($row_mate11def['def']>9){echo $row_mate11def['def']; }?></span>
</td>

</tr>
<?php  $i++; } while ($row_mate11def = mysql_fetch_assoc($mate11def)); ?>
</table>
</td>
<?php }?>



<?php if($totalRows_mate12def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate12def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm12'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate12def['def']; ?>"/>
<input type="hidden"  name="<?php echo 't12'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate12def; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate12def['def']==0){echo "<b>N</b>"; } if(($row_mate12def['def']>0) and ($row_mate12def['def']<10)){ echo "0".$row_mate12def['def']; } if($row_mate12def['def']>9){echo $row_mate12def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate12def = mysql_fetch_assoc($mate12def)); ?>
</table>
</td>
<?php } ?>

<?php if($totalRows_mate13def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
<?php echo $row_mate13def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm13'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate13def['def']; ?>"/>
<input type="hidden"  name="<?php echo 't13'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate13def; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate13def['def']==0){echo "<b>N</b>"; } if(($row_mate13def['def']>0) and ($row_mate13def['def']<10)){ echo "0".$row_mate13def['def']; } if($row_mate13def['def']>9){echo $row_mate13def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate13def = mysql_fetch_assoc($mate13def)); ?>
</table>
</td>
<?php } ?>



<?php if($totalRows_mate14def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
ET
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="hidden"  name="<?php echo 'm14'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_mate14def['def']; ?>"/>
<input type="hidden"  name="<?php echo 't14'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate14def; ?>"/>
<span class="texto_mediano_gris"><?php if($row_mate14def['def']==0){echo "<b>N</b>"; } if(($row_mate14def['def']>0) and ($row_mate14def['def']<10)){ echo "0".$row_mate14def['def']; } if($row_mate14def['def']>9){echo $row_mate14def['def']; }?></span>
</td>

</tr>
<?php $i++; } while ($row_mate14def = mysql_fetch_assoc($mate14def)); ?>
</table>
</td>
<?php } ?>


<td>


</td>



<?php // fin consulta
?>


 </tr></table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>



<?php } else { ?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png" /><br /><br />
<span class="texto_grande_gris" > NO HAY ESTUDIANTES REGISTRADOS EN ESTA SECCION </span>
</center>

<?php } ?>
</center>
</body>
</html>
<?php
mysql_free_result($asignatura);
mysql_free_result($confip);
mysql_free_result($mate1);

mysql_free_result($mate15);

mysql_free_result($colegio);

?>
