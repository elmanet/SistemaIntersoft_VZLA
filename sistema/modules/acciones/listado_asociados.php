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

mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT b.id, a.name, d.nombre, e.descripcion  FROM jos_users a, jos_alumno_asistencia_coordinacion b, jos_curso c, jos_anio_nombre d, jos_seccion e WHERE b.user_id=a.id AND b.curso_id=c.id AND c.seccion_id=e.id AND c.anio_id=d.id ORDER BY a.name, d.numero_anio, e.descripcion ASC");
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: COLEGIONLINE ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>

<?php if($totalRows_reporte>0){ ?>

<table width="760" border="0" cellspacing="0" cellpadding="0"  >
  <!--DWLayoutTable-->
  <tr>
    <td valign="top" align="center">
        <h1><img src="../../images/pngnew/busqueda-de-los-usuarios-del-hombre-icono-6234-48.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de usuarios Asociados!</h1>
       
        <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">
                <td width="430" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Apellidos y Nombres</span></div></td>
                <td width="100" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">Curso Asociado</span></div></td>
                <td width="25" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris">&nbsp;</span></div></td>
              </tr>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="26" class="textoVARIOS_eloy"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['name']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy" style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['nombre']." ".$row_reporte['descripcion']; ?></span></div></td>
 <td width="25" class="textogrande_eloy"><div align="center"><span class="texto_mediano_gris"><a href="eliminar_asociado.php?id=<?php echo $row_reporte['id']; ?>"><img src="../../images/png/eliminar.PNG" border="0" align="absmiddle"></span></div></td>



              </tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>
            </table>
</td>
</tr>
    </table>
<?php }else { ?>
<table>
<tr><td align="center">
<div style="margin-top:20px;">
<img src="../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="60">	
<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">

<p align="center">"No exiten Datos para Mostrar!"</p><br />
</div>
</div>
	</td></tr>


    </table>
<?php } ?>
</body>
</center>
</html>
<?php

mysql_free_result($reporte);
?>
