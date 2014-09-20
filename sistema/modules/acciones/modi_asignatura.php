<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
//initialize the session
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
// 	GRABADO EN LA TABLA 



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

   $updateSQL = sprintf("UPDATE jos_asignatura_nombre SET nombre=%s, iniciales=%s WHERE id=%s",
							
							GetSQLValueString($_POST['mate'], "text"),
							GetSQLValueString($_POST['iniciales'], "text"),
							GetSQLValueString($_POST['id'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "admin_asignatura.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $updateGoTo));
}

// CONSULTA SQL

$colname_asigna = "-1";
if (isset($_GET['id'])) {
  $colname_asigna = $_GET['id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_asigna = sprintf("SELECT a.id, a.nombre as mate, a.iniciales FROM jos_asignatura_nombre a, jos_periodo c WHERE  a.periodo=c.id AND c.actual=1 AND a.id=%s  ORDER BY a.nombre ASC" , GetSQLValueString($colname_asigna, "int"));
$asigna = mysql_query($query_asigna, $sistemacol) or die(mysql_error());
$row_asigna = mysql_fetch_assoc($asigna);
$totalRows_asigna = mysql_num_rows($asigna);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

// FIN DE LA CONSULTA SQL 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />


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

<div id="contenedor_central_modulo">
<table width="450" border="0">
  <tr>
       <td class="titulo_extragrande_gris" colspan="2">Modificar Asignatura</td>
      </tr>
     
<tr><td>

<?php // INICIO DE MODI ASIGNATURA
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onKeyPress="return disableEnterKey(event)">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">
		<td width="50" class="textogrande_eloy"  ><div align="center"><span class="texto_mediano_gris">ID</span></div></td>
		<td width="300" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Nombre de la Asignatura</span></div></td>
		<td width="50" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Iniciales</span></div></td>
		<td width="50" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">&nbsp;</span></div></td>
               
              </tr>
      
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="20" class="textoVARIOS_eloy"><div align="center"><span class="texto_mediano_gris"><?php echo $row_asigna['id']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><input type="text" name="mate" value="<?php echo $row_asigna['mate']; ?>" size="35"/></span></div></td>
		<td height="20" class="textoVARIOS_eloy" style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><input type="text" name="iniciales" value="<?php echo $row_asigna['iniciales']; ?>" size="5"/></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><input name="Actualizar" type="submit" value="Actualizar"/></span></div></td>

                
              </tr>
      
            </table>
  <input type="hidden" name="id" value="<?php echo $row_asigna['id']; ?>"/>          
	<input type="hidden" name="MM_update" value="form1">
</form>            
            
<span class="texto_pequeno_gris">Sistema Intersoft para: <b><?php echo $row_colegio['webcol'];?></b></span>
<!--FIN INFO CONSULTA -->	
	

 </td></tr>
      

      <tr>
        <td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
      </tr>
    </table></td>
  </tr>
</table>

</div>

</body>
</center>
</html>
<?php
mysql_free_result($asigna);
mysql_free_result($colegio);
?>
