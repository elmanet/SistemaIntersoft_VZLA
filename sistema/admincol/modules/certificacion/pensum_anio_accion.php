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

mysql_select_db($database_sistemacol, $sistemacol);
$query_anio = "SELECT * FROM jos_cdc_planestudio ORDER BY id ASC";
$anio = mysql_query($query_anio, $sistemacol) or die(mysql_error());
$row_anio = mysql_fetch_assoc($anio);
$totalRows_anio = mysql_num_rows($anio);


// INICIO DE SQL DE REGISTRO DE  DATOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {



  $insertSQL = sprintf("INSERT INTO jos_cdc_pensum_anios (id, nombre_anio, inicial, no_anio, planestudio_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre_anio'], "text"),
                       GetSQLValueString($_POST['inicial'], "text"),
		                 GetSQLValueString($_POST['no_anio'], "int"),
                       GetSQLValueString($_POST['planestudio_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
  
  $insertGoTo = "pensum_anios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>INTERSOFT | Software Educativo</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

<?php // SCRIPT PARA BLOQUEAR EL ENTER 
?>
<script>
function disableEnterKey(e){
var key;
if(window.event){
key = window.event.keyCode; //IE
}else{
key = e.which; //firefox
}
if(key==13){
return false;
}else{
return true;
}
}
</script>

</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Cargar nuevo A&ntilde;o al Pensum!</h2>
	
	</td></tr>

<tr><td>
	
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">Nombre del Año</td>
		<td align="center">Iniciales</td>
		<td align="center">No. de A&ntilde;o</td>
		<td align="center">Plan de Estudio</td>
		<td align="center">Acci&oacute;n</td>
	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
	<tr >
		<td align="center"><input name="nombre_anio" type="text" id="nombre_anio" value="" size="25" onKeyUp="this.value=this.value.toUpperCase()"/></td>
		<td align="center"><input name="inicial" type="text" id="inicial" value="" size="4" /></td>
		<td align="center"><input name="no_anio" type="text" id="no_anio" value="" size="2" /></td>
		<td align="center">
			<select name="planestudio_id" id="planestudio_id">
				<?php
				do { ?>
             			<option value="<?php echo $row_anio['id']; ?>"><?php echo $row_anio['plan_estudio']."/".$row_anio['cod'];; ?></option>
             			<?php } while ($row_anio = mysql_fetch_assoc($anio)); ?>
             		</select>
		</td>
		<td align="center"><input type="submit" name="buttom" value="Cargar >" />
		<input type="hidden" name="MM_insert" value="form">
		<input type="hidden" name="id" id="id" value=""></td>
	</tr>

 </form>  	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	
	<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Selecciona el a&ntilde;o seg&uacute;n su plan de Estudio" <br /></p>
</div>
</div>
	</td></tr>


    </table>
<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>
<?php

mysql_free_result($usuario);
//mysql_free_result($localidad);
mysql_free_result($anio);

?>
