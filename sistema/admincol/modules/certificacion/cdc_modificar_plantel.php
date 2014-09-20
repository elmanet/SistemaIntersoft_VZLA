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

// general plantel
$colname_plantel = "-1";
if (isset($_GET['id'])) {
  $colname_plantel = $_GET['id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel = sprintf("SELECT * FROM jos_cdc_plantelcurso a, jos_cdc_planestudio b, jos_cdc_localidad c, jos_cdc_nombre_plantel d, jos_cdc_estudiante e WHERE a.planestudio_id=b.id AND a.localidad_id=c.id AND a.nombre_plantel_id=d.id AND a.alumno_id=e.id AND a.id=%s", GetSQLValueString($colname_plantel, "int"));
$plantel = mysql_query($query_plantel, $sistemacol) or die(mysql_error());
$row_plantel = mysql_fetch_assoc($plantel);
$totalRows_plantel = mysql_num_rows($plantel);

// nombre de plantel

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel1 = sprintf("SELECT * FROM jos_cdc_nombre_plantel ");
$plantel1 = mysql_query($query_plantel1, $sistemacol) or die(mysql_error());
$row_plantel1 = mysql_fetch_assoc($plantel1);
$totalRows_plantel1 = mysql_num_rows($plantel1);


// localidad
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel2 = sprintf("SELECT * FROM jos_cdc_localidad");
$plantel2 = mysql_query($query_plantel2, $sistemacol) or die(mysql_error());
$row_plantel2 = mysql_fetch_assoc($plantel2);
$totalRows_plantel2 = mysql_num_rows($plantel2);


// INICIO DE SQL DE REGISTRO DE  DATOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {



     $updateSQL = sprintf("update jos_cdc_plantelcurso SET no=%s, nombre_plantel_id=%s, localidad_id=%s, ef=%s WHERE id=%s",
                         
                            GetSQLValueString($_POST['no'], "int"),
                            GetSQLValueString($_POST['nombre_plantel_id'], "int"),
                            GetSQLValueString($_POST['localidad_id'], "int"),
                            GetSQLValueString($_POST['ef'], "text"),
                            GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "cdc_modificar_plantel2.php";
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

<link rel="stylesheet" href="../../jquery/styles/nyroModal.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../../jquery/js/jquery.nyroModal.custom.js"></script>

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
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top" align="center">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Modificar planteles de Estudio!</h2>
	
	</td></tr>

<tr><td>
	
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" align="center" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">Nombre del Plantel</td>
		<td align="center">No. Posici&oacute;n</td>
		<td align="center">Localidad</td>
		<td align="center">E.F.</td>
	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<tr >
		<td align="center">
			<select name="nombre_plantel_id" id="nombre_plantel_id">
				<option value="<?php echo $row_plantel['nombre_plantel_id']; ?>"><?php echo $row_plantel['nombre_plantel']; ?></option>
				<option value="*">---------------------------------</option>
				<?php
				do { ?>
             			<option value="<?php echo $row_plantel1['id']; ?>"><?php echo $row_plantel1['nombre_plantel']; ?></option>
             			<?php } while ($row_plantel1 = mysql_fetch_assoc($plantel1)); ?>
             		</select>
			
</td>
	<td align="center">	<input name="no" type="text" id="no" value="<?php echo $row_plantel['no']; ?>" size="2" /></td>
		<td align="center">
			<select name="localidad_id" id="localidad_id">
				<option value="<?php echo $row_plantel['localidad_id']; ?>"><?php echo $row_plantel['localidad']; ?></option>
				<option value="*">---------------------------------</option>
				<?php
				do { ?>
             			<option value="<?php echo $row_plantel2['id']; ?>"><?php echo $row_plantel2['localidad']; ?></option>
             			<?php } while ($row_plantel2 = mysql_fetch_assoc($plantel2)); ?>
             		</select>
		</td>
	<td align="center"><input name="ef" type="text" id="ef" value="<?php echo $row_plantel['ef']; ?>" size="2" /></td>
		</tr>
		<tr>
		<td colspan="4" align="center">
		<br />
		<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
		<input type="hidden" name="MM_update" value="modi_form">
		<input type="submit" name="buttom" value="Modificar >" />
		</td></tr>




 </form>  	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>
<tr><td align="center">
	<span class="texto_grande_gris">Para cancelar presiona click afuera de esta Ventana!</span>
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
mysql_free_result($plantel);

?>
