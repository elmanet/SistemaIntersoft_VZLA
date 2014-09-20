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
$query_planestudio = "SELECT * FROM jos_cdc_planestudio ORDER BY id ASC";
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);

$colname_mate_eli = "-1";
if (isset($_GET['mate_id'])) {
  $colname_mate_eli = $_GET['mate_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_eli = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas WHERE id=%s", GetSQLValueString($colname_mate_eli, "text"));
$mate_eli = mysql_query($query_mate_eli, $sistemacol) or die(mysql_error());
$row_mate_eli = mysql_fetch_assoc($mate_eli);
$totalRows_mate_eli = mysql_num_rows($mate_eli);

// listado de estudiantes
$maxRows_mate = 10;
$pageNum_mate = 0;
if (isset($_GET['pageNum_mate'])) {
  $pageNum_mate = $_GET['pageNum_mate'];
}
$startRow_mate = $pageNum_mate * $maxRows_mate;

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate = sprintf("SELECT a.id, a.nombre_asignatura, c.cod, a.orden_asignatura, b.nombre_anio, a.creado  FROM jos_cdc_pensum_asignaturas a, jos_cdc_pensum_anios b, jos_cdc_planestudio c WHERE a.anio_id=b.id AND b.planestudio_id=c.id ORDER BY a.creado DESC");
$query_limit_mate = sprintf("%s LIMIT %d, %d", $query_mate, $startRow_mate, $maxRows_mate);
$mate = mysql_query($query_limit_mate, $sistemacol) or die(mysql_error());
$row_mate = mysql_fetch_assoc($mate);

if (isset($_GET['totalRows_mate'])) {
  $totalRows_mate = $_GET['totalRows_mate'];
} else {
  $all_mate = mysql_query($query_mate);
  $totalRows_mate = mysql_num_rows($all_mate);
}
$totalPages_mate = ceil($totalRows_mate/$maxRows_mate)-1;


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
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de Asignaturas - Pensum de Estudio!</h2>
	
	</td></tr>
<tr><td>
<div style="font-size:12px; font-family:verdana; width:200px; height:20px; background-color:#fffccc; margin-bottom:10px; padding-top:5px; padding-left:10px; border:1px solid; ">

<a href="pensum_materias_accion.php"><img src="../../images/icons/nuevo.png" border="0" align="absmiddle">&nbsp;Cargar Asignaturas</a>
</div>

<form action="pensum_materias_detalle.php" name="form" id="form" method="GET" enctype="multipart/form-data">
<span style="font-size:12px;">Selecciona Plan de Estudio: </span> <select name="9812HHFJHJHF63883B3CNCH7" id="9812HHFJHJHF63883B3CNCH7">
				<?php
				do { ?>
             			<option value="<?php echo $row_planestudio['id']; ?>"><?php echo $row_planestudio['cod']."/".$row_planestudio['plan_estudio']; ?></option>
             			<?php } while ($row_planestudio = mysql_fetch_assoc($planestudio)); ?>
             		</select>
<input type="submit" name="buttom" value="Buscar >" />

</form> 

</tr><td>
<tr><td>
<?php if(($_GET['mate_id']>0) and ($totalRows_mate_eli==0)){ ?>
<div style="margin-top:20px;">
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">
<p align="center"><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;"Asignatura Eliminada con Exito!"</p>
</div>
</div>
<?php }?>
<br />		
<table style="font-size:10px; font-family:verdana;" width="90%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">

		<td align="center">Descripci&oacute;n</td>
		<td align="center">Cod Plan/Estudio</td>
		<td align="center">A&ntilde;o</td>
		<td align="center">Orden Asig.</td>
		<td align="center">Creado</td>
		<td align="center">Acciones</td>
	</tr>
	<?php 
	do { ?>
	<tr >
		
		<td align="center"><?php echo $row_mate['nombre_asignatura']; ?></td>
		<td align="center"><?php echo $row_mate['cod']; ?></td>
		<td align="center"><?php echo $row_mate['nombre_anio']; ?></td>
		<td align="center"><?php echo $row_mate['orden_asignatura']; ?></td>
		<td align="center"><?php echo $row_mate['creado']; ?></td>
		<td align="center"><a href="pensum_materias_modificacion.php?id=<?php echo $row_mate['id'];?>"><img src="../../images/icons/modificar.png" border="0" align="absmiddle"></a><?php /* &nbsp;<a href="accion_eliminar.php?mate_id=<?php echo $row_mate['id'];?>"><img src="../../images/png/cancel_f2.png" width="15" height="15" border="0" align="absmiddle"></a> */ ?></td>
	</tr>
        <?php } while ($row_mate = mysql_fetch_assoc($mate)); ?>	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	<tr>
		<td >
		<?php if ($pageNum_mate >= 1) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_mate=%d%s", $currentPage, max(0, $pageNum_mate - 1), $queryString_mate); ?>">&lt;&lt;Anterior </a>
                          <?php } // Show if not first page ?>
                          <?php if ($pageNum_mate >= 0) { // Show if first page ?>
                          <a href="<?php printf("%s?pageNum_mate=%d%s", $currentPage, min($totalPages_mate, $pageNum_mate + 1), $queryString_mate); ?>">Siguiente &gt;&gt;</a>
                          <?php } // Show if first page ?>
		</td>
	</tr>

	<tr><td align="center">

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
mysql_free_result($mate_eli);
mysql_free_result($mate);

?>
