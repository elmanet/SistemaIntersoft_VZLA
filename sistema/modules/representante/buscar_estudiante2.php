<?php require_once('../inc/conexion_sinsesion.inc.php'); ?>
<?php
// CONSULTA SQL

$consulta=$_POST['ced_representante'];

mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = "SELECT * FROM jos_alumno_info  WHERE cursando=1 AND cedula_representante=$consulta or cedula_madre=$consulta or cedula_padre=$consulta ORDER BY nombre ASC";
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

// FIN DE LA CONSULTA SQL 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>

<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=400,width=650,left=200,top=150,resizable=no,scrollbars=auto,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
function newPopup2(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=450,width=750,left=200,top=150,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
</script>

</head>
<center>
<body>
<div class="marco_vista">
	<div class="icono"><img src="../../images/pngnew/humanos-de-usuario-icono-7364-96.png" width="40" height="40" /></div>
	<div class="container">
		
			<h1>Mis Estudiantes:</h1>
		
		<!-- BUSQUEDA DE ESTUDIANTES -->
		<?php if($totalRows_alumno>0) { ?>
		<table>
		<?php $lista=1;
		do { ?>
		<tr>
		<td>
			<span class="texto"><?php echo $row_alumno['nombre'];?></span>
		</td>
		<td>
			&nbsp;&nbsp;<a href="JavaScript:newPopup2('detalle_inasistencia.php?cod=<?php echo $row_alumno['alumno_id']; ?>');"><img src="../../images/icons/user.png" width="16" height="16" alt="" align="absmiddle" border="0"/></a>
			&nbsp;<a href="JavaScript:newPopup('detalle_notas.php?cod=<?php echo $row_alumno['alumno_id']; ?>');"><img src="../../images/icons/layout_sidebar.png" width="16" height="16" alt="" align="absmiddle" border="0"/></a>
		</td>
		</tr>
		<?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>	
		</table>	
		<?php }else { ?>
		<span class="texto">No Exiten <br />Estudiantes asociados <br />a ese No. de C&eacute;dula</span><br />
		<?php } ?>
		<br />
		<span class="texto_pequeno"><a href="buscar_estudiante.php" ><--Volver Atr&aacute;s </a></span>
	</div>
	<div class="footer">
	 		Inasistencias:&nbsp;&nbsp;<img src="../../images/icons/user.png" width="16" height="16" alt="" align="absmiddle"/><br />
			Calificaciones:&nbsp;<img src="../../images/icons/layout_sidebar.png" width="16" height="16" alt="" align="absmiddle"/>	
	<!-- <br /><br />Colegionline&reg; <?php echo date(Y);?> --></div>
</div>
</body>
</center>
</html>
<?php
mysql_free_result($alumno);
?>