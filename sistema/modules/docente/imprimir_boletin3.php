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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jos_formato_nota_descriptiva_bol01 (id_boletin_descriptiva, alumno_id, descripcion, lapso, nom_mate_pendiente, nota_mate_pendiente) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_boletin_descriptiva'], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['lapso'], "int"),
                       GetSQLValueString($_POST['nom_mate_pendiente'], "text"),
                       GetSQLValueString($_POST['nota_mate_pendiente'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "imprimir_boletin2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE jos_formato_nota_descriptiva_bol01 SET alumno_id=%s, descripcion=%s,  lapso=%s, nom_mate_pendiente=%s, nota_mate_pendiente=%s WHERE id_boletin_descriptiva=%s",
                       GetSQLValueString($_POST['alumno_id'], "int"),
		       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['lapso'], "int"),
                       GetSQLValueString($_POST['nom_mate_pendiente'], "text"),
                       GetSQLValueString($_POST['nota_mate_pendiente'], "int"),
                       GetSQLValueString($_POST['id_boletin_descriptiva'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "imprimir_boletin2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


$colname_alumno = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_alumno = $_GET['alumno_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_alumno_info a, jos_alumno_curso b WHERE a.alumno_id=b.alumno_id AND a.alumno_id = %s ORDER BY cedula ASC", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);


$colname_boletin_descriptivo = "-1";
if (isset($_GET['alumno_id'])) {
  $colname_boletin_descriptivo = $_GET['alumno_id'];
}
$lap_boletin_descriptivo = "-1";
if (isset($_GET['lapso'])) {
  $lap_boletin_descriptivo = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_boletin_descriptivo = sprintf("SELECT * FROM jos_formato_nota_descriptiva_bol01 WHERE alumno_id = %s AND lapso=%s", GetSQLValueString($colname_boletin_descriptivo, "int"), GetSQLValueString($lap_boletin_descriptivo, "int"));
$boletin_descriptivo = mysql_query($query_boletin_descriptivo, $sistemacol) or die(mysql_error());
$row_boletin_descriptivo = mysql_fetch_assoc($boletin_descriptivo);
$totalRows_boletin_descriptivo = mysql_num_rows($boletin_descriptivo);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso_encurso = "SELECT * FROM jos_lapso_encurso";
$lapso_encurso = mysql_query($query_lapso_encurso, $sistemacol) or die(mysql_error());
$row_lapso_encurso = mysql_fetch_assoc($lapso_encurso);
$totalRows_lapso_encurso = mysql_num_rows($lapso_encurso);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>:: SISTEMA COLEGIONLINE::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckeditor/adapters/jquery.js"></script>


<?php
// Include the CKEditor class.
include("../ckeditor/ckeditor.php");

// Create a class instance.
$CKEditor = new CKEditor();

// Path to the CKEditor directory.
$CKEditor->basePath = '/ckeditor/';

// Replace all textarea elements with CKEditor.
$CKEditor->replaceAll();
?>

</head>
<center>
<body>
<table width="720" border="0" align="center">
  <tr>
    <td width="770"><div align="left"><span class="textogrande_eloy"><a href="imprimir_boletin2.php?curso_id=<?php echo $row_alumno['curso_id']; ?>&lapso=<?php echo $_GET['lapso']; ?>" class="cartelera_eloy"><img src="../../images/gif/1rrow4.gif" width="25" height="25" border="0" align="absmiddle">Volver Atr&aacute;s </a></span></div></td>
  </tr>
  <tr>
    <td><div align="center" class="titulo_extragrande_gris"><br>
    Informe Descriptivo de:   <br>
    <span class="titulo_extramediano_gris"><?php echo $row_alumno['apellido']; ?>,</span><span class="titulo_extramediano_gris">   <?php echo $row_alumno['nombre']; ?></span></div></td>
  </tr>
  <tr>
    <td align="center"><?php if ($totalRows_boletin_descriptivo == 0) { // Show if recordset empty ?>
  <table width="720" border="0">
    <tr>
      <td><form method="post" name="form1" action="<?php echo $editFormAction; ?>&curso_id=<?php echo $row_alumno['curso_id']; ?>&lapso=<?php echo $_GET['lapso']; ?>">
        <table width="720" align="center">
          <tr valign="baseline">
            <td height="25" align="center">
<TEXTAREA class="ckeditor" COLS=50 ROWS=3 name="descripcion"  id="descripcion"><?php echo $row_boletin_descriptivo['descripcion']; ?></TEXTAREA>

</td>
            </tr>
          </table>
        <center>
          <fieldset style="width:450px; background-color:#FFC">
            <legend class="texto_pequeno_gris">Información de Materia Pendiente</legend>
            <table width="450" border="0" align="center">
              <tr valign="baseline">
                <td align="right" nowrap class="texto_mediano_gris">Nombre materia pendiente:</td>
                <td><input type="text" name="nom_mate_pendiente" value="" size="32"></td>
                </tr>
              <tr valign="baseline">
                <td align="right" nowrap class="texto_mediano_gris">Calificaci&oacute;n:</td>
                <td><input type="text" name="nota_mate_pendiente" value="" size="5"></td>
                </tr>
              </table>
            </fieldset>
          </center>
        <table width="720" border="0" align="center">
          <tr valign="baseline">
            <td align="center"><br>                  <input type="submit" value="Agregar Informe&gt;&gt;"> <label>
                <input type="button" name="button" id="button" value="Cancelar" onClick="window.location.href='imprimir_boletin2.php?curso_id=<?php echo $row_alumno['curso_id']; ?>';">
            </label></td>
            </tr>
          </table>
        <input type="hidden" name="id_boletin_descriptiva" value="">
        <input type="hidden" name="alumno_id" value="<?php echo $row_alumno['alumno_id']; ?>">
        <input type="hidden" name="lapso" value="<?php echo $_GET['lapso']; ?>">
        <input type="hidden" name="MM_insert" value="form1">
        </form></td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>      <br></td>
  </tr>
  <tr>
    <td align="center"><?php if ($totalRows_boletin_descriptivo > 0) { // Show if recordset not empty ?>
        <table width="720" border="0">
          <tr>
            <td><form method="POST" name="form2" action="<?php echo $editFormAction; ?>&curso_id=<?php echo $row_alumno['curso_id']; ?>&lapso=<?php echo $_GET['lapso']; ?>">
              <table width="720" align="center">
                <tr valign="baseline">
                  <td height="25" align="center">
                  <TEXTAREA class="ckeditor" COLS=50 ROWS=3 name="descripcion"  id="descripcion"><?php echo $row_boletin_descriptivo['descripcion']; ?></TEXTAREA>  

		</td>
                </tr>
              </table>
              <center>
                <fieldset style="width:450px; background-color:#FFC">
                  <legend class="texto_pequeno_gris">Informaci&oacute;n de Materia Pendiente</legend>
                  <table width="450" border="0" align="center">
                    <tr valign="baseline">
                      <td align="right" nowrap class="texto_mediano_gris">Nombre materia pendiente:</td>
                      <td><input name="nom_mate_pendiente" type="text" id="nom_mate_pendiente" value="<?php echo $row_boletin_descriptivo['nom_mate_pendiente']; ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap class="texto_mediano_gris">Calificaci&oacute;n:</td>
                      <td><input name="nota_mate_pendiente" type="text" id="nota_mate_pendiente" value="<?php echo $row_boletin_descriptivo['nota_mate_pendiente']; ?>" size="5"></td>
                    </tr>
                  </table>
                </fieldset>
              </center>
              <table width="720" border="0" align="center">
                <tr valign="baseline">
                  <td align="center"><br>
                    <input type="submit" value="Modificar Informe&gt;&gt;"> <input type="button" name="button2" id="button2" value="Cancelar" onClick="window.location.href='imprimir_boletin2.php?curso_id=<?php echo $row_alumno['curso_id']; ?>&lapso=<?php echo $_GET['lapso']; ?>';"></td>
                </tr>
              </table>
              <input name="id_boletin_descriptiva" type="hidden" id="id_boletin_descriptiva" value="<?php echo $row_boletin_descriptivo['id_boletin_descriptiva']; ?>">
              <input name="alumno_id" type="hidden" id="alumno_id" value="<?php echo $row_boletin_descriptivo['alumno_id']; ?>">
              <input name="lapso" type="hidden" id="lapso" value="<?php echo $row_boletin_descriptivo['lapso']; ?>">
              <input type="hidden" name="MM_update" value="form2">
            </form></td>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?></td>
  </tr>
</table>
</body>
</html>
<?php

mysql_free_result($alumno);

mysql_free_result($boletin_descriptivo);

mysql_free_result($lapso_encurso);
?>
