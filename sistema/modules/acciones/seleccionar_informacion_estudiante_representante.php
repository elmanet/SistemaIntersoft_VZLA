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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: REPORTE IMPRESO ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
	</td></tr>
	<tr><td>&nbsp;</td></tr>
    <td valign="top" align="center">
<center>
<img src="../../images/pngnew/busqueda-de-los-usuarios-del-hombre-icono-6234-48.png" alt="" > </center>
<span aling="center" class="texto_mediano_gris">C&eacute;dula del Representante:</span>

<form action="seleccionar_estudiante_representante.php" method="GET">
	<input type="text" name="cedula_representante" value="" size="13"/>
	</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td align="center">
	<input type="submit" name="buttom"  class="texto_mediano_gris" value="Buscar >" />
	</form>



</td>
</tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td align="center"><span  class="texto_pequeno_gris">Sistema Automatizado</span></td></tr>
	<tr><td align="center"><span class="texto_pequeno_gris">Colegionline 2011</span></td></tr>
    </table>
</body>
</center>
</html>

