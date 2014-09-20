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

mysql_select_db($database_sistemacol, $sistemacol);
$query_seccion = sprintf("SELECT a.id, c.nombre, b.descripcion FROM jos_curso a, jos_seccion b, jos_anio_nombre c WHERE a.seccion_id=b.id AND a.anio_id=c.id ORDER BY c.numero_anio ASC");
$seccion = mysql_query($query_seccion, $sistemacol) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);


mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.nombre_docente, a.apellido_docente, b.id  FROM jos_docente a, jos_users b WHERE a.joomla_id=b.id ORDER BY apellido_docente ASC");
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_coordinador = sprintf("SELECT a.nombre_docente, a.apellido_docente, b.id FROM jos_secretaria_coordinador a, jos_users b WHERE a.joomla_id=b.id ORDER BY apellido_docente ASC");
$coordinador = mysql_query($query_coordinador, $sistemacol) or die(mysql_error());
$row_coordinador = mysql_fetch_assoc($coordinador);
$totalRows_coordinador = mysql_num_rows($coordinador);


// cambiar asistencia_confi


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "f1")) {

if(($_POST['valor1']==1) and ($_POST['valor2']==0)) {

$usuario=$_POST['docente_id'];

     $insertSQL = sprintf("INSERT INTO jos_alumno_asistencia_coordinacion (id, user_id, curso_id) VALUES (%s, %s, %s)",
                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($usuario, "int"),
                            GetSQLValueString($_POST['curso_id'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "asociar_coordinacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}

if(($_POST['valor1']==0) and ($_POST['valor2']==1)) {

$usuario=$_POST['coordinador_id'];

     $insertSQL = sprintf("INSERT INTO jos_alumno_asistencia_coordinacion (id, user_id, curso_id) VALUES (%s, %s, %s)",
                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($usuario, "int"),
                            GetSQLValueString($_POST['curso_id'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());


  $insertGoTo = "asociar_coordinacion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}

}


//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">



</head>
<center>
<body>


<table width="500" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Asociar Coordinaciones!</h2>
	<form action="<?php echo $editFormAction; ?>" method="POST" name="f1" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)" >
	</td></tr>

	<tr><td>
	<fieldset width="300">
		   <legend><strong style="font-size:11px"><em>Seleccionar de la tabla de Docentes</em></strong> </legend>
		<span class="texto_mediano_gris">Seleccionar Docente: </span> <input type="checkbox" name="valor1" id="valor1" value="1" />

<select name="docente_id" class="texto_mediano_gris" id="docente_id">
          <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_docente['id']; ?>"><?php echo $row_docente['apellido_docente'].", ".$row_docente['nombre_docente']; ?></option>
           <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
           mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
</fieldset>
	</td></tr>

	<tr><td>
	<fieldset width="300">

		   <legend><strong style="font-size:11px"><em>Seleccionar de la tabla de Coordinadores</em></strong> </legend>
		<span class="texto_mediano_gris">Seleccionar Coordinador: </span> <input type="checkbox" name="valor2" id="valor2" value="1" />

<select name="coordinador_id" class="texto_mediano_gris" id="coordinador_id">
          <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_coordinador['id']; ?>"><?php echo $row_coordinador['apellido_docente'].", ".$row_coordinador['nombre_docente']; ?></option>
           <?php } while ($row_coordinador = mysql_fetch_assoc($coordinador));
  	   $rows = mysql_num_rows($coordinador);
  	   if($rows > 0) {
           mysql_data_seek($coordinador, 0);
	  $row_coordinador = mysql_fetch_assoc($coordinador);
		 }
	   ?>

</fieldset>
	</td></tr>
	<tr>
	<td>
	<fieldset width="300">

		   <legend><strong style="font-size:11px"><em>Seleccionar el A&ntilde;o o Curso</em></strong> </legend>
<span class="texto_pequeno_gris" style="color:red;">S&oacute;lo debes darle en seleccionar a una de las dos opciones o de la tabla de docentes o de coordinadores..<br /> </span>
<span class="texto_mediano_gris">Curso o Secci&oacute;n: </span><select name="curso_id" class="texto_mediano_gris" id="curso_id">
          <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_seccion['id']; ?>"><?php echo $row_seccion['nombre']." - ".$row_seccion['descripcion']; ?></option>
           <?php } while ($row_seccion = mysql_fetch_assoc($seccion));
  	   $rows = mysql_num_rows($seccion);
  	   if($rows > 0) {
           mysql_data_seek($seccion, 0);
	  $row_seccion = mysql_fetch_assoc($seccion);
		 }
	   ?>
         </select>
	<input type="submit" name="buttom" value="Configurar >" />

</fieldset>
	</td></tr>

<input type="hidden" name="id" value="">
<input type="hidden" name="MM_insert" value="f1">
	</form>
<tr><td>
&nbsp;&nbsp;
</td></tr>
    </table>
</body>
</center>
</html>
<?php

mysql_free_result($seccion);
mysql_free_result($docente);
mysql_free_result($coordinador);

?>
