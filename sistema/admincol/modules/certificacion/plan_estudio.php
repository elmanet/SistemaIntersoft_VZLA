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

// listado de estudiantes
$maxRows_planes = 6;
$pageNum_planes = 0;
if (isset($_GET['pageNum_planes'])) {
  $pageNum_planes = $_GET['pageNum_planes'];
}
$startRow_planes = $pageNum_planes * $maxRows_planes;

mysql_select_db($database_sistemacol, $sistemacol);
$query_planes = sprintf("SELECT * FROM jos_cdc_planestudio  ORDER BY id ASC");
$query_limit_planes = sprintf("%s LIMIT %d, %d", $query_planes, $startRow_planes, $maxRows_planes);
$planes = mysql_query($query_limit_planes, $sistemacol) or die(mysql_error());
$row_planes = mysql_fetch_assoc($planes);

if (isset($_GET['totalRows_planes'])) {
  $totalRows_planes = $_GET['totalRows_planes'];
} else {
  $all_planes = mysql_query($query_planes);
  $totalRows_planes = mysql_num_rows($all_planes);
}
$totalPages_planes = ceil($totalRows_planes/$maxRows_planes)-1;


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

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de Planes de Estudio!</h2>
	
	</td></tr>
<tr><td>
<div style="font-size:12px; font-family:verdana; width:200px; height:20px; background-color:#fffccc; margin-bottom:10px; padding-top:5px; padding-left:10px; border:1px solid; ">

<a href="plan_estudio_accion.php"><img src="../../images/icons/nuevo.png" border="0" align="absmiddle">&nbsp;Cargar Plan de Estudio</a>
</div>
</tr><td>
<tr><td>
	
<table style="font-size:10px; font-family:verdana;" width="90%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Cod</td>
		<td align="center">Descripci&oacute;n</td>
		<td align="center">Menci&oacute;n</td>
		<td align="center">Creado</td>
		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center">&nbsp;<?php if($pageNum_planes==1){ $newlista=$maxRows_planes+$lista; echo $newlista; $lista ++;   } if ($pageNum_planes==0){ echo $lista; $lista ++;} ?>&nbsp;</td>
		<td align="center"><?php echo $row_planes['cod']; ?></td>
		<td align="center"><?php echo $row_planes['plan_estudio']; ?></td>
		<td align="center"><?php if($row_planes['mencion']==''){ echo "***";} else { echo $row_planes['mencion'];} ?></td>
		<td align="center"><?php echo $row_planes['creado']; ?></td>
		<td align="center"><a href="plan_estudio_modificacion.php?id=<?php echo $row_planes['id'];?>"><img src="../../images/icons/modificar.png" border="0" align="absmiddle"></a></td>
	</tr>
        <?php } while ($row_planes = mysql_fetch_assoc($planes)); ?>	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	<tr>
		<td >
		<?php if ($pageNum_planes > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_planes=%d%s", $currentPage, max(0, $pageNum_planes - 1), $queryString_planes); ?>">&lt;&lt;Anterior </a>
                          <?php } // Show if not first page ?>
                          <?php if ($pageNum_planes == 0) { // Show if first page ?>
                          <a href="<?php printf("%s?pageNum_planes=%d%s", $currentPage, min($totalPages_planes, $pageNum_planes + 1), $queryString_planes); ?>">Siguiente &gt;&gt;</a>
                          <?php } // Show if first page ?>
		</td>
	</tr>

	<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Estos son los planes de Estudio utilizados por la Zona Educativa, se deseas agregar alguno nuevo debes cargar las asignaturas para ese plan de estudio"</p>
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
mysql_free_result($planes);

?>
