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
$colname_reporte = "-1";
if (isset($_GET['cedula_representante'])) {
  $colname_reporte = $_GET['cedula_representante'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT alumno_id, nombre, apellido  FROM jos_alumno_info WHERE cedula_representante= %s" , GetSQLValueString($colname_reporte, "text"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso_encurso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso_encurso = mysql_query($query_lapso_encurso, $sistemacol) or die(mysql_error());
$row_lapso_encurso = mysql_fetch_assoc($lapso_encurso);
$totalRows_lapso_encurso = mysql_num_rows($lapso_encurso);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: REPORTE IMPRESO ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

<script language=javascript>
function ventanaSecundaria (URL){
   window.open(URL,"ventana1","width=700,height=400,scrollbars=NO")
}
</script> 


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
<span aling="center" class="texto_mediano_gris">Selecciona el Estudiante:</span>




</td>
</tr>
	<tr><td>&nbsp;</td></tr>

	<?php if ($totalRows_reporte>0){?>
	     <?php do { ?>
	<tr><td><a href="javascript:ventanaSecundaria('../asignaturas/calificaciones_representante.php?abc=<?php echo $row_lapso_encurso['cod'];?>&us=<?php echo $row_reporte['alumno_id']; ?>')"><img src="../../images/gif/ic_menu_link.gif" alt="" border="0" align="absmiddle" ><?php echo $row_reporte['nombre']; ?></a> </td></tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>	
	<tr><td>&nbsp;</td></tr>
<tr><td align="center"><a href="seleccionar_informacion_estudiante_representante.php" class="texto_pequeno_gris"  style="color:blue;">- Volver Atr&aacute;s -</a> </td></tr>
	<?php } ?>
	<?php if ($totalRows_reporte==0){?>
	<tr><td align="center"><a href="" class="texto_pequeno_gris">No Exiten Datos</a> </td></tr>
	<tr><td align="center"><a href="seleccionar_informacion_estudiante_representante.php" class="texto_pequeno_gris"  style="color:blue;">- Volver a Intentar -</a> </td></tr>
	<?php } ?>
	<tr><td>&nbsp;</td></tr>

	<tr><td align="center"><span  class="texto_pequeno_gris">Sistema Automatizado</span></td></tr>
	<tr><td align="center"><span class="texto_pequeno_gris">Colegionline 2011</span></td></tr>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);

?>

