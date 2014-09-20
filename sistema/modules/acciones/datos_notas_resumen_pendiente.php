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


     $updateSQL = sprintf("update jos_cdc_resumen_pendiente SET no_alumno=%s, m1=%s, m2=%s, m3=%s, m4=%s, m5=%s, m6=%s, m7=%s, m8=%s, m9=%s, m10=%s, m11=%s, m12=%s, m13=%s, m14=%s, ept1=%s, ept2=%s, ept3=%s, ept4=%s WHERE id=%s",
                         
                            GetSQLValueString($_POST['no_alumno'.$i], "int"),
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
                            GetSQLValueString($_POST['ept1'.$i], "int"),
                            GetSQLValueString($_POST['ept2'.$i], "int"),
                            GetSQLValueString($_POST['ept3'.$i], "int"),
                            GetSQLValueString($_POST['etp4'.$i], "int"),
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


//TABLA DE RESUMEN
$colname_mate1 = "-1";
if (isset($_GET['id'])) {
  $colname_mate1 = $_GET['id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.id, a.no_alumno, a.m1, a.m2, a.m3, a.m4, a.m5, a.m6, a.m7, a.m8, a.m9, a.m10, a.m11, a.m12, a.m13, a.m14, a.ept1, a.ept2, a.ept3, a.ept4, b.cedula, b.nombre, b.apellido FROM jos_cdc_resumen_pendiente a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.id = %s", GetSQLValueString($colname_mate1, "int"));
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


<h3>Modificar Calificaciones Estudiantes</h3>
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
C&eacute;dula
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
Apellidos y Nombres
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
Hoja
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
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
EPT1
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
EPT2
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
EPT3
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
EPT4
</td>

</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="<?php echo $row_mate1['id']; ?>" />
</td>
<td class="ancho_td_nombre3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['cedula']; ?></span>
</td>
<td class="ancho_td_nombre3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_pequeno_gris"><?php echo $row_mate1['apellido'].", ".$row_mate1['nombre']; ?></span>
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<select name="<?php echo 'no_alumno'.$i; ?>"><option value="<?php echo $row_mate1['no_alumno']; ?>">H-A</option><option value="13">H-1</option><option value="25">H-2</option><option value="38">H-3</option></select>
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm1'.$i; ?>" value="<?php echo $row_mate1['m1']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm2'.$i; ?>" value="<?php echo $row_mate1['m2']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm3'.$i; ?>" value="<?php echo $row_mate1['m3']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm4'.$i; ?>" value="<?php echo $row_mate1['m4']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm5'.$i; ?>" value="<?php echo $row_mate1['m5']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm6'.$i; ?>" value="<?php echo $row_mate1['m6']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm7'.$i; ?>" value="<?php echo $row_mate1['m7']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm8'.$i; ?>" value="<?php echo $row_mate1['m8']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm9'.$i; ?>" value="<?php echo $row_mate1['m9']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm10'.$i; ?>" value="<?php echo $row_mate1['m10']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm11'.$i; ?>" value="<?php echo $row_mate1['m11']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm12'.$i; ?>" value="<?php echo $row_mate1['m12']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm13'.$i; ?>" value="<?php echo $row_mate1['m13']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'm14'.$i; ?>" value="<?php echo $row_mate1['m14']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'ept1'.$i; ?>" value="<?php echo $row_mate1['ept1']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'ept2'.$i; ?>" value="<?php echo $row_mate1['ept2']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'ept3'.$i; ?>" value="<?php echo $row_mate1['ept3']; ?>" />
</td>
<td  class="ancho_td_no3"style="border-right:1px solid; border-bottom:1px solid;" >
<input type="text" size="2" class="texto_pequeno_gris" name="<?php echo 'ept4'.$i; ?>" value="<?php echo $row_mate1['ept4']; ?>" />
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