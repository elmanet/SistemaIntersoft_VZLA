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
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_pr a, jos_alumno_info b, jos_formato_evaluacion_planilla_primaria c WHERE a.alumno_id=b.alumno_id AND a.confiplanilla_id=c.id AND b.cedula = %s AND a.lapso=%s ", GetSQLValueString($colname_alumno, "text"),GetSQLValueString($colname_lap, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>

<body>
<div id="ancho_boletin">
<table border="0" align="center" class="tabla">
  <tr>
    <td valign="top"><table border="0" align="center" class="columna">
      <tr>
        <td colspan="2"><table border="0" class="columna">
          <tr>
            <td width="79"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="79" height="79"></td>
            <td width="360" align="left"><span class="texto_grande_gris"><?php echo $row_colegio['nomcol']; ?></span><br>
              <span class="texto_mediano_gris"><?php echo $row_colegio['dircol']; ?><br>
                <?php echo $row_colegio['telcol']; ?><br>
              </span><strong><span class="texto_pequeno_gris"><?php echo $row_colegio['webcol']; ?></span></strong><br></td>
            <td width="1">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="texto_mediano_gris"><strong>NOMBRE DEL PROYECTO:</strong> <?php echo $row_alumno['nombre_proyecto']; ?></span></td>
      </tr>
      <tr>
        <td colspan="2"><span class="texto_mediano_gris"><strong>INICIO:</strong> <?php echo $row_alumno['desde']; ?> <strong>CIERRE:</strong> <?php echo $row_alumno['hasta']; ?></span></td>
      </tr>
      <tr>
        <td colspan="2"><span class="texto_mediano_gris"><strong>No. DE SEMANAS:</strong> <?php echo $row_alumno['no_semanas']; ?></span></td>
      </tr>
      <tr>
        <td colspan="2"><span class="texto_mediano_gris"><strong>DIAS LABORADOS:</strong> <?php echo $row_alumno['dia_laborados']; ?> &nbsp;&nbsp;<strong>INASISTENCIA: </strong><?php echo $row_alumno['inasistencia']; ?></span></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="texto_mediano_gris"><strong>ESTUDIANTE: </strong></span><strong class="texto_mediano_gris"><em style="text-decoration:underline"><?php echo $row_alumno['apellido']; ?> <?php echo $row_alumno['nombre']; ?></em></strong></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">
        	<div class="nota">
            	<p class="texto_mediano_grande"><strong>Apreciaci&oacute;n: <?php echo $row_alumno['def_cualitativa']; ?> - <?php echo $row_alumno['def_cuantitativa']; ?></strong></p>
            </div>
        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><strong class="texto_mediano_grande">OBSERVACIONES Y RECOMENDACIONES DEL REPRESENTANTE:</strong></td>
      </tr>
      <tr>
        <td colspan="2" style="border-bottom:1px solid;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="border-bottom:1px solid;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="222" align="center"><table width="200" border="0">
          <tr>
            <td  style="border-bottom:1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="texto_mediano_gris">Director</td>
          </tr>
        </table></td>
        <td width="222" align="center"><table width="200" border="0">
          <tr>
            <td  style="border-bottom:1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="texto_mediano_gris">Docente</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center"><table width="200" border="0">
          <tr>
            <td  style="border-bottom:1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="texto_mediano_gris">Representante</td>
          </tr>
        </table></td>
        <td align="center"><table width="200" border="0">
          <tr>
            <td  style="border-bottom:1px solid;"><br>
              <br></td>
          </tr>
          <tr>
            <td align="center" class="texto_mediano_gris">Coord. de Proyectos<br>
              de Evaluaci&oacute;n</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td valign="top"><table border="0" align="center" class="columna">
      <tr>
        <td align="center" valign="middle"><span class="texto_mediano_grande"><strong>APRECIACION CUALITATIVA POR AVANCE DE COMPETENCIAS Y DIMENSIONES DE APRENDIZAJE</strong></span></td>
      </tr>
      <tr>
        <td><span style="text-align:justify; font-family:verdana; font-size:8.4pt;" ><p align="justify"><?php echo $row_alumno['des_cualitativa']; ?></p></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
?>
