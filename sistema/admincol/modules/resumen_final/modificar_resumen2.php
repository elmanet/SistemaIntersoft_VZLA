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

// MODIFICAR CALIFICACIONES 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {

$total2=$_POST["total"];

$i = 0;
do { 
   $i++;





if($_POST['p'.$i]==1){
	if($_POST['m1'.$i]!=""){$m1=99;}
	if($_POST['m2'.$i]!=""){$m2=99;}
	if($_POST['m3'.$i]!=""){$m3=99;}
	if($_POST['m4'.$i]!=""){$m4=99;}
	if($_POST['m5'.$i]!=""){$m5=99;}
	if($_POST['m6'.$i]!=""){$m6=99;}
	if($_POST['m7'.$i]!=""){$m7=99;}
	if($_POST['m8'.$i]!=""){$m8=99;}
	if($_POST['m9'.$i]!=""){$m9=99;}

if($_POST['t10'.$i]>0){
$m10=99;
}else{ $m10='';}

if($_POST['t11'.$i]>0){
$m11=99;
}else{ $m11='';}

if($_POST['t12'.$i]>0){
$m12=99;
}else{ $m12='';}

if($_POST['t13'.$i]>0){
$m13=99;
}else{ $m13='';}

if($_POST['t14'.$i]>0){
$m14=99;
}else{ $m14='';}


}else{
$m1=$_POST['m1'.$i];
$m2=$_POST['m2'.$i];
$m3=$_POST['m3'.$i];
$m4=$_POST['m4'.$i];
$m5=$_POST['m5'.$i];
$m6=$_POST['m6'.$i];
$m7=$_POST['m7'.$i];
$m8=$_POST['m8'.$i];
$m9=$_POST['m9'.$i];

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
}


  $updateSQL = sprintf("UPDATE jos_cdc_resumen SET no_alumno=%s, m1=%s, m2=%s, m3=%s, m4=%s, m5=%s, m6=%s, m7=%s, m8=%s, m9=%s, m10=%s, m11=%s, m12=%s, m13=%s, m14=%s, ept1=%s, ept2=%s, ept3=%s, ept4=%s WHERE id=%s",
							  GetSQLValueString($_POST['no_alumno'.$i], "int"),                       
                       GetSQLValueString($m1, "int"),
                       GetSQLValueString($m2, "int"),
                       GetSQLValueString($m3, "int"),
                       GetSQLValueString($m4, "int"),
                       GetSQLValueString($m5, "int"),
                       GetSQLValueString($m6, "int"),
                       GetSQLValueString($m7, "int"),
                       GetSQLValueString($m8, "int"),
                       GetSQLValueString($m9, "int"),
                       GetSQLValueString($m10, "int"),
                       GetSQLValueString($m11, "int"),
                       GetSQLValueString($m12, "int"),
                       GetSQLValueString($m13, "int"),
                       GetSQLValueString($m14, "int"),
                       GetSQLValueString($_POST['ept1'.$i], "int"),
                       GetSQLValueString($_POST['ept2'.$i], "int"),
                       GetSQLValueString($_POST['ept3'.$i], "int"),
                       GetSQLValueString($_POST['ept4'.$i], "int"),
                       GetSQLValueString($_POST['id'.$i], "bigint"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

 

} while ($i+1 <= $total2 );

header(sprintf("Location: %s", $updateGoTo));
}
/*
// INSERTAR ASIGNATURAS EPT
 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {

$totalept=$_POST["totalept"];

$a = 0;
do { 
   $a++;


if($_POST['descripcion'.$a]==!NULL){

  $updateSQL = sprintf("UPDATE jos_cdc_resumen_ept SET descripcion=%s, no=%s, horas_clase=%s WHERE id=%s",

                       GetSQLValueString($_POST['descripcion'.$a], "text"),
                       GetSQLValueString($_POST['no'.$a], "int"),
                       GetSQLValueString($_POST['horas_clase'.$a], "text"),
                       GetSQLValueString($_POST['id_ept'.$a], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());
}

} while ($a+1 <= $totalept );


header(sprintf("Location: %s", $updateGoTo));
}
*/
//INSERTAR DOCENTES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {

$totaldocente=$_POST["totaldocente"];

$i = 0;
do { 
   $i++;


  $updateSQL = sprintf("UPDATE jos_cdc_resumen_docente SET nombre_mate=%s, orden_mate=%s, nombre_docente=%s, apellido_docente=%s, cedula_docente=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre_mate'.$i], "text"),
                       GetSQLValueString($_POST['orden_mate'.$i], "text"),
                       GetSQLValueString($_POST['nombre_docente'.$i], "text"),
                       GetSQLValueString($_POST['apellido_docente'.$i], "text"),
                       GetSQLValueString($_POST['cedula_docente'.$i], "bigint"),
                       GetSQLValueString($_POST['id_d'.$i], "bigint"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result3 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());


} while ($i+1 <= $totaldocente);


header(sprintf("Location: %s", $updateGoTo));
}


//INSERTAR OBSERVACIONES
$total_observa=$_POST['totalobserva'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {


$i = 0;
do { 
   $i++;

if($_POST['observacion'.$i]==!NULL){

  $updateSQL = sprintf("UPDATE jos_cdc_resumen_observaciones SET observacion=%s, hoja=%s WHERE id=%s",
                       GetSQLValueString($_POST['observacion'.$i], "text"),
                       GetSQLValueString($_POST['hoja'.$i], "int"),
                       GetSQLValueString($_POST['id_observacion'.$i], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result5 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());
}

} while ($i+1 <= $total_observa);


 $updateGoTo = "cargar_resumen3.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $updateGoTo));
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
$tr_profe_mate = "-1";
if (isset($_POST['tipor'])) {
  $tr_profe_mate = $_POST['tipor'];
}
$tc_profe_mate = "-1";
if (isset($_POST['tipoc'])) {
  $tc_profe_mate = $_POST['tipoc'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_profe_mate = sprintf("SELECT * FROM jos_cdc_resumen_docente WHERE curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s ORDER BY orden_mate ASC", GetSQLValueString($colname_profe_mate, "int"), GetSQLValueString($tr_profe_mate, "int"), GetSQLValueString($tc_profe_mate, "int"));
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
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s AND a.cedula<99999999 AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
} 
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id  AND e.condicion=1 AND b.curso_id = %s AND a.cedula>99999999 AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
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
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
}else {

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
$mate1l1 = mysql_query($query_mate1l1, $sistemacol) or die(mysql_error());
$row_mate1l1 = mysql_fetch_assoc($mate1l1);
$totalRows_mate1l1 = mysql_num_rows($mate1l1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1l1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido,  c.def, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s  AND c.lapso=1 AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1l1, "text"));
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
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
$mate1def = mysql_query($query_mate1def, $sistemacol) or die(mysql_error());
$row_mate1def = mysql_fetch_assoc($mate1def);
$totalRows_mate1def = mysql_num_rows($mate1def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=1 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1def, "text"));
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
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
$mate2def = mysql_query($query_mate2def, $sistemacol) or die(mysql_error());
$row_mate2def = mysql_fetch_assoc($mate2def);
$totalRows_mate2def = mysql_num_rows($mate2def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate2def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=2 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate2def, "text"));
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
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
$mate3def = mysql_query($query_mate3def, $sistemacol) or die(mysql_error());
$row_mate3def = mysql_fetch_assoc($mate3def);
$totalRows_mate3def = mysql_num_rows($mate3def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate3def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=3 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate3def, "text"));
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
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);

$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
$mate4def = mysql_query($query_mate4def, $sistemacol) or die(mysql_error());
$row_mate4def = mysql_fetch_assoc($mate4def);
$totalRows_mate4def = mysql_num_rows($mate4def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate4def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=4 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate4def, "text"));
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
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
$mate5def = mysql_query($query_mate5def, $sistemacol) or die(mysql_error());
$row_mate5def = mysql_fetch_assoc($mate5def);
$totalRows_mate5def = mysql_num_rows($mate5def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate5def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=5 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate5def, "text"));
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
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
}else{
if ($confi=="bol01"){

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
$mate6def = mysql_query($query_mate6def, $sistemacol) or die(mysql_error());
$row_mate6def = mysql_fetch_assoc($mate6def);
$totalRows_mate6def = mysql_num_rows($mate6def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate6def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=6 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate6def, "text"));
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
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);

$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1  AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
$mate7def = mysql_query($query_mate7def, $sistemacol) or die(mysql_error());
$row_mate7def = mysql_fetch_assoc($mate7def);
$totalRows_mate7def = mysql_num_rows($mate7def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate7def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=7 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate7def, "text"));
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
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
}else{

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
$mate8def = mysql_query($query_mate8def, $sistemacol) or die(mysql_error());
$row_mate8def = mysql_fetch_assoc($mate8def);
$totalRows_mate8def = mysql_num_rows($mate8def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate8def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=8 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate8def, "text"));
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
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999  AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999  AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
$mate9def = mysql_query($query_mate9def, $sistemacol) or die(mysql_error());
$row_mate9def = mysql_fetch_assoc($mate9def);
$totalRows_mate9def = mysql_num_rows($mate9def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate9def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=9 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate9def, "text"));
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
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
$mate10def = mysql_query($query_mate10def, $sistemacol) or die(mysql_error());
$row_mate10def = mysql_fetch_assoc($mate10def);
$totalRows_mate10def = mysql_num_rows($mate10def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate10def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=10 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate10def, "text"));
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
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
}else {
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
$mate11def = mysql_query($query_mate11def, $sistemacol) or die(mysql_error());
$row_mate11def = mysql_fetch_assoc($mate11def);
$totalRows_mate11def = mysql_num_rows($mate11def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate11def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=11 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate11def, "text"));
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
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
$mate12def = mysql_query($query_mate12def, $sistemacol) or die(mysql_error());
$row_mate12def = mysql_fetch_assoc($mate12def);
$totalRows_mate12def = mysql_num_rows($mate12def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate12def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=12 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate12def, "text"));
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
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate13def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.orden_asignatura=13 GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate13def, "text"));
$mate13def = mysql_query($query_mate13def, $sistemacol) or die(mysql_error());
$row_mate13def = mysql_fetch_assoc($mate13def);
$totalRows_mate13def = mysql_num_rows($mate13def);
}
}


// AGRUPANDO EDUCACION PARA EL TRABAJO


// DEF MATERIA 14
$colname_mate14def = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate14def = $_POST['curso_id'];
}

$confi=$row_confip['codfor'];
if ($tipo_cedula==1){
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula<99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1  AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate14def = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),0) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id  AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND a.cedula>99999999 AND b.curso_id = %s AND d.tipo_asignatura='educacion_trabajo' GROUP BY a.alumno_id  ORDER BY a.cedula ASC", GetSQLValueString($colname_mate14def, "text"));
$mate14def = mysql_query($query_mate14def, $sistemacol) or die(mysql_error());
$row_mate14def = mysql_fetch_assoc($mate14def);
$totalRows_mate14def = mysql_num_rows($mate14def);
}
}


// PROMEDIO DE LAPSO
$colname_mate15 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate15 = $_POST['curso_id'];
}

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s  GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_bol02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor01 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
$mate15 = mysql_query($query_mate15, $sistemacol) or die(mysql_error());
$row_mate15 = mysql_fetch_assoc($mate15);
$totalRows_mate15 = mysql_num_rows($mate15);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate15 = sprintf("SELECT a.nombre, a.apellido, d.tipo_asignatura, e.iniciales as mate, e.nombre as nombre_mate, ROUND(AVG(c.def),2) as def FROM jos_alumno_info a, jos_alumno_curso b, jos_formato_evaluacion_nor02 c, jos_asignatura d, jos_asignatura_nombre e WHERE a.alumno_id=c.alumno_id AND a.cursando=1 AND a.alumno_id=b.alumno_id AND c.asignatura_id=d.id AND d.tipo_asignatura='' AND d.asignatura_nombre_id=e.id AND e.condicion=1 AND b.curso_id = %s GROUP BY a.alumno_id ORDER BY a.cedula ASC", GetSQLValueString($colname_mate15, "text"), GetSQLValueString($lap_mate15, "int"));
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

// VER ESTUDIANTES
$colname_resumen_estudiante = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_estudiante = $_POST['curso_id'];
}
$tr_resumen_estudiante = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_estudiante = $_POST['tipor'];
}
$tc_resumen_estudiante = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_estudiante = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_estudiante = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_estudiante, "int"), GetSQLValueString($tr_resumen_estudiante, "int"), GetSQLValueString($tc_resumen_estudiante, "int"));
$resumen_estudiante = mysql_query($query_resumen_estudiante, $sistemacol) or die(mysql_error());
$row_resumen_estudiante = mysql_fetch_assoc($resumen_estudiante);
$totalRows_resumen_estudiante = mysql_num_rows($resumen_estudiante);


//m1
$colname_resumen_m1 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m1 = $_POST['curso_id'];
}
$tr_resumen_m1 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m1 = $_POST['tipor'];
}
$tc_resumen_m1 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m1 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m1 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m1, "int"), GetSQLValueString($tr_resumen_m1, "int"), GetSQLValueString($tc_resumen_m1, "int"));
$resumen_m1 = mysql_query($query_resumen_m1, $sistemacol) or die(mysql_error());
$row_resumen_m1 = mysql_fetch_assoc($resumen_m1);
$totalRows_resumen_m1 = mysql_num_rows($resumen_m1);

//m2
$colname_resumen_m2 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m2 = $_POST['curso_id'];
}
$tr_resumen_m2 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m2 = $_POST['tipor'];
}
$tc_resumen_m2 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m2 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m2 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m2, "int"), GetSQLValueString($tr_resumen_m2, "int"), GetSQLValueString($tc_resumen_m2, "int"));
$resumen_m2 = mysql_query($query_resumen_m2, $sistemacol) or die(mysql_error());
$row_resumen_m2 = mysql_fetch_assoc($resumen_m2);
$totalRows_resumen_m2 = mysql_num_rows($resumen_m2);

//m3
$colname_resumen_m3 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m3 = $_POST['curso_id'];
}
$tr_resumen_m3 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m3 = $_POST['tipor'];
}
$tc_resumen_m3 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m3 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m3 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m3, "int"), GetSQLValueString($tr_resumen_m3, "int"), GetSQLValueString($tc_resumen_m3, "int"));
$resumen_m3 = mysql_query($query_resumen_m3, $sistemacol) or die(mysql_error());
$row_resumen_m3 = mysql_fetch_assoc($resumen_m3);
$totalRows_resumen_m3 = mysql_num_rows($resumen_m3);

//m4
$colname_resumen_m4 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m4 = $_POST['curso_id'];
}
$tr_resumen_m4 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m4 = $_POST['tipor'];
}
$tc_resumen_m4 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m4 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m4 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m4, "int"), GetSQLValueString($tr_resumen_m4, "int"), GetSQLValueString($tc_resumen_m4, "int"));
$resumen_m4 = mysql_query($query_resumen_m4, $sistemacol) or die(mysql_error());
$row_resumen_m4 = mysql_fetch_assoc($resumen_m4);
$totalRows_resumen_m4 = mysql_num_rows($resumen_m4);

//m5
$colname_resumen_m5 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m5 = $_POST['curso_id'];
}
$tr_resumen_m5 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m5 = $_POST['tipor'];
}
$tc_resumen_m5 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m5 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m5 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m5, "int"), GetSQLValueString($tr_resumen_m5, "int"), GetSQLValueString($tc_resumen_m5, "int"));
$resumen_m5 = mysql_query($query_resumen_m5, $sistemacol) or die(mysql_error());
$row_resumen_m5 = mysql_fetch_assoc($resumen_m5);
$totalRows_resumen_m5 = mysql_num_rows($resumen_m5);

//m6
$colname_resumen_m6 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m6 = $_POST['curso_id'];
}
$tr_resumen_m6 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m6 = $_POST['tipor'];
}
$tc_resumen_m6 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m6 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m6 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m6, "int"), GetSQLValueString($tr_resumen_m6, "int"), GetSQLValueString($tc_resumen_m6, "int"));
$resumen_m6 = mysql_query($query_resumen_m6, $sistemacol) or die(mysql_error());
$row_resumen_m6 = mysql_fetch_assoc($resumen_m6);
$totalRows_resumen_m6 = mysql_num_rows($resumen_m6);

//m7
$colname_resumen_m7 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m7 = $_POST['curso_id'];
}
$tr_resumen_m7 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m7 = $_POST['tipor'];
}
$tc_resumen_m7 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m7 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m7 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m7, "int"), GetSQLValueString($tr_resumen_m7, "int"), GetSQLValueString($tc_resumen_m7, "int"));
$resumen_m7 = mysql_query($query_resumen_m7, $sistemacol) or die(mysql_error());
$row_resumen_m7 = mysql_fetch_assoc($resumen_m7);
$totalRows_resumen_m7 = mysql_num_rows($resumen_m7);

//m8
$colname_resumen_m8 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m8 = $_POST['curso_id'];
}
$tr_resumen_m8 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m8 = $_POST['tipor'];
}
$tc_resumen_m8 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m8 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m8 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m8, "int"), GetSQLValueString($tr_resumen_m8, "int"), GetSQLValueString($tc_resumen_m8, "int"));
$resumen_m8 = mysql_query($query_resumen_m8, $sistemacol) or die(mysql_error());
$row_resumen_m8 = mysql_fetch_assoc($resumen_m8);
$totalRows_resumen_m8 = mysql_num_rows($resumen_m8);

//m9
$colname_resumen_m9 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m9 = $_POST['curso_id'];
}
$tr_resumen_m9 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m9 = $_POST['tipor'];
}
$tc_resumen_m9 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m9 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m9 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m9, "int"), GetSQLValueString($tr_resumen_m9, "int"), GetSQLValueString($tc_resumen_m9, "int"));
$resumen_m9 = mysql_query($query_resumen_m9, $sistemacol) or die(mysql_error());
$row_resumen_m9 = mysql_fetch_assoc($resumen_m9);
$totalRows_resumen_m9 = mysql_num_rows($resumen_m9);

//m10
$colname_resumen_m10 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m10 = $_POST['curso_id'];
}
$tr_resumen_m10 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m10 = $_POST['tipor'];
}
$tc_resumen_m10 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m10 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m10 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m10, "int"), GetSQLValueString($tr_resumen_m10, "int"), GetSQLValueString($tc_resumen_m10, "int"));
$resumen_m10 = mysql_query($query_resumen_m10, $sistemacol) or die(mysql_error());
$row_resumen_m10 = mysql_fetch_assoc($resumen_m10);
$totalRows_resumen_m10 = mysql_num_rows($resumen_m10);

//m11
$colname_resumen_m11 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m11 = $_POST['curso_id'];
}
$tr_resumen_m11 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m11 = $_POST['tipor'];
}
$tc_resumen_m11 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m11 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m11 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m11, "int"), GetSQLValueString($tr_resumen_m11, "int"), GetSQLValueString($tc_resumen_m11, "int"));
$resumen_m11 = mysql_query($query_resumen_m11, $sistemacol) or die(mysql_error());
$row_resumen_m11 = mysql_fetch_assoc($resumen_m11);
$totalRows_resumen_m11 = mysql_num_rows($resumen_m11);

//m12
$colname_resumen_m12 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m12 = $_POST['curso_id'];
}
$tr_resumen_m12 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m12 = $_POST['tipor'];
}
$tc_resumen_m12 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m12 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m12 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m12, "int"), GetSQLValueString($tr_resumen_m12, "int"), GetSQLValueString($tc_resumen_m12, "int"));
$resumen_m12 = mysql_query($query_resumen_m12, $sistemacol) or die(mysql_error());
$row_resumen_m12 = mysql_fetch_assoc($resumen_m12);
$totalRows_resumen_m12 = mysql_num_rows($resumen_m12);

//m13
$colname_resumen_m13 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m13 = $_POST['curso_id'];
}
$tr_resumen_m13 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m13 = $_POST['tipor'];
}
$tc_resumen_m13 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m13 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m13 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m13, "int"), GetSQLValueString($tr_resumen_m13, "int"), GetSQLValueString($tc_resumen_m13, "int"));
$resumen_m13 = mysql_query($query_resumen_m13, $sistemacol) or die(mysql_error());
$row_resumen_m13 = mysql_fetch_assoc($resumen_m13);
$totalRows_resumen_m13 = mysql_num_rows($resumen_m13);

//m14
$colname_resumen_m14 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_m14 = $_POST['curso_id'];
}
$tr_resumen_m14 = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_m14 = $_POST['tipor'];
}
$tc_resumen_m14 = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_m14 = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_m14 = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_m14, "int"), GetSQLValueString($tr_resumen_m14, "int"), GetSQLValueString($tc_resumen_m14, "int"));
$resumen_m14 = mysql_query($query_resumen_m14, $sistemacol) or die(mysql_error());
$row_resumen_m14 = mysql_fetch_assoc($resumen_m14);
$totalRows_resumen_m14 = mysql_num_rows($resumen_m14);

//ept
$colname_resumen_ept = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_ept = $_POST['curso_id'];
}
$tr_resumen_ept = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_ept = $_POST['tipor'];
}
$tc_resumen_ept = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_ept = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_ept = sprintf("SELECT * FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.curso_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen_ept, "int"), GetSQLValueString($tr_resumen_ept, "int"), GetSQLValueString($tc_resumen_ept, "int"));
$resumen_ept = mysql_query($query_resumen_ept, $sistemacol) or die(mysql_error());
$row_resumen_ept = mysql_fetch_assoc($resumen_ept);
$totalRows_resumen_ept = mysql_num_rows($resumen_ept);


//mateept
$colname_resumen_mateept = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_mateept = $_POST['curso_id'];
}
$tr_resumen_mateept = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_mateept = $_POST['tipor'];
}
$tc_resumen_mateept = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_mateept = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_mateept = sprintf("SELECT * FROM jos_cdc_resumen_ept WHERE curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s", GetSQLValueString($colname_resumen_mateept, "int"), GetSQLValueString($tr_resumen_mateept, "int"), GetSQLValueString($tc_resumen_mateept, "int"));
$resumen_mateept = mysql_query($query_resumen_mateept, $sistemacol) or die(mysql_error());
$row_resumen_mateept = mysql_fetch_assoc($resumen_mateept);
$totalRows_resumen_mateept = mysql_num_rows($resumen_mateept);

//observa
$colname_resumen_observa = "-1";
if (isset($_POST['curso_id'])) {
  $colname_resumen_observa = $_POST['curso_id'];
}
$tr_resumen_observa = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen_observa = $_POST['tipor'];
}
$tc_resumen_observa = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen_observa = $_POST['tipoc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen_observa = sprintf("SELECT * FROM jos_cdc_resumen_observaciones WHERE curso_id=%s AND tipo_resumen=%s AND tipo_cedula=%s", GetSQLValueString($colname_resumen_observa, "int"), GetSQLValueString($tr_resumen_observa, "int"), GetSQLValueString($tc_resumen_observa, "int"));
$resumen_observa = mysql_query($query_resumen_observa, $sistemacol) or die(mysql_error());
$row_resumen_observa = mysql_fetch_assoc($resumen_observa);
$totalRows_resumen_observa = mysql_num_rows($resumen_observa);



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
var elemento = document.forms[0].elements[i]type="text" ;
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
<table width="1150"><tr><td>
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

<?php if($totalRows_resumen>0){ ?>

<h3>Modificar Resumen de Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?></h3>
<table width="1150"><tr>


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
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
ORDEN
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
PE
</td>
</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>

</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_resumen_estudiante['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<span class="texto_pequeno_gris"><?php echo $row_resumen_estudiante['apellido']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<span class="texto_pequeno_gris"><?php echo $row_resumen_estudiante['nombre']; ?></span>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="text" name="<?php echo 'no_alumno'.$i; ?>" class="texto_pequeno_gris" size="2" value="<?php echo $lista; ?>"/>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
<input type="checkbox" name="<?php echo 'p'.$i; ?>" class="texto_pequeno_gris" value="1"/>
</td>
</tr>
<?php $i++; $lista ++; } while ($row_resumen_estudiante = mysql_fetch_assoc($resumen_estudiante)); ?>
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
<input type="text" size="2"  name="<?php echo 'm1'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m1['m1']; ?>"/>
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="<?php echo $row_resumen_m1['id']; ?>" />
</td>

</tr>
<?php $i++; } while ($row_resumen_m1 = mysql_fetch_assoc($resumen_m1)); ?>
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
<input type="text" size="2"  name="<?php echo 'm2'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m2['m2']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m2 = mysql_fetch_assoc($resumen_m2)); ?>
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
<input type="text" size="2"  name="<?php echo 'm3'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m3['m3']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m3 = mysql_fetch_assoc($resumen_m3)); ?>
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
<input type="text" size="2"  name="<?php echo 'm4'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m4['m4']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m4 = mysql_fetch_assoc($resumen_m4)); ?>
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
<input type="text" size="2"  name="<?php echo 'm5'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m5['m5']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m5 = mysql_fetch_assoc($resumen_m5)); ?>
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
<input type="text" size="2"  name="<?php echo 'm6'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m6['m6']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m6 = mysql_fetch_assoc($resumen_m6)); ?>
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
<input type="text" size="2"  name="<?php echo 'm7'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m7['m7']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m7 = mysql_fetch_assoc($resumen_m7)); ?>
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
<input type="text" size="2"  name="<?php echo 'm8'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m8['m8']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m8 = mysql_fetch_assoc($resumen_m8)); ?>
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
<input type="text" size="2"  name="<?php echo 'm9'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m9['m9']; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m9 = mysql_fetch_assoc($resumen_m9)); ?>
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
<input type="text" size="2"  name="<?php echo 'm10'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m10['m10']; ?>"/>
<input type="hidden"  name="<?php echo 't10'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate10def; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m10 = mysql_fetch_assoc($resumen_m10)); ?>
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
<input type="text" size="2"  name="<?php echo 'm11'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m11['m11']; ?>"/>
<input type="hidden"  name="<?php echo 't11'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate11def; ?>"/>
</td>



</tr>
<?php $i++; } while ($row_resumen_m11 = mysql_fetch_assoc($resumen_m11)); ?>
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
<input type="text" size="2"  name="<?php echo 'm12'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m12['m12']; ?>"/>
<input type="hidden"  name="<?php echo 't12'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate12def; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m12 = mysql_fetch_assoc($resumen_m12)); ?>
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
<input type="text" size="2"  name="<?php echo 'm13'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m13['m13']; ?>"/>
<input type="hidden"  name="<?php echo 't13'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate13def; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m13 = mysql_fetch_assoc($resumen_m13)); ?>
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
<input type="text" size="2"  name="<?php echo 'm14'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_resumen_m14['m14']; ?>"/>
<input type="hidden"  name="<?php echo 't14'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $totalRows_mate14def; ?>"/>
</td>

</tr>
<?php $i++; } while ($row_resumen_m14 = mysql_fetch_assoc($resumen_m14)); ?>
</table>
</td>
<?php } ?>


<td>
<table> 
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
ET1

</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
ET2
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center" >
ET3
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
ET4
</td>
</tr>
<?php $i=1; do  { ?>
<tr >
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="<?php echo 'ept1'.$i; ?>" id="<?php echo 'ept1'.$i; ?>">
            			<option value="<?php echo $row_resumen_ept['ept1'];?>"><?php echo $row_resumen_ept['ept1'];?></option>
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold" name="<?php echo 'ept2'.$i; ?>" id="<?php echo 'ept2'.$i; ?>">
            			<option value="<?php echo $row_resumen_ept['ept2'];?>"><?php echo $row_resumen_ept['ept2'];?></option>
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="<?php echo 'ept3'.$i; ?>" id="<?php echo 'ept3'.$i; ?>">
            			<option value="<?php echo $row_resumen_ept['ept3'];?>"><?php echo $row_resumen_ept['ept3'];?></option>
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>
<td class="ancho_td_nota" style="border-right:1px solid; border-bottom:1px solid;" align="center" >
		       <select class="texto_mediano_gris" style="font-weight:bold"  name="<?php echo 'ept4'.$i; ?>" id="<?php echo 'ept4'.$i; ?>">
            			<option value="<?php echo $row_resumen_ept['ept4'];?>"><?php echo $row_resumen_ept['ept4'];?></option>
            			<option value=""></option>
            			<option value="0">*</option>
            			<option value="1">X</option>
             			<option value="2"><b>-</b></option>
                	</select>
</td>


</tr>
<?php $i++; } while ($row_resumen_ept = mysql_fetch_assoc($resumen_ept)); ?>
</table>

		<input type="hidden" name="total"  id="total" value="<?php echo $totalRows_resumen_estudiante;?>" >
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
	<td width="20" align="center"><b>Orden</b></td>

</tr>
	<?php $i=1; do { ?>
<tr height="25">
	<td align="center"><?php echo $row_profe_mate['nombre_mate'];?>
	<input type="hidden" size="20"  name="<?php echo 'nombre_mate'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['nombre_mate']; ?>"/>
	<input type="hidden" size="20"  name="<?php echo 'id_d'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['id']; ?>"/>

	</td>
	<td align="center"><input type="text" size="20"  name="<?php echo 'nombre_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['nombre_docente'] ?>"/></td>
	<td align="center"> <input type="text" size="20"  name="<?php echo 'apellido_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['apellido_docente']; ?>"/></td>
	<td align="center"><input type="text" size="20"  name="<?php echo 'cedula_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['cedula_docente'] ?>"/></td>
	<td align="center"><input type="text" size="1"  name="<?php echo 'orden_mate'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['orden_mate']; ?>"/></td>
</tr>
	<?php $i++;  } while ($row_profe_mate = mysql_fetch_assoc($profe_mate)); ?>

		<input type="hidden" name="totaldocente"  id="totaldocente" value="<?php echo $totalRows_profe_mate;?>" />
<?php  /*<tr>
	<td align="center">EDUCACI&Oacute;N PARA EL TRABAJO</td>
	<input type="hidden"  name="nombre_mate_ept" class="texto_pequeno_gris" value="EDUC. PARA EL TRABAJO"/>
	<input type="hidden"  name="id_d_ept" class="texto_pequeno_gris" value=""/>
	<input type="hidden"  name="orden_mate_ept" class="texto_pequeno_gris" value="<?php $orden=$totalRows_profe_mate+1; echo $orden;?>"/>
	<td align="center"><input type="text" size="20"  name="apellido_docente_ept" class="texto_pequeno_gris" value=""/></tp>
	<td align="center"><input type="text" size="20"  name="nombre_docente_ept" class="texto_pequeno_gris" value=""/></tp>
	<td align="center"><input type="text" size="20"  name="cedula_docente_ept" class="texto_pequeno_gris" value=""/></tp>
</tr>
*/ ?>
</table>

<h3>PROGRAMAS DE EDUCACION PARA EL TRABAJO</h3>

<?php if($totalRows_resumen_mateept>0){//Si hay datos ?>
<table>
<tr height="25" bgcolor="green">

	<td align="center" colspan="3" width="350" style="font-size:12px; color:#fff;">Programas de EPT</td>

</tr>
<tr>
  <td align="center" class="texto_mediano_gris">No. Orden</td>
  <td align="center" class="texto_mediano_gris">Asignaturas</td>
  <td align="center" class="texto_mediano_gris">Horas/clase</td>
</tr>
<?php $i=1; do  { ?>
<td align="center"><input type="text" size="3" name="<?php echo 'no'.$i;?>" id="<?php echo 'no'.$i;?>" value="<?php echo $row_resumen_mateept['no'];?>"></td>
<td align="center"><input type="text" size="20" name="<?php echo 'descripcion'.$i;?>" id="<?php echo 'descripcion'.$i;?>" value="<?php echo $row_resumen_mateept['descripcion'];?>"></td>
<td align="center"><input type="text" size="3" name="<?php echo 'horas_clase'.$i;?>" id="<?php echo 'horas_clase'.$i;?>" value="<?php echo $row_resumen_mateept['horas_clase'];?>">

		<input type="hidden" name="totalept"  id="totalept" value="<?php echo $totalRows_resumen_mateept;?>" >
		<input type="hidden" name="<?php echo 'id_ept'.$i;?>" value="<?php echo $row_resumen_mateept['id'];?>" >

</td>
</tr>
<?php $i++;  } while ($row_resumen_mateept = mysql_fetch_assoc($resumen_mateept)); ?>
</table>
<?php } else {?>
<br />
<img src="../../images/png/atencion.png" width="80"/><br /><br />	
<span class="texto_mediano_gris" style="color:red;">No existen Materias de Educaci&oacute;n para el Trabajo Agregadas</span>
<?php }?>

<h3>AGREGAR OBSERVACIONES</h3>
<?php if($totalRows_resumen_observa>0){//Si hay datos ?>
<table>
<?php $i=1; do { ?>
<tr><td>
<span class="texto_mediano_gris">Observaciones para la Hoja #<?php echo $i; ?></span>
</td></tr>
<tr><td>
<TEXTAREA COLS=100 ROWS=10 NAME="<?php echo 'observacion'.$i; ?>"><?php echo $row_resumen_observa['observacion'];?></TEXTAREA> 
<input type="hidden" name="<?php echo 'id_observacion'.$i; ?>" value="<?php echo $row_resumen_observa['id'];?>" >
<input type="hidden" name="<?php echo 'hoja'.$i; ?>" value="<?php echo $row_resumen_observa['hoja'];?>" >
		<input type="hidden" name="totalobserva"  id="totalobserva" value="<?php echo $totalRows_resumen_observa;?>" >
</td></tr>
<?php $i++;  } while ($row_resumen_observa = mysql_fetch_assoc($resumen_observa)); ?>
</table>
<?php } else {?>
<br />
<img src="../../images/png/atencion.png" width="80"/><br /><br />	
<span class="texto_mediano_gris" style="color:red;">No existen Observaciones Agregadas  al Resumen</span>
<?php }?>

<br />
<br />
<br />
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Modificar Resumen" style="font-size:16px;"/>
</td>
	<input type="hidden" name="MM_update" value="form">
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
<span class="texto_grande_gris" >NO SE CARGO EL RESUMEN PARA ESTA SECCION</span>
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
