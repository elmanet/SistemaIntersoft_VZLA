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


$colname_docente = "-1";
if (isset($_GET['cedula'])) {
  $colname_docente = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT * FROM jos_docente WHERE cedula_docente = %s", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::REGISTRO DE DOCENTES::</title>
<link href="../css/componentes.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body >
<center>
<div id="contenedor">
	<div id="contenido">
	 <?php if($_GET['cedula']>0){?>
<br>
		<img src="../images/pngnew/los-usuarios-de-foro-de-la-familia-icono-4429-128.png" height="" width="" alt="" align="middle"/>

		<h2>MODIFICACION REALIZADA CON EXITO!</h2>

		<?php }?>		
		
	</div>
</div>
<div id="footer"><center><c>Copyright © 2011 Open Source Matters. Todos los derechos reservados.</c></center> </div>

</center>
</body>
</html>

<?php
mysql_free_result($docente);
?>
