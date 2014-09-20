<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
//initialize the session
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


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

   $insertSQL = sprintf("INSERT INTO jos_curso (id, periodo_id, seccion_id, docente_id, anio_id) VALUES (%s, %s, %s, %s, %s)",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['periodo_id'], "int"),
							GetSQLValueString($_POST['seccion_id'], "int"),
							GetSQLValueString($_POST['docente_id'], "int"),
							GetSQLValueString($_POST['anio_id'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "admin_cursos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}


// CONSULTA SQL

mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT * FROM jos_docente ORDER BY nombre_docente ASC");
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_anios = sprintf("SELECT * FROM jos_anio_nombre ORDER BY numero_anio ASC");
$anios = mysql_query($query_anios, $sistemacol) or die(mysql_error());
$row_anios = mysql_fetch_assoc($anios);
$totalRows_anios = mysql_num_rows($anios);


mysql_select_db($database_sistemacol, $sistemacol);
$query_seccion = sprintf("SELECT * FROM jos_seccion ORDER BY descripcion ASC");
$seccion = mysql_query($query_seccion, $sistemacol) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

// FIN DE LA CONSULTA SQL 
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

<div id="contenedor_central_modulo">
<table width="500" border="0">
  <tr>
    <td width="128"><img src="../../images/pngnew/archivo-de-la-biblioteca-icono-8962-128.png" width="75" height="75" /></td>
    <td width="362"><table width="100%" border="0">
      <tr>
        <td class="titulo_extragrande_gris" colspan="2">CARGAR CURSOS</td>
      </tr>
      <tr><td>
	
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
		   
	<tr><td align="left">Selecciona el A&ntilde;o y la Secci&oacute;n</td></tr>
	<tr><td>
	
	<select name="anio_id" class="texto_mediano_gris" id="anio_id">
         <option value="">A&ntilde;o</option>
           <?php do { ?>
              <option value="<?php echo $row_anios['id']; ?>"><?php echo $row_anios['nombre']; ?></option>
           <?php } while ($row_anios = mysql_fetch_assoc($anios));
  	   $rows = mysql_num_rows($anios);
  	   if($rows > 0) {
           mysql_data_seek($anios, 0);
	  $row_anios = mysql_fetch_assoc($anios);
		 }
	   ?>
         </select>
         
	<select name="seccion_id" class="texto_mediano_gris" id="seccion_id">
         <option value="">Secci&oacute;n</option>
           <?php do { ?>
              <option value="<?php echo $row_seccion['id']; ?>"><?php echo $row_seccion['descripcion']; ?></option>
           <?php } while ($row_seccion = mysql_fetch_assoc($seccion));
  	   $rows = mysql_num_rows($seccion);
  	   if($rows > 0) {
           mysql_data_seek($seccion, 0);
	  $row_seccion = mysql_fetch_assoc($seccion);
		 }
	   ?>	   
         </select>
         
         
         </td></tr>
         


       <tr><td align="left">Selecciona el Docente Gu&iacute;a:</td></tr>
	<tr><td>
	<select name="docente_id" class="texto_mediano_gris" id="docente_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_docente['id']; ?>"><?php echo $row_docente['nombre_docente']." ".$row_docente['apellido_docente']; ?></option>
           <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
           mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
         </select></td></tr>
         

<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="">
	<input name="periodo_id" type="hidden" id="periodo_id" value="<?php echo $row_periodo['id'];?>">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Crear Curso >" />
	
	<input type="hidden" name="MM_insert" value="form1">
      </form>
	</td></tr>
     
 </td></tr>
      

      <tr>
        <td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
      </tr>
    </table></td>
  </tr>
</table>

</div>

</body>
</center>
</html>
<?php
mysql_free_result($docente);
mysql_free_result($anios);
mysql_free_result($seccion);
mysql_free_result($periodo);
?>
