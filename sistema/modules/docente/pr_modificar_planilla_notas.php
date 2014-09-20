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








// corregir
$fecha1= $_POST['ano1']."-".$_POST['mes1']."-".$_POST['dia1'];
$fecha2= $_POST['ano2']."-".$_POST['mes2']."-".$_POST['dia2'];
$fecha3= $_POST['ano3']."-".$_POST['mes3']."-".$_POST['dia3'];
$fecha4= $_POST['ano4']."-".$_POST['mes4']."-".$_POST['dia4'];
//corregir


// CONSULTA SQL

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso ");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$colname_docente = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_docente = $_GET['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.name, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id  FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id AND c.id = %s", GetSQLValueString($colname_docente, "int"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

// CONSULTA POR GET

$colname_confiplanilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_confiplanilla = $_GET['asignatura_id'];
}
$lap_confiplanilla = "-1";
if (isset($_GET['lapso'])) {
  $lap_confiplanilla = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla_primaria  WHERE asignatura_id = %s  AND lapso=%s ", GetSQLValueString($colname_confiplanilla, "int"), GetSQLValueString($lap_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);




//FIN CONSULTA
// ACTUALIZACION DE CLAVE

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  $updateSQL = sprintf("UPDATE jos_formato_evaluacion_planilla_primaria SET no_semanas=%s, nombre_proyecto=%s, dia_laborados=%s, desde=%s, hasta=%s, fecha_entrega=%s WHERE id=%s",
							GetSQLValueString($_POST['no_semanas'], "int"),
							GetSQLValueString($_POST['nombre_proyecto'], "text"),
							GetSQLValueString($_POST['dia_laborados'], "int"),
							GetSQLValueString($_POST['desde'], "date"),
							GetSQLValueString($_POST['hasta'], "date"),
							GetSQLValueString($_POST['fecha_entrega'], "date"),
							GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "pr_verificar_planilla_notas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
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
<?php if ($row_docente['gid']==19){ // INICIO DE LA RESTRICCION DE SESIONES ?>

<table width="680" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

<?php // CUANDO LA PLANILLA EXISTE PARA EL LAPSO

if(($_GET['asignatura_id']==$row_confiplanilla['asignatura_id']) and ($_GET['lapso']==$row_confiplanilla['lapso'])) { ?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Configurar Planilla de Calificaciones</h2>
<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
<table>
<tr>
<td>

</td></tr>
<tr><td><span class="texto_mediano_gris"><b>Asignatura:</b> <?php echo $row_docente['nombre']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>A&ntilde;o y Secci&oacute;n:</b> <?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Docente:</b> <?php echo $row_docente['name']; ?></span></td></tr>
</table>
</fieldset >
<fieldset >
<legend><strong><em>Configuraci&oacute;n de la Planilla</em></strong> </legend>
<table>
<tr>
<tr><td><span class="texto_mediano_gris"><b>No. Semanas:</tr><td> </b> <input class="texto_mediano_gris" name="no_semanas" type="text" id="no_semanas" size="3" value="<?php echo $row_confiplanilla['no_semanas']; ?>"></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Nombre del Proyecto:</tr><td> </b><input class="texto_mediano_gris" name="nombre_proyecto" type="text" size="60" id="nombre_proyecto" value="<?php echo $row_confiplanilla['nombre_proyecto']; ?>"> </span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Dias Laborados:</tr><td> </b> <input class="texto_mediano_gris" name="dia_laborados" type="text" size="3" id="dia_laborados" value="<?php echo $row_confiplanilla['dia_laborados']; ?>"></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Desde:</tr><td> </b> <input class="texto_mediano_gris" name="desde" type="text" id="desde" size="10" value="<?php echo $row_confiplanilla['desde']; ?>"/></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Hasta:</tr><td> </b><input class="texto_mediano_gris" name="hasta" type="text" id="hasta" size="10" value="<?php echo $row_confiplanilla['hasta']; ?>"> </span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Entrega:</tr><td> </b> <input class="texto_mediano_gris" name="fecha_entrega"  size="10" type="text" id="fecha_entrega" value="<?php echo $row_confiplanilla['fecha_entrega']; ?>"></span></td></tr>

</td></tr>
<tr><td>
</td></tr>
<tr><td>

	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_GET['asignatura_id']; ?>">
	<input name="id" type="hidden" id="id" value="<?php echo $row_confiplanilla['id']; ?>">



</td><tr>
</table>
</fieldset >
<br />

	<input class="texto_mediano_gris" type="submit" name="buttom" value="Modificar Datos>" />
	<input type="hidden" name="MM_update" value="form1">
</form>
<?php } // FIN DE LA CONSULTA

?>

	
 <tr><td>
   &nbsp;&nbsp;
 </td></tr>
</table>

<?php } //FIN DE LA RESTRICCION DE SESIONES
?>
</body>
</center>
</html>
<?php

mysql_free_result($docente);

mysql_free_result($lapso);

mysql_free_result($periodo);

mysql_free_result($confiplanilla);

?>
