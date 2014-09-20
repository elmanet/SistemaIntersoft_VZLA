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

// CONSULTA SQL
$colname_docente = "-1";
if (isset($_POST['docente_id'])) {
  $colname_docente = $_POST['docente_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT * FROM jos_docente WHERE id = %s", GetSQLValueString($colname_docente, "int"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

// CONSULTA DE LAS ASIGNATURAS
mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura1 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura1 = mysql_query($query_asignatura1, $sistemacol) or die(mysql_error());
$row_asignatura1 = mysql_fetch_assoc($asignatura1);
$totalRows_asignatura1 = mysql_num_rows($asignatura1);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura2 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura2 = mysql_query($query_asignatura2, $sistemacol) or die(mysql_error());
$row_asignatura2 = mysql_fetch_assoc($asignatura2);
$totalRows_asignatura2 = mysql_num_rows($asignatura2);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura3 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura3 = mysql_query($query_asignatura3, $sistemacol) or die(mysql_error());
$row_asignatura3 = mysql_fetch_assoc($asignatura3);
$totalRows_asignatura3 = mysql_num_rows($asignatura3);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura4 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura4 = mysql_query($query_asignatura4, $sistemacol) or die(mysql_error());
$row_asignatura4 = mysql_fetch_assoc($asignatura4);
$totalRows_asignatura4 = mysql_num_rows($asignatura4);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura5 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura5 = mysql_query($query_asignatura5, $sistemacol) or die(mysql_error());
$row_asignatura5 = mysql_fetch_assoc($asignatura5);
$totalRows_asignatura5 = mysql_num_rows($asignatura5);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura6 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura6 = mysql_query($query_asignatura6, $sistemacol) or die(mysql_error());
$row_asignatura6 = mysql_fetch_assoc($asignatura6);
$totalRows_asignatura6 = mysql_num_rows($asignatura6);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura7 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura7 = mysql_query($query_asignatura7, $sistemacol) or die(mysql_error());
$row_asignatura7 = mysql_fetch_assoc($asignatura7);
$totalRows_asignatura7 = mysql_num_rows($asignatura7);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura8 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura8 = mysql_query($query_asignatura8, $sistemacol) or die(mysql_error());
$row_asignatura8 = mysql_fetch_assoc($asignatura8);
$totalRows_asignatura8 = mysql_num_rows($asignatura8);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura9 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura9 = mysql_query($query_asignatura9, $sistemacol) or die(mysql_error());
$row_asignatura9 = mysql_fetch_assoc($asignatura9);
$totalRows_asignatura9 = mysql_num_rows($asignatura9);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura10 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura10 = mysql_query($query_asignatura10, $sistemacol) or die(mysql_error());
$row_asignatura10 = mysql_fetch_assoc($asignatura10);
$totalRows_asignatura10 = mysql_num_rows($asignatura10);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura11 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura11 = mysql_query($query_asignatura11, $sistemacol) or die(mysql_error());
$row_asignatura11 = mysql_fetch_assoc($asignatura11);
$totalRows_asignatura11 = mysql_num_rows($asignatura11);

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura12 = sprintf("SELECT * FROM jos_asignatura_nombre ORDER BY nombre ASC");
$asignatura12 = mysql_query($query_asignatura12, $sistemacol) or die(mysql_error());
$row_asignatura12 = mysql_fetch_assoc($asignatura12);
$totalRows_asignatura12 = mysql_num_rows($asignatura12);
// FIN CONSULTA ASIGNATURAS

//CONSULTA CURSOS
mysql_select_db($database_sistemacol, $sistemacol);
$query_curso1 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso1 = mysql_query($query_curso1, $sistemacol) or die(mysql_error());
$row_curso1 = mysql_fetch_assoc($curso1);
$totalRows_curso1 = mysql_num_rows($curso1);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso2 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso2 = mysql_query($query_curso2, $sistemacol) or die(mysql_error());
$row_curso2 = mysql_fetch_assoc($curso2);
$totalRows_curso2 = mysql_num_rows($curso2);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso3 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso3 = mysql_query($query_curso3, $sistemacol) or die(mysql_error());
$row_curso3 = mysql_fetch_assoc($curso3);
$totalRows_curso3 = mysql_num_rows($curso3);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso4 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso4 = mysql_query($query_curso4, $sistemacol) or die(mysql_error());
$row_curso4 = mysql_fetch_assoc($curso4);
$totalRows_curso4 = mysql_num_rows($curso4);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso5 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso5 = mysql_query($query_curso5, $sistemacol) or die(mysql_error());
$row_curso5 = mysql_fetch_assoc($curso5);
$totalRows_curso5 = mysql_num_rows($curso5);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso6 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso6 = mysql_query($query_curso6, $sistemacol) or die(mysql_error());
$row_curso6 = mysql_fetch_assoc($curso6);
$totalRows_curso6 = mysql_num_rows($curso6);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso7 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso7 = mysql_query($query_curso7, $sistemacol) or die(mysql_error());
$row_curso7 = mysql_fetch_assoc($curso7);
$totalRows_curso7 = mysql_num_rows($curso7);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso8 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso8 = mysql_query($query_curso8, $sistemacol) or die(mysql_error());
$row_curso8 = mysql_fetch_assoc($curso8);
$totalRows_curso8 = mysql_num_rows($curso8);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso9 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso9 = mysql_query($query_curso9, $sistemacol) or die(mysql_error());
$row_curso9 = mysql_fetch_assoc($curso9);
$totalRows_curso9 = mysql_num_rows($curso9);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso10 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso10 = mysql_query($query_curso10, $sistemacol) or die(mysql_error());
$row_curso10 = mysql_fetch_assoc($curso10);
$totalRows_curso10 = mysql_num_rows($curso10);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso11 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso11 = mysql_query($query_curso11, $sistemacol) or die(mysql_error());
$row_curso11 = mysql_fetch_assoc($curso11);
$totalRows_curso11 = mysql_num_rows($curso11);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso12 = sprintf("SELECT a.id, b.nombre, c.descripcion FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id ORDER BY b.numero_anio, c.id ASC");
$curso12 = mysql_query($query_curso12, $sistemacol) or die(mysql_error());
$row_curso12 = mysql_fetch_assoc($curso12);
$totalRows_curso12 = mysql_num_rows($curso12);


// FIN CONSULTA CURSOS


// INSERTAR ASOCIACIONES


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$total=$_POST["total"];

$i = 0;
do { 
   $i++;


if($_POST['asignatura_id'.$i]==!NULL){

 
  $insertSQL = sprintf("INSERT INTO jos_asignatura (tipo_asignatura, orden_asignatura, docente_id, curso_id, periodo, asignatura_nombre_id) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['tipo_asignatura'.$i], "text"),
                       GetSQLValueString($_POST['orden_asignatura'.$i], "int"),
                       GetSQLValueString($_POST['docente_id'], "int"),
                       GetSQLValueString($_POST['curso_id'.$i], "int"),
                       GetSQLValueString($_POST['periodo_id'], "int"),
                       GetSQLValueString($_POST['asignatura_id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

} while ($i+1 <= $total );
 
  $insertGoTo = "admin_asignatura_docente.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}

//FIN CONSULTA

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
<table width="650" border="0">

  <tr>
       <td  colspan="2"><span style="font-size:16px">ASOCIAR ASIGNATURAS A:</span> &nbsp;<span class="texto_mediano_gris"><b><?php echo $row_docente['nombre_docente']." ".$row_docente['apellido_docente'];?></b></span> </td>
      </tr>

<tr><td>

<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">
		
                <td width="100" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">&nbsp;Asignatura&nbsp;</span></div></td>
		<td width="60" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">A&ntilde;o y Secci&oacute;n</span></div></td>
                <td width="80" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Tipo de <br />Asignatura</span></div></td>
                <td width="50" class="textogrande_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris">Orden</span></div></td>


              </tr>
              <?php $i=1; do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3">
		<?php if ($i==1) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura1['id']; ?>"><?php echo $row_asignatura1['nombre']; ?></option>
		<?php } while ($row_asignatura1 = mysql_fetch_assoc($asignatura1)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==2) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura2['id']; ?>"><?php echo $row_asignatura2['nombre']; ?></option>
		<?php } while ($row_asignatura2 = mysql_fetch_assoc($asignatura2)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==3) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura3['id']; ?>"><?php echo $row_asignatura3['nombre']; ?></option>
		<?php } while ($row_asignatura3 = mysql_fetch_assoc($asignatura3)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==4) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura4['id']; ?>"><?php echo $row_asignatura4['nombre']; ?></option>
		<?php } while ($row_asignatura4 = mysql_fetch_assoc($asignatura4)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==5) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura5['id']; ?>"><?php echo $row_asignatura5['nombre']; ?></option>
		<?php } while ($row_asignatura5 = mysql_fetch_assoc($asignatura5)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==6) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura6['id']; ?>"><?php echo $row_asignatura6['nombre']; ?></option>
		<?php } while ($row_asignatura6 = mysql_fetch_assoc($asignatura6)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==7) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura7['id']; ?>"><?php echo $row_asignatura7['nombre']; ?></option>
		<?php } while ($row_asignatura7 = mysql_fetch_assoc($asignatura7)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==8) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura8['id']; ?>"><?php echo $row_asignatura8['nombre']; ?></option>
		<?php } while ($row_asignatura8 = mysql_fetch_assoc($asignatura8)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==9) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura9['id']; ?>"><?php echo $row_asignatura9['nombre']; ?></option>
		<?php } while ($row_asignatura9 = mysql_fetch_assoc($asignatura9)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==10) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura10['id']; ?>"><?php echo $row_asignatura10['nombre']; ?></option>
		<?php } while ($row_asignatura10 = mysql_fetch_assoc($asignatura10)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==11) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura11['id']; ?>"><?php echo $row_asignatura11['nombre']; ?></option>
		<?php } while ($row_asignatura11 = mysql_fetch_assoc($asignatura11)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==12) { ?>
		<select name="<?php echo 'asignatura_id'.$i;?>" id="<?php echo 'asignatura_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_asignatura12['id']; ?>"><?php echo $row_asignatura12['nombre']; ?></option>
		<?php } while ($row_asignatura12 = mysql_fetch_assoc($asignatura12)); ?>
		</select>
 	<?php } ?>
		
		
		</span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3">
		
	<?php if ($i==1) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso1['id']; ?>"><?php echo $row_curso1['nombre']." ".$row_curso1['descripcion']; ?></option>
		<?php } while ($row_curso1 = mysql_fetch_assoc($curso1)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==2) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso2['id']; ?>"><?php echo $row_curso2['nombre']." ".$row_curso2['descripcion']; ?></option>
		<?php } while ($row_curso2 = mysql_fetch_assoc($curso2)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==3) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso3['id']; ?>"><?php echo $row_curso3['nombre']." ".$row_curso3['descripcion']; ?></option>
		<?php } while ($row_curso3 = mysql_fetch_assoc($curso3)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==4) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso4['id']; ?>"><?php echo $row_curso4['nombre']." ".$row_curso4['descripcion']; ?></option>
		<?php } while ($row_curso4 = mysql_fetch_assoc($curso4)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==5) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso5['id']; ?>"><?php echo $row_curso5['nombre']." ".$row_curso5['descripcion']; ?></option>
		<?php } while ($row_curso5 = mysql_fetch_assoc($curso5)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==6) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso6['id']; ?>"><?php echo $row_curso6['nombre']." ".$row_curso6['descripcion']; ?></option>
		<?php } while ($row_curso6 = mysql_fetch_assoc($curso6)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==7) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso7['id']; ?>"><?php echo $row_curso7['nombre']." ".$row_curso7['descripcion']; ?></option>
		<?php } while ($row_curso7 = mysql_fetch_assoc($curso7)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==8) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso8['id']; ?>"><?php echo $row_curso8['nombre']." ".$row_curso8['descripcion']; ?></option>
		<?php } while ($row_curso8 = mysql_fetch_assoc($curso8)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==9) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso9['id']; ?>"><?php echo $row_curso9['nombre']." ".$row_curso9['descripcion']; ?></option>
		<?php } while ($row_curso9 = mysql_fetch_assoc($curso9)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==10) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso10['id']; ?>"><?php echo $row_curso10['nombre']." ".$row_curso10['descripcion']; ?></option>
		<?php } while ($row_curso10 = mysql_fetch_assoc($curso10)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==11) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso11['id']; ?>"><?php echo $row_curso11['nombre']." ".$row_curso11['descripcion']; ?></option>
		<?php } while ($row_curso11 = mysql_fetch_assoc($curso11)); ?>
		</select>
 	<?php } ?>
 	<?php if ($i==12) { ?>
		<select name="<?php echo 'curso_id'.$i;?>" id="<?php echo 'curso_id'.$i;?>">
		<option value="">***</option>
		<?php
		do { ?>

		<option value="<?php echo $row_curso12['id']; ?>"><?php echo $row_curso12['nombre']." ".$row_curso12['descripcion']; ?></option>
		<?php } while ($row_curso12 = mysql_fetch_assoc($curso12)); ?>
		</select>
 	<?php } ?>
 	
		
		</span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris3">
			     <select name="<?php echo 'tipo_asignatura'.$i;?>" id="<?php echo 'tipo_asignatura'.$i;?>">

			     <option value="">Normal</option>
			     <option value="educacion_trabajo">Educaci&oacute;n para el Trabajo</option>
			     <option value="premilitar">Pre-Militar</option>
			     <option value="primaria">Primaria</option>
			     </select>
             </span></div></td>
		<td height="26" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_mediano_gris"><input name="<?php echo 'orden_asignatura'.$i;?>" id="<?php echo 'orden_asignatura'.$i;?>" value="" size="3"/></span></div></td>



                
              </tr>
              <?php $i++;} while ($i<=12); ?>
            </table>
           Verifica los Datos y Presiona una sola vez Click.. 
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Asociar Asignaturas" style="font-size:16px;"/>


		<input type="hidden" name="total"  id="total" value="12" >
		<input type="hidden" name="docente_id" value="<?php echo $row_docente['id'];?>">
		<input type="hidden" name="periodo_id" value="<?php echo $row_periodo['id'];?>">
		<input type="hidden" name="MM_insert" value="form">

</form>
            
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
mysql_free_result($docente);
mysql_free_result($colegio);
?>
