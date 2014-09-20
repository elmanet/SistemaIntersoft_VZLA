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


//MODIFICAR LA TABLA DE DOCENTES CDC

$total=$_POST["total"];

// MODIFICAR TABLA DOCENTE_CDC INFO

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$i=0;
do { 
   $i++;


     $updateSQL = sprintf("update jos_cdc_resumen_docente SET nombre_mate=%s, orden_mate=%s, nombre_docente=%s, apellido_docente=%s, cedula_docente=%s WHERE id=%s",
                         
                            GetSQLValueString($_POST['nombre_mate'.$i], "text"),
                            GetSQLValueString($_POST['orden_mate'.$i], "int"),
                            GetSQLValueString($_POST['nombre_docente'.$i], "text"),
                            GetSQLValueString($_POST['apellido_docente'.$i], "text"),
                            GetSQLValueString($_POST['cedula_docente'.$i], "biginit"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result7 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

 $updateGoTo = "proceso_fin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $updateGoTo));
}


//TABLA DE DOCENTES RESUMEN
$colname_mate1 = "-1";
if (isset($_GET['id'])) {
  $colname_mate1 = $_GET['id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  * FROM jos_cdc_resumen_docente WHERE id = %s", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);


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
<?php if($totalRows_mate1>0){?>


<h3>Modificar Datos de Docentes de Resumen</h3>
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
ASIGNATURA
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
ORDEN
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
APELLIDOS
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
NOMBRES
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
CEDULA
</td>
</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="<?php echo $row_mate1['id']; ?>" />


<!--<input type="hidden" name="<?php echo 'no_alumno'.$i; ?>" value="<?php echo $lista; ?>" />
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="" />-->
</td>
<td class="ancho_td_nombre3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_mediano_gris"><input type="text" size="40" name="<?php echo 'nombre_mate'.$i; ?>" value="<?php echo $row_mate1['nombre_mate']; ?>" /></span>
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'orden_mate'.$i; ?>" value="<?php echo $row_mate1['orden_mate']; ?>" />
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<input type="text" size="35" class="texto_pequeno_gris" name="<?php echo 'apellido_docente'.$i; ?>" value="<?php echo $row_mate1['apellido_docente']; ?>" />
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<input type="text" size="35" class="texto_pequeno_gris" name="<?php echo 'nombre_docente'.$i; ?>" value="<?php echo $row_mate1['nombre_docente']; ?>" />
</td>
<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" size="10" name="<?php echo 'cedula_docente'.$i; ?>" value="<?php echo $row_mate1['cedula_docente']; ?>" />
</td>

</tr>
<?php $i++; $lista ++; } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</table>
</center>
</td>



		<input type="hidden" name="total"  id="total" value="<?php echo $totalRows_mate1;?>" >

</tr>
</table>
<br />
<center>
<span class="texto_grande_gris" style="color:red;">"PARA VER LOS CAMBIOS <br />DESPUES DE ACTUALIZAR CIERRA ESTA VENTANA <br />Y PRESIONA F5 PARA ACTUALIZAR"</span>
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


<?php } else { ?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png" /><br /><br />
<span class="texto_grande_gris" >ERROR DE DATOS </span>
</center>

<?php } ?>
</center>
</body>
</html>
<?php

mysql_free_result($mate1);

mysql_free_result($colegio);


?>
