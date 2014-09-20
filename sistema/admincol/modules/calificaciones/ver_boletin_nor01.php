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

// CARGANDO DATOS TABLA
$colname_alumno = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno = $_GET['cedula'];
}
$lapso_alumno = "-1";
if (isset($_GET['lapso'])) {
  $lapso_alumno = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT b.indicador_nacionalidad, b.apellido, b.nombre, b.cedula, e.nombre as anio, f.descripcion, h.nombre_proyecto

FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b, jos_curso d, jos_anio_nombre e, jos_seccion f, jos_alumno_curso g, jos_formato_evaluacion_planilla h

WHERE a.alumno_id=b.alumno_id AND b.alumno_id=g.alumno_id AND g.curso_id=d.id AND d.seccion_id=f.id AND d.anio_id=e.id AND a.confiplanilla_id=h.id AND b.cedula = %s AND a.lapso = %s", GetSQLValueString($colname_alumno, "bigint"), GetSQLValueString($lapso_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

// NOTA DESCRIPTIVA
$colname_boletin_des = "-1";
if (isset($_GET['cedula'])) {
  $colname_boletin_des = $_GET['cedula'];
}
$lap_boletin_des = "-1";
if (isset($_GET['lapso'])) {
  $lap_boletin_des = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_boletin_des = sprintf("SELECT * FROM jos_formato_nota_descriptiva_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cedula = %s AND lapso=%s", GetSQLValueString($colname_boletin_des, "bigint"),GetSQLValueString($lap_boletin_des, "int"));
$boletin_des = mysql_query($query_boletin_des, $sistemacol) or die(mysql_error());
$row_boletin_des = mysql_fetch_assoc($boletin_des);
$totalRows_boletin_des = mysql_num_rows($boletin_des);

$colname_profe_guia = "-1";
if (isset($_GET['cedula'])) {
  $colname_profe_guia = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_profe_guia = sprintf("SELECT * FROM jos_alumno_curso a, jos_curso b, jos_docente c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.curso_id=b.id AND b.docente_id=c.id AND d.cedula = %s", GetSQLValueString($colname_profe_guia, "bigint"));
$profe_guia = mysql_query($query_profe_guia, $sistemacol) or die(mysql_error());
$row_profe_guia = mysql_fetch_assoc($profe_guia);
$totalRows_profe_guia = mysql_num_rows($profe_guia);

//CARGANDO DATOS DE ASIGNATURAS
$colname_asignatura = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura = $_GET['cedula'];
}
$lapso_asignatura = "-1";
if (isset($_GET['lapso'])) {
  $lapso_asignatura = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='' AND d.cedula = %s AND a.lapso = %s ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura, "bigint"), GetSQLValueString($lapso_asignatura, "int"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

//PRIMER LAPSO
$colname_asignatura1 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura1 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura1 = sprintf("SELECT c.nombre, a.def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='' AND d.cedula = %s AND a.lapso = 1 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura1, "bigint"));
$asignatura1 = mysql_query($query_asignatura1, $sistemacol) or die(mysql_error());
$row_asignatura1 = mysql_fetch_assoc($asignatura1);
$totalRows_asignatura1 = mysql_num_rows($asignatura1);

//SEGUNDO LAPSO
$colname_asignatura2 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura2 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura2 = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='' AND d.cedula = %s AND a.lapso = 2 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura2, "bigint"));
$asignatura2 = mysql_query($query_asignatura2, $sistemacol) or die(mysql_error());
$row_asignatura2 = mysql_fetch_assoc($asignatura2);
$totalRows_asignatura2 = mysql_num_rows($asignatura2);

//TERCER LAPSO
$colname_asignatura3 = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura3 = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura3 = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='' AND d.cedula = %s AND a.lapso = 3 ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura3, "bigint"));
$asignatura3 = mysql_query($query_asignatura3, $sistemacol) or die(mysql_error());
$row_asignatura3 = mysql_fetch_assoc($asignatura3);
$totalRows_asignatura3 = mysql_num_rows($asignatura3);

//def de anio
$colname_asignatura_final = "-1";
if (isset($_GET['cedula'])) {
  $colname_asignatura_final = $_GET['cedula'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura_final = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='' AND d.cedula = %s GROUP BY a.alumno_id, c.nombre ORDER BY b.orden_asignatura ASC" , GetSQLValueString($colname_asignatura_final, "bigint"));
$asignatura_final = mysql_query($query_asignatura_final, $sistemacol) or die(mysql_error());
$row_asignatura_final = mysql_fetch_assoc($asignatura_final);
$totalRows_asignatura_final = mysql_num_rows($asignatura_final);

//EDUCACION PARA EL TRABAJO
//PRIMER LAPSO
$colname_mate141 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate141 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate141 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 1 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate141, "bigint"));
$mate141 = mysql_query($query_mate141, $sistemacol) or die(mysql_error());
$row_mate141 = mysql_fetch_assoc($mate141);
$totalRows_mate141 = mysql_num_rows($mate141);

//SEGUNDO LAPSO
$colname_mate142 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate142 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate142 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 2 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate142, "bigint"));
$mate142 = mysql_query($query_mate142, $sistemacol) or die(mysql_error());
$row_mate142 = mysql_fetch_assoc($mate142);
$totalRows_mate142 = mysql_num_rows($mate142);

//TERCER LAPSO
$colname_mate143 = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate143 = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate143 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s AND a.lapso = 3 GROUP BY a.alumno_id" , GetSQLValueString($colname_mate143, "bigint"));
$mate143 = mysql_query($query_mate143, $sistemacol) or die(mysql_error());
$row_mate143 = mysql_fetch_assoc($mate143);
$totalRows_mate143 = mysql_num_rows($mate143);

//def de ept
$colname_mate14_final = "-1";
if (isset($_GET['cedula'])) {
  $colname_mate14_final = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14_final = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c, jos_alumno_info d WHERE a.alumno_id=d.alumno_id AND a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND b.tipo_asignatura='educacion_trabajo' AND d.cedula = %s  GROUP BY a.alumno_id" , GetSQLValueString($colname_mate14_final, "bigint"));
$mate14_final = mysql_query($query_mate14_final, $sistemacol) or die(mysql_error());
$row_mate14_final = mysql_fetch_assoc($mate14_final);
$totalRows_mate14_final = mysql_num_rows($mate14_final);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: SISTEMA COLEGIONLINE::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

<script type="text/javascript"> 
var NEW_LOC = "admin_listado_planilla.php"; 
function goNow() { document.location=NEW_LOC; } 
function printPage() { 
  if (confirm("�Imprimir p�gina?")) {
    window.print();
  }
  // La redirecci�n ocurre incluso cuando la p�gina no se ha imprimido
  // si quieres hacer la redirecci�n s�lo si la p�gina se ha imprimido
  // inserta la siguiente frase arriba 
  goNow();
} 
</script>
</head>

<body>
<div id="ancho_boletin_lb">
<table border="0" align="left" class="tabla">
  <tr>
    <td width="229" align="left"><img src="../../images/gif/me_logo.gif" width="200" height="51" border="0"></td>
    <td width="588" align="right"><span class="texto_pequeno_gris"><strong><?php echo $row_colegio['nomcol']; ?></strong><br>
Coordinaci&oacute;n de Evaluaci&oacute;n y Control del Estudios<br>
<?php echo $row_colegio['dircol']; ?></span></td>
    <td width="92" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>
    </tr>
  <tr>
    <td colspan="3" align="center"><span class="texto_mediano_grande"><em><strong>INFORME DE ACTUACION DEL ESTUDIANTE </strong><strong></strong></em></span><em class="texto_mediano_gris"><strong>
        <?php echo $_GET['lapso']; ?> LAPSO - A&Ntilde;O ESCOLAR : 2010-2011</strong></em></td>
  </tr>
  <tr>
    <td colspan="2" align="left">
      <table border="0" style="border-bottom:1px solid; border-left:1px solid; border-right:1px solid; border-top:1px solid;">
      <tr>
        <td height="20" align="left" valign="bottom" class="texto_mediano_gris" style="width:18cm"><strong>&nbsp;CEDULA:</strong> <em><?php echo $row_alumno['indicador_nacionalidad']; ?>-<?php echo $row_alumno['cedula']; ?></em>&nbsp;&nbsp;<strong>APELLIDOS Y NOMBRES:</strong> <em><?php echo $row_alumno['apellido']; ?>, <?php echo $row_alumno['nombre']; ?></em></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" class="texto_mediano_gris"><strong>&nbsp;A&Ntilde;O Y SECCION:</strong> <em><?php echo $row_alumno['anio']." ".$row_alumno['descripcion']; ?></em></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" class="texto_mediano_gris"><strong>&nbsp;DOCENTE:</strong> <em><?php echo $row_profe_guia['apellido_docente']; ?>, <?php echo $row_profe_guia['nombre_docente']; ?></em></td>
      </tr>
      <tr>
        <td align="left" class="texto_mediano_gris"><strong>&nbsp;NOMBRE DEL PROYECTO: </strong><em class="texto_mediano_grande"><?php echo $row_alumno['nombre_proyecto']; ?></em></td>
      </tr>
    </table>
      <br></td>
    <td align="center"></td>
    </tr>
  <tr>
    <td colspan="3" align="center"><table border="0" >
      <tr>
        <td width="600" align="left" valign="top"><table border="1" cellpadding="0" cellspacing="0" style="font-family:verdana; font-size: 10px; color:#424242; ">
            <tr>
              <td width="400" align="center"><span style="font-size:14px; font-family: verdana; color: #424242"><strong>ASIGNATURAS</strong></span></td>
              <td width="50" align="center"><em>DEF<br />L1</em></td>
              <td width="50" align="center"><em>DEF<br />L2</em></td>
            <?php if($totalRows_asignatura3>0){ // NOTAS DE TERCER LAPSO
                    ?>
              <td width="50" align="center"><em>DEF<br />L3</em></td>
              <?php } ?>

              <td align="center"><span class="texto_mediano_gris"><strong><em>Def. <br>
A&ntilde;o<br>
Escolar</em></strong></span></td>

            </tr>
            <?php // NOTAS DE PRIMER LAPSO
                    ?>
            <td colspan="2">
               <table width="100%" height="100%"  style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
            <?php do { ?>
              <tr>
                <td width="400"  height="20" align="center"><span><strong><?php echo $row_asignatura1['nombre']; ?></strong></span></td>
                <td width="50" align="center"><span ><b><?php if($row_asignatura1['def']==0){ echo 'NC';}?> <?php if(($row_asignatura1['def']>0) and ($row_asignatura1['def']<10)) { echo "0".$row_asignatura1['def']; }?> <?php if($row_asignatura1['def']>9){ echo $row_asignatura1['def']; }?></b></span></td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura1 = mysql_fetch_assoc($asignatura1)); ?>
               </table>
            </td>

              <?php // NOTAS DE SEGUNDO LAPSO
                    ?>
            <td >
                <table width="100%" height="100%"  style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
            <?php do { ?>
              <tr>
                <td width="50" align="center"><span ><b><?php if($row_asignatura2['def']==0){ echo 'NC';}?> <?php if(($row_asignatura2['def']>0) and ($row_asignatura2['def']<10)) { echo "0".$row_asignatura2['def']; }?> <?php if($row_asignatura2['def']>9){ echo $row_asignatura2['def']; }?></b></span></td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura2 = mysql_fetch_assoc($asignatura2)); ?>
               </table>

            </td>

            <?php if($totalRows_asignatura3>0){
                        // NOTAS DE TERCER LAPSO
                    ?>
            <td >
                <table width="100%" height="100%"  style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
            <?php do { ?>
              <tr>

                <td width="50" align="center"><span ><b><?php if($row_asignatura3['def']==0){ echo 'NC';}?> <?php if(($row_asignatura3['def']>0) and ($row_asignatura3['def']<10)) { echo "0".$row_asignatura3['def']; }?> <?php if($row_asignatura3['def']>9){ echo $row_asignatura3['def']; }?></b></span></td>
<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/?>
              </tr>
              <?php } while ($row_asignatura3 = mysql_fetch_assoc($asignatura3)); ?>
               </table>

            </td>
<?php } ?>


 <?php 

if($totalRows_asignatura_final>0){
                        // DEFINITIVA DE ANIO

                    ?>
            <td >
                <table width="100%" height="100%"  style="font-size:9px;" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
            <?php do { ?>
              <tr>

                <td width="50" align="center" style="font-size:12px"><span ><b><?php if($row_asignatura_final['def']==0){ echo 'NC';}?> <?php if(($row_asignatura_final['def']>0) and ($row_asignatura_final['def']<10)) { echo "0".$row_asignatura_final['def']; }?> <?php if($row_asignatura_final['def']>9){ echo $row_asignatura_final['def']; }?></b></span></td>

<?php /*
                <td align="center"><span class="texto_mediano_gris" style="font-size:12px; font-weight:bold; font-family:Verdana, Geneva, sans-serif"><?php $df=$row_asignatura['Definitiva_Curso']; echo number_format($df, 0); ?></span></td>

*/
?>
              </tr>
              <?php } while ($row_asignatura_final = mysql_fetch_assoc($asignatura_final)); ?>
               </table>

            </td>
<?php } 

?>


  <?php if($totalRows_mate141>0){?>
	<tr>
        <?php //EPT PRIMER LAPSO ?>
	<td align="center"><span ><strong>EDUCACION PARA EL TRABAJO</strong></span></td>

	 <td align="center"><span ><b><?php if($row_mate141['def']==0){ echo 'NC';}?> <?php if(($row_mate141['def']>0) and ($row_mate141['def']<10)) { echo "0".$row_mate141['def']; }?> <?php if($row_mate141['def']>9){ echo $row_mate141['def']; }?></b></span></td>

         <?php //EPT SEGUNDO LAPSO ?>

	 <td align="center"><span ><b><?php if($row_mate142['def']==0){ echo 'NC';}?> <?php if(($row_mate142['def']>0) and ($row_mate142['def']<10)) { echo "0".$row_mate142['def']; }?> <?php if($row_mate142['def']>9){ echo $row_mate142['def']; }?></b></span></td>

         <?php //EPT TERCER LAPSO ?>
         <?php if($totalRows_mate143>0){?>


	 <td align="center"><span ><b><?php if($row_mate143['def']==0){ echo 'NC';}?> <?php if(($row_mate143['def']>0) and ($row_mate143['def']<10)) { echo "0".$row_mate143['def']; }?> <?php if($row_mate143['def']>9){ echo $row_mate143['def']; }?></b></span></td>
         <?php } ?>
        

<?php //DEF EPT 

?>
         <?php if($totalRows_mate14_final>0){?>

	 <td align="center" style="font-size:12px"><span ><b><?php if($row_mate14_final['def']==0){ echo 'NC';}?> <?php if(($row_mate14_final['def']>0) and ($row_mate14_final['def']<10)) { echo "0".$row_mate14_final['def']; }?> <?php if($row_mate14_final['def']>9){ echo $row_mate14_final['def']; }?></b></span></td>
         <?php } ?>
         
	</tr>

<?php } 

?>



          </table></td>
        <td width="200" valign="top"><table border="1" cellpadding="0" cellspacing="0" style="width:5cm; margin-left:0">
          <tr>
            <td height="30" align="center" bgcolor="#CCCCCC" class="texto_pequeno_gris"><strong class="texto_mediano_grande">DESCRIPCION DEL ESTUDIANTE</strong></td>
          </tr>
          <tr>
            <td class="texto_mediano_gris"><br>
              <table border="0" align="center" cellpadding="0" cellspacing="0" style="width:11cm">
              <tr>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />

                <td><?php echo $row_boletin_des['descripcion']; ?></td>
              </tr>
            </table>
              <br>
              <?php if($row_boletin_des['nom_mate_pendiente']<>""){?>
              <strong>&nbsp;&nbsp;Materia Pendiente:</strong> <?php echo $row_boletin_des['nom_mate_pendiente']; ?> <strong>Calificaci&oacute;n:</strong> <?php echo $row_boletin_des['nota_mate_pendiente']; }?>
</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p>&nbsp;</p>
      <table border="0" style="width:20cm" >
      <tr>
        <td style="border-bottom:1px solid">&nbsp;</td>
        <td style="width:5cm">&nbsp;</td>
        <td style="border-bottom:1px solid">&nbsp;</td>


      </tr>
      <tr class="texto_mediano_gris">
        <td align="center">DOCENTE - GUIA</td>
        <td align="center">&nbsp;</td>
        <td align="center">COOR. DEPARTAMENTO DE EVALUACION</td>

      </tr>
    </table></td>
  </tr>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($colegio);
mysql_free_result($alumno);

mysql_free_result($boletin_des);

mysql_free_result($profe_guia);

mysql_free_result($asignatura);
mysql_free_result($asignatura1);
mysql_free_result($asignatura2);
mysql_free_result($asignatura3);
mysql_free_result($asignatura_final);
mysql_free_result($mate141);
mysql_free_result($mate142);
mysql_free_result($mate143);
mysql_free_result($mate14_final);
?>
