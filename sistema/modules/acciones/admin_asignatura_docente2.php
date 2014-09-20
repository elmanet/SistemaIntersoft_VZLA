<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
//initialize the session
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
// 	GRABADO EN LA TABLA 



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

   $insertSQL = sprintf("INSERT INTO jos_asignatura (id, tipo_asignatura, orden_asignatura, docente_id, curso_id, periodo, asignatura_nombre_id) VALUES (%s, %s, %s, %s, %s, %s, %s)",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['tipo_asignatura'], "text"),
							GetSQLValueString($_POST['orden_asignatura'], "int"),
							GetSQLValueString($_POST['docente_id'], "int"),
							GetSQLValueString($_POST['curso_id'], "int"),
							GetSQLValueString($_POST['periodo'], "text"),
							GetSQLValueString($_POST['asignatura_nombre_id'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "admin_asignatura_docente.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}


// CONSULTA SQL

mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT * FROM jos_docente ORDER BY nombre_docente ASC");
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asigna = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asigna = mysql_query($query_asigna, $sistemacol) or die(mysql_error());
$row_asigna = mysql_fetch_assoc($asigna);
$totalRows_asigna = mysql_num_rows($asigna);


mysql_select_db($database_sistemacol, $sistemacol);
$query_cursos = sprintf("SELECT a.id, b.descripcion, c.nombre FROM jos_curso a, jos_seccion b, jos_anio_nombre c WHERE a.seccion_id=b.id AND a.anio_id=c.id ORDER BY c.numero_anio, b.id");
$cursos = mysql_query($query_cursos, $sistemacol) or die(mysql_error());
$row_cursos = mysql_fetch_assoc($cursos);
$totalRows_cursos = mysql_num_rows($cursos);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

// FIN DE LA CONSULTA SQL 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />

</head>
<center>
<body>

<div id="contenedor_central_modulo">
<table width="500" border="0">
  <tr>
    <td width="128"><img src="../../images/pngnew/nino-de-usuario-icono-8714-96.png" width="75" height="75" /></td>
    <td width="362"><table width="100%" border="0">
      <tr>
        <td class="titulo_extragrande_gris" colspan="2">ASOCIAR DOCENTE A ASIGNATURA</td>
      </tr>
      <tr><td>
	
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
		   
	<tr><td align="left">Selecciona el Curso:</td></tr>
	<tr><td>
	<select name="curso_id" class="texto_mediano_gris" id="curso_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_cursos['id']; ?>"><?php echo $row_cursos['nombre']." ".$row_cursos['descripcion']; ?></option>
           <?php } while ($row_cursos = mysql_fetch_assoc($cursos));
  	   $rows = mysql_num_rows($cursos);
  	   if($rows > 0) {
           mysql_data_seek($cursos, 0);
	  $row_cursos = mysql_fetch_assoc($cursos);
		 }
	   ?>
         </select></td></tr>
         
       <tr><td align="left">Selecciona la Asignatura:</td></tr>
	<tr><td>
	<select name="asignatura_nombre_id" class="texto_mediano_gris" id="asignatura_nombre_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_asigna['id']; ?>"><?php echo $row_asigna['nombre']; ?></option>
           <?php } while ($row_asigna = mysql_fetch_assoc($asigna));
  	   $rows = mysql_num_rows($asigna);
  	   if($rows > 0) {
           mysql_data_seek($asigna, 0);
	  $row_asigna = mysql_fetch_assoc($asigna);
		 }
	   ?>
         </select></td></tr>

       <tr><td align="left">Selecciona el Docente:</td></tr>
	<tr><td>
	<select name="docente_id" class="texto_mediano_gris" id="docente_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_docente['id']; ?>"><?php echo $row_docente['nombre_docente']." ".$row_docente['apellido_docente']; ?></option>
           <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
           mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
         </select></td></tr>
         
<tr><td align="left">
	Tipo de Asignatura:
</td></tr>
<tr><td>

	     <select name="tipo_asignatura" id="tipo_asignatura">
	     <option value="">Normal</option>
	     <option value="educacion_trabajo">Educaci&oacute;n para el Trabajo</option>
	     <option value="premilitar">Pre-Militar</option>
             <option value="primaria">Primaria</option>
             </select>
</td></tr>
<tr><td align="left">
	Orden de la Asignatura:
</td></tr>
<tr><td align="left">
	<input name="orden_asignatura" type="text" id="orden_asignatura" value="" size="4"/>
</td></tr>
<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="">
	<input name="periodo" type="hidden" id="periodo" value="<?php echo $row_periodo['id'];?>">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Asociar Docente >" />
	
	<input type="hidden" name="MM_insert" value="form1">
      </form>
	</td></tr>
     
 </td></tr>
      

      <tr>
        <td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
      </tr>
    </table></td>
  </tr>
</table>

</div>

</body>
</center>
</html>
<?php
mysql_free_result($docente);
mysql_free_result($asigna);
mysql_free_result($cursos);
mysql_free_result($periodo);
?>
