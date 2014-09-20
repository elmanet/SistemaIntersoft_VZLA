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
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, c.id as anio_id, b.no_lista, b.curso_id, e.descripcion, f.id as asig_id, g.nombre_docente, g.apellido_docente, h.nombre as mate, g.nombre_docente, g.apellido_docente FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_docente g, jos_asignatura_nombre h WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND d.docente_id=g.id AND f.docente_id=g.id AND f.asignatura_nombre_id=h.id AND a.cedula= %s " , GetSQLValueString($colname_reporte, "text"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);
$anio=$row_reporte['anio_id'];
$curso=$row_reporte['curso_id'];

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
$query_planilla = sprintf("SELECT a.def, a.lapso, b.nombre, b.apellido, d.nombre as mate, b.nombre_representante, b.apellido_representante  FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND a.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND b.cedula = %s AND a.lapso=1 GROUP BY d.nombre ORDER BY c.orden_asignatura ASC", GetSQLValueString($colname_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);

$colname_planilla2 = "-1";
if (isset($_GET['cedula'])) {
  $colname_planilla2 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla2 = sprintf("SELECT a.def, a.lapso, b.nombre, b.apellido, d.nombre as mate, b.nombre_representante, b.apellido_representante  FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND a.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND b.cedula = %s AND a.lapso=2 GROUP BY d.nombre ORDER BY c.orden_asignatura ASC", GetSQLValueString($colname_planilla2, "int"));
$planilla2 = mysql_query($query_planilla2, $sistemacol) or die(mysql_error());
$row_planilla2 = mysql_fetch_assoc($planilla2);
$totalRows_planilla2 = mysql_num_rows($planilla2);


$colname_planilla3 = "-1";
if (isset($_GET['cedula'])) {
  $colname_planilla3 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla3 = sprintf("SELECT a.def, a.lapso, b.nombre, b.apellido, d.nombre as mate, b.nombre_representante, b.apellido_representante  FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND a.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND b.cedula = %s AND a.lapso=3 GROUP BY d.nombre ORDER BY c.orden_asignatura ASC", GetSQLValueString($colname_planilla3, "int"));
$planilla3 = mysql_query($query_planilla3, $sistemacol) or die(mysql_error());
$row_planilla3 = mysql_fetch_assoc($planilla3);
$totalRows_planilla3 = mysql_num_rows($planilla3);

//DEF
$colname_planilladef = "-1";
if (isset($_GET['cedula'])) {
  $colname_planilladef = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilladef = sprintf("SELECT a.lapso, b.nombre, b.apellido, d.nombre as mate, b.nombre_representante, b.apellido_representante , ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND a.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND b.cedula = %s GROUP BY d.nombre ORDER BY c.orden_asignatura ASC", GetSQLValueString($colname_planilladef, "int"));
$planilladef = mysql_query($query_planilladef, $sistemacol) or die(mysql_error());
$row_planilladef = mysql_fetch_assoc($planilladef);
$totalRows_planilladef = mysql_num_rows($planilladef);

//DEF_SECCION

mysql_select_db($database_sistemacol, $sistemacol);
$query_pro_seccion = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND b.curso_id =$curso AND c.lapso=3 GROUP BY a.alumno_id ORDER BY def DESC");
$pro_seccion = mysql_query($query_pro_seccion, $sistemacol) or die(mysql_error());
$row_pro_seccion = mysql_fetch_assoc($pro_seccion);
$totalRows_pro_seccion = mysql_num_rows($pro_seccion);


//DEF_ANIO

mysql_select_db($database_sistemacol, $sistemacol);
$query_pro_anio = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_anio_nombre d, jos_curso e WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND b.curso_id=e.id AND e.anio_id = d.id AND d.id =$anio AND c.lapso=3 GROUP BY a.alumno_id ORDER BY def DESC");
$pro_anio = mysql_query($query_pro_anio, $sistemacol) or die(mysql_error());
$row_pro_anio = mysql_fetch_assoc($pro_anio);
$totalRows_pro_anio = mysql_num_rows($pro_anio);

//DEF_GENERAL

mysql_select_db($database_sistemacol, $sistemacol);
$query_general = sprintf("SELECT a.cedula, a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, ROUND(AVG(c.def),2) as def, g.nombre as anio, h.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e, jos_curso f, jos_anio_nombre g, jos_seccion h WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND b.curso_id=f.id AND f.anio_id=g.id AND f.seccion_id=h.id AND c.lapso=3 GROUP BY a.alumno_id ORDER BY def DESC");
$general = mysql_query($query_general, $sistemacol) or die(mysql_error());
$row_general = mysql_fetch_assoc($general);
$totalRows_general = mysql_num_rows($general);


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

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confi = mysql_query($query_confi, $sistemacol) or die(mysql_error());
$row_confi = mysql_fetch_assoc($confi);
$totalRows_confi = mysql_num_rows($confi);

//INASISTENCIAS
$colname_inasistencia = "-1";
if (isset($_GET['cedula'])) {
  $colname_inasistencia = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inasistencia = sprintf("SELECT sum(inasistencia_alumno) as inasistencia_alumno, sum(inasistencia) as hora_clase FROM jos_alumno_asistencia a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cedula = %s", GetSQLValueString($colname_inasistencia, "int"));
$inasistencia = mysql_query($query_inasistencia, $sistemacol) or die(mysql_error());
$row_inasistencia = mysql_fetch_assoc($inasistencia);
$totalRows_inasistencia = mysql_num_rows($inasistencia);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/form_impresion.css" rel="stylesheet" type="text/css" media="print">
</head>
<center>
<body>
<table id="boletin_bol02" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
        <table border="0">
<!--INFORMACION DE IMPRESION  -->

<tr><td><div class="ocultar">
<table><tr><td><h1>Ver la siguiente hoja >>></h1></td>
<td>
	<form action="ver_boletin2_<?php echo $row_confi['codfor']; ?>.php" method="GET" name="f1">
	<input type="hidden" name="cedula" id="cedula" value=" <?php echo $_GET['cedula']; ?>" />

	<input type="hidden" name="lapso" id="lapso" value="<?php echo $_GET['codfor']; ?>" />
	<input type="submit" name="buttom" value="Aceptar >>" />
	</form>
</td></tr></table>
</div></td></tr>

<!--FIN DE IMPRESION   -->


<!--INFORMACION DE LA CONSULTA  -->
 <tr><td valign="top" align="center" class="texto_mediano_gris" >

<table width="100%"><tr>
<td width="50%" align="left">
<table width="95%" style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde" >

 <tr bgcolor="#00FF99" class="texto_mediano_eloy">
		
		<tr>
                    <td width="30" rowspan="2" ><div align="center"><span><b>&nbsp;No.&nbsp;</b></span></div></td>
                <td width="400" rowspan="2"><div align="center"><span><b><h1>Asignaturas</h1></b></span></div></td>
                <td colspan="3"><div align="center"><span><b>1ER LAPSO</b></span></div></td>
                <td colspan="3"><div align="center"><span><b>2DO LAPSO</b></span></div></td>
                <td colspan="3"><div align="center"><span><b>3ER LAPSO</b></span></div></td>
                <td rowspan="2" ><div align="center"><span><b>DEF</b></span></div></td>


		</tr>

		<tr>		
		<td width="30"><div align="center"><span>CT</span></div></td>
                <td width="30"><div align="center"><span>CL</span></div></td>
                <td width="30"><div align="center"><span>I</span></div></td>

                <td width="30"><div align="center"><span>CT</span></div></td>
                <td width="30"><div align="center"><span>CL</span></div></td>
                <td width="30"><div align="center"><span>I</span></div></td>

		<td width="30"><div align="center"><span>CT</span></div></td>
                <td width="30"><div align="center"><span>CL</span></div></td>
                <td width="30"><div align="center"><span>I</span></div></td>





		

 
		</tr>
		
                
	
         
	
	</tr>
         <tr><td colspan="5">
                 <table width="100%" height="100%"  style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">

              <?php 
 		 $lista = 1;	
		do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

                  <td style="border-left:1px solid"  width="30" ><div align="center"><span>&nbsp;<?php echo $lista; $lista ++; ?>&nbsp;</span></div></td>
                <td style="border-left:1px solid"  width="400" ><div align="left"><span>&nbsp;<?php echo $row_planilla['mate']; ?></span></div></td>

<?php // PRIMER LAPSO 
?>
 <td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span><b><?php if($row_planilla['lapso']==1){ if ($row_planilla['def']<10 and $row_planilla['def']>0){ echo "0".$row_planilla['def'];} if ($row_planilla['def']>=10){ echo $row_planilla['def'];} if ($row_planilla['def']==0){ echo "";} }?></b></span></div></td>
<td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span><b><?php if($row_planilla['lapso']==1){ if(($row_planilla['def']>0) and ($row_planilla['def']<10)) { echo "I";} if (($row_planilla['def']>9) and ($row_planilla['def']<15)) { echo "P";} if(($row_planilla['def']>14) and ($row_planilla['def']<19)) { echo "A";} if(($row_planilla['def']>18) and ($row_planilla['def']<=20)) { echo "C";} if ($row_planilla['def']==0){ echo "";} } ?></b></span></div></td>
 <td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span></span></div></td>
                
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)); ?>

                 </table>
             </td>
             <td colspan="3">
                 <table width="100%" height="100%" style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
  
         <?php
 	
		do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy" >

<?php  // SEGUNDO LAPSO
?>
 <td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span><b><?php if($row_planilla2['lapso']==2){ if ($row_planilla2['def']<10 and $row_planilla2['def']>0){ echo "0".$row_planilla2['def'];} if ($row_planilla2['def']>=10){ echo $row_planilla2['def'];} if ($row_planilla2['def']==0){ echo "";} }?></b></span></div></td>
<td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span><b><?php if($row_planilla2['lapso']==2){ if(($row_planilla2['def']>0) and ($row_planilla2['def']<10)) { echo "I";} if (($row_planilla2['def']>9) and ($row_planilla2['def']<15)) { echo "P";} if(($row_planilla2['def']>14) and ($row_planilla2['def']<19)) { echo "A";} if(($row_planilla2['def']>18) and ($row_planilla2['def']<=20)) { echo "C";} if ($row_planilla2['def']==0){ echo "";} } ?></b></span></div></td>
 <td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span></span></div></td>


              </tr>
              <?php } while ($row_planilla2 = mysql_fetch_assoc($planilla2)); ?>
                 </table>

		</td>
	<td colspan="3">
                 <table width="100%" height="100%" style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
  
         <?php
 	
		do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy" >

<?php  // TERCER LAPSO
?>
 <td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span><b><?php if($row_planilla3['lapso']==3){ if ($row_planilla3['def']<10 and $row_planilla3['def']>0){ echo "0".$row_planilla3['def'];} if ($row_planilla3['def']>=10){ echo $row_planilla3['def'];} if ($row_planilla3['def']==0){ echo "";} }?></b></span></div></td>
<td style="border-left:1px solid; background-color:#FFFCCC;" width="30"><div align="center"><span><b><?php if($row_planilla3['lapso']==3){ if(($row_planilla3['def']>0) and ($row_planilla3['def']<10)) { echo "I";} if (($row_planilla3['def']>9) and ($row_planilla3['def']<15)) { echo "P";} if(($row_planilla3['def']>14) and ($row_planilla3['def']<19)) { echo "A";} if(($row_planilla3['def']>18) and ($row_planilla3['def']<=20)) { echo "C";} if ($row_planilla3['def']==0){ echo "";} } ?></b></span></div></td>
 <td style="border-left:1px solid; background-color:#FFFCCC;" width="30"><div align="center"><span></span></div></td>

              </tr>
              <?php } while ($row_planilla3 = mysql_fetch_assoc($planilla3)); ?>
                 </table>

<td>
                 <table width="100%" height="100%" style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
  
         <?php
 	
		do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy" >

<?php  // DEF
?>
 <td style="border-left:1px solid; background-color:#FFFCCC;"  width="30"><div align="center"><span><b><?php if ($row_planilladef['def']<10 and $row_planilladef['def']>0){ echo "0".$row_planilladef['def'];} if ($row_planilladef['def']>=10){ echo $row_planilladef['def'];} if ($row_planilladef['def']==0){ echo "";} ?></b></span></div></td>



              </tr>
              <?php } while ($row_planilladef = mysql_fetch_assoc($planilladef)); ?>
                 </table>

</td></tr>

    </table>


<tr>
<td width="50%" align="left">

<span class="texto_pequeno_gris"><b>CL</b>= Calificacion Cualitativa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>CT</b>=  Calificacion Cuantitativa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>I</b>= Inasistencias</b></span>
<br>
<h2>EXPRESION EVALUATIVA</h2>
<div style="margin-left:0px; width:85%" align="left">
<span class="texto_pequeno_gris"><b>C: CONSOLIDADO (19-20 ptos)</b>&nbsp;&nbsp;El estudiante alcanzo todas las competencias.</span>
<br>
<span class="texto_pequeno_gris"><b>A: AVANZADO (15-18 ptos)</b>&nbsp;&nbsp;El estudiante alcanzo la mayoria de las competencias.</span>
<br>
<span class="texto_pequeno_gris"><b>P: EN PROCESO (10-14 ptos)</b>&nbsp;&nbsp;El estudiante promueve, sin embargo requiere atencion individualizada con enfasis en las deficiencias detectadas en el proceso.</span>
<br>
<span class="texto_pequeno_gris"><b>I: INICIADO (01-09 ptos)</b>&nbsp;&nbsp;El estudiante no promueve,requiere reiniciar el proceso para asi desarrollar las competencias.</span>
</div>

<br>
<table style="border:1px solid;" width="95%">
<tr style="border:1px solid;"><td colspan="8" align="center" style="font-size:15px;"><b>CONTROL DE INANSISTENCIAS</b></td></tr>
<tr style="border:1px solid;">
<td style="border:1px solid;" align="center" width="80">1ER LAPSO</td>
<td style="border:1px solid;" align="center" width="40">%</td>
<td style="border:1px solid;" align="center" width="80">2DO LAPSO</td>
<td style="border:1px solid;" align="center" width="40">%</td>
<td style="border:1px solid;" align="center" width="80">3ER LAPSO</td>
<td style="border:1px solid;" align="center" width="40">%</td>
<td style="border:1px solid;" align="center" width="80">TOTAL</td>
<td style="border:1px solid;" align="center" width="40">%</td>
</tr>
<tr style="border:1px solid;">
<td style="border:1px solid;">&nbsp;</td>
<td style="border:1px solid;">&nbsp;</td>
<td style="border:1px solid;">&nbsp;</td>
<td style="border:1px solid;">&nbsp;</td>
<td style="border:1px solid;" align="center"><?php echo $row_inasistencia['inasistencia_alumno'];?></td>
<td style="border:1px solid;" align="center">
<?php /*
$porcentaje=($row_inasistencia['inasistencia_alumno']*100)/$row_inasistencia['hora_clase'];
echo $porcentaje;
*/
?>
</td>
<td style="border:1px solid;">&nbsp;</td>
<td style="border:1px solid;">&nbsp;</td>
</tr>
</table>
<!--FIN INFO CONSULTA -->
</td>

          </tr>
<tr>
<td>
<table style="border:1px solid;" width="95%">
<tr style="border:1px solid;">
<td style="border:1px solid;" align="center" class="texto_mediano_gris"><b>Orden M&eacute;rito/Secci&oacute;n</b></td>
<td style="border:1px solid;" align="center" class="texto_mediano_gris"><b>Orden M&eacute;rito/A&ntilde;o</b></td>
<td style="border:1px solid;" align="center" class="texto_mediano_gris"><b>Orden M&eacute;rito/General</b></td>
</tr>
<tr style="border:1px solid;">
<td style="border:1px solid;" align="center">
			<?php
			$i=1; 
			do {  

			if($row_pro_seccion['cedula']==$_GET['cedula']){

			echo $i;

			} ?>

			<?php $i++; } while ($row_pro_seccion = mysql_fetch_assoc($pro_seccion)); ?>

</td>
<td style="border:1px solid;" align="center">
			<?php
			$i=1; 
			do {  

			if($row_pro_anio['cedula']==$_GET['cedula']){

			echo $i;

			} ?>

			<?php $i++; } while ($row_pro_anio = mysql_fetch_assoc($pro_anio)); ?>

</td>
<td style="border:1px solid;" align="center">
			<?php
			$i=1; 
			do {  
			if($row_general['cedula']==$_GET['cedula']){

			echo $i;

			} ?>
			<?php $i++; } while ($row_general = mysql_fetch_assoc($general)); ?>
</td>
</tr>
</table>
</td></tr>
	</table>
</td>
<td width="50%">

<table width="100%">
<tr>
<td  style="border:1px solid;" align="center"><h2>RESUMEN DESCRIPTIVO</h2></td>
</tr>
<tr>
<td>
<br>
1ER LAPSO:_____________________________________________________________________________________________________
<br /><br>_____________________________________________________________________________________________________________
<br /><br>_______________________________________________________________________________________________________________
<br>
<br>
Fecha:______________________________________________ Firma Docente Guia:______________________________________
<br>
<br>

</td>
</tr>
<tr>
<td>
<br />
2DO LAPSO:____________________________________________________________________________________________________
<br /><br>_____________________________________________________________________________________________________________
<br /><br>_______________________________________________________________________________________________________________
<br>
<br>
Fecha:______________________________________________ Firma Docente Guia:____________________________________
<br>
<br>

</td>
</tr>
<tr>
<td>
<br />
3ER LAPSO:____________________________________________________________________________________________________
<br /><br>_______________________________________________________________________________________________________________
<br /><br>_______________________________________________________________________________________________________________
<br>
<br>
<br>
<br>

Observaciones del Director:___________________________________________________________________________________
<br />
<br>________________________________________________________________________________________________________________
<br />
<br>________________________________________________________________________________________________________________
<br />
<br>________________________________________________________________________________________________________________
<br>
<br>
<br />
<br />
<br />
<div align="center"><span><b>SELLO DEL PLANTEL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRMA DEL DIRECTOR</b></span></div>
</td>
</tr>
</tr>
</table>


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
mysql_free_result($planilla2);
mysql_free_result($planilla3);
mysql_free_result($planilladef);

mysql_free_result($confiplanilla);

mysql_free_result($confi);
?>
