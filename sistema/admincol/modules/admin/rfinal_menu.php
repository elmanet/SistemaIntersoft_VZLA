<?php require_once('../inc/conexion.inc.php');

// INICIO DE BUSQUEDAS SQL
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
</head>
<center>
<body>
<div id="contenedor_central_modulo">
<?php if ($row_usuario['gid']==25) { // INICIO DE LA CONSULTA 
?>
<table width="400" border="0">
        <tr>
        <td class="titulo_extragrande_gris">RESUMEN</td>
      </tr>
        <tr><td class="enlace"><b>Acciones del M&oacute;dulo</b></td></tr>
      
        <tr><td height="20" valign="top"><a href="../resumen_final/datos_alumno1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Datos de Estudiantes</a></td></tr>
	<tr><td height="20" valign="top"><a href="../resumen_final/confi_fecha.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Configurar Fechas Resumenes</a></td></tr>
	<tr><td height="20" valign="top"><a href="../resumen_final/modificar_resumen1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Modificar Resumen</a></td></tr>

      <tr><td class="enlace"><b>Resumen Final</b></td></tr>
      
      <tr><td height="20" valign="top"><a href="../resumen_final/cargar_resumen1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Cargar Resumen (Final)</a></td></tr>
      <tr><td height="20" valign="top"><a href="../resumen_final/imprimir_resumen1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Imprimir Resumen (Final)</a></td></tr>



      <tr><td class="enlace"><b>Resumen Final-Revisi&oacute;n</b></td></tr>
      
      <tr><td height="20" valign="top"><a href="../resumen_final/cargar_resumen_revision1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Cargar Resumen (Revisi&oacute;n)</a></td></tr>
      <tr><td height="20" valign="top"><a href="../resumen_final/imprimir_resumen_revision1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Imprimir Resumen (Revisi&oacute;n)</a></td></tr>


      <tr><td class="enlace"><b>Materia Pendiente</b></td></tr>

      <tr><td height="20" valign="top"><a href="../resumen_final/cargar_resumen_pendiente1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Cargar N&oacute;mina Materia Pendiente</a></td></tr>
      <tr><td height="20" valign="top"><a href="../resumen_final/cargar_resumen_momento1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Cargar Materia Pendiente (Momentos)</a></td></tr>
      <tr><td height="20" valign="top"><a href="../resumen_final/imprimir_resumen_pendiente1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Imprimir Resumen Materia Pendiente</a></td></tr>
	<tr><td height="20" valign="top"><a href="../resumen_final/admin_asignatura_ept.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Asignaturas Materia Pendiente (NUEVO)</a></td></tr>


		           
      
        <tr><td class="enlace">&nbsp;</td></tr>
      </tr>
      <tr>
        <td height="20" valign="top"></td>
      </tr>
      <tr>
        <td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
     
  </tr>
</table>
<?php } //FIN DE LA CONSULTA 

?> 
</div>
</body>
</center>
</html>
<?php
mysql_free_result($usuario);
?>
