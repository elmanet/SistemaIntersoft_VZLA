<?php require_once('../inc/conexion.inc.php');

// CONSULTA SQL

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::SISTEMA COLEGIONLINE::</title>
<link href="../../css/componentes.css" rel="stylesheet" type="text/css">
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body >
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>
<center>
<h2> <img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Registro de Estudiantes </h2>

<form action="estudiante_nuevo2.php" method="POST" id="verificar_alumno">
	<table width="500px"><tr><td style="color:#blue; background-color: #fffccc;" colspan="2" ><h3>Verificacion de Registro</h3></td></tr>
		<tr><td align="right">Cedula del Estudiante:</td>
		
		<td><span id="sprytextfield4"><strong><input type="text" name="cedula" value="" size="15" /><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span><span class="texto_pequeno_gris">                            Ej. 13987456</span></strong></span></td></tr>
		<tr><td></td><td><input type="submit" name="button" value="Verificar" /></td></tr>
		<tr><td colspan="2"><b>Si el estudiante es regular de la instituci&oacute;n, los datos ser&aacute;n tomados de la Base de Datos...</b></td></tr>
	</table>
</form>


<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {hint:"Ej. 13568420", validateOn:["blur"], minChars:7});

//-->
</script>
</center>


<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</html>

