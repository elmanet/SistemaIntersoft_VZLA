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

$total=$_POST["total2"];

$i = 0;
do { 
   $i++;

if($_POST['alumno_pendiente'.$i]==1){

  $insertSQL = sprintf("INSERT INTO jos_cdc_resumen_pendiente (id, alumno_id, anio_id, tipo_resumen, tipo_cedula, momento) VALUES ( %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'.$i], "int"),
                       GetSQLValueString($_POST['alumno_id'.$i], "int"),
                       GetSQLValueString($_POST['anio_id'], "int"),
                       GetSQLValueString($_POST['tipo_resumen'], "int"),
                       GetSQLValueString($_POST['tipo_cedula'], "int"),
                       GetSQLValueString($_POST['momento'], "int"));

 
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
 }

} while ($i+1 <= $total );

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
$query_mate1 = sprintf("SELECT  a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula<99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula<99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula<99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula<99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC" , GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
} 
}else{
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula>99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula>99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula>99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC", GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT a.alumno_id, a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND a.cedula>99999999 AND a.cursando=1 AND b.curso_id= %s ORDER BY b.no_lista ASC" , GetSQLValueString($colname_mate1, "int"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);
} 
}

// CONSULTA DE ANIOS

mysql_select_db($database_sistemacol, $sistemacol);
$query_aniosp = sprintf("SELECT * FROM jos_anio_nombre WHERE orden_resumen>0 ORDER BY orden_resumen ASC");
$aniosp = mysql_query($query_aniosp, $sistemacol) or die(mysql_error());
$row_aniosp = mysql_fetch_assoc($aniosp);
$totalRows_aniosp = mysql_num_rows($aniosp);


// INSTITUICION
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
$query_resumen = sprintf("SELECT * FROM jos_cdc_resumen_pendiente a, jos_curso b WHERE a.anio_id=b.anio_id AND a.momento>1 AND b.id=%s AND a.tipo_resumen=%s AND a.tipo_cedula=%s", GetSQLValueString($colname_resumen, "int"), GetSQLValueString($tr_resumen, "int"), GetSQLValueString($tc_resumen, "int"));
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
<table width="500"><tr><td>
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

<table width="500"><tr>


<?php // MATERIA 1
?> 

<form action="<?php echo $editFormAction; ?>" method="POST" name="form">

<td align="center">
	<h2>Cargar N&oacute;mina de Materia Pendiente</h2>
<table><tr><td>
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
NO.
</td>
<td  class="ancho_td_cedula" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
CEDULA
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
NOMBRE Y APELLIDOS
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">

</td>


</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
<input type="hidden" name="<?php echo 'alumno_id'.$i; ?>" value="<?php echo $row_mate1['alumno_id']; ?>" />
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="" />
</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['cedula']; ?></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<span class="texto_pequeno_gris"><?php echo $row_mate1['nomalum']." ".$row_mate1['apellido']; ?></span>
</td>

<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="checkbox" name="<?php echo 'alumno_pendiente'.$i; ?>" class="texto_pequeno_gris" value="1"/>
</td>


</tr>
<?php $i++; $lista ++; } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</table>
</td>


<td>


		<input type="hidden" name="total2"  id="total2" value="<?php echo $totalRows_mate1;?>" >
		<input type="hidden" name="curso_id" value="<?php echo $_POST['curso_id'];?>">
		<input type="hidden" name="tipo_resumen" value="<?php echo $_POST['tipor'];?>">
		<input type="hidden" name="tipo_cedula" value="<?php echo $_POST['tipoc'];?>">
		<input type="hidden" name="momento" value="<?php echo '1';?>">





</td>
</tr>
<tr><td colspan="17" align="center">
<br />
<br />
<span class="texto_mediano_gris" style="font-size:17px;">Selecciona A&ntilde;o a registrar los estudiantes: </span>
<select name="anio_id" id="anio_id" style="font-size:17px;">
	<?php
	do { ?>
        <option value="<?php echo $row_aniosp['id']; ?>"><?php echo $row_aniosp['nombre']; ?></option>
        <?php } while ($row_aniosp = mysql_fetch_assoc($aniosp)); ?>
       </select>


<center>


<br />
<br />
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Cargar N&oacute;mina" style="font-size:16px;"/>
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
<span class="texto_pequeno_gris">Sistema Intersoft para: <b><?php echo $row_colegio['webcol'];?></b></span>



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

mysql_free_result($confip);
mysql_free_result($mate1);
mysql_free_result($aniosp);

mysql_free_result($colegio);
mysql_free_result($resumen);

?>
