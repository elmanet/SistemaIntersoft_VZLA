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

// CONSULTA SQL

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);


// VER NOTAS


$colname_resumen = "-1";
if (isset($_GET['987cdc'])) {
  $colname_resumen = $_GET['987cdc'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_resumen = sprintf("SELECT a.id, b.cedula, b.indicador_nacionalidad, a.no_alumno, a.m1, a.m2, a.m3, a.m4, a.m5, a.m6, a.m7, a.m8, a.m9, a.m10, a.m11, a.m12, a.m13, a.m14, a.ept1, a.ept2, a.ept3, a.ept4, a.alumno_id, b.nombre, b.apellido FROM jos_cdc_resumen a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND b.cursando=1 AND id=%s", GetSQLValueString($colname_resumen, "int"));
$resumen = mysql_query($query_resumen, $sistemacol) or die(mysql_error());
$row_resumen = mysql_fetch_assoc($resumen);
$totalRows_resumen = mysql_num_rows($resumen);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" >


<link rel="stylesheet" href="../../jquery/styles/nyroModal.css" type="text/css" media="screen" />

<?php // SCRIPT PARA BLOQUEAR EL ENTER 
?>
<script>
function disableEnterKey(e){
var key;
if(window.event){
key = window.event.keyCode; //IE
}else{
key = e.which; //firefox
}
if(key==13){
return false;
}else{
return true;
}
}
</script>


</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
if($totalRows_resumen>0){
?>
	<div>
		<br />
		<img src="../../images/pngnew/chico-editar-usuario-icono-9008-48.png"/>
		<br />
		<span class="texto_grande_gris"><?php echo $row_resumen['nombre']." ".$row_resumen['apellido']; ?></span>
	</div>
	<div style="border:1px solid; background-color:#fffccc;">
		<table >
		<td class="texto_pequeno_gris" align="center"><b>01</b></td>
		<td class="texto_pequeno_gris" align="center"><b>02</b></td>
		<td class="texto_pequeno_gris" align="center"><b>03</b></td>
		<td class="texto_pequeno_gris" align="center"><b>04</b></td>
		<td class="texto_pequeno_gris" align="center"><b>05</b></td>
		<td class="texto_pequeno_gris" align="center"><b>06</b></td>
		<td class="texto_pequeno_gris" align="center"><b>07</b></td>
		<td class="texto_pequeno_gris" align="center"><b>08</b></td>
		<td class="texto_pequeno_gris" align="center"><b>09</b></td>
		<td class="texto_pequeno_gris" align="center"><b>10</b></td>
		<td class="texto_pequeno_gris" align="center"><b>11</b></td>
		<td class="texto_pequeno_gris" align="center"><b>12</b></td>
		<td class="texto_pequeno_gris" align="center"><b>13</b></td>
		<td class="texto_pequeno_gris" align="center"><b>ET</b></td>
		
		
		
		<tr>
			<td style="text-align:left; border:1px solid;" class="texto_mediano_gris" ><input type="text" size="2" name="m1" value="<?php echo $row_resumen['m1'];?>"/></td>
			<td style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m2" value="<?php echo $row_resumen['m2'];?>"/></td>
			<td style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text"  size="2"name="m3" value="<?php echo $row_resumen['m3'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m4" value="<?php echo $row_resumen['m4'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m5" value="<?php echo $row_resumen['m5'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m6" value="<?php echo $row_resumen['m6'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m7" value="<?php echo $row_resumen['m7'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m8" value="<?php echo $row_resumen['m8'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m9" value="<?php echo $row_resumen['m9'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m10" value="<?php echo $row_resumen['m10'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m11" value="<?php echo $row_resumen['m11'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m12" value="<?php echo $row_resumen['m12'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m13" value="<?php echo $row_resumen['m13'];?>"/></td>
			<td  style="text-align:left; border:1px solid;" class="texto_mediano_gris"><input type="text" size="2" name="m14" value="<?php echo $row_resumen['m14'];?>"/></td>

	  	</tr>
		</table>
	</div>	
	<div class="texto_mediano_gris">
	<br />
		"Para las Calificaciones N (No Cursa) se coloca 0, para P (Pendiente) se coloca 99"
	</div>
<?php } }?>

</body>
</center>
</html>
<?php

mysql_free_result($usuario);
mysql_free_result($resumen);




?>
