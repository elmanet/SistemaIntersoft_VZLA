<?php 
// CONEXION CON LA BASE DE DATOS 
require_once('Connections/sistemacol.php'); ?>

<?php
// VERIFICACION DE LA VERSION DE PHP
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
// FIN DE LA VERIFICACION DE LA VERSION DE PHP

  
//HOJA DE MENU DE MODULOS DE ColegiOnline
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="css/main_central.css" rel="stylesheet" type="text/css">
<link href="css/modules.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<!-- INICIO DEL CONTENEDOR PRINCIPAL -->
<div style="background:#04B45F;">
<iframe width="1200" height="1000"  name="frame" scrolling="auto" frameborder="0" src="modules/acceso/index.php" >
</iframe>
</div> 

</body>
</center>
</html>

