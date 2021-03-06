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

// CONSULTA SQL
$colname_alumno = "-1";
if (isset($_GET['id_asignatura'])) {
  $colname_alumno = $_GET['id_asignatura'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT a.id, a.id_asignatura, a.fecha, a.contenido, a.tipo_examen, c.nombre as mate FROM jos_horario_examen a, jos_asignatura b, jos_asignatura_nombre c WHERE a.id_asignatura=b.id AND b.asignatura_nombre_id=c.id AND a.id_asignatura = %s ", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

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
<table width="650" border="0">
  <tr>
       <td class="titulo_extragrande_gris" colspan="2">MIS DE EVALUACIONES </td>
      </tr>
<tr><td>
<span class="texto_grande_gris"><b>Asignatura:</b> <?php echo $row_alumno['mate']; ?></span>
</td></tr>
<tr><td>
<a href="horario_examen.php"><span class="texto_mediano_gris"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;<b>Ver otra Asignatura </b></span></a>
</td></tr>
<tr><td>
<?php if ($totalRows_alumno > 0){ // INICIO DE LA CONSULTA ?>
<?php // INICIO DE LISTADO DE EXAMENES
?>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">
	<td width="" class="textogrande_eloy"  height="26" ><div align="center"><span class="texto_mediano_gris"><b>Fecha de la Evaluaci&oacute;n</b></span></div></td>
	<td width="" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><b>Contenido</b></span></div></td>
                <td width="" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><b>Tipo de Evaluaci&oacute;n</b></span></div></td>
		
              </tr>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="26" class="textoVARIOS_eloy"><div align="center"><span class="texto_mediano_gris"><?php echo $row_alumno['fecha']; ?></span></div></td>		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_alumno['contenido']; ?></span></div></td>
                <td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_alumno['tipo_examen']; ?></span></div></td>
	
                
              </tr>
              <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>
            </table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
<!--FIN INFO CONSULTA -->	
	

 </td></tr>
      

      <tr>
        <td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
      </tr>
    </table></td>
  </tr>
</table>

</div>

<?php } //FIN DE LA CONSULTA 
?>

<?php if ($totalRows_alumno == 0){ // ERROR NO HAY EXAMENES ?>

<div style="margin-top:20px">
<span class="texto_mediano_gris" ><img src="../../images/png/atencion.png" width="40" height="40" border="0" align="absmiddle">&nbsp;<b>No hay Evaluaciones Cargadas al Sistema...</b></span>
</div>
<?php } //FIN DE LA CONSULTA 
?>
</body>
</center>
</html>
<?php
mysql_free_result($alumno);
mysql_free_result($colegio);
?>
