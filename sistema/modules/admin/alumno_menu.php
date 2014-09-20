<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
if (!isset($_SESSION)){ 
  session_start();
}

// ** Logout the current user. **
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
	
  $logoutGoTo = "../acceso/acceso.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php

//AUTORIZACION PARA ENTRAR A LA PAGINA

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
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

$MM_restrictGoTo = "../acceso/acceso_error2.php";
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
// fin de la autorizacion
?>
<?php

// VALIDACION DE VERSION DE PHP
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SISTEMA COLEGIONLINE |</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
<link href="../../css/marca.css" rel="stylesheet" type="text/css" />

</head>
<center>
<body>
<div id="contenedor_central_modulo">
<?php if (($row_usuario['gid']>22) and ($row_usuario['gid']<26)) { // INICIO DE LA CONSULTA 
?>
<table width="500" border="0">
        <tr>
        <td class="titulo_extragrande_gris">MODULO DE ESTUDIANTES</td>
      </tr>
      
      <tr><td class="enlace"><b>Informaci&oacute;n del Estudiante</b></td></tr>
      
      <tr><td height="20" valign="top"><a href="../info/info_estudiante_admin.php">Informaci&oacute;n General</a></td></tr>
      <tr><td height="20" valign="top"><a href="../alumno/estudiante_detalle.php">Informaci&oacute;n Detallada</a></td></tr> 
           
      <tr><td class="enlace"><b>Acciones Nuevas</b></td></tr>
   
      <tr><td height="20" valign="top"><a href="../inscripcion/inscripcion_formal.php" target="_blank" >Agregar o Modificar Estudiante</a></td></tr>
      <tr><td height="20" valign="top"><a href="../inscripcion/inscripcion_formal_rapido.php" target="_blank" >Inscripci&oacute;n R&aacute;pida Estudiante</a></td></tr>
      <tr><td height="20" valign="top"><a href="../inscripcion/autorizar_inscripcion1.php"  >Autorizar Estudiante Inscripci&oacute;n</a></td></tr>
      <tr><td height="20" valign="top"><a href="../inscripcion/listado_preinscritos.php"  >Pre-Inscripciones</a></td></tr>
      <!--<tr><td height="20" valign="top"><a href="../../com_inscripcion/planilla_inscripcion_verifica_rapido.php" >Registro Corto de Estudiante</a></td></tr>-->
       
       <tr><td class="enlace"><b>Matricula</b></td></tr>
       		<tr><td height="20" valign="top"><a href="../acciones/asignar_alumno_01.php">Matricular Estudiante a Secci&oacute;n</a></td></tr>
		<tr><td height="20" valign="top"><a href="../acciones/asignar_alumno_seccion_seleccionar.php">Matricular varios Estudiantes a una Secci&oacute;n</a></td></tr>
		<tr><td height="20" valign="top"><a href="../acciones/datos_alumno1.php" >Verificar Datos Matr&iacute;cula</a></td></tr>	
		<tr><td height="20" valign="top"><a href="../acciones/nolista_alumno_01.php" >Registrar No. de Lista de Estudiantes</a></td></tr>
		<tr><td height="20" valign="top"><a href="../acciones/cambioseccion_alumno_01.php" >Cambiar Estudiante de Secci&oacute;n</a></td></tr>
		<tr><td height="20" valign="top"><a href="../acciones/retirar_estudiante1.php" >Retirar Estudiante del Plantel</a></td></tr>	

      
      <tr><td class="enlace"><b>Reportes</b></td></tr>
      <tr><td height="20" valign="top"><a href="../inscripcion/imprimir_planilla.php" target="_blank">Planilla de Registro</a></td></tr>
      <tr><td height="20" valign="top"><a href="../reportes/seleccionar_anio.php">Reporte de Estudiantes por Secci&oacute;n</a></td></tr>
      <tr><td height="20" valign="top"><a href="../reportes/re_matricula1.php">Reporte de Matr&iacute;cula</a></td></tr>
      <tr><td height="20" valign="top"><a href="#">Modificaci&oacute;n de Matricula</a></td></tr>

		
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
