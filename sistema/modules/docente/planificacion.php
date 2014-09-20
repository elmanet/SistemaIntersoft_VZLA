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
$colname_docente = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_docente = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, h.id as id_plan, h.nombre_archivo, h.comentario, h.tipo_plan FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g, jos_docente_planificacion h WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id AND h.asignatura_id=c.id AND h.docente_id=b.id AND a.username = %s ORDER BY g.numero_anio, f.id, h.tipo_plan ASC", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

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
<table width="800" border="0">
  <tr>
       <td class="titulo_extragrande_gris" colspan="2">MI PLANIFICACION</td>
      </tr>
      <tr><td>
	<a href="publicar_horario_examen02.php"><img src="../../images/png/apply_f2.png" align="absmiddle" border="0"></a>&nbsp;<a href="cargar_planificacion1.php">Subir Planificaci&oacute;n</a>
      </td></tr>
<tr><td>
<?php if ($row_docente['gid']==19){ // INICIO DE LA CONSULTA ?>
<?php // INICIO DE LISTADO 
?>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">
		<td width="30" class="textogrande_eloy"  ><div align="center"><span class="texto_mediano_gris">ID</span></div></td>
                <td width="100" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">&nbsp;Asignatura&nbsp;</span></div></td>
		<td width="60" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">A&ntilde;o y Secci&oacute;n</span></div></td>
                <td width="80" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Tipo de <br />Planificaci&oacute;n</span></div></td>
                <td width="100" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Observaciones</span></div></td>
                <td width="100" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Descargar <br />Archivo</span></div></td>
		<td width="30" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"></span></div></td>
              </tr>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="26" class="textoVARIOS_eloy"><div align="center"><span class="texto_mediano_gris3"><?php echo $row_docente['id_plan']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3"><?php echo $row_docente['nombre']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3"><?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3"><?php if($row_docente['tipo_plan']==1){ echo "Planificaci&oacute;n <br />Anual";} if($row_docente['tipo_plan']==2){ echo "Planificaci&oacute;n <br />de Lapso";} if($row_docente['tipo_plan']==3){ echo "Plan de Evaluaci&oacute;n <br />Mensuale";} ?></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3"><?php echo $row_docente['comentario']; ?></span></div></td>
                <td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3"><a href="planificacion/data/<?php echo $row_docente['nombre_archivo']; ?>" target="_blank"><?php echo $row_docente['nombre_archivo']; ?></a></span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3"><a href="#" ><img src="../../images/png/cancel_f2.png" align="absmiddle" border="0"></a></span></div></td>

                
              </tr>
              <?php } while ($row_docente = mysql_fetch_assoc($docente)); ?>
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
</body>
</center>
</html>
<?php
mysql_free_result($docente);
mysql_free_result($colegio);
?>
