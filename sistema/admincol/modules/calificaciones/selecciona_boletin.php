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


mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT f.descripcion, g.nombre, e.id as cursoid FROM jos_users a, jos_docente b, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=e.docente_id AND e.seccion_id=f.id AND e.anio_id=g.id ORDER BY g.numero_anio, g.nombre, f.descripcion ");
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi1 = sprintf("SELECT * FROM jos_formato_evaluacion_tboletin");
$confi1 = mysql_query($query_confi1, $sistemacol) or die(mysql_error());
$row_confi1 = mysql_fetch_assoc($confi1);
$totalRows_confi1 = mysql_num_rows($confi1);

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Modulo de Impresion de Boletines!</h2>
	<h3>Busqueda por C&eacute;dula de Estudiante</h3>
	<form action="ver_boletin_<?php echo $row_confi['codfor']."".$row_confi1['cod']; ?>.php" method="GET" name="f1" target="_blank">
	</td></tr><tr><td><img src="../../images/gif/construccion-plantilla.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;
	<input type="text" name="cedula" id="cedula" value="" />

	<select name="lapso" class="texto_mediano_gris" id="lapso">
          <option value="1">1er Lapso</option>
          <option value="2">2do Lapso</option>
          <option value="3">3er Lapso</option>
         </select>
	
	<input type="submit" name="buttom" value="Buscar >" />
	</td></tr>
	<tr><td>
		
	</td></tr>
	</form>
<tr><td>
&nbsp;&nbsp;
</td></tr>
    </table>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h3>Busqueda por Secci&oacute;n</h3>
	<form action="imprimir_boletin2.php" method="GET" name="f1" >
	</td></tr><tr><td><img src="../../images/gif/construccion-plantilla.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<select name="curso_id" class="texto_mediano_gris" id="curso_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_docente['cursoid']; ?>"><?php echo $row_docente['nombre']." ".$row_docente['descripcion']; ?></option>
           <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
           mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
         </select>
	<input type="hidden" name="lapso" id="lapso" value="<?php echo $row_lapso['cod']; ?>" />
	<input type="submit" name="buttom" value="Buscar >" />
	</td></tr>
	<tr><td>
		
	</td></tr>
	</form>
<tr><td>
&nbsp;&nbsp;
</td></tr>
    </table>
</body>
</center>
</html>
<?php


mysql_free_result($confi);

?>