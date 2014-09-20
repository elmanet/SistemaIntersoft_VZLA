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

$asignatura= $_POST['id_asignatura'];

if (!empty($asignatura)) { 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha= $_POST['ano']."-".$_POST['mes']."-".$_POST['dia'];
//corregir

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

   $insertSQL = sprintf("INSERT INTO jos_horario_examen (id, id_asignatura, fecha, contenido, tipo_examen) VALUES (%s, %s, %s, %s, %s)",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['id_asignatura'], "int"),
							GetSQLValueString($fecha, "date"),
							GetSQLValueString($_POST['contenido'], "text"),
							GetSQLValueString($_POST['tipo_examen'], "text"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "publicar_horario_examen01.php";
  if (isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	$insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}

}



// CONSULTA SQL
$colname_docente = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_docente = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id  FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id AND a.username = %s", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

// FIN DE LA CONSULTA SQL 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />

</head>
<center>
<body>
<?php if ($row_docente['gid']==19){ // INICIO DE LA CONSULTA ?>
<div id="contenedor_central_modulo">
<table width="500" border="0">
  <tr>
	<td width="128"><img src="../../images/png/calendario.png" width="75" height="75" /></td>
	<td width="362"><table width="100%" border="0">
	  <tr>
		<td class="titulo_extragrande_gris" colspan="2">PUBLICAR NUEVA EVALUACION</td>
	  </tr>
	  <tr><td>
	
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
		   
	<tr><td align="left">Selecciona la Asignatura:</td></tr>
	<tr><td>
	<select name="id_asignatura" class="texto_mediano_gris" id="id_asignatura">
		 <option value="">..Selecciona</option>
		   <?php do { ?>
			  <option value="<?php echo $row_docente['mate']; ?>"><?php echo $row_docente['nombre']." de ".$row_docente['anio']." ".$row_docente['descripcion']; ?></option>
		   <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
		   mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
		 </select></td></tr>
<tr>
<td align="left">Fecha de la Evaluaci&oacute;n: 
</td></tr>
<tr><td>
<select name="dia" id="dia">
			 <option value="01">01</option>
			 <option value="02">02</option>
			 <option value="03">03</option>
			 <option value="04">04</option>
			 <option value="05">05</option>
			 <option value="06">06</option>
			 <option value="07">07</option>
			 <option value="08">08</option>
			 <option value="09">09</option>
			 <option value="10">10</option>
		 	 <option value="11">11</option>
		<option value="12">12</option>
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>  
		 <option value="31">31</option>						
			 </select>
			 <select name="mes" id="mes">
			 <option value="01">Enero</option>
			 <option value="02">Febrero</option>
			 <option value="03">Marzo</option>
			 <option value="04">Abril</option>
			 <option value="05">Mayo</option>
			 <option value="06">Junio</option>
			 <option value="07">Julio</option>
			 <option value="08">Agosto</option>
			 <option value="09">Septiembre</option>
			 <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>						  
			 </select>
			 <select name="ano" id="ano">
			 
			 <option value="2013">2013</option>
		 <option value="2014">2014</option>
			 </select>

</td></tr>
<tr><td align="left">
	Contenido de la Evaluaci&oacute;n:
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="contenido"></TEXTAREA>
</td></tr>
<tr><td align="left">
	Tipo de Evaluaci&oacute;n:
</td></tr>
<tr><td>
		 <select name="tipo_examen" id="tipo_examen">
		 <option value="Exposici&oacute;n">Exposici&oacute;n</option>
		 <option value="Taller Evaluado">Taller Evaluado</option>
			 <option value="Prueba Parcial">Prueba Parcial</option>
		 <option value="Prueba Final">Prueba Final</option>
			 </select>
</td></tr>

<tr>
<td>
	 
	<input name="id" type="hidden" id="id" value="">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Publicar Horario >" />
	
	<input type="hidden" name="MM_insert" value="form1">
	  </form>
	</td></tr>
	 
 </td></tr>
	  

	  <tr>
		<td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
	  </tr>
	</table></td>
  </tr>
</table>

</div>

<?php } //FIN DE LA CONSULTA 
?>
</body>
</center>
</html>
<?php
mysql_free_result($docente);
?>
