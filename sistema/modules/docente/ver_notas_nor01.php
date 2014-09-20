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
$query_tipofl = sprintf("SELECT * FROM jos_formato_evaluacion_tfinal" , GetSQLValueString($colname_tipofl, "int"));
$tipofl = mysql_query($query_tipofl, $sistemacol) or die(mysql_error());
$row_tipofl = mysql_fetch_assoc($tipofl);
$totalRows_tipofl = mysql_num_rows($tipofl);
$tipofl=$row_tipofl['cod'];


$colname_reporte = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_reporte = $_GET['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, f.id as asig_id, g.nombre_docente, g.apellido_docente, h.nombre as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_docente g, jos_asignatura_nombre h WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND f.docente_id=g.id AND f.asignatura_nombre_id=h.id AND f.id= %s" , GetSQLValueString($colname_reporte, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

$maxRows_planilla = 19;
$pageNum_planilla = 0;
if (isset($_GET['pageNum_planilla'])) {
  $pageNum_planilla = $_GET['pageNum_planilla'];
}
$startRow_planilla = $pageNum_planilla * $maxRows_planilla;

$colname_planilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_planilla = $_GET['asignatura_id'];
}
$lap_planilla = "-1";
if (isset($_GET['lapso'])) {
  $lap_planilla = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b, jos_alumno_curso c WHERE a.alumno_id=b.alumno_id AND b.alumno_id=c.alumno_id AND a.asignatura_id = %s AND a.lapso=%s ORDER BY c.no_lista ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$query_limit_planilla = sprintf("%s LIMIT %d, %d", $query_planilla, $startRow_planilla, $maxRows_planilla);
$planilla = mysql_query($query_limit_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);

if (isset($_GET['totalRows_planilla'])) {
  $totalRows_planilla = $_GET['totalRows_planilla'];
} else {
  $all_planilla = mysql_query($query_planilla);
  $totalRows_planilla = mysql_num_rows($all_planilla);
}
$totalPages_planilla = ceil($totalRows_planilla/$maxRows_planilla)-1;

//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_confiplanilla = $_GET['asignatura_id'];
}
$lap_confiplanilla = "-1";
if (isset($_GET['lapso'])) {
  $lap_confiplanilla = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s AND lapso=%s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "int"), GetSQLValueString($lap_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);

$queryString_planilla = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_planilla") == false && 
        stristr($param, "totalRows_planilla") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_planilla = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_planilla = sprintf("&totalRows_planilla=%d%s", $totalRows_planilla, $queryString_planilla);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: COLEGIONLINE ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/form_impresion.css" rel="stylesheet" type="text/css" media="print">
</head>
<body>
<?php if ($totalRows_planilla>0) { // SI EXITEN DATOS
    ?>
  <table width="1200" border="0" align="left" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td><table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="66" align="center" valign="top" class="titulosgrandes_eloy"><table width="1200" border="0" align="center">
              <tr>
                <td width="66" align="left"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>
                <td width="498" align="left"><span class="titulo_grande_gris">Rep&uacute;blica Bolivariana de Venezuela</span><span class="titulo_grande_gris"><br>
                    <?php echo $row_colegio['nomcol']; ?><br>
                </span>
                <hr align="left" width="300"></td>
                <td width="622" align="center"><span class="titulo_extragrande_gris">&nbsp;PLANILLA DE ACTUACION GENERAL DEL ESTUDIANTE</span></td>
              </tr>
            </table></td>
            <td width="2279" align="left" valign="middle" class="titulosgrandes_eloy">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="top" class="titulosgrandes_eloy"><table border="0">
              <tr>
                <td width="2507" height="40" align="center"><table width="1200" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000" bordercolordark="#000000">
                  <tr>
                      <td colspan="31" align="left" class="texto_pequeno_gris"><table width="1200" border="0" align="center">
                        <tr>
                          <td width="842" height="100" align="left" valign="top"><span class="texto_mediano_gris"><strong>&nbsp;&nbsp;Nombre Docente:</strong> <?php echo $row_reporte['nombre_docente']; ?> <?php echo $row_reporte['apellido_docente']; ?><br>
                            <strong>&nbsp;&nbsp;Asignatura:</strong> <?php echo $row_reporte['mate']; ?><br>
                            <strong>&nbsp;&nbsp;Secci&oacute;n:</strong> <?php echo $row_reporte['anio']." ".$row_reporte['descripcion']; ?><br>
                            <strong>&nbsp;&nbsp;Periodo:</strong>2010-2011<br>
                            <strong>&nbsp;&nbsp;Nombre del Proyecto:</strong> <?php echo $row_confiplanilla['nombre_proyecto']; ?><br>
                            <strong>&nbsp;&nbsp;Lapso:</strong> <?php echo $row_planilla['lapso']; ?> Lapso.</span></td>
                          <td width="480" align="center"><table width="480" border="1" align="right" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000">
                            <tr>
                              <td colspan="4" align="center" valign="middle"><strong><span class="texto_mediano_gris">INFORMACION EVALUACIONES PARCIALES</span></strong></td>
                            </tr>
                            <tr>
                                <td align="center" width="50" valign="middle"></td>
                                <td align="center" width="80" valign="middle"><b>FECHA</b></td>
                                <td align="center" width="150" valign="middle"><b>OBJETIVO</b></td>
                                <td align="center" width="200" valign="middle"><b>INSTRUMENTO</b></td>
                            </tr>

                            <tr>
                              <td align="center" valign="middle">I</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['fecha1'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['info1'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['tipo_eva1'];?></td>

                            </tr>
                            <tr>
                              <td align="center" valign="middle">II</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['fecha2'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['info2'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['tipo_eva2'];?></td>
                            </tr>
                            <tr>
                              <td align="center" valign="middle">III</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['fecha3'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['info3'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['tipo_eva3'];?></td>
                            </tr>
                            <tr>
                              <td align="center" valign="middle">IV</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['fecha4'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['info4'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['tipo_eva4'];?></td>
                            </tr>
                              <tr>
                              <td align="center" valign="middle">V</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['fecha5'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['info5'];?></td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['tipo_eva5'];?></td>
                            </tr>
                          </table></td>
                          <td width="300" align="center"><table width="300" border="1" align="left" cellpadding="0" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000">
                            <tr>
                              <td colspan="2" align="center" valign="middle"><strong><span class="texto_mediano_gris">RASGOS DE PERSONALIDAD</span></strong></td>
                            </tr>
 
                            <tr>
                                <td align="center" width="15" valign="middle">1</td>
                                <td align="center" width="275" valign="middle"><?php echo $row_confiplanilla['isc1'];?></td>
                            </tr>
                            <tr>
                              <td align="center" valign="middle">2</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['isc2'];?></td>
                            </tr>
                            <tr>
                              <td align="center" valign="middle">3</td>
                              <td align="center" valign="middle"><?php echo $row_confiplanilla['isc3'];?></td>
                            </tr>

                          </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  <tr>
                    <td rowspan="6" align="center" class="texto_mediano_gris"><strong>&nbsp;NO.&nbsp;</strong></td>
                    <td width="25" rowspan="6" align="center" class="texto_mediano_gris"><strong>&nbsp;CEDULA&nbsp;</strong></td>
                    <td width="350" rowspan="6" align="center" class="texto_mediano_gris"><strong>NOMBRE DEL ALUMNO</strong></td>
      
      
                    <td colspan="15" align="center" class="texto_pequeno_gris"><strong>CALIFICACIONES DE EVALUACIONES PARCIALES</strong></td>
                    <td width="20" rowspan="6" align="center" class="texto_pequeno_gris"><strong>&nbsp;SUMA&nbsp;</strong></td>
                    <td colspan="4" rowspan="4" align="center" class="texto_pequeno_gris"><strong>RASGO DE PERSONALIDAD</strong></td>
                    <td width="40" rowspan="6" align="center" class="texto_pequeno_gris"><strong>AJUSTE RASGO</strong></td>
		<?php if ($tipofl==1){ ?>
                   <td width="40" rowspan="6" align="center" class="texto_pequeno_gris"><strong>&nbsp;70%&nbsp;</strong></td>
                    <td colspan="3" rowspan="3" align="center" class="texto_pequeno_gris"><strong>FINAL DE LAPSO</strong></td>
                    <td width="40" rowspan="6" align="center" class="texto_pequeno_gris"><strong>&nbsp;30%<br>
                      +<br>
                      70%&nbsp;</strong></td>
                   <?php } ?>
                      <td width="40" rowspan="6" align="center" class="texto_pequeno_gris"><strong>&nbsp;DEF.&nbsp;</strong></td>
                    <td width="20" rowspan="6" align="center" class="texto_pequeno_gris"><strong>&nbsp;AJUSTE&nbsp;</strong></td>
                    </tr>

                  <tr>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong>I</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong>II</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong>III</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong>IV</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong>V</strong></td>
                    </tr>
                  <tr>
                    <td colspan="15" align="center" class="texto_pequeno_gris"><strong>PORCENTAJES</strong></td>
                    </tr>
                  <tr>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong><?php echo $row_confiplanilla['p1']; ?>%</strong><br></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong><?php echo $row_confiplanilla['p2']; ?>%</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong><?php echo $row_confiplanilla['p3']; ?>%</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong><?php echo $row_confiplanilla['p4']; ?>%</strong></td>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong><?php echo $row_confiplanilla['p5']; ?>%</strong></td>
		<?php if ($tipofl==1){ ?>
                    <td colspan="3" align="center" class="texto_pequeno_gris"><strong>30%</strong></td>
		<?php } ?>
                    </tr>

                  <tr>
           
                    <td width="40" height="12" rowspan="2" align="center" class="texto_pequeno_gris"><strong>F1</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>A112</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>%</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>F1</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>A112</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>%</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>F1</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>A112</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>%</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>F1</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>A112</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>%</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>F1</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>A112</strong></td>
                    <td width="40" rowspan="2" align="center" class="texto_pequeno_gris"><strong>%</strong></td>
             
                  </tr>
                  <tr>
                    <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>1</strong></td>
                    <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>2</strong></td>
                    <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>3</strong></td>
                    <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>PRE</strong></td>
		<?php if ($tipofl==1){ ?>
                  <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>F1</strong></td>
                    <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>F2</strong></td>
                    <td width="40" height="6" align="center" class="texto_pequeno_gris"><strong>%</strong></td>
		<?php } ?>

                    </tr>
                    <?php $lista=1;
				  	do { ?>
                    <tr >
                        <td height="20" align="center" class="texto_pequeno_gris">&nbsp;<?php if($pageNum_planilla==1){ $newlista=$maxRows_planilla+$lista; echo $newlista; $lista ++;   } if ($pageNum_planilla==0){ echo $lista; $lista ++;} ?>&nbsp;</td>
                        <td height="20" align="center" style="font-family: arial; font-size: 8px;">&nbsp;<?php echo $row_planilla['indicador_nacionalidad']; ?>-<?php echo $row_planilla['cedula']; ?>&nbsp;</td>
                        <td height="20" align="left" style="font-family: arial; font-size: 8px;">&nbsp;<?php echo $row_planilla['apellido']; ?>, <?php echo $row_planilla['nombre']; ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p1f1']==(int)0.00 && $row_planilla['p1f1']!==null){ echo 'NP';} else { echo $row_planilla['p1f1'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p1f2']==(int)0.00 && $row_planilla['p1f2']!==null){ echo 'NP';} else { echo $row_planilla['p1f2'];} ?></td>

                        <?php if($row_planilla['p1f2']==null){?>
                       <b> <td align="center" class="texto_pequeno_gris"><?php $po1=($row_planilla['p1f1']*$row_confiplanilla['p1'])/100; if($po1==0){ echo '';} else { echo "<b>".$po1."</b>";} ?></td>
                        <?php } else { ?>
                        <td align="center" class="texto_pequeno_gris"><?php $po1=($row_planilla['p1f2']*$row_confiplanilla['p1'])/100; if($po1==0){ echo '';} else { echo "<b>".$po1."</b>";} ?></td>
                        <?php } ?>

                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p2f1']==(int)0.00 && $row_planilla['p2f1']!==null){ echo 'NP';} else { echo $row_planilla['p2f1'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p2f2']==(int)0.00 && $row_planilla['p2f2']!==null){ echo 'NP';} else { echo $row_planilla['p2f2'];} ?></td>

                        <?php if($row_planilla['p2f2']==null){?>
                        <td align="center" class="texto_pequeno_gris"><?php $po2=($row_planilla['p2f1']*$row_confiplanilla['p2'])/100; if($po2==0){ echo '';} else { echo "<b>".$po2."</b>";} ?></td>
                        <?php } else { ?>
                        <td align="center" class="texto_pequeno_gris"><?php $po2=($row_planilla['p2f2']*$row_confiplanilla['p2'])/100; if($po2==0){ echo '';} else { echo "<b>".$po2."</b>";} ?></td>
                        <?php } ?>

                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p3f1']==(int)0.00 && $row_planilla['p3f1']!==null){ echo 'NP';} else { echo $row_planilla['p3f1'];} ?></td>                       
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p3f2']==(int)0.00 && $row_planilla['p3f2']!==null){ echo 'NP';} else { echo $row_planilla['p3f2'];} ?></td>

                        <?php if($row_planilla['p3f2']==null){?>
                        <td align="center" class="texto_pequeno_gris"><?php $po3=($row_planilla['p3f1']*$row_confiplanilla['p3'])/100; if($po3==0){ echo '';} else { echo "<b>".$po3."</b>";} ?></td>
                        <?php } else { ?>
                        <td align="center" class="texto_pequeno_gris"><?php $po3=($row_planilla['p3f2']*$row_confiplanilla['p3'])/100; if($po3==0){ echo '';} else { echo "<b>".$po3."</b>";} ?></td>
                        <?php } ?>

                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p4f1']==(int)0.00 && $row_planilla['p4f1']!==null){ echo 'NP';} else { echo $row_planilla['p4f1'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p4f2']==(int)0.00 && $row_planilla['p4f2']!==null){ echo 'NP';} else { echo $row_planilla['p4f2'];} ?></td>
                        <?php if($row_planilla['p4f2']==null){?>
                        <td align="center" class="texto_pequeno_gris"><?php $po4=($row_planilla['p4f1']*$row_confiplanilla['p4'])/100; if($po4==0){ echo '';} else { echo "<b>".$po4."</b>";} ?></td>
                        <?php } else { ?>
                        <td align="center" class="texto_pequeno_gris"><?php $po4=($row_planilla['p4f2']*$row_confiplanilla['p4'])/100; if($po4==0){ echo '';} else { echo "<b>".$po4."</b>";} ?></td>
                        <?php } ?>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p5f1']==(int)0.00 && $row_planilla['p5f1']!==null){ echo 'NP';} else { echo $row_planilla['p5f1'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['p5f2']==(int)0.00 && $row_planilla['p5f2']!==null){ echo 'NP';} else { echo $row_planilla['p5f2'];} ?></td>
                        <?php if($row_planilla['p5f2']==null){?>
                        <td align="center" class="texto_pequeno_gris"><?php $po5=($row_planilla['p5f1']*$row_confiplanilla['p5'])/100; if($po5==0){ echo '';} else { echo "<b>".$po5."</b>";} ?></td>
                        <?php } else { ?>
                        <td align="center" class="texto_pequeno_gris"><?php $po5=($row_planilla['p5f2']*$row_confiplanilla['p5'])/100; if($po5==0){ echo '';} else { echo "<b>".$po5."</b>";} ?></td>
                        <?php } ?>

                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['sumanotas']==(int)0.00 && $row_planilla['sumanotas']!==null){ echo '';} else { echo $row_planilla['sumanotas'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['ind1']=='0') { echo 'C';} if($row_planilla['ind1']=='1') { echo 'B';} if($row_planilla['ind1']=='2') { echo 'A';} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['ind2']=='0') { echo 'C';} if($row_planilla['ind2']=='1') { echo 'B';} if($row_planilla['ind2']=='2') { echo 'A';}  ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['ind3']=='0') { echo 'C';} if($row_planilla['ind3']=='1') { echo 'B';} if($row_planilla['ind3']=='2') { echo 'A';}  ?></td>
                        <td align="center" class="texto_pequeno_gris"><b><?php if($row_planilla['indtotal']=='0') { echo 'C';} if($row_planilla['indtotal']=='1') { echo 'B';} if($row_planilla['indtotal']=='2') { echo 'A';}  ?></b></td>
		<?php if ($tipofl==1){ ?>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['sumapon']==(int)0.00 && $row_planilla['sumapon']!==null){ echo '';} else { echo $row_planilla['sumapon'];} ?></td>



                       <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['seten']==(int)0.00 && $row_planilla['seten']!==null){ echo '';} else { echo $row_planilla['seten'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['flf1']==(int)0.00 && $row_planilla['flf1']!==null){ echo 'NP';} else { echo $row_planilla['flf1'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['flf2']==(int)0.00 && $row_planilla['flf2']!==null){ echo 'NP';} else { echo $row_planilla['flf2'];} ?></td>
                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['treinta']==0){ echo ""; }else{ echo $row_planilla['treinta']; }?></td>

<?php } ?>

                        <td align="center" class="texto_pequeno_gris"><?php if($row_planilla['calpro']==0){ echo ""; }else{ echo $row_planilla['calpro']; }?></td>
                        <td align="center" class="texto_pequeno_gris"><strong ><?php if($row_planilla['def']==0){ echo "NC";}if(($row_planilla['def']>0) and ($row_planilla['def']<10)){ echo "0".$row_planilla['def'];} if($row_planilla['def']>9){ echo $row_planilla['def'];}  ?></strong></td>
                        
                        <td align="center" class="texto_pequeno_gris">&nbsp;</td>
                      </tr>
                     
                    <?php } while ($row_planilla = mysql_fetch_assoc($planilla)); ?>
                </table></td>
              </tr>
              <tr>
                <td height="41" align="center"><table width="1200" border="0" cellpadding="0" cellspacing="0" bordercolordark="#000000" bordercolorlight="#000000">

           
                  <tr>
                      <td width="455" class="texto_mediano_gris">FIRMA DEL DOCENTE:__________________________________</td>

                    <td width="408" align="center" valign="bottom"><span class="texto_mediano_gris"></span></td>
                    <td width="337" align="center" valign="middle" class="texto_mediano_gris">

                     <table border="1" cellpadding="0" cellspacing="0" bordercolordark="#000000" bordercolorlight="#000000" class="ocultar">
                      <tr>
                        <td colspan="2" align="center" valign="middle"><strong>IDENTIFICACION DEL CURSO</strong></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" class="texto_pequeno_gris">Total de Estudiantes: </td>
                        <td height="15" align="center" valign="middle" class="texto_pequeno_gris"><?php echo $totalRows_planilla ?></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" class="texto_pequeno_gris">N&uacute;mero de Estudiantes en esta P&aacute;gina:</td>
                        <td width="30" height="15" align="center" valign="middle" class="texto_pequeno_gris">&nbsp;&nbsp;<?php if($totalRows_planilla > 19 and $pageNum_planilla==0){ echo 19;} if($totalRows_planilla > 19 and $pageNum_planilla==1){$newtotal=$totalRows_planilla-19; echo $newtotal;} if($totalRows_planilla < 19){echo $totalRows_planilla;} ?>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="15" colspan="2" align="center" valign="middle" class="texto_pequeno_gris"><?php if ($pageNum_planilla > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_planilla=%d%s", $currentPage, max(0, $pageNum_planilla - 1), $queryString_planilla); ?>">&lt;&lt;Anterior </a>
                          <?php } // Show if not first page ?>
                          <?php if ($pageNum_planilla == 0) { // Show if first page ?>
                          <a href="<?php printf("%s?pageNum_planilla=%d%s", $currentPage, min($totalPages_planilla, $pageNum_planilla + 1), $queryString_planilla); ?>">Siguiente &gt;&gt;</a>
                          <?php } // Show if first page ?></td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="22" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF" class="textomediano_eloy"><span class="titulosmedianos_eloy">
              <?php if (1== 0) { // Show if recordset empty ?>
            </span>
              <table width="400" border="0">
                <tr>
                  <td align="center"><p><img src="../images/png/6.png" width="150" height="150"><br>
                      <span class="texto_grande_gris">&iexcl;NOTAS BLOQUEADAS!</span><span class="texto_mediano_gris"><br>
                    <br>
                    LES PEDIMOS DISCULPAS A TODOS LOS ALUMNOS Y REPRESENTANTES DEL COLEGIO POR LA FALLA EN LA PUBLICACION DE LAS NOTAS.</span></p>
                    <p class="texto_pequeno_gris">PROXIMAMENTE SE CORREGIR&Aacute; EL PROBLEMA Y SE ESTARAN PUBLICANDO LAS NOTAS PARCIALES DEL 3ER LAPSO</p></td>
                </tr>
              </table>
              <span class="titulosmedianos_eloy">
              <?php } // Show if recordset empty ?>
              </span></td>
          </tr>
        </table>
    <tr>
        <td></td>
  </table>
<?php } // FIN SI EXISTEN DATOS
?>
    <?php if ($totalRows_planilla==0){ // SI NO EXISTEN DATOS
        ?>
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
    <?php } // FIN SI NO EXISTEN DATOS
    ?>

</body>
</html>
<?php


mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($planilla);

mysql_free_result($confiplanilla);
?>
