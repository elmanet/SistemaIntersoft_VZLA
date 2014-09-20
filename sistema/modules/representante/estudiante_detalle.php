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
$apellido_alumno=$_GET['apellido_alumno'];

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

// listado de estudiantes


mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = "SELECT * FROM jos_alumno_info  WHERE cursando=1 AND apellido like '%$apellido_alumno%' or nombre like '%$apellido_alumno%' or cedula like '%$apellido_alumno%' ORDER BY apellido ASC";
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

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
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Listado de Estudiantes</h2>
	
	</td></tr>
<tr><td>

<form action="estudiante_detalle.php" name="form" id="form" method="GET" enctype="multipart/form-data" >
<span style="font-size:12px;"><b>Buscar Estudiante:</b> </span> 

<input type="text" name="apellido_alumno" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar >" />

</form> 

<br />
<a href="estudiante_detalle.php" > | Ver Todos los Estudiantes |</a>
<br />
<br />
<?php if($totalRows_alumno>0) {	?>

<br />
</tr><td>
<tr><td>

<table style="font-size:10px; font-family:verdana;" width="100%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Apellido y Nombre <br />del Estudiante</td>
		<td align="center">C&eacute;dula del<br />Estudiante</td>
		<td align="center">Tel&eacute;fono del<br />Estudiante</td>
		<td align="center">Apellido y Nombre<br />del Representante</td>
		<td align="center">Tel&eacute;fono del<br />Representante</td>

		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center" width="10"><?php if($pageNum_alumno==1){ $newlista=$maxRows_alumno+$lista; echo $newlista; $lista ++;   } if ($pageNum_alumno==0){ echo $lista; $lista ++;} ?>&nbsp;</td>
		<td align="center" width="200"><?php echo $row_alumno['apellido']."<br /> ".$row_alumno['nombre']; ?></td>
		<td align="center" width="50">&nbsp;<?php echo $row_alumno['indicador_nacionalidad']."-".$row_alumno['cedula']; ?>&nbsp;</td>
		<td align="center" width="60">&nbsp;<?php echo $row_alumno['telefono_alumno']; ?>&nbsp;</td>
		<td align="center" width="200"><?php echo $row_alumno['apellido_representante']."<br /> ".$row_alumno['nombre_representante']; ?></td>
		<td align="center" width="60">&nbsp;<?php echo $row_alumno['telefono_representante']; ?>&nbsp;</td>
		
		<td align="center" width="10">
		
		<a href="estudiante_detalle2.php?cedula=<?php echo $row_alumno['cedula'];?>"><img src="../../images/png/32px-Crystal_Clear_action_reload.png" width="25"  alt="" border="0" align="absmiddle"></a>
		
		</td>
	</tr>
        <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>	

</table>
<?php } else { ?>
<center>
<img src="../../images/png/atencion.png" width="15%" alt="" /><br /><br />
<span class="texto_mediano_gris">No Existen Estudiantes con estas especificaciones!</span>
</center>
<?php } ?>
<tr><td>
&nbsp;&nbsp;
</td></tr>





    </table>
<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>
<?php

mysql_free_result($usuario);
mysql_free_result($alumno);

?>
