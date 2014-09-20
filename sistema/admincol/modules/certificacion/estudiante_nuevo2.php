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


$colname_alumno = "-1";
if (isset($_POST['cedula'])) {
  $colname_alumno = $_POST['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_alumno_info WHERE cedula = %s", GetSQLValueString($colname_alumno, "bigint"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

$colname_alumno_cer = "-1";
if (isset($_POST['cedula'])) {
  $colname_alumno_cer = $_POST['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_cer = sprintf("SELECT * FROM jos_cdc_estudiante WHERE cedula = %s", GetSQLValueString($colname_alumno_cer, "bigint"));
$alumno_cer = mysql_query($query_alumno_cer, $sistemacol) or die(mysql_error());
$row_alumno_cer = mysql_fetch_assoc($alumno_cer);
$totalRows_alumno_cer = mysql_num_rows($alumno_cer);


// INICIO DE SQL DE REGISTRO DE  DATOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {



  $insertSQL = sprintf("INSERT INTO jos_cdc_estudiante (id, indicador_nacionalidad, cedula, fecha_nacimiento, apellido_alumno, nombre_alumno, lugar_nacimiento, ent_federal_pais) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                       GetSQLValueString($_POST['cedula'], "bigint"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['apellido_alumno'], "text"),
                       GetSQLValueString($_POST['nombre_alumno'], "text"),
                       GetSQLValueString($_POST['lugar_nacimiento'], "text"),
                       GetSQLValueString($_POST['ent_federal_pais'], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
  
  $insertGoTo = "estudiantes.php";
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

<?php if($totalRows_alumno>0){ 	if($row_alumno_cer>0){ // VERIFICANDO DATOS EN LAS BD
?>

<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">" El Estudiante YA EXITE! <br /> tanto en la BD de Estudiantes Regulares<br /> como de Certificaciones!" <br /><br /><b> Nombre y Apellido: <br /> 
<?php echo $row_alumno['nombre']." ".$row_alumno['apellido']; ?> </b><br /></p>
</div>
</div>


<?php } else { // EL ESTUDIANTE SE DEBE AGREGAR A LA NOMINA DE CERTIFICACIONES
?>

<table width="900" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
<center>
	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Registrar Estudiante!</h2>
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
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="nombre_alumno" type="text" id="nombre_alumno" value="<?php echo $row_alumno['nombre'];?>" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Apellido del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="apellido_alumno" type="text" id="apellido_alumno" value="<?php echo $row_alumno['apellido'];?>" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;C&eacute;dula del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<select name="indicador_nacionalidad" id="indicador_nacionalidad"><option value="<?php echo $row_alumno['indicador_nacionalidad'];?>"><?php echo $row_alumno['indicador_nacionalidad'];?></option><option value="V">V</option><option value="E">E</option></select><input name="cedula" type="text" id="cedula" value="<?php echo $row_alumno['cedula'];?>" size="15"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Fecha de Nacimiento<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo $row_alumno['fecha_nacimiento'];?>" size="15"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Lugar de Nacimiento<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="lugar_nacimiento" type="text" id="lugar_nacimiento" value="<?php echo $row_alumno['lugar_nacimiento'];?>" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Entidad Federal<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="ent_federal_pais" type="text" id="entidad_federal_pais" value="" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar >" /><br /><br />
		<input type="hidden" name="MM_insert" value="form">
		<input type="hidden" name="id" id="id" value=""></td>
	</tr>

 </form>  	

</table>
</center>
<tr><td>
&nbsp;&nbsp;
</td></tr>


    </table>



<?php } ?>

<?php } ?>




<?php if($totalRows_alumno==0){	if($row_alumno_cer>0){ ?>

<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">" El Estudiante YA EXITE! <br /><br /><b> Nombre y Apellido: <br /> 
<?php echo $row_alumno_cer['nombre_alumno']." ".$row_alumno_cer['apellido_alumno']; ?> </b><br /></p>
</div>
</div>

<?php } else { // CARGANDO DATOS DE ESTUDIANTE
?>

<table width="900" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
<center>
	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Registrar Estudiante!</h2>
</center>	
	</td></tr>

<tr><td>
	<center>
<table style="font-size:10px; font-family:verdana; " width="45%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center" colspan="6"><span style="font-size:14px; font-family:verdana;"><b>Datos del Estudiante</b></span></td>

	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
	<tr >
		<td colspan="6">
		<br />
		&nbsp;&nbsp;&nbsp;&nbsp;Nombre del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="nombre_alumno" type="text" id="nombre_alumno" value="" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Apellido del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="apellido_alumno" type="text" id="apellido_alumno" value="" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;C&eacute;dula del Estudiante<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<select name="indicador_nacionalidad" id="indicador_nacionalidad"><option value="V">V</option><option value="E">E</option></select><input name="cedula" type="text" id="cedula" value="" size="15"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Fecha de Nacimiento<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="" size="15"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Lugar de Nacimiento<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="lugar_nacimiento" type="text" id="lugar_nacimiento" value="" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />

		&nbsp;&nbsp;&nbsp;&nbsp;Entidad Federal<br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input name="ent_federal_pais" type="text" id="entidad_federal_pais" value="" size="35" onKeyUp="this.value=this.value.toUpperCase()"/><br /><br />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar >" /><br /><br />
		<input type="hidden" name="MM_insert" value="form">
		<input type="hidden" name="id" id="id" value=""></td>
	</tr>

 </form>  	

</table>
</center>
<tr><td>
&nbsp;&nbsp;
</td></tr>


    </table>



<?php } ?>

<?php } ?>


<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>
<?php

mysql_free_result($usuario);

mysql_free_result($alumno);
mysql_free_result($alumno_cer);
?>
