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
if (isset($_GET['cedula'])) {
  $colname_reporte = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.cedula_docente, a.nombre_docente, a.apellido_docente, a.direccion_docente, a.telefono_docente, a.email_docente, c.nombre as nombremate, b.id as id_mate, e.nombre as anio, f.descripcion FROM jos_docente a, jos_asignatura b, jos_asignatura_nombre c, jos_curso d, jos_anio_nombre e, jos_seccion f WHERE a.id=b.docente_id AND b.asignatura_nombre_id=c.id AND b.curso_id=d.id AND d.anio_id=e.id AND d.seccion_id=f.id AND a.cedula_docente= %s  ORDER BY apellido_docente ASC" , GetSQLValueString($colname_reporte, "text"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >
<head>
<title>:: REPORTE IMPRESO ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr>

<!--INFORMACION DEL COLEGIO -->
   

<!--INFORMACION DE LA CONSULTA -->
<td valign="top" align="center" class="texto_mediano_gris" ><h1>REPORTE DETALLADO DE DOCENTE</h1></td></tr>
<td>

<h3> Informacion General del Docente  </h3>
	<table>
	<tr class="textogrande_eloy" >
	<td bgcolor="#00FF99" style="border:1px solid;" class="textogrande_eloy" ><div align="right"><span class="texto_mediano_gris">Cedula:</span></div></td>
	<td bgcolor="#fff" ><span class="texto_mediano_gris"><?php echo $row_reporte['cedula_docente']; ?></span></td></tr>

	<tr class="textogrande_eloy" >
	<td bgcolor="#00FF99" style="border:1px solid;" class="textogrande_eloy" ><div align="right"><span class="texto_mediano_gris">Apellido y Nombre:</span></div></td>
	<td bgcolor="#fff" ><span class="texto_mediano_gris"><?php echo $row_reporte['apellido_docente'].", ".$row_reporte['nombre_docente']; ?></span></td></tr>

	<tr class="textogrande_eloy" >
	<td bgcolor="#00FF99" style="border:1px solid;"  class="textogrande_eloy" ><div align="right"><span class="texto_mediano_gris">Telefono:</span></div></td>
	<td bgcolor="#fff" ><span class="texto_mediano_gris"><?php echo $row_reporte['telefono_docente']; ?></span></td></tr>

	<tr class="textogrande_eloy" >
	<td bgcolor="#00FF99" style="border:1px solid;" class="textogrande_eloy" ><div align="right"><span class="texto_mediano_gris">Direccion:</span></div></td>
	<td bgcolor="#fff" ><span class="texto_mediano_gris"><?php echo $row_reporte['direccion_docente']; ?></span></td></tr>

	<tr class="textogrande_eloy" >
	<td bgcolor="#00FF99"  style="border:1px solid;" class="textogrande_eloy" ><div align="right"><span class="texto_mediano_gris">E-mail:</span></div></td>
	<td bgcolor="#fff" ><span class="texto_mediano_gris"><?php echo $row_reporte['email_docente']; ?></span></td></tr>

	</table>
<h3> Asignaturas Asociadas al Docente </h3>

<tr><td align="right"><span class="texto_mediano_gris" > Total de Asignaturas Asociadas:<b> <?php echo $totalRows_reporte;?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></td></tr>

<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">

<tr bgcolor="#00FF99" class="textogrande_eloy" >

		<td width="100" class="textogrande_eloy" style="border-top:1px solid; font-weight:bold;"><div align="center"><span class="texto_mediano_gris">Id</span></div></td>
                <td width="500" class="textogrande_eloy" style="border-top:1px solid; font-weight:bold;" ><div align="center"><span class="texto_mediano_gris">Nombre de la Asignatura</span></div></td>
                <td width="100" class="textogrande_eloy" style="border-top:1px solid; font-weight:bold;"><div align="center"><span class="texto_mediano_gris">Curso</span></div></td>


              </tr>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
		<td height="26" class="textoVARIOS_eloy" ><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['id_mate']; ?></span></div></td>
                <td class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="left"><span class="texto_mediano_gris">&nbsp;<?php echo $row_reporte['nombremate']; ?></span></div></td>
                <td class="textoVARIOS_eloy" style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><?php echo $row_reporte['anio']." ".$row_reporte['descripcion']; ?></span></div></td>


              </tr>

              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>
            </table>

<!--FIN INFO CONSULTA -->

</td>
          </tr>
	</table>
		<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_reporte == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen ningun registro</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
<tr><td>

<h2>Vuelve a introducir la Cedula</h2>
<form action="re_docente_detalle.php" method="GET">
	<input type="text" name="cedula" value="" />
	<input type="submit" name="buttom" value="Buscar >" />
	</form>

</td></tr>
        </table>
        <?php } // Show if recordset empty ?>
    <tr><td>    </td>
</tr>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);

mysql_free_result($colegio);
?>
