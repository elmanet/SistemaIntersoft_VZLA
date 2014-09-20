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
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);
$lapso_encurso=$row_lapso['cod'];

mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);
$confi=$row_confip['codfor'];

$colname_asignatura = "-1";
if (isset($_GET['curso_id'])) {
  $colname_asignatura = $_GET['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id AND a.id = %s", GetSQLValueString($colname_asignatura, "text"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);


// PROMEDIO DE 1 LAPSO

mysql_select_db($database_sistemacol, $sistemacol);
if ($confi=="bol01"){
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=1 GROUP BY a.lapso", GetSQLValueString($colname_mate151, "int"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);
}
if ($confi=="bol02"){
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=1 GROUP BY a.lapso", GetSQLValueString($colname_mate151, "int"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);
}
if ($confi=="nor01"){
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=1 GROUP BY a.lapso", GetSQLValueString($colname_mate151, "int"));
$mate151 = mysql_query($query_mate151, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);
}
if ($confi=="nor02"){
$query_mate151 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_nor02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=1 GROUP BY a.lapso", GetSQLValueString($colname_mate151, "int"));
$mate151 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate151 = mysql_fetch_assoc($mate151);
$totalRows_mate151 = mysql_num_rows($mate151);
}


// PROMEDIO DE 2 LAPSO

mysql_select_db($database_sistemacol, $sistemacol);
if ($confi=="bol01"){
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=2 GROUP BY a.lapso", GetSQLValueString($colname_mate152, "int"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);
}
if ($confi=="bol02"){
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=2 GROUP BY a.lapso", GetSQLValueString($colname_mate152, "int"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);
}
if ($confi=="nor01"){
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=2 GROUP BY a.lapso", GetSQLValueString($colname_mate152, "int"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);
}
if ($confi=="nor02"){
$query_mate152 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_nor02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=2 GROUP BY a.lapso", GetSQLValueString($colname_mate152, "int"));
$mate152 = mysql_query($query_mate152, $sistemacol) or die(mysql_error());
$row_mate152 = mysql_fetch_assoc($mate152);
$totalRows_mate152 = mysql_num_rows($mate152);
}


// PROMEDIO DE 3 LAPSO

mysql_select_db($database_sistemacol, $sistemacol);
if ($confi=="bol01"){
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),0) as def FROM jos_formato_evaluacion_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=3 GROUP BY a.lapso", GetSQLValueString($colname_mate153, "int"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);
}
if ($confi=="bol02"){
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=3 GROUP BY a.lapso", GetSQLValueString($colname_mate153, "int"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);
}
if ($confi=="nor01"){
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=3 GROUP BY a.lapso", GetSQLValueString($colname_mate153, "int"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);
}
if ($confi=="nor02"){
$query_mate153 = sprintf("SELECT ROUND(AVG(a.def),2) as def FROM jos_formato_evaluacion_nor02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND a.def>0 AND a.lapso=3 GROUP BY a.lapso", GetSQLValueString($colname_mate153, "int"));
$mate153 = mysql_query($query_mate153, $sistemacol) or die(mysql_error());
$row_mate153 = mysql_fetch_assoc($mate153);
$totalRows_mate153 = mysql_num_rows($mate153);
}


mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../../css/marca.css" rel="stylesheet" type="text/css" />
</head>
<body>

<center>
<table ><tr>

<?php // MATERIA 1
?> 
<td aling="center">
			<h1>PROMEDIO GENERAL DE LA INSTITUCI&Oacute;N</h1>
			<h2></h2></td></tr><tr>
<table>
<tr>
<td >
<span class="texto_grande_gris" style="font-size:20px;">1ER LAPSO: </span><span class="texto_grande_gris"><?php if($row_mate151['def']==0){ echo "No se han cargado";} if(($row_mate151['def']>0) and ($row_mate151['def']<10)){ echo "0".$row_mate151['def'];} if(($row_mate151['def']>9) and ($row_mate151['def']<=20)){ echo $row_mate151['def'];} ?> Puntos</span>
</td>
</tr>

<tr>
<td >
<span class="texto_grande_gris" style="font-size:20px;">2DO LAPSO: </span><span class="texto_grande_gris"><?php if($row_mate152['def']==0){ echo "No se han cargado";} if(($row_mate152['def']>0) and ($row_mate152['def']<10)){ echo "0".$row_mate152['def'];} if(($row_mate152['def']>9) and ($row_mate152['def']<=20)){ echo $row_mate152['def'];} ?> Puntos</span>
</td>
</tr>

<tr>
<td >
<span class="texto_grande_gris" style="font-size:20px;">3ER LAPSO: </span><span class="texto_grande_gris"><?php if($row_mate153['def']==0){ echo "No se han cargado";} if(($row_mate153['def']>0) and ($row_mate153['def']<10)){ echo "0".$row_mate153['def'];} if(($row_mate153['def']>9) and ($row_mate153['def']<=20)){ echo $row_mate153['def'];} ?> Puntos</span>
</td>
</tr>
</table>



<span class="texto_pequeno_gris">INTERSOFT | Software Educativo para: <b><?php echo $row_colegio['webcol'];?></b></span>
</center>


</body>
</html>
<?php
mysql_free_result($asignatura);
mysql_free_result($confip);
mysql_free_result($mate151);
mysql_free_result($mate152);
mysql_free_result($mate153);

mysql_free_result($colegio);
mysql_free_result($lapso);

?>
