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

// 	GRABADO EN LA TABLA 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha1= $_POST['ano1']."-".$_POST['mes1']."-".$_POST['dia1'];
$fecha2= $_POST['ano2']."-".$_POST['mes2']."-".$_POST['dia2'];
$fecha3= $_POST['ano3']."-".$_POST['mes3']."-".$_POST['dia3'];
$fecha4= $_POST['ano4']."-".$_POST['mes4']."-".$_POST['dia4'];
//corregir

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

   $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_planilla_primaria (id, asignatura_id, no_semanas, nombre_proyecto, dia_laborados, desde, hasta, fecha_entrega, lapso, periodo_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['asignatura_id'], "int"),
							GetSQLValueString($_POST['no_semanas'], "int"),
							GetSQLValueString($_POST['nombre_proyecto'], "text"),
							GetSQLValueString($_POST['dia_laborados'], "int"),
							GetSQLValueString($_POST['desde'], "date"),
							GetSQLValueString($_POST['hasta'], "date"),
							GetSQLValueString($_POST['fecha_entrega'], "date"),
							GetSQLValueString($_POST['lapso'], "int"),
							GetSQLValueString($_POST['periodo_id'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "pr_seleccionar_anio_carga_notas2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 header(sprintf("Location: %s", $insertGoTo));
}



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
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla_primaria WHERE asignatura_id = %s AND lapso=%s ", GetSQLValueString($colname_confiplanilla, "int"), GetSQLValueString($lap_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);


//FIN CONSULTA
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
    <td valign="top"><h3>Configurar Planilla de Calificaciones </h3>

<?php // CUANDO LA PLANILLA EXISTE PARA EL LAPSO

if(($_GET['asignatura_id']==$row_confiplanilla['asignatura_id']) and ($_GET['lapso']==$row_confiplanilla['lapso'])) { ?>

<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Informaci&oacute;n de calificaciones</h2>
<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
<table>
<tr><td>

</td></tr>
<tr><td><span class="texto_mediano_gris"><b>Asignatura:</b> <?php echo $row_docente['nombre']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>A&ntilde;o y Secci&oacute;n:</b> <?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Docente:</b> <?php echo $row_docente['name']; ?></span></td></tr>
</table>
</fieldset >

<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
<table>

<tr><td><span class="texto_mediano_gris"><b>No. Semanas:</b> <?php echo $row_confiplanilla['no_semanas']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Nombre del Proyecto:</b> <?php echo $row_confiplanilla['nombre_proyecto']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Dias Laborados:</b> <?php echo $row_confiplanilla['dia_laborados']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Desde:</b> <?php echo $row_confiplanilla['desde']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Hasta:</b> <?php echo $row_confiplanilla['hasta']; ?></span></td></tr>
<tr><td><span class="texto_mediano_gris"><b>Fecha de Entrega:</b> <?php echo $row_confiplanilla['fecha_entrega']; ?></span></td></tr>
</table>
</fieldset >


</td></tr>
<tr><td>
<br />
<form action="carga_notas_pr.php" method="POST" name="form_enviar">

	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_GET['asignatura_id']; ?>">
	<input name="curso_id" type="hidden" id="curso_id" value="<?php echo $row_docente['curso_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input name="confiplanilla_id" type="hidden" id="confiplanilla_id" value="<?php echo $row_confiplanilla['id']; ?>">
	<input class="texto_grande_gris" type="submit" name="buttom" value="Cargar Boletines>" />

</form>
</td></tr>
<tr><td>
<br />
<form action="pr_modificar_planilla_notas.php" method="GET" name="form_modificar">

	<input name="id" type="hidden" id="id" value="<?php echo $row_confiplanilla['id']; ?>">


	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_GET['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Modificar Datos>" />

</form>
</td><tr>
</table>

<?php } // FIN DE LA CONSULTA

?>

<?php // CUANDO NO EXITE PARA ESTE LAPSO

if(($_GET['asignatura_id']==$row_confiplanilla['asignatura_id']) and ($_GET['lapso']!=$row_confiplanilla['lapso'])) {?>

<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
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
</table>
</fieldset >

<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
<table>	   
	<tr><td>
	<span class="texto_mediano_gris"><b>Nombre del Proyecto:</b></span>
	<input class="texto_mediano_gris" name="nombre_proyecto" type="text" id="nombre_proyecto" value="" size="50">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Numero de Semanas:</b></span>
	<input class="texto_mediano_gris" name="no_semanas" type="text" id="no_semanas" value=""  size="2">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Dias Labaorados:</b></span>
	<input class="texto_mediano_gris" name="dia_laborados" type="text" id="dia_laborados" value=""  size="2">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Desde:</b></span>
	<input class="texto_mediano_gris" name="desde" type="text" id="desde" value=""  size="10">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Hasta:</b></span>
	<input class="texto_mediano_gris" name="hasta" type="text" id="hasta" value=""  size="10">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Fecha de Entrega:</b></span>
	<input class="texto_mediano_gris" name="fecha_entrega" type="text" id="fecha_entrega" value=""  size="10">
	</td></tr>
</table>
</fieldset >



<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_GET['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input name="periodo_id" type="hidden" id="perido_id" value="<?php echo $row_periodo['id']; ?>">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Grabar Planilla >" />
	
	<input type="hidden" name="MM_insert" value="form1">
      </form>
</td></tr>
</table>


<?php } // FIN DE FORM DE REGISTRO DE PLANILLA
 ?>


<?php // CUANDO NO EXITE LA PLANILLA

if ($_GET['asignatura_id']!=$row_confiplanilla['asignatura_id']) { ?>

<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
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
</table>
</fieldset >

<fieldset >
<legend><strong><em>Datos de la Asignatura y Docente</em></strong> </legend>
<table>	   
	<tr><td>
	<span class="texto_mediano_gris"><b>Nombre del Proyecto:</b></span>
	<input class="texto_mediano_gris" name="nombre_proyecto" type="text" id="nombre_proyecto" value="" size="50">
	</td></tr>
	<tr><td>	
	<span class="texto_mediano_gris"><b>Numero de Semanas:</b></span>
	<input class="texto_mediano_gris" name="no_semanas" type="text" id="no_semanas" value="" size="2">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Dias Labaorados:</b></span>
	<input class="texto_mediano_gris" name="dia_laborados" type="text" id="dia_laborados" value=""  size="2">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Desde:</b></span>
	<input class="texto_mediano_gris" name="desde" type="text" id="desde" value=""  size="10">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Hasta:</b></span>
	<input class="texto_mediano_gris" name="hasta" type="text" id="hasta" value=""  size="10">
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Fecha de Entrega:</b></span>
	<input class="texto_mediano_gris" name="fecha_entrega" type="text" id="fecha_entrega" value=""  size="10">
	</td></tr>
</table>
</fieldset >

<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_GET['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_lapso['cod']; ?>">
	<input name="periodo_id" type="hidden" id="perido_id" value="<?php echo $row_periodo['id']; ?>">
	
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
