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

$colname_periodo = "-1";
if (isset($_GET['periodo_id'])) {
  $colname_periodo = $_GET['periodo_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE id=%s", GetSQLValueString($colname_periodo, "int"));
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

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


<br />
<br />
<center>
<img src="../../images/pngnew/biblioteca-icono-3766-128.png"/><br />
<span class="texto_grande_gris">Cargar Certificaci&oacute;n de Desempe&ntilde;o</span> <br /><span class="texto_mediano_gris">A&ntilde;o Escolar: <b><?php echo $row_periodo['descripcion']; ?></b></span>
<br />
<br />
<form action="certificado_primaria1.php" method="POST" name="form_des">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $_GET['asignatura_id']; ?>">
	<input name="periodo" type="hidden" id="periodo" value="<?php echo $row_periodo['id']; ?>">
	<input class="texto_grande_gris" type="submit" name="buttom" value="Continuar >" />

</form>
</center>


<?php } //FIN DE LA RESTRICCION DE SESIONES
?>
</body>
</center>
</html>
<?php

mysql_free_result($docente);

mysql_free_result($periodo);

mysql_free_result($periodo);

mysql_free_result($confiplanilla);

?>
