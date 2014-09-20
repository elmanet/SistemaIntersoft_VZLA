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
<?php if ($row_usuario['gid']>24) { // INICIO DE LA CONSULTA 
?>
<table width="400" border="0">
        <tr>
        <td class="titulo_extragrande_gris">REPORTE DE CALIFICACIONES</td>
      </tr>
      
      <tr><td class="enlace"><b>Información de calificación de Estudiante</b></td></tr>
      
	<tr><td height="20" valign="top"><a href="../calificaciones/seleccionar_seccion_promedios.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Promedio General de Sección</a></td></tr>
	<tr><td height="20" valign="top"><a href="../calificaciones/seleccionar_anio_promedios.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Promedio General por A&ntilde;os</a></td></tr>
        <tr><td height="20" valign="top"><a href="../calificaciones/reporte_promedio_general_lapso.php" target="_blank">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Promedio General de Estudiantes de Lapso </a></td></tr>
	        <tr><td height="20" valign="top"><a href="../calificaciones/reporte_promedio_general_anio.php" target="_blank">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Promedio General de Estudiantes de A&ntilde;o </a></td></tr>
        <tr><td height="20" valign="top"><a href="../calificaciones/reporte_promedio_institucion.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Promedio General de la Institución</a></td></tr>
        <tr><td height="20" valign="top"><a href="../calificaciones/def_anio1.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Reporte Definitivas Estudiantes</a></td></tr>

           
      <tr><td class="enlace"><b>Reportes de Calificaciones</b></td></tr>
   
        <tr><td height="20" valign="top"><a href="../calificaciones/selecciona_notas.php" >
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Resumen de Lapso</a></td></tr>
	<tr><td height="20" valign="top"><a href="../calificaciones/seleccionar_anio_sabana.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Sabana de Calificaciones</a></td></tr>
	<tr><td height="20" valign="top"><a href="../calificaciones/seleccionar_anio_aplazados.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Reporde de Aplazados</a></td></tr>

      <tr><td class="enlace"><b>Control de Estudio</b></td></tr>

        <tr><td height="20" valign="top"><a href="../calificaciones/selecciona_notas_parciales.php" >
                    <img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Modificar Calificaciones Parciales</a></td></tr>
      <tr><td height="20" valign="top"><a href="../calificaciones/selecciona_notas_definitivas.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Agregar/Modificar Calificaciones Definitivas</a></td></tr>
        <tr><td height="20" valign="top"><a href="../calificaciones/selecciona_notas_ajuste.php" >
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Ajuste de Calificaciones</a></td></tr>



      <tr><td class="enlace"><b>Configuraciones</b></td></tr>
      <tr><td height="20" valign="top"><a href="../calificaciones/eliminar_selecciona_nomina.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Eliminar Estudiantes duplicados en N&oacute;minas</a></td></tr>
	<tr><td height="20" valign="top"><a href="../asignaciones/selecciona_estudiante.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Agregar Estudiante a N&oacute;mina</a></td></tr>
      <tr><td height="20" valign="top"><a href="../calificaciones/selecciona_asignaturas_agregarnotas.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Agregar Secci&oacute;n a N&oacute;mina</a></td></tr>		

		
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
