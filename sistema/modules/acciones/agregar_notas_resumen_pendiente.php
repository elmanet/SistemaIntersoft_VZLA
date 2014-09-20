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


//AGREGAR ESTUDIANTE A PEDIENTE




$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$i=0;
do { 
   $i++;


     $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_pendiente (id, alumno_id, anio_id, plan_id, no_alumno, tipo_resumen, tipo_cedula, momento, modi, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, m13, m14)VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($_POST['alumno_id'], "int"),
                            GetSQLValueString($_POST['anio_id'], "int"),
                            GetSQLValueString($_POST['plan_id'], "int"),
                            GetSQLValueString($_POST['no_alumno'], "int"),
                            GetSQLValueString($_POST['tipo_resumen'], "int"),
                            GetSQLValueString($_POST['tipo_cedula'], "int"),
                            GetSQLValueString($_POST['momento'], "int"),
                            GetSQLValueString($_POST['modi'], "int"),                     
                            GetSQLValueString($_POST['m1'], "int"),
                            GetSQLValueString($_POST['m2'], "int"),
                            GetSQLValueString($_POST['m3'], "int"),
                            GetSQLValueString($_POST['m4'], "int"),
                            GetSQLValueString($_POST['m5'], "int"),
                            GetSQLValueString($_POST['m6'], "int"),
                            GetSQLValueString($_POST['m7'], "int"),
                            GetSQLValueString($_POST['m8'], "int"),
                            GetSQLValueString($_POST['m9'], "int"),
                            GetSQLValueString($_POST['m10'], "int"),
                            GetSQLValueString($_POST['m11'], "int"),
                            GetSQLValueString($_POST['m12'], "int"),
                            GetSQLValueString($_POST['m13'], "int"),
                            GetSQLValueString($_POST['m14'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result7 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

 $insertGoTo = "proceso_fin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $insertGoTo));
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
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
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


<h3>Agregar  Estudiante a la N&oacute;mina</h3>
<table width="960"><tr>


<?php // ESTUDIANTE
?> 

<form action="<?php echo $editFormAction; ?>" method="POST" name="form">

<td>
<center>
<table><tr><td>
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
No.
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
Cod. del Estudiante
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
Orden
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N1
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N2
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N3
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N4
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N5
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N6
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N7
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N8
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N9
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N10
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N11
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N12
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N13
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
N14
</td>

</tr>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris">1</span>
<input type="hidden" name="id" value="" />

<input type="hidden" name="anio_id" value="<?php echo $_GET['anio_id']; ?>" />
<input type="hidden" name="plan_id" value="<?php echo $_GET['plan_id']; ?>" />
<input type="hidden" name="tipo_resumen" value="<?php echo $_GET['tipor']; ?>" />
<input type="hidden" name="tipo_cedula" value="<?php echo $_GET['tipoc']; ?>" />
<input type="hidden" name="momento" value="<?php echo $_GET['momento']; ?>" />
<input type="hidden" name="modi" value="1" />

</td>
<td class="ancho_td_nombre3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<input type="text" size="15" class="texto_pequeno_gris" name="alumno_id" value="" /> <br /><a href="../alumno/estudiante_detalle.php" target="_blank">Buscar Codigo</a>
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" size="2" class="texto_pequeno_gris" name="no_alumno" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m1" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m2" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m3" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m4" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m5" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m6" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m7" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m8" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m9" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m10" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m11" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m12" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m13" value="" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="m14" value="" />
</td>

</tr>
</table>
</center>
</td>


</tr>
</table>
<br />
<center>
<h2>NOTA</h2><span class="texto_mediano_gris" style="color:blue;">1)DEBES AGREGAR ES EL COD DEL ESTUDIANTE<br />2)EL No. DE ORDEN DEL ESTUDIANTE LA HOJA 1 ES DE 1 A 13 <br />EN LA HOJA 2 DEL 14 AL 26, ASI SUCESIVAMNTE</span> <br /><span class="texto_grande_gris" style="color:red;">"PARA VER LOS CAMBIOS <br />DESPUES DE ACTUALIZAR CIERRA ESTA VENTANA <br />Y PRESIONA F5 PARA ACTUALIZAR"</span>
</center>
<br />
<br />
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Datos Verificados" style="font-size:16px;"/>
</td>
	<input type="hidden" name="MM_insert" value="form">
	</form>
<br />
<br />
</center>


 </tr></table>
 <center>
<span class="texto_pequeno_gris">INTERSOFT | Software Educativo para: <b><?php echo $row_colegio['webcol'];?></b></span>
</center>


</center>
</body>
</html>
<?php

mysql_free_result($colegio);


?>
