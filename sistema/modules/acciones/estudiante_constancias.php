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
$query_alumno = "SELECT * FROM jos_alumno_info  WHERE cursando=1 AND apellido like '%$apellido_alumno%' or nombre like '%$apellido_alumno%' or cedula like '%$apellido_alumno%' ORDER BY apellido ASC LIMIT 20";
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>INTERSOFT | Software Educativo</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css">
<link href="../../css/input.css" rel="stylesheet" type="text/css">
<link href="../../css/marca.css" rel="stylesheet" type="text/css" />
<?php require_once('../inc/validate.inc.php'); ?>

</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;M&oacute;dulo de Constancias</h2>
	
	</td></tr>
<tr><td>

<form action="estudiante_constancias.php" name="signupForm" id="signupForm" method="GET" enctype="multipart/form-data" >

<span class="texto_mediano_gris">Buscar Estudiante: </span> 

<input type="text" class="text_input" id="apellido_alumno" name="apellido_alumno" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar > " class="texto_grande_gris"/>

</form> 

<!-- <br />
<a href="estudiante_constancias.php" > | Todos los Estudiantes |</a>
<br />-->
<br />
<?php if($totalRows_alumno>0) {	?>
	
	
<br />
</tr><td>
<tr><td>

<table style="font-size:10px; font-family:verdana;" width="100%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">No.</td>
		<td align="center">Estudiante</td>


		<td align="center">Acciones</td>
	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center" class="texto_pequeno_gris"><?php echo $lista; $lista ++; ?>&nbsp;</td>
		
		<td align="center" class="texto_pequeno_gris"><?php echo $row_alumno['apellido'].", ".$row_alumno['nombre']; ?><br />
		<?php echo $row_alumno['indicador_nacionalidad']."-".$row_alumno['cedula']; ?></td>

		<td bgcolor="#fff">

		
		<form name="input_<?php echo $lista;?>" action="../reportes/constancia.php" target="_blank" method="get">
<fieldset style="background-color:#fffccc; width:400px;">
<legend><span class="texto_pequeno_gris" ><b>Tipo de Constancia</b></span></legend>
<span class="texto_pequeno_gris" style="text-align:left">
<input type="radio" name="constancia" value="1" /> Constancia de Estudio <br />
<input type="radio" name="constancia" value="2" /> Constancia de Conducta - <input name="c" class="texto_pequeno_gris" type="text" value="BUENA CONDUCTA" size="20"/> <br />
<input type="radio" name="constancia" value="3" /> Constancia de Estudio (Retiro) - <input name="cr" class="texto_pequeno_gris" type="text" value="BUENA CONDUCTA" size="20"/><br />
<input type="radio" name="constancia" value="4" /> Constancia de Inscripci&oacute;n <br />
<input type="radio" name="constancia" value="5" /> Constancia de Retiro - Fecha <input name="fecha_retiro" class="texto_pequeno_gris" type="text" value="" size="20"/><br />
<input type="radio" name="constancia" value="6" /> Constancia de Notas / <input type="radio" name="lapsoc" value="1" /> L1 <input type="radio" name="lapsoc" value="2" />L2<input type="radio" name="lapsoc" value="3" />L3<br />
</span>
<center>
<input type="submit" class="texto_pequeno_gris" value="VER" />
</center>
</fieldset>


			
		
		<input name="cedula" type="hidden" value="<?php echo $row_alumno['cedula']; ?>"/>
		<!--<a href="../reportes/constancia.php?cedula=<?php echo $row_alumno['cedula'];?>&constancia=1" target="_blank"><img src="../../images/png/actualizar.PNG" width="25"  alt="" border="0" align="absmiddle"></a>-->
		</form>
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
