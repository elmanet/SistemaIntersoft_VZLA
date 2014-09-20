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

$colname_reporte = "-1";
if (isset($_GET['curso_id'])) {
  $colname_reporte = $_GET['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion, h.nombre as mate, g.fecha_inasistencia, g.inasistencia, g.inasistencia_alumno FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_alumno_asistencia g, jos_asignatura_nombre h WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.id=g.asignatura_id AND f.asignatura_nombre_id=h.id AND g.alumno_id=a.alumno_id AND d.id=%s ORDER BY g.id DESC", GetSQLValueString($colname_reporte, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: COLEGIONLINE ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
        <h1>INASISTENCIAS AGREGADAS CON EXITO!</h1>
        <h2><span style="color: red; font-size: 14px; font-family: verdana; text-align: right;" > <b>Para cargar mas inasistencias cierra esta ventana...</b></span></h2>

        <table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">
                <td width="80" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">No. Lista</span></div></td>
		<td width="100" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Cedula</span></div></td>
                <td width="430" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Apellidos y Nombres</span></div></td>
                <td width="100" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Curso</span></div></td>
                <td width="100" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Asignatura Ins.</span></div></td>
                <td width="50" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Hora Clase</span></div></td>
                <td width="50" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Inst.</span></div></td>
                <td width="100" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Fecha Ins.</span></div></td>
              </tr>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="26" class="textoVARIOS_eloy"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['no_lista']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['cedula']; ?></span></div></td>
                <td class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="left"><span class="texto_mediano_gris">&nbsp;<?php echo $row_reporte['apellido'].", ".$row_reporte['nomalum']; ?></span></div></td>
                <td height="26" class="textoVARIOS_eloy" style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['anio']." ".$row_reporte['descripcion']; ?></span></div></td>
                <td height="26" class="textoVARIOS_eloy" style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['mate']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['inasistencia']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['inasistencia_alumno']; ?></span></div></td>
                <td height="26" class="textoVARIOS_eloy" style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['fecha_inasistencia']; ?></span></div></td>



              </tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>
            </table>
</td>
</tr>
    </table>
</body>
</center>
</html>
<?php

mysql_free_result($reporte);
?>
