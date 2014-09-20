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
$query_anio = "SELECT a.id, a.nombre_anio, b.cod FROM jos_cdc_pensum_anios a, jos_cdc_planestudio b WHERE a.planestudio_id=b.id ORDER BY b.id, a.no_anio ASC";
$anio = mysql_query($query_anio, $sistemacol) or die(mysql_error());
$row_anio = mysql_fetch_assoc($anio);
$totalRows_anio = mysql_num_rows($anio);

$colname_consulta = "-1";
if (isset($_GET['id'])) {
  $colname_consulta = $_GET['id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_consulta = sprintf("SELECT * FROM jos_cdc_estudiante WHERE id=%s", GetSQLValueString($colname_consulta, "int"));
$consulta = mysql_query($query_consulta, $sistemacol) or die(mysql_error());
$row_consulta = mysql_fetch_assoc($consulta);
$totalRows_consulta = mysql_num_rows($consulta);


// INICIO DE SQL DE REGISTRO DE  DATOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {



     $updateSQL = sprintf("update jos_cdc_estudiante SET indicador_nacionalidad=%s, cedula=%s, fecha_nacimiento=%s, apellido_alumno=%s, nombre_alumno=%s, lugar_nacimiento=%s, ent_federal_pais=%s WHERE id=%s",
                         
                            GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                            GetSQLValueString($_POST['cedula'], "bigint"),
                            GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                            GetSQLValueString($_POST['apellido_alumno'], "text"),
                            GetSQLValueString($_POST['nombre_alumno'], "text"),
                            GetSQLValueString($_POST['lugar_nacimiento'], "text"),
                            GetSQLValueString($_POST['ent_federal_pais'], "text"),
                            GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "estudiantes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
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
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
<center>
	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Modificar Datos del Estudiante!</h2>
</center>	
	</td></tr>

<tr><td>
<center>
<table style="font-size:10px; font-family:verdana;" width="45%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center" colspan="6"><span style="font-size:14px; font-family:verdana;"><b>Datos del Estudiante</b></span></td>

	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
	<tr >
		<td colspan="6">
		<br />
		&nbsp;&nbsp;&nbsp;&nbsp;Nombre del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="nombre_alumno" type="text" id="nombre_alumno" value="<?php echo $row_consulta['nombre_alumno'];?>" size="35" /><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Apellido del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="apellido_alumno" type="text" id="apellido_alumno" value="<?php echo $row_consulta['apellido_alumno'];?>" size="35" /><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;C&eacute;dula del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<select name="indicador_nacionalidad" id="indicador_nacionalidad"><option value="<?php echo $row_consulta['indicador_nacionalidad'];?>"><?php echo $row_consulta['indicador_nacionalidad'];?></option><option value="V">V</option><option value="E">E</option></select><input name="cedula" type="text" id="cedula" value="<?php echo $row_consulta['cedula'];?>" size="15"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Fecha de Nacimiento<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo $row_consulta['fecha_nacimiento'];?>" size="15"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Lugar de Nacimiento<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="lugar_nacimiento" type="text" id="lugar_nacimiento" value="<?php echo $row_consulta['lugar_nacimiento'];?>" size="35" /><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Entidad Federal<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="ent_federal_pais" type="text" id="entidad_federal_pais" value="<?php echo $row_consulta['ent_federal_pais'];?>" size="35" /><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar >" /><br /><br />
		<input type="hidden" name="MM_update" value="modi_form">
		<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>"></td>
	</tr>

 </form>  	

</table>
</center>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	
	<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Recuerda que la fecha de nacimiento se escribe a&ntilde;o-mes-d&iacute;a" <br /></p>
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
mysql_free_result($consulta);
mysql_free_result($anio);

?>
