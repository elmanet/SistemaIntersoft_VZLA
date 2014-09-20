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

// CONSULTA SQL

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

//CONSULTA DE LAS NOTAS EXISTENTES
$colname_alumno_notaexiste1 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno_notaexiste1 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notaexiste1 = sprintf("SELECT * FROM jos_alumno_info a, jos_cdc_resumen b, jos_curso c, jos_anio_nombre d WHERE a.alumno_id=b.alumno_id AND b.tipo_resumen=1 AND b.curso_id=c.id AND c.anio_id=d.id AND d.orden_resumen=1 AND a.cedula = %s", GetSQLValueString($colname_alumno_notaexiste1, "bigint"));
$alumno_notaexiste1 = mysql_query($query_alumno_notaexiste1, $sistemacol) or die(mysql_error());
$row_alumno_notaexiste1 = mysql_fetch_assoc($alumno_notaexiste1);
$totalRows_alumno_notaexiste1 = mysql_num_rows($alumno_notaexiste1);
//2
$colname_alumno_notaexiste2 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno_notaexiste2 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notaexiste2 = sprintf("SELECT * FROM jos_alumno_info a, jos_cdc_resumen b, jos_curso c, jos_anio_nombre d WHERE a.alumno_id=b.alumno_id AND b.tipo_resumen=1 AND b.curso_id=c.id AND c.anio_id=d.id AND d.orden_resumen=2 AND a.cedula = %s", GetSQLValueString($colname_alumno_notaexiste2, "bigint"));
$alumno_notaexiste2 = mysql_query($query_alumno_notaexiste2, $sistemacol) or die(mysql_error());
$row_alumno_notaexiste2 = mysql_fetch_assoc($alumno_notaexiste2);
$totalRows_alumno_notaexiste2 = mysql_num_rows($alumno_notaexiste2);
//3
$colname_alumno_notaexiste3 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno_notaexiste3 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notaexiste3 = sprintf("SELECT * FROM jos_alumno_info a, jos_cdc_resumen b, jos_curso c, jos_anio_nombre d WHERE a.alumno_id=b.alumno_id AND b.tipo_resumen=1 AND b.curso_id=c.id AND c.anio_id=d.id AND d.orden_resumen=3 AND a.cedula = %s", GetSQLValueString($colname_alumno_notaexiste3, "bigint"));
$alumno_notaexiste3 = mysql_query($query_alumno_notaexiste3, $sistemacol) or die(mysql_error());
$row_alumno_notaexiste3 = mysql_fetch_assoc($alumno_notaexiste3);
$totalRows_alumno_notaexiste3 = mysql_num_rows($alumno_notaexiste3);
//4
$colname_alumno_notaexiste4 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno_notaexiste4 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notaexiste4 = sprintf("SELECT * FROM jos_alumno_info a, jos_cdc_resumen b, jos_curso c, jos_anio_nombre d WHERE a.alumno_id=b.alumno_id AND b.tipo_resumen=1 AND b.curso_id=c.id AND c.anio_id=d.id AND d.orden_resumen=4 AND a.cedula = %s", GetSQLValueString($colname_alumno_notaexiste4, "bigint"));
$alumno_notaexiste4 = mysql_query($query_alumno_notaexiste4, $sistemacol) or die(mysql_error());
$row_alumno_notaexiste4 = mysql_fetch_assoc($alumno_notaexiste4);
$totalRows_alumno_notaexiste4 = mysql_num_rows($alumno_notaexiste4);
//5
$colname_alumno_notaexiste5 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno_notaexiste5 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notaexiste5 = sprintf("SELECT * FROM jos_alumno_info a, jos_cdc_resumen b, jos_curso c, jos_anio_nombre d WHERE a.alumno_id=b.alumno_id AND b.tipo_resumen=1 AND b.curso_id=c.id AND c.anio_id=d.id AND d.orden_resumen=5 AND a.cedula = %s", GetSQLValueString($colname_alumno_notaexiste5, "bigint"));
$alumno_notaexiste5 = mysql_query($query_alumno_notaexiste5, $sistemacol) or die(mysql_error());
$row_alumno_notaexiste5 = mysql_fetch_assoc($alumno_notaexiste5);
$totalRows_alumno_notaexiste5 = mysql_num_rows($alumno_notaexiste5);
//6
$colname_alumno_notaexiste6 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno_notaexiste6 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notaexiste6 = sprintf("SELECT * FROM jos_alumno_info a, jos_cdc_resumen b, jos_curso c, jos_anio_nombre d WHERE a.alumno_id=b.alumno_id AND b.tipo_resumen=1 AND b.curso_id=c.id AND c.anio_id=d.id AND d.orden_resumen=6 AND a.cedula = %s", GetSQLValueString($colname_alumno_notaexiste6, "bigint"));
$alumno_notaexiste6 = mysql_query($query_alumno_notaexiste6, $sistemacol) or die(mysql_error());
$row_alumno_notaexiste6 = mysql_fetch_assoc($alumno_notaexiste6);
$totalRows_alumno_notaexiste6 = mysql_num_rows($alumno_notaexiste6);


//consultar la existencia de planteles asociados a estudiante
$colname_plantelcurso = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_plantelcurso = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_plantelcurso = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_plantelcurso = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantelcurso = sprintf("SELECT a.id, a.no, a.ef, c.nombre_plantel, e.localidad FROM jos_cdc_plantelcurso a, jos_cdc_estudiante b, jos_cdc_nombre_plantel c, jos_cdc_planestudio d, jos_cdc_localidad e WHERE a.alumno_id=b.id AND a.nombre_plantel_id=c.id AND a.planestudio_id=d.id AND a.localidad_id=e.id AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no ASC", GetSQLValueString($colname_plantelcurso, "int"), GetSQLValueString($alumno_plantelcurso, "bigint"));
$plantelcurso = mysql_query($query_plantelcurso, $sistemacol) or die(mysql_error());
$row_plantelcurso = mysql_fetch_assoc($plantelcurso);
$totalRows_plantelcurso = mysql_num_rows($plantelcurso);


//consultar la existencia de asignaturas de ETP
$colname_eptcurso = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_eptcurso = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_eptcurso = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_eptcurso = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_eptcurso = sprintf("SELECT a.id, a.horas_clase, d.inicial, c.nombre_asignatura_ept FROM jos_cdc_ept_cursadas a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas_ept c, jos_cdc_pensum_anios d, jos_cdc_planestudio e WHERE a.alumno_id=b.id AND a.planestudio_id=e.id AND c.anio_id=d.id AND a.asignatura_ept_id=c.id AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no_orden ASC", GetSQLValueString($colname_eptcurso, "int"), GetSQLValueString($alumno_eptcurso, "bigint"));
$eptcurso = mysql_query($query_eptcurso, $sistemacol) or die(mysql_error());
$row_eptcurso = mysql_fetch_assoc($eptcurso);
$totalRows_eptcurso = mysql_num_rows($eptcurso);

//consultar la existencia  de Observaciones

$colname_observaciones = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_observaciones = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_observaciones = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_observaciones = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_observaciones = sprintf("SELECT a.id, a.observacion FROM jos_cdc_observaciones a, jos_cdc_estudiante b, jos_cdc_planestudio c WHERE a.alumno_id=b.id AND a.planestudio_id=c.id AND a.planestudio_id=%s AND b.cedula=%s", GetSQLValueString($colname_observaciones, "int"), GetSQLValueString($alumno_observaciones, "bigint"));
$observaciones = mysql_query($query_observaciones, $sistemacol) or die(mysql_error());
$row_observaciones = mysql_fetch_assoc($observaciones);
$totalRows_observaciones = mysql_num_rows($observaciones);

// existencia de alumno_plan de estudio


$colname_alumno_planestudio = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_alumno_planestudio = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_alumno_planestudio = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_alumno_planestudio = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio_estudiante a, jos_cdc_estudiante b WHERE a.alumno_id=b.id AND a.planestudio_id=%s AND b.cedula=%s", GetSQLValueString($colname_alumno_planestudio, "int"), GetSQLValueString($alumno_alumno_planestudio, "bigint"));
$alumno_planestudio = mysql_query($query_alumno_planestudio, $sistemacol) or die(mysql_error());
$row_alumno_planestudio = mysql_fetch_assoc($alumno_planestudio);
$totalRows_alumno_planestudio = mysql_num_rows($alumno_planestudio);


// seleccionar consulta de planteles

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel = sprintf("SELECT * FROM jos_cdc_nombre_plantel  ORDER BY nombre_plantel ASC");
$plantel = mysql_query($query_plantel, $sistemacol) or die(mysql_error());
$row_plantel = mysql_fetch_assoc($plantel);
$totalRows_plantel = mysql_num_rows($plantel);

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel_dos = sprintf("SELECT * FROM jos_cdc_nombre_plantel  ORDER BY nombre_plantel ASC");
$plantel_dos = mysql_query($query_plantel_dos, $sistemacol) or die(mysql_error());
$row_plantel_dos = mysql_fetch_assoc($plantel_dos);
$totalRows_plantel_dos = mysql_num_rows($plantel_dos);

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel_tres = sprintf("SELECT * FROM jos_cdc_nombre_plantel  ORDER BY nombre_plantel ASC");
$plantel_tres = mysql_query($query_plantel_tres, $sistemacol) or die(mysql_error());
$row_plantel_tres = mysql_fetch_assoc($plantel_tres);
$totalRows_plantel_tres = mysql_num_rows($plantel_tres);

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel_cuatro = sprintf("SELECT * FROM jos_cdc_nombre_plantel  ORDER BY nombre_plantel ASC");
$plantel_cuatro = mysql_query($query_plantel_cuatro, $sistemacol) or die(mysql_error());
$row_plantel_cuatro = mysql_fetch_assoc($plantel_cuatro);
$totalRows_plantel_cuatro = mysql_num_rows($plantel_cuatro);

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel_cinco = sprintf("SELECT * FROM jos_cdc_nombre_plantel  ORDER BY nombre_plantel ASC");
$plantel_cinco = mysql_query($query_plantel_cinco, $sistemacol) or die(mysql_error());
$row_plantel_cinco = mysql_fetch_assoc($plantel_cinco);
$totalRows_plantel_cinco = mysql_num_rows($plantel_cinco);

//CONSULTA DE LOCALIDADES
mysql_select_db($database_sistemacol, $sistemacol);
$query_local1 = sprintf("SELECT * FROM jos_cdc_localidad  ORDER BY localidad ASC");
$local1 = mysql_query($query_local1, $sistemacol) or die(mysql_error());
$row_local1 = mysql_fetch_assoc($local1);
$totalRows_local1 = mysql_num_rows($local1);

mysql_select_db($database_sistemacol, $sistemacol);
$query_local2 = sprintf("SELECT * FROM jos_cdc_localidad  ORDER BY localidad ASC");
$local2 = mysql_query($query_local2, $sistemacol) or die(mysql_error());
$row_local2 = mysql_fetch_assoc($local2);
$totalRows_local2 = mysql_num_rows($local2);

mysql_select_db($database_sistemacol, $sistemacol);
$query_local3 = sprintf("SELECT * FROM jos_cdc_localidad  ORDER BY localidad ASC");
$local3 = mysql_query($query_local3, $sistemacol) or die(mysql_error());
$row_local3 = mysql_fetch_assoc($local3);
$totalRows_local3 = mysql_num_rows($local3);

mysql_select_db($database_sistemacol, $sistemacol);
$query_local4 = sprintf("SELECT * FROM jos_cdc_localidad  ORDER BY localidad ASC");
$local4 = mysql_query($query_local4, $sistemacol) or die(mysql_error());
$row_local4 = mysql_fetch_assoc($local4);
$totalRows_local4 = mysql_num_rows($local4);

mysql_select_db($database_sistemacol, $sistemacol);
$query_local5 = sprintf("SELECT * FROM jos_cdc_localidad  ORDER BY localidad ASC");
$local5 = mysql_query($query_local5, $sistemacol) or die(mysql_error());
$row_local5 = mysql_fetch_assoc($local5);
$totalRows_local5 = mysql_num_rows($local5);

// SELECCIONAR EPT
$colname_ept1 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept1 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept1 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept1, "int"));
$ept1 = mysql_query($query_ept1, $sistemacol) or die(mysql_error());
$row_ept1 = mysql_fetch_assoc($ept1);
$totalRows_ept1 = mysql_num_rows($ept1);

$colname_ept2 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept2 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept2 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept2, "int"));
$ept2 = mysql_query($query_ept2, $sistemacol) or die(mysql_error());
$row_ept2 = mysql_fetch_assoc($ept2);
$totalRows_ept2 = mysql_num_rows($ept2);

$colname_ept3 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept3 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept3 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept3, "int"));
$ept3 = mysql_query($query_ept3, $sistemacol) or die(mysql_error());
$row_ept3 = mysql_fetch_assoc($ept3);
$totalRows_ept3 = mysql_num_rows($ept3);

$colname_ept4 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept4 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept4 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept4, "int"));
$ept4 = mysql_query($query_ept4, $sistemacol) or die(mysql_error());
$row_ept4 = mysql_fetch_assoc($ept4);
$totalRows_ept4 = mysql_num_rows($ept4);

$colname_ept5 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept5 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept5 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept5, "int"));
$ept5 = mysql_query($query_ept5, $sistemacol) or die(mysql_error());
$row_ept5 = mysql_fetch_assoc($ept5);
$totalRows_ept5 = mysql_num_rows($ept5);

$colname_ept6 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept6 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept6 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept6, "int"));
$ept6 = mysql_query($query_ept6, $sistemacol) or die(mysql_error());
$row_ept6 = mysql_fetch_assoc($ept6);
$totalRows_ept6 = mysql_num_rows($ept6);

$colname_ept7 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept7 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept7 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept7, "int"));
$ept7 = mysql_query($query_ept7, $sistemacol) or die(mysql_error());
$row_ept7 = mysql_fetch_assoc($ept7);
$totalRows_ept7 = mysql_num_rows($ept7);

$colname_ept8 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept8 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept8 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept8, "int"));
$ept8 = mysql_query($query_ept8, $sistemacol) or die(mysql_error());
$row_ept8 = mysql_fetch_assoc($ept8);
$totalRows_ept8 = mysql_num_rows($ept8);

$colname_ept9 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_ept9 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept9 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept9, "int"));
$ept9 = mysql_query($query_ept9, $sistemacol) or die(mysql_error());
$row_ept9 = mysql_fetch_assoc($ept9);
$totalRows_ept9 = mysql_num_rows($ept9);

$colname_ept10 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {





  $colname_ept10 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_ept10 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id AND c.id=%s  ORDER BY b.no_anio, a.nombre_asignatura_ept  ASC", GetSQLValueString($colname_ept10, "int"));
$ept10 = mysql_query($query_ept10, $sistemacol) or die(mysql_error());
$row_ept10 = mysql_fetch_assoc($ept10);
$totalRows_ept10 = mysql_num_rows($ept10);


// SELECCIONAR ESTUDIANTE
$colname_alumno = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $colname_alumno = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT id, nombre_alumno, apellido_alumno, indicador_nacionalidad, fecha_nacimiento, lugar_nacimiento, ent_federal_pais, cedula FROM jos_cdc_estudiante WHERE cedula = %s", GetSQLValueString($colname_alumno, "bigint"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

// planes de estudio consultas
$plan_alumno_plan1 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_alumno_plan1 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_plan1 = sprintf("SELECT a.id, b.nombre_anio, c.id as mate, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_pensum_anios b, jos_cdc_pensum_asignaturas c WHERE c.anio_id=b.id AND b.planestudio_id=a.id AND a.id=%s AND b.no_anio=1 ORDER BY b.no_anio, c.orden_asignatura  ASC", GetSQLValueString($plan_alumno_plan1, "int"));
$alumno_plan1 = mysql_query($query_alumno_plan1, $sistemacol) or die(mysql_error());
$row_alumno_plan1 = mysql_fetch_assoc($alumno_plan1);
$totalRows_alumno_plan1 = mysql_num_rows($alumno_plan1);

$plan_alumno_plan2 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_alumno_plan2 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_plan2 = sprintf("SELECT a.id, b.nombre_anio, c.id as mate, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_pensum_anios b, jos_cdc_pensum_asignaturas c WHERE c.anio_id=b.id AND b.planestudio_id=a.id AND a.id=%s AND b.no_anio=2 ORDER BY b.no_anio, c.orden_asignatura  ASC", GetSQLValueString($plan_alumno_plan2, "int"));
$alumno_plan2 = mysql_query($query_alumno_plan2, $sistemacol) or die(mysql_error());
$row_alumno_plan2 = mysql_fetch_assoc($alumno_plan2);
$totalRows_alumno_plan2 = mysql_num_rows($alumno_plan2);

$plan_alumno_plan3 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_alumno_plan3 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_plan3 = sprintf("SELECT a.id, b.nombre_anio, c.id as mate, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_pensum_anios b, jos_cdc_pensum_asignaturas c WHERE c.anio_id=b.id AND b.planestudio_id=a.id AND a.id=%s AND b.no_anio=3 ORDER BY b.no_anio, c.orden_asignatura  ASC", GetSQLValueString($plan_alumno_plan3, "int"));
$alumno_plan3 = mysql_query($query_alumno_plan3, $sistemacol) or die(mysql_error());
$row_alumno_plan3 = mysql_fetch_assoc($alumno_plan3);
$totalRows_alumno_plan3 = mysql_num_rows($alumno_plan3);

$plan_alumno_plan4 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_alumno_plan4 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_plan4 = sprintf("SELECT a.id, b.nombre_anio, c.id as mate, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_pensum_anios b, jos_cdc_pensum_asignaturas c WHERE c.anio_id=b.id AND b.planestudio_id=a.id AND a.id=%s AND b.no_anio=4 ORDER BY b.no_anio, c.orden_asignatura  ASC", GetSQLValueString($plan_alumno_plan4, "int"));
$alumno_plan4 = mysql_query($query_alumno_plan4, $sistemacol) or die(mysql_error());
$row_alumno_plan4 = mysql_fetch_assoc($alumno_plan4);
$totalRows_alumno_plan4 = mysql_num_rows($alumno_plan4);

$plan_alumno_plan5 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_alumno_plan5 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_plan5 = sprintf("SELECT a.id, b.nombre_anio, c.id as mate, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_pensum_anios b, jos_cdc_pensum_asignaturas c WHERE c.anio_id=b.id AND b.planestudio_id=a.id AND a.id=%s AND b.no_anio=5 ORDER BY b.no_anio, c.orden_asignatura  ASC", GetSQLValueString($plan_alumno_plan5, "int"));
$alumno_plan5 = mysql_query($query_alumno_plan5, $sistemacol) or die(mysql_error());
$row_alumno_plan5 = mysql_fetch_assoc($alumno_plan5);
$totalRows_alumno_plan5 = mysql_num_rows($alumno_plan5);

$plan_alumno_plan6 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_alumno_plan6 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_plan6 = sprintf("SELECT a.id, b.nombre_anio, c.id as mate, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_pensum_anios b, jos_cdc_pensum_asignaturas c WHERE c.anio_id=b.id AND b.planestudio_id=a.id AND a.id=%s AND b.no_anio=6 ORDER BY b.no_anio, c.orden_asignatura  ASC", GetSQLValueString($plan_alumno_plan6, "int"));
$alumno_plan6 = mysql_query($query_alumno_plan6, $sistemacol) or die(mysql_error());
$row_alumno_plan6 = mysql_fetch_assoc($alumno_plan6);
$totalRows_alumno_plan6 = mysql_num_rows($alumno_plan6);

// CONSULTA DE NOTAS DEL ESTUDIANTE CARGADAS
$plan_notas_plan1 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan1 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan1 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan1 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan1 = sprintf("SELECT * FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND d.no_anio=1 AND a.id=%s AND b.cedula=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan1, "int"), GetSQLValueString($alumno_notas_plan1, "bigint"));
$notas_plan1 = mysql_query($query_notas_plan1, $sistemacol) or die(mysql_error());
$row_notas_plan1 = mysql_fetch_assoc($notas_plan1);
$totalRows_notas_plan1 = mysql_num_rows($notas_plan1);

$plan_notas_plan2 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan2 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan2 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan2 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan2 = sprintf("SELECT * FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND d.no_anio=2 AND a.id=%s AND b.cedula=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan2, "int"), GetSQLValueString($alumno_notas_plan2, "bigint"));
$notas_plan2 = mysql_query($query_notas_plan2, $sistemacol) or die(mysql_error());
$row_notas_plan2 = mysql_fetch_assoc($notas_plan2);
$totalRows_notas_plan2 = mysql_num_rows($notas_plan2);

$plan_notas_plan3 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan3 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan3 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan3 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan3 = sprintf("SELECT * FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND d.no_anio=3 AND a.id=%s AND b.cedula=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan3, "int"), GetSQLValueString($alumno_notas_plan3, "bigint"));
$notas_plan3 = mysql_query($query_notas_plan3, $sistemacol) or die(mysql_error());
$row_notas_plan3 = mysql_fetch_assoc($notas_plan3);
$totalRows_notas_plan3 = mysql_num_rows($notas_plan3);

$plan_notas_plan4 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan4 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan4 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan4 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan4 = sprintf("SELECT * FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND d.no_anio=4 AND a.id=%s AND b.cedula=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan4, "int"), GetSQLValueString($alumno_notas_plan4, "bigint"));
$notas_plan4 = mysql_query($query_notas_plan4, $sistemacol) or die(mysql_error());
$row_notas_plan4 = mysql_fetch_assoc($notas_plan4);
$totalRows_notas_plan4 = mysql_num_rows($notas_plan4);

$plan_notas_plan5 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan5 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan5 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan5 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan5 = sprintf("SELECT * FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND d.no_anio=5 AND a.id=%s AND b.cedula=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan5, "int"), GetSQLValueString($alumno_notas_plan5, "bigint"));
$notas_plan5 = mysql_query($query_notas_plan5, $sistemacol) or die(mysql_error());
$row_notas_plan5 = mysql_fetch_assoc($notas_plan5);
$totalRows_notas_plan5 = mysql_num_rows($notas_plan5);

$plan_notas_plan6 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan6 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan6 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan6 = $_GET['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan6 = sprintf("SELECT * FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND d.no_anio=6 AND a.id=%s AND b.cedula=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan6, "int"), GetSQLValueString($alumno_notas_plan6, "bigint"));
$notas_plan6 = mysql_query($query_notas_plan6, $sistemacol) or die(mysql_error());
$row_notas_plan6 = mysql_fetch_assoc($notas_plan6);
$totalRows_notas_plan6 = mysql_num_rows($notas_plan6);

// otra cosa

$anio_colname = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $anio_colname = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_anio = sprintf("SELECT a.id, a.nombre_anio, b.cod, a.inicial FROM jos_cdc_pensum_anios a, jos_cdc_planestudio b WHERE a.planestudio_id=b.id AND a.planestudio_id=%s ORDER BY b.id, a.no_anio ASC", GetSQLValueString($anio_colname, "int"));
$anio = mysql_query($query_anio, $sistemacol) or die(mysql_error());
$row_anio = mysql_fetch_assoc($anio);
$totalRows_anio = mysql_num_rows($anio);



// INICIO DE SQL DE REGISTRO DE  DATOS 

// INSERTAR LOS PLANTELES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_plantel")) {
$total=$_POST["totalalum"];

$i = 0;
do { 
   $i++;

if($_POST['nombre_plantel_id'.$i]==!NULL){

  $insertSQL = sprintf("INSERT INTO jos_cdc_plantelcurso (id, no, nombre_plantel_id, localidad_id, ef, alumno_id, planestudio_id) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['no'.$i], "int"),
                       GetSQLValueString($_POST['nombre_plantel_id'.$i], "int"),
                       GetSQLValueString($_POST['localidad_id'.$i], "int"),
                       GetSQLValueString($_POST['ef'.$i], "text"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['planestudio_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}


} while ($i+1 <= $total );

if($totalRows_alumno_planestudio>0){
  $insertGoTo = "cargar_certificacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
}
 header(sprintf("Location: %s", $insertGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if($totalRows_alumno_planestudio==0){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_plantel")) {

 $insertSQL = sprintf("INSERT INTO jos_cdc_planestudio_estudiante (id, alumno_id, planestudio_id) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['planestudio_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());


  $insertGoTo = "cargar_certificacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}
}
//FIN CONSULTA

// INSERTAR CALIFICACIONES DEL ANIOS

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_anio1")) {

$total2=$_POST["totalmates1"];

$i = 0;
do { 
   $i++;

if ($_POST['valor1']==1){
if($_POST['tipo_eva'.$i]==!NULL){

$tipo_eva=$_POST['tipo_eva'.$i];
$fecha_mes=$_POST['fecha_mes'.$i];
$fecha_anio=$_POST['fecha_anio'.$i];
$plantelcurso_no=$_POST['plantelcurso_no'.$i];
}else{
$tipo_eva=$_POST['tipo_eva_t'];
$fecha_mes=$_POST['fecha_mes_t'];
$fecha_anio=$_POST['fecha_anio_t'];
$plantelcurso_no=$_POST['plantelcurso_no_t'];
}

}else {
$tipo_eva=$_POST['tipo_eva'.$i];
$fecha_mes=$_POST['fecha_mes'.$i];
$fecha_anio=$_POST['fecha_anio'.$i];
$plantelcurso_no=$_POST['plantelcurso_no'.$i];
} //FIN CICLO VALOR


  $insertSQL = sprintf("INSERT INTO jos_cdc_pensum (id, alumno_id, asignatura_id, def, tipo_eva, fecha_mes, fecha_anio, plantelcurso_no) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                       GetSQLValueString($_POST['def'.$i], "int"),
                       GetSQLValueString($tipo_eva, "text"),
                       GetSQLValueString($fecha_mes, "text"),
                       GetSQLValueString($fecha_anio, "int"),
                       GetSQLValueString($plantelcurso_no, "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());


} while ($i+1 <= $total2 );
 
  $insertGoTo = "cargar_certificacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}

//FIN CONSULTA



// INSERTAR CALIFICACIONES DE EPT


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_ept")) {

$total2=$_POST["totalept"];

$i = 0;
do { 
   $i++;


if($_POST['asignatura_ept_id'.$i]==!NULL){

 
  $insertSQL = sprintf("INSERT INTO jos_cdc_ept_cursadas (id, alumno_id, planestudio_id, asignatura_ept_id, horas_clase, no_orden) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['planestudio_id'], "int"),
                       GetSQLValueString($_POST['asignatura_ept_id'.$i], "int"),
                       GetSQLValueString($_POST['horas_clase'.$i], "text"),
                       GetSQLValueString($_POST['no_orden'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

} while ($i+1 <= $total2 );
 
  $insertGoTo = "cargar_certificacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}

//FIN CONSULTA

// INSERTAR OBSERVACIONES


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_observacion")) {

$total2=$_POST["totalept"];


if($_POST['observacion']==!NULL){

 
  $insertSQL = sprintf("INSERT INTO jos_cdc_observaciones (id, alumno_id, planestudio_id, observacion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['planestudio_id'], "int"),
                       GetSQLValueString($_POST['observacion'], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

 
  $insertGoTo = "cargar_certificacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}

//FIN CONSULTA



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<!-- Attach our CSS -->
		<link rel="stylesheet" href="../../css/jNotify.jquery.css">	
	  
<link rel="stylesheet" href="../../jquery/styles/nyroModal.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../../jquery/js/jquery.nyroModal.custom.js"></script>

	  	<link rel="stylesheet" href="../../modal/reveal.css">	
	  	
		<!-- Attach necessary scripts -->
		<!-- <script type="text/javascript" src="jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script> -->
		<script type="text/javascript" src="../../modal/jquery.reveal.js"></script>

<script type="text/javascript">
$(function() {
  $('.nyroModal').nyroModal();
});
</script> 
	

<?php // SCRIPT PARA BLOQUEAR EL ENTER 
?>
<script>
function disableEnterKey(e){
var key;
if(window.event){
key = window.event.keyCode; //IE
}else{
key = e.which; //firefox
}
if(key==13){
return false;
}else{
return true;
}
}
</script>

<script language="JavaScript">
function plantel()
{
window.open("cdc_modificar_plantel.php?&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY'];?>&9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>",null,"height=600,width=800,status=yes,toolbar=no,menubar=no,location =no");

}
</script>


</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>


<?php if ($totalRows_alumno>0){ // VER EXISTENCIA DE ESTUDIANTE
?>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top" align="right">

<h1><img src="../../images/pngnew/icono_navegacion.gif" border="0" align="absmiddle">&nbsp;&nbsp;<u >CARGAR CERTIFICACION DE CALIFICACIONES</u></h1>	
	
	</td></tr>

<tr><td>


<div>
<h2><img src="../../images/pngnew/busqueda-de-los-usuarios-del-hombre-icono-6234-48.png" border="0" align="absmiddle">&nbsp;&nbsp;Datos del Estudiante</h2>
<i>Nombre y Apellido:</i> <b><?php echo $row_alumno['nombre_alumno']. " ".$row_alumno['apellido_alumno']; ?></b><br />
<i>C&eacute;dula:</i> <b><?php echo $row_alumno['indicador_nacionalidad']. "-".$row_alumno['cedula']; ?></b><br />
<i>Fecha de Nacimiento:</i> <b><?php echo $row_alumno['fecha_nacimiento']; ?></b><br />
<i>Lugar de Nacimiento:</i> <b><?php echo $row_alumno['lugar_nacimiento']; ?></b><br />
<i>Ent. Federal o Pa&iacute;:</i> <b><?php echo $row_alumno['ent_federal_pais']; ?></b><br />
<hr>
</div>

<div>
<h2><img src="../../images/png/home-big.png" border="0" width="50" height="50" align="absmiddle">&nbsp;&nbsp;Planteles donde Curs&oacute; Estudios</h2>

<?php if(($totalRows_plantelcurso==0)) { ?>

<form action="<?php echo $editFormAction; ?>" name="form_plantel" id="form_plantel" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
<table>
<tr height="25" bgcolor="green">
	<td align="center" width="50"style="font-size:12px; color:#fff;">No.</td>
	<td align="center" width="300" style="font-size:12px; color:#fff;">Nombre del Plantel</td>
	<td align="center"width="100" style="font-size:12px; color:#fff;">Localidad</td>
	<td align="center" width="50" style="font-size:12px; color:#fff;">E.F.</td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $i; ?></td>
   <td align="center">
 <?php if ($i==1){  ?>
	<input type="hidden" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $i;?>">
	<select name="<?php echo 'nombre_plantel_id'.$i;?>" id="<?php echo 'nombre_plantel_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_plantel['id']; ?>"><?php echo $row_plantel['nombre_plantel']; ?></option>
	<?php } while ($row_plantel = mysql_fetch_assoc($plantel)); ?>
	</select>
 <?php }  ?>
 <?php if ($i==2) { ?>
	<input type="hidden" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $i;?>">
	<select name="<?php echo 'nombre_plantel_id'.$i;?>" id="<?php echo 'nombre_plantel_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_plantel_dos['id']; ?>"><?php echo $row_plantel_dos['nombre_plantel']; ?></option>
	<?php } while ($row_plantel_dos = mysql_fetch_assoc($plantel_dos)); ?>
	</select>
 <?php } ?>
 <?php if ($i==3) { ?>
	<input type="hidden" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $i;?>">
	<select name="<?php echo 'nombre_plantel_id'.$i;?>" id="<?php echo 'nombre_plantel_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_plantel_tres['id']; ?>"><?php echo $row_plantel_tres['nombre_plantel']; ?></option>
	<?php } while ($row_plantel_tres = mysql_fetch_assoc($plantel_tres)); ?>
	</select>
 <?php } ?>
 <?php if ($i==4) { ?>
	<input type="hidden" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $i;?>">
	<select name="<?php echo 'nombre_plantel_id'.$i;?>" id="<?php echo 'nombre_plantel_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>


	<option value="<?php echo $row_plantel_cuatro['id']; ?>"><?php echo $row_plantel_cuatro['nombre_plantel']; ?></option>
	<?php } while ($row_plantel_cuatro = mysql_fetch_assoc($plantel_cuatro)); ?>
	</select>
 <?php } ?>
 <?php if ($i==5) { ?>
	<input type="hidden" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $i;?>">
	<select name="<?php echo 'nombre_plantel_id'.$i;?>" id="<?php echo 'nombre_plantel_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_plantel_cinco['id']; ?>"><?php echo $row_plantel_cinco['nombre_plantel']; ?></option>
	<?php } while ($row_plantel_cinco = mysql_fetch_assoc($plantel_cinco)); ?>
	</select>
 <?php } ?>


   </td>
   <td align="center">
	   

 <?php if ($i==1) { ?>
	<select name="<?php echo 'localidad_id'.$i;?>" id="<?php echo 'localidad_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_local1['id']; ?>"><?php echo $row_local1['localidad']; ?></option>
	<?php } while ($row_local1 = mysql_fetch_assoc($local1)); ?>
	</select>
 <?php } ?>
 <?php if ($i==2) { ?>
	<select name="<?php echo 'localidad_id'.$i;?>" id="<?php echo 'localidad_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_local2['id']; ?>"><?php echo $row_local2['localidad']; ?></option>
	<?php } while ($row_local2 = mysql_fetch_assoc($local2)); ?>
	</select>
 <?php } ?>
 <?php if ($i==3) { ?>
	<select name="<?php echo 'localidad_id'.$i;?>" id="<?php echo 'localidad_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_local3['id']; ?>"><?php echo $row_local3['localidad']; ?></option>
	<?php } while ($row_local3 = mysql_fetch_assoc($local3)); ?>
	</select>
 <?php } ?>
 <?php if ($i==4) { ?>
	<select name="<?php echo 'localidad_id'.$i;?>" id="<?php echo 'localidad_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_local4['id']; ?>"><?php echo $row_local4['localidad']; ?></option>
	<?php } while ($row_local4 = mysql_fetch_assoc($local4)); ?>
	</select>
 <?php } ?>
 <?php if ($i==5) { ?>
	<select name="<?php echo 'localidad_id'.$i;?>" id="<?php echo 'localidad_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_local5['id']; ?>"><?php echo $row_local5['localidad']; ?></option>
	<?php } while ($row_local5 = mysql_fetch_assoc($local5)); ?>
	</select>
 <?php } ?>

   </td>
   <td align="center">
	   <input type="text" size="4" name="<?php echo 'ef'.$i;?>" value=""/>
   </td>

</tr>
<input type="hidden" name="<?php echo 'id'.$i;?>" id="<?php echo 'id'.$i;?>" value=""></td>

<?php  $i++;
} while($i<=5); ?>
</table>
<input type="hidden" name="alumno_id" id="alumno_id" value="<?php echo $row_alumno['id'];?>"/>
<input type="hidden" name="planestudio_id" id="planestudio_id" value="<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>"/>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Planteles" style="font-size:16px;"/>
<br />
		<input type="hidden" name="totalalum"  id="totalalum" value="5" >
		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="planestudio_id" value="<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>">
		<input type="hidden" name="MM_insert" value="form_plantel">

</form>  	

<?php } else { ?>
<a href="" data-reveal-id="myModal"> <img src="../../images/icons/nuevo.png" border="0" align="absmiddle">Cargar Nuevo Plantel a Estudiante</a>
		<div id="myModal" class="reveal-modal">
			<h1>Agregar Nuevo Plantel</h1>

<form action="<?php echo $editFormAction; ?>" name="form_plantel" id="form_plantel" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
<table>
<tr>
<td align="right">Nombre del Plantel: </td>
<td>
	<select name="<?php echo 'nombre_plantel_id'.'1';?>" id="<?php echo 'nombre_plantel_id'.'1';?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_plantel['id']; ?>"><?php echo $row_plantel['nombre_plantel']; ?></option>
	<?php } while ($row_plantel = mysql_fetch_assoc($plantel)); ?>
	</select>
</td>
</tr><tr>
<td align="right">Localidad: </td>
<td>
	<select name="<?php echo 'localidad_id'.'1';?>" id="<?php echo 'localidad_id'.'1';?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_local1['id']; ?>"><?php echo $row_local1['localidad']; ?></option>
	<?php } while ($row_local1 = mysql_fetch_assoc($local1)); ?>
	</select>
</td>
</tr><tr>
<td align="right">Entidad Federal: </td>
<td><input type="text" size="4" name="<?php echo 'ef'.'1';?>" value=""/></td>
</tr><tr>
<td align="right">No. Plantel: </td>
<td><input type="text" size="4" name="<?php echo 'no'.'1';?>" value=""/></td>
</tr>
</table>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Planteles" style="font-size:16px;"/>
		<input type="hidden" name="totalalum"  id="totalalum" value="1" >
		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="planestudio_id" value="<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>">
		<input type="hidden" name="MM_insert" value="form_plantel">
			</form>
		</div>
<br />
<table>
<tr style="background-color:#BEF781;">
<td align="center"><b>No.</b></td>
<td align="center"><b>Nombre del Plantel</b></td>
<td align="center"><b>Localidad</b></td>
<td align="center"><b>E.F</b></td>
<td align="center"><b>Acciones</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
<td>&nbsp;&nbsp;<?php echo $row_plantelcurso['no']; ?>&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;<?php echo $row_plantelcurso['nombre_plantel']; ?>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;<?php echo $row_plantelcurso['localidad']; ?>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;<?php echo $row_plantelcurso['ef']; ?>&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;<a href="cdc_modificar_plantel.php?id=<?php echo $row_plantelcurso['id']; ?>" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png" width="15" height="15" border="0" align="absmiddle"></a>&nbsp;<a href="cdc_eliminar_plantel.php?id=<?php echo $row_plantelcurso['id']; ?>&9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY'];?>"><img src="../../images/png/cancel_f2.png" width="15" height="15" border="0" align="absmiddle"></a>&nbsp;&nbsp;</td>


</tr>
</tr>
<?php  $i++;
} while ($row_plantelcurso = mysql_fetch_assoc($plantelcurso)); ?>
</table>
<br />

<?php } ?>

<hr>
</div>

<div>
<h2><img src="../../images/pngnew/certificado.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;Pensum de Estudio</h2>

<div style="margin-top:20px;"  >
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">
<p align="center">"NOTA: Para las asignaturas con la caracteristica de PENDIENTE usar 99 como Definitiva, CURSANDO usar 98 y EXONARADO usar 97" <br /></p>
</div>
</div>
<br />

<?php //ANIO #1
if ($totalRows_notas_plan1==0){
if ($totalRows_alumno_plan1>0){ ?>
<form action="<?php echo $editFormAction; ?>" name="form_anio1" id="form_anio1" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
<table><tr>
<td><b>Seleccionar datos com&uacute;nes:</b> <input type="checkbox" name="valor1" id="valor1" value="1" /></td>
<td>Tipo Evaluaci&oacute;n:</td>
<td>
	<select name="tipo_eva_t">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>  
	<option value="Q">Q</option> 
	<option value="*">*</option>
	</select>
</td>
<td>Mes:</td>
<td>
	<select name="fecha_mes_t">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
</td>
<td>A&ntilde;o:</td>
<td>
	<select name="fecha_anio_t">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
<td>No. Plantel:</td>
<td>
	<select name="plantelcurso_no_t">
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
</tr>
</table>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_alumno_plan1['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_alumno_plan1['nombre_asignatura'];?><input type="hidden" name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_alumno_plan1['mate'];?>"/></td>
   <td align="center"><input type="text" size="4" maxlength="2" name="<?php echo 'def'.$i;?>" id="<?php echo 'def'.$i;?>" value="<?php if(($i==$totalRows_alumno_plan1) and ($row_alumno_notaexiste1['m14']!='')){ echo $row_alumno_notaexiste1['m14'];}else { echo $row_alumno_notaexiste1['m'.$i];} ?>"/></td>
   <td align="center">
	<select name="<?php echo 'tipo_eva'.$i;?>">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
	<option value="Q">Q</option> 
	<option value="*">*</option>
	</select>
   </td>

   <td align="center">
	<select name="<?php echo 'fecha_mes'.$i;?>">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
   </td>
   <td align="center">	

	<select name="<?php echo 'fecha_anio'.$i;?>">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
 <td align="center">
	<select name="<?php echo 'plantelcurso_no'.$i;?>">
	<option value="">**</option>
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
	
		<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
		<input type="hidden" name="totalmates1"  id="totalmates1" value="<?php echo $totalRows_alumno_plan1; ?>" >

</tr>

<?php  $i++;  } while ($row_alumno_plan1 = mysql_fetch_assoc($alumno_plan1)); ?>
</table>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Calificaciones a&ntilde;o #1" style="font-size:16px;"/>
<br />
<hr>

		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="MM_insert" value="form_anio1">
</form>

<?php } // FIN ANIO 1 sin no hay notas
}else{ // inicio de modificacion de notas
?>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_notas_plan1['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar

        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_notas_plan1['nombre_asignatura'];?></td>
   <td align="center"><?php echo $row_notas_plan1['def'];?></td>
   <td align="center"><?php echo $row_notas_plan1['tipo_eva'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan1['fecha_mes'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan1['fecha_anio'];?></td>
</td>
 <td align="center"><?php echo $row_notas_plan1['plantelcurso_no'];?></td>
</td>



</tr>
<?php } while ($row_notas_plan1 = mysql_fetch_assoc($notas_plan1)); ?>
</table>
<br />
<a href="cdc_modificar_notas.php?9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7']; ?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY']; ?>&anio=1" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR/AGREGAR CALIFICACIONES PARA ESTE A&Ntilde;O</a>

<?php }// fin de ANIO #1 
?>
<hr>
<?php //ANIO #2
if ($totalRows_notas_plan2==0){
if ($totalRows_alumno_plan2>0){ ?>
<form action="<?php echo $editFormAction; ?>" name="form_anio2" id="form_anio2" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table><tr>
<td><b>Seleccionar datos com&uacute;nes:</b> <input type="checkbox" name="valor1" id="valor1" value="1" /></td>
<td>Tipo Evaluaci&oacute;n:</td>
<td>
	<select name="tipo_eva_t">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
   <option value="Q">Q</option>	
	<option value="*">*</option>
	</select>
</td>
<td>Mes:</td>
<td>
	<select name="fecha_mes_t">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
</td>
<td>A&ntilde;o:</td>
<td>
	<select name="fecha_anio_t">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
<td>No. Plantel:</td>
<td>
	<select name="plantelcurso_no_t">
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
</tr>
</table>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_alumno_plan2['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_alumno_plan2['nombre_asignatura'];?><input type="hidden" name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_alumno_plan2['mate'];?>"/></td>
   <td align="center"><input type="text" size="4" maxlength="2" name="<?php echo 'def'.$i;?>" value="<?php if(($i==$totalRows_alumno_plan2) and ($row_alumno_notaexiste2['m14']!='')){ echo $row_alumno_notaexiste2['m14'];}else { echo $row_alumno_notaexiste2['m'.$i];} ?>"/></td>
   <td align="center">
	<select name="<?php echo 'tipo_eva'.$i;?>">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option> 
	<option value="Q">Q</option>
	<option value="*">*</option>
	</select>
   </td>
   <td align="center">
	<select name="<?php echo 'fecha_mes'.$i;?>">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
   </td>
   <td align="center">	
   
   <select name="<?php echo 'fecha_anio'.$i;?>">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>

</td>
 <td align="center">
	<select name="<?php echo 'plantelcurso_no'.$i; $no=1;?>">
	<option value="">**</option>
	<?php
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>


		<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
		<input type="hidden" name="totalmates1"  id="totalmates1" value="<?php echo $totalRows_alumno_plan2; ?>" >

</tr>

<?php  $i++; } while ($row_alumno_plan2 = mysql_fetch_assoc($alumno_plan2)); ?>
</table>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Calificaciones a&ntilde;o #2" style="font-size:16px;"/>
<br />
<hr>


		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="MM_insert" value="form_anio1">

</form>

<?php } // FIN ANIO 2 sin no hay notas
}else{ // inicio de modificacion de notas
?>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_notas_plan2['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar

        echo 'fffccc';
    } ?>"  height="25">
<td align="center"><?php echo $row_notas_plan2['nombre_asignatura'];?></td>
   <td align="center"><?php echo $row_notas_plan2['def'];?></td>
   <td align="center"><?php echo $row_notas_plan2['tipo_eva'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan2['fecha_mes'];?></td>

   </td>
   <td align="center"><?php echo $row_notas_plan2['fecha_anio'];?></td>
</td>
 <td align="center"><?php echo $row_notas_plan2['plantelcurso_no'];?></td>
</td>



</tr>
<?php } while ($row_notas_plan2 = mysql_fetch_assoc($notas_plan2)); ?>
</table>
<br />
<a href="cdc_modificar_notas.php?9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7']; ?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY']; ?>&anio=2" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR/AGREGAR CALIFICACIONES PARA ESTE A&Ntilde;O</a>

<?php }// fin de ANIO #2 
?>
<hr>
<?php //ANIO #3
if ($totalRows_notas_plan3==0){
if ($totalRows_alumno_plan3>0){ ?>
<form action="<?php echo $editFormAction; ?>" name="form_anio3" id="form_anio3" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
<table><tr>
<td><b>Seleccionar datos com&uacute;nes:</b> <input type="checkbox" name="valor1" id="valor1" value="1" /></td>
<td>Tipo Evaluaci&oacute;n:</td>
<td>
	<select name="tipo_eva_t">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option> 
	<option value="Q">Q</option> 
	<option value="*">*</option>
	</select>
</td>
<td>Mes:</td>
<td>
	<select name="fecha_mes_t">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
</td>
<td>A&ntilde;o:</td>
<td>
	<select name="fecha_anio_t">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
<td>No. Plantel:</td>
<td>
	<select name="plantelcurso_no_t">
	<option value="">**</option>
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
</tr>
</table>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_alumno_plan3['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_alumno_plan3['nombre_asignatura'];?><input type="hidden" name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_alumno_plan3['mate'];?>"/></td>
   <td align="center"><input type="text" size="4"  maxlength="2" name="<?php echo 'def'.$i;?>" value="<?php if(($i==$totalRows_alumno_plan3) and ($row_alumno_notaexiste3['m14']!='')){ echo $row_alumno_notaexiste3['m14'];}else { echo $row_alumno_notaexiste3['m'.$i];} ?>"/></td>
   <td align="center">
	<select name="<?php echo 'tipo_eva'.$i;?>">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
	<option value="Q">Q</option>  
	<option value="*">*</option>
	</select>
   </td>
   <td align="center">
	<select name="<?php echo 'fecha_mes'.$i;?>">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
   </td>
   <td align="center">	
<select name="<?php echo 'fecha_anio'.$i;?>">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
 <td align="center">
	<select name="<?php echo 'plantelcurso_no'.$i; $no=1;?>">
	<option value="">**</option>
	<?php
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>


		<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
		<input type="hidden" name="totalmates1"  id="totalmates1" value="<?php echo $totalRows_alumno_plan3; ?>" >

</tr>

<?php  $i++; } while ($row_alumno_plan3 = mysql_fetch_assoc($alumno_plan3)); ?>
</table>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Calificaciones a&ntilde;o #3" style="font-size:16px;"/>
<br />


		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="MM_insert" value="form_anio1">

</form>
<?php } // FIN ANIO 3 sin no hay notas
}else{ // inicio de modificacion de notas
?>

<table>

<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_notas_plan3['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>

	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>

	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar

        echo 'fffccc';
    } ?>"  height="25">
  <td align="center"><?php echo $row_notas_plan3['nombre_asignatura'];?></td>
   <td align="center"><?php echo $row_notas_plan3['def'];?></td>
   <td align="center"><?php echo $row_notas_plan3['tipo_eva'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan3['fecha_mes'];?></td>

   </td>
   <td align="center"><?php echo $row_notas_plan3['fecha_anio'];?></td>
</td>
 <td align="center"><?php echo $row_notas_plan3['plantelcurso_no'];?></td>
</td>



</tr>
<?php } while ($row_notas_plan3 = mysql_fetch_assoc($notas_plan3)); ?>
</table>
<br />
<a href="cdc_modificar_notas.php?9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7']; ?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY']; ?>&anio=3" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR/AGREGAR CALIFICACIONES PARA ESTE A&Ntilde;O</a>

<?php }// fin de ANIO #3 
?>

<?php //ANIO #4
if ($totalRows_notas_plan4==0){
if ($totalRows_alumno_plan4>0){ ?>
<form action="<?php echo $editFormAction; ?>" name="form_anio4" id="form_anio4" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table><tr>
<td><b>Seleccionar datos com&uacute;nes:</b> <input type="checkbox" name="valor1" id="valor1" value="1" /></td>
<td>Tipo Evaluaci&oacute;n:</td>
<td>
	<select name="tipo_eva_t">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
	<option value="Q">Q</option>  
	<option value="*">*</option>
	</select>
</td>
<td>Mes:</td>
<td>
	<select name="fecha_mes_t">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
</td>
<td>A&ntilde;o:</td>
<td>
	<select name="fecha_anio_t">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
<td>No. Plantel:</td>
<td>
	<select name="plantelcurso_no_t">
	<option value="">**</option>
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
</tr>
</table>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_alumno_plan4['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_alumno_plan4['nombre_asignatura'];?><input type="hidden" name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_alumno_plan4['mate'];?>"/></td>
   <td align="center"><input type="text" size="4"  maxlength="2" name="<?php echo 'def'.$i;?>" value="<?php if(($i==$totalRows_alumno_plan4) and ($row_alumno_notaexiste4['m14']!='')){ echo $row_alumno_notaexiste4['m14'];}else { echo $row_alumno_notaexiste4['m'.$i];} ?>"/></td>
   <td align="center">
	<select name="<?php echo 'tipo_eva'.$i;?>">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
	<option value="Q">Q</option>  
	<option value="*">*</option>
	</select>
   </td>
   <td align="center">
	<select name="<?php echo 'fecha_mes'.$i;?>">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
   </td>
   <td align="center">	

	<select name="<?php echo 'fecha_anio'.$i;?>">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
 <td align="center">
	<select name="<?php echo 'plantelcurso_no'.$i; $no=1;?>">
	<option value="">**</option>
	<?php
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>


		<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
		<input type="hidden" name="totalmates1"  id="totalmates1" value="<?php echo $totalRows_alumno_plan4; ?>" >

</tr>

<?php  $i++; } while ($row_alumno_plan4 = mysql_fetch_assoc($alumno_plan4)); ?>
</table>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Calificaciones a&ntilde;o #4" style="font-size:16px;"/>
<br />
<hr>


		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="MM_insert" value="form_anio1">

</form>

<?php } // FIN ANIO 4 sin no hay notas
}else{ // inicio de modificacion de notas
?>

<table>

<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_notas_plan4['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>

	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>

	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar

        echo 'fffccc';
    } ?>"  height="25">
<td align="center"><?php echo $row_notas_plan4['nombre_asignatura'];?></td>
   <td align="center"><?php echo $row_notas_plan4['def'];?></td>
   <td align="center"><?php echo $row_notas_plan4['tipo_eva'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan4['fecha_mes'];?></td>

   </td>
   <td align="center"><?php echo $row_notas_plan4['fecha_anio'];?></td>
</td>
 <td align="center"><?php echo $row_notas_plan4['plantelcurso_no'];?></td>
</td>



</tr>
<?php } while ($row_notas_plan4 = mysql_fetch_assoc($notas_plan4)); ?>
</table>
<br />
<a href="cdc_modificar_notas.php?9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7']; ?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY']; ?>&anio=4" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR/AGREGAR CALIFICACIONES PARA ESTE A&Ntilde;O</a>

<hr>
<?php }// fin de ANIO #4 
?>

<?php //ANIO #5
if ($totalRows_notas_plan5==0){
if ($totalRows_alumno_plan5>0){ ?>
<form action="<?php echo $editFormAction; ?>" name="form_anio5" id="form_anio5" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table><tr>
<td><b>Seleccionar datos com&uacute;nes:</b> <input type="checkbox" name="valor1" id="valor1" value="1" /></td>
<td>Tipo Evaluaci&oacute;n:</td>
<td>
	<select name="tipo_eva_t">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>  
   <option value="Q">Q</option>	
	<option value="*">*</option>
	</select>
</td>
<td>Mes:</td>
<td>
	<select name="fecha_mes_t">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
</td>
<td>A&ntilde;o:</td>
<td>
	<select name="fecha_anio_t">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
<td>No. Plantel:</td>
<td>
	<select name="plantelcurso_no_t">
	<option value="">**</option>
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
</tr>
</table>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_alumno_plan5['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_alumno_plan5['nombre_asignatura'];?><input type="hidden" name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_alumno_plan5['mate'];?>"/></td>
   <td align="center"><input type="text" size="4"  maxlength="2" name="<?php echo 'def'.$i;?>" value="<?php if(($i==$totalRows_alumno_plan5) and ($row_alumno_notaexiste5['m14']!='')){ echo $row_alumno_notaexiste5['m14'];}else { echo $row_alumno_notaexiste5['m'.$i];} ?>"/></td>
   <td align="center">
	<select name="<?php echo 'tipo_eva'.$i;?>">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
	<option value="Q">Q</option>  
	<option value="*">*</option>
	</select>
   </td>
   <td align="center">
	<select name="<?php echo 'fecha_mes'.$i;?>">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
   </td>
   <td align="center">	

	<select name="<?php echo 'fecha_anio'.$i;?>">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
 <td align="center">
	<select name="<?php echo 'plantelcurso_no'.$i; $no=1;?>">
	<option value="">**</option>
	<?php
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>



		<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
		<input type="hidden" name="totalmates1"  id="totalmates1" value="<?php echo $totalRows_alumno_plan5; ?>" >

</tr>

<?php  $i++; } while ($row_alumno_plan5 = mysql_fetch_assoc($alumno_plan5)); ?>
</table>
 
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Calificaciones a&ntilde;o #5" style="font-size:16px;"/>
<br />
<hr>


		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="MM_insert" value="form_anio1">

</form>

<?php } // FIN ANIO 5 sin no hay notas
}else{ // inicio de modificacion de notas
?>

<table>

<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_notas_plan5['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>

	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>

	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar

        echo 'fffccc';
    } ?>"  height="25">
<td align="center"><?php echo $row_notas_plan5['nombre_asignatura'];?></td>
   <td align="center"><?php echo $row_notas_plan5['def'];?></td>
   <td align="center"><?php echo $row_notas_plan5['tipo_eva'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan5['fecha_mes'];?></td>

   </td>
   <td align="center"><?php echo $row_notas_plan5['fecha_anio'];?></td>
</td>
 <td align="center"><?php echo $row_notas_plan5['plantelcurso_no'];?></td>
</td>



</tr>
<?php } while ($row_notas_plan5 = mysql_fetch_assoc($notas_plan5)); ?>
</table>
<br />
<a href="cdc_modificar_notas.php?9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7']; ?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY']; ?>&anio=5" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR/AGREGAR CALIFICACIONES PARA ESTE A&Ntilde;O</a>

<hr>
<?php }// fin de ANIO #5 
?>


<?php //ANIO #6
if ($totalRows_notas_plan6==0){
if ($totalRows_alumno_plan6>0){ ?>
<form action="<?php echo $editFormAction; ?>" name="form_anio6" id="form_anio6" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table><tr>
<td><b>Seleccionar datos com&uacute;nes:</b> <input type="checkbox" name="valor1" id="valor1" value="1" /></td>
<td>Tipo Evaluaci&oacute;n:</td>
<td>
	<select name="tipo_eva_t">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option>
	<option value="Q">Q</option>  
	<option value="*">*</option>
	</select>
</td>
<td>Mes:</td>
<td>
	<select name="fecha_mes_t">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
</td>
<td>A&ntilde;o:</td>
<td>
	<select name="fecha_anio_t">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
<td>No. Plantel:</td>
<td>
	<select name="plantelcurso_no_t">
	<option value="">**</option>
	<?php  $no=1;
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>
</tr>
</table>

<table>
<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_alumno_plan6['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>
	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>
	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
   <td align="center"><?php echo $row_alumno_plan6['nombre_asignatura'];?><input type="hidden" name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_alumno_plan6['mate'];?>"/></td>
   <td align="center"><input type="text" size="4"  maxlength="2" name="<?php echo 'def'.$i;?>" value="<?php if(($i==$totalRows_alumno_plan6) and ($row_alumno_notaexiste6['m14']!='')){ echo $row_alumno_notaexiste6['m14'];}else { echo $row_alumno_notaexiste6['m'.$i];} ?>"/></td>
   <td align="center">
	<select name="<?php echo 'tipo_eva'.$i;?>">
	<option value="">**</option>
	<option value="F">F</option>
	<option value="R">R</option>
	<option value="P">P</option>
	<option value="T">T</option>
	<option value="M">M</option>
	<option value="E">E</option> 
	<option value="Q">Q</option> 
	<option value="*">*</option>
	</select>
   </td>
   <td align="center">
	<select name="<?php echo 'fecha_mes'.$i;?>">
	<option value="">**</option>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	</select>
   </td>
   <td align="center">	

	<select name="<?php echo 'fecha_anio'.$i;?>">
	<option value="">**</option>
	<?php  $fec=date(Y);
	do { ?>
	<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
	<?php  $fec=$fec-1;
	} while($fec>=1950); ?>
	</select>
</td>
 <td align="center">
	<select name="<?php echo 'plantelcurso_no'.$i; $no=1;?>">
	<option value="">**</option>
	<?php
	do { ?>
	<option value="<?php echo $no;?>"><?php echo $no;?></option>
	<?php  $no=$no+1;
	} while($no<=5); ?>
	</select>
</td>


		<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
		<input type="hidden" name="totalmates1"  id="totalmates1" value="<?php echo $totalRows_alumno_plan6; ?>" >

</tr>

<?php  $i++;} while ($row_alumno_plan6 = mysql_fetch_assoc($alumno_plan6)); ?>
</table>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Calificaciones a&ntilde;o #6" style="font-size:16px;"/>
<br />
<hr>


		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="MM_insert" value="form_anio1">

</form>

<?php } // FIN ANIO 6 sin no hay notas
}else{ // inicio de modificacion de notas
?>

<table>

<tr height="25" bgcolor="green">

	<td  align="center" style="color:#fff;">A&ntilde;o o Grado: <b><?php echo $row_notas_plan6['nombre_anio'];?></b></td>
	<td  align="center" style="color:#fff;">Calificaci&oacute;n</td>

	<td  align="center" rowspan="2" width="50" style="color:#fff;">T-E</td>
	<td  align="center" colspan="2" style="color:#fff;">Fecha</td>
	<td></td>
</tr>
<tr>

	

	<td align="center" width="300" style="font-size:12px;"><b>Asignaturas</b></td>
	<td align="center"width="50" style="font-size:12px; "><b>En No.</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>Mes</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>A&ntilde;o</b></td>
	<td align="center" width="50" style="font-size:12px; "><b>No.</b></td>
</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar

        echo 'fffccc';
    } ?>"  height="25">
<td align="center"><?php echo $row_notas_plan6['nombre_asignatura'];?></td>
   <td align="center"><?php echo $row_notas_plan6['def'];?></td>
   <td align="center"><?php echo $row_notas_plan6['tipo_eva'];?></td>
   </td>
   <td align="center"><?php echo $row_notas_plan6['fecha_mes'];?></td>

   </td>
   <td align="center"><?php echo $row_notas_plan6['fecha_anio'];?></td>
</td>
 <td align="center"><?php echo $row_notas_plan6['plantelcurso_no'];?></td>
</td>



</tr>
<?php } while ($row_notas_plan6 = mysql_fetch_assoc($notas_plan6)); ?>
</table>
<br />
<a href="cdc_modificar_notas.php?9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7']; ?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY']; ?>&anio=6" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR/AGREGAR CALIFICACIONES PARA ESTE A&Ntilde;O</a>

<?php }// fin de ANIO #6 
?>

<hr>
</div>


<div>
<h2><img src="../../images/pngnew/biblioteca-icono-3766-128.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;Programas de Educaci&oacute;n para el Trabajo</h2>

<?php if(($totalRows_eptcurso==0)) { 
// ASIGNATURAS DE EDUCACION PARA EL TRABAJO
?>
<form action="<?php echo $editFormAction; ?>" name="form_ept" id="form_ept" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table>
<tr height="25" bgcolor="green">

	<td align="center" width="300" style="font-size:12px; color:#fff;">Asignaturas EPT</td>
	<td align="center"width="100" style="font-size:12px; color:#fff;">Horas Clase</td>

</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">

   <td align="center">
	<input type="hidden" name="<?php echo 'no_orden'.$i;?>" id="<?php echo 'no_orden'.$i;?>" value="<?php echo $i;?>">

 <?php if ($i==1) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept1['id']; ?>"><?php echo $row_ept1['nombre_asignatura_ept']." / ".$row_ept1['nombre_anio']; ?></option>
	<?php } while ($row_ept1 = mysql_fetch_assoc($ept1)); ?>
	</select>
 <?php } ?>

<?php if ($i==2) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept2['id']; ?>"><?php echo $row_ept2['nombre_asignatura_ept']." / ".$row_ept2['nombre_anio']; ?></option>
	<?php } while ($row_ept2 = mysql_fetch_assoc($ept2)); ?>
	</select>
 <?php } ?>

<?php if ($i==3) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept3['id']; ?>"><?php echo $row_ept3['nombre_asignatura_ept']." / ".$row_ept3['nombre_anio']; ?></option>
	<?php } while ($row_ept3 = mysql_fetch_assoc($ept3)); ?>
	</select>
 <?php } ?>

<?php if ($i==4) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept4['id']; ?>"><?php echo $row_ept4['nombre_asignatura_ept']." / ".$row_ept4['nombre_anio']; ?></option>
	<?php } while ($row_ept4 = mysql_fetch_assoc($ept4)); ?>
	</select>
 <?php } ?>

<?php if ($i==5) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept5['id']; ?>"><?php echo $row_ept5['nombre_asignatura_ept']." / ".$row_ept5['nombre_anio']; ?></option>
	<?php } while ($row_ept5 = mysql_fetch_assoc($ept5)); ?>
	</select>
 <?php } ?>

<?php if ($i==6) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept6['id']; ?>"><?php echo $row_ept6['nombre_asignatura_ept']." / ".$row_ept6['nombre_anio']; ?></option>
	<?php } while ($row_ept6 = mysql_fetch_assoc($ept6)); ?>
	</select>
 <?php } ?>

<?php if ($i==7) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept7['id']; ?>"><?php echo $row_ept7['nombre_asignatura_ept']." / ".$row_ept7['nombre_anio']; ?></option>
	<?php } while ($row_ept7 = mysql_fetch_assoc($ept7)); ?>
	</select>
 <?php } ?>

<?php if ($i==8) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept8['id']; ?>"><?php echo $row_ept8['nombre_asignatura_ept']." / ".$row_ept8['nombre_anio']; ?></option>
	<?php } while ($row_ept8 = mysql_fetch_assoc($ept8)); ?>
	</select>
 <?php } ?>

<?php if ($i==9) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept9['id']; ?>"><?php echo $row_ept9['nombre_asignatura_ept']." / ".$row_ept9['nombre_anio']; ?></option>
	<?php } while ($row_ept9 = mysql_fetch_assoc($ept9)); ?>
	</select>
 <?php } ?>

<?php if ($i==10) { ?>
	<select name="<?php echo 'asignatura_ept_id'.$i;?>" id="<?php echo 'asignatura_ept_id'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept10['id']; ?>"><?php echo $row_ept10['nombre_asignatura_ept']." / ".$row_ept10['nombre_anio']; ?></option>
	<?php } while ($row_ept10 = mysql_fetch_assoc($ept10)); ?>
	</select>
 <?php } ?>
   </td>


 <td align="center">
	   <input type="text" size="3" name="<?php echo 'horas_clase'.$i;?>"/>
   </td>
</tr>
<?php  $i++;
} while($i<=10); ?>
</table>
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Asignaturas EPT" style="font-size:16px;"/>
<br />

		<input type="hidden" name="totalept"  id="totalept" value="10" >
		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="planestudio_id" value="<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>">
		<input type="hidden" name="MM_insert" value="form_ept">

</form>

<?php } else { //fin de ept si no existen datos
//  SI YA TIENE DATOS CARGADO DE EPT
?>
<a href="" data-reveal-id="myModal2"> <img src="../../images/icons/nuevo.png" border="0" align="absmiddle">Cargar Nueva Asignatura de EPT</a>
		<div id="myModal2" class="reveal-modal">
			<h1>Agregar Nueva Asignatura EPT</h1>

<form action="<?php echo $editFormAction; ?>" name="form_ept" id="form_ept" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
<table>
<tr>
<td align="right">Nombre de la Asignatura: </td>
<td>
	<select name="<?php echo 'asignatura_ept_id'.'1';?>" id="<?php echo 'asignatura_ept_id'.'1';?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_ept1['id']; ?>"><?php echo $row_ept1['nombre_asignatura_ept']." / ".$row_ept1['nombre_anio']; ?></option>
	<?php } while ($row_ept1 = mysql_fetch_assoc($ept1)); ?>
	</select>
</td>
</tr><tr>
<td align="right">Horas Clase: </td>
<td>
	<input type="text" size="3" name="<?php echo 'horas_clase'.'1';?>"/>
</td>
</tr><tr>
<td align="right">No. Posicion: </td>
<td><input type="text" size="4" name="<?php echo 'no_orden'.'1';?>" value=""/></td>
</tr>
</table>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Asignatura" style="font-size:16px;"/>
		<input type="hidden" name="totalept"  id="totalept" value="1" >
		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="planestudio_id" value="<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>">
		<input type="hidden" name="MM_insert" value="form_ept">
			</form>
		</div>

<br />
<table>
<tr style="background-color:#BEF781;">
<td align="center"><b>No.</b></td>
<td align="center"><b>Nombre de la Asignatura</b></td>
<td align="center"><b>Horas Clase</b></td>
<td align="center"><b>Acciones</b></td>

</tr>

<?php $i=1;
do { ?>
<tr  bgcolor="#<?php if ($i%2==0) { // si es par

         echo 'fff';
    } else { // si es impar
        echo 'fffccc';
    } ?>"  height="25">
<td>&nbsp;&nbsp;<?php echo $row_eptcurso['inicial']; ?>&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;<?php echo $row_eptcurso['nombre_asignatura_ept']; ?>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;<?php echo $row_eptcurso['horas_clase']; ?>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;<a href="cdc_modificar_ept.php?id=<?php echo $row_eptcurso['id']; ?>" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png" width="15" height="15" border="0" align="absmiddle"></a>&nbsp;<a href="cdc_eliminar_ept.php?id=<?php echo $row_eptcurso['id']; ?>&9812HHFJHJHF63883B3CNCH7=<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>&1298JJII128938367HHY=<?php echo $_GET['1298JJII128938367HHY'];?>"><img src="../../images/png/cancel_f2.png" width="15" height="15" border="0" align="absmiddle"></a>&nbsp;&nbsp;</td>
</tr>
</tr>
<?php  $i++;
} while ($row_eptcurso = mysql_fetch_assoc($eptcurso)); ?>
</table>
<br />

<?php }?>
<hr>
</div>

<div>
<h2><img src="../../images/png/chat.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;Observaciones</h2>
<i>Observaciones:</i> <br />

<?php if($totalRows_observaciones==0){ // INICIO DE LA CONSULTA
 ?>
<form action="<?php echo $editFormAction; ?>" name="form_observaciones" id="form_observaciones" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<TEXTAREA COLS=100 ROWS=10 NAME="observacion">
</TEXTAREA> 
<br />
<p>Verifica los Datos y Presiona una sola vez Click.. </p>
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Observaciones" style="font-size:16px;"/>
<br />

		<input type="hidden" name="alumno_id" value="<?php echo $row_alumno['id'];?>">
		<input type="hidden" name="planestudio_id" value="<?php echo $_GET['9812HHFJHJHF63883B3CNCH7'];?>">
		<input type="hidden" name="MM_insert" value="form_observacion">
</form>


<?php } else { // fin si no existian observaciones agregadas 
?>
<h5><i><?php echo $row_observaciones['observacion'];?></i></h5>

<br />
<a href="cdc_observacion.php?id=<?php echo $row_observaciones['id']; ?>" target="_blank" class="nyroModal"><img src="../../images/png/32px-Crystal_Clear_action_reload.png"  border="0" align="absmiddle">&nbsp;&nbsp; MODIFICAR OBSERVACIONES</a>

<?php } // FIN DE LA CONSULTA
?>
<hr>
</div>
<?php /*
<div style="text-align:right;">
<h2><img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;Acci&oacute;n del M&oacute;dulo</h2>
</div>
*/ ?>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {hint:"Ej. 13568420", validateOn:["blur"], minChars:7});

//-->
</script>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	
	<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Esta opci&oacute;n sirve para cargar las notas Certificadas<br /> de un Estudiante Regular o alg&uacute;n ex-alumno" <br /></p>
</div>
</div>
<br />
	</td></tr>


    </table>
    
    <?php } else { 

?> 

<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"No Existe un Estudiante con este No. de C&eacute;dula<br /> <br /> <strong>Cierra esta Ventana y Verif&iacute;ca el No.</strong></p>
</div>
</div>


<?php } //FIN DE LA VERIFICACION
?> 
<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>