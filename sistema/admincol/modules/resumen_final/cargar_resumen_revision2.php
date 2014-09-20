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

// INSERTAR CALIFICACIONES 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$total2=$_POST["total"];

$i = 0;
$x=1;
do { 
   $i++;
if($_POST['t10'.$i]>0){
$m10=$_POST['m10'.$i];
}else{ $m10='';}

if($_POST['t11'.$i]>0){
$m11=$_POST['m11'.$i];
}else{ $m11='';}

if($_POST['t12'.$i]>0){
$m12=$_POST['m12'.$i];
}else{ $m12='';}

if($_POST['t13'.$i]>0){
$m13=$_POST['m13'.$i];
}else{ $m13='';}

if($_POST['t14'.$i]>0){
$m14=$_POST['m14'.$i];
}else{ $m14='';}




if((($_POST['m1'.$i]>0)and($_POST['m1'.$i]<21)) or (($_POST['m2'.$i]>0)and($_POST['m2'.$i]<21)) or (($_POST['m3'.$i]>0)and($_POST['m3'.$i]<21)) or (($_POST['m4'.$i]>0)and($_POST['m4'.$i]<21)) or (($_POST['m5'.$i]>0)and($_POST['m5'.$i]<21)) or (($_POST['m6'.$i]>0)and($_POST['m6'.$i]<21)) or (($_POST['m7'.$i]>0)and($_POST['m7'.$i]<21)) or (($_POST['m8'.$i]>0)and($_POST['m8'.$i]<21)) or (($_POST['m9'.$i]>0)and($_POST['m9'.$i]<21)) or (($_POST['m21'.$i]>0)and($_POST['m21'.$i]<21)) or (($_POST['m11'.$i]>0)and($_POST['m11'.$i]<21)) or (($_POST['m12'.$i]>0)and($_POST['m12'.$i]<21)) or (($_POST['m13'.$i]>0)and($_POST['m13'.$i]<21)) or (($_POST['m14'.$i]>0)and($_POST['m14'.$i]<21)) or ($_POST['m1'.$i]==98) or ($_POST['m2'.$i]==98) or ($_POST['m3'.$i]==98) or ($_POST['m4'.$i]==98) or ($_POST['m5'.$i]==98) or ($_POST['m6'.$i]==98) or ($_POST['m7'.$i]==98) or ($_POST['m8'.$i]==98) or ($_POST['m9'.$i]==98) or ($_POST['m10'.$i]==98) or ($_POST['m11'.$i]==98) or ($_POST['m12'.$i]==98) or ($_POST['m13'.$i]==98) or ($_POST['m14'.$i]==98)){ 

$no_alumno=$x;
  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen (id, alumno_id, curso_id, plan_id, no_alumno, tipo_resumen, tipo_cedula, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, m13, m14, ept1, ept2, ept3, ept4) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,  %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['alumno_id'.$i], "int"),
                       GetSQLValueString($_POST['curso_id'], "int"),
                       GetSQLValueString($_POST['plan_id'], "int"),
                       GetSQLValueString($no_alumno, "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['m1'.$i], "int"),
                       GetSQLValueString($_POST['m2'.$i], "int"),
                       GetSQLValueString($_POST['m3'.$i], "int"),
                       GetSQLValueString($_POST['m4'.$i], "int"),
                       GetSQLValueString($_POST['m5'.$i], "int"),
                       GetSQLValueString($_POST['m6'.$i], "int"),
                       GetSQLValueString($_POST['m7'.$i], "int"),
                       GetSQLValueString($_POST['m8'.$i], "int"),
                       GetSQLValueString($_POST['m9'.$i], "int"),
                       GetSQLValueString($m10, "int"),
                       GetSQLValueString($m11, "int"),
                       GetSQLValueString($m12, "int"),
                       GetSQLValueString($m13, "int"),
                       GetSQLValueString($m14, "int"),
                       GetSQLValueString($_POST['ept1'.$i], "int"),
                       GetSQLValueString($_POST['ept2'.$i], "int"),
                       GetSQLValueString($_POST['ept3'.$i], "int"),
                       GetSQLValueString($_POST['ept4'.$i], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
 $x++; }
 

} while ($i+1 <= $total2 );

header(sprintf("Location: %s", $insertGoTo));
}

// INSERTAR ASIGNATURAS EPT
 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$totalept=$_POST["totalept"];

$a = 0;
do { 
   $a++;


if($_POST['descripcion'.$a]==!NULL){

  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_ept (id, curso_id, descripcion, no, horas_clase, tipo_resumen, tipo_cedula) VALUES ( %s, %s,  %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_ept'.$a], "int"),
                       GetSQLValueString($_POST['curso_id'], "int"),
                       GetSQLValueString($_POST['descripcion'.$a], "text"),
                       GetSQLValueString($_POST['no'.$a], "int"),
                       GetSQLValueString($_POST['horas_clase'.$a], "text"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

} while ($a+1 <= $totalept );


header(sprintf("Location: %s", $insertGoTo));
}

//INSERTAR DOCENTES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$totaldocente=$_POST["totaldocente"];

$i = 0;
do { 
   $i++;

if($_POST['docente_revision'.$i]==1){
$nombre_docente=$_POST['nombre_docente'.$i];
$apellido_docente=$_POST['apellido_docente'.$i];
$cedula_docente=$_POST['cedula_docente'.$i];
}else{
$nombre_docente="****";
$apellido_docente="****";
$cedula_docente=0;
}
  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_docente (id, curso_id, tipo_resumen, tipo_cedula, nombre_mate, orden_mate, nombre_docente, apellido_docente, cedula_docente) VALUES ( %s, %s,  %s, %s, %s, %s, %s, %s, %s)",

                       GetSQLValueString($_POST['id_d'.$i], "int"),
                       GetSQLValueString($_POST['curso_id'], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['nombre_mate'.$i], "text"),
                       GetSQLValueString($_POST['orden_mate'.$i], "text"),
                       GetSQLValueString($nombre_docente, "text"),
                       GetSQLValueString($apellido_docente, "text"),
                       GetSQLValueString($cedula_docente, "bigint"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result3 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());


} while ($i+1 <= $totaldocente);


header(sprintf("Location: %s", $insertGoTo));
}

//INSERTAR DOCENTE EPT


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {



if($_POST['docente_revision_ept']==1){
$nombre_docente_ept=$_POST['nombre_docente_ept'];
$apellido_docente_ept=$_POST['apellido_docente_ept'];
$cedula_docente_ept=$_POST['cedula_docente_ept'];
}else{
$nombre_docente_ept="****";
$apellido_docente_ept="****";
$cedula_docente_ept=0;
}

  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_docente (id, curso_id, tipo_resumen, tipo_cedula, nombre_mate, orden_mate, nombre_docente, apellido_docente, cedula_docente) VALUES ( %s, %s,  %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_d_ept'], "int"),
                       GetSQLValueString($_POST['curso_id'], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['nombre_mate_ept'], "text"),
                       GetSQLValueString($_POST['orden_mate_ept'], "text"),
                       GetSQLValueString($nombre_docente_ept, "text"),
                       GetSQLValueString($apellido_docente_ept, "text"),
                       GetSQLValueString($cedula_docente_ept, "bigint"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());


header(sprintf("Location: %s", $insertGoTo));
}

//INSERTAR OBSERVACIONES


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$i = 0;
do { 
   $i++;

if($_POST['observacion'.$i]==!NULL){

  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_observaciones (id, curso_id, tipo_resumen, tipo_cedula, observacion, hoja) VALUES ( %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_observacion'.$i], "int"),
                       GetSQLValueString($_POST['curso_id'], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['observacion'.$i], "text"),
                       GetSQLValueString($_POST['hoja'.$i], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result5 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

} while ($i+1 <= $totalept);

 $insertGoTo = "cargar_resumen3.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $insertGoTo));
}

//FIN CONSULTA
mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);

//ASIGNATURAS PROFESORES
$colname_profe_mate = "-1";
if (isset($_POST['curso_id'])) {
  $colname_profe_mate = $_POST['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_profe_mate = sprintf("SELECT * FROM jos_asignatura a, jos_asignatura_nombre b, jos_docente c WHERE a.asignatura_nombre_id=b.id AND a.docente_id=c.id AND a.tipo_asignatura IS NULL AND b.condicion=1 AND a.curso_id=%s ORDER BY a.orden_asignatura ASC", GetSQLValueString($colname_profe_mate, "int"));
$profe_mate = mysql_query($query_profe_mate, $sistemacol) or die(mysql_error());
$row_profe_mate = mysql_fetch_assoc($profe_mate);
$totalRows_profe_mate = mysql_num_rows($profe_mate);

// consultas de ept
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept1 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept1 = mysql_query($query_mate_ept1, $sistemacol) or die(mysql_error());
$row_mate_ept1 = mysql_fetch_assoc($mate_ept1);
$totalRows_mate_ept1 = mysql_num_rows($mate_ept1);

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept2 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept2 = mysql_query($query_mate_ept2, $sistemacol) or die(mysql_error());
$row_mate_ept2 = mysql_fetch_assoc($mate_ept2);
$totalRows_mate_ept2 = mysql_num_rows($mate_ept2);

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept3 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept3 = mysql_query($query_mate_ept3, $sistemacol) or die(mysql_error());
$row_mate_ept3 = mysql_fetch_assoc($mate_ept3);
$totalRows_mate_ept3 = mysql_num_rows($mate_ept3);

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate_ept4 = sprintf("SELECT * FROM jos_cdc_pensum_asignaturas_ept GROUP BY nombre_asignatura_ept ORDER BY nombre_asignatura_ept ASC");
$mate_ept4 = mysql_query($query_mate_ept4, $sistemacol) or die(mysql_error());
$row_mate_ept4 = mysql_fetch_assoc($mate_ept4);
$totalRows_mate_ept4 = mysql_num_rows($mate_ept4);




$colname_asignatura = "-1";
if (isset($_POST['curso_id'])) {
  $colname_asignatura = $_POST['curso_id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id AND a.id = %s ", GetSQLValueString($colname_asignatura, "text"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

$tipo_cedula=$_POST['tipoc'];
//MATERIA 1
//nombres
$colname_mate1 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1 = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s AND a.cedula<99999999 AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
} 
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id  AND e.condicion=1 AND b.curso_id = %s AND a.cedula>99999999 AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
} 
}

//LAPSO 1
$colname_mate1l1 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1l1 = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
}else {

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
}

// DEF MATERIA 1
$colname_mate1def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}

}

// DEF MATERIA 2
$colname_mate2def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate2def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
}

// DEF MATERIA 3
$colname_mate3def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate3def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}

}


// DEF MATERIA 4
$colname_mate4def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate4def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
}


// DEF MATERIA 5
$colname_mate5def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate5def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}

}
// DEF MATERIA 6
$colname_mate6def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate6def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
}else{
if ($confi=="bol01"){

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
}


// DEF MATERIA 7
$colname_mate7def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate7def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);

$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}

}


// DEF MATERIA 8
$colname_mate8def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate8def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
}else{

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}

}


// DEF MATERIA 9
$colname_mate9def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate9def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
}

// DEF MATERIA 10
$colname_mate10def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate10def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
}
// DEF MATERIA 11
$colname_mate11def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate11def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
}else {
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
}


// DEF MATERIA 12
$colname_mate12def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate12def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
}

// DEF MATERIA 13
$colname_mate13def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate13def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
}


// AGRUPANDO EDUCACION PARA EL TRABAJO  O IPM

$colname_pensum = "-1";
if (isset($_POST['plan_id'])) {
  $colname_pensum = $_POST['plan_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_pensum = sprintf("SELECT * FROM jos_cdc_planestudio WHERE id=%s", GetSQLValueString($colname_pensum, "int"));
$pensum = mysql_query($query_pensum, $sistemacol) or die(mysql_error());
$row_pensum = mysql_fetch_assoc($pensum);
$totalRows_pensum = mysql_num_rows($pensum);
$plan=$row_pensum['cod'];

// DEF MATERIA 14
if($plan=="32011"){

$colname_mate14def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate14def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
}
}// CERRAMOS LA CONDICION DE 32011

// DEF MATERIA 14
if($plan=="31018"){

$colname_mate14def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate14def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id  AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id  AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id  AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id  AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id  AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id  AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id  AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id  AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='premilitar'  GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
}
}// CERRAMOS LA CONDICION DE 32018

// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate15 = $_POST['curso_id'];
}

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s  GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND b.status=1 AND b.status=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura IS NULL AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);


// VER EXISTENCIA DE RESUMEN
$colname_resumen = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen = $_POST['curso_id'];
}
$tr_resumen = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen = $_POST['tipor'];
}
$tc_resumen = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen = sprintf("SELECT * FROM jos_cdc_resumen WHERE curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s", GetSQLValueString($colname_resumen, "int"), GetSQLValueString($tr_resumen, "int"), GetSQLValueString($tc_resumen, "int"));
$resumen = mysql_query($query_resumen, $sistemacol) or die(mysql_error());
$row_resumen = mysql_fetch_assoc($resumen);
$totalRows_resumen = mysql_num_rows($resumen);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/form_impresion.css" rel="stylesheet" type="text/css">
<script>
function todos_ept1(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept1"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept2(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept2"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept3(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept3"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept4(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept4"){
elemento.checked = chkbox.checked
}
}
}
}
</script>

</head>
<body>
<center>
<?php if($totalRows_mate1>0){?>
<table width="900"><tr><td>
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
		<td align="center">
			
		</td>
</td></tr></table>

<?php if($totalRows_resumen==0){ ?>

<h3>Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?></h3>
<table width="900"><tr>


<?php // MATERIA 1
?> 

<form action="<?php echo $editFormAction; ?>" method="POST" name="form">

<td>

<table><tr><td>
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
NO.
</td>
<td  class="ancho_td_cedula" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
CEDULA
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
APELLIDOS
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
NOMBRES
</td>

</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
<input type="hidden" name="<?php echo 'alumno_id'.$i; ?>" value="<?php echo $row_mate1['alumno_id']; ?>" />
<input type="hidden" name="<?php echo 'cedula'.$i; ?>" value="<?php echo $row_mate1['cedula']; ?>" />
<input type="hidden" name="<?php echo 'indicador_nacionalidad'.$i; ?>" value="<?php echo $row_mate1['indicador_nacionalidad']; ?>" />
<input type="hidden" name="<?php echo 'no_alumno'.$i; ?>" value="" />
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="" />
</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
<span class="texto_pequeno_gris">&nbsp;<?php echo $row_mate1['apellido']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
<span class="texto_pequeno_gris">&nbsp;<?php echo $row_mate1['nombre']; ?></span>
</td>
</tr>
<?php $i++; $lista ++; } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</table>
</td>

<?php if($totalRows_mate1def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate1def['mate']; ?>
</td>
</tr>
<?php $i=1; do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate1def['def']>0) and ($row_mate1def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm1'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate1def['def']; ?>"/>

<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate1def = mysql_fetch_assoc($mate1def)); ?>
</table>
</td>
<?php } ?>

<?php if($totalRows_mate2def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate2def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate2def['def']>0) and ($row_mate2def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm2'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate2def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate2def = mysql_fetch_assoc($mate2def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate3def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate3def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate3def['def']>0) and ($row_mate3def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm3'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate3def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php  $i++; } while ($row_mate3def = mysql_fetch_assoc($mate3def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate4def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate4def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate4def['def']>0) and ($row_mate4def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm4'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate4def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate4def = mysql_fetch_assoc($mate4def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate5def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate5def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate5def['def']>0) and ($row_mate5def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm5'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate5def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate5def = mysql_fetch_assoc($mate5def)); ?>
</table>
</td>
<?php  } ?>


<?php if($totalRows_mate6def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
<?php echo $row_mate6def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate6def['def']>0) and ($row_mate6def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm6'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate6def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate6def = mysql_fetch_assoc($mate6def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate7def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate7def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate7def['def']>0) and ($row_mate7def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm7'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate7def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate7def = mysql_fetch_assoc($mate7def)); ?>
</table>
</td>
<?php }?>


<?php if($totalRows_mate8def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate8def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate8def['def']>0) and ($row_mate8def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm8'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate8def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate8def = mysql_fetch_assoc($mate8def)); ?>
</table>
</td>
<?php } ?>


<?php if($totalRows_mate9def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate9def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<?php if(($row_mate9def['def']>0) and ($row_mate9def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm9'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate9def['def']; ?>"/>
<?php } ?>
</td>

</tr>
<?php $i++; } while ($row_mate9def = mysql_fetch_assoc($mate9def)); ?>
</table>
</td>
<?php  } ?>


<?php if($totalRows_mate10def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate10def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate10def['def']>0) and ($row_mate10def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm10'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate10def['def']; ?>"/>
<?php } ?>
<input type="hidden"  name="<?php echo 't10'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate10def; ?>"/>

</td>

</tr>
<?php $i++; } while ($row_mate10def = mysql_fetch_assoc($mate10def)); ?>
</table>
</td>
<?php  } ?>


<?php if($totalRows_mate11def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate11def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate11def['def']>0) and ($row_mate11def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm11'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate11def['def']; ?>"/>
<?php } ?>
<input type="hidden"  name="<?php echo 't11'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate11def; ?>"/>

</td>



</tr>
<?php  $i++; } while ($row_mate11def = mysql_fetch_assoc($mate11def)); ?>
</table>
</td>
<?php }?>



<?php if($totalRows_mate12def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_mate12def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate12def['def']>0) and ($row_mate12def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm12'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate12def['def']; ?>"/>
<?php } ?>
<input type="hidden"  name="<?php echo 't12'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate12def; ?>"/>

</td>

</tr>
<?php $i++; } while ($row_mate12def = mysql_fetch_assoc($mate12def)); ?>
</table>
</td>
<?php } ?>

<?php if($totalRows_mate13def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
<?php echo $row_mate13def['mate']; ?>
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate13def['def']>0) and ($row_mate13def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm13'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate13def['def']; ?>"/>
<?php } ?>
<input type="hidden"  name="<?php echo 't13'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate13def; ?>"/>

</td>

</tr>
<?php $i++; } while ($row_mate13def = mysql_fetch_assoc($mate13def)); ?>
</table>
</td>
<?php } ?>



<?php if($totalRows_mate14def>0){?>
<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
ET
</td>
</tr>
<?php $i=1;  do { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<?php if(($row_mate14def['def']>0) and ($row_mate14def['def']<10)){ ?>
<input type="text"  size="2" name="<?php echo 'm14'.$i; ?>" class="texto_pequeno_gris" value="<?php echo '0'.$row_mate14def['def']; ?>"/>
<?php } ?>
<input type="hidden"  name="<?php echo 't14'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate14def; ?>"/>

</td>

</tr>
<?php $i++; } while ($row_mate14def = mysql_fetch_assoc($mate14def)); ?>
</table>
</td>
<?php } ?>


<td>

<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
ET1<br />
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="ept1_t" id="ept1_t">
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
ET2<br />
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="ept2_t" id="ept2_t">
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
ET3<br />
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="ept3_t" id="ept3_t">
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
ET4<br />
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="ept4_t" id="ept4_t">
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
</tr>
<?php $i=1; do  { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold" name="<?php echo 'ept1'.$i; ?>" id="<?php echo 'ept1'.$i; ?>">
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2">-</span></option>
                	</select>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold" name="<?php echo 'ept2'.$i; ?>" id="<?php echo 'ept2'.$i; ?>">
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="<?php echo 'ept3'.$i; ?>" id="<?php echo 'ept3'.$i; ?>">
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="<?php echo 'ept4'.$i; ?>" id="<?php echo 'ept4'.$i; ?>">
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>



</tr>
<?php $i++; } while ($row_mate1l1 = mysql_fetch_assoc($mate1l1)); ?>
</table>

		<input type="hidden" name="total"  id="total" value="<?php echo $totalRows_mate1;?>" >
		<input type="hidden" name="curso_id" value="<?php echo $_POST['curso_id'];?>">
		<input type="hidden" name="tipo_resumen" value="<?php echo $_POST['tipor'];?>">
		<input type="hidden" name="tipo_cedula" value="<?php echo $_POST['tipoc'];?>">
		<input type="hidden" name="plan_id" value="<?php echo $_POST['plan_id'];?>">





</td>
</tr>
<tr><td colspan="17">

<center>

<h3>LISTADO DE DOCENTES RESUMEN</h3>
<table border="1" style="font-size:8pt;">
<tr style="background-color:#fffccc;" height="25" >
	<td width="150" align="center"><b>Asignatura</b></td>
	<td width="150" align="center"><b>Nombre de Docente</b></td>
	<td width="150" align="center"><b>Apellido del Docente</b></td>
	<td width="100" align="center"><b>Cedula</b></td>
	<td width="100" align="center"><b>Docentes con <br />Revisi&oacute;n</b></td>
</tr>
	<?php $i=1; do { ?>
<tr height="25">
	<td align="center"><?php echo $row_profe_mate['nombre'];?>
	<input type="hidden" size="20"  name="<?php echo 'nombre_mate'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['nombre']; ?>"/>
	<input type="hidden" size="20"  name="<?php echo 'id_d'.$i; ?>" class="texto_pequeno_gris" value=""/>
	<input type="hidden" size="20"  name="<?php echo 'orden_mate'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $i; ?>"/>
	</td>
	<td align="center"><input type="text" size="20"  name="<?php echo 'nombre_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['nombre_docente'] ?>"/></td>
	<td align="center"> <input type="text" size="20"  name="<?php echo 'apellido_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['apellido_docente']; ?>"/></td>
	<td align="center"><input type="text" size="20"  name="<?php echo 'cedula_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['cedula_docente'] ?>"/></td>
	<td align="center"> <input type="checkbox" name="<?php echo 'docente_revision'.$i; ?>" class="texto_pequeno_gris" value="1"/></td>
</tr>
	<?php $i++;  } while ($row_profe_mate = mysql_fetch_assoc($profe_mate)); ?>

		<input type="hidden" name="totaldocente"  id="totaldocente" value="<?php echo $totalRows_profe_mate;?>" />
<tr>
<td align="center"><?php if($plan=="32011"){ ?> EDUCACI&Oacute;N PARA EL TRABAJO<?php } ?><?php if($plan=="31018"){ ?> INSTRUCCION PREMILITAR<?php } ?></td>
	<?php if($plan=="32011"){ ?>	
	<input type="hidden"  name="nombre_mate_ept" class="texto_pequeno_gris" value="EDUC. PARA EL TRABAJO"/>
	<?php } ?><?php if($plan=="31018"){ ?>
		<input type="hidden"  name="nombre_mate_ept" class="texto_pequeno_gris" value="INSTRUCCION PREMILITAR"/>
		<?php } ?>
	<input type="hidden"  name="id_d_ept" class="texto_pequeno_gris" value=""/>
	<input type="hidden"  name="orden_mate_ept" class="texto_pequeno_gris" value="<?php $orden=$totalRows_profe_mate+1; echo $orden;?>"/>
	<td align="center"><input type="text" size="20"  name="apellido_docente_ept" class="texto_pequeno_gris" value=""/></td>
	<td align="center"><input type="text" size="20"  name="nombre_docente_ept" class="texto_pequeno_gris" value=""/></td>
	<td align="center"><input type="text" size="20"  name="cedula_docente_ept" class="texto_pequeno_gris" value=""/></td>
	<td align="center"> <input type="checkbox" name="docente_revision_ept" class="texto_pequeno_gris" value="1"/></td>
</tr>
</table>

<h3>PROGRAMAS DE EDUCACION PARA EL TRABAJO</h3>
<table>
<tr height="25" bgcolor="green">

	<td align="center" colspan="2" width="300" style="font-size:12px; color:#fff;">Cargar Programas de EPT</td>

</tr>
<tr>
  <td align="center" class="texto_mediano_gris">Asignaturas</td>
  <td align="center" class="texto_mediano_gris">Horas/clase</td>
</tr>
<?php $i=1;
do { ?>


<tr  bgcolor="#<?php if ($i%2==0) { // si es par
         echo 'fff';
    } else { // si es impar
        echo 'fffccc';

    } ?>"  height="25">


   <td align="center">
	<input type="hidden" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $i;?>">

 <?php if ($i==1) { ?>
	<select name="<?php echo 'descripcion'.$i;?>" id="<?php echo 'descripcion'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_mate_ept1['nombre_asignatura_ept']; ?>"><?php echo $row_mate_ept1['nombre_asignatura_ept']; ?></option>
	<?php } while ($row_mate_ept1 = mysql_fetch_assoc($mate_ept1)); ?>
	</select>
 <?php } ?>

 <?php if ($i==2) { ?>
	<select name="<?php echo 'descripcion'.$i;?>" id="<?php echo 'descripcion'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_mate_ept2['nombre_asignatura_ept']; ?>"><?php echo $row_mate_ept2['nombre_asignatura_ept']; ?></option>
	<?php } while ($row_mate_ept2 = mysql_fetch_assoc($mate_ept2)); ?>
	</select>
 <?php } ?>

 <?php if ($i==3) { ?>
	<select name="<?php echo 'descripcion'.$i;?>" id="<?php echo 'descripcion'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_mate_ept3['nombre_asignatura_ept']; ?>"><?php echo $row_mate_ept3['nombre_asignatura_ept']; ?></option>
	<?php } while ($row_mate_ept3 = mysql_fetch_assoc($mate_ept3)); ?>
	</select>
 <?php } ?>

 <?php if ($i==4) { ?>
	<select name="<?php echo 'descripcion'.$i;?>" id="<?php echo 'descripcion'.$i;?>">
	<option value="">*** Vacio ***</option>
	<?php
	do { ?>

	<option value="<?php echo $row_mate_ept4['nombre_asignatura_ept']; ?>"><?php echo $row_mate_ept4['nombre_asignatura_ept']; ?></option>
	<?php } while ($row_mate_ept4 = mysql_fetch_assoc($mate_ept4)); ?>
	</select>
 <?php } ?>

   </td>
 	<td align="center">
	<input type="text" size="3" name="<?php echo 'horas_clase'.$i;?>" id="<?php echo 'horas_clase'.$i;?>" value="">
	</td>
		<input type="hidden" name="totalept"  id="totalept" value="4" >
		<input type="hidden" name="<?php echo 'id_ept'.$i;?>" value="" >

</tr>
<?php  $i++;
} while($i<=4); ?>
</table>

<h3>AGREGAR OBSERVACIONES</h3>
<table>
<?php $i=1; do { ?>
<tr><td>
<span class="texto_mediano_gris">Observaciones para la Hoja #<?php echo $i; ?></span>
</td></tr>
<tr><td>
<TEXTAREA COLS=100 ROWS=10 NAME="<?php echo 'observacion'.$i; ?>"></TEXTAREA> 
<input type="hidden" name="<?php echo 'id_observacion'.$i; ?>" value="" >
<input type="hidden" name="<?php echo 'hoja'.$i; ?>" value="<?php echo $i; ?>" >
</td></tr>
<?php  $i++;
} while($i<=4); ?>
</table>
<br />
<br />
<br />
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar Resumen" style="font-size:16px;"/>
</td>
	<input type="hidden" name="MM_insert" value="form">
	</form>
<br />
<br />
</center>

<?php // fin consulta

} else {
?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png" /><br /><br />
<span class="texto_grande_gris" >YA SE CARGO EL RESUMEN PARA ESTA SECCION</span>
</center>
<br />
<br />
<?php } ?>
 </tr></table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>



<?php } else { ?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png" /><br /><br />
<span class="texto_grande_gris" >NO EXISTEN ESTUDIANTES CON ESTE TIPO DE CEDULA O <br /> NO HAY ESTUDIANTES REGISTRADOS EN ESTA SECCION </span>
</center>

<?php } ?>
</center>
</body>
</html>
<?php
mysql_free_result($asignatura);
mysql_free_result($confip);
mysql_free_result($mate1);

mysql_free_result($mate15);

mysql_free_result($colegio);
mysql_free_result($resumen);

?>
