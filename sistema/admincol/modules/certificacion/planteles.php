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

$colname_mate_eli = "-1";
if (isset($_GET['plantel_id'])) {
  $colname_mate_eli = $_GET['plantel_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_eli = sprintf("SELECT * FROM jos_cdc_nombre_plantel WHERE id=%s", GetSQLValueString($colname_mate_eli, "text"));
$mate_eli = mysql_query($query_mate_eli, $sistemacol) or die(mysql_error());
$row_mate_eli = mysql_fetch_assoc($mate_eli);
$totalRows_mate_eli = mysql_num_rows($mate_eli);

// listado de estudiantes
$maxRows_plantel = 12;
$pageNum_plantel = 0;
if (isset($_GET['pageNum_plantel'])) {
  $pageNum_plantel = $_GET['pageNum_plantel'];
}
$startRow_plantel = $pageNum_plantel * $maxRows_plantel;

mysql_select_db($database_sistemacol, $sistemacol);
$query_plantel = sprintf("SELECT * FROM jos_cdc_nombre_plantel  ORDER BY nombre_plantel ASC");
$query_limit_plantel = sprintf("%s LIMIT %d, %d", $query_plantel, $startRow_plantel, $maxRows_plantel);
$plantel = mysql_query($query_limit_plantel, $sistemacol) or die(mysql_error());
$row_plantel = mysql_fetch_assoc($plantel);

if (isset($_GET['totalRows_plantel'])) {
  $totalRows_plantel = $_GET['totalRows_plantel'];
} else {
  $all_plantel = mysql_query($query_plantel);
  $totalRows_plantel = mysql_num_rows($all_plantel);
}
$totalPages_plantel = ceil($totalRows_plantel/$maxRows_plantel)-1;


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

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de Planteles Educativos Registrados!</h2>
	
	</td></tr>
<tr><td>
<div style="font-size:12px; font-family:verdana; width:200px; height:20px; background-color:#fffccc; margin-bottom:10px; padding-top:5px; padding-left:10px; border:1px solid; ">

<a href="planteles_accion.php"><img src="../../images/icons/nuevo.png" border="0" align="absmiddle">&nbsp;Cargar Nuevo Plantel</a>
</div>
<form action="planteles_detalle.php" name="form" id="form" method="GET" enctype="multipart/form-data" >
<span style="font-size:12px;">Buscar Plantel: </span> 
<input type="text" name="nombre_plantel" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar >" />

</form> 
</tr><td>
<tr><td>

<?php if(($_GET['plantel_id']>0) and ($totalRows_mate_eli==0)){ ?>
<div style="margin-top:20px;">
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">
<p align="center"><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;"Plantel Eliminado con Exito!"</p>
</div>
</div>
<?php }?>
	<br />
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Nombre del Plantel</td>
		<td align="center">Creado</td>
		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center">&nbsp;<?php if($pageNum_plantel==1){ $newlista=$maxRows_plantel+$lista; echo $newlista; $lista ++;   } if ($pageNum_plantel==0){ echo $lista; $lista ++;} ?>&nbsp;</td>
		<td align="center"><?php echo $row_plantel['nombre_plantel']; ?></td>
		<td align="center"><?php echo $row_plantel['creado']; ?></td>
		<td align="center"><a href="plantel_modificacion.php?id=<?php echo $row_plantel['id'];?>"><img src="../../images/icons/modificar.png" border="0" align="absmiddle"></a>&nbsp;<a href="accion_eliminar.php?plantel_id=<?php echo $row_plantel['id'];?>"><img src="../../images/png/cancel_f2.png" width="15" height="15" border="0" align="absmiddle"></a></td>
	</tr>
        <?php } while ($row_plantel = mysql_fetch_assoc($plantel)); ?>	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	<tr>
		<td >
		<?php if ($pageNum_plantel > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_plantel=%d%s", $currentPage, max(0, $pageNum_plantel - 1), $queryString_plantel); ?>">&lt;&lt;Anterior </a>
                          <?php } // Show if not first page ?>
                          <?php if ($pageNum_plantel == 0) { // Show if first page ?>
                          <a href="<?php printf("%s?pageNum_plantel=%d%s", $currentPage, min($totalPages_plantel, $pageNum_plantel + 1), $queryString_plantel); ?>">Siguiente &gt;&gt;</a>
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
mysql_free_result($plantel);
mysql_free_result($mate_eli);

?>
