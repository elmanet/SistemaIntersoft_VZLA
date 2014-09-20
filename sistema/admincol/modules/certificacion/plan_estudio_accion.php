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

// INICIO DE SQL DE REGISTRO DE  DATOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {



  $insertSQL = sprintf("INSERT INTO jos_cdc_planestudio (id, cod, plan_estudio, mencion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['cod'], "text"),
                      GetSQLValueString($_POST['plan_estudio'], "text"),
                      GetSQLValueString($_POST['mencion'], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
  
  $insertGoTo = "plan_estudio.php";
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
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Cargar Plan de Estudio!</h2>
	
	</td></tr>

<tr><td>
	
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">Cod</td>
		<td align="center">Descripci&oacute;n</td>
		<td align="center">Menci&oacute;n</td>
		<td align="center">Acciones</td>
	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
	<tr >
		<td align="center"><input name="cod" type="text" id="cod" value="" size="6" /></td>
		<td align="center"><input name="plan_estudio" type="text" id="plan_estudio" value="" size="40" onKeyUp="this.value=this.value.toUpperCase()"/></td>
		<td align="center"><input name="mencion" type="text" id="mencion" value="" size="10" /></td>
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

<p align="center">"El plan de Estudio que no tenga menci&oacute;n se debe dejar el campo en blanco" <br /></p>
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
mysql_free_result($localidad);

?>
