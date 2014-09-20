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
$query_confi = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confi = mysql_query($query_confi, $sistemacol) or die(mysql_error());
$row_confi = mysql_fetch_assoc($confi);
$totalRows_confi = mysql_num_rows($confi);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso ");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

$colname_docente = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_docente = $_GET['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT b.nombre, e.nombre as anio, d.descripcion FROM jos_asignatura a, jos_asignatura_nombre b, jos_curso c, jos_seccion d, jos_anio_nombre e WHERE a.asignatura_nombre_id=b.id AND a.curso_id=c.id AND c.anio_id=e.id AND c.seccion_id=d.id AND a.id=%s", GetSQLValueString($colname_docente, "int"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);


// INSERTAR PLANIFICACION

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {


    $insertSQL = sprintf("INSERT INTO jos_docente_planificacion (docente_id, asignatura_id, lapso, nombre_archivo, comentario, tipo_plan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['docente_id'], "int"),
                       GetSQLValueString($_POST['asignatura_id'], "int"),
                       GetSQLValueString($_POST['lapso'], "int"),
                       GetSQLValueString($_POST['nombre_archivo'], "text"),
                       GetSQLValueString($_POST['comentario'], "text"),                       
                       GetSQLValueString($_POST['tipo_plan'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

 $insertGoTo = "planificacion.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $insertGoTo));
}


//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>:: COLEGIONLINE ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
  <h3>Paso 3. Cargar Informaci&oacute;n general del Archivo</h3>
<table width="760" border="0" cellspacing="0" cellpadding="0">
<form action="<?php echo $editFormAction; ?>" method="POST">
  <!--DWLayoutTable-->
  <tr>
  <td valign="top" class="texto_mediano_gris"><b>Planificaci&oacute;n de:</b>

	</td></tr>
	<tr><td class="texto_mediano_gris">
	<?php echo $row_docente['nombre']." de ".$row_docente['anio']." ".$row_docente['descripcion']; ?>
		
	</td></tr>

 	<tr>
    	<td valign="top" class="texto_mediano_gris"><br /><b>Nombre del Archivo</b>

	</td></tr>
	<tr><td class="texto_mediano_gris">
	<?php echo $_GET['nomarchivo']; ?>
	</td></tr>
	
	<tr><td class="texto_mediano_gris"><br /><b>Tipo de Planificaci&oacute;n</b></td></tr>
	<tr><td class="texto_mediano_gris">
		<?php   if($_GET['tipo_plan']==1){ echo "Planificaci&oacute;n Anual";}
			if($_GET['tipo_plan']==2){ echo "Planificaci&oacute;n de Lapso";}
			if($_GET['tipo_plan']==3){ echo "Plan de Evaluaci&oacute;n Mensual";}
		?>
		
	</td></tr>
	
	<tr><td class="texto_mediano_gris"><br /><b>Observaciones</b></td></tr>
	<tr><td class="texto_mediano_gris">
	<textarea name="comentario"></textarea></td></tr>
	
	<tr><td class="texto_mediano_gris">
		<input type="hidden" name="nombre_archivo" value="<?php echo $_GET['nomarchivo']?>"/>
		<input type="hidden" name="asignatura_id" value="<?php echo $_GET['asignatura_id']?>"/>
		<input type="hidden" name="tipo_plan" value="<?php echo $_GET['tipo_plan']?>"/>
		<input type="hidden" name="lapso" value="<?php echo $_GET['lapso']?>"/>
		<input type="hidden" name="docente_id" value="<?php echo $_GET['docente_id']?>"/>
		<br />
	<button type="submit">Cargar Informaci&oacute;n</button>

	</td></tr>
		<input type="hidden" name="MM_insert" value="form">
	</form>
	
	
	
	<tr><td>
	&nbsp;&nbsp;
	</td></tr>
    </table>
</body>
</center>
</html>
<?php

mysql_free_result($docente);

mysql_free_result($confi);

mysql_free_result($lapso);

?>
