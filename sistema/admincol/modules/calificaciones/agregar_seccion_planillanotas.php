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
//CARGAR PLANILLA DE CONFIGURACION
mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);
$confi=$row_confip['codfor'];

// VERIFICACION DE DATOS
$colname_reporte = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_reporte = $_POST['asignatura_id'];
}
$colname_reporte_lap = "-1";
if (isset($_POST['lapso'])) {
  $colname_reporte_lap = $_POST['lapso'];
}
if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id FROM jos_alumno_info a, jos_formato_evaluacion_bol01 b WHERE a.alumno_id=b.alumno_id AND b.asignatura_id= %s AND b.lapso= %s  ORDER BY a.cedula ASC " , GetSQLValueString($colname_reporte, "int"), GetSQLValueString($colname_reporte_lap, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);
}
if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id FROM jos_alumno_info a, jos_formato_evaluacion_bol02 b WHERE a.alumno_id=b.alumno_id AND b.asignatura_id= %s AND b.lapso= %s  ORDER BY a.cedula ASC " , GetSQLValueString($colname_reporte, "int"), GetSQLValueString($colname_reporte_lap, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);
}
if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id FROM jos_alumno_info a, jos_formato_evaluacion_nor01 b WHERE a.alumno_id=b.alumno_id AND b.asignatura_id= %s AND b.lapso= %s  ORDER BY a.cedula ASC " , GetSQLValueString($colname_reporte, "int"), GetSQLValueString($colname_reporte_lap, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);
}
if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id FROM jos_alumno_info a, jos_formato_evaluacion_nor02 b WHERE a.alumno_id=b.alumno_id AND b.asignatura_id= %s AND b.lapso= %s  ORDER BY a.cedula ASC " , GetSQLValueString($colname_reporte, "int"), GetSQLValueString($colname_reporte_lap, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);
}

// CARGANDO ESTUDIANTES
$colname_alumno= "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_alumno= $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno= sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula,  c.nombre as anio, b.no_lista, e.descripcion, a.alumno_id FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND f.id= %s ORDER BY b.no_lista ASC" , GetSQLValueString($colname_alumno, "int"));
$alumno= mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno= mysql_fetch_assoc($alumno);
$totalRows_alumno= mysql_num_rows($alumno);


mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso = sprintf("SELECT * FROM jos_alumno_curso ");
$curso = mysql_query($query_curso, $sistemacol) or die(mysql_error());
$row_curso = mysql_fetch_assoc($curso);
$totalRows_curso = mysql_num_rows($curso);


// INSERTAR DATOS MULTIPLES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_form")) {
$total=$_POST["totalalum"];
//En este punto establezco la variable $i que me ayudara a contar el numero de veces que se debe ejecutar el do ... while
$i = 0;
do { 
   $i++;

   // PARA EL FORMATO BOL01
	if($confi=="bol01"){

     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_bol01 (id, alumno_id, asignatura_id, lapso) VALUES (%s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
        }

   // PARA EL FORMATO BOL02
	if($confi=="bol02"){

     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_bol02 (id, alumno_id, asignatura_id, lapso) VALUES (%s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
        }

   // PARA EL FORMATO NOR01
	if($confi=="nor01"){

     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_nor01 (id, alumno_id, asignatura_id, lapso) VALUES (%s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
        }

   // PARA EL FORMATO NOR02
	if($confi=="nor02"){

     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_nor02 (id, alumno_id, asignatura_id, lapso) VALUES (%s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
        }

} while ($i+1 <= $total );

  $insertGoTo = "agregar_seccion_planillanotas2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
    
    <?php if ($totalRows_reporte == 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr>

 <td valign="top" align="center" class="texto_mediano_gris" >
<?php // CARGA DE ASIGNACION DE SECCION

?>

<form action="<?php echo $editFormAction; ?>" name="new_form" id="new_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
    <input type="hidden" name="asignatura_id" id="asignatura_id" value="<?php echo $_POST['asignatura_id']; ?>" />
    <input type="hidden" name="lapso" id="lapso" value="<?php echo $_POST['lapso']; ?>" />
<h2 style="color:green;">M&oacute;dulo para cargar Secci&oacute;n a planilla de Calificaciones </h2>
<table width="800" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              
	     
	      <tr bgcolor="#00FF99" class="texto_pequeno_gris">
                <td width="50"><div align="center"><span>No. Lista</span></div></td>
		<td width="50"><div align="center"><span>Cedula</span></div></td>
                <td width="300"><div align="center"><span>Apellidos y Nombres</span></div></td>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_alumno['no_lista']; ?></span></div></td>
		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_alumno['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_alumno['apellido'].", ".$row_alumno['nomalum']; ?></span></div></td>
                 <input type="hidden" name="<?php echo 'alumno_id'.$i;?>" id="<? echo 'alumno_id'.$i;?>" value="<?php echo $row_alumno['alumno_id']; ?>" /></span></div></td>
               

<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >

<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_alumno; ?>" >

</td>
                
              </tr>
              <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>


    <tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar N&oacute;mina">    </td></tr>

            </table>
<?php // FIN CARGA 

?>

<input type="hidden" name="MM_insert" value="new_form">
</form>


<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
<!--FIN INFO CONSULTA -->
</td>

          </tr>
	</table>
		<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_reporte > 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
                  <span class="titulo_grande_gris">Error... Ya existen Estudiantes agregados en esta n&oacute;mina!!</span><span class="texto_mediano_gris"><br>
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

mysql_free_result($alumno);

mysql_free_result($colegio);

mysql_free_result($seccion);

mysql_free_result($curso);

mysql_free_result($docente);

?>
