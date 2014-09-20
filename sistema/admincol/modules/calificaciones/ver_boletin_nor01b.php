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
$query_colegio = "SELECT * FROM jos_institucion";
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

// CARGANDO DATOS TABLA
$colname_alumno = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno = $_GET['cedula'];
}
$lapso_alumno = "-1";
if (isset($_GET['lapso'])) {
  $lapso_alumno = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT b.indicador_nacionalidad, b.apellido, b.nombre, b.cedula, e.nombre as anio, f.descripcion, h.nombre_proyecto

FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b, jos_curso d, jos_anio_nombre e, jos_seccion f, jos_alumno_curso g, jos_formato_evaluacion_planilla h

WHERE a.alumno_id=b.alumno_id AND b.alumno_id=g.alumno_id AND g.curso_id=d.id AND d.seccion_id=f.id AND d.anio_id=e.id AND a.confiplanilla_id=h.id AND b.cedula = %s AND a.lapso = %s", GetSQLValueString($colname_alumno, "bigint"), GetSQLValueString($lapso_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

// NOTA DESCRIPTIVA
$colname_boletin_des = "-1";
if (isset($_GET['cedula'])) {
  $colname_boletin_des = $_GET['cedula'];
}
$lap_boletin_des = "-1";
if (isset($_GET['lapso'])) {
  $lap_boletin_des = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_boletin_des = sprintf("SELECT * FROM jos_formato_nota_descriptiva_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cedula = %s AND lapso=%s", GetSQLValueString($colname_boletin_des, "bigint"),GetSQLValueString($lap_boletin_des, "int"));
$boletin_des = mysql_query($query_boletin_des, $sistemacol) or die(mysql_error());
$row_boletin_des = mysql_fetch_assoc($boletin_des);
$totalRows_boletin_des = mysql_num_rows($boletin_des);

$colname_profe_guia = "-1";
if (isset($_GET['cedula'])) {
  $colname_profe_guia = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_profe_guia = sprintf("SELECT * FROM jos_alumno_curso a, jos_curso b, jos_docente c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.curso_id=b.id AND b.docente_id=c.id AND d.cedula = %s", GetSQLValueString($colname_profe_guia, "bigint"));
$profe_guia = mysql_query($query_profe_guia, $sistemacol) or die(mysql_error());
$row_profe_guia = mysql_fetch_assoc($profe_guia);
$totalRows_profe_guia = mysql_num_rows($profe_guia);

//CARGANDO DATOS DE ASIGNATURAS
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

//def de anio
$colname_asignatura_final = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura_final = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura_final = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura IS NULL AND a.def>0  AND d.cedula = %s GROUP BY a.alumno_id, c.nombre ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura_final, "bigint"));
$asignatura_final = mysql_query($query_asignatura_final, $sistemacol) or die(mysql_error());
$row_asignatura_final = mysql_fetch_assoc($asignatura_final);
$totalRows_asignatura_final = mysql_num_rows($asignatura_final);

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

//def de ept
$colname_mate14_final = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate14_final = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14_final = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s  GROUP BY a.alumno_id" , GetSQLValueString($colname_mate14_final, "bigint"));
$mate14_final = mysql_query($query_mate14_final, $sistemacol) or die(mysql_error());
$row_mate14_final = mysql_fetch_assoc($mate14_final);
$totalRows_mate14_final = mysql_num_rows($mate14_final);

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

//def de premilitar
$colname_mate15_final = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate15_final = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15_final = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='premilitar' AND d.cedula = %s  GROUP BY a.alumno_id" , GetSQLValueString($colname_mate15_final, "bigint"));
$mate15_final = mysql_query($query_mate15_final, $sistemacol) or die(mysql_error());
$row_mate15_final = mysql_fetch_assoc($mate15_final);
$totalRows_mate15_final = mysql_num_rows($mate15_final);

//INASISTENCIAS
$colname_inasistencia = "-1";
if (isset($_GET['cedula'])) {
  $colname_inasistencia = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inasistencia = sprintf("SELECT sum(inasistencia_alumno) as inasistencia_alumno, sum(inasistencia) as hora_clase FROM jos_alumno_asistencia a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cedula = %s", GetSQLValueString($colname_inasistencia, "bigint"));
$inasistencia = mysql_query($query_inasistencia, $sistemacol) or die(mysql_error());
$row_inasistencia = mysql_fetch_assoc($inasistencia);
$totalRows_inasistencia = mysql_num_rows($inasistencia);

// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate15 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND a.cedula = %s  GROUP BY a.alumno_id", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);

mysql_select_db($database_sistemacol, $sistemacol);
$query_posicion = sprintf("SELECT a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as defi FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id GROUP BY a.alumno_id ORDER BY defi ASC");
$posicion = mysql_query($query_posicion, $sistemacol) or die(mysql_error());
$row_posicion = mysql_fetch_assoc($posicion);
$totalRows_posicion = mysql_num_rows($posicion);

$colname_posicion_c = "-1";
if (isset($_GET['curso_id'])) {
  $colname_posicion_c = $_GET['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_posicion_c = sprintf("SELECT a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as defi FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY defi ASC", GetSQLValueString($colname_posicion_c, "int"));
$posicion_c = mysql_query($query_posicion_c, $sistemacol) or die(mysql_error());
$row_posicion_c = mysql_fetch_assoc($posicion_c);
$totalRows_posicion_c = mysql_num_rows($posicion_c);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi1 = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$confi1 = mysql_query($query_confi1, $sistemacol) or die(mysql_error());
$row_confi1 = mysql_fetch_assoc($confi1);
$totalRows_confi1 = mysql_num_rows($confi1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INTERSOFT | Software Educativo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

<style type="text/css">
body{background-image: url('../../images/logo-libros.jpg');}

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

<body>
<div id="ancho_boletin_lb">
<table border="0" align="left" class="tabla">
  <tr><td colspan="4">
  <table>
	<tr>
    <td width="429" align="left"><img src="../../images/gif/me_logo.gif" width="200" height="51" border="0"></td>
    <td width="588" align="right"><span class="texto_pequeno_gris"><strong><?php echo $row_colegio['nomcol']; ?></strong><br>
Coordinaci&oacute;n de Evaluaci&oacute;n y Control del Estudios<br>
<?php echo $row_colegio['dircol']; ?></span></td>
    <td width="92" align="left" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>
    </tr>
  <tr>
    <td colspan="3" align="center"><span class="texto_mediano_grande"><em><strong>INFORME DE ACTUACION DEL ESTUDIANTE </strong><strong></strong></em></span><em class="texto_mediano_gris"><strong>
        <?php echo $_GET['lapso']; ?> LAPSO - A&Ntilde;O ESCOLAR : <?php echo $row_confi1['descripcion'];?></strong></em></td>
  </tr>
  </table>
  </td>
  </tr>
  <tr>
    <td colspan="2" align="left">
      <table style="border:1px solid;background-color:#fff;" >
      <tr>
        <td height="20" align="left" valign="bottom" class="texto_mediano_gris" style="width:18cm"><strong>&nbsp;CEDULA:</strong> <em><?php echo $row_alumno['indicador_nacionalidad']; ?>-<?php echo $row_alumno['cedula']; ?></em>&nbsp;&nbsp;<strong>APELLIDOS Y NOMBRES:</strong> <em><?php echo $row_alumno['apellido']; ?>, <?php echo $row_alumno['nombre']; ?></em></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" class="texto_mediano_gris"><strong>&nbsp;A&Ntilde;O Y SECCION:</strong> <em><?php echo $row_alumno['anio']." ".$row_alumno['descripcion']; ?></em></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" class="texto_mediano_gris"><strong>&nbsp;DOCENTE GUIA:</strong> <em><?php echo $row_profe_guia['apellido_docente']; ?>, <?php echo $row_profe_guia['nombre_docente']; ?></em></td>
      </tr>
      <tr>
        <td align="left" class="texto_mediano_gris"><strong>&nbsp;NOMBRE DEL PROYECTO: </strong><em class="texto_mediano_grande"><?php echo $row_alumno['nombre_proyecto']; ?></em></td>
      </tr>
    </table>
      <br></td>
    <td align="center"><table class="sample" align="center" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000" class="tabla" style="width:4cm; font-size:11px;">
      <tr>
     <!--   <td colspan="2" align="center" valign="middle"><strong><span class="texto_mediano_gris">&nbsp;APRECIACION&nbsp;</span></strong></td>
        <td colspan="4" align="center" valign="middle"><strong><span class="texto_mediano_gris">&nbsp;INASISTENCIAS&nbsp;</span></strong></td>-->
        </tr>
      <tr>
        <!--<td align="center" valign="middle"><strong><span class="texto_mediano_gris">CUAL</span></strong></td>
        <td align="center" valign="middle"><strong><span class="texto_mediano_gris">CUAN</span></strong></td>-->
        <td colspan="4" align="center" valign="middle"><strong><span class="texto_mediano_gris">TOTAL</span></strong></td>
       <?php /* <td align="center" valign="middle"><strong><span class="texto_mediano_gris">%</span></strong></td> */?>
        </tr>
      <tr>
        <!--<td align="center" valign="middle">I</td>
        <td align="center" valign="middle">0-9</td>
        <td align="center" colspan="4" height="15"  valign="middle" class="texto_mediano_gris"><?php if($totalRows_inasistencia>0){echo $row_inasistencia['inasistencia_alumno'];}else{echo "0";}?></td>-->
       <?php /* <td align="center" valign="middle"><?php if($totalRows_inasistencia>0){$porcentaje=($row_inasistencia['inasistencia_alumno']*100)/$row_inasistencia['hora_clase'];
echo $porcentaje."%";}else{echo "0%";}?></td>*/?>
        </tr>
      <tr>
        <!-- <td align="center" valign="middle">P</td>
        <td align="center" valign="middle">10-13</td>-->
        <td colspan="4" align="center" valign="middle"><strong><span class="texto_mediano_gris">PROMEDIO A&Ntilde;O</span></strong></td>
        </tr>
      <tr>
        <!--<td align="center" valign="middle">A</td>
        <td align="center" valign="middle">14-17</td>-->
        <td colspan="4" rowspan="2" align="center" valign="middle"><strong><span class="texto_grande_gris"><?php echo $row_mate15['def'];?></span></strong></td>
        </tr>
      <tr>
        <!-- <td align="center" valign="middle">C</td>
        <td align="center" valign="middle">18-20</td>-->
        </tr>
        <tr>
        <td align="center" colspan="2" valign="middle"><b>Posici&oacute;n General</b></td>
         <td align="center"  valign="middle">
         <strong><span class="texto_grande_gris">


<?php $num=$totalRows_posicion; do { ?>

<?php if($row_posicion['cedula']==$_GET['cedula']){ echo $num; }?>

<?php $num=$num-1;} while ($row_posicion = mysql_fetch_assoc($posicion)); ?>
        
        </span></span></strong>
         
         </td>
        </tr>
         <tr>
        <td align="center" colspan="2" valign="middle"><b>Posici&oacute;n en la Secci&oacute;n</b></td>
        <td align="center" colspan="2"  valign="middle">
        <strong><span class="texto_grande_gris">


<?php $num=$totalRows_posicion_c; do { ?>

<?php if($row_posicion_c['cedula']==$_GET['cedula']){ echo $num; }?>

<?php $num=$num-1;} while ($row_posicion_c = mysql_fetch_assoc($posicion_c)); ?>




        
        </span></span></strong>&nbsp;
        </td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="3" align="center"><table border="0" >
      <tr>
        <td width="500"  align="left" valign="top">
        
        <table class="sample" >
			<tr>
            <?php // NOTAS DE PRIMER LAPSO
                    ?>
            <td colspan="3">
               <table class="sample2" >
              <tr>
              <td width="295" align="center"><span style="font-size:14px; "><strong>ASIGNATURAS</strong></span></td>
           <!--   <td width="50"  align="center" ><em>DEF<br />CUA</em></td>-->		
              <td width="50" align="center" ><em>DEF<br />L1</em></td>
              </tr>
            <?php do { ?>
              <tr>
                <td width="300"  height="20" align="center" ><span><?php echo $row_asignatura1['nombre']; ?>	</span></td>
             <!--   <td width="50" align="center" ><em class="texto_mediano_grande">
                   <?php if($row_asignatura1['def']==0){ echo "-"; }?> <?php if(($row_asignatura1['def']>0) and ($row_asignatura1['def']<10)){ echo "I";} if(($row_asignatura1['def']>9) and ($row_asignatura1['def']<14)){ echo "P";} if(($row_asignatura1['def']>13) and ($row_asignatura1['def']<18)){ echo "A";} if(($row_asignatura1['def']>17) and ($row_asignatura1['def']<21)){ echo "C"; }?>
                </em></td>-->
                <td width="50" align="center" ><span ><b><?php if($row_asignatura1['def']==0){ echo 'NC';}?> <?php if(($row_asignatura1['def']>0) and ($row_asignatura1['def']<10)) { echo "0".$row_asignatura1['def']; }?> <?php if($row_asignatura1['def']>9){ echo $row_asignatura1['def']; }?></b></span></td>
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


            <?php if($totalRows_asignatura2>0){
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
               
            <!--    <td width="50"align="center" ><em class="texto_mediano_grande">
                   <?php if($row_asignatura2['def']==0){ echo "-"; }?> <?php if(($row_asignatura2['def']>0) and ($row_asignatura2['def']<10)){ echo "I";} if(($row_asignatura2['def']>9) and ($row_asignatura2['def']<14)){ echo "P";} if(($row_asignatura2['def']>13) and ($row_asignatura2['def']<18)){ echo "A";} if(($row_asignatura2['def']>17) and ($row_asignatura2['def']<21)){ echo "C"; }?>
                </em></td>-->
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
    <!--     <td align="center" height="20">
                   <?php if($row_mate142['def']==0){ echo "-"; }?> <?php if(($row_mate142['def']>=1) and ($row_mate142['def']<=9)){ echo "I";} if(($row_mate142['def']>9) and ($row_mate142['def']<14)){ echo "P";} if(($row_mate142['def']>13) and ($row_mate142['def']<18)){ echo "A";} if(($row_mate142['def']>17) and ($row_mate142['def']<21)){ echo "C"; }?>
               </td>-->
	 <td align="center" height="20"><span ><b><?php if($row_mate142['def']==0){ echo 'NC';}?> <?php if(($row_mate142['def']>0) and ($row_mate142['def']<10)) { echo "0".$row_mate142['def']; }?> <?php if($row_mate142['def']>9){ echo $row_mate142['def']; }?></b></span></td>
	 </tr>
			<?php } ?>
              
               </table>

            </td>
			<?php } 
			if($totalRows_asignatura3>0){ // NOTAS DE TERCER LAPSO
			
			?>

            <td colspan="2">
                <table class="sample2">
                <tr>
			<!--		<td width="50"  align="center"><em>DEF<br />CUA</em></td>-->
               <td width="50" align="center" ><em>DEF<br />L3</em></td>                
                </tr>
            <?php do { ?>
              <tr>

                <!--<td width="50" height="20" align="center" ><em class="texto_mediano_grande">
                   <?php if($row_asignatura3['def']==0){ echo "-"; }?> <?php if(($row_asignatura3['def']>0) and ($row_asignatura3['def']<10)){ echo "I";} if(($row_asignatura3['def']>9) and ($row_asignatura3['def']<14)){ echo "P";} if(($row_asignatura3['def']>13) and ($row_asignatura3['def']<18)){ echo "A";} if(($row_asignatura3['def']>17) and ($row_asignatura3['def']<21)){ echo "C"; }?>
                </em></td>-->
                <td width="50" height="20"  align="center"><span ><b><?php if($row_asignatura3['def']==0){ echo 'NC';}?> <?php if(($row_asignatura3['def']>0) and ($row_asignatura3['def']<10)) { echo "0".$row_asignatura3['def']; }?> <?php if($row_asignatura3['def']>9){ echo $row_asignatura3['def']; }?></b></span></td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura3 = mysql_fetch_assoc($asignatura3)); ?>
              <tr>
              
  <?php //PREMILITAR TERCER LAPSO ?>
  <?php if($totalRows_mate153>0){?>
	<tr>

	 <td align="center" height="20" ><span ><b><?php if($row_mate153['def']==0){ echo 'NC';}?> <?php if(($row_mate153['def']>0) and ($row_mate153['def']<10)) { echo "0".$row_mate153['def']; }?> <?php if($row_mate153['def']>9){ echo $row_mate153['def']; }?></b></span></td>
	 </tr>
	 <?php } ?>    
	 
         <?php //EPT TERCER LAPSO ?>
 			<?php if($totalRows_mate143>0){?>
    <!--     <td align="center" height="20">
                   <?php if($row_mate143['def']==0){ echo "-"; }?> <?php if(($row_mate143['def']>=1) and ($row_mate143['def']<=9)){ echo "I";} if(($row_mate143['def']>9) and ($row_mate143['def']<14)){ echo "P";} if(($row_mate143['def']>13) and ($row_mate143['def']<18)){ echo "A";} if(($row_mate143['def']>17) and ($row_mate143['def']<21)){ echo "C"; }?>
               </td>-->
	 <td align="center" height="20" ><span ><b><?php if($row_mate143['def']==0){ echo 'NC';}?> <?php if(($row_mate143['def']>0) and ($row_mate143['def']<10)) { echo "0".$row_mate143['def']; }?> <?php if($row_mate143['def']>9){ echo $row_mate143['def']; }?></b></span></td>
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
						<td width="50"  height="20" align="center" ><em>DEF<br />A&Ntilde;O</em></td>                
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



    


         
	</tr>





          </table></td>
        <td width="300" valign="top"><table style="border:1px solid; background-color:#fff; height:200px;" style="width:10cm; margin-left:0">
          <tr>
            <td height="30" align="center" bgcolor="#CCCCCC" style="border-bottom:1px solid" class="texto_pequeno_gris"><strong class="texto_mediano_grande">DESCRIPCION DEL ESTUDIANTE</strong></td>
          </tr>
          
          <tr>
            <td class="texto_mediano_gris"><br>
              <table  style="width:11cm">
              <tr>
                <td  style="padding-left:10px;"><?php echo $row_boletin_des['descripcion']; ?></td>
              </tr>
            </table>
              <br>
              <?php if($row_boletin_des['nom_mate_pendiente']<>""){?>
              <strong>&nbsp;&nbsp;Materia Pendiente:</strong> <?php echo $row_boletin_des['nom_mate_pendiente']; ?> <strong>Calificaci&oacute;n:</strong> <?php echo $row_boletin_des['nota_mate_pendiente']; }?>
</td>
          </tr>
        </table><span style="font-family:arial; font-size:10px;">Intersoft | Software Educativo &copy; 2002-2012</span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><p>&nbsp;</p>
      <table border="0" style="width:20cm" >
      <tr>
        <td style="border-bottom:1px solid">&nbsp;</td>
        <td style="width:1cm">&nbsp;</td>
        <td style="border-bottom:1px solid">&nbsp;</td>
        <td style="width:1cm">&nbsp;</td>
      <td style="border-bottom:1px solid" width="200">&nbsp;</td>
      </tr>
      <tr class="texto_mediano_gris">
        <td align="center">DOCENTE GUIA</td>
        <td align="center">&nbsp;</td>
        <td align="center">COOR. DEPARTAMENTO DE EVALUACION</td>
      <td align="center">&nbsp;</td>
        <td align="center">DIRECTOR</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($colegio);
mysql_free_result($alumno);

mysql_free_result($boletin_des);

mysql_free_result($profe_guia);

mysql_free_result($asignatura);
mysql_free_result($asignatura1);
mysql_free_result($asignatura2);
mysql_free_result($asignatura3);
mysql_free_result($asignatura_final);
mysql_free_result($mate141);
mysql_free_result($mate142);
mysql_free_result($mate143);
mysql_free_result($mate14_final);

?>
