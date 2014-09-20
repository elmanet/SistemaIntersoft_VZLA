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

$confip=$row_confi['codfor'];

$colname_mate = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_mate = $_GET['asignatura_id'];
}
$lap_mate = "-1";
if (isset($_GET['lapso'])) {
  $lap_mate = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id= %s AND lapso= %s", GetSQLValueString($colname_mate, "int"), GetSQLValueString($lap_mate, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);

$colname_cedula = "-1";
if (isset($_GET['cedula'])) {
  $colname_cedula = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT alumno_id, nombre, apellido, cedula FROM jos_alumno_info WHERE cedula= %s", GetSQLValueString($colname_cedula, "bigint"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

$alum_alumno_notas = "-1";
if (isset($_GET['cedula'])) {
  $alum_alumno_notas = $_GET['cedula'];
}
$colname_alumno_notas = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_alumno_notas = $_GET['asignatura_id'];
}
$lap_alumno_notas = "-1";
if (isset($_GET['lapso'])) {
  $lap_alumno_notas = $_GET['lapso'];
}

if ($confip=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notas = sprintf("SELECT * FROM jos_alumno_info a, jos_formato_evaluacion_bol01 b WHERE a.alumno_id=b.alumno_id AND a.cedula= %s AND b.asignatura_id= %s AND b.lapso= %s ", GetSQLValueString($alum_alumno_notas, "bigint"), GetSQLValueString($colname_alumno_notas, "int"), GetSQLValueString($lap_alumno_notas, "int"));
$alumno_notas = mysql_query($query_alumno_notas, $sistemacol) or die(mysql_error());
$row_alumno_notas = mysql_fetch_assoc($alumno_notas);
$totalRows_alumno_notas = mysql_num_rows($alumno_notas);
}
if ($confip=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notas = sprintf("SELECT * FROM jos_alumno_info a, jos_formato_evaluacion_bol02 b WHERE a.alumno_id=b.alumno_id AND a.cedula= %s AND b.asignatura_id= %s AND b.lapso= %s ", GetSQLValueString($alum_alumno_notas, "bigint"), GetSQLValueString($colname_alumno_notas, "int"), GetSQLValueString($lap_alumno_notas, "int"));
$alumno_notas = mysql_query($query_alumno_notas, $sistemacol) or die(mysql_error());
$row_alumno_notas = mysql_fetch_assoc($alumno_notas);
$totalRows_alumno_notas = mysql_num_rows($alumno_notas);
}
if ($confip=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notas = sprintf("SELECT * FROM jos_alumno_info a, jos_formato_evaluacion_nor01 b WHERE a.alumno_id=b.alumno_id AND a.cedula= %s AND b.asignatura_id= %s AND b.lapso= %s ", GetSQLValueString($alum_alumno_notas, "bigint"), GetSQLValueString($colname_alumno_notas, "int"), GetSQLValueString($lap_alumno_notas, "int"));
$alumno_notas = mysql_query($query_alumno_notas, $sistemacol) or die(mysql_error());
$row_alumno_notas = mysql_fetch_assoc($alumno_notas);
$totalRows_alumno_notas = mysql_num_rows($alumno_notas);
}
if ($confip=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_notas = sprintf("SELECT * FROM jos_alumno_info a, jos_formato_evaluacion_nor02 b WHERE a.alumno_id=b.alumno_id AND a.cedula= %s AND b.asignatura_id= %s AND b.lapso= %s ", GetSQLValueString($alum_alumno_notas, "bigint"), GetSQLValueString($colname_alumno_notas, "int"), GetSQLValueString($lap_alumno_notas, "int"));
$alumno_notas = mysql_query($query_alumno_notas, $sistemacol) or die(mysql_error());
$row_alumno_notas = mysql_fetch_assoc($alumno_notas);
$totalRows_alumno_notas = mysql_num_rows($alumno_notas);
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso ");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id  FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id ORDER BY d.nombre, c.id, f.descripcion ASC", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_form")) {

    // formato bol01
    if ($confip=="bol01"){
    $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_bol01 (id, alumno_id, asignatura_id, confiplanilla_id, lapso) VALUES (%s, %s, %s, %s, %s)",

                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($_POST['alumno_id'], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));
    }
// formato bol02
        if ($confip=="bol02"){
    $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_bol02 (id, alumno_id, asignatura_id, confiplanilla_id, lapso) VALUES (%s, %s, %s, %s, %s)",

                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($_POST['alumno_id'], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));
    }

    // formato nor01
        if ($confip=="nor01"){
    $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_nor01 (id, alumno_id, asignatura_id, confiplanilla_id, lapso) VALUES (%s, %s, %s, %s, %s)",

                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($_POST['alumno_id'], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));
    }
    // formato nor02
        if ($confip=="nor02"){
    $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_nor02 (id, alumno_id, asignatura_id, confiplanilla_id, lapso) VALUES (%s, %s, %s, %s, %s)",

                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($_POST['alumno_id'], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));
    }

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "selecciona_estudiante.php";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Agregar Estudiante a N&oacute;mina de Calificaciones!</h2>
	<h3>Selecciona todos los datos siguientes... </h3>
	
	</td></tr><tr><td>
       <?php if(($totalRows_alumno_notas==0)){?>
       <?php if(($totalRows_alumno>0)){?>
                <table class="texto_mediano_gris">
                    <tr>
                        <td><b>Apellidos y Nombre del Estudiante:</b></td>
                        <td><?php echo $row_alumno['apellido'].", ".$row_alumno['nombre'];?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h3>Informaci&oacute;n General</h3></td>
                    </tr>
                <tr>
                    <td align="right"><b>Id del Estudiante:</b></td>
                    <td><?php echo $row_alumno['alumno_id'];?></td>
                </tr>
                <tr>
                    <td align="right"><b>Asignatura:</b></td>
                    <td><?php echo $_GET['asignatura_id'];?></td>
                </tr>
                    <tr>
                        <td align="right"><b>Planilla de Configuraci&oacute;n:</b></td>
                    <td><?php echo $row_confiplanilla['id'];?></td>
                </tr>
                 <tr>
                    <td align="right"><b>Lapso:</b></td>
                    <td><?php echo $_GET['lapso'];?></td>
                </tr>
                <tr>
                    
                    <td colspan="2" align="center">
                        <form action="<?php echo $editFormAction; ?>" name="new_form" id="new_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
                            <input type="hidden" name="id" id="id" value=""/>
                            <input type="hidden" name="alumno_id" id="alumno_id" value="<?php echo $row_alumno['alumno_id'];?>"/>
                            <input type="hidden" name="asignatura_id" id="asignatura_id" value="<?php echo $_GET['asignatura_id'];?>"/>
                            <input type="hidden" name="confiplanilla_id" id="confiplanilla_id" value="<?php echo $row_confiplanilla['id'];?>"/>
                            <input type="hidden" name="lapso" id="lapso" value="<?php echo $_GET['lapso'];?>"/>
                            <input name="boton" type="submit" value="Grabar Datos"/>
                            <input type="hidden" name="MM_insert" value="new_form"/>
                        </form>

                    </td>
                </tr>
                </table>


        <?php }else{?>
        No es posible asignar El Estudiante no esta Registrado!
        <?php }?>
	<?php }else{ ?>
	Este Estudiante ya esta agregado a esta nomina!
	<?php }?>
	</td></tr>
	<tr><td>
		
	</td></tr>

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
mysql_free_result($confiplanilla);

mysql_free_result($lapso);

mysql_free_result($alumno);
mysql_free_result($alumno_notas);

?>
