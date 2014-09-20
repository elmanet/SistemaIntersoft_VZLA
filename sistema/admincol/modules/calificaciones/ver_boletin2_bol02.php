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
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, f.id as asig_id, g.nombre_docente, g.apellido_docente, h.nombre as mate, g.nombre_docente, g.apellido_docente FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_docente g, jos_asignatura_nombre h WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND d.docente_id=g.id AND f.docente_id=g.id AND f.asignatura_nombre_id=h.id AND a.cedula= %s" , GetSQLValueString($colname_reporte, "text"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

$colname_planilla = "-1";
if (isset($_GET['cedula'])) {
  $colname_planilla = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT a.def, a.lapso, b.nombre, b.apellido, d.nombre as mate, b.nombre_representante, b.apellido_representante  FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND a.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND b.cedula = %s ORDER BY c.orden_asignatura ASC", GetSQLValueString($colname_planilla, "text"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);

//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_confiplanilla = $_GET['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "text"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table id="boletin_bol02" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
        <table border="0">
          <tr><td height="100" valign="top">

<!--INFORMACION DEL COLEGIO -->
<table width="80%"><tr><td>
<div style="font-size:15px; text-align:justify;">
<p>
<h2>REGLAMENTO   GENERAL   DE   LA   LEY ORGANICA   DE   EDUCACION: </h2>  
<p aling="justify">
<b>Articulo 109:</b>  La asistencia a clases es obligatoria. El porcentaje m&iacute;nimo de asistencia para optar a la aprobaci&oacute;n de un grado, &aacute;rea, asignatura o similar, seg&uacute;n el caso, ser&aacute; del setenta y cinco por ciento (75%)
</p>
<p>
<b>Articulo 112:</b>  Cuando el treinta por ciento (30%) o m&aacute;s de los alumnos no alcanzare la calificaci&oacute;n m&iacute;nima aprobatoria en las evaluaciones parciales, finales de lapso o revisi&oacute;n, se aplicar&aacute; a los interesados dentro de los tres (3) d&iacute;as h&aacute;biles siguientes a la publicaci&oacute;n de dicha calificaci&oacute;n, una segunda forma de evaluaci&oacute;n similar, sobre los mismos objetivos, contenidos y competencias, bajo la supervisi&oacute;n y control del Director del plantel o de cualquier otra autoridad designada por el Ministerio de Educaci&oacute;n, Cultura y Deportes, todo ello sin perjuicio de los an&aacute;lisis que resulten aconsejables y procedentes seg&uacute;n el caso. La calificaci&oacute;n obtenida en segunda oportunidad ser&aacute; la definitiva.
</p>

<h2>LA EVALUACION EN EL SISTEMA 
EDUCATIVO BOLIVARIANO.</h2>
<p>
Seg&uacute;n la Ley Org&aacute;nica de Educaci&oacute;n, gaceta oficial No. 5.929 extraordinario del 15/08/2009. Art&iacute;culo 44: La evaluaci&oacute;n como parte del proceso educativo, es democr&aacute;tica , cuali-cuantitativa, diagn&oacute;stica, flexible, formativa y acumulativa.
</p>
<p><b>La ense&ntilde;anza de las buenas costumbres o h&aacute;bitos    sociales es tan esencial como la instrucci&oacute;n.
Sim&oacute;n   Bol&iacute;var
</b>
</p>
</p>
</div>
</td></tr></table>
</td>

              
<td>

		<table width="550px"><tr><td>
    <td height="100"  width="120" align="right" valign="middle"><img src="../../images/t_guardia_nacional_211.png" width="100" height="100" align="absmiddle"></td>

            	<td valign="middle"><div align="center">
            	  <table width="100%" border="0" align="center">
                 	<tr>
                    		<td align="center" valign="bottom" style="font-size:11px">REPUBLICA BOLIVARIANA DE VENEZUELA</td>
                	</tr>
                 	<tr>
                    		<td align="center" valign="bottom" style="font-size:11px">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</td>
                	</tr>
                 	<tr>
                    		<td align="center" valign="bottom" style="font-size:11px">FUERZA ARMADA NACIONAL BOLIVARIANA</td>
                	</tr>
                 	<tr>
                    		<td align="center" valign="bottom" style="font-size:11px">GUARDIA NACIONA BOLIVARIANA</td>
                	</tr>
                 	<tr>
                    		<td align="center" valign="bottom" style="font-size:11px">DIRECCION DE EDUCACION</td>
                	</tr>
                 	<tr>
                    		<td align="center" valign="bottom" style="font-size:11px"><?php echo $row_colegio['nomcol']; ?></td>
                	</tr>

                  </table>
              	</td>
		<td valign="middle"><div align="center">
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>

              	</td>
</td></tr></table>
<table align="center">
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>

<tr><td align="center" style="font-size:40px" >INFORME ACADEMICO</td></tr>

<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>

</table>

<table width="100%" border="0" align="right" style="font-size:15px;">
                 	<tr>
                    		<td align="left"><b>ESTUDIANTE:</b> <?php echo $row_planilla['nombre']." ".$row_planilla['apellido']; ?></td>
			</tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			<tr><td><b>A&ntilde;O Y SECCION:</b> <?php echo $row_reporte['anio']." ".$row_reporte['descripcion']; ?> <b>PERIODO:</b>2010-2011</td>

                	</tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			<tr>
                    		<td align="left"><b>REPRESENTANTE:</b> <?php echo $row_planilla['nombre_representante']." ".$row_planilla['apellido_representante']; ?></td>

                	</tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			<tr>
<td align="left"><b>DOCENTE GUIA:</b> <?php echo $row_reporte['nombre_docente']." ".$row_reporte['apellido_docente']; ?></td>
                	</tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
<tr>
                    		<td align="left"><b>JEFE DEL DPTO. DE EVALUACION:</b> LCDA. YELIZA CONTRERAS</td></tr>
                  </table>
</td>
</tr> 

<table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
		<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_reporte == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen registros..</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
    
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($planilla);

mysql_free_result($confiplanilla);
?>
