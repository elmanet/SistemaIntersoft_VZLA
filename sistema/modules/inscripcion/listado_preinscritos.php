<?php require_once('../inc/conexion.inc.php');
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

//ACTUALIZACION DE PREINSCRITO

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "acepta")) {

  $updateSQL = sprintf("UPDATE jos_alumno_preinscripcion SET aceptado=%s WHERE id=%s",
             GetSQLValueString($_POST['aceptado'], "int"),
		       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "listado_preinscritos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

// listado de estudiantes
$apellido_alumno=$_GET['apellido_alumno'];
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = "SELECT * FROM jos_alumno_preinscripcion  WHERE  ape_alumno like '%$apellido_alumno%' or nom_alumno like '%$apellido_alumno%' or ced_alumno like '%$apellido_alumno%' ORDER BY ape_alumno ASC";
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
<?php if ($row_usuario['gid']>=25){ // AUTENTIFICACION DE USUARIO 
?>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de Estudiantes Pre-Inscritos</h2>
	
	</td></tr>
<tr><td>

<form action="listado_preinscritos.php" name="form" id="form" method="GET" enctype="multipart/form-data" >
<span style="font-size:12px;"><b>Buscar Estudiante:</b> </span> 

<input type="text" name="apellido_alumno" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar >" />

</form> 

<br />
<a href="listado_preinscritos.php" > | Ver Todos los Estudiantes |</a>
<br />
<br />
<?php if($totalRows_alumno>0) {	?>

<br />
</tr><td>
<tr><td>

<table style="font-size:10px; font-family:verdana;" width="100%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Apellido y Nombre <br />del Estudiante</td>
		<td align="center">C&eacute;dula del<br />Estudiante</td>
		<td align="center">Tel&eacute;fono del<br />Estudiante</td>
		<td align="center">Grado o A&ntilde;o <br /> a cursar</td>

		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center" width="10"><?php echo $lista; $lista ++; ?>&nbsp;</td>
		<td align="center" width="200"><?php echo $row_alumno['ape_alumno']."<br /> ".$row_alumno['nom_alumno']; ?></td>
		<td align="center" width="50">&nbsp;<?php echo $row_alumno['ced_alumno']; ?>&nbsp;</td>
		<td align="center" width="60">&nbsp;<?php echo $row_alumno['tel_alumno']; ?>&nbsp;</td>
		<td align="center" width="60">&nbsp;<?php echo $row_alumno['grado_cursar']; ?>&nbsp;</td>
		
		<td align="center" width="10">
		<?php if($row_alumno['aceptado']==NULL){?>
		<form action="<?php echo $editFormAction; ?>" method="POST" name="acepta">
			<input name="id" type="hidden" id="id" value="<?php echo $row_alumno['id']; ?>">
			<input name="aceptado" type="hidden" id="aceptado" value="1">
			<input class="texto_mediano_gris" type="submit" name="buttom" value="Aceptar" />
			<input type="hidden" name="MM_update" value="acepta">
	</form>
	   <?php }else{?>
	   <img src="../../images/png/32px-Crystal_Clear_action_apply.png" alt="" >
	  <?php  } ?>
		
		</td>
	</tr>
        <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>	

</table>
<?php } else { ?>
<center>
<img src="../../images/png/atencion.png" width="15%" alt="" /><br /><br />
<span class="texto_mediano_gris">No Existen Estudiantes con estas especificaciones!</span>
</center>
<?php } ?>
<tr><td>
&nbsp;&nbsp;
</td></tr>





    </table>
<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>
<?php
mysql_free_result($usuario);
mysql_free_result($alumno);

?>
