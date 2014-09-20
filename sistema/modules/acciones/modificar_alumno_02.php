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

$colname_reporte = "-1";
if (isset($_POST['curso_id'])) {
  $colname_reporte = $_POST['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, b.no_lista, d.nombre as anio, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_curso c, jos_anio_nombre d, jos_seccion e WHERE b.curso_id=c.id AND a.alumno_id=b.alumno_id AND c.anio_id=d.id AND c.seccion_id=e.id AND a.cursando=1 AND b.curso_id= %s  ORDER BY b.no_lista ASC " , GetSQLValueString($colname_reporte, "text"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

// MODIFICAR DATOS MULTIPLES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "new_form")) {

$total=$_POST["totalalum"];
//En este punto establezco la variable $i que me ayudara a contar el numero de veces que se debe ejecutar el do ... while
$i = 0;
do { 
   $i++;


      $updateSQL = sprintf("UPDATE jos_alumno_info SET nombre=%s, apellido=%s WHERE alumno_id=%s",
                       GetSQLValueString($_POST['nombre'.$i], "text"),
                       GetSQLValueString($_POST['apellido'.$i], "text"),
                       GetSQLValueString($_POST['alumno_id'.$i], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  header(sprintf("Location: %s", $updateGoTo));
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "new_form")) {

$a = 0;
do { 
   $a++;

      $updateSQL = sprintf("UPDATE jos_alumno_curso SET no_lista=%s WHERE alumno_id=%s",
                       GetSQLValueString($_POST['no_lista'.$a], "text"),
                       GetSQLValueString($_POST['alumno_id'.$a], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($a+1 <= $total );

  $updateGoTo = "modificar_alumno_03.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];

  }
  header(sprintf("Location: %s", $updateGoTo));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

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
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr>

 <td valign="top" align="center" class="texto_mediano_gris" ><h2>N&oacute;mina Estudiantes de <?php echo $row_reporte['anio']." ".$row_reporte['descripcion'];?></h2>

<?php // CARGA DE ASIGNACION DE SECCION

?>

<form action="<?php echo $editFormAction; ?>" name="new_form" id="new_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table width="800" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              
	     
	      <tr bgcolor="#00FF99" class="texto_mediano_gris">

		<td width="50"><div align="center"><span>Cedula</span></div></td>
                <td width="100"><div align="center"><span>Apellidos</span></div></td>
                <td width="100"><div align="center"><span>Nombres</span></div></td>
                <td width="60"><div align="center"><span>No. Lista</span></div></td>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">




		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_reporte['cedula']; ?></span></div></td>
<td style="border-left:1px solid"><div align="center"><span><input type="text" size="35" name="<?php echo 'apellido'.$i;?>" id="<? echo 'apellido'.$i;?>" value="<?php echo $row_reporte['apellido']; ?>" /></span></div>
<td style="border-left:1px solid"><div align="center"><span><input type="text" size="35" name="<?php echo 'nombre'.$i;?>" id="<? echo 'nombre'.$i;?>" value="<?php echo $row_reporte['nomalum']; ?>" /></span></div>

              
<td style="border-left:1px solid"><div align="center"><span><input type="text" size="2" maxlength="2" name="<?php echo 'no_lista'.$i;?>" id="<? echo 'no_lista'.$i;?>" value="<?php echo $row_reporte['no_lista']; ?>" /></span></div> 
<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>" id="<? echo 'alumno_id'.$i;?>" value="<?php echo $row_reporte['alumno_id']; ?>" />
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" >

</td>
                
              </tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Modificar Datos">    </td></tr>

            </table>
<?php // FIN CARGA 

?>

<input type="hidden" name="MM_update" value="new_form">
</form>


<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
<!--FIN INFO CONSULTA -->
</td>

          </tr>
	</table>
		<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_reporte == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen Estudiantes para Asignar!!!</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
    <tr><td>    </td>
</tr>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($seccion);

mysql_free_result($curso);

?>
