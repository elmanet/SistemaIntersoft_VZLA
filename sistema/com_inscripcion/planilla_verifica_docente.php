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
<title>::REGISTRO DE DOCENTES::</title>
<link href="../css/componentes.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body >

<center>
<br>
<img src="../images/pngnew/los-usuarios-de-foro-de-la-familia-icono-4429-128.png" height="" width="" alt="" align="middle"/>
<h2> Registro de Docentes </h2>

<form action="planilla_registro_docente1.php" method="GET" id="verificar_alumno">
	<table width="400px"><tr><td style="color:#blue; background-color: #fffccc;" colspan="2" ><h3>Verificacion de Registro</h3></td></tr>
		<tr><td align="right">Cedula del Docente:</td>
		
		<td><span id="sprytextfield4"><strong><input type="text" name="cedula" value="" size="15" /><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span><span class="texto_pequeno_gris">                            Ej. 13987456</span></strong></span></td></tr>
		<tr><td></td><td><input type="submit" name="button" value="Verificar" /></td></tr>
		
	</table>
</form>


<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {hint:"Ej. 13568420", validateOn:["blur"], minChars:7});

//-->
</script>
<br>

</center>



</body>
</html>

