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

$colname_planestudio = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $colname_planestudio = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT a.id, a.cod, a.plan_estudio  FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_planestudio_estudiante c WHERE c.planestudio_id=a.id AND c.alumno_id=b.id AND b.cedula=%s ORDER BY a.cod DESC", GetSQLValueString($colname_planestudio, "int"));
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

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

	
	
	</td></tr>

<tr><td>
<form action="imprimir_certificacion3.php" name="form" id="form" method="POST" enctype="multipart/form-data" target="_blank">
<div id="recuadro_cedula"><br />
<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Imprimir Notas!</h2>
<?php if ($totalRows_planestudio>0){ // VERIFICO SI HAY DATOS
?>
Plan de Estudio<br />
<select name="9812HHFJHJHF63883B3CNCH7" id="9812HHFJHJHF63883B3CNCH7">
				<?php
				do { ?>
             			<option value="<?php echo $row_planestudio['id']; ?>"><?php echo $row_planestudio['cod']."/".$row_planestudio['plan_estudio']; ?></option>
             			<?php } while ($row_planestudio = mysql_fetch_assoc($planestudio)); ?>
             		</select><br />
<input type="hidden" name="1298JJII128938367HHY" id="1298JJII128938367HHY" value="<?php echo $_POST['1298JJII128938367HHY']; ?>"/>
<input type="submit" name="buttom" value="Confirmar >" />
<?php } else {?>
<br />
El Estudiante no Posee Certificaciones cargadas al sistemas!
<br />
<br />
<a href="imprimir_certificacion1.php">Volver Atras</a>
<?php } ?>
</div>
</form>  	
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});


//-->
</script>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	
	<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Esta opci&oacute;n sirve para cargar las notas Certificadas<br /> de un Estudiante Regular o alg&uacute;n ex-alumno" <br /></p>
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
mysql_free_result($planestudio);

?>
