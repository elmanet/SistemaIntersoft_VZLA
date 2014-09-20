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

// 	GRABADO EN LA TABLA DE ALUMNO_CURSO

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

   $updateSQL = sprintf("UPDATE jos_alumno_curso  SET no_lista=%s, curso_id=%s, alumno_id=%s WHERE id=%s",
                       GetSQLValueString($_POST['no_lista'], "int"),
                       GetSQLValueString($_POST['curso_id'], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());
 

 $updateGoTo = "modificar_alumno_03.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $updateGoTo));
}




$colname_reporte = "-1";
if (isset($_GET['cedula'])) {
  $colname_reporte = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT alumno_id, nombre, apellido  FROM jos_alumno_info WHERE cedula= %s" , GetSQLValueString($colname_reporte, "biginit"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

$colname_curso = "-1";
if (isset($_GET['cedula'])) {
  $colname_curso = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_curso = sprintf("SELECT a.alumno_id, a.cedula, b.alumno_id, b.no_lista, b.id FROM jos_alumno_info a, jos_alumno_curso b WHERE a.alumno_id=b.alumno_id AND cedula= %s" , GetSQLValueString($colname_curso, "bigint"));
$curso = mysql_query($query_curso, $sistemacol) or die(mysql_error());
$row_curso = mysql_fetch_assoc($curso);
$totalRows_curso = mysql_num_rows($curso);

mysql_select_db($database_sistemacol, $sistemacol);
$query_seccion = sprintf("SELECT a.id, c.nombre, b.descripcion FROM jos_curso a, jos_seccion b, jos_anio_nombre c WHERE a.seccion_id=b.id AND a.anio_id=c.id ORDER BY c.nombre ASC");
$seccion = mysql_query($query_seccion, $sistemacol) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SISTEMA COLEGIONLINE |</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top"><h2>Cambiar Estudiante de Secci&oacute;n</h2></td></tr>
	<tr>	
	<td>
	<?php if ($totalRows_reporte>0){ ?>
	<?php if ($totalRows_curso>0){ ?>
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form">
	<span class="texto_mediano_grisclaro">Nombre del Estudiante:</span>	
	<span class="texto_mediano_gris"><b><?php echo $row_reporte['apellido']." ".$row_reporte['nombre']; ?> </b></span>

	</td>
	</tr>
	<tr>
	<td>
	<span class="texto_mediano_grisclaro">A&ntilde;o y seccion:</span>
	<select name="curso_id" class="texto_mediano_gris" id="curso_id">
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
	<span class="texto_mediano_grisclaro">No. Lista:</span>	
	<input type="text" name="no_lista" value="<?php echo $row_curso['no_lista']; ?>" size="3" maxlength="2"/>
	<input type="submit" name="buttom" value="Asignar Estudiante >" />
	</td>
	</tr>
	<tr><td>
	<input type="hidden" name="id" value="<?php echo $row_curso['id']; ?>" />

	<input type="hidden" name="alumno_id" value="<?php echo $row_curso['alumno_id']; ?>" />
	<input type="hidden" name="cursando" value="1" />
	
	</td></tr>
	<input type="hidden" name="MM_insert" value="form">
	</form>
	<?php  } ?>
	<?php  } ?>

	
	<?php if ($totalRows_curso==0){?>
	<span class="texto_mediano_gris"><b> <?php echo $row_reporte['nombre']; ?>, NO HA SIDO ASIGNADO A UNA SECCION...</b></span>
	<br><br>	
	<span class="texto_mediano_gris"><a href="asignar_alumno_01.php"><---Volver Atras</a></span>
	<?php }?>	
	
	<?php if ($totalRows_reporte==0){ ?>
	 <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... Estudiante no registrado!</span><br>
                <br>
             <span class="texto_mediano_gris"><a href="asignar_alumno_01.php"><---Volver Atras</a></span><br>
            </div></td>
          </tr>

        </table>
	<?php }?>
</td>
</tr>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);
mysql_free_result($curso);
mysql_free_result($seccion);
?>
