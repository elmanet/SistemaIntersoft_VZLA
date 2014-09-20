<?php require_once('../inc/conexion_sinsesion.inc.php'); 
// CONSULTA SQL

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi = "SELECT * FROM jos_formato_evaluacion_confi";
$confi = mysql_query($query_confi, $sistemacol) or die(mysql_error());
$row_confi = mysql_fetch_assoc($confi);
$totalRows_confi = mysql_num_rows($confi);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lap = "SELECT * FROM jos_lapso_encurso";
$lap = mysql_query($query_lap, $sistemacol) or die(mysql_error());
$row_lap = mysql_fetch_assoc($lap);
$totalRows_lap = mysql_num_rows($lap);

$formato=$row_confi['codfor'];
$lap=$row_lap['cod'];

$colname_alumno = "-1";
if (isset($_GET['cod'])) {
  $colname_alumno = $_GET['cod'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT a.nombre, a.apellido, a.cedula, a.alumno_id, b.p1f1, b.p1f2, b.p2f1, b.p2f2, b.p3f1, b.p3f2, b.p4f1, b.p4f2, b.p5f1, b.p5f2, d.nombre as mate, b.asignatura_id FROM jos_alumno_info a, jos_formato_evaluacion_$formato b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND b.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND b.lapso=$lap AND a.alumno_id = %s", GetSQLValueString($colname_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />

</head>
<center>
<body>
<h2>Reporte de Calificaciones</h2>

<?php if($totalRows_alumno>0) {?>
<div style="text-align:left; width:600px;margin-bottom:25px;" >
<span class="texto_mediano_gris"><strong>Estudiante:</strong> <?php echo $row_alumno['nombre']." ".$row_alumno['apellido'];?></span><br /><br />
	<div class="divredondeado">
		<span class="texto_mediano_gris"><strong><?php echo $row_lap['descripcion'];?></strong></span>
	</div>
</div>
<table class="tab" border="1" width="600">
<tr class="titulo">
<td width="200">Nombre de la Asignatura</td>
<td width="40">N1</td>
<td width="40">Art112</td>
<td width="40">N2</td>
<td width="40">Art112</td>
<td width="40">N3</td>
<td width="40">Art112</td>
<td width="40">N4</td>
<td width="40">Art112</td>
<td width="40">N5</td>
<td width="40">Art112</td>
</tr>
<?php do { ?>
<tr class="contenido">
<td><?php echo $row_alumno['mate'];?></td>
<td><?php echo $row_alumno['p1f1'];?></td>
<td><?php echo $row_alumno['p1f2'];?></td>
<td><?php echo $row_alumno['p2f1'];?></td>
<td><?php echo $row_alumno['p2f2'];?></td>
<td><?php echo $row_alumno['p3f1'];?></td>
<td><?php echo $row_alumno['p3f2'];?></td>
<td><?php echo $row_alumno['p4f1'];?></td>
<td><?php echo $row_alumno['p4f2'];?></td>
<td><?php echo $row_alumno['p5f1'];?></td>
<td><?php echo $row_alumno['p5f2'];?></td>
</tr>
<?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>
</table>
<?php } else { ?>
<div style="text-align:left; width:600px;margin-bottom:25px;" >
	<div class="divredondeado2">
		<br />
		<img src="../../images/png/atencion.png" width="90" alt="" /><br /><br />
		<span class="texto_mediano_gris">No se han Cargado Calificaciones</span> 
	</div>
</div>
<?php } ?>
	
<div class="texto_pequeno_gris">Colegionline&reg; <?php echo date(Y);?></div>
	
</body>
</center>
</html>
<?php
mysql_free_result($alumno);
mysql_free_result($confi);
?>