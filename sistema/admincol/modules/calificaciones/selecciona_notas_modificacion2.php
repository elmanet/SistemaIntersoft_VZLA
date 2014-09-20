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

$colname_alumno = "-1";
if (isset($_POST['curso_id'])) {
  $colname_alumno = $_POST['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno= sprintf("SELECT * FROM jos_alumno_info a, jos_alumno_curso b WHERE a.alumno_id=b.alumno_id AND b.curso_id=%s ORDER BY  a.apellido ASC", GetSQLValueString($colname_alumno, "int"));
$alumno= mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno= mysql_fetch_assoc($alumno);
$totalRows_alumno= mysql_num_rows($alumno);

$colname_curso = "-1";
if (isset($_POST['curso_id'])) {
  $colname_curso = $_POST['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_curso= sprintf("SELECT a.id as mate, b.nombre FROM jos_asignatura a, jos_asignatura_nombre b WHERE a.asignatura_nombre_id=b.id AND a.curso_id=%s ORDER BY a.orden_asignatura ASC", GetSQLValueString($colname_curso, "int"));
$curso= mysql_query($query_curso, $sistemacol) or die(mysql_error());
$row_curso= mysql_fetch_assoc($curso);
$totalRows_curso= mysql_num_rows($curso);

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

        <h2><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Modificar de Calificaci&oacute;n!</h2>
        <h3><b>Paso 2. </b></h3><span class="texto_grande_gris">Selecciona el estudiante y la Asignatura... </span><br /><br />
	<form action="modificar_notas_<?php echo $row_confi['codfor'];?>.php" method="POST" name="f1" >
	</td></tr><tr><td><img src="../../images/gif/construccion-plantilla.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<select name="alumno_id" class="texto_mediano_gris" id="alumno_id">
         <option value="">..Selecciona el Estudiante</option>
           <?php do { ?>
              <option value="<?php echo $row_alumno['alumno_id']; ?>"><?php echo $row_alumno['apellido']."  ".$row_alumno['nombre']; ?></option>
           <?php } while ($row_alumno= mysql_fetch_assoc($alumno));
  	   $rows = mysql_num_rows($alumno);
  	   if($rows > 0) {
           mysql_data_seek($alumno, 0);
	  $row_alumno= mysql_fetch_assoc($alumno);
		 }
	   ?>
         </select>
            </td></tr>
  <tr><td>
        <img src="../../images/gif/construccion-plantilla.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<select name="asignatura_id" class="texto_mediano_gris" id="asignatura_id">
         <option value="">..Selecciona la Asignatura</option>
           <?php do { ?>
              <option value="<?php echo $row_curso['mate']; ?>"><?php echo $row_curso['nombre']; ?></option>
           <?php } while ($row_curso= mysql_fetch_assoc($curso));
  	   $rows = mysql_num_rows($curso);
  	   if($rows > 0) {
           mysql_data_seek($curso, 0);
	  $row_curso= mysql_fetch_assoc($curso);
		 }
	   ?>
         </select>
 </td></tr>
  <tr><td style="padding-top: 15px;">
          <span class="texto_mediano_gris">Clave del Supervisor:</span>
      </td></tr>
  <tr><td>
          <input type="password" id="pass" name="pass" value=""/>

	<input type="hidden" name="lapso" id="lapso" value="<?php echo $_POST['lap']; ?>" />
	<input type="submit" name="buttom" value="Buscar >" />
	</td></tr>
	<tr><td>
		
	</td></tr>
	</form>
<tr><td>
&nbsp;&nbsp;
</td></tr>
    </table>
</body>
</center>
</html>
<?php

mysql_free_result($alumno);

mysql_free_result($confi);

mysql_free_result($lapso);

?>
