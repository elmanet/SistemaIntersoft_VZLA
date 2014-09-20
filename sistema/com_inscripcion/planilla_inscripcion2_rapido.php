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


$colname_alumno = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_alumno_info WHERE cedula = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::PLANILLA DE REGISTRO DE ESTUDIANTES::</title>
<link href="../css/componentes.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body >
<div id="contenedor">
	<div id="contenido">
	 <?php if($_GET['cedula']>0){?>
		<h2>REGISTRO COMPLETO</h2>
		<p> Ahora puede imprimir la planilla de inscripci&oacute;n del Estudiante o seguir con el registro de Estudiantes...</p>
		<a href="planilla_inscripcion_verifica_rapido.php" >Inscribir otro Estudiante...</a>
		<?php }?>		
		<h3>Imprimir Planilla de Inscripci&oacute;n</h3>
		<form action="planilla_inscripcion_ficha.php" method="GET" target="_blank">		
			<table><tr><td>		   
					<tr><td>C&eacute;dula del Estudiante:</td><td><input type="text" name="cedula" value="<?php echo $_GET['cedula']; ?>" /></td><td><input type="submit" name="boton" value="Imprimir Planilla" /></td></tr>
					<tr><td colspan="3"></td></tr>
					<tr><td colspan="3"></td></tr>					
					
			</td></tr></table>
		</form>
	</div>
</div>
<div id="footer"><center><c>OLE Technology C.A. Copyright © 2010 Open Source Matters. Todos los derechos reservados.</c></center> </div>

 
</body>
</html>

<?php
mysql_free_result($alumno);
?>
