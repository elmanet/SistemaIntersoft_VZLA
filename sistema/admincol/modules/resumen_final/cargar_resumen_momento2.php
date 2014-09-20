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
if($_POST['momento']==1){$m=2;}
if($_POST['momento']==2){$m=3;}
if($_POST['momento']==3){$m=4;}

$i = 0;

do { 
   $i++;

if($_POST['momento']<4){

if((($_POST['m1'.$i]>0) and ($_POST['m1'.$i]<10)) or (($_POST['m2'.$i]>0) and ($_POST['m2'.$i]<10)) or (($_POST['m3'.$i]>0) and ($_POST['m3'.$i]<10)) or (($_POST['m4'.$i]>0) and ($_POST['m4'.$i]<10)) or (($_POST['m5'.$i]>0) and ($_POST['m5'.$i]<10)) or (($_POST['m6'.$i]>0) and ($_POST['m6'.$i]<10)) or (($_POST['m7'.$i]>0) and ($_POST['m7'.$i]<10)) or (($_POST['m8'.$i]>0) and ($_POST['m8'.$i]<10)) or (($_POST['m9'.$i]>0) and ($_POST['m9'.$i]<10)) or (($_POST['m10'.$i]>0) and ($_POST['m10'.$i]<10)) or (($_POST['m11'.$i]>0) and ($_POST['m11'.$i]<10)) or (($_POST['m12'.$i]>0) and ($_POST['m12'.$i]<10)) or (($_POST['m13'.$i]>0) and ($_POST['m13'.$i]<10)) or (($_POST['m14'.$i]>0) and ($_POST['m14'.$i]<10))  or ($_POST['m1'.$i]==98)  or ($_POST['m2'.$i]==98)  or ($_POST['m3'.$i]==98)  or ($_POST['m4'.$i]==98)  or ($_POST['m5'.$i]==98)  or ($_POST['m6'.$i]==98)  or ($_POST['m7'.$i]==98)  or ($_POST['m8'.$i]==98)  or ($_POST['m9'.$i]==98)  or ($_POST['m10'.$i]==98)  or ($_POST['m11'.$i]==98)  or ($_POST['m12'.$i]==98)  or ($_POST['m13'.$i]==98)  or ($_POST['m14'.$i]==98)){


  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_pendiente (id, alumno_id, anio_id, plan_id, no_alumno, tipo_resumen, tipo_cedula, momento, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, m13, m14) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['alumno_id'.$i], "int"),
                       GetSQLValueString($_POST['anio_id'], "int"),
                       GetSQLValueString($_POST['plan_id'], "int"),
                       GetSQLValueString($_POST['no_alumno'.$i], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($m, "int"),
                       GetSQLValueString($_POST['m1'.$i], "int"),
                       GetSQLValueString($_POST['m2'.$i], "int"),
                       GetSQLValueString($_POST['m3'.$i], "int"),
                       GetSQLValueString($_POST['m4'.$i], "int"),
                       GetSQLValueString($_POST['m5'.$i], "int"),
                       GetSQLValueString($_POST['m6'.$i], "int"),
                       GetSQLValueString($_POST['m7'.$i], "int"),
                       GetSQLValueString($_POST['m8'.$i], "int"),
                       GetSQLValueString($_POST['m9'.$i], "int"),
                       GetSQLValueString($_POST['m10'.$i], "int"),
                       GetSQLValueString($_POST['m11'.$i], "int"),
                       GetSQLValueString($_POST['m12'.$i], "int"),
                       GetSQLValueString($_POST['m13'.$i], "int"),
                       GetSQLValueString($_POST['m14'.$i], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}
}

} while ($i+1 <= $total2 );

header(sprintf("Location: %s", $insertGoTo));
}
/*
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
*/
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
  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_docente (id, curso_id, tipo_resumen, tipo_cedula, plan_id, momento, nombre_mate, orden_mate, nombre_docente, apellido_docente, cedula_docente) VALUES ( %s, %s,  %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                       GetSQLValueString($_POST['id_d'.$i], "int"),
                       GetSQLValueString($_POST['anio_id'], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['plan_id'], "int"),
                       GetSQLValueString($_POST['momento'], "int"),
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

  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_observaciones (id, curso_id, tipo_resumen, tipo_cedula, plan_id, momento, observacion, hoja) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_observacion'.$i], "int"),
                       GetSQLValueString($_POST['anio_id'], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['plan_id'], "int"),
                       GetSQLValueString($_POST['momento'], "int"),
                       GetSQLValueString($_POST['observacion'.$i], "text"),
                       GetSQLValueString($_POST['hoja'.$i], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result5 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

} while ($i+1 <= $totalept);

header(sprintf("Location: %s", $insertGoTo));
}

// MODIFICAR MOMENTO EXISTENTE

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$i=0;
do { 
   $i++;
$modi=1;

     $updateSQL = sprintf("update jos_cdc_resumen_pendiente SET plan_id=%s, no_alumno=%s, modi=%s, m1=%s, m2=%s, m3=%s, m4=%s, m5=%s, m6=%s, m7=%s, m8=%s, m9=%s, m10=%s, m11=%s, m12=%s, m13=%s, m14=%s WHERE alumno_id=%s AND momento=%s",
                             GetSQLValueString($_POST['plan_id'], "int"),
                            GetSQLValueString($_POST['no_alumno'.$i], "int"), 
                            GetSQLValueString($modi, "int"),                           
                            GetSQLValueString($_POST['m1'.$i], "int"),
                            GetSQLValueString($_POST['m2'.$i], "int"),
                            GetSQLValueString($_POST['m3'.$i], "int"),
                            GetSQLValueString($_POST['m4'.$i], "int"),
                            GetSQLValueString($_POST['m5'.$i], "int"),
                            GetSQLValueString($_POST['m6'.$i], "int"),
                            GetSQLValueString($_POST['m7'.$i], "int"),
                            GetSQLValueString($_POST['m8'.$i], "int"),
                            GetSQLValueString($_POST['m9'.$i], "int"),
                            GetSQLValueString($_POST['m10'.$i], "int"),
                            GetSQLValueString($_POST['m11'.$i], "int"),
                            GetSQLValueString($_POST['m12'.$i], "int"),
                            GetSQLValueString($_POST['m13'.$i], "int"),
                            GetSQLValueString($_POST['m14'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['momento'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result5 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total2 );

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
if (isset($_POST['anio_id'])) {
  $colname_profe_mate = $_POST['anio_id'];
}
/*
$plan_profe_mate = "-1";
if (isset($_POST['plan_id'])) {
  $plan_profe_mate = $_POST['plan_id'];
}
*/
mysql_select_db($database_sistemacol, $sistemacol);
$query_profe_mate = sprintf("SELECT * FROM jos_cdc_resumen_asignatura_pendiente WHERE anio_id = %s ORDER BY numero ASC", GetSQLValueString($colname_profe_mate, "int"));
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



//ASIGNATURAS
$colname_asignatura = "-1";
if (isset($_POST['anio_id'])) {
  $colname_asignatura = $_POST['anio_id'];
}
/*
$plan_asignatura = "-1";
if (isset($_POST['plan_id'])) {
  $plan_asignatura = $_POST['plan_id'];
}*/
mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_cdc_resumen_asignatura_pendiente WHERE anio_id = %s  ORDER BY numero ASC", GetSQLValueString($colname_asignatura, "int"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);

// INSTITUCION
mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

// CONSULTA DE ANIOS
$colname_aniosp = "-1";
if (isset($_POST['anio_id'])) {
  $colname_aniosp = $_POST['anio_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_aniosp = sprintf("SELECT * FROM jos_anio_nombre  ORDER BY orden_resumen ASC", GetSQLValueString($colname_aniosp, "int"));
$aniosp = mysql_query($query_aniosp, $sistemacol) or die(mysql_error());
$row_aniosp = mysql_fetch_assoc($aniosp);
$totalRows_aniosp = mysql_num_rows($aniosp);

// VER EXISTENCIA DE RESUMEN
$momento=$_POST['momento'];


$colname_resumen = "-1";
if (isset($_POST['anio_id'])) {
  $colname_resumen = $_POST['anio_id'];
}
$tr_resumen = "-1";
if (isset($_POST['tipor'])) {
  $tr_resumen = $_POST['tipor'];
}
$tc_resumen = "-1";
if (isset($_POST['tipoc'])) {
  $tc_resumen = $_POST['tipoc'];
}
$momento_resumen = "-1";
if (isset($_POST['momento'])) {
  $momento_resumen = $_POST['momento'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen = sprintf("SELECT * FROM jos_cdc_resumen_pendiente a, jos_alumno_info b WHERE a.modi IS NULL AND a.alumno_id=b.alumno_id AND a.anio_id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s AND a.momento=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_resumen, "int"), GetSQLValueString($tr_resumen, "int"), GetSQLValueString($tc_resumen, "int"), GetSQLValueString($momento_resumen, "int"));
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

<table width="1000"><tr><td>
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

<h3>Estudiantes con Materia Pendiente de <?php echo $row_aniosp['nombre']; ?></h3>
<table width="1000"><tr>


<?php // MATERIA 1
?> 

<form action="<?php echo $editFormAction; ?>" method="POST" name="form">

<td align="center">

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
<?php do { ?>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
<?php echo $row_asignatura['iniciales'];?>
</td>
<?php } while ($row_asignatura = mysql_fetch_assoc($asignatura)); ?>

<?php $i=1;  $totalmates=14-$totalRows_asignatura; do { ?>
<td class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;">
</td>
<?php  $i++; } while ($i <= $totalmates); ?>

</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
<input type="hidden" name="<?php echo 'alumno_id'.$i; ?>" value="<?php echo $row_resumen['alumno_id']; ?>" />
<input type="hidden" name="<?php echo 'no_alumno'.$i; ?>" value="<?php echo $i; ?>" />
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="" />
</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_resumen['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<span class="texto_pequeno_gris"><?php echo $row_resumen['apellido']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<span class="texto_pequeno_gris"><?php echo $row_resumen['nombre']; ?></span>
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" size="2" maxlength="2" class="texto_pequeno_gris" name="<?php echo 'm1'.$i; ?>" value="<?php echo $row_resumen['m1']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm2'.$i; ?>" value="<?php echo $row_resumen['m2']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm3'.$i; ?>" value="<?php echo $row_resumen['m3']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm4'.$i; ?>" value="<?php echo $row_resumen['m4']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm5'.$i; ?>" value="<?php echo $row_resumen['m5']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm6'.$i; ?>" value="<?php echo $row_resumen['m6']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm7'.$i; ?>" value="<?php echo $row_resumen['m7']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm8'.$i; ?>" value="<?php echo $row_resumen['m8']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm9'.$i; ?>" value="<?php echo $row_resumen['m9']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm10'.$i; ?>" value="<?php echo $row_resumen['m10']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm11'.$i; ?>" value="<?php echo $row_resumen['m11']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm12'.$i; ?>" value="<?php echo $row_resumen['m12']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm13'.$i; ?>" value="<?php echo $row_resumen['m13']; ?>" />
</td>
<td class="ancho_td_no3"  style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text"  size="2" maxlength="2"  class="texto_pequeno_gris" name="<?php echo 'm14'.$i; ?>" value="<?php echo $row_resumen['m14']; ?>" />
</td>


</tr>
<?php $i++; $lista ++; } while ($row_resumen = mysql_fetch_assoc($resumen)); ?>
</table>


		<input type="hidden" name="total"  id="total" value="<?php echo $totalRows_resumen;?>" >
		<input type="hidden" name="anio_id" value="<?php echo $_POST['anio_id'];?>">
		<input type="hidden" name="momento" value="<?php echo $_POST['momento'];?>">
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
	<td width="100" align="center"><b>Docentes con <br />Materia Pendiente</b></td>
</tr>
	<?php $i=1; do { ?>
<tr height="25">
	<td align="center"><?php echo $row_profe_mate['nombre'];?>
	<input type="hidden" size="20"  name="<?php echo 'nombre_mate'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['nombre']; ?>"/>
	<input type="hidden" size="20"  name="<?php echo 'id_d'.$i; ?>" class="texto_pequeno_gris" value=""/>
	<input type="hidden" size="20"  name="<?php echo 'orden_mate'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $i; ?>"/>
	</td>
	<td align="center"><input type="text" size="20"  name="<?php echo 'nombre_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['nombre_docente'];?>"/></td>
	<td align="center"> <input type="text" size="20"  name="<?php echo 'apellido_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['apellido_docente'];?>"/></td>
	<td align="center"><input type="text" size="20"  name="<?php echo 'cedula_docente'.$i; ?>" class="texto_pequeno_gris" value="<?php echo $row_profe_mate['cedula_docente'];?>"/></td>
	<td align="center"> <input type="checkbox" name="<?php echo 'docente_revision'.$i; ?>" class="texto_pequeno_gris" value="1"/></td>
</tr>
	<?php $i++;  } while ($row_profe_mate = mysql_fetch_assoc($profe_mate)); ?>

		<input type="hidden" name="totaldocente"  id="totaldocente" value="<?php echo $totalRows_profe_mate;?>" />
<?php /*<tr>
	<td align="center">EDUCACI&Oacute;N PARA EL TRABAJO</td>
	<input type="hidden"  name="nombre_mate_ept" class="texto_pequeno_gris" value="EDUC. PARA EL TRABAJO"/>
	<input type="hidden"  name="id_d_ept" class="texto_pequeno_gris" value=""/>
	<input type="hidden"  name="orden_mate_ept" class="texto_pequeno_gris" value="<?php $orden=$totalRows_profe_mate+1; echo $orden;?>"/>
	<td align="center"><input type="text" size="20"  name="apellido_docente_ept" class="texto_pequeno_gris" value=""/></td>
	<td align="center"><input type="text" size="20"  name="nombre_docente_ept" class="texto_pequeno_gris" value=""/></td>
	<td align="center"><input type="text" size="20"  name="cedula_docente_ept" class="texto_pequeno_gris" value=""/></td>
	<td align="center"> <input type="checkbox" name="docente_revision_ept" class="texto_pequeno_gris" value="1"/></td>
</tr>*/?>
</table>
<?php /*
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
*/?>
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
?>

 </tr></table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>



<?php } else { ?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png" /><br /><br />
<h2>Pueden ocurrir las siguientes cosas:</h2>
<span class="texto_grande_gris" >1. YA CARGASTE LA NOMINA DE ESTE A&Ntilde;O PARA ESTE MOMENTO</span><br />
<span class="texto_grande_gris" >2. NO EXISTEN ESTUDIANTES CON ESTE TIPO DE CEDULA</span><br />
<span class="texto_grande_gris" >3. NO HAY ESTUDIANTES REGISTRADOS CON MATERIA PENDIENTE EN ESTA SECCION</span><br />

</center>

<?php } ?>
<?php if($row_resumen['modi']==1){ ?>
YA SE CARGO ESTE MOMENTO
<?php }?>

</center>
</body>
</html>
<?php
mysql_free_result($asignatura);
mysql_free_result($confip);
mysql_free_result($profe_mate);


mysql_free_result($colegio);
mysql_free_result($resumen);

?>
