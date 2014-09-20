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

mysql_select_db($database_sistemacol, $sistemacol);
$query_institucion = "SELECT * FROM jos_cdc_institucion";
$institucion = mysql_query($query_institucion, $sistemacol) or die(mysql_error());
$row_institucion = mysql_fetch_assoc($institucion);
$totalRows_institucion = mysql_num_rows($institucion);

$colname_alumno = "-1";
if (isset($_POST['cedula'])) {
  $colname_alumno = $_POST['cedula'];
}
$colname_lap = "-1";
if (isset($_POST['periodo'])) {
  $colname_lap = $_POST['periodo'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_pr_certificado a, jos_alumno_info b, jos_asignatura c, jos_docente d WHERE a.alumno_id=b.alumno_id AND a.asignatura_id=c.id AND c.docente_id=d.id AND b.cedula = %s AND a.periodo_id=%s ", GetSQLValueString($colname_alumno, "biginit"),GetSQLValueString($colname_lap, "int"));
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


$fecha_nac =$row_alumno['fecha_nacimiento'];
function edad($fecha_nac){
$dia=date("j");
$mes=date("n");
$anno=date("Y");
$dia_nac=substr($fecha_nac, 8, 2);
$mes_nac=substr($fecha_nac, 5, 2);
$anno_nac=substr($fecha_nac, 0, 4);
if($mes_nac>$mes){
$calc_edad= $anno-$anno_nac-1;
}else{
if($mes==$mes_nac AND $dia_nac>$dia){
$calc_edad= $anno-$anno_nac-1;
}else{
$calc_edad= $anno-$anno_nac;
}
}
return $calc_edad;
}
//echo $calc_edad;


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
<?php if($totalRows_alumno>0){?>
<div id="ancho_boletin_nor02">
	<div class="logo">
	<img src="../../images/logo_me_cer.jpg">
	<span style="font-size:6pt">Ministerio del Poder Popular
para la Educaci&oacute;n</span>
	</div>
	<div class="infologo" style="font-size:12px;">
		<center>
		REPUBLICA BOLIVARIANA DE VENEZUELA<br />
		MINISTERIO DEL PODER POPULAR PARA LA EDUCACION<br />
		ZONA EDUCATIVA TACHIRA<br />
		<?php echo $row_colegio['nomcol']; ?></b><br />
		CODIGO PLANTEL <?php echo $row_institucion['cod_plantel']; ?><br />
		SAN CRISTOBAL - EDO. TACHIRA<br />
		</center>
<hr />
	</div>
	<div class="logo">
	<img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="79" height="79">
	</div>

	<div class="titulo_boletin" style="height:1.5cm;">
		<br />
		<b>CERTIFICACION DEL DESEMPE&Ntilde;O DEL ESTUDIANTE</b>
	</div>

	<div class="infoestudiante" style="height:3.5cm; border:0px; text-align: justify; padding-left:8px; padding-right:8px; font-size:10pt;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El Suscrito, Director de la <b><?php echo $row_colegio['nomcol']; ?></b>. Quien funciona en la localidad de <b>SAN CRISTOBAL</b> del Municipio: <b>SAN CRISTOBAL</b> Parroquia <b>SAN SEBASTIAN</b> del Estado T&aacute;chira.  Hace constar en el presente informe, el desempe&ntilde;o de: <b><?php echo $row_alumno['apellido']; ?> <?php echo $row_alumno['nombre']; ?></b> C.I. No. <b><?php echo $row_alumno['cedula']; ?></b> Natural de <b><?php echo $row_alumno['lugar_nacimiento']; ?> </b> y de <b><?php echo edad($fecha_nac); ?></b> a&ntilde;os de edad, quien curs&oacute;: <b><?php echo $row_alumnoinfo['anio']; ?></b> de Educaci&oacute;n Primaria durante el A&ntilde;o Escolar  <b><?php echo $row_alumnoinfo['periodo']; ?></b>, seg&uacute;n lo establecido en los Art&iacute;culos 7, 8, 14, 15 y 16 de la Resoluci&oacute;n 266, del 20 de Diciembre de 1999, observ&oacute; las siguientes competencias: 
		

	</div>

		<div class="titulo_boletin" style="height:1.5cm;">
		<br />
		<b>INFORME DESCRIPTIVO</b>
	</div>

	<div class="descripcion">
		<?php echo $row_alumno['des_cualitativa']; ?>
	<br />
	<br />
<center>
<span style="font-size:12pt;">
Condici&oacute;n: <b><?php echo $row_alumno['condicion']; ?></b>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Apreciaci&oacute;n Literal: <b><?php echo $row_alumno['def_cualitativa']; ?></b>
</span>
</center>
<br />
<br />
<br />
<span>
<b>A</b>.- EL ESTUDIANTE ALCANZO TODAS LAS COMPETENCIAS Y EN ALGUNOS CASOS SUPER&Oacute; LAS EXPECTATIVAS PARA EL GRADO.
<br />
<b>B</b>.- EL ESTUDIANTE ALCANZO TODAS LAS COMPETENCIAS PREVISTAS PARA EL GRADO.
<br />
<b>C</b>.- EL ESTUDIANTE ALCANZO LA MAYORIA DE LAS COMPETENCIAS PREVISTAS PARA EL GRADO.
<br />
<b>D</b>.- EL ESTUDIANTE ALCANZO ALGUNAS DE LAS COMPETENCIAS DEL GRADO PERO REQUIERE DE UN PROCESO DE NIVELACI&Oacute;N AL INICIO DEL NUEVO A&Ntilde;O ESCOLAR PARA ALCANZAR LAS RESTANTES.
<br />
<b>E</b>.- EL ESTUDIANTE NO LOGRO ADQUIRIR LAS COMPETENCIAS M&Iacute;NIMAS REQUERIDAS PARA SER PROMOVIDO AL GRADO INMEDIATAMENTE SUPERIOR.
</span>

	
	</div>
	<div class="observaciones">
		<center>
				<table ><tr><td>

		<table border="0" align="center" class="fuente" width="600">

		      <tr>
			<td width="222" align="center"><table width="200" border="0">
			  <tr>
			    <td  style="border-bottom:1px solid;">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" >Lcda. <?php echo $row_institucion['nombre_director']." ".$row_institucion['apellido_director'];?></td>
			  </tr>
			  <tr>
			    <td align="center" >Director(a)</td>
			  </tr>
			</table></td>
			<td width="222" align="center"><table width="200" border="0">
			  <tr>
			    <td  style="border-bottom:1px solid;">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" >Lcda. <?php echo $row_alumno['nombre_docente']." ".$row_alumno['apellido_docente']; ?></td>
			  </tr>
			  <tr>
			    <td align="center" >Docente</td>
			  </tr>
			</table></td>
		      </tr>
		      
		    </table>
		</center>
	</div>

</div>
<br />
<?php } else { ?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png"/><br /><br />
<span style="font-size:12pt;" class="texto_grande_gris">NO EXISTE NINGUN ESTUDIANTE REGISTRAD CON ESE No. DE CEDULA <br />O AUN NO HAN SE HA CARGADO LA CERTIFICACION PARA ESTE ESTUDIANTE </span><br /><br />
<span class="texto_mediano_gris">Para continuar cierra esta Ventana!</span>
</center>
<?php } ?>
</body>
</html>
<?php
mysql_free_result($colegio);

mysql_free_result($institucion);

mysql_free_result($alumno);

mysql_free_result($alumnoinfo);
?>
