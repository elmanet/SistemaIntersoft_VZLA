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

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confi = mysql_query($query_confi, $sistemacol) or die(mysql_error());
$row_confi = mysql_fetch_assoc($confi);
$totalRows_confi = mysql_num_rows($confi);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso ");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);
$lapso_curso=$row_lap['cod'];

$colname_docente = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_docente = $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.name, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id, c.tipo_asignatura  FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id AND c.id = %s", GetSQLValueString($colname_docente, "int"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

// CONSULTA POR POST

$colname_confiplanilla = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_confiplanilla = $_POST['asignatura_id'];
}
$lap_confiplanilla = "-1";
if (isset($_POST['lapso'])) {
  $lap_confiplanilla = $_POST['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE lapso = %s AND asignatura_id = %s", GetSQLValueString($lap_confiplanilla, "int"), GetSQLValueString($colname_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);

mysql_select_db($database_sistemacol, $sistemacol);
$query_tipofl = sprintf("SELECT * FROM jos_formato_evaluacion_tfinal" , GetSQLValueString($colname_tipofl, "int"));
$tipofl = mysql_query($query_tipofl, $sistemacol) or die(mysql_error());
$row_tipofl = mysql_fetch_assoc($tipofl);
$totalRows_tipofl = mysql_num_rows($tipofl);
$tipofl=$row_tipofl['cod'];

//FIN CONSULTA

// 	GRABADO EN LA TABLA 

$pruebas= $_POST['cant_pruebas'];
$po1=$_POST['p1'];
$po2=$_POST['p2'];
$po3=$_POST['p3'];
$po4=$_POST['p4'];
$po5=$_POST['p5'];
$po6=$_POST['p6'];
$tipofl=$_POST['tipofl'];
$confip=$_POST['confip'];
$totalporcentaje=($po1+$po2+$po3+$po4+$po5+$po6);
if(($tipofl==0) and ($confip=="nor01")) {
$valorpor=100;
}
if(($tipofl==1) and ($confip=="nor01")) {
$valorpor=100;
}
if ((!empty($pruebas)) and ($totalporcentaje==$valorpor)) { 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha1= $_POST['ano1']."-".$_POST['mes1']."-".$_POST['dia1'];
$fecha2= $_POST['ano2']."-".$_POST['mes2']."-".$_POST['dia2'];
$fecha3= $_POST['ano3']."-".$_POST['mes3']."-".$_POST['dia3'];
$fecha4= $_POST['ano4']."-".$_POST['mes4']."-".$_POST['dia4'];
$fecha5= $_POST['ano5']."-".$_POST['mes5']."-".$_POST['dia5'];

//corregir

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

   $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_planilla (id, asignatura_id, lapso, nombre_proyecto, cant_pruebas, isc1, isc2, isc3, isc4, p1, p2, p3, p4, p5, p6, info1, tipo_eva1, fecha1, info2, tipo_eva2, fecha2, info3, tipo_eva3, fecha3, info4, tipo_eva4, fecha4, info5, tipo_eva5, fecha5) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['asignatura_id'], "int"),
							GetSQLValueString($_POST['lapso'], "int"),
							GetSQLValueString($_POST['nombre_proyecto'], "text"),
							GetSQLValueString($_POST['cant_pruebas'], "int"),
							GetSQLValueString($_POST['isc1'], "text"),
							GetSQLValueString($_POST['isc2'], "text"),
							GetSQLValueString($_POST['isc3'], "text"),
							GetSQLValueString($_POST['isc4'], "text"),
							GetSQLValueString($_POST['p1'], "int"),
							GetSQLValueString($_POST['p2'], "int"),
							GetSQLValueString($_POST['p3'], "int"),
							GetSQLValueString($_POST['p4'], "int"),
							GetSQLValueString($_POST['p5'], "int"),
							GetSQLValueString($_POST['p6'], "int"),
                                                        GetSQLValueString($_POST['info1'], "text"),
							GetSQLValueString($_POST['tipo_eva1'], "text"),
							GetSQLValueString($fecha1, "date"),
							GetSQLValueString($_POST['info2'], "text"),
							GetSQLValueString($_POST['tipo_eva2'], "text"),
							GetSQLValueString($fecha2, "date"),
							GetSQLValueString($_POST['info3'], "text"),
							GetSQLValueString($_POST['tipo_eva3'], "text"),
							GetSQLValueString($fecha3, "date"),
							GetSQLValueString($_POST['info4'], "text"),
							GetSQLValueString($_POST['tipo_eva4'], "text"),
							GetSQLValueString($fecha4, "date"),
                                                        GetSQLValueString($_POST['info5'], "text"),
							GetSQLValueString($_POST['tipo_eva5'], "text"),
							GetSQLValueString($fecha5, "date"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "seleccionar_anio_carga_notas2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 header(sprintf("Location: %s", $insertGoTo));
}

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
<?php if ($row_docente['tipo_asignatura']=='primaria'){ ?>

<br />
<br />
<center>
<img src="../../images/pngnew/biblioteca-icono-3766-128.png"/><br />
<span class="texto_grande_gris">Agregar Descripci&oacute;n cualitativa</span> <br /><span class="texto_mediano_gris">Lapso en curso: <b><?php echo $_POST['lapso']; ?> Lapso</b></span>
<br />
<br />
<form action="boletin_primaria_des1.php" method="POST" name="form_des" target="_blank">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_POST['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input class="texto_grande_gris" type="submit" name="buttom" value="Continuar >" />

</form>
</center>

<?php }else {?>


<table width="680" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top"><h3>Configurar Planilla de Calificaciones </h3>

<?php // CUANDO LA PLANILLA EXISTE PARA EL LAPSO

if(($_POST['asignatura_id']==$row_confiplanilla['asignatura_id']) and ($_POST['lapso']==$row_confiplanilla['lapso'])) { ?>

<table>
<tr><td>
        <h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Informaci&oacute;n de calificaciones</h2>
</td></tr>
<tr><td><span class="texto_mediano_gris"><b>Asignatura:</b> <?php echo $row_docente['nombre']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>A&ntilde;o y Secci&oacute;n:</b> <?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Docente:</b> <?php echo $row_docente['name']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Nombre del Proyecto:</b> <?php echo $row_confiplanilla['nombre_proyecto']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Cantidad de Pruebas:</b> <?php echo $row_confiplanilla['cant_pruebas']; ?></span></td></tr>

<tr><td><span class="texto_mediano_gris"><b>Porcentaje #1:</b> <?php echo $row_confiplanilla['p1']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Porcentaje #2:</b> <?php echo $row_confiplanilla['p2']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Porcentaje #3:</b> <?php echo $row_confiplanilla['p3']; ?></span></td></tr>

<?php if ($row_confiplanilla['cant_pruebas']==4) { ?>
    <?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="bol02") or ($row_confi['codfor']=="nor01"))  { ?>
    <tr><td><span class="texto_mediano_gris"><b>Porcentaje #4:</b> <?php echo $row_confiplanilla['p4']; ?></span></td></tr>
    <?php }?>
    <?php if ($row_confi['codfor']=="nor02")  { ?>
     <tr><td><span class="texto_mediano_gris"><b>Porcentaje Indicador:</b> <?php echo $row_confiplanilla['p6']; ?></span></td></tr>
    <?php }?>
<?php }?>

<?php if ($row_confiplanilla['cant_pruebas']==5)  { ?>
    <?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="bol02") or ($row_confi['codfor']=="nor01"))  { ?>
    <tr><td><span class="texto_mediano_gris"><b>Porcentaje #4:</b> <?php echo $row_confiplanilla['p4']; ?></span></td></tr>
    <tr><td><span class="texto_mediano_gris"><b>Porcentaje #5:</b> <?php echo $row_confiplanilla['p5']; ?></span></td></tr>
    <?php }?>
    <?php if ($row_confi['codfor']=="nor02")  { ?>
    <tr><td><span class="texto_mediano_gris"><b>Porcentaje #4:</b> <?php echo $row_confiplanilla['p4']; ?></span></td></tr>
    <tr><td><span class="texto_mediano_gris"><b>Porcentaje Indicador:</b> <?php echo $row_confiplanilla['p6']; ?></span></td></tr>
    <?php }?>
<?php }?>

<?php if ($row_confiplanilla['cant_pruebas']==6) { ?>
<tr><td><span class="texto_mediano_gris"><b>Porcentaje #4:</b> <?php echo $row_confiplanilla['p4']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Porcentaje #5:</b> <?php echo $row_confiplanilla['p5']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Porcentaje Indicador:</b> <?php echo $row_confiplanilla['p6']; ?></span></td></tr>
<?php }?>


<?php if ($row_confi['codfor']=="bol01"){?>
<tr><td><span class="texto_mediano_gris"><b>Indicador #1:</b> <?php echo $row_confiplanilla['isc1']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Indicador #2:</b> <?php echo $row_confiplanilla['isc2']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Indicador #3:</b> <?php echo $row_confiplanilla['isc3']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Indicador #4:</b> <?php echo $row_confiplanilla['isc4']; ?></span></td></tr>
<?php }?>

<?php if (($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Rasgo Personalidad #1:</b> <?php echo $row_confiplanilla['isc1']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Rasgo Personalidad #2:</b> <?php echo $row_confiplanilla['isc2']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Rasgo Personalidad #3:</b> <?php echo $row_confiplanilla['isc3']; ?></span></td></tr>

<?php }?>

<tr><td>
<fieldset>
<legend> Informaci&oacute;n Evaluaci&oacute;n 1</legend>
<table><tr>
<td><span class="texto_mediano_gris"><b>Informaci&oacute;n:</b> <?php echo $row_confiplanilla['info1']; ?></span></td></tr>
<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01")  or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Tipo Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['tipo_eva1']; ?></span></td></tr>
<?php }?>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['fecha1']; ?></span></td>
</tr></table>
</fieldset>
</td></tr>


<tr><td>
<fieldset>
<legend> Informaci&oacute;n Evaluaci&oacute;n 2</legend>
<table><tr>
<td><span class="texto_mediano_gris"><b>Informaci&oacute;n:</b> <?php echo $row_confiplanilla['info2']; ?></span></td></tr>
<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Tipo Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['tipo_eva2']; ?></span></td></tr>
<?php }?>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['fecha2']; ?></span></td></tr>
</table>
</fieldset>
</td></tr>

<tr><td>
<fieldset>
<legend> Informaci&oacute;n Evaluaci&oacute;n 3</legend>
<table>
    <tr><td><span class="texto_mediano_gris"><b>Informaci&oacute;n:</b> <?php echo $row_confiplanilla['info3']; ?></span></td></tr>
<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01")  or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Tipo Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['tipo_eva3']; ?></span></td></tr>
<?php }?>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['fecha3']; ?></span></td></tr>
</table>
</fieldset>
</td></tr>

<?php if ($row_confiplanilla['cant_pruebas']==4) { ?>
<tr><td>
<fieldset>
<legend> Informaci&oacute;n Evaluaci&oacute;n 4</legend>
<table>
<tr><td><span class="texto_mediano_gris"><b>Informaci&oacute;n:</b> <?php echo $row_confiplanilla['info4']; ?></span></td></tr>
<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Tipo Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['tipo_eva4']; ?></span></td></tr>
<?php }?>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['fecha4']; ?></span></td></tr>
</table>
</fieldset>
</td></tr>
<?php }?>


<?php if ($row_confiplanilla['cant_pruebas']>=5) { ?>
<tr><td>
<fieldset>
<legend> Informaci&oacute;n Evaluaci&oacute;n 4</legend>
<table>
<tr><td><span class="texto_mediano_gris"><b>Informaci&oacute;n:</b> <?php echo $row_confiplanilla['info4']; ?></span></td></tr>
<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01")  or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Tipo Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['tipo_eva4']; ?></span></td></tr>
<?php }?>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['fecha4']; ?></span></td></tr>
</table>
</fieldset>
</td></tr>

<tr><td>
<fieldset>
<legend> Informaci&oacute;n Evaluaci&oacute;n 5</legend>
<table>
<tr><td><span class="texto_mediano_gris"><b>Informaci&oacute;n:</b> <?php echo $row_confiplanilla['info5']; ?></span></td></tr>
<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
<tr><td><span class="texto_mediano_gris"><b>Tipo Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['tipo_eva5']; ?></span></td></tr>
<?php }?>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Evaluaci&oacute;n:</b> <?php echo $row_confiplanilla['fecha5']; ?></span></td></tr>
</table>
</fieldset>
</td></tr>


<?php }?>


<tr><td>
<form action="carga_notas_<?php echo $row_confi['codfor'];?>.php" method="POST" name="form_enviar" target="_blank">

	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_POST['asignatura_id']; ?>">
	<input name="curso_id" type="hidden" id="curso_id" value="<?php echo $row_docente['curso_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input name="confiplanilla_id" type="hidden" id="confiplanilla_id" value="<?php echo $row_confiplanilla['id']; ?>">
	<input class="texto_grande_gris" type="submit" name="buttom" value="Cargar Calificaciones>" />

</form>
</td></tr>
<tr><td>
<form action="modificar_planilla_notas.php" method="POST" name="form_modificar">

	<input name="id" type="hidden" id="id" value="<?php echo $row_confiplanilla['id']; ?>">


	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_POST['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Modificar Datos>" />

</form>
</td><tr>
</table>

<?php } // FIN DE LA CONSULTA

?>

<?php // CUANDO NO EXITE PARA ESTE LAPSO

if(($_POST['asignatura_id']==$row_confiplanilla['asignatura_id']) and ($_POST['lapso']!=$row_confiplanilla['lapso'])) {?>

<table><tr><td>
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
	<span class="texto_mediano_gris"><b>Asignatura:</b> <?php echo $row_docente['nombre']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>A&ntilde;o y Secci&oacute;n:</b> <?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Docente:</b> <?php echo $row_docente['name']; ?></span>
	</td></tr>	   
	<tr><td>
	<span class="texto_mediano_gris"><b>Nombre del Proyecto:</b></span>
	<input name="nombre_proyecto" type="text" id="nombre_proyecto" value="">
	</td></tr>
<tr><td align="left">
<?php if(($row_tipofl['cod']==0) and ($row_confi['codfor']=="nor01")) { ?>
<h2>Calcular las Calificaciones Parciales a 100%</h2>
<?php } ?>
Cantidad de Evaluaciones y Ponderaciones: 
</td></tr>
<tr><td>
       <select name="cant_pruebas" id="cant_pruebas">
             <option value="">Cant</option>
	     <option value="3">3</option>
	     <option value="4">4</option>
             <?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
             <option value="5">5</option>
             <?php } ?>
             <?php if ($row_confi['codfor']=="nor02"){?>
             <option value="6">6</option>
             <?php } ?>
        </select>
        <?php if ($row_confi['codfor']=="nor02"){?>
         <h4>Recuerda que en la cantidad de Evaluaciones debes tomar en cuenta la evaluci&oacute;n del indicador </h4>
        <?php } ?>
       <select name="p1" id="p1">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
        </select>

       <select name="p2" id="p2">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>>
        </select>

       <select name="p3" id="p3">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>

        </select>

       <select name="p4" id="p4">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
	     <option value="50">50%</option>
        </select>

        <?php if (($row_confi['codfor']=="nor01")or($row_confi['codfor']=="nor02")){?>
          <select name="p5" id="p5">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
	     <option value="50">50%</option>
         </select>
        <?php } ?>

        <?php if ($row_confi['codfor']=="nor02"){?>
         <input type="text" name="p6" id="p6" size="2" readonly="readonly" value="20" class="texto_mediano_gris"/> %
        <?php } ?>

</td></tr>

<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #1:</b></span>
	<input class="texto_mediano_gris" name="isc1" type="text" id="isc1" value=""/>
	</td></tr>
<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc1" type="hidden" id="isc1" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #1:</b></span>
	<input class="texto_mediano_gris" name="isc1" type="text" id="isc1" value="">
	</td></tr>
<?php }?>


<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #2:</b></span>
	<input class="texto_mediano_gris" name="isc2" type="text" id="isc2" value="">
	</td></tr>

<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc2" type="hidden" id="isc2" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #2:</b></span>
	<input class="texto_mediano_gris" name="isc2" type="text" id="isc2" value="">
	</td></tr>
<?php }?>



<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #3:</b></span>
	<input class="texto_mediano_gris" name="isc3" type="text" id="isc3" value="">
	</td></tr>
<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc3" type="hidden" id="isc3" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #3:</b></span>
	<input class="texto_mediano_gris" name="isc3" type="text" id="isc3" value="">
	</td></tr>
<?php }?>


<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #4:</b></span>
	<input class="texto_mediano_gris" name="isc4" type="text" id="isc4" value="">
	</td></tr>
<?php }?>

<?php if (($row_confi['codfor']=="bol02") or ($row_confi['nor01'])or ($row_confi['codfor']=="nor02")){?>
	<input name="isc4" type="hidden" id="isc4" value=""/>

<?php } ?>


 <tr><td>
 <fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 1</b></legend>
<table>
<tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 1era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info1"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
                <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 1:</span>
                        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva1" type="text" id="tipo_eva1" value="">
	</td></tr>
<?php }else{?>
		<input class="texto_mediano_gris" name="tipo_eva1" type="hidden" id="tipo_eva1" value="">
<?php } ?>


<tr><td align="left" class="texto_mediano_gris">Fecha de la 1era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia1" id="dia1">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>


             </select>
             <select name="mes1" id="mes1">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano1" id="ano1">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>

</td></tr>
 </table>
</fieldset>
</td></tr>

 <tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 2</b></legend>
<table>

<tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 2da. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info2"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
                <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 2:</span>
                        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva2" type="text" id="tipo_eva2" value="">
	</td></tr>
<?php }else{?>
		<input class="texto_mediano_gris" name="tipo_eva2" type="hidden" id="tipo_eva2" value="">
<?php } ?>

<tr>
<td align="left" class="texto_mediano_gris">Fecha de la 2da. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia2" id="dia2">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes2" id="mes2">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano2" id="ano2">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>

</td></tr>
 </table>
</fieldset>
</td></tr>


<tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 3</b></legend>
<table>

 <tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 3era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info3"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 3:</span>
                </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva3" type="text" id="tipo_eva3" value="">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva3" type="hidden" id="tipo_eva3" value="">
<?php } ?>

<tr>
<td align="left" class="texto_mediano_gris">Fecha de la 3era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia3" id="dia3">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes3" id="mes3">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano3" id="ano3">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>

</td></tr>
 </table>
</fieldset>
</td></tr>


<tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 4</b></legend>
<table>

    <tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 4ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info4"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
                <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 4:</span>
                        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva4" type="text" id="tipo_eva4" value="">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva4" type="hidden" id="tipo_eva4" value="">
<?php } ?>

<tr>
<td align="left" class="texto_mediano_gris">Fecha de la 4ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia4" id="dia4">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes4" id="mes4">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano4" id="ano4">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>


</td></tr>
 </table>
</fieldset>
</td></tr>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>

<tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 5</b></legend>
<table>
    <tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 5ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info5"></TEXTAREA>
</td></tr>

	<tr><td>
              <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 5:</span>
        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva5" type="text" id="tipo_eva5" value="">
	</td></tr>

<tr>
    <td align="left" class="texto_mediano_gris">Fecha de la 5ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia5" id="dia5">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes5" id="mes5">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano5" id="ano5">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>


</td></tr>
 </table>
</fieldset>
</td></tr>

<?php } else {?>
           <input name="info5" type="hidden" id="info5" value=""/>
           <input name="tipo_eva5" type="hidden" id="tipo_eva5" value=""/>
           <input name="dia5" type="hidden" id="dia5" value=""/>
           <input name="mes5" type="hidden" id="mes5" value=""/>
           <input name="ano5" type="hidden" id="ano5" value=""/>
<?php } ?>
<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_POST['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input name="tipofl" type="hidden" id="tipofl" value="<?php echo $row_tipofl['cod']; ?>">
	<input name="confip" type="hidden" id="confip" value="<?php echo $row_confi['codfor']; ?>">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Grabar Planilla >" />
	
	<input type="hidden" name="MM_insert" value="form1">
      </form>
</td></tr>
</table>


<?php } // FIN DE FORM DE REGISTRO DE PLANILLA
 ?>


<?php // CUANDO NO EXITE LA PLANILLA

if ($_POST['asignatura_id']!=$row_confiplanilla['asignatura_id']) { ?>

<table><tr><td>
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
	<span class="texto_mediano_gris"><b>Asignatura:</b> <?php echo $row_docente['nombre']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>A&ntilde;o y Secci&oacute;n:</b> <?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Docente:</b> <?php echo $row_docente['name']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Nombre del Proyecto:</b></span>
	<input name="nombre_proyecto" type="text" id="nombre_proyecto" value="" class="texto_mediano_gris" size="45">
	</td></tr>	   

<tr><td align="left">
<?php if(($row_tipofl['cod']==0) and ($row_confi['codfor']=="nor01")) { ?>
<h2>Calcular las Calificaciones Parciales a 100%</h2>
<?php } ?>
Cantidad de Evaluaciones y Ponderaciones:
</td></tr>
<tr><td>
       <select name="cant_pruebas" id="cant_pruebas">
             <option value="">Cant</option>
	     <option value="3">3</option>
	     <option value="4">4</option>
             <?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
             <option value="5">5</option>
             <?php } ?>
             <?php if ($row_confi['codfor']=="nor02"){?>
             <option value="6">6</option>
             <?php } ?>
        </select>
        <?php if ($row_confi['codfor']=="nor02"){?>
         <h4>Recuerda que en la cantidad de Evaluaciones debes tomar en cuenta la evaluci&oacute;n del indicador </h4>
        <?php } ?>
       <select name="p1" id="p1">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
        </select>

       <select name="p2" id="p2">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>>
        </select>

       <select name="p3" id="p3">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>

        </select>

       <select name="p4" id="p4">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
	     <option value="50">50%</option>
        </select>

        <?php if (($row_confi['codfor']=="nor01")or($row_confi['codfor']=="nor02")){?>
          <select name="p5" id="p5">
             <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
	     <option value="50">50%</option>
         </select>
        <?php } ?>

        <?php if ($row_confi['codfor']=="nor02"){?>
         <input type="text" name="p6" id="p6" size="2" readonly="readonly" value="20" class="texto_mediano_gris"/> %
        <?php } ?>

</td></tr>

<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #1:</b></span>
	<input class="texto_mediano_gris" name="isc1" type="text" id="isc1" value=""/>
	</td></tr>
<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc1" type="hidden" id="isc1" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #1:</b></span>
	<input class="texto_mediano_gris" name="isc1" type="text" id="isc1" value="">
	</td></tr>
<?php }?>


<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #2:</b></span>
	<input class="texto_mediano_gris" name="isc2" type="text" id="isc2" value="">
	</td></tr>

<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc2" type="hidden" id="isc2" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #2:</b></span>
	<input class="texto_mediano_gris" name="isc2" type="text" id="isc2" value="">
	</td></tr>
<?php }?>



<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #3:</b></span>
	<input class="texto_mediano_gris" name="isc3" type="text" id="isc3" value="">
	</td></tr>
<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc3" type="hidden" id="isc3" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #3:</b></span>
	<input class="texto_mediano_gris" name="isc3" type="text" id="isc3" value="">
	</td></tr>
<?php }?>


<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #4:</b></span>
	<input class="texto_mediano_gris" name="isc4" type="text" id="isc4" value="">
	</td></tr>
<?php }?>

<?php if (($row_confi['codfor']=="bol02") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<input name="isc4" type="hidden" id="isc4" value=""/>
<?php } ?>



   <tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 1</b></legend>
<table>
<tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 1era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info1"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
                <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 1:</span>
                        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva1" type="text" id="tipo_eva1" value="">
	</td></tr>
<?php }else{?>
		<input class="texto_mediano_gris" name="tipo_eva1" type="hidden" id="tipo_eva1" value="">
<?php } ?>


<tr><td align="left" class="texto_mediano_gris">Fecha de la 1era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia1" id="dia1">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>


             </select>
             <select name="mes1" id="mes1">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano1" id="ano1">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>

</td></tr>
 </table>
</fieldset>
</td></tr>

 <tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 2</b></legend>
<table>

<tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 2da. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info2"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
                <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 2:</span>
                        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva2" type="text" id="tipo_eva2" value="">
	</td></tr>
<?php }else{?>
		<input class="texto_mediano_gris" name="tipo_eva2" type="hidden" id="tipo_eva2" value="">
<?php } ?>

<tr>
<td align="left" class="texto_mediano_gris">Fecha de la 2da. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia2" id="dia2">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes2" id="mes2">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano2" id="ano2">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>

</td></tr>
 </table>
</fieldset>
</td></tr>


<tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 3</b></legend>
<table>
    
 <tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 3era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info3"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 3:</span>
                </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva3" type="text" id="tipo_eva3" value="">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva3" type="hidden" id="tipo_eva3" value="">
<?php } ?>

<tr>
<td align="left" class="texto_mediano_gris">Fecha de la 3era. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia3" id="dia3">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes3" id="mes3">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano3" id="ano3">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>

</td></tr>
 </table>
</fieldset>
</td></tr>


<tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 4</b></legend>
<table>

    <tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 4ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info4"></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01") or ($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
                <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 4:</span>
                        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva4" type="text" id="tipo_eva4" value="">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva4" type="hidden" id="tipo_eva4" value="">
<?php } ?>

<tr>
<td align="left" class="texto_mediano_gris">Fecha de la 4ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia4" id="dia4">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes4" id="mes4">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano4" id="ano4">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>


</td></tr>
 </table>
</fieldset>
</td></tr>

<?php if (($row_confi['codfor']=="nor01")or ($row_confi['codfor']=="nor02")){?>

<tr><td>
<fieldset style="background-color: #fffccc;">
<legend> <b class="texto_mediano_gris"> Informaci&oacute;n Evaluaci&oacute;n 5</b></legend>
<table>
    <tr><td align="left" class="texto_mediano_gris">Informaci&oacute;n de la 5ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info5"></TEXTAREA>
</td></tr>

	<tr><td>
              <span class="texto_mediano_gris">Tipo de Evaluaci&oacute;n 5:</span>
        </td></tr>
        <tr><td>
	<input class="texto_mediano_gris" name="tipo_eva5" type="text" id="tipo_eva5" value="">
	</td></tr>

<tr>
    <td align="left" class="texto_mediano_gris">Fecha de la 5ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<select name="dia5" id="dia5">
             <option value="">...</option>
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
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes5" id="mes5">
             <option value="">...</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano5" id="ano5">
             <option value="">...</option>
             <option value="2011">2011</option>
	     <option value="2012">2012</option>
             </select>


</td></tr>
 </table>
</fieldset>
</td></tr>
                    
<?php } else {?>
           <input name="info5" type="hidden" id="info5" value=""/>
           <input name="tipo_eva5" type="hidden" id="tipo_eva5" value=""/>
           <input name="dia5" type="hidden" id="dia5" value=""/>
           <input name="mes5" type="hidden" id="mes5" value=""/>
           <input name="ano5" type="hidden" id="ano5" value=""/>
<?php } ?>




<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_POST['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input name="tipofl" type="hidden" id="tipofl" value="<?php echo $row_tipofl['cod']; ?>">
	<input name="confip" type="hidden" id="confip" value="<?php echo $row_confi['codfor']; ?>">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Grabar Planilla >" />
	
	<input type="hidden" name="MM_insert" value="form1">
      </form>
</td></tr>
</table>


<?php } // FIN DE FORM DE REGISTRO DE PLANILLA
 ?>

	
 <tr><td>
   &nbsp;&nbsp;
 </td></tr>
</table>

<?php } } //FIN DE LA RESTRICCION DE SESIONES
?>
</body>
</center>
</html>
<?php

mysql_free_result($docente);

mysql_free_result($confi);

mysql_free_result($lapso);

mysql_free_result($confiplanilla);

?>
