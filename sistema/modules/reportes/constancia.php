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


$colname_reporte = "-1";
if (isset($_GET['cedula'])) {
  $colname_reporte = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.indicador_nacionalidad, c.nombre as anio, c.nombre_completo, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cursando=1 AND a.cedula= %s" , GetSQLValueString($colname_reporte, "bigint"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

$colname_reporte_pre = "-1";
if (isset($_GET['cedula'])) {
  $colname_reporte_pre = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte_pre = sprintf("SELECT nom_alumno, ape_alumno, ced_alumno, indicador_nacionalidad, grado_cursar FROM jos_alumno_preinscripcion WHERE ced_alumno= %s" , GetSQLValueString($colname_reporte_pre, "bigint"));
$reporte_pre = mysql_query($query_reporte_pre, $sistemacol) or die(mysql_error());
$row_reporte_pre = mysql_fetch_assoc($reporte_pre);
$totalRows_reporte_pre = mysql_num_rows($reporte_pre);


mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio2 = sprintf("SELECT * FROM jos_cdc_institucion ");
$colegio2 = mysql_query($query_colegio2, $sistemacol) or die(mysql_error());
$row_colegio2 = mysql_fetch_assoc($colegio2);
$totalRows_colegio2 = mysql_num_rows($colegio2);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);

//// INFORMACION DE LAS NOTAS


//CARGANDO DATOS DE ASIGNATURAS


$confi=$row_confip['codfor'];

if ($confi=="bol01"){
	
$colname_asignatura = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura = $_GET['cedula'];
}
$lapso_asignatura = "-1";
if (isset($_GET['lapso'])) {
  $lapso_asignatura = $_GET['lapso'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = %s ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura, "bigint"), GetSQLValueString($lapso_asignatura, "int"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

//PRIMER LAPSO
$colname_asignatura1 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura1 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura1 = sprintf("SELECT c.nombre, a.def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 1 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura1, "bigint"));
$asignatura1 = mysql_query($query_asignatura1, $sistemacol) or die(mysql_error());
$row_asignatura1 = mysql_fetch_assoc($asignatura1);
$totalRows_asignatura1 = mysql_num_rows($asignatura1);

//SEGUNDO LAPSO
$colname_asignatura2 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura2 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura2 = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 2 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura2, "bigint"));
$asignatura2 = mysql_query($query_asignatura2, $sistemacol) or die(mysql_error());
$row_asignatura2 = mysql_fetch_assoc($asignatura2);
$totalRows_asignatura2 = mysql_num_rows($asignatura2);

//TERCER LAPSO
$colname_asignatura3 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura3 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura3 = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 3 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura3, "bigint"));
$asignatura3 = mysql_query($query_asignatura3, $sistemacol) or die(mysql_error());
$row_asignatura3 = mysql_fetch_assoc($asignatura3);
$totalRows_asignatura3 = mysql_num_rows($asignatura3);

//EDUCACION PARA EL TRABAJO
//PRIMER LAPSO
$colname_mate141 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate141 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate141 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate141, "bigint"));
$mate141 = mysql_query($query_mate141, $sistemacol) or die(mysql_error());
$row_mate141 = mysql_fetch_assoc($mate141);
$totalRows_mate141 = mysql_num_rows($mate141);

//SEGUNDO LAPSO
$colname_mate142 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate142 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate142 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate142, "bigint"));
$mate142 = mysql_query($query_mate142, $sistemacol) or die(mysql_error());
$row_mate142 = mysql_fetch_assoc($mate142);
$totalRows_mate142 = mysql_num_rows($mate142);

//TERCER LAPSO
$colname_mate143 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate143 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate143 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate143, "bigint"));
$mate143 = mysql_query($query_mate143, $sistemacol) or die(mysql_error());
$row_mate143 = mysql_fetch_assoc($mate143);
$totalRows_mate143 = mysql_num_rows($mate143);

//INSTRUCCION PREMILITAR
//PRIMER LAPSO
$colname_mate151 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate151 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate151, "bigint"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);

//SEGUNDO LAPSO
$colname_mate152 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate152 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate152, "bigint"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);

//TERCER LAPSO
$colname_mate153 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate153 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate153, "bigint"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);

}

if ($confi=="bol02"){
	
$colname_asignatura = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura = $_GET['cedula'];
}
$lapso_asignatura = "-1";
if (isset($_GET['lapso'])) {
  $lapso_asignatura = $_GET['lapso'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = %s ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura, "bigint"), GetSQLValueString($lapso_asignatura, "int"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

//PRIMER LAPSO
$colname_asignatura1 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura1 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura1 = sprintf("SELECT c.nombre, a.def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 1 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura1, "bigint"));
$asignatura1 = mysql_query($query_asignatura1, $sistemacol) or die(mysql_error());
$row_asignatura1 = mysql_fetch_assoc($asignatura1);
$totalRows_asignatura1 = mysql_num_rows($asignatura1);

//SEGUNDO LAPSO
$colname_asignatura2 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura2 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura2 = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 2 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura2, "bigint"));
$asignatura2 = mysql_query($query_asignatura2, $sistemacol) or die(mysql_error());
$row_asignatura2 = mysql_fetch_assoc($asignatura2);
$totalRows_asignatura2 = mysql_num_rows($asignatura2);

//TERCER LAPSO
$colname_asignatura3 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura3 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura3 = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 3 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura3, "bigint"));
$asignatura3 = mysql_query($query_asignatura3, $sistemacol) or die(mysql_error());
$row_asignatura3 = mysql_fetch_assoc($asignatura3);
$totalRows_asignatura3 = mysql_num_rows($asignatura3);

//EDUCACION PARA EL TRABAJO
//PRIMER LAPSO
$colname_mate141 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate141 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate141 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate141, "bigint"));
$mate141 = mysql_query($query_mate141, $sistemacol) or die(mysql_error());
$row_mate141 = mysql_fetch_assoc($mate141);
$totalRows_mate141 = mysql_num_rows($mate141);

//SEGUNDO LAPSO
$colname_mate142 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate142 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate142 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate142, "bigint"));
$mate142 = mysql_query($query_mate142, $sistemacol) or die(mysql_error());
$row_mate142 = mysql_fetch_assoc($mate142);
$totalRows_mate142 = mysql_num_rows($mate142);

//TERCER LAPSO
$colname_mate143 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate143 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate143 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate143, "bigint"));
$mate143 = mysql_query($query_mate143, $sistemacol) or die(mysql_error());
$row_mate143 = mysql_fetch_assoc($mate143);
$totalRows_mate143 = mysql_num_rows($mate143);

//INSTRUCCION PREMILITAR
//PRIMER LAPSO
$colname_mate151 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate151 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate151, "bigint"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);

//SEGUNDO LAPSO
$colname_mate152 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate152 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate152, "bigint"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);

//TERCER LAPSO
$colname_mate153 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate153 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate153, "bigint"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);

}

if ($confi=="nor01"){  //FORMATO NOR01
	
$colname_asignatura = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura = $_GET['cedula'];
}
$lapso_asignatura = "-1";
if (isset($_GET['lapso'])) {
  $lapso_asignatura = $_GET['lapso'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = %s ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura, "bigint"), GetSQLValueString($lapso_asignatura, "int"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

//PRIMER LAPSO
$colname_asignatura1 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura1 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura1 = sprintf("SELECT c.nombre, a.def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 1 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura1, "bigint"));
$asignatura1 = mysql_query($query_asignatura1, $sistemacol) or die(mysql_error());
$row_asignatura1 = mysql_fetch_assoc($asignatura1);
$totalRows_asignatura1 = mysql_num_rows($asignatura1);

//SEGUNDO LAPSO
$colname_asignatura2 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura2 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura2 = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 2 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura2, "bigint"));
$asignatura2 = mysql_query($query_asignatura2, $sistemacol) or die(mysql_error());
$row_asignatura2 = mysql_fetch_assoc($asignatura2);
$totalRows_asignatura2 = mysql_num_rows($asignatura2);

//TERCER LAPSO
$colname_asignatura3 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura3 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura3 = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 3 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura3, "bigint"));
$asignatura3 = mysql_query($query_asignatura3, $sistemacol) or die(mysql_error());
$row_asignatura3 = mysql_fetch_assoc($asignatura3);
$totalRows_asignatura3 = mysql_num_rows($asignatura3);

//EDUCACION PARA EL TRABAJO
//PRIMER LAPSO
$colname_mate141 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate141 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate141 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate141, "bigint"));
$mate141 = mysql_query($query_mate141, $sistemacol) or die(mysql_error());
$row_mate141 = mysql_fetch_assoc($mate141);
$totalRows_mate141 = mysql_num_rows($mate141);

//SEGUNDO LAPSO
$colname_mate142 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate142 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate142 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate142, "bigint"));
$mate142 = mysql_query($query_mate142, $sistemacol) or die(mysql_error());
$row_mate142 = mysql_fetch_assoc($mate142);
$totalRows_mate142 = mysql_num_rows($mate142);

//TERCER LAPSO
$colname_mate143 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate143 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate143 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate143, "bigint"));
$mate143 = mysql_query($query_mate143, $sistemacol) or die(mysql_error());
$row_mate143 = mysql_fetch_assoc($mate143);
$totalRows_mate143 = mysql_num_rows($mate143);

//INSTRUCCION PREMILITAR
//PRIMER LAPSO
$colname_mate151 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate151 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate151, "bigint"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);

//SEGUNDO LAPSO
$colname_mate152 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate152 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate152, "bigint"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);

//TERCER LAPSO
$colname_mate153 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate153 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate153, "bigint"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);

}

if ($confi=="nor02"){ //FORMATO NOR02

	
$colname_asignatura = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura = $_GET['cedula'];
}
$lapso_asignatura = "-1";
if (isset($_GET['lapso'])) {
  $lapso_asignatura = $_GET['lapso'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = %s ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura, "bigint"), GetSQLValueString($lapso_asignatura, "int"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

//PRIMER LAPSO
$colname_asignatura1 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura1 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura1 = sprintf("SELECT c.nombre, a.def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 1 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura1, "bigint"));
$asignatura1 = mysql_query($query_asignatura1, $sistemacol) or die(mysql_error());
$row_asignatura1 = mysql_fetch_assoc($asignatura1);
$totalRows_asignatura1 = mysql_num_rows($asignatura1);

//SEGUNDO LAPSO
$colname_asignatura2 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura2 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura2 = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 2 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura2, "bigint"));
$asignatura2 = mysql_query($query_asignatura2, $sistemacol) or die(mysql_error());
$row_asignatura2 = mysql_fetch_assoc($asignatura2);
$totalRows_asignatura2 = mysql_num_rows($asignatura2);

//TERCER LAPSO
$colname_asignatura3 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura3 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura3 = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND d.cedula = %s AND a.lapso = 3 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura3, "bigint"));
$asignatura3 = mysql_query($query_asignatura3, $sistemacol) or die(mysql_error());
$row_asignatura3 = mysql_fetch_assoc($asignatura3);
$totalRows_asignatura3 = mysql_num_rows($asignatura3);

//EDUCACION PARA EL TRABAJO
//PRIMER LAPSO
$colname_mate141 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate141 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate141 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate141, "bigint"));
$mate141 = mysql_query($query_mate141, $sistemacol) or die(mysql_error());
$row_mate141 = mysql_fetch_assoc($mate141);
$totalRows_mate141 = mysql_num_rows($mate141);

//SEGUNDO LAPSO
$colname_mate142 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate142 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate142 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate142, "bigint"));
$mate142 = mysql_query($query_mate142, $sistemacol) or die(mysql_error());
$row_mate142 = mysql_fetch_assoc($mate142);
$totalRows_mate142 = mysql_num_rows($mate142);

//TERCER LAPSO
$colname_mate143 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate143 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate143 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate143, "bigint"));
$mate143 = mysql_query($query_mate143, $sistemacol) or die(mysql_error());
$row_mate143 = mysql_fetch_assoc($mate143);
$totalRows_mate143 = mysql_num_rows($mate143);

//INSTRUCCION PREMILITAR
//PRIMER LAPSO
$colname_mate151 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate151 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate151, "bigint"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);

//SEGUNDO LAPSO
$colname_mate152 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate152 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate152, "bigint"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);

//TERCER LAPSO
$colname_mate153 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate153 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate153, "bigint"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);

}
//////

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

<style type="text/css">

table.sample {
	border-width: 1px;
	border-spacing: 2px;
	border-style: solid;
	border-color: #000;
	border-collapse: collapse;
	background-color: white;
	font-family: arial;
	font-size: 10px;
}

table.sample2 {
	border-width: 1px;
	border-spacing: 2px;
	border-style: solid;
	border-color: #000;
	border-collapse: collapse;
	background-color: white;
	font-family: arial;
	font-size: 10px;
	
}

table.sample td {
	border-width: 0.5px;
	padding: 0px;
	border-style: solid;
	border-color: #000;
	background-color: white;
	border-collapse: collapse;
font-family: arial;
	
}


table.sample2 td {
	border-width: 1px;
	padding: 0px;
	border-style: solid;
	border-color: #000;
	background-color: white;
	border-collapse: collapse;
font-family:arial;
}
</style>


</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if (($totalRows_reporte > 0) or ($totalRows_reporte_pre > 0)) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr><td height="100" valign="top">

<!--INFORMACION DEL COLEGIO -->
		<table width="650"><tr><td>
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>
            	<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="left">
                 	<tr>
                    		<td align="left" valign="bottom" style="font-size:20px"><?php echo $row_colegio['nomcol']; ?></td>
                	</tr>
                	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris">INSC. EN EL M.P.P.E. <?php echo $row_colegio2['cod_plantel']; ?> <br /><?php echo $row_colegio['dircol']; ?><br />Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  	</tr>

                  </table>
              	</td>
</td></tr></table>

</td>              
     </tr>     




<!--INFORMACION DE LA CONSULTA -->





<?php if($_GET['constancia']=="") { ?>
<tr>
<td>
<br />
<br />

<center><h2>No Seleccionaste ninguna Constancia</h2></center>
</td>
</tr>
<?php } ?>


<!-- CONSTANCIA DE ESTUDIO -->
<?php if($_GET['constancia']==1) { ?>
<tr>
 <td valign="top" align="center" class="texto_mediano_gris" ><br /><br /><h1 style="text-decoration: underline;">CONSTANCIA DE ESTUDIO </h1><br /><br />
     
<table width="600" >
     <tr >
     <td class="textogrande_eloy" style="font-size:14px; line-height: 2em; text-indent: 5em; text-align:justify; text-transform: uppercase;">
    <p>Quien suscribe, <?php if($row_colegio2['cargo_director']=="Director") { echo "EL ".$row_colegio2['cargo_director'];} if($row_colegio2['cargo_director']=="Directora") { echo "LA ".$row_colegio2['cargo_director'];} ?> de la  <b><?php echo $row_colegio['nomcol']; ?></b>, C&oacute;digo Plantel <b><?php echo $row_colegio2['cod_plantel']; ?></b>, ubicado en la <span style="text-transform: uppercase;"><?php echo $row_colegio['dircol']; ?></span>, 
    certifica que: <b><?php echo $row_reporte['nomalum']." ".$row_reporte['apellido']; ?>,</b> <b><?php echo $row_reporte['indicador_nacionalidad']."-".$row_reporte['cedula'];?></b>, 	cursa en la Instituci&oacute;n el: <b ><?php echo $row_reporte['nombre_completo']; ?> </b>A&ntilde;o Escolar <?php echo $row_periodo['descripcion']; ?>.</p>
    <br />
    <p>Constancia que se expide a solicitud de parte interesada en la ciudad de  <?php echo $row_colegio['ciudad']; ?>, a los 
    <?php
 $fecha = date("d-m-Y"); // fecha actual
 $ano = date("Y"); // Año actual
 $mes_no = date("m"); // Mes actual
 $dia = date("d"); // Dia actual
	if($mes_no==1) { $mes="ENERO";}
	if($mes_no==2) { $mes="FEBRERO";}
	if($mes_no==3) { $mes="MARZO";}
	if($mes_no==4) { $mes="ABRIL";}
	if($mes_no==5) { $mes="MAYO";}
	if($mes_no==6) { $mes="JUNIO";}
	if($mes_no==7) { $mes="JULIO";}
	if($mes_no==8) { $mes="AGOSTO";}
	if($mes_no==9) { $mes="SEPTIEMBRE";}
	if($mes_no==10) { $mes="OCTUBRE";}
	if($mes_no==11) { $mes="NOVIEMBRE";}
	if($mes_no==12) { $mes="DICIEMBRE";}

 $time = time(); // Timestamp Actual

$hoy1=$ano.$mes.$dia; 

?>  <?php echo $dia;?> d&iacute;as de mes de <?php echo $mes;?> del a&ntilde;o <?php echo $ano;?>.</p>
<br />
<br />
<br />
     
     
     </td>
     </tr>
     <tr>
		<td>
<span style="font-size:14px; line-height: 1.2em;">
<center>
__________________________________________<br />
<?php echo $row_colegio2['titulo_director']; ?> <?php echo $row_colegio2['nombre_director']." ".$row_colegio2['apellido_director']; ?><br />
V-<?php echo $row_colegio2['cedula_director']; ?><br />
<?php echo $row_colegio2['cargo_director']; ?>
</center>
</span>

<br />
<br />
VA SIN ENMIENDA   <br />
<br />
<?php echo $row_colegio2['enmienda']; ?>	
		</td>     
     </tr>
    <?php  }?>
    
    
    
    
    
<!-- CONSTANCIA DE CONDUCTA -->    






<?php if($_GET['constancia']=="2") { ?>
<tr>
 <td valign="top" align="center" class="texto_mediano_gris" ><br /><br /><h1 style="text-decoration: underline;">CONSTANCIA DE CONDUCTA </h1><br /><br />
     
<table width="600" >
     <tr >
     <td class="textogrande_eloy" style="font-size:14px; line-height: 2em; text-indent: 5em; text-align:justify; text-transform: uppercase;">
    <p>Quien suscribe, <?php if($row_colegio2['cargo_director']=="Director") { echo "EL ".$row_colegio2['cargo_director'];} if($row_colegio2['cargo_director']=="Directora") { echo "LA ".$row_colegio2['cargo_director'];} ?> de la  <b><?php echo $row_colegio['nomcol']; ?></b>, C&oacute;digo Plantel <b><?php echo $row_colegio2['cod_plantel']; ?></b>, ubicado en la <span style="text-transform: uppercase;"><?php echo $row_colegio['dircol']; ?></span>, 
    hace constar por medio de la presente que: <b><?php echo $row_reporte['nomalum']." ".$row_reporte['apellido']; ?>,</b> <b><?php echo $row_reporte['indicador_nacionalidad']."-".$row_reporte['cedula'];?></b>, 	cursante del: <b ><?php echo $row_reporte['nombre_completo']; ?>,</b> Hasta la fecha de emisi&oacute;n presenta: <b><?php echo $_GET['c']; ?>.</b></p>
    <br />
    <p>Constancia que se expide a solicitud de parte interesada en la ciudad de  <?php echo $row_colegio['ciudad']; ?>, a los 
    <?php
 $fecha = date("d-m-Y"); // fecha actual
 $ano = date("Y"); // Año actual
 $mes_no = date("m"); // Mes actual
 $dia = date("d"); // Dia actual
	if($mes_no==1) { $mes="ENERO";}
	if($mes_no==2) { $mes="FEBRERO";}
	if($mes_no==3) { $mes="MARZO";}
	if($mes_no==4) { $mes="ABRIL";}
	if($mes_no==5) { $mes="MAYO";}
	if($mes_no==6) { $mes="JUNIO";}
	if($mes_no==7) { $mes="JULIO";}
	if($mes_no==8) { $mes="AGOSTO";}
	if($mes_no==9) { $mes="SEPTIEMBRE";}
	if($mes_no==10) { $mes="OCTUBRE";}
	if($mes_no==11) { $mes="NOVIEMBRE";}
	if($mes_no==12) { $mes="DICIEMBRE";}

 $time = time(); // Timestamp Actual

$hoy1=$ano.$mes.$dia; 

?>  <?php echo $dia;?> d&iacute;as de mes de <?php echo $mes;?> del a&ntilde;o <?php echo $ano;?>.</p>
<br />
<br />
<br />
     
     
     </td>
     </tr>
     <tr>
		<td>
<span style="font-size:14px; line-height: 1.2em;">
<center>
__________________________________________<br />
<?php echo $row_colegio2['titulo_director']; ?> <?php echo $row_colegio2['nombre_director']." ".$row_colegio2['apellido_director']; ?><br />
V-<?php echo $row_colegio2['cedula_director']; ?><br />
<?php echo $row_colegio2['cargo_director']; ?>
</center>
</span>

<br />
<br />
VA SIN ENMIENDA   <br />
<br />
<?php echo $row_colegio2['enmienda']; ?>	
		</td>     
     </tr>
<?php } ?>    

<!-- CONSTANCIA DE CONDUCTA RETIRO -->
 <?php if($_GET['constancia']=="3") { ?>
<tr>
<td>
<br />
<br />

<center><h2>No se ha creado a&uacute;n esta Constancia</h2></center>
</td>
</tr>
<?php } ?>    

<!-- CONSTANCIA DE PRE-INSCRIPCION -->

<?php if(($_GET['constancia']==4) and ($_GET['cins']==1)) { ?>
<tr>
 <td valign="top" align="center" class="texto_mediano_gris" ><br /><br /><h1 style="text-decoration: underline;">CONSTANCIA DE PRE-INSCRIPCI&Oacute;N </h1><br /><br />
     
<table width="600" >
     <tr >
     <td class="textogrande_eloy" style="font-size:14px; line-height: 2em; text-indent: 5em; text-align:justify; text-transform: uppercase;">
    <p>Quien suscribe, <?php if($row_colegio2['cargo_director']=="Director") { echo "EL ".$row_colegio2['cargo_director'];} if($row_colegio2['cargo_director']=="Directora") { echo "LA ".$row_colegio2['cargo_director'];} ?> de la  <b><?php echo $row_colegio['nomcol']; ?></b>, C&oacute;digo Plantel <b><?php echo $row_colegio2['cod_plantel']; ?></b>, ubicado en la <span style="text-transform: uppercase;"><?php echo $row_colegio['dircol']; ?></span>, 
    certifica que: <b><?php echo $row_reporte_pre['nom_alumno']." ".$row_reporte_pre['ape_alumno']; ?>,</b> <b><?php echo $row_reporte_pre['indicador_nacionalidad']."-".$row_reporte_pre['ced_alumno'];?></b>, 	est&aacute; pre-inscrito(a) en la instituci&oacute;n para cursar el <b ><?php echo $row_reporte_pre['grado_cursar']; ?> </b> durante el a&ntilde;o escolar <?php echo $row_periodo['descripcion']; ?>.</p>
    <br />
    <p>Constancia que se expide a solicitud de parte interesada en la ciudad de  <?php echo $row_colegio['ciudad']; ?>, a los 
    <?php
 $fecha = date("d-m-Y"); // fecha actual
 $ano = date("Y"); // Año actual
 $mes_no = date("m"); // Mes actual
 $dia = date("d"); // Dia actual
	if($mes_no==1) { $mes="ENERO";}
	if($mes_no==2) { $mes="FEBRERO";}
	if($mes_no==3) { $mes="MARZO";}
	if($mes_no==4) { $mes="ABRIL";}
	if($mes_no==5) { $mes="MAYO";}
	if($mes_no==6) { $mes="JUNIO";}
	if($mes_no==7) { $mes="JULIO";}
	if($mes_no==8) { $mes="AGOSTO";}
	if($mes_no==9) { $mes="SEPTIEMBRE";}
	if($mes_no==10) { $mes="OCTUBRE";}
	if($mes_no==11) { $mes="NOVIEMBRE";}
	if($mes_no==12) { $mes="DICIEMBRE";}

 $time = time(); // Timestamp Actual

$hoy1=$ano.$mes.$dia; 

?>  <?php echo $dia;?> d&iacute;as de mes de <?php echo $mes;?> del a&ntilde;o <?php echo $ano;?>.</p>
<br />
<br />
<br />
     
     
     </td>
     </tr>
     <tr>
		<td>
<span style="font-size:14px; line-height: 1.2em;">
<center>
__________________________________________<br />
<?php echo $row_colegio2['titulo_director']; ?> <?php echo $row_colegio2['nombre_director']." ".$row_colegio2['apellido_director']; ?><br />
V-<?php echo $row_colegio2['cedula_director']; ?><br />
<?php echo $row_colegio2['cargo_director']; ?>
</center>
</span>

<br />
<br />
VA SIN ENMIENDA   <br />
<br />
<?php echo $row_colegio2['enmienda']; ?>	
		</td>     
     </tr>
    <?php  }?>
    
 <!-- CONSTANCIA DE INSCRIPCION SOLO -->
    
<?php if($_GET['constancia']==4) { ?>
<tr>
 <td valign="top" align="center" class="texto_mediano_gris" ><br /><br /><h1 style="text-decoration: underline;">CONSTANCIA DE INSCRIPCI&Oacute;N </h1><br /><br />
     
<table width="600" >
     <tr >
     <td class="textogrande_eloy" style="font-size:14px; line-height: 2em; text-indent: 5em; text-align:justify; text-transform: uppercase;">
    <p>Quien suscribe, <?php if($row_colegio2['cargo_director']=="Director") { echo "EL ".$row_colegio2['cargo_director'];} if($row_colegio2['cargo_director']=="Directora") { echo "LA ".$row_colegio2['cargo_director'];} ?> de la  <b><?php echo $row_colegio['nomcol']; ?></b>, C&oacute;digo Plantel <b><?php echo $row_colegio2['cod_plantel']; ?></b>, ubicado en la <span style="text-transform: uppercase;"><?php echo $row_colegio['dircol']; ?></span>, 
    certifica que: <b><?php echo $row_reporte['nomalum']." ".$row_reporte['apellido']; ?>,</b> <b><?php echo $row_reporte['indicador_nacionalidad']."-".$row_reporte['cedula'];?></b>,  est&aacute; inscrito(a) para cursar el: <b ><?php echo $row_reporte['nombre_completo']; ?> </b>A&ntilde;o Escolar <?php echo $row_periodo['descripcion']; ?>.</p>
    <br />
    <p>Constancia que se expide a solicitud de parte interesada en la ciudad de  <?php echo $row_colegio['ciudad']; ?>, a los 
    <?php
 $fecha = date("d-m-Y"); // fecha actual
 $ano = date("Y"); // Año actual
 $mes_no = date("m"); // Mes actual
 $dia = date("d"); // Dia actual
	if($mes_no==1) { $mes="ENERO";}
	if($mes_no==2) { $mes="FEBRERO";}
	if($mes_no==3) { $mes="MARZO";}
	if($mes_no==4) { $mes="ABRIL";}
	if($mes_no==5) { $mes="MAYO";}
	if($mes_no==6) { $mes="JUNIO";}
	if($mes_no==7) { $mes="JULIO";}
	if($mes_no==8) { $mes="AGOSTO";}
	if($mes_no==9) { $mes="SEPTIEMBRE";}
	if($mes_no==10) { $mes="OCTUBRE";}
	if($mes_no==11) { $mes="NOVIEMBRE";}
	if($mes_no==12) { $mes="DICIEMBRE";}

 $time = time(); // Timestamp Actual

$hoy1=$ano.$mes.$dia; 

?>  <?php echo $dia;?> d&iacute;as de mes de <?php echo $mes;?> del a&ntilde;o <?php echo $ano;?>.</p>
<br />
<br />
<br />
     
     
     </td>
     </tr>
     <tr>
		<td>
<span style="font-size:14px; line-height: 1.2em;">
<center>
__________________________________________<br />
<?php echo $row_colegio2['titulo_director']; ?> <?php echo $row_colegio2['nombre_director']." ".$row_colegio2['apellido_director']; ?><br />
V-<?php echo $row_colegio2['cedula_director']; ?><br />
<?php echo $row_colegio2['cargo_director']; ?>
</center>
</span>

<br />
<br />
VA SIN ENMIENDA   <br />
<br />
<?php echo $row_colegio2['enmienda']; ?>	
		</td>     
     </tr>
    <?php  }?>
    
    

<!-- CONSTANCIA DE RETIRO -->

<?php if($_GET['constancia']==5) { ?>
<tr>
 <td valign="top" align="center" class="texto_mediano_gris" ><br /><br /><h1 style="text-decoration: underline;">CONSTANCIA DE RETIRO </h1><br /><br />
     
<table width="600" >
     <tr >
     <td class="textogrande_eloy" style="font-size:14px; line-height: 2em; text-indent: 5em; text-align:justify; text-transform: uppercase;">
    <p>Quien suscribe, <?php if($row_colegio2['cargo_director']=="Director") { echo "EL ".$row_colegio2['cargo_director'];} if($row_colegio2['cargo_director']=="Directora") { echo "LA ".$row_colegio2['cargo_director'];} ?> de la  <b><?php echo $row_colegio['nomcol']; ?></b>, C&oacute;digo Plantel <b><?php echo $row_colegio2['cod_plantel']; ?></b>, ubicado en la <span style="text-transform: uppercase;"><?php echo $row_colegio['dircol']; ?></span>, 
    certifica que: <b><?php echo $row_reporte['nomalum']." ".$row_reporte['apellido']; ?>,</b> <b><?php echo $row_reporte['indicador_nacionalidad']."-".$row_reporte['cedula'];?></b>, 	cursante del: <b ><?php echo $row_reporte['nombre_completo']; ?> </b>, fue retirado(a) de la Instituci&oacute;n el d&iacute;a <?php echo $_GET['fecha_retiro']; ?>.</p>
    <br />
    <p>Constancia que se expide a solicitud de parte interesada en la ciudad de  <?php echo $row_colegio['ciudad']; ?>, a los 
    <?php
 $fecha = date("d-m-Y"); // fecha actual
 $ano = date("Y"); // Año actual
 $mes_no = date("m"); // Mes actual
 $dia = date("d"); // Dia actual
	if($mes_no==1) { $mes="ENERO";}
	if($mes_no==2) { $mes="FEBRERO";}
	if($mes_no==3) { $mes="MARZO";}
	if($mes_no==4) { $mes="ABRIL";}
	if($mes_no==5) { $mes="MAYO";}
	if($mes_no==6) { $mes="JUNIO";}
	if($mes_no==7) { $mes="JULIO";}
	if($mes_no==8) { $mes="AGOSTO";}
	if($mes_no==9) { $mes="SEPTIEMBRE";}
	if($mes_no==10) { $mes="OCTUBRE";}
	if($mes_no==11) { $mes="NOVIEMBRE";}
	if($mes_no==12) { $mes="DICIEMBRE";}

 $time = time(); // Timestamp Actual

$hoy1=$ano.$mes.$dia; 

?>  <?php echo $dia;?> d&iacute;as de mes de <?php echo $mes;?> del a&ntilde;o <?php echo $ano;?>.</p>
<br />
<br />
<br />
     
     
     </td>
     </tr>
     <tr>
		<td>
<span style="font-size:14px; line-height: 1.2em;">
<center>
__________________________________________<br />
<?php echo $row_colegio2['titulo_director']; ?> <?php echo $row_colegio2['nombre_director']." ".$row_colegio2['apellido_director']; ?><br />
V-<?php echo $row_colegio2['cedula_director']; ?><br />
<?php echo $row_colegio2['cargo_director']; ?>
</center>
</span>

<br />
<br />
VA SIN ENMIENDA   <br />
<br />
<?php echo $row_colegio2['enmienda']; ?>	
		</td>     
     </tr>
    <?php  }?>
    
    

<!-- CONSTANCIA DE NOTAS -->
<?php if($_GET['constancia']=="6") { ?>

<tr>
 <td valign="top" align="center" class="texto_mediano_gris" ><br /><br /><h1 style="text-decoration: underline;">CONSTANCIA DE NOTAS </h1>
     
<table width="600" >
     <tr >
     <td class="textogrande_eloy" style="font-size:14px; line-height: 2em; text-indent: 5em; text-align:justify; text-transform: uppercase;">
    <p>Quien suscribe, <?php if($row_colegio2['cargo_director']=="Director") { echo "EL ".$row_colegio2['cargo_director'];} if($row_colegio2['cargo_director']=="Directora") { echo "LA ".$row_colegio2['cargo_director'];} ?> de la  <b><?php echo $row_colegio['nomcol']; ?></b>, C&oacute;digo Plantel <b><?php echo $row_colegio2['cod_plantel']; ?></b>, ubicado en la <span style="text-transform: uppercase;"><?php echo $row_colegio['dircol']; ?></span>, 
    hace constar por medio de la presente que: <b><?php echo $row_reporte['nomalum']." ".$row_reporte['apellido']; ?>,</b> <b><?php echo $row_reporte['indicador_nacionalidad']."-".$row_reporte['cedula'];?></b>, 	cursante del  <b ><?php echo $row_reporte['nombre_completo']; ?> </b>A&ntilde;o Escolar <?php echo $row_periodo['descripcion']; ?>.</p>

    <p>Obtuvo en su rendimiento acad&eacute;mico del <b><?php echo $_GET['lapsoc'];?> Lapso</b>, las siguientes calificaciones: </p>

<!-- AQUI VAN LAS NOTAS -->

<!-- INICIO DE LAS CALIFICACIONES -->

	<tr>	
   <td align="center" colspan="4">
    <table border="0" >
      <tr>
        <td width="500"  align="center" valign="top">
    <table border="0" >
      <tr>
        <td width="500"  align="center" valign="top">
        
        <table class="sample" >
			<tr>
            <?php // NOTAS DE PRIMER LAPSO
                    ?>
            <td colspan="3">
               <table class="sample2" >
              <tr >
              <td width="295"  align="center"><span style="font-size:14px; "><strong>ASIGNATURAS</strong></span></td>            <!--<td width="50"  align="center" ><em>DEF<br />CUA</em></td>-->
              <td width="50" align="center" ><em>DEF<br />L1</em></td>
              </tr>
            <?php do { ?>
              <tr>
              	<td width="300"  height="20" align="center" ><span><?php echo $row_asignatura1['nombre']; ?>	</span>
              	</td>
                 <!-- <td width="50" align="center" ><em class="texto_mediano_grande">
                   <?php if($row_asignatura1['def']==0){ echo "-"; }?> <?php if(($row_asignatura1['def']>0) and ($row_asignatura1['def']<10)){ echo "I";} if(($row_asignatura1['def']>9) and ($row_asignatura1['def']<14)){ echo "P";} if(($row_asignatura1['def']>13) and ($row_asignatura1['def']<18)){ echo "A";} if(($row_asignatura1['def']>17) and ($row_asignatura1['def']<21)){ echo "C"; }?>
                </em></td>-->
                <td width="50" align="center" ><span ><b><?php if($row_asignatura1['def']==0){ echo 'NC';}?> <?php if(($row_asignatura1['def']>0) and ($row_asignatura1['def']<10)) { echo "0".$row_asignatura1['def']; }?> <?php if($row_asignatura1['def']>9){ echo $row_asignatura1['def']; }?></b></span>
                </td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura1 = mysql_fetch_assoc($asignatura1)); ?>
  
<?php //PREMILITAR PRIMER LAPSO ?>
  <?php if($totalRows_mate151>0){?>
	<tr>
        
	<td align="center" height="20"><span >INSTRUCCION PRE-MILITAR</span></td>
              <!--  <td align="center" >
                   <?php if($row_mate141['def']==0){ echo "-"; }?> <?php if(($row_mate141['def']>=1) and ($row_mate141['def']<=9)){ echo "I";} if(($row_mate141['def']>9) and ($row_mate141['def']<14)){ echo "P";} if(($row_mate141['def']>13) and ($row_mate141['def']<18)){ echo "A";} if(($row_mate141['def']>17) and ($row_mate141['def']<21)){ echo "C"; }?>
               </td>-->
	 <td align="center" ><span ><b><?php if($row_mate151['def']==0){ echo 'NC';}?> <?php if(($row_mate151['def']>0) and ($row_mate151['def']<10)) { echo "0".$row_mate151['def']; }?> <?php if($row_mate151['def']>9){ echo $row_mate151['def']; }?></b></span></td>
	 </tr>
	 <?php } ?>  
  
  <?php //EPT PRIMER LAPSO ?>
  <?php if($totalRows_mate141>0){?>
	<tr>
        
	<td align="center" height="20"><span >EDUCACION PARA EL TRABAJO</span></td>
              <!--  <td align="center" >
                   <?php if($row_mate141['def']==0){ echo "-"; }?> <?php if(($row_mate141['def']>=1) and ($row_mate141['def']<=9)){ echo "I";} if(($row_mate141['def']>9) and ($row_mate141['def']<14)){ echo "P";} if(($row_mate141['def']>13) and ($row_mate141['def']<18)){ echo "A";} if(($row_mate141['def']>17) and ($row_mate141['def']<21)){ echo "C"; }?>
               </td>-->
	 <td align="center" ><span ><b><?php if($row_mate141['def']==0){ echo 'NC';}?> <?php if(($row_mate141['def']>0) and ($row_mate141['def']<10)) { echo "0".$row_mate141['def']; }?> <?php if($row_mate141['def']>9){ echo $row_mate141['def']; }?></b></span></td>
	 </tr>
	 <?php } ?>
	 
               </table>
            </td>


            <?php if(($totalRows_asignatura2>0) and ($_GET['lapsoc']==2) or ($_GET['lapsoc']==3)){
					 // NOTAS DE SEGUNDO LAPSO
                    ?>
            <td colspan="2">
              <table class="sample2">
                <tr>
					<!--<td width="50"  align="center"><em>DEF<br />CUA</em></td>-->
               <td width="50" align="center" ><em>DEF<br />L2</em></td>                
                </tr>
            <?php do { ?>
              <tr>
               
             <!--   <td width="50" align="center" ><em class="texto_mediano_grande">
                   <?php if($row_asignatura2['def']==0){ echo "-"; }?> <?php if(($row_asignatura2['def']>0) and ($row_asignatura2['def']<10)){ echo "I";} if(($row_asignatura2['def']>9) and ($row_asignatura2['def']<14)){ echo "P";} if(($row_asignatura2['def']>13) and ($row_asignatura2['def']<18)){ echo "A";} if(($row_asignatura2['def']>17) and ($row_asignatura2['def']<21)){ echo "C"; }?>
                </em></td> --> 
                <td width="50" height="20" align="center"><span ><b><?php if($row_asignatura2['def']==0){ echo 'NC';}?> <?php if(($row_asignatura2['def']>0) and ($row_asignatura2['def']<10)) { echo "0".$row_asignatura2['def']; }?> <?php if($row_asignatura2['def']>9){ echo $row_asignatura2['def']; }?></b></span></td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura2 = mysql_fetch_assoc($asignatura2)); ?>
<?php //PREMILITAR SEGUNDO LAPSO ?>
  <?php if($totalRows_mate152>0){?>
	<tr>

	 <td align="center" height="20"><span ><b><?php if($row_mate152['def']==0){ echo 'NC';}?> <?php if(($row_mate152['def']>0) and ($row_mate152['def']<10)) { echo "0".$row_mate152['def']; }?> <?php if($row_mate152['def']>9){ echo $row_mate152['def']; }?></b></span></td>
	 </tr>
	 <?php } ?>    
  
                <?php //EPT SEGUNDO LAPSO ?>
          <tr>
         <?php if($totalRows_mate142>0){?>
       <!--  <td align="center" height="20">
                   <?php if($row_mate142['def']==0){ echo "-"; }?> <?php if(($row_mate142['def']>=1) and ($row_mate142['def']<=9)){ echo "I";} if(($row_mate142['def']>9) and ($row_mate142['def']<14)){ echo "P";} if(($row_mate142['def']>13) and ($row_mate142['def']<18)){ echo "A";} if(($row_mate142['def']>17) and ($row_mate142['def']<21)){ echo "C"; }?>
               </td>-->
	 <td align="center" height="20"><span ><b><?php if($row_mate142['def']==0){ echo 'NC';}?> <?php if(($row_mate142['def']>0) and ($row_mate142['def']<10)) { echo "0".$row_mate142['def']; }?> <?php if($row_mate142['def']>9){ echo $row_mate142['def']; }?></b></span></td>
	 </tr>
			<?php } ?>
              
               </table>

            </td>
			<?php } 
			if(($totalRows_asignatura3>0) and ($_GET['lapsoc']==3)){ // NOTAS DE TERCER LAPSO
			
			?>

            <td colspan="2">
                <table class="sample2">
                <tr>
					<td width="50"  align="center"><em>DEF<br />CUA</em></td>
               <td width="50" align="center" ><em>DEF<br />L3</em></td>                
                </tr>
            <?php do { ?>
              <tr>

                <td width="50" align="center" ><em class="texto_mediano_grande">
                   <?php if($row_asignatura3['def']==0){ echo "-"; }?> <?php if(($row_asignatura3['def']>0) and ($row_asignatura3['def']<10)){ echo "I";} if(($row_asignatura3['def']>9) and ($row_asignatura3['def']<14)){ echo "P";} if(($row_asignatura3['def']>13) and ($row_asignatura3['def']<18)){ echo "A";} if(($row_asignatura3['def']>17) and ($row_asignatura3['def']<21)){ echo "C"; }?>
                </em></td>
                <td width="50" align="center"><span ><b><?php if($row_asignatura3['def']==0){ echo 'NC';}?> <?php if(($row_asignatura3['def']>0) and ($row_asignatura3['def']<10)) { echo "0".$row_asignatura3['def']; }?> <?php if($row_asignatura3['def']>9){ echo $row_asignatura3['def']; }?></b></span></td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura3 = mysql_fetch_assoc($asignatura3)); ?>
              <tr>
              
  <?php //PREMILITAR TERCER LAPSO ?>
  <?php if($totalRows_mate153>0){?>
	<tr>

	 <td align="center" ><span ><b><?php if($row_mate153['def']==0){ echo 'NC';}?> <?php if(($row_mate153['def']>0) and ($row_mate153['def']<10)) { echo "0".$row_mate153['def']; }?> <?php if($row_mate153['def']>9){ echo $row_mate153['def']; }?></b></span></td>
	 </tr>
	 <?php } ?>    
	 
         <?php //EPT TERCER LAPSO ?>
 			<?php if($totalRows_mate143>0){?>
         <td align="center" height="20">
                   <?php if($row_mate143['def']==0){ echo "-"; }?> <?php if(($row_mate143['def']>=1) and ($row_mate143['def']<=9)){ echo "I";} if(($row_mate143['def']>9) and ($row_mate143['def']<14)){ echo "P";} if(($row_mate143['def']>13) and ($row_mate143['def']<18)){ echo "A";} if(($row_mate143['def']>17) and ($row_mate143['def']<21)){ echo "C"; }?>
               </td>
	 <td align="center"><span ><b><?php if($row_mate143['def']==0){ echo 'NC';}?> <?php if(($row_mate143['def']>0) and ($row_mate143['def']<10)) { echo "0".$row_mate143['def']; }?> <?php if($row_mate143['def']>9){ echo $row_mate143['def']; }?></b></span></td>
         <?php } ?>              
              </tr>
               </table>

            </td>
<?php } ?>


 <?php if($totalRows_asignatura_final>0){
                        // DEFINITIVA DE ANIO
                    ?>
            <td colspan="2">
                <table class="sample2">
                <tr>
						<td width="50"  align="center" ><em>DEF<br />A&Ntilde;O</em></td>                
                </tr>
            <?php do { ?>
              <tr>

                <td width="50" height="20" align="center" style="font-size:12px;"><span ><b><?php if($row_asignatura_final['def']==0){ echo 'NC';}?> <?php if(($row_asignatura_final['def']>0) and ($row_asignatura_final['def']<10)) { echo "0".$row_asignatura_final['def']; }?> <?php if($row_asignatura_final['def']>9){ echo $row_asignatura_final['def']; }?></b></span></td>

<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>


*/?>
              </tr>
              <?php } while ($row_asignatura_final = mysql_fetch_assoc($asignatura_final)); ?>
         
         
       	<?php //DEF PREMILITAR ?>
         <?php if($totalRows_mate15_final>0){?>
			<tr>
	 		<td height="20" align="center" style="font-size:12px"><span ><b><?php if($row_mate15_final['def']==0){ echo 'NC';}?> <?php if(($row_mate15_final['def']>0) and ($row_mate15_final['def']<10)) { echo "0".$row_mate15_final['def']; }?> <?php if($row_mate15_final['def']>9){ echo $row_mate15_final['def']; }?></b></span></td>
         <?php } ?>
         
             
        	<?php //DEF EPT ?>
         <?php if($totalRows_mate14_final>0){?>
			<tr>
	 		<td height="20" align="center" style="font-size:12px"><span ><b><?php if($row_mate14_final['def']==0){ echo 'NC';}?> <?php if(($row_mate14_final['def']>0) and ($row_mate14_final['def']<10)) { echo "0".$row_mate14_final['def']; }?> <?php if($row_mate14_final['def']>9){ echo $row_mate14_final['def']; }?></b></span></td>
         <?php } ?>
         </td>
          </tr>     
      </table>

<?php } ?>


  

    </td>


         
	</tr>





          </table>


<!-- fin de LAS NOTAS -->




     
     
     </td>
     </tr>
     <tr>
		<td>
<p> <?php echo $row_colegio['ciudad']; ?>,  
    <?php
 $fecha = date("d-m-Y"); // fecha actual
 $ano = date("Y"); // Año actual
 $mes_no = date("m"); // Mes actual
 $dia = date("d"); // Dia actual
	if($mes_no==1) { $mes="ENERO";}
	if($mes_no==2) { $mes="FEBRERO";}
	if($mes_no==3) { $mes="MARZO";}
	if($mes_no==4) { $mes="ABRIL";}
	if($mes_no==5) { $mes="MAYO";}
	if($mes_no==6) { $mes="JUNIO";}
	if($mes_no==7) { $mes="JULIO";}
	if($mes_no==8) { $mes="AGOSTO";}
	if($mes_no==9) { $mes="SEPTIEMBRE";}
	if($mes_no==10) { $mes="OCTUBRE";}
	if($mes_no==11) { $mes="NOVIEMBRE";}
	if($mes_no==12) { $mes="DICIEMBRE";}

 $time = time(); // Timestamp Actual

$hoy1=$ano.$mes.$dia; 

?>  <?php echo $dia;?> DE <?php echo $mes;?> DE <?php echo $ano;?>.</p>
<br />
<br />
<br />
<span style="font-size:14px; line-height: 1.2em;">
<center>
__________________________________________<br />
<?php echo $row_colegio2['titulo_director']; ?> <?php echo $row_colegio2['nombre_director']." ".$row_colegio2['apellido_director']; ?><br />
V-<?php echo $row_colegio2['cedula_director']; ?><br />
<?php echo $row_colegio2['cargo_director']; ?>
</center>
</span>

<br />
<br />
VA SIN ENMIENDA   <br />
<br />
<?php echo $row_colegio2['enmienda']; ?>	
		</td>     
     </tr>
    <?php  }?>
    
    
    
<!-- FIN DE LAS CONSTANCIAS -->

	</table>
		<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_reporte == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen registros en esta area</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
    <tr><td>    </td>
</tr>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);
mysql_free_result($colegio2);
mysql_free_result($colegio);
?>
