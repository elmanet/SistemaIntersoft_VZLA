<?php 
// CONEXION CON LA BASE DE DATOS 
require_once('../../Connections/sistemacol.php'); ?>
<?php 
//INICIO DE SESION 
if (!isset($_SESSION)){
  session_start();

}

// ** LOGUEO DE USUARIOS **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../../../modules/acceso/acceso.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
// FIN DEL LOGUEO DE USUARIOS
?>
<?php
if (!isset($_SESSION)) {
  session_start();

   include("verifica_sesion.php");

}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** RETRICCION DE ACCESO A LA PAGINA ***
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../../modules/acceso/acceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
// FIN DE LA RESTRICCION DE LA PAGINA 
?>

<?php
// VERIFICACION DE LA VERSION DE PHP
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
// FIN DE LA VERIFICACION DE LA VERSION DE PHP

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

$colname_alumno = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_alumno = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_users a, jos_alumno_info b WHERE a.id=b.joomla_id AND email = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

// FIN DE BUSQUEDAS SQL
  
//HOJA DE MENU DE MODULOS DE ColegiOnline
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css">
<link href="../../css/fondo.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../../images/favicon.ico">
</head>
<center>
<body>
<!-- INICIO DEL CONTENEDOR PRINCIPAL -->
<div id="contenedor_menu_top">
	<div id="logo"></div>
	<div style="float:left; margin-left:30px; margin-top:15px; "><span class="texto_pequeno_gris" style="color:#fff;"> <b>Conectado como:</b> <?php echo $row_usuario['name'];?> </span> </div>
	      <?php if ($row_usuario['gid']==25){ // INICIO DE LA CONSULTA ?>
	<div  style="float:left; margin-left:30px; margin-top:5px;"><a href="../../../modules/acceso/index.php"><span class="texto_pequeno_gris" style="color:#fff;"><img src="../../images/pngnew/nino-de-usuario-icono-8714-96.png" width="32" height="32" border="0" align="absmiddle">&nbsp;Administraci&oacute;n y Coordinaci&oacute;n</span></a> </div>
	      <?php } // FIN DE LA CONSULTA ?>
	<div  style="float:left; margin-left:30px; margin-top:5px;"><a href="<?php echo $logoutAction ?>"><span class="texto_pequeno_gris" style="color:#fff;"><img src="../../images/png/inicio3.png" width="32" height="32" border="0" align="absmiddle">&nbsp;<b>CERRAR SESION</b></span></a> </div>
</div>

	<table><tr><td>
	<div id="contenedor_central_modulo">

      <?php if (($row_usuario['gid']>0) and ($row_usuario['gid']<25)){ // INICIO DE LA CONSULTA 
      ?>
 <p><a href="<?php echo $logoutAction ?>"><span class="texto_mediano_gris" sytle="color:#fff;">.</span></a> 
</p>
	No estas autorizado para esta area..
	<?php } ?>  

      <?php if ($row_usuario['gid']==25){ // INICIO DE LA CONSULTA 
      ?>
<!-- INICIO DE AREA ADMINISTRATIVA -->   

<h1><img src="../../images/pngnew/biblioteca-icono-3766-128.png" width="60" height="60" border="0" align="absmiddle">EVALUACI&Oacute;N Y CONTROL DE ESTUDIO</h1>
<span class="texto_grande_gris">Institución: <?php echo $row_colegio['nomcol']; ?></span>
	<div id="menu">
		<table width="100%">
			<tr>
				<td><a href="../admin/rcalificaciones_menu.php" target="frame"><img src="../../images/pngnew/archivo-de-la-biblioteca-icono-8962-128.png" alt="" width="70" height="70" border="0" /></a></td>
				<td><a href="../admin/boletines_menu.php" target="frame" ><img src="../../images/png/hoja354.png" alt="" width="70" height="70" border="0" /></a></td>
				<td><a href="../admin/rfinal_menu.php" target="frame" ><img src="../../images/pngnew/los-derechos-de-carpeta-de-usuario-icono-4877-96.png" height="70" width="70"  border="0"  alt="" /></a></td>
				<td><a href="../admin/cnotas_menu.php" target="frame"><img src="../../images/pngnew/beos-bloques-icono-8737-96.png" alt="" width="70" height="70" border="0" /></a></td>
				<td><a href="../admin/matricula_menu.php" target="frame"><img src="../../images/pngnew/netvibes-user-icono-4355-128.png" alt="" width="70" height="70" border="0" /></a></td>
				<td><a href="../../../modules/acciones/imprimir_titulo1.php" target="frame"><img src="../../images/pngnew/certificado.png" alt="" width="70" height="70" border="0" /></a></td>
				<td><a href="../admin/confi_menu.php" target="frame"><img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" alt="" width="70" height="70" border="0" /></a></td>
			</tr>
			<tr>
				<td valing="top" ><a href="../admin/rcalificaciones_menu.php" target="frame">Reportes de </br> Calificaciones</a></td>
				<td valing="top"><a href="../admin/boletines_menu.php" target="frame">Informes y </br>Boletines</a></td>
				<td valing="top"><a href="../admin/rfinal_menu.php"  target="frame">Resumen</br> de A&ntilde;o</a></td>
				<td valing="top"><a href="../admin/cnotas_menu.php" target="frame">Certificación  </br>de Calificaciones</a></td>
				<td valing="top"><a href="../admin/matricula_menu.php" target="frame">Matricula</a></td>
				<td valing="top"><a href="../../../modules/acciones/imprimir_titulo1.php" target="frame">Titulos</a></td>
				<td valing="top"><a href="../admin/confi_menu.php" target="frame">Configuración</br>del Sistema</a></td>
			</tr>			
		</table>		
	</div>
	<span class="resaltar">&quot;No olvides Cerrar tu Sesión al Terminar&quot;</br>
		</span>
	<div id="contenido_administrativo">
	 <iframe name="frame" id="frame" width="900" height="600" scrolling="auto" frameborder="0" src="../admin/inicio_menu.php">
	 </iframe>
	 </div>

<!-- FIN DE AREA ADMINISTRATIVA -->

<?php } //FIN DE LA CONSULTA 

?> 

 <?php if ($row_usuario['gid']==100){ // ******* AUDITORIA ******* 
      ?>

<!-- INICIO DE AREA ADMINISTRATIVA -->   

<h1><img src="../../images/pngnew/usuario-administrador-personal-icono-9746-128.png" width="80" height="80" border="0" align="absmiddle">AUDITORIA DEL SISTEMA</h1>
<table><tr><td>
<span class="texto_grande_gris">Institución: <?php echo $row_colegio['nomcol']; ?></span>
</td></tr>

<tr><td><a href="index.php" target="frame1">Volver al menuprin</a></td>
</tr>
</table>

	<div id="menux" style="margin-top:50px; margin-bottom:30px;" align="center">
		<table width="100%">
			<tr>
				<td align="center"><a href="../admin/rcalificaciones_menu.php" target="frame"><img src="../../images/pngnew/preferencias-de-escritorio-de-la-criptografia-icono-6094-128.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/boletines_menu.php" target="frame" ><img src="../../images/png/hoja354.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/rfinal_menu.php" target="frame" ><img src="../../images/pngnew/los-derechos-de-carpeta-de-usuario-icono-4877-96.png" height="70" width="70"  border="0"  alt="" /></a></td>
				<td align="center"><a href="../admin/cnotas_menu.php" target="frame"><img src="../../images/pngnew/beos-bloques-icono-8737-96.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/matricula_menu.php" target="frame"><img src="../../images/pngnew/netvibes-user-icono-4355-128.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/certificado_menu.php" target="frame"><img src="../../images/pngnew/certificado.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/confi_menu.php" target="frame"><img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" alt="" width="70" height="70" border="0" /></a></td>
			</tr>
			<tr>
				<td valing="top" align="center" ><a href="../admin/rcalificaciones_menu.php" target="frame">Cambiar </br> Contrase&ntilde;a</a></td>
				<td valing="top" align="center"><a href="../admin/boletines_menu.php" target="frame">Informes y </br>Boletines</a></td>
				<td valing="top" align="center"><a href="../admin/rfinal_menu.php"  target="frame">Resumen</br> Final</a></td>
				<td valing="top" align="center"><a href="../admin/cnotas_menu.php" target="frame">Certificación  </br>de Calificaciones</a></td>
				<td valing="top" align="center"><a href="../admin/matricula_menu.php" target="frame">Matricula</a></td>
				<td valing="top" align="center"><a href="../admin/certificado_menu.php" target="frame">Titulos</a></td>
				<td valing="top" align="center"><a href="../admin/confi_menu.php" target="frame">Configuración</br>del Plantel</a></td>
			</tr>	

<tr>
				<td align="center"><a href="../admin/rcalificaciones_menu.php" target="frame"><img src="../../images/pngnew/archivo-de-la-biblioteca-icono-8962-128.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/boletines_menu.php" target="frame" ><img src="../../images/png/hoja354.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/rfinal_menu.php" target="frame" ><img src="../../images/pngnew/los-derechos-de-carpeta-de-usuario-icono-4877-96.png" height="70" width="70"  border="0"  alt="" /></a></td>
				<td align="center"><a href="../admin/cnotas_menu.php" target="frame"><img src="../../images/pngnew/beos-bloques-icono-8737-96.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/matricula_menu.php" target="frame"><img src="../../images/pngnew/netvibes-user-icono-4355-128.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/certificado_menu.php" target="frame"><img src="../../images/pngnew/certificado.png" alt="" width="70" height="70" border="0" /></a></td>
				<td align="center"><a href="../admin/confi_menu.php" target="frame"><img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" alt="" width="70" height="70" border="0" /></a></td>
			</tr>
			<tr>
				<td valing="top" align="center" ><a href="../admin/rcalificaciones_menu.php" target="frame">Reporte de </br> Calificaciones</a></td>
				<td valing="top" align="center"><a href="../admin/boletines_menu.php" target="frame">Informes y </br>Boletines</a></td>
				<td valing="top" align="center"><a href="../admin/rfinal_menu.php"  target="frame">Resumen</br> Final</a></td>
				<td valing="top" align="center"><a href="../admin/cnotas_menu.php" target="frame">Certificación  </br>de Calificaciones</a></td>
				<td valing="top" align="center"><a href="../admin/matricula_menu.php" target="frame">Matricula</a></td>
				<td valing="top" align="center"><a href="../admin/certificado_menu.php" target="frame">Titulos</a></td>
				<td valing="top" align="center"><a href="../admin/confi_menu.php" target="frame">Configuración</br>del Plantel</a></td>
			</tr>	
		
		</table>		
	</div>
	<span class="resaltar">&quot;No olvides Cerrar tu Sesión al Terminar&quot;</br>
		</span>
	<div id="contenido_administrativo">

	 </div>

<!-- FIN DE AREA ADMINISTRATIVA -->

<?php } //FIN DE LA CONSULTA 

?> 

		<div id="contenedor_vacio">
		</br>		
		</div>
	</div>
	</td></tr></table>
<!-- FIN DEL CONTENEDOR PRINCIPAL -->

		<div id="contenedor_vacio">
		</br>		
		</div>
	</div>
	</td></tr></table>
	<br />
		<br />
			<br />
				<br />
				<span class="texto_pequeno_gris">| <a href="http://www.intersoftlatin.com/index.php/quienes-somos" target="_blank">Quienes Somos?</a></span><span class="texto_pequeno_gris"> | <a href="http://www.intersoftlatin.com/index.php/contacto" target="_blank">Contactanos</a> |</span>
				<br />
				<span class="texto_pequeno_gris"> Todos los derechos reservados 2011 &copy; INTERSOFT-latin</span>
				<br />
				<br />
				<br />
				
</body>
</center>
</html>
<?php
mysql_free_result($usuario);

mysql_free_result($alumno);
?>
