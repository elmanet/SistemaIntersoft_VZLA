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


mysql_select_db($database_sistemacol, $sistemacol);
$query_institucion = sprintf("SELECT * FROM jos_cdc_institucion");
$institucion = mysql_query($query_institucion, $sistemacol) or die(mysql_error());
$row_institucion = mysql_fetch_assoc($institucion);
$totalRows_institucion = mysql_num_rows($institucion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$colname_seccion = "-1";
if (isset($_POST['anio_id'])) {
  $colname_seccion = $_POST['anio_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_seccion = sprintf("SELECT * FROM jos_anio_nombre WHERE id=%s", GetSQLValueString($colname_seccion, "int"));
$seccion = mysql_query($query_seccion, $sistemacol) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);


$colname_asignaturas = "-1";
if (isset($_POST['anio_id'])) {
  $colname_asignaturas = $_POST['anio_id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignaturas = sprintf("SELECT * FROM jos_cdc_resumen_asignatura_pendiente WHERE anio_id=%s  ORDER BY numero ASC", GetSQLValueString($colname_asignaturas, "int"));
$asignaturas = mysql_query($query_asignaturas, $sistemacol) or die(mysql_error());
$row_asignaturas = mysql_fetch_assoc($asignaturas);
$totalRows_asignaturas = mysql_num_rows($asignaturas);

/*
// SELECCIONAR PLANES DE ESTUDIO
if(($row_seccion['numero_anio']==1) or ($row_seccion['numero_anio']==7)){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE cod='32011' AND actual=1");
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
}
if(($row_seccion['numero_anio']==2) or ($row_seccion['numero_anio']==8)){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE cod='32011' AND actual=1");
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
}
if(($row_seccion['numero_anio']==3) or ($row_seccion['numero_anio']==9)){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE cod='32011' AND actual=1");
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
}
if(($row_seccion['numero_anio']==4) or ($row_seccion['numero_anio']==10)){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE cod='31018' AND actual=1");
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
}
if(($row_seccion['numero_anio']==5) or ($row_seccion['numero_anio']==11)){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE cod='31018' AND actual=1");
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
}
if(($row_seccion['numero_anio']==6) or ($row_seccion['numero_anio']==12)){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE cod='31018' AND actual=1");
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
}
// FIN PLANES DE ESTUDIO
*/

if($_POST['hoja']==1){
$hojaini=1;
$hojafin=13;
}
if($_POST['hoja']==2){
$hojaini=14;
$hojafin=26;
}
if($_POST['hoja']==3){
$hojaini=27;
$hojafin=39;
}
if($_POST['hoja']==4){
$hojaini=40;
$hojafin=52;
}

// VER NOTAS


$colname_resumen = "-1";
if (isset($_POST['anio_id'])) {
  $colname_resumen = $_POST['anio_id'];
}
$tr_resumen = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen = $_POST['tipor'];
}
$tc_resumen = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen = $_POST['tipoc'];
}
$plan_resumen = "-1";
if (isset($_POST['plan_id'])) {
  $plan_resumen = $_POST['plan_id'];
}
$momento_resumen = "-1";
if (isset($_POST['momento'])) {
  $momento_resumen = $_POST['momento'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen = sprintf("SELECT b.cedula, b.indicador_nacionalidad, a.id, a.no_alumno, a.m1, a.m2, a.m3, a.m4, a.m5, a.m6, a.m7, a.m8, a.m9, a.m10, a.m11, a.m12, a.m13, a.m14, a.ept1, a.ept2, a.ept3, a.ept4, c.cod, c.plan_estudio, c.mencion FROM jos_cdc_resumen_pendiente a, jos_alumno_info b, jos_cdc_planestudio c WHERE a.alumno_id=b.alumno_id AND a.plan_id=c.id AND b.cursando=1 AND a.no_alumno>=$hojaini AND a.no_alumno<=$hojafin AND a.anio_id=%s AND tipo_resumen=%s AND tipo_cedula=%s AND a.plan_id=%s AND a.momento=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen, "int"), GetSQLValueString($tr_resumen, "int"), GetSQLValueString($tc_resumen, "int"), GetSQLValueString($plan_resumen, "int"), GetSQLValueString($momento_resumen, "int"));
$resumen = mysql_query($query_resumen, $sistemacol) or die(mysql_error());
$row_resumen = mysql_fetch_assoc($resumen);
$totalRows_resumen = mysql_num_rows($resumen);

// CONSULTA DE DOCENTES
$colname_verdocentes = "-1";
if (isset($_POST['anio_id'])) {
  $colname_verdocentes = $_POST['anio_id'];
}
$tr_verdocentes = "-1";
if (isset($_POST['tipor'])) {
  $tr_verdocentes = $_POST['tipor'];
}
$tc_verdocentes = "-1";
if (isset($_POST['tipoc'])) {
  $tc_verdocentes = $_POST['tipoc'];
}
$plan_verdocentes = "-1";
if (isset($_POST['plan_id'])) {
  $plan_verdocentes = $_POST['plan_id'];
}
$momento_verdocentes = "-1";
if (isset($_POST['momento'])) {
  $momento_verdocentes = $_POST['momento'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_verdocentes = sprintf("SELECT * FROM jos_cdc_resumen_docente WHERE curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s AND plan_id=%s AND momento=%s ORDER BY orden_mate ASC", GetSQLValueString($colname_verdocentes, "int"), GetSQLValueString($tr_verdocentes, "int"), GetSQLValueString($tc_verdocentes, "int"), GetSQLValueString($plan_verdocentes, "int"), GetSQLValueString($momento_verdocentes, "int"));
$verdocentes = mysql_query($query_verdocentes, $sistemacol) or die(mysql_error());
$row_verdocentes = mysql_fetch_assoc($verdocentes);
$totalRows_verdocentes = mysql_num_rows($verdocentes);


// CONSULTA DE MATERIAS DE EPT
//EPT1
$colname_mate_ept1 = "-1";
if (isset($_POST['anio_id'])) {
  $colname_mate_ept1 = $_POST['anio_id'];
}
$tr_mate_ept1 = "-1";
if (isset($_POST['tipor'])) {
  $tr_mate_ept1 = $_POST['tipor'];
}
$tc_mate_ept1 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_mate_ept1 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept1 = sprintf("SELECT * FROM jos_cdc_resumen_ept WHERE no=1 AND curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s ", GetSQLValueString($colname_mate_ept1, "int"), GetSQLValueString($tr_mate_ept1, "int"), GetSQLValueString($tc_mate_ept1, "int"));
$mate_ept1 = mysql_query($query_mate_ept1, $sistemacol) or die(mysql_error());
$row_mate_ept1 = mysql_fetch_assoc($mate_ept1);
$totalRows_mate_ept1 = mysql_num_rows($mate_ept1);

//EPT2
$colname_mate_ept2 = "-1";
if (isset($_POST['anio_id'])) {
  $colname_mate_ept2 = $_POST['anio_id'];
}
$tr_mate_ept2 = "-1";
if (isset($_POST['tipor'])) {
  $tr_mate_ept2 = $_POST['tipor'];
}
$tc_mate_ept2 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_mate_ept2 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept2 = sprintf("SELECT * FROM jos_cdc_resumen_ept WHERE no=2 AND curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s ", GetSQLValueString($colname_mate_ept2, "int"), GetSQLValueString($tr_mate_ept2, "int"), GetSQLValueString($tc_mate_ept2, "int"));
$mate_ept2 = mysql_query($query_mate_ept2, $sistemacol) or die(mysql_error());
$row_mate_ept2 = mysql_fetch_assoc($mate_ept2);
$totalRows_mate_ept2 = mysql_num_rows($mate_ept2);

//EPT3
$colname_mate_ept3 = "-1";
if (isset($_POST['anio_id'])) {
  $colname_mate_ept3 = $_POST['anio_id'];
}
$tr_mate_ept3 = "-1";
if (isset($_POST['tipor'])) {
  $tr_mate_ept3 = $_POST['tipor'];
}
$tc_mate_ept3 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_mate_ept3 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept3 = sprintf("SELECT * FROM jos_cdc_resumen_ept WHERE no=3 AND curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s ", GetSQLValueString($colname_mate_ept3, "int"), GetSQLValueString($tr_mate_ept3, "int"), GetSQLValueString($tc_mate_ept3, "int"));
$mate_ept3 = mysql_query($query_mate_ept3, $sistemacol) or die(mysql_error());
$row_mate_ept3 = mysql_fetch_assoc($mate_ept3);
$totalRows_mate_ept3 = mysql_num_rows($mate_ept3);

//EPT4
$colname_mate_ept4 = "-1";
if (isset($_POST['anio_id'])) {
  $colname_mate_ept4 = $_POST['anio_id'];
}
$tr_mate_ept4 = "-1";
if (isset($_POST['tipor'])) {
  $tr_mate_ept4 = $_POST['tipor'];
}
$tc_mate_ept4 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_mate_ept4 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept4 = sprintf("SELECT * FROM jos_cdc_resumen_ept WHERE no=4 AND curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s ", GetSQLValueString($colname_mate_ept4, "int"), GetSQLValueString($tr_mate_ept4, "int"), GetSQLValueString($tc_mate_ept4, "int"));
$mate_ept4 = mysql_query($query_mate_ept4, $sistemacol) or die(mysql_error());
$row_mate_ept4 = mysql_fetch_assoc($mate_ept4);
$totalRows_mate_ept4 = mysql_num_rows($mate_ept4);


//CONSULTA DE LAS OBSERVACIONES

if($_POST['hoja']==1){
$hoja=1;
}
if($_POST['hoja']==2){
$hoja=2;
}
if($_POST['hoja']==3){
$hoja=3;
}
if($_POST['hoja']==4){
$hoja=4;
}


$colname_observacion = "-1";
if (isset($_POST['anio_id'])) {
  $colname_observacion = $_POST['anio_id'];
}
$tr_observacion = "-1";
if (isset($_POST['tipor'])) {
  $tr_observacion = $_POST['tipor'];
}
$tc_observacion = "-1";
if (isset($_POST['tipoc'])) {
  $tc_observacion = $_POST['tipoc'];
}
$plan_observacion = "-1";
if (isset($_POST['plan_id'])) {
  $plan_observacion = $_POST['plan_id'];
}
$momento_observacion = "-1";
if (isset($_POST['momento'])) {
  $momento_observacion = $_POST['momento'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_observacion = sprintf("SELECT * FROM jos_cdc_resumen_observaciones WHERE  hoja=$hoja AND  curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s AND plan_id=%s AND momento=%s ", GetSQLValueString($colname_observacion, "int"), GetSQLValueString($tr_observacion, "int"), GetSQLValueString($tc_observacion, "int"), GetSQLValueString($plan_observacion, "int"), GetSQLValueString($momento_observacion, "int"));
$observacion = mysql_query($query_observacion, $sistemacol) or die(mysql_error());
$row_observacion = mysql_fetch_assoc($observacion);
$totalRows_observacion = mysql_num_rows($observacion);



// VER DATOS ALUMNOS
$colname_resumen_alumno = "-1";
if (isset($_POST['anio_id'])) {
  $colname_resumen_alumno = $_POST['anio_id'];
}
$tr_resumen_alumno = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_alumno = $_POST['tipor'];
}
$tc_resumen_alumno = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_alumno = $_POST['tipoc'];
}
$plan_resumen_alumno = "-1";
if (isset($_POST['plan_id'])) {
  $plan_resumen_alumno = $_POST['plan_id'];
}
$momento_resumen_alumno = "-1";
if (isset($_POST['momento'])) {
  $momento_resumen_alumno = $_POST['momento'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_alumno = sprintf("SELECT * FROM jos_cdc_resumen_pendiente a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.no_alumno>=$hojaini AND a.no_alumno<=$hojafin AND a.anio_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s  AND a.plan_id=%s AND a.momento=%s GROUP BY a.alumno_id ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_alumno, "int"), GetSQLValueString($tr_resumen_alumno, "int"), GetSQLValueString($tc_resumen_alumno, "int"), GetSQLValueString($plan_resumen_alumno, "int"), GetSQLValueString($momento_resumen_alumno, "int"));
$resumen_alumno = mysql_query($query_resumen_alumno, $sistemacol) or die(mysql_error());
$row_resumen_alumno = mysql_fetch_assoc($resumen_alumno);
$totalRows_resumen_alumno = mysql_num_rows($resumen_alumno);

// ALUMNOS SECCION
$colname_alumno_seccion = "-1";
if (isset($_POST['anio_id'])) {
  $colname_alumno_seccion = $_POST['anio_id'];
}
$tr_alumno_seccion = "-1";
if (isset($_POST['tipor'])) {
  $tr_alumno_seccion = $_POST['tipor'];
}
$plan_alumno_seccion = "-1";
if (isset($_POST['plan_id'])) {
  $plan_alumno_seccion = $_POST['plan_id'];
}
$momento_alumno_seccion = "-1";
if (isset($_POST['momento'])) {
  $momento_alumno_seccion = $_POST['momento'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_seccion = sprintf("SELECT * FROM jos_cdc_resumen_pendiente WHERE anio_id=%s  AND tipo_resumen=%s  AND  plan_id=%s AND momento=%s", GetSQLValueString($colname_alumno_seccion, "int"), GetSQLValueString($tr_alumno_seccion, "int"), GetSQLValueString($plan_alumno_seccion, "int"), GetSQLValueString($momento_alumno_seccion, "int"));
$alumno_seccion = mysql_query($query_alumno_seccion, $sistemacol) or die(mysql_error());
$row_alumno_seccion = mysql_fetch_assoc($alumno_seccion);
$totalRows_alumno_seccion = mysql_num_rows($alumno_seccion);

$momento_fecham = "-1";
if (isset($_POST['momento'])) {
  $momento_fecham = $_POST['momento'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_fecham = sprintf("SELECT * FROM jos_cdc_resumen_fecham WHERE momento=%s", GetSQLValueString($momento_fecham, "int"));
$fecham = mysql_query($query_fecham, $sistemacol) or die(mysql_error());
$row_fecham = mysql_fetch_assoc($fecham);
$totalRows_fecham = mysql_num_rows($fecham);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SISTEMA INTERSOFT | Software Educativo</title>
<link href="../../css/form_vista_resumen.css" rel="stylesheet" type="text/css" >
<link href="../../css/form_impresion_resumen.css" rel="stylesheet" type="text/css" media="print">

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
<STYLE type=text/css> 
#elemento_fijo { 
    POSITION: fixed; TOP: 96&#37;;   /*POSITION: fixed; TOP: 555px;*/ 
    border:1px solid #000;  background:#cff;
    padding-right: 10px;
    
} 
* HTML #elemento_fijo { 
    POSITION: absolute; ; TOP: expression(document.compatMode=="CSS1Compat"? document.documentElement.scrollTop+580+"px" : body.scrollTop+580+"px") 
} 
</STYLE> 
</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
if($totalRows_resumen>0){
?>
<div class="ocultar">
<div id="elemento_fijo" ><a href="../../../modules/acciones/agregar_notas_resumen_pendiente.php?anio_id=<?php echo $_POST['anio_id'];?>&plan_id=<?php echo $_POST['plan_id'];?>&tipor=<?php echo $_POST['tipor'];?>&tipoc=<?php echo $_POST['tipoc'];?>&momento=<?php echo $_POST['momento'];?>" target="_blank" class="nyroModal"><img src="../../images/pngnew/agregar-usuarios-icono-3782-48.png" alt="" align="middle" />Agregar Estudiante</a></div>
</div>
<div id="ancho_certificacion">
<div id="logo_me">
<div id="logo">
<img src="../../images/logo_ce_2013.jpg" border="0" align="absmiddle" width="300" height="35"> 
</div>
<!--
Ministerio de Poder Popular<br />
para la Educaci&oacute;n<br />
Viceministerio de Participaci&oacute;n y Apoyo Acad&eacute;mico<br />
Direcci&oacute;n General de Registro y Control Acad&eacute;mico
-->
</div>
<div id="titulo_mencion">
	<div class="certificacion">
	<b>RESUMEN FINAL DE EVALUACION</b>
	</div>
	<div class="coddea">
	<b>(R&eacute;gimen Regular) C&oacute;digo del Formato: RR-DEA-04-03</b>
	</div>
	<div class="titulo1">
	<b>I. Plan de Estudio:</b>
	</div>
	<div class="plan">
	 <?php echo $row_resumen['plan_estudio']; ?> 
	</div>
	<div class="titulo2">
	<b>COD:</b>
	</div>
	<div class="codplan">
	<?php echo $row_resumen['cod']; ?>
	</div>
	<div class="titulo1">
	<b>Menci&oacute;n:</b>
	</div>
	<div class="mencion"><?php if ($row_resumen['mencion']==NULL) { echo "************";} else { echo $row_resumen['mencion']; $men=$row_resumen['mencion'];} ?>
	</div>
	<div class="titulo1" style="width:1.7cm;">
	<b>A&ntilde;o Escolar:</b> 
	</div>
	<div class="codplan_22">
	<?php echo $row_periodo['descripcion'];?> 
	</div>
	<div class="fecha_titulo">
	<b>Mes y A&ntilde;o de la Evaluaci&oacute;n: </b> 
	</div>
	<div class="codplan_2">
	<span style="font-size: 6.3pt;text-decoration: underline;" > 
	<?php 
	 echo $row_fecham['mes'];
	?>, <?php echo $row_fecham['anio'];?>
	</span>
	</div>



</div>
<div id="info_plantel_estudiante">
	<div class="titulo">
	<b>II. Datos del Plantel:</b>
	</div>
	<div class="titulo_info" style="text-align:left;">
	<b>C&oacute;d. Plantel:</b>
	</div>
	<div class="cod_plantel">
	<?php echo $row_institucion['cod_plantel'];?>
	</div>
	<div class="titulo_info" style="width:1cm;">
	<b>Nombre:</b> 
	</div>
	<div class="nombre_plantel" style="width:8.6cm;font-size: 6.3pt;">
	<?php echo $row_institucion['nombre_plantel'];?>
	</div>
	<div class="titulo_info">
	<b>Dtto.Esc.:</b>
	</div>
	<div class="dtto">
	 <?php echo $row_institucion['dtto_esc'];?> 
	</div>

	<div class="titulo_info" style="text-align:left;">
	<b>Direcci&oacute;n:</b>
	</div>
	<div class="direccion" style="font-size:7pt;">
	 <?php echo $row_institucion['direccion'];?>
	</div>
	<div class="titulo_info" >
	 <b>Tel&eacute;fono:</b>
	</div>
	<div class="telefono">
 	<?php echo $row_institucion['telefono'];?>
	</div>

	<div class="titulo_info" style="text-align:left;">
	<b>Municipio:</b>
	</div>
	<div class="municipio">
 	 <?php echo $row_institucion['municipio'];?>
	</div>
	<div class="titulo_info" >
	<b>Ent. Federal:</b> 
	</div>
	<div class="varios">
 	 <?php echo $row_institucion['ent_federal'];?>
	</div>
	<div class="titulo_info" style="width:3cm;" >
	<b>Zona Educativa:</b>
	</div>
	<div class="varios">
 	 <?php echo $row_institucion['zona_educativa'];?>
	</div>

	<div class="titulo_info" style="text-align:left;">
	<b>Director (a):</b>
	</div>
	<div class="direccion">
	 <?php echo $row_institucion['apellido_director'].", ".$row_institucion['nombre_director'];?>
	</div>
	<div class="titulo_info" >
	 <b>C.I.:</b>
	</div>
	<div class="telefono">
 	<?php echo $row_institucion['cedula_director'];?>
	</div>
	<div class="titulo">
	<b>III. Resumen Final de Evaluaci&oacute;n:</b>
	</div>

</div>
<div id="central_notas">

<table class="tabla">
	<tr>
		<td class="cuadro_no" rowspan="3"><b>No.</b></td>
		<td class="cuadro_cedula" rowspan="3"><b>C&eacute;dula de Identidad</b></td>
		<td colspan="15" align="center"><b>Calificaciones de las Asignaturas</b></td>
		<td rowspan="2" colspan="4" align="center"><b>Prog. Aprobados Educ. Trab.</b></td>
		<td  class="cuadro_no" rowspan="3"><b>Resu<br />men</b></td>
	</tr>
	<tr>
		<td class="cuadrito">01</td>
		<td class="cuadrito">02</td>
		<td class="cuadrito">03</td>
		<td class="cuadrito">04</td>
		<td class="cuadrito">05</td>
		<td class="cuadrito">06</td>
		<td class="cuadrito">07</td>
		<td class="cuadrito">08</td>
		<td class="cuadrito">09</td>
		<td class="cuadrito">10</td>
		<td class="cuadrito">11</td>
		<td class="cuadrito">12</td>
		<td class="cuadrito">13</td>
		<td class="cuadrito">14</td>
		<td class="cuadrito">15</td>
	</tr>
	<tr>
		 <?php do { ?><td class="cuadrito">

<?php if($row_asignaturas['numero']==1){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==2){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==3){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==4){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==5){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==6){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==7){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==8){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==9){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==10){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==11){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==12){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==13){ echo $row_asignaturas['iniciales'];} ?>
<?php if($row_asignaturas['numero']==14){ echo $row_asignaturas['iniciales'];} ?>
</td>
<?php  } while ($row_asignaturas = mysql_fetch_assoc($asignaturas)); ?>

<?php 
// PARA COLOCAR EL CUADRO DE EPT
if($row_resumen['m14']!=""){ ?>
<td class="cuadrito">
ET
</td>
<?php $i=2; }?>

<?php if($row_resumen['m14']==0){ 
$i=1; 
}?>

<?php  $totalmates=14-$totalRows_asignaturas; do { ?>
<td class="cuadrito">
*
</td>
<?php  $i++; } while ($i <= $totalmates); ?>
<td class="cuadrito">*</td> <!--  columna 15 -->

		<td class="cuadrito">1</td>
		<td class="cuadrito">2</td>
		<td class="cuadrito">3</td>
		<td class="cuadrito">4</td>
	</tr>
	<?php 
	$sm1=0;	$sm2=0;	$sm3=0;	$sm4=0;	$sm5=0;	$sm6=0;	$sm7=0;	$sm8=0;	$sm9=0;	$sm10=0; $sm11=0; $sm12=0; $sm13=0; $sm14=0; 
	$si1=0;	$si2=0;	$si3=0;	$si4=0;	$si5=0;	$si6=0;	$si7=0;	$si8=0;	$si9=0;	$si10=0; $si11=0; $si12=0; $si13=0; $si14=0;
	$sa1=0;	$sa2=0;	$sa3=0;	$sa4=0;	$sa5=0;	$sa6=0;	$sa7=0;	$sa8=0;	$sa9=0;	$sa10=0; $sa11=0; $sa12=0; $sa13=0; $sa14=0;
	$sr1=0;	$sr2=0;	$sr3=0;	$sr4=0;	$sr5=0;	$sr6=0;	$sr7=0;	$sr8=0;	$sr9=0;	$sr10=0; $sr11=0; $sr12=0; $sr13=0; $sr14=0;
	$no=1;
	do  { $a=0; ?>
	<tr>
		<td><?php echo $no;?></td>
		<td style="text-align:left;">&nbsp;&nbsp;<a href="../../../modules/acciones/datos_notas_resumen_pendiente.php?id=<?php echo $row_resumen['id'];?>" target="_blank" class="nyroModal"><?php echo $row_resumen['indicador_nacionalidad']."-".$row_resumen['cedula'];?></a><span class="ocultar">&nbsp;&nbsp;&nbsp;&nbsp;<a href="../../../modules/acciones/eliminar_datos_notas_resumen_pendiente.php?id=<?php echo $row_resumen['id'];?>" target="_blank" class="nyroModal"><img src="../../../images/png/cancel_f2.png" alt="" height="13" style="vertical-align:middle;"></a></span></td>
		<td><?php if(($row_resumen['m1']>0) and ($row_resumen['m1']<10)){echo "0".$row_resumen['m1'];} if(($row_resumen['m1']>9) and ($row_resumen['m1']<21)){echo $row_resumen['m1'];} if($row_resumen['m1']==0){echo "";} if($row_resumen['m1']==99){echo "P";} if($row_resumen['m1']==98){echo "I";} if($row_resumen['m1']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m2']>0) and ($row_resumen['m2']<10)){echo "0".$row_resumen['m2'];} if(($row_resumen['m2']>9) and ($row_resumen['m2']<21)){echo $row_resumen['m2'];} if($row_resumen['m2']==0){echo "";} if($row_resumen['m2']==99){echo "P";} if($row_resumen['m2']==98){echo "I";} if($row_resumen['m2']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m3']>0) and ($row_resumen['m3']<10)){echo "0".$row_resumen['m3'];} if(($row_resumen['m3']>9) and ($row_resumen['m3']<21)){echo $row_resumen['m3'];} if($row_resumen['m3']==0){echo "";} if($row_resumen['m3']==99){echo "P";} if($row_resumen['m3']==98){echo "I";} if($row_resumen['m3']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m4']>0) and ($row_resumen['m4']<10)){echo "0".$row_resumen['m4'];} if(($row_resumen['m4']>9) and ($row_resumen['m4']<21)){echo $row_resumen['m4'];} if($row_resumen['m4']==0){echo "";} if($row_resumen['m4']==99){echo "P";} if($row_resumen['m4']==98){echo "I";} if($row_resumen['m4']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m5']>0) and ($row_resumen['m5']<10)){echo "0".$row_resumen['m5'];} if(($row_resumen['m5']>9) and ($row_resumen['m5']<21)){echo $row_resumen['m5'];} if($row_resumen['m5']==0){echo "";} if($row_resumen['m5']==99){echo "P";} if($row_resumen['m5']==98){echo "I";} if($row_resumen['m5']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m6']>0) and ($row_resumen['m6']<10)){echo "0".$row_resumen['m6'];} if(($row_resumen['m6']>9) and ($row_resumen['m6']<21)){echo $row_resumen['m6'];} if($row_resumen['m6']==0){echo "";} if($row_resumen['m6']==99){echo "P";} if($row_resumen['m6']==98){echo "I";} if($row_resumen['m6']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m7']>0) and ($row_resumen['m7']<10)){echo "0".$row_resumen['m7'];} if(($row_resumen['m7']>9) and ($row_resumen['m7']<21)){echo $row_resumen['m7'];} if($row_resumen['m7']==0){echo "";} if($row_resumen['m7']==99){echo "P";} if($row_resumen['m7']==98){echo "I";} if($row_resumen['m7']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m8']>0) and ($row_resumen['m8']<10)){echo "0".$row_resumen['m8'];} if(($row_resumen['m8']>9) and ($row_resumen['m8']<21)){echo $row_resumen['m8'];} if($row_resumen['m8']==0){echo "";} if($row_resumen['m8']==99){echo "P";} if($row_resumen['m8']==98){echo "I";} if($row_resumen['m8']==NULL){echo "*";} ?></td>

		<td><?php if(($row_resumen['m9']>0) and ($row_resumen['m9']<10)){echo "0".$row_resumen['m9'];} if(($row_resumen['m9']>9) and ($row_resumen['m9']<21)){echo $row_resumen['m9'];} if($row_resumen['m9']==0){echo "";} if($row_resumen['m9']==99){echo "P";} if($row_resumen['m9']==98){echo "I";} if($row_resumen['m9']==NULL){echo "*";} ?></td>



		<td><?php if(($totalRows_asignaturas==9) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if(($row_resumen['m14']>9) and ($row_resumen['m14']<21)){echo $row_resumen['m14'];} }else{

if(($row_resumen['m9']!="") and ($row_resumen['m10']==NULL) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} if($row_resumen['m14']==0){echo "";} if($row_resumen['m14']==99){echo "P";} if($row_resumen['m14']==98){echo "I";} if($row_resumen['m14']==NULL){echo "*";}}  

if($row_resumen['m10']!=""){ if(($row_resumen['m10']>0) and ($row_resumen['m10']<10)){echo "0".$row_resumen['m10'];} if(($row_resumen['m10']>9) and ($row_resumen['m10']<21)){echo $row_resumen['m10'];} if($row_resumen['m10']==0){echo "";} if($row_resumen['m10']==99){echo "P";} if($row_resumen['m10']==98){echo "I";} if($row_resumen['m10']==NULL){echo "*";} } 

if(($row_resumen['m9']!="") and ($row_resumen['m10']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m9']==NULL) and ($row_resumen['m10']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m9']==NULL) and ($row_resumen['m10']==NULL) and ($row_resumen['m14']!="")){ echo "*"; } }
// termina m10
?></td>

		<td><?php if(($totalRows_asignaturas==10) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} }else{

if(($row_resumen['m10']!="") and ($row_resumen['m11']==NULL) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} if($row_resumen['m14']==0){echo "";} if($row_resumen['m14']==99){echo "P";} if($row_resumen['m14']==98){echo "I";} if($row_resumen['m14']==NULL){echo "*";}}  

if($row_resumen['m11']!=""){ if(($row_resumen['m11']>0) and ($row_resumen['m11']<10)){echo "0".$row_resumen['m11'];} if(($row_resumen['m11']>9) and ($row_resumen['m11']<21)){echo $row_resumen['m11'];} if($row_resumen['m11']==0){echo "";} if($row_resumen['m11']==99){echo "P";} if($row_resumen['m11']==98){echo "I";} if($row_resumen['m11']==NULL){echo "*";} } 

if(($row_resumen['m10']!="") and ($row_resumen['m11']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m10']==NULL) and ($row_resumen['m11']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m10']==NULL) and ($row_resumen['m11']==NULL) and ($row_resumen['m14']!="")){ echo "*"; } }
//termina m11
?></td>

		<td><?php if(($totalRows_asignaturas==11) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} }else{

if(($row_resumen['m11']!="") and ($row_resumen['m12']==NULL) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} if($row_resumen['m14']==0){echo "";} if($row_resumen['m14']==99){echo "P";} if($row_resumen['m14']==98){echo "I";} if($row_resumen['m14']==NULL){echo "*";}}  

if($row_resumen['m12']!=""){ if(($row_resumen['m12']>0) and ($row_resumen['m12']<10)){echo "0".$row_resumen['m12'];} if(($row_resumen['m12']>9) and ($row_resumen['m12']<21)){echo $row_resumen['m12'];} if($row_resumen['m12']==0){echo "";} if($row_resumen['m12']==99){echo "P";} if($row_resumen['m12']==98){echo "I";} if($row_resumen['m12']==NULL){echo "*";} } 

if(($row_resumen['m11']!="") and ($row_resumen['m12']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m11']==NULL) and ($row_resumen['m12']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m11']==NULL) and ($row_resumen['m12']==NULL) and ($row_resumen['m14']!="")){ echo "*"; } }
// termina m12
?></td>

		<td><?php if(($totalRows_asignaturas==12) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} }else{

if(($row_resumen['m12']!="") and ($row_resumen['m13']==NULL) and ($row_resumen['m14']!="")){ if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)){echo "0".$row_resumen['m14'];} if($row_resumen['m14']>9){echo $row_resumen['m14'];} if($row_resumen['m14']==0){echo "";} if($row_resumen['m14']==99){echo "P";} if($row_resumen['m14']==98){echo "I";} if($row_resumen['m14']==NULL){echo "*";}}  

if($row_resumen['m13']!=""){ if(($row_resumen['m13']>0) and ($row_resumen['m13']<10)){echo "0".$row_resumen['m13'];} if(($row_resumen['m13']>9) and ($row_resumen['m13']<21)){echo $row_resumen['m13'];} if($row_resumen['m13']==0){echo "";} if($row_resumen['m13']==99){echo "P";} if($row_resumen['m13']==98){echo "I";} if($row_resumen['m13']==NULL){echo "*";} } 

if(($row_resumen['m12']!="") and ($row_resumen['m13']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m12']==NULL) and ($row_resumen['m13']==NULL) and ($row_resumen['m14']==NULL)){ echo "*"; } if(($row_resumen['m12']==NULL) and ($row_resumen['m13']==NULL) and ($row_resumen['m14']!="")){ echo "*"; } }	
//termina 13
?></td>

		<td>*</td>
		<td>*</td> <!-- columna 15 -->
		<td><?php if($row_resumen['ept1']==0){echo "*";} if($row_resumen['ept1']==1){echo "X";} if($row_resumen['ept1']==2){echo "-";}?></td>
		<td><?php if($row_resumen['ept2']==0){echo "*";} if($row_resumen['ept2']==1){echo "X";} if($row_resumen['ept2']==2){echo "-";}?></td>
		<td><?php if($row_resumen['ept3']==0){echo "*";} if($row_resumen['ept3']==1){echo "X";} if($row_resumen['ept3']==2){echo "-";}?></td>
		<td><?php if($row_resumen['ept4']==0){echo "*";} if($row_resumen['ept4']==1){echo "X";} if($row_resumen['ept4']==2){echo "-";}?></td>
		<?php // cuadro derecho de resumen ?>		
		<td>
		<?php
		// No. para las calificaciones
		if(($row_resumen['m1']>0) and ($row_resumen['m1']<10) and ($row_resumen['m1']!="")) { $a++;}
		if(($row_resumen['m2']>0) and ($row_resumen['m2']<10) and ($row_resumen['m2']!="")){ $a++;}
		if(($row_resumen['m3']>0) and ($row_resumen['m3']<10) and ($row_resumen['m3']!="")){ $a++;}
		if(($row_resumen['m4']>0) and ($row_resumen['m4']<10) and ($row_resumen['m4']!="")){ $a++;}
		if(($row_resumen['m5']>0) and ($row_resumen['m5']<10) and ($row_resumen['m5']!="")){ $a++;}
		if(($row_resumen['m6']>0) and ($row_resumen['m6']<10) and ($row_resumen['m6']!="")){ $a++;}
		if(($row_resumen['m7']>0) and ($row_resumen['m7']<10) and ($row_resumen['m7']!="")){ $a++;}
		if(($row_resumen['m8']>0) and ($row_resumen['m8']<10) and ($row_resumen['m8']!="")){ $a++;}
		if(($row_resumen['m9']>0) and ($row_resumen['m9']<10) and ($row_resumen['m9']!="")){ $a++;}
		if(($row_resumen['m10']>0) and ($row_resumen['m10']<10) and ($row_resumen['m10']!="")){ $a++;}
		if(($row_resumen['m11']>0) and ($row_resumen['m11']<10) and ($row_resumen['m11']!="")){ $a++;}
		if(($row_resumen['m12']>0) and ($row_resumen['m12']<10) and ($row_resumen['m12']!="")){ $a++;}
		if(($row_resumen['m13']>0) and ($row_resumen['m13']<10) and ($row_resumen['m13']!="")){ $a++;}
		if(($row_resumen['m14']>0) and ($row_resumen['m14']<10) and ($row_resumen['m14']!="")){ $a++;}
		
		//No. para las materias inasistentes
		if(($row_resumen['m1']>90)) { $a=98;}
		if(($row_resumen['m2']>90)) { $a=98;}
		if(($row_resumen['m3']>90)) { $a=98;}
		if(($row_resumen['m4']>90)) { $a=98;}
		if(($row_resumen['m5']>90)) { $a=98;}
		if(($row_resumen['m6']>90)) { $a=98;}
		if(($row_resumen['m7']>90)) { $a=98;}
		if(($row_resumen['m8']>90)) { $a=98;}
		if(($row_resumen['m9']>90)) { $a=98;}
		if(($row_resumen['m10']>90)) { $a=98;}
		if(($row_resumen['m11']>90)) { $a=98;}
		if(($row_resumen['m12']>90)) { $a=98;}
		if(($row_resumen['m13']>90)) { $a=98;}
		if(($row_resumen['m14']>90)) { $a=98;}
		
		
		if($a==0){echo "1";}
		if($a==1){echo "2";}
		if(($a>1) and ($a<90)){echo "3";}
		if($a==98){echo "4";}
		
		?>
		</td>
	</tr>
	<?php  //sumatoria inscritas 
		if($row_resumen['m1']>0){$sm1++;}
		if($row_resumen['m2']>0){$sm2++;}
		if($row_resumen['m3']>0){$sm3++;}
		if($row_resumen['m4']>0){$sm4++;}
		if($row_resumen['m5']>0){$sm5++;}
		if($row_resumen['m6']>0){$sm6++;}
		if($row_resumen['m7']>0){$sm7++;}
		if($row_resumen['m8']>0){$sm8++;}
		if($row_resumen['m9']>0){$sm9++;}
		if($row_resumen['m10']>0){$sm10++;}
		if($row_resumen['m11']>0){$sm11++;}
		if($row_resumen['m12']>0){$sm12++;}
		if($row_resumen['m13']>0){$sm13++;}
		if($row_resumen['m14']>0){$sm14++;}
		$valorm8=$row_resumen['m8'];
		$valorm9=$row_resumen['m9'];
		$valorm10=$row_resumen['m10'];
		$valorm11=$row_resumen['m11'];
		$valorm12=$row_resumen['m12'];
		$valorm13=$row_resumen['m13'];
		$valorm14=$row_resumen['m14'];
	?>

	<?php  //sumatoria INSISTENCIAS
		if(($row_resumen['m1']==98) or ($row_resumen['m1']==99)) {$si1++;}
		if(($row_resumen['m2']==98) or ($row_resumen['m2']==99)){$si2++;}
		if(($row_resumen['m3']==98) or ($row_resumen['m3']==99)) {$si3++;}
		if(($row_resumen['m4']==98) or ($row_resumen['m4']==99)){$si4++;}
		if(($row_resumen['m5']==98) or ($row_resumen['m5']==99)){$si5++;}
		if(($row_resumen['m6']==98) or ($row_resumen['m6']==99)){$si6++;}
		if(($row_resumen['m7']==98) or ($row_resumen['m7']==99)){$si7++;}
		if(($row_resumen['m8']==98) or ($row_resumen['m8']==99)){$si8++;}
		if(($row_resumen['m9']==98) or ($row_resumen['m9']==99)){$si9++;}
		if(($row_resumen['m10']==98) or ($row_resumen['m10']==99)){$si10++;}
		if(($row_resumen['m11']==98) or ($row_resumen['m11']==99)){$si11++;}
		if(($row_resumen['m12']==98) or ($row_resumen['m12']==99)){$si12++;}
		if(($row_resumen['m13']==98) or ($row_resumen['m13']==99)){$si13++;}
		if(($row_resumen['m14']==98) or ($row_resumen['m14']==99)){$si14++;}

	?>

	<?php  //sumatoria APROBADAS
		if(($row_resumen['m1']>9) and ($row_resumen['m1']<21)) {$sa1++;}
		if(($row_resumen['m2']>9) and ($row_resumen['m2']<21)) {$sa2++;}
		if(($row_resumen['m3']>9) and ($row_resumen['m3']<21)) {$sa3++;}
		if(($row_resumen['m4']>9) and ($row_resumen['m4']<21)) {$sa4++;}
		if(($row_resumen['m5']>9) and ($row_resumen['m5']<21)) {$sa5++;}
		if(($row_resumen['m6']>9) and ($row_resumen['m6']<21)) {$sa6++;}
		if(($row_resumen['m7']>9) and ($row_resumen['m7']<21)) {$sa7++;}
		if(($row_resumen['m8']>9) and ($row_resumen['m8']<21)) {$sa8++;}
		if(($row_resumen['m9']>9) and ($row_resumen['m9']<21)) {$sa9++;}
		if(($row_resumen['m10']>9) and ($row_resumen['m10']<21)) {$sa10++;}
		if(($row_resumen['m11']>9) and ($row_resumen['m11']<21)) {$sa11++;}
		if(($row_resumen['m12']>9) and ($row_resumen['m12']<21)) {$sa12++;}
		if(($row_resumen['m13']>9) and ($row_resumen['m13']<21)) {$sa13++;}
		if(($row_resumen['m14']>9) and ($row_resumen['m14']<21)) {$sa14++;}



	?>
	
	<?php  //sumatoria REPROBADAS
		if(($row_resumen['m1']>0) and ($row_resumen['m1']<10)) {$sr1++;}
		if(($row_resumen['m2']>0) and ($row_resumen['m2']<10)) {$sr2++;}
		if(($row_resumen['m3']>0) and ($row_resumen['m3']<10)) {$sr3++;}
		if(($row_resumen['m4']>0) and ($row_resumen['m4']<10)) {$sr4++;}
		if(($row_resumen['m5']>0) and ($row_resumen['m5']<10)) {$sr5++;}
		if(($row_resumen['m6']>0) and ($row_resumen['m6']<10)) {$sr6++;}
		if(($row_resumen['m7']>0) and ($row_resumen['m7']<10)) {$sr7++;}
		if(($row_resumen['m8']>0) and ($row_resumen['m8']<10)) {$sr8++;}
		if(($row_resumen['m9']>0) and ($row_resumen['m9']<10)) {$sr9++;}
		if(($row_resumen['m10']>0) and ($row_resumen['m10']<10)) {$sr10++;}
		if(($row_resumen['m11']>0) and ($row_resumen['m11']<10)) {$sr11++;}
		if(($row_resumen['m12']>0) and ($row_resumen['m12']<10)) {$sr12++;}
		if(($row_resumen['m13']>0) and ($row_resumen['m13']<10)) {$sr13++;}
		if(($row_resumen['m14']>0) and ($row_resumen['m14']<10)) {$sr14++;}



	?>
	<?php $no++; } while ($row_resumen = mysql_fetch_assoc($resumen)); ?>

	<tr>
	<?php if($no<14){  $no=$totalRows_resumen+1; $tr=13; do { ?>
	<tr>
		<td class="cuadrito"><?php echo $no; ?></td>
		<td >**********</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>

	</tr>
	<?php $no++; } while($no <= $tr); }?>
		<td rowspan="5" colspan="2">
		<table><tr>
			<td rowspan="4" style="width:2cm; height:1.6cm; border-width: 0 1px 0 0;"><b>III. TOTALES</b></td>
			<td style="width:2cm; border-width: 0 0 1px 0; text-align:right; ">INSC&nbsp;&nbsp;</td>
			</tr>
			<tr>
			<td style="width:2cm; border-width: 0 0 1px 0; text-align:right;">INAS&nbsp;&nbsp;</td>
			</tr>
			<tr>
			<td style="width:2cm; border-width: 0 0 1px 0; text-align:right;">APRO&nbsp;&nbsp;</td>
			</tr>
			<tr>
			<td style="width:2cm; border-width: 0 0 0 0; text-align:right;">APLAZ&nbsp;&nbsp;</td>
			</tr>
		</table>
		</td>


	</tr>
	<tr>
<?php // ASIGNATURAS INSCRITAS ?>
		<td class="cuadrito"><?php if($sm1<10){echo "0".$sm1;}else{echo $sm1;}?></td>
		<td class="cuadrito"><?php if($sm2<10){echo "0".$sm2;}else{echo $sm2;}?></td>
		<td class="cuadrito"><?php if($sm3<10){echo "0".$sm3;}else{echo $sm3;}?></td>
		<td class="cuadrito"><?php if($sm4<10){echo "0".$sm4;}else{echo $sm4;}?></td>
		<td class="cuadrito"><?php if($sm5<10){echo "0".$sm5;}else{echo $sm5;}?></td>
		<td class="cuadrito"><?php if($sm6<10){echo "0".$sm6;}else{echo $sm6;}?></td>
		<td class="cuadrito"><?php if($sm7<10){echo "0".$sm7;}else{echo $sm7;}?></td>
		<td class="cuadrito"><?php if($sm8<10){echo "0".$sm8;}else{echo $sm8;}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{ if(($sm9>0) and ($sm9<10)){echo "0".$sm9;} if($sm9>9){echo $sm9; } if(($sm9==NULL)and($row_seccion['orden_resumen']<6)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==9) and ($sm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{ if(($sm10>0) and ($sm10<10)){echo "0".$sm10;} if($sm10>9){echo $sm10; } if(($sm10==NULL)and($row_seccion['orden_resumen']<6)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==10) and ($sm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{ if(($sm11>0) and ($sm11<10)){echo "0".$sm11;} if($sm11>9){echo $sm11; } if(($sm11==NULL)and($row_seccion['orden_resumen']>3)){echo "00";} if(($sm11>0)and($row_seccion['orden_resumen']>3)){echo "";} if(($sm11==NULL)and($row_seccion['orden_resumen']<4)){echo "*";}}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==11) and ($sm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{ if(($sm12>0) and ($sm12<10)){echo "0".$sm12;} if($sm12>9){echo $sm12; } if($sm12==NULL){echo "*";}}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==12) and ($sm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{ if(($sm13>0) and ($sm13<10)){echo "0".$sm13;} if($sm13>9){echo $sm13; } if($sm13==NULL){echo "*";}}?></td>
		<td class="cuadrito"><?php if($sm14<10){echo "*";}else{echo "*";}?></td>
 		<td class="cuadrito"> * </td> <!-- Columna 15 -->


<?php /*
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($valorm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{

if($valorm9!=""){ if($sm9==0){echo "*x";}if($sm9<10){echo "0".$sm9;}else{echo $sm9;} } if(($valorm14!="") and ($valorm9==NULL) and ($valorm8!="")){ echo $sm14; } if(($valorm8!="") and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*a"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*c"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14!="")){ echo "*d"; } }?></td>


		<td class="cuadrito"><?php  if(($totalRows_asignaturas==9) and ($valorm14>0)){if($sm14<10){echo "0".$sm14;}else{echo $sm14;} }else{ if($valorm10!=""){ if($sm10==0){echo "*a";}else{echo $sm10;} } if(($valorm14!="") and ($valorm10==NULL) and ($valorm9!="")){ echo $sm14; } if(($valorm9!="") and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*b"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14!="")){ echo "*3"; } }?></td>


		<td class="cuadrito"><?php if($valorm11!=""){ if($sm11==0){echo "*a";}else{echo $sm11;} } if(($valorm14!="") and ($valorm11==NULL) and ($valorm10!="")){ echo $sm14; } if(($valorm10!="") and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*b"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14!="")){ echo "*b"; }?></td>

		<td class="cuadrito"><?php if($valorm12!=""){ if($sm12==0){echo "*";}else{echo $sm12;} } if(($valorm14!="") and ($valorm12==NULL) and ($valorm11!="")){ echo $sm14; } if(($valorm11!="") and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm13!=""){ if($sm13==0){echo "*";}else{echo $sm13;} } if(($valorm14!="") and ($valorm13==NULL) and ($valorm12!="")){ echo $sm14; } if(($valorm12!="") and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14!="")){ echo "*"; }?></td>

*/?>

		<td rowspan="2" colspan="5"><b>TIPO DE EVALUACION </b></td>
	</tr>

	<tr>
<?php // INASISTENCIAS ?>		
		<td class="cuadrito"><?php if(($si1>=0)and($si1<10)){ echo "0".$si1; }else{ echo $si1;}?></td>
		<td class="cuadrito"><?php if(($si2>=0)and($si2<10)){ echo "0".$si2; }else{ echo $si2;}?></td>
		<td class="cuadrito"><?php if(($si3>=0)and($si3<10)){ echo "0".$si3; }else{ echo $si3;}?></td>
		<td class="cuadrito"><?php if(($si4>=0)and($si4<10)){ echo "0".$si4; }else{ echo $si4;}?></td>
		<td class="cuadrito"><?php if(($si5>=0)and($si5<10)){ echo "0".$si5; }else{ echo $si5;}?></td>
		<td class="cuadrito"><?php if(($si6>=0)and($si6<10)){ echo "0".$si6; }else{ echo $si6;}?></td>
		<td class="cuadrito"><?php if(($si7>=0)and($si7<10)){ echo "0".$si7; }else{ echo $si7;}?></td>
		<td class="cuadrito"><?php if(($si8>=0)and($si8<10)){ echo "0".$si8; }else{ echo $si8;}?></td>

		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($si14>0)){if($si14<10){echo "0".$si14;}else{echo $si14;} }else{ if(($si9>0) and ($si9<10)){echo "0".$si9;} if($si9>9){echo $si9; } if(($si9==NULL)and($sm9==0)and($row_seccion['orden_resumen']<6)){echo "00";} if(($si9==NULL)and($sm9>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==9) and ($si14>0)){if($si14<10){echo "0".$si14;}else{echo $si14;} }else{ if(($si10>0) and ($si10<10)){echo "0".$si10;} if($si10>9){echo $si10; } if(($si10==NULL)and($sm10==0)and($row_seccion['orden_resumen']<6)){echo "00"; } if(($si10==NULL)and($sm10>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==10) and ($si14>0)){if($si14<10){echo "0".$si14;}else{echo $si14;} }else{ if(($si11>0) and ($si11<10)){echo "0".$si11;} if($si11>9){echo $si11; } if(($si11==NULL)and($row_seccion['orden_resumen']>3)){echo "00";} if(($si11>0)and($row_seccion['orden_resumen']>3)){echo "";} if(($si11==NULL)and($row_seccion['orden_resumen']<4)){echo "*";}}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==11) and ($si14>0)){if($si14<10){echo "0".$si14;}else{echo $si14;} }else{ if(($si12>0) and ($si12<10)){echo "0".$si12;} if($si12>9){echo $si12; } if(($si12==NULL)and($sm12==0)){echo "*"; } if(($si12==NULL)and($sm12>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==12) and ($si14>0)){if($si14<10){echo "0".$si14;}else{echo $si14;} }else{ if(($si13>0) and ($si13<10)){echo "0".$si13;} if($si13>9){echo $si13; } if(($si13==NULL)and($sm13==0)){echo "*"; } if(($si13==NULL)and($sm13>0)){echo "00"; }}?></td>
		<td class="cuadrito"> * </td>
		<td class="cuadrito"> * </td> <!-- Columna 15 -->

<?php /*
		<td class="cuadrito"><?php if($valorm9!=""){ if(($si9>=0)and($si9<10)){ echo "0".$si9; }else{ echo $si9;} } if(($valorm14!="") and ($valorm9==NULL) and ($valorm8!="")){ if(($si14>=0)and($si14<10)){ echo "0".$si14; }else{ echo $si14;} } if(($valorm8!="") and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm10!=""){ if(($si10>=0)and($si10<10)){ echo "0".$si10; }else{ echo $si10;} } if(($valorm14!="") and ($valorm10==NULL) and ($valorm9!="")){if(($si14>=0)and($si14<10)){ echo "0".$si14; }else{ echo $si14;} } if(($valorm9!="") and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm11!=""){ if(($si11>=0)and($si11<10)){ echo "0".$si11; }else{ echo $si11;} } if(($valorm14!="") and ($valorm11==NULL) and ($valorm10!="")){ if(($si14>=0)and($si14<10)){ echo "0".$si14; }else{ echo $si14;} } if(($valorm10!="") and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14!="")){ echo "*"; }?></td>

		<td class="cuadrito"><?php if($valorm12!=""){ if(($si12>=0)and($si12<10)){ echo "0".$si12; }else{ echo $si12;} } if(($valorm14!="") and ($valorm12==NULL) and ($valorm11!="")){ if(($si14>=0)and($si14<10)){ echo "0".$si14; }else{ echo $si14;} } if(($valorm11!="") and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm13!=""){ if(($si13>=0)and($si13<10)){ echo "0".$si13; }else{ echo $si13;} } if(($valorm14!="") and ($valorm13==NULL) and ($valorm12!="")){ if(($si14>=0)and($si14<10)){ echo "0".$si14; }else{ echo $si14;} } if(($valorm12!="") and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"> * </td>
*/?>

	</tr>

	<tr>
		<?php // APROBADAS ?>		
		<td class="cuadrito"><?php if(($sa1>=0)and($sa1<10)){ echo "0".$sa1; }else{ echo $sa1;}?></td>
		<td class="cuadrito"><?php if(($sa2>=0)and($sa2<10)){ echo "0".$sa2; }else{ echo $sa2;}?></td>
		<td class="cuadrito"><?php if(($sa3>=0)and($sa3<10)){ echo "0".$sa3; }else{ echo $sa3;}?></td>
		<td class="cuadrito"><?php if(($sa4>=0)and($sa4<10)){ echo "0".$sa4; }else{ echo $sa4;}?></td>
		<td class="cuadrito"><?php if(($sa5>=0)and($sa5<10)){ echo "0".$sa5; }else{ echo $sa5;}?></td>
		<td class="cuadrito"><?php if(($sa6>=0)and($sa6<10)){ echo "0".$sa6; }else{ echo $sa6;}?></td>
		<td class="cuadrito"><?php if(($sa7>=0)and($sa7<10)){ echo "0".$sa7; }else{ echo $sa7;}?></td>
		<td class="cuadrito"><?php if(($sa8>=0)and($sa8<10)){ echo "0".$sa8; }else{ echo $sa8;}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sa14>0)){if($sa14<10){echo "0".$sa14;}else{echo $sa14;} }else{ if(($sa9>0) and ($sa9<10)){echo "0".$sa9;} if($sa9>9){echo $sa9; } if(($sa9==NULL)and($sm9==0)and($row_seccion['orden_resumen']<6)){echo "00"; } if(($sa9==NULL)and($sm9>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sa14>0)){if($sa14<10){echo "0".$sa14;}else{echo $sa14;} }else{ if(($sa10>0) and ($sa10<10)){echo "0".$sa10;} if($sa10>9){echo $sa10; } if(($sa10==NULL)and($sm10==0)and($row_seccion['orden_resumen']<6)){echo "00"; }  if(($sa10==NULL)and($sm10>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sa14>0)){if($sa14<10){echo "0".$sa14;}else{echo $sa14;} }else{ if(($sa11>0) and ($sa11<10)){echo "0".$sa11;} if($sa11>9){echo $sa11; } if(($sa11==NULL)and($row_seccion['orden_resumen']>3)){echo "00";} if(($sa11>0)and($row_seccion['orden_resumen']>3)){echo "";} if(($sa11==NULL)and($row_seccion['orden_resumen']<4)){echo "*";}}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sa14>0)){if($sa14<10){echo "0".$sa14;}else{echo $sa14;} }else{ if(($sa12>0) and ($sa12<10)){echo "0".$sa12;} if($sa12>9){echo $sa12; } if(($sa12==NULL)and($sm12==0)){echo "*"; } if(($sa12==NULL)and($sm12>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sa14>0)){if($sa14<10){echo "0".$sa14;}else{echo $sa14;} }else{ if(($sa13>0) and ($sa13<10)){echo "0".$sa13;} if($sa13>9){echo $sa13; } if(($sa13==NULL)and($sm13==0)){echo "*"; } if(($sa13==NULL)and($sm13>0)){echo "00"; }}?></td>

		<td class="cuadrito"> *</td>
		<td class="cuadrito"> * </td> <!-- Columna 15 -->
<?php /*
		<td class="cuadrito"><?php if($valorm9!=""){ if(($sa9>=0)and($sa9<10)){ echo "0".$sa9; }else{ echo $sa9;} } if(($valorm14!="") and ($valorm9==NULL) and ($valorm8!="")){ if(($sa14>=0)and($sa14<10)){ echo "0".$sa14; }else{ echo $sa14;} } if(($valorm8!="") and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm10!=""){ if(($sa10>=0)and($sa10<10)){ echo "0".$sa10; }else{ echo $sa10;} } if(($valorm14!="") and ($valorm10==NULL) and ($valorm9!="")){if(($sa14>=0)and($sa14<10)){ echo "0".$sa14; }else{ echo $sa14;} } if(($valorm9!="") and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14!="")){ echo "*"; }?></td>



		<td class="cuadrito"><?php if($valorm11!=""){ if(($sa11>=0)and($sa11<10)){ echo "0".$sa11; }else{ echo $sa11;} } if(($valorm14!="") and ($valorm11==NULL) and ($valorm10!="")){ if(($sa14>=0)and($sa14<10)){ echo "0".$sa14; }else{ echo $sa14;} } if(($valorm10!="") and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14!="")){ echo "*"; }?></td>

		<td class="cuadrito"><?php if($valorm12!=""){ if(($sa12>=0)and($sa12<10)){ echo "0".$sa12; }else{ echo $sa12;} } if(($valorm14!="") and ($valorm12==NULL) and ($valorm11!="")){ if(($sa14>=0)and($sa14<10)){ echo "0".$sa14; }else{ echo $sa14;} } if(($valorm11!="") and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm13!=""){ if(($sa13>=0)and($sa13<10)){ echo "0".$sa13; }else{ echo $sa13;} } if(($valorm14!="") and ($valorm13==NULL) and ($valorm12!="")){ if(($sa14>=0)and($sa14<10)){ echo "0".$sa14; }else{ echo $sa14;} } if(($valorm12!="") and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14!="")){ echo "*"; }?></td>

*/?>

		<td colspan="5"> <?php if($_POST['tipor']==1){echo "FINAL";} if($_POST['tipor']==2){echo "REVISION";} if($_POST['tipor']==3){echo "MATERIA PENDIENTE";}  ?> </td>
	</tr>

	<tr>
	<?php // REPROBADAS ?>		
		<td class="cuadrito"><?php if(($sr1>=0)and($sr1<10)){ echo "0".$sr1; }else{ echo $sr1;}?></td>

		<td class="cuadrito"><?php if(($sr2>=0)and($sr2<10)){ echo "0".$sr2; }else{ echo $sr2;}?></td>
		<td class="cuadrito"><?php if(($sr3>=0)and($sr3<10)){ echo "0".$sr3; }else{ echo $sr3;}?></td>
		<td class="cuadrito"><?php if(($sr4>=0)and($sr4<10)){ echo "0".$sr4; }else{ echo $sr4;}?></td>
		<td class="cuadrito"><?php if(($sr5>=0)and($sr5<10)){ echo "0".$sr5; }else{ echo $sr5;}?></td>
		<td class="cuadrito"><?php if(($sr6>=0)and($sr6<10)){ echo "0".$sr6; }else{ echo $sr6;}?></td>
		<td class="cuadrito"><?php if(($sr7>=0)and($sr7<10)){ echo "0".$sr7; }else{ echo $sr7;}?></td>
		<td class="cuadrito"><?php if(($sr8>=0)and($sr8<10)){ echo "0".$sr8; }else{ echo $sr8;}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==8) and ($sr14>0)){if($sr14<10){echo "0".$sr14;}else{echo $sr14;} }else{ if(($sr9>0) and ($sr9<10)){echo "0".$sr9;} if($sr9>9){echo $sr9; } if(($sr9==NULL)and($sm9==0)and($row_seccion['orden_resumen']<6)){echo "00"; } if(($sr9==NULL)and($sm9>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==9) and ($sr14>0)){if($sr14<10){echo "0".$sr14;}else{echo $sr14;} }else{ if(($sr10>0) and ($sr10<10)){echo "0".$sr10;} if($sr10>9){echo $sr10; } if(($sr10==NULL)and($sm10==0)and($row_seccion['orden_resumen']<6)){echo "00"; } if(($sr10==NULL)and($sm10>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==10) and ($sr14>0)){if($sr14<10){echo "0".$sr14;}else{echo $sr14;} }else{ if(($sr11>0) and ($sr11<10)){echo "0".$sr11;} if($sr11>9){echo $sr11; } if(($sr11==NULL)and($row_seccion['orden_resumen']>3)){echo "00";} if(($sr11>0)and($row_seccion['orden_resumen']>3)){echo "";} if(($sr11==NULL)and($row_seccion['orden_resumen']<4)){echo "*";}}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==11) and ($sr14>0)){if($sr14<10){echo "0".$sr14;}else{echo $sr14;} }else{ if(($sr12>0) and ($sr12<10)){echo "0".$sr12;} if($sr12>9){echo $sr12; } if(($sr12==NULL)and($sm12==0)){echo "*"; } if(($sr12==NULL)and($sm12>0)){echo "00"; }}?></td>
		<td class="cuadrito"><?php if(($totalRows_asignaturas==12) and ($sr14>0)){if($sr14<10){echo "0".$sr14;}else{echo $sr14;} }else{ if(($sr13>0) and ($sr13<10)){echo "0".$sr13;} if($sr13>9){echo $sr13; } if(($sr13==NULL)and($sm13==0)){echo "*"; } if(($sr13==NULL)and($sm13>0)){echo "00"; }}?></td>

		<td class="cuadrito">* </td>
		<td class="cuadrito"> * </td> <!-- Columna 15 -->

<?php /*


		<td class="cuadrito"><?php if($valorm9!=""){ if(($sr9>=0)and($sr9<10)){ echo "0".$sr9; }else{ echo $sr9;} } if(($valorm14!="") and ($valorm9==NULL) and ($valorm8!="")){ if(($sr14>=0)and($sr14<10)){ echo "0".$sr14; }else{ echo $sr14;} } if(($valorm8!="") and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm8==NULL) and ($valorm9==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm10!=""){ if(($sr10>=0)and($sr10<10)){ echo "0".$sr10; }else{ echo $sr10;} } if(($valorm14!="") and ($valorm10==NULL) and ($valorm9!="")){if(($sr14>=0)and($sr14<10)){ echo "0".$sr14; }else{ echo $sr14;} } if(($valorm9!="") and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm9==NULL) and ($valorm10==NULL) and ($valorm14!="")){ echo "*"; }?></td>



		<td class="cuadrito"><?php if($valorm11!=""){ if(($sr11>=0)and($sr11<10)){ echo "0".$sr11; }else{ echo $sr11;} } if(($valorm14!="") and ($valorm11==NULL) and ($valorm10!="")){ if(($sr14>=0)and($sr14<10)){ echo "0".$sr14; }else{ echo $sr14;} } if(($valorm10!="") and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm10==NULL) and ($valorm11==NULL) and ($valorm14!="")){ echo "*"; }?></td>

		<td class="cuadrito"><?php if($valorm12!=""){ if(($sr12>=0)and($sr12<10)){ echo "0".$sr12; }else{ echo $sr12;} } if(($valorm14!="") and ($valorm12==NULL) and ($valorm11!="")){ if(($sr14>=0)and($sr14<10)){ echo "0".$sr14; }else{ echo $sr14;} } if(($valorm11!="") and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm11==NULL) and ($valorm12==NULL) and ($valorm14!="")){ echo "*"; }?></td>


		<td class="cuadrito"><?php if($valorm13!=""){ if(($sr13>=0)and($sr13<10)){ echo "0".$sr13; }else{ echo $sr13;} } if(($valorm14!="") and ($valorm13==NULL) and ($valorm12!="")){ if(($sr14>=0)and($sr14<10)){ echo "0".$sr14; }else{ echo $sr14;} } if(($valorm12!="") and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14==NULL)){ echo "*"; } if(($valorm12==NULL) and ($valorm13==NULL) and ($valorm14!="")){ echo "*"; }?></td>

*/?>


		<td colspan="5"> &nbsp; </td>
	</tr>

	<tr>
		<td class="cuadrito"><b>No.</b></td>
		<td colspan="4"><b>Apellidos</b></td>
		<td colspan="7"><b>Nombres</b></td>
		<td colspan="5"><b>Lugar de Nacimiento</b></td>
		<td class="cuadrito"><b>E.F.</b></td>
		<td class="cuadrito"><b>Sexo</b></td>
		<td colspan="3"><b>Fecha de Nac</b></td>
	</tr>

	<?php $no=1; do { ?>
	<tr>
		<td><?php echo $no;?></td>
		<td colspan="4" style="text-align:left;">&nbsp;&nbsp;<a href="../../../modules/acciones/datos_alumno_resumen.php?alumno_id=<?php echo $row_resumen_alumno['alumno_id'];?>" target="_blank" class="nyroModal"><?php echo $row_resumen_alumno['apellido'];?></a></td>
		<td colspan="7"style="text-align:left;">&nbsp;&nbsp;<?php echo $row_resumen_alumno['nombre'];?></td>

		<td colspan="5" style="text-align:left;">&nbsp;&nbsp;<?php echo $row_resumen_alumno['lugar_nacimiento'];?></td>
		<td style="text-align:left;">&nbsp;&nbsp;<?php echo $row_resumen_alumno['ef'];?></td>
		<td style="text-align:center;">&nbsp;&nbsp;<?php echo $row_resumen_alumno['sexo'];?></td>
			<?php
			$fecha = $row_resumen_alumno['fecha_nacimiento'];
			$ano = substr($fecha, -10, 4);
			$mes = substr($fecha, -5, 2);
			$dia = substr($fecha, -2, 2);
			?> 
		<td><?php echo $dia;?></td>
		<td><?php echo $mes;?></td>
		<td><?php echo $ano;?></td>

	</tr>
	<?php $no++;} while ($row_resumen_alumno = mysql_fetch_assoc($resumen_alumno)); ?>

	<tr>
	<?php if($no<=13){ $no=$totalRows_resumen_alumno+1; $tr=13; do { ?>
	<tr>
		<td class="cuadrito"><?php echo $no; ?></td>
		<td colspan="4" >**********</td>
		<td colspan="7">**********</td>
		<td colspan="5" >**********</td>
		<td >**</td>
		<td >**</td>
		<td>**</td>
		<td>**</td>
		<td>**</td>

	</tr>
	<?php $no++; } while($no <= $tr);} ?>
	
		<td class="cuadrito">&nbsp;</td>
		<td colspan="4"><b>Asignaturas</b></td>
		<td colspan="7"><b>Apellidos y Nombres del Profesor</b></td>
		<td colspan="3"><b>C.I.</b></td>
		<td colspan="3"><b>FIRMA</b></td>
		<td colspan="4" rowspan="16" >

		<table style="border:0px; "><tr>
			<td style="height:0.84cm;  border-width: 0 0 1px 0;"><b>IV. Identificaci&oacute;n del Curso</b></td>
		</tr>
		<tr>
			<td style="text-align:left; font-size:7pt;border-width: 0 0 1px 0; height:0.4cm">&nbsp;MENCION</td>
		</tr>
		<tr>
			<td style="height:0.4cm; border-width: 0 0 1px 0;"><span style="font-size:6pt"><?php if ($men=="") { echo "*******";} else { echo $men;} ?></span></td>
		</tr>
		<tr>
			<td style="height:0.4cm;border-width: 0 0 1px 0;">&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:left; font-size:7pt; height:0.4cm;border-width: 0 0 1px 0;">&nbsp;GRADO O A&Ntilde;O:</td>
		</tr>
		<tr>
			<td style="height:0.4cm;border-width: 0 0 1px 0;" ><?php if($row_seccion['orden_resumen']==1){echo "1er";} if($row_seccion['orden_resumen']==2){echo "2do";} if($row_seccion['orden_resumen']==3){echo "3er";} if($row_seccion['orden_resumen']==4){echo "4to";} if($row_seccion['orden_resumen']==5){echo "5to";}?></td>
		</tr>
		<tr>
			<td style="text-align:left; font-size:7pt; height:0.4cm;border-width: 0 0 1px 0;">&nbsp;SECCION:</td>
		</tr>
		<tr>
			<td style="height:0.4cm;border-width: 0 0 1px 0;" >"U"</td>
		</tr>
		<tr>
			<td style="text-align:left; font-size:7pt; height:0.4cm;border-width: 0 0 1px 0;">&nbsp;No. ESTUDIANTES</td>
		</tr>
		<tr>
			<td  style="text-align:left; font-size:7pt; height:0.4cm;border-width: 0 0 1px 0;">&nbsp;EN ESTA PAGINA:</td>
		</tr>
		<tr>
			<td style="height:0.42cm;border-width: 0 0 1px 0;" ><?php if($totalRows_resumen<10){echo "0".$totalRows_resumen;}else{echo $totalRows_resumen;} ?></td>
		</tr>
		<tr>
			<td  style="text-align:left; font-size:7pt; height:0.4cm;border-width: 0 0 1px 0;">&nbsp;TOTAL ESTUDIANTES</td>
		</tr>
		<tr>
			<td  style="text-align:left; font-size:7pt; height:0.4cm;border-width: 0 0 1px 0;">&nbsp;DE LA SECCION:</td>
		</tr>
		<tr>
			<td style="height:0.4cm;border-width: 0 0 0px 0px;" ><?php if($totalRows_alumno_seccion<10){echo "0".$totalRows_alumno_seccion;} if($totalRows_alumno_seccion>9){echo $totalRows_alumno_seccion;}?></td>
		</tr>
	</table>
	</tr>
	
	<?php $no=1; do { ?>
	<tr>
		<td class="cuadrito"><?php echo $no; ?></td>
		<td colspan="4" style="text-align:left;font-size:6pt; ">&nbsp;<a href="../../../modules/acciones/datos_docentes_resumen.php?id=<?php echo $row_verdocentes['id'];?>" target="_blank" class="nyroModal"><?php echo $row_verdocentes['nombre_mate']; ?></a></td>
		<?php if($row_verdocentes['apellido_docente']=="****"){ ?>
		<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }else{?>
		
		<?php 
		if($no==1){ // pasando por la base de datos			
		if($sm1>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else { ?>
		<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		      } // fin de comprobacion
		?>
		
		<?php 
		if($no==2){ // pasando por la base de datos			
		if($sm2>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		<?php 
		if($no==3){ // pasando por la base de datos			
		if($sm3>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>		
		
		<?php 
		if($no==4){ // pasando por la base de datos			
		if($sm4>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		<?php 
		if($no==5){ // pasando por la base de datos			
		if($sm5>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		<?php 
		if($no==6){ // pasando por la base de datos			
		if($sm6>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		
		<?php 
		if($no==7){ // pasando por la base de datos			
		if($sm7>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		<?php 
		if($no==8){ // pasando por la base de datos			
		if($sm8>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		<?php 
		if($no==9){ // pasando por la base de datos			
		if($sm9>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
<?php 
		if($no==10){ // pasando por la base de datos			
		if(($sm10>0) or ($sm14>0)) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>		
		
		<?php 
		if($no==11){ // pasando por la base de datos			
		if(($sm11>0) or ($sm14>0)) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>
		
		<?php 
		if($no==12){ // pasando por la base de datos			
		if(($sm12>0) or ($sm14>0)) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>		
		
		<?php 
		if($no==13){ // pasando por la base de datos			
		if(($sm13>0) or ($sm14>0)) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>

		<?php 
		if($no==14){ // pasando por la base de datos			
		if($sm14>0) { // comprobando existencia de docentes
		?>
		<td colspan="7" style="text-align:left; ">&nbsp;<?php echo $row_verdocentes['apellido_docente'].", ".$row_verdocentes['nombre_docente']; ?></td>
		<td colspan="3" style="text-align:left; ">&nbsp;<?php echo "V-".$row_verdocentes['cedula_docente']; ?></td>	
		<td colspan="3">&nbsp;</td>
		<?php 
		} else {
	?>	<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>
		<?php }// fin de recorrido   
		} // fin de comprobacion
		?>		
		
		
		<?php }?>
	</tr>
	<?php $no++; } while ($row_verdocentes = mysql_fetch_assoc($verdocentes)); ?>
	
	<?php if($no<16){ $no=$totalRows_verdocentes+1; $tr=15; do { ?>
	<tr>
		<td class="cuadrito"><?php echo $no; ?></td>
		<td colspan="4">*************</td>
		<td colspan="7">*************</td>
		<td colspan="3">*************</td>
		<td colspan="3">*************</td>

	</tr>
	<?php $no++; } while($no <= $tr); }?>

	<tr>
		<td colspan="22" style="text-align:left; font-size:9pt;">&nbsp;<b>V. Programas cursados en Educaci&oacute;n para el Trabajo/ horas-Estudiantes Semanales de C/uno</b></td>
	</tr>

	<tr>
		<td class="cuadrito">1.</td>
		
		<?php if(($sm10)>0 or ($sm14)>0) {  // comprobando existencia 
		?>
		<?php if($totalRows_mate_ept1>0) {?>
		<td colspan="8" style="text-align:left; font-size:8pt;">&nbsp;<?php echo $row_mate_ept1['descripcion'];?></td>
		<td class="cuadrito"><?php echo $row_mate_ept1['horas_clase'];?></td>	
		<?php }else{ ?>
		<td colspan="8">*</td>
		<td class="cuadrito">*</td>
		<?php }?>
		<?php } else { ?>
		<td colspan="8">*</td>
		<td class="cuadrito">*</td>
		<?php } // fin comprobacion
	   ?>
	   
	   
		<td class="cuadrito">3.</td>
		
		<?php if(($sm10)>0 or ($sm14)>0) { // comprobando existencia 
		?>
		<?php if($totalRows_mate_ept3>0) {?>
		<td colspan="10" style="text-align:left; font-size:8pt;">&nbsp;<?php echo $row_mate_ept3['descripcion'];?></td>
		<td class="cuadrito"><?php echo $row_mate_ept3['horas_clase'];?></td>
		<?php }else{ ?>
		<td colspan="10">*</td>
		<td class="cuadrito">*</td>
		<?php }?>
				<?php } else { ?>
		<td colspan="10">*</td>
		<td class="cuadrito">*</td>
		<?php } // fin comprobacion
	   ?>

	</tr>
	<tr>

		<td class="cuadrito">2.</td>
		
		<?php if(($sm10)>0 or ($sm14)>0) { // comprobando existencia 
		?>
		<?php if($totalRows_mate_ept2>0) {?>
		<td colspan="8" style="text-align:left; font-size:8pt;">&nbsp;<?php echo $row_mate_ept2['descripcion'];?></td>
		<td class="cuadrito"><?php echo $row_mate_ept2['horas_clase'];?></td>
		<?php }else{ ?>
		<td colspan="8" >*</td>
		<td class="cuadrito">*</td>
		<?php }?>
		<?php } else { ?>
		<td colspan="8">*</td>
		<td class="cuadrito">*</td>
		<?php } // fin comprobacion
	   ?>
		
		<td class="cuadrito">4.</td>
		
		<?php if(($sm10)>0 or ($sm14)>0) { // comprobando existencia 
		?>
		<?php if($totalRows_mate_ept4>0) {?>
		<td colspan="10" style="text-align:left; font-size:8pt;">&nbsp;<?php echo $row_mate_ept4['descripcion'];?></td>
		<td class="cuadrito"><?php echo $row_mate_ept4['horas_clase'];?></td>
		<?php }else{ ?>
		<td colspan="10">*</td>
		<td class="cuadrito">*</td>
		<?php }?>
		<?php } else { ?>
		<td colspan="10">*</td>
		<td class="cuadrito">*</td>
		<?php } // fin comprobacion
	   ?>

	</tr>
		
</table>

<div id="observaciones">
	<div class="lineas">
	<b>VI. Observaciones:</b>&nbsp;&nbsp;&nbsp;<?php if($totalRows_observacion>0){ echo $row_observacion['observacion'];}else { echo "*************";} ?> 
	</div>
	<div class="lineas">
	</div>
	<div class="lineas">
	</div>

</div>


<div id="central_sellos">
	<div class="marco">
		<div class="titulo">
		<b>VII. Fecha de Remisi&oacute;n</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_fecham['fecha_completa'];?>
		</div>
		<div class="sello">
			<div class="cuadro_mediano">
			<b>Director(a)</b>
			</div>
			<div class="cuadro_mediano">
			Apellidos y Nombres
			</div>
			<div class="nombre_director"><br />
			<CENTER>
			<?php echo $row_institucion['apellido_director'].", ".$row_institucion['nombre_director'];?>
			</CENTER>
			</div>
			<div class="cuadro_mediano">
			N&uacute;mero de C.I.:			
			</div>
			<div class="cuadro_mediano">
			<CENTER>
			V-<?php echo $row_institucion['cedula_director'];?>
			</CENTER>
			</div>
			<div class="cuadro_mediano">
			Firma
			</div>
			<div class="firma">
			</div>
		</div>
		<div class="sello" style="text-align:center;">
		<br />
		<br />
		<br />
		<br />

		SELLO DEL <br />PLANTEL
		</div>
	</div>
	<div class="separacion">
	</div>
		<div class="marco">
		<div class="titulo">
		<b>VIII. Fecha de Recepci&oacute;n</b>
		</div>
		<div class="sello">
			<div class="cuadro_mediano">
			<b>Funcionario(a) Receptor(a)</b>
			</div>
			<div class="cuadro_mediano">
			Apellidos y Nombres
			</div>
			<div class="nombre_director">
			</div>
			<div class="cuadro_mediano">
			N&uacute;mero de C.I.:			
			</div>
			<div class="cuadro_mediano">
			</div>
			<div class="cuadro_mediano">
			Firma
			</div>
			<div class="firma">
			</div>
		</div>
		<div class="sello" style="text-align:center;">
		<br />
		<br />
		<br />
		<br />
		SELLO DE LA ZONA <br />EDUCATIVA
		</div>
	</div>
	


</div>




</div>


</div>



<?php } }?>

</body>
</center>
</html>
<?php

mysql_free_result($usuario);
//mysql_free_result($supervisor);
//mysql_free_result($planestudio);
mysql_free_result($institucion);

//mysql_free_result($alumno);
//mysql_free_result($plantelcurso1);
//mysql_free_result($plantelcurso2);
//mysql_free_result($plantelcurso3);
//mysql_free_result($plantelcurso4);
//mysql_free_result($plantelcurso5);

mysql_free_result($fecham);


?>
