<?php require_once('../inc/conexion.inc.php');

// CONSULTA SQL
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_institucion";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

// INICIO DE BUSQUEDAS SQL
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT name, username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$colname_usuacor = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuacor = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuacor = sprintf("SELECT a.username, a.password, a.gid, b.tipo_docente FROM jos_users a, jos_secretaria_coordinador b WHERE a.id=b.joomla_id AND a.username = %s", GetSQLValueString($colname_usuacor, "text"));
$usuacor = mysql_query($query_usuacor, $sistemacol) or die(mysql_error());
$row_usuacor = mysql_fetch_assoc($usuacor);
$totalRows_usuacor = mysql_num_rows($usuacor);


$colname_alumno = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_alumno = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_users a, jos_alumno_info b WHERE a.id=b.joomla_id AND username = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso_encurso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso_encurso = mysql_query($query_lapso_encurso, $sistemacol) or die(mysql_error());
$row_lapso_encurso = mysql_fetch_assoc($lapso_encurso);
$totalRows_lapso_encurso = mysql_num_rows($lapso_encurso);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi_asistencia = sprintf("SELECT * FROM jos_alumno_asistencia_confi");
$confi_asistencia = mysql_query($query_confi_asistencia, $sistemacol) or die(mysql_error());
$row_confi_asistencia = mysql_fetch_assoc($confi_asistencia);
$totalRows_confi_asistencia = mysql_num_rows($confi_asistencia);
$confi_asis=$row_confi_asistencia['cod'];

$colname_inasistencia = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_inasistencia = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inasistencia = sprintf("SELECT * FROM jos_users a, jos_alumno_asistencia_coordinacion b WHERE b.user_id=a.id AND a.username = %s", GetSQLValueString($colname_inasistencia, "int"));
$inasistencia = mysql_query($query_inasistencia, $sistemacol) or die(mysql_error());
$row_inasistencia = mysql_fetch_assoc($inasistencia);
$totalRows_inasistencia = mysql_num_rows($inasistencia);

mysql_select_db($database_sistemacol, $sistemacol);
$query_anoescolar = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$anoescolar = mysql_query($query_anoescolar, $sistemacol) or die(mysql_error());
$row_anoescolar = mysql_fetch_assoc($anoescolar);
$totalRows_anoescolar = mysql_num_rows($anoescolar);

// FIN DE BUSQUEDAS SQL
  
//HOJA DE MENU DE MODULOS DE ColegiOnline
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; utf-8" />
<title>INTERSOFT | Software Educativo</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css">
<link href="../../css/fondo.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../../images/favicon.ico">
</head>
<center>
<body>

<?php if ($row_usuario['gid']==25){ // INICIO DE LA CONSULTA ?>
<!--

<div style="color:#fff; font-family:verdana; width:120px; height:60px; background-color:green; position:fixed !important; right:0px; top:80px; z-index:10 !important; -moz-border-radius:15px 15px 0px 0px;-webkit-border-radius:15px 0px 0px 15px;box-shadow: 3px 3px 4pc #ccc;-webkit-box-shadow: 3px 3px 4px #000;-moz-box-shadow: 3px 3px 4px #000;">
<br />
<span class="texto_pequeno_gris" style="color:#fff;">
Periodo Seleccionado<br />
<?php echo $row_anoescolar['descripcion'];?>
</span>

</div>



<div style="color:#fff; font-family:verdana; width:120px; height:110px; background-color:green; position:fixed !important; right:0px; top:170px; z-index:10 !important; -moz-border-radius:15px 15px 0px 0px;-webkit-border-radius:15px 0px 0px 15px;box-shadow: 3px 3px 4pc #ccc;-webkit-box-shadow: 3px 3px 4px #000;-moz-box-shadow: 3px 3px 4px #000;">

<br /><img src="../../images/pngnew/busqueda-de-los-usuarios-del-hombre-icono-6234-48.png"  width="35" alt="" ><br />
Ver Periodo:<br />
<?php if($row_anoescolar['descripcion']=="2013-2014") {?>
<a href="<?php echo $row_anoescolar['direccion'];?>1112" class="texto_pequeno_gris" style="color:#fff;">2011-2012</a><br/>
<a href="<?php echo $row_anoescolar['direccion'];?>1213" class="texto_pequeno_gris" style="color:#fff;">2012-2013</a><br/>
<?php } 
if($row_anoescolar['descripcion']=="2011-2012") {?>
<a href="<?php echo $row_anoescolar['direccion'];?>1213" class="texto_pequeno_gris" style="color:#fff;">2012-2013</a><br/>
<a href="<?php echo $row_anoescolar['direccion'];?>" class="texto_pequeno_gris" style="color:#fff;">2013-2014</a>
<?php } 
if($row_anoescolar['descripcion']=="2012-2013") {?>
<a href="<?php echo $row_anoescolar['direccion'];?>1112" class="texto_pequeno_gris" style="color:#fff;">2011-2012</a><br/>
<a href="<?php echo $row_anoescolar['direccion'];?>" class="texto_pequeno_gris" style="color:#fff;">2013-2014</a>
<?php } ?>
</div>
-->

<?php }	?>


<!-- INICIO DEL CONTENEDOR PRINCIPAL -->
<div id="contenedor_menu_top">
	<!-- <div id="logo"></div> -->
	<div style="float: left; padding-left:50px;">
		<img src="../../images/<?php echo $row_users['logocol'];?> " height="40" alt="" align="middle">
	</div>
	<div style="float: left;padding-left:5px;">
		<span class="texto_pequeno_gris" style="color:#fff;"><?php echo $row_users['nomcol'];?></span><br />
		<span class="texto_pequeno_gris" style="color:#fff;">Sistema Automatizado Educativo</span>
	</div>	
	
	<span class="texto_pequeno_gris" style="color:#fff;"> <b>Conectado como:</b> <?php echo $row_usuario['name'];?> </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<?php if ($row_usuario['gid']==25){ // INICIO DE LA CONSULTA ?>
	<a href="../../admincol/modules/acceso/index.php"><span class="texto_pequeno_gris" style="color:#fff;"><img src="../../images/pngnew/biblioteca-icono-3766-128.png" width="32" height="32" border="0" align="absmiddle">&nbsp;Dpto. de Evaluaci&oacute;n y Control de Estudio</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 	     
	 <?php } // FIN DE LA CONSULTA ?>
	<a href="<?php echo $logoutAction ?>"><span class="texto_pequeno_gris" style="color:#fff;"><img src="../../images/png/inicio3.png" width="32" height="32" border="0" align="absmiddle">&nbsp;<b>CERRAR SESION</b></span></a>
	</div>


	<div id="contenedor_central_modulo">
  <div id="container_mf">
      <?php if ($row_usuario['gid']==18){ // INICIO DE LA CONSULTA ?>

<!-- INICIO DE AREA DE ALUMNOS --> 
    
	<div id="menu">
		<ul style="list-style:none;-webkit-padding-start: 0px;">
			<li><a href="../alumno/usuario.php?id=<?php echo $row_alumno['alumno_id']; ?>" target="frame"><img src="../../images/png/edit_user.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../alumno/horario_examen.php" target="frame" ><img src="../../images/png/calendario.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../asignaturas/calificaciones.php?abc=<?php echo $row_lapso_encurso['cod'];?>&us=<?php echo $row_alumno['alumno_id']; ?>" target="frame"><img src="../../images/png/Search.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../info/info_alumno.php" target="frame"><img src="../../images/png/preguntas.png" alt="" width="70" height="70" border="0" /></a></li>
		</ul>
	</div>
	<div id="contenido_alumno">
	 <iframe id="frame" name="frame" scrolling="auto" frameborder="0" src="../admin/inicio_menu.php">
	 </iframe>
	</div>

<!-- FIN DE AREA DE ALUMNOS -->

<?php } //FIN DE LA CONSULTA ?> 

<?php if ($row_usuario['gid']==19){ // INICIO DE LA CONSULTA ?>

<!-- INICIO DE AREA DE DOCENTES -->

	<div id="menu">
		<ul style="list-style:none;-webkit-padding-start: 0px;">
			<li><a href="../docente/usuario.php" target="frame"><img src="../../images/png/edit_user.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../docente/publicar_horario_examen01.php" target="frame" ><img src="../../images/png/calendario.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../docente/planificacion.php" target="frame" ><img src="../../images/png/HEINSNEXTGEN APPLICATIONS.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../docente/docente_carganotas_menu.php" target="frame"><img src="../../images/png/Tasks.png" alt="" width="70" height="70" border="0" /></a></li>
			<?php if($confi_asis==1){?>   
				<li><a href="../acciones/asistencia_alumno_menu.php" target="frame"><img src="../../images/png/Documents.png" height="70" width="70" alt="" border="0"/></a></li>
			<?php } ?>
			<?php if(($totalRows_inasistencia>0) and ($confi_asis==0)){ ?>
				<li><a href="../acciones/asistencia_alumno_menu.php" target="frame"><img src="../../images/png/Documents.png" height="70" width="70" alt="" border="0"/></a></li>
			<?php } ?>
				<li><a href="../docente/seleccionar_anio_re_estudiantes.php" target="frame"><img src="../../images/png/Search.png" alt="" width="70" height="70" border="0" /></a></li>
				<li><a href="../info/info_alumno.php" target="frame"><img src="../../images/png/preguntas.png" alt="" width="70" height="70" border="0" /></a></li>
			</ul>		
	</div>
	
	<div id="contenido_alumno">
	 <iframe id="frame" name="frame" scrolling="auto" frameborder="0" src="../admin/inicio_menu.php">
	 </iframe>
	</div>

<!-- FIN DE AREA DE DOCENTES  -->

		<?php } //FIN DE LA CONSULTA 		?>
		
<?php if ($row_usuacor['gid']==50){ // INICIO DE LA CONSULTA ?>

<!-- INICIO DE AREA DE SECRETARIAS -->
	
	<div id="menu">
	<ul style="list-style:none;-webkit-padding-start: 0px;">
			<li><a href="../admin/alumno_menu2.php" target="frame"><img src="../../images/png/add_user.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../../admincol/modules/admin/rcalificaciones_menu2.php" target="frame"><img src="../../images/pngnew/archivo-de-la-biblioteca-icono-8962-128.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../../admincol/modules/calificaciones/selecciona_boletin.php" target="frame" ><img src="../../images/png/hoja354.png" alt="" width="70" height="70" border="0" /></a></li>
			<?php if($confi_asis==1){?>   
				<li><a href="../acciones/asistencia_alumno_menu.php" target="frame"><img src="../../images/png/Documents.png" height="70" width="70" alt="" border="0"/></a></li>
			<?php } ?>
			<?php if(($totalRows_inasistencia>0) and ($confi_asis==0)){ ?>
				<li><a href="../acciones/asistencia_alumno_menu.php" target="frame"><img src="../../images/png/Documents.png" height="70" width="70" alt="" border="0"/></a></li>
			<?php } ?>
				<li><a href="../admin/reportes_menu.php" target="frame"><img src="../../images/png/hoja1.png" alt="" width="70" height="70" border="0" /></a></li>
				<li><a href="../info/info_alumno.php" target="frame"><img src="../../images/png/preguntas.png" alt="" width="70" height="70" border="0" /></a></li>
		</ul>	
	</div>
	<div id="contenido_alumno">
	 <iframe id="frame" name="frame" scrolling="auto" frameborder="0" src="../admin/inicio_menu.php">
	 </iframe>
	</div>

<!-- FIN DE AREA DE COORDINADORES  -->

<?php } //FIN DE LA CONSULTA 	?>
		



 <?php if (($row_usuario['gid']>22) and ($row_usuario['gid']<26)){ // INICIO DE LA CONSULTA  ?>

<!-- INICIO DE AREA ADMINISTRATIVA -->   

	<div id="menu">
		<ul style="list-style:none;-webkit-padding-start: 0px;">
			<li><a href="../admin/alumno_menu.php" target="frame"><img src="../../images/png/add_user.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../admin/docente_menu.php" target="frame" ><img src="../../images/png/docentes.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../admin/coordinacion_menu.php" target="frame" ><img src="../../images/pngnew/usuario-administrador-personal-icono-9746-128.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../admin/asistencia_menu.php" target="frame" ><img src="../../images/png/Tasks.png" height="70" width="70"  border="0"  alt="" /></a></li>
			<li><a href="../admin/reportes_menu.php" target="frame"><img src="../../images/png/hoja1.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../admin/secretaria_menu.php" target="frame"><img src="../../images/pngnew/beos-bloques-icono-8737-96.png" alt="" width="70" height="70" border="0" /></a></li>
			<li><a href="../ayuda/ayuda_mod002.htm" target="frame" ><img src="../../images/png/preguntas.png" alt="" width="70" height="70" border="0" /></a></li>
		</ul>
	</div>
	<div id="contenido_administrativo">
	 <iframe id="frame" name="frame" scrolling="auto" frameborder="0" src="../admin/inicio_menu.php">
	 </iframe>
	 </div>
 </div>
<!-- FIN DE AREA ADMINISTRATIVA -->

<?php } //FIN DE LA CONSULTA 

?> 


		<div id="contenedor_vacio">
		<br />		
		</div>
	</div>

	<br />
		<br />
			<br />
				
	
<!-- FIN DEL CONTENEDOR PRINCIPAL -->
</body>
</center>
</html>
