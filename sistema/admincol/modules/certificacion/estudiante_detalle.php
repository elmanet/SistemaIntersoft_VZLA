<?php require_once('../inc/conexion.inc.php');

$apellido_alumno=$_GET['apellido_alumno'];

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

// listado de estudiantes


mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = "SELECT * FROM jos_cdc_estudiante WHERE apellido_alumno like '%$apellido_alumno%' or nombre_alumno like '%$apellido_alumno%' or cedula like '%$apellido_alumno%'";
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);


//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" >
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>
<center>
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de Estudiantes Registrados!</h2>
	
	</td></tr>
<tr><td>
<div style="font-size:12px; font-family:verdana; width:200px; height:20px; background-color:#fffccc; margin-bottom:10px; padding-top:5px; padding-left:10px; border:1px solid; ">

<a href="estudiante_nuevo1.php"><img src="../../images/icons/nuevo.png" border="0" align="absmiddle">&nbsp;Cargar Nuevo Estudiante</a>
</div>

<form action="estudiante_detalle.php" name="form" id="form" method="GET" enctype="multipart/form-data" >
<span style="font-size:12px;">Buscar Estudiante: </span> 
<input type="text" name="apellido_alumno" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar >" />

</form> 
<br />

</tr><td>
<tr><td>

<table style="font-size:10px; font-family:verdana;" width="90%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Apellido y Nombre</td>
		<td align="center">C&eacute;dula</td>
		<td align="center">Fecha de Nac.</td>
		<td align="center">Lugar de Nac.</td>
		<td align="center">Entidad Fed.</td>
		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center">&nbsp;<?php if($pageNum_alumno==1){ $newlista=$maxRows_alumno+$lista; echo $newlista; $lista ++;   } if ($pageNum_alumno==0){ echo $lista; $lista ++;} ?>&nbsp;</td>
		<td><?php echo $row_alumno['apellido_alumno'].", ".$row_alumno['nombre_alumno']; ?></td>
		<td align="center"><?php echo $row_alumno['indicador_nacionalidad']."-".$row_alumno['cedula']; ?></td>
		<td align="center"><?php echo $row_alumno['fecha_nacimiento']; ?></td>
		<td align="center"><?php echo $row_alumno['lugar_nacimiento']; ?></td>
		<td align="center"><?php echo $row_alumno['ent_federal_pais']; ?></td>
		<td align="center"><a href="estudiante_modificacion.php?id=<?php echo $row_alumno['id'];?>"><img src="../../images/icons/modificar.png" border="0" align="absmiddle"></a></td>
	</tr>
        <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>	

</table>


<tr><td>
&nbsp;&nbsp;
</td></tr>

	<tr>
		<td >
		<?php if ($pageNum_alumno > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_alumno=%d%s", $currentPage, max(0, $pageNum_alumno - 1), $queryString_alumno); ?>">&lt;&lt;Anterior </a>
                          <?php } // Show if not first page ?>
                          <?php if ($pageNum_alumno == 0) { // Show if first page ?>
                          <a href="<?php printf("%s?pageNum_alumno=%d%s", $currentPage, min($totalPages_alumno, $pageNum_alumno + 1), $queryString_alumno); ?>">Siguiente &gt;&gt;</a>
                          <?php } // Show if first page ?>
		</td>
	</tr>

	<tr><td align="center">
<div style="margin-top:20px;">
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Estudiantes registrados en la N&oacute;mina de Certificaciones" <br /><br /><b>Nota:</b> Los Estudiantes en curso que no esten en esta n&oacute;mina se agregar&aacute;n en el momento de solicitar las notas certificadas o en el resumen final</p>
</div>
</div>
	</td></tr>


    </table>
    </center>
<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>
<?php

mysql_free_result($usuario);
mysql_free_result($alumno);

?>
