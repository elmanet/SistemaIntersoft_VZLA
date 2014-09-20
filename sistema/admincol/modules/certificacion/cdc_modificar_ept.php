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
$colname_mate_ept = "-1";
if (isset($_GET['id'])) {
  $colname_mate_ept = $_GET['id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept = sprintf("SELECT a.id as mate, b.id, a.nombre_asignatura_ept, b.horas_clase, b.no_orden, c.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_ept_cursadas b, jos_cdc_pensum_anios c WHERE b.asignatura_ept_id=a.id AND a.anio_id=c.id AND b.id=%s", GetSQLValueString($colname_mate_ept, "int"));
$mate_ept = mysql_query($query_mate_ept, $sistemacol) or die(mysql_error());
$row_mate_ept = mysql_fetch_assoc($mate_ept);
$totalRows_mate_ept = mysql_num_rows($mate_ept);

// nombre de plantel

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept1 = sprintf("SELECT a.id, a.nombre_asignatura_ept, b.nombre_anio FROM jos_cdc_pensum_asignaturas_ept a, jos_cdc_pensum_anios b WHERE a.anio_id=b.id");
$mate_ept1 = mysql_query($query_mate_ept1, $sistemacol) or die(mysql_error());
$row_mate_ept1 = mysql_fetch_assoc($mate_ept1);
$totalRows_mate_ept1 = mysql_num_rows($mate_ept1);


// INICIO DE SQL DE REGISTRO DE  DATOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {



     $updateSQL = sprintf("update jos_cdc_ept_cursadas SET asignatura_ept_id=%s, horas_clase=%s, no_orden=%s WHERE id=%s",
                         
                            GetSQLValueString($_POST['asignatura_ept_id'], "int"),
                            GetSQLValueString($_POST['horas_clase'], "text"),
                            GetSQLValueString($_POST['no_orden'], "int"),
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

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Modificar Asignaturas de EPT!</h2>
	
	</td></tr>

<tr><td>
	
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" align="center" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">Nombre de la Asignatura</td>
		<td align="center">Horas Clase</td>
		<td align="center">No. Orden</td>

	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<tr >
		<td align="center">
			<select name="asignatura_ept_id" id="asignatura_ept_id">
				<option value="<?php echo $row_mate_ept['mate']; ?>"><?php echo $row_mate_ept['nombre_asignatura_ept']."/".$row_mate_ept['nombre_anio']."-".$row_mate_ept['id']; ?></option>
				<option value="">---------------------------------</option>
				<?php
				do { ?>
             			<option value="<?php echo $row_mate_ept1['id']; ?>"><?php echo $row_mate_ept1['nombre_asignatura_ept']."/".$row_mate_ept1['nombre_anio']."-".$row_mate_ept1['id']; ?></option>
             			<?php } while ($row_mate_ept1 = mysql_fetch_assoc($mate_ept1)); ?>
             		</select>
			
</td>
	<td align="center">	<input name="horas_clase" type="text" id="horas_clase" value="<?php echo $row_mate_ept['horas_clase']; ?>" size="2" /></td>
	<td align="center"><input name="no_orden" type="text" id="no_orden" value="<?php echo $row_mate_ept['no_orden']; ?>" size="2" /></td>
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
mysql_free_result($mate_ept);

?>
