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


// PROMEDIO DE LAPSO GENERAL
$colname_mate15g = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate15g = $_GET['curso_id'];
}
$lap_mate15g = "-1";
if (isset($_GET['lapso'])) {
  $lap_mate15g = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
if ($confi=="bol01"){
$query_mate15g = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY b.curso_id ORDER BY def DESC", GetSQLValueString($colname_mate15g, "text"), GetSQLValueString($lap_mate15g, "int"));
$mate15g = mysql_query($query_mate15g, $sistemacol) or die(mysql_error());
$row_mate15g = mysql_fetch_assoc($mate15g);
$totalRows_mate15g = mysql_num_rows($mate15g);
}
if ($confi=="bol02"){
$query_mate15g = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY b.curso_id ORDER BY def DESC", GetSQLValueString($colname_mate15g, "text"), GetSQLValueString($lap_mate15g, "int"));
$mate15g = mysql_query($query_mate15g, $sistemacol) or die(mysql_error());
$row_mate15g = mysql_fetch_assoc($mate15g);
$totalRows_mate15g = mysql_num_rows($mate15g);
}
if ($confi=="nor01"){
$query_mate15g = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY b.curso_id ", GetSQLValueString($colname_mate15g, "int"), GetSQLValueString($lap_mate15g, "int"));
$mate15g = mysql_query($query_mate15g, $sistemacol) or die(mysql_error());
$row_mate15g = mysql_fetch_assoc($mate15g);
$totalRows_mate15g = mysql_num_rows($mate15g);
}
if ($confi=="nor02"){
$query_mate15g = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY b.curso_id ", GetSQLValueString($colname_mate15g, "text"), GetSQLValueString($lap_mate15g, "int"));
$mate15g = mysql_query($query_mate15g, $sistemacol) or die(mysql_error());
$row_mate15g = mysql_fetch_assoc($mate15g);
$totalRows_mate15g = mysql_num_rows($mate15g);
}

// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_GET['curso_id'])) {
  $colname_mate15 = $_GET['curso_id'];
}
$lap_mate15 = "-1";
if (isset($_GET['lapso'])) {
  $lap_mate15 = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
if ($confi=="bol01"){
$query_mate15 = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY a.alumno_id ORDER BY def DESC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
$query_mate15 = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY a.alumno_id ORDER BY def DESC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor01"){
$query_mate15 = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY a.alumno_id ORDER BY def DESC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor02"){
$query_mate15 = sprintf("SELECT a.cedula, a.nombre, a.apellido, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c WHERE a.alumno_id=c.alumno_id AND a.alumno_id=b.alumno_id AND c.def>0 AND b.curso_id = %s AND c.lapso= %s GROUP BY a.alumno_id ORDER BY def DESC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}


mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);


mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<body>

<center>
<table width="800"><tr>
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>

            	<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="left">
                 	<tr>
                    		<td align="left" valign="bottom" style="font-size:25px"><?php echo $row_colegio['nomcol']; ?></td>
                	</tr>
                	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  	</tr>
                  	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  	</tr>
                  </table>
		
		</td>
		</tr>
		<tr>
		<td align="center" width="800" colspan="2">
			<h1>REPORTE DE PROMEDIOS DE <?php echo $_GET['lapso']; if($_GET['lapso']==1){echo "ER";} if($_GET['lapso']==2){echo "DO";} if($_GET['lapso']==3){echo "ER";}?>  LAPSO</h1>
			<span class="texto_grande_gris">Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?></span><br />
			<span class="texto_grande_gris">Promedio General de la Secci&oacute;n: <?php echo $row_mate15g['def']; ?> Puntos</span>
		</td>
		</tr>
</table>




<table ><tr>

<?php // MATERIA 1
?> 
<td>
<table><tr><td>
<tr>
<td align="center" width="80" style="border-bottom:1px solid; border-right:1px solid;">
<b>CEDULA</b>
</td>
<td width="400" style="border-bottom:1px solid; border-right:1px solid;">
<b>APELLIDOS Y NOMBRES</b>
</td>
<td align="center" width="50" style="border-bottom:1px solid;">
<b>PROM</b>
</td>
</tr>
<?php  do { ?>
<tr>
<td align="center" style="border-right:1px solid; border-bottom:1px solid;" >
<?php echo $row_mate15['cedula']; ?>
</td>
<td  style="border-right:1px solid; border-bottom:1px solid;" >
<?php echo $row_mate15['apellido'].", ". $row_mate15['nombre']; ?>
</td>
<td  align="center" width="50" style="border-bottom:1px solid;">
<?php if($row_mate15['def']==0){ echo "NP";} if(($row_mate15['def']>0) and ($row_mate15['def']<=20)){ echo $row_mate15['def'];} ?>

</td>
</tr>
<?php } while ($row_mate15 = mysql_fetch_assoc($mate15)); ?>
</td>
</tr></table>
</td>


<?php // fin consulta
?>
 </tr></table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
</center>


</body>
</html>
<?php
mysql_free_result($asignatura);

mysql_free_result($mate15);
mysql_free_result($confip);

mysql_free_result($colegio);
mysql_free_result($lapso);

?>
