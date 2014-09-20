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

$localidad=$_GET['localidad'];
// listado de estudiantes
mysql_select_db($database_sistemacol, $sistemacol);
$query_localidad = "SELECT * FROM jos_cdc_localidad WHERE localidad like '%$localidad%'";
$localidad = mysql_query($query_localidad, $sistemacol) or die(mysql_error());
$row_localidad = mysql_fetch_assoc($localidad);


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
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de localidades Registradas!</h2>
	
	</td></tr>
<tr><td>
<div style="font-size:12px; font-family:verdana; width:200px; height:20px; background-color:#fffccc; margin-bottom:10px; padding-top:5px; padding-left:10px; border:1px solid; ">

<a href="localidad_accion.php"><img src="../../images/icons/nuevo.png" border="0" align="absmiddle">&nbsp;Cargar Nueva localidad</a>
</div>
<form action="localidad_detalle.php" name="form" id="form" method="GET" enctype="multipart/form-data" >
<span style="font-size:12px;">Buscar Localidad: </span> 
<input type="text" name="localidad" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar >" />

</form> 

</tr><td>
<tr><td>
<?php if(($_GET['localidad_id']>0) and ($totalRows_mate_eli==0)){ ?>
<div style="margin-top:20px;">
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">
<p align="center"><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;"Localidad Eliminada con Exito!"</p>
</div>
</div>
<?php }?>
	<br />	
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Nombre de la localidad</td>
		<td align="center">Creado</td>
		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center">&nbsp;<?php if($pageNum_localidad==1){ $newlista=$maxRows_localidad+$lista; echo $newlista; $lista ++;   } if ($pageNum_localidad==0){ echo $lista; $lista ++;} ?>&nbsp;</td>
		<td align="center"><?php echo $row_localidad['localidad']; ?></td>
		<td align="center"><?php echo $row_localidad['creado']; ?></td>
		<td align="center"><a href="localidad_modificacion.php?id=<?php echo $row_localidad['id'];?>"><img src="../../images/icons/modificar.png" border="0" align="absmiddle"></a>&nbsp;<a href="accion_eliminar.php?localidad_id=<?php echo $row_localidad['id'];?>"><img src="../../images/png/cancel_f2.png" width="15" height="15" border="0" align="absmiddle"></a></td>
	</tr>
        <?php } while ($row_localidad = mysql_fetch_assoc($localidad)); ?>	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>

	<tr>
		<td >
		<?php if ($pageNum_localidad > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_localidad=%d%s", $currentPage, max(0, $pageNum_localidad - 1), $queryString_localidad); ?>">&lt;&lt;Anterior </a>
                          <?php } // Show if not first page ?>
                          <?php if ($pageNum_localidad == 0) { // Show if first page ?>
                          <a href="<?php printf("%s?pageNum_localidad=%d%s", $currentPage, min($totalPages_localidad, $pageNum_localidad + 1), $queryString_localidad); ?>">Siguiente &gt;&gt;</a>
                          <?php } // Show if first page ?>
		</td>
	</tr>

	<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"Estas son las localidades registradas en nuestra base de datos"</p>
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
mysql_free_result($localidad);

?>
