<?php require_once('../Connections/sistemacol.php'); ?>
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



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::REGISTRO DE COORDINADORES Y SECRETARIAS::</title>
<link href="../css/componentes.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
</head>
<body >
<center>
<div id="contenedor">
	<div id="contenido">
	 <?php if($_GET['cedula']>0){?>
<br>
		<img src="../images/pngnew/usuario-administrador-personal-icono-9746-128.png" height="" width="" alt="" align="middle"/>

		<h2>REGISTRO COMPLETADO</h2>
		
		<a href="planilla_verifica_coordinador.php" >Registrar Otro Coordinador...</a>
		<p><a href="../modules/acceso/index.php" >-Volver al menú Principal-</a></p>
		<?php }?>		
		
	</div>
</div>
<div id="footer"><center><c>Copyright © 2011 Open Source Matters. Todos los derechos reservados.</c></center> </div>

</center>
</body>
</html>


