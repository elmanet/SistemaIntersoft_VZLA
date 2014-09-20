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
$query_colegio = "SELECT * FROM jos_institucion";
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

$colname_alumno = "-1";
if (isset($_POST['cedula'])) {
  $colname_alumno = $_POST['cedula'];
}
$colname_lap = "-1";
if (isset($_POST['lapso'])) {
  $colname_lap = $_POST['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_pr a, jos_alumno_info b, jos_formato_evaluacion_planilla_primaria c WHERE a.alumno_id=b.alumno_id AND a.confiplanilla_id=c.id AND b.cedula = %s AND a.lapso=%s ", GetSQLValueString($colname_alumno, "biginit"),GetSQLValueString($colname_lap, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);


$colname_alumnoinfo = "-1";
if (isset($_POST['cedula'])) {
  $colname_alumnoinfo = $_POST['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_alumnoinfo = sprintf("SELECT f.descripcion as periodo, e.nombre as anio, d.descripcion as seccion FROM jos_alumno_info a, jos_alumno_curso b, jos_curso c, jos_seccion d, jos_anio_nombre e, jos_periodo f WHERE a.alumno_id=b.alumno_id AND b.curso_id=c.id AND c.periodo_id=f.id AND c.seccion_id=d.id AND c.anio_id=e.id AND a.cedula = %s", GetSQLValueString($colname_alumnoinfo, "biginit"));
$alumnoinfo = mysql_query($query_alumnoinfo, $sistemacol) or die(mysql_error());
$row_alumnoinfo = mysql_fetch_assoc($alumnoinfo);
$totalRows_alumnoinfo = mysql_num_rows($alumnoinfo);

$colname_des_especialidad = "-1";
if (isset($_POST['cedula'])) {
  $colname_des_especialidad = $_POST['cedula'];
}
$lap_des_especialidad = "-1";
if (isset($_POST['lapso'])) {
  $lap_des_especialidad = $_POST['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_des_especialidad = sprintf("SELECT d.nombre as mate, b.des_cualitativa, b.def_cualitativa FROM jos_alumno_info a, jos_formato_evaluacion_pr_especialistas b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND b.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND a.cedula = %s AND b.lapso = %s ORDER BY c.orden_asignatura", GetSQLValueString($colname_des_especialidad, "biginit"),GetSQLValueString($lap_des_especialidad, "int"));
$des_especialidad = mysql_query($query_des_especialidad, $sistemacol) or die(mysql_error());
$row_des_especialidad = mysql_fetch_assoc($des_especialidad);
$totalRows_des_especialidad = mysql_num_rows($des_especialidad);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../../css/form_impresion.css" rel="stylesheet" type="text/css">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="ancho_boletin_nor02">
	<div class="logo">
	<img src="../../images/logo_me_cer.jpg">
	<span style="font-size:6pt">Ministerio del Poder Popular
para la Educaci&oacute;n</span>
	</div>
	<div class="infologo">
		<center>
		REPUBLICA BOLIVARIANA DE VENEZUELA<br />
		MINISTERIO DEL PODER POPULAR PARA LA EDUCACION<br />
		<?php echo $row_colegio['nomcol']; ?></b><br />
		<?php echo $row_colegio['dircol']; ?><br />
		</center>
	</div>
	<div class="logo">
	<img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="79" height="79">
	</div>

	<div class="infoestudiante">
		<b>APELLIDOS Y NOMBRES:</b> <em style="text-decoration:underline"><?php echo $row_alumno['apellido']; ?> <?php echo $row_alumno['nombre']; ?></em><br />
		<b>GRADO:</b> <?php echo $row_alumnoinfo['anio']; ?> &nbsp;&nbsp;<b>SECCION:</b> <?php echo $row_alumnoinfo['seccion']; ?> &nbsp;&nbsp;<b>A&Ntilde;O ESCOLAR:</b> <?php echo $row_alumnoinfo['periodo']; ?><br />
	  	<b>NOMBRE DEL PROYECTO:</b> <?php echo $row_alumno['nombre_proyecto']; ?><br />
		<b>INICIO:</b><?php echo $row_alumno['desde']; ?> &nbsp;&nbsp;<b>CIERRE:</b> <?php echo $row_alumno['hasta']; ?> <br />
		<b>No. DE SEMANAS:</b> <?php echo $row_alumno['no_semanas']; ?> &nbsp;&nbsp;<b>DIAS LABORADOS:</b> <?php echo $row_alumno['dia_laborados']; ?> &nbsp;&nbsp;<b>INASISTENCIA:</b> <?php echo $row_alumno['inasistencia']; ?><br /><br />
		

	</div>

	<div class="titulo_boletin">
		<b>INFORME DE ESTUDIANTE</b>
	</div>

	<div class="descripcion">
		<?php echo $row_alumno['des_cualitativa']; ?>

	<table class="tabla">
	<tr>
		<td class="tabla" align="center" width="120" ><b>AREA</b></td>
		<td class="tabla" align="center" width="400" ><b>INDICADORES</b></td>
		<td class="tabla" align="center" width="100" ><b>APRECIACION</b></td>
	</tr>
	<?php do { ?>
	<tr>
		<td class="tabla"  align="center" ><?php echo $row_des_especialidad['mate']; ?></td>
		<td class="tabla" style="padding-left:5px; padding-right:5px; font-size:11px; font-family:verdana;"><?php echo $row_des_especialidad['des_cualitativa']; ?></td>
		<td class="tabla"  align="center" style="font-size:13px;" > <?php echo $row_des_especialidad['def_cualitativa']; ?></td>
	</tr>
	 <?php } while ($row_des_especialidad = mysql_fetch_assoc($des_especialidad)); ?>
	</table>
	<center><b>A</b>= Excelente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <b>B</b>= Bueno &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <b>C</b>= Regular &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<b>D</b>= Mejorable  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>E</b>= No logro las Competencias</center>
	</div>

	<div class="observaciones">

		<center>
				<table ><tr><td>
		<table border="0" align="center" class="fuente" width="600">

		      <tr>
			<td colspan="2"><strong >RECOMENDACIONES DEL DOCENTE:</strong></td>
		      </tr>
			<tr>
			<td colspan="2" >&nbsp;</td>
		      </tr>
		      <tr>
			<td colspan="2" style="border-bottom:1px solid;">&nbsp;</td>
		      </tr>
			<tr>
			<td colspan="2" >&nbsp;</td>
		      </tr>
		      <tr>
			<td colspan="2" style="border-bottom:1px solid;">&nbsp;</td>
		      </tr>
		      <tr>
			<td colspan="2">&nbsp;</td>
		      </tr>
			<tr>
			<td colspan="2" >&nbsp;</td>
		      </tr>
		      <tr>
			<td width="222" align="center"><table width="200" border="0">
			  <tr>
			    <td  style="border-bottom:1px solid;">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" >Director</td>
			  </tr>
			</table></td>
			<td width="222" align="center"><table width="200" border="0">
			  <tr>
			    <td  style="border-bottom:1px solid;">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" >Docente</td>
			  </tr>
			</table></td>
		      </tr>
		      <tr>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>

		      </tr>
		      <tr>
			<td align="center" colspan="2"><table width="200" border="0">
			  <tr>
			    <td  >&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" >Sello</td>
			  </tr>
			</table></td>
			</tr>

<tr>
			<td colspan="2"><strong >OBSERVACIONES DEL REPRESENTANTE:</strong></td>
		      </tr>
			<tr>
			<td colspan="2" >&nbsp;</td>
		      </tr>
		      <tr>
			<td colspan="2" style="border-bottom:1px solid;">&nbsp;</td>
		      </tr>
			<tr>
			<td colspan="2" >&nbsp;</td>
		      </tr>
	



		      </tr>
		    </table></td>
		      </tr>
		    </table>
		</center>

	</div>


</div>
<br />
</body>
</html>
<?php
mysql_free_result($colegio);

mysql_free_result($alumno);

mysql_free_result($alumnoinfo);
?>
