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

$colname_periodo = "-1";
if (isset($_POST['periodo_id'])) {
  $colname_periodo = $_POST['periodo_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE id=%s", GetSQLValueString($colname_periodo, "int"));
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);
$periodo=$row_periodo['id'];

$colname_reporte = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_reporte = $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, f.id as asig_id FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND f.id= %s ORDER BY a.apellido ASC" , GetSQLValueString($colname_reporte, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

$colname_planilla = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_planilla = $_POST['asignatura_id'];
}
$periodo_planilla = "-1";
if (isset($_POST['periodo'])) {
  $periodo_planilla = $_POST['periodo'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_pr_certificado a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.periodo_id=%s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($periodo_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);



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

	// FIN CALCULO
     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_pr_certificado (id, alumno_id, asignatura_id, periodo_id, des_cualitativa, def_cualitativa, condicion) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                            GetSQLValueString($_POST['periodo_id'], "int"),
                            GetSQLValueString($_POST['des_cualitativa'.$i], "text"),
                            GetSQLValueString($_POST['def_cualitativa'.$i], "text"),
                            GetSQLValueString($_POST['condicion'.$i], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $insertGoTo = "certificado_primaria2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

// MODIFICAR DATOS MULTIPLES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {
$total=$_POST["totalalum"];
//En este punto establezco la variable $i que me ayudara a contar el numero de veces que se debe ejecutar el do ... while
$i = 0;
do { 
   $i++;


	// FIN CALCULO
     $updateSQL = sprintf("update jos_formato_evaluacion_pr_certificado SET alumno_id=%s, asignatura_id=%s, periodo_id=%s, des_cualitativa=%s, def_cualitativa=%s, condicion=%s WHERE id=%s",
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                            GetSQLValueString($_POST['periodo_id'], "int"),
                            GetSQLValueString($_POST['des_cualitativa'.$i], "text"),
                            GetSQLValueString($_POST['def_cualitativa'.$i], "text"),
                            GetSQLValueString($_POST['condicion'.$i], "text"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $updateGoTo = "certificado_primaria2.php";
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckeditor/adapters/jquery.js"></script>


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
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr><td height="100" valign="top">

<!--INFORMACION DEL COLEGIO -->
		<table width="760"><tr><td>
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>
            	<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="left">
                 	<tr>
                    		<td align="left" valign="bottom" style="font-size:25px"><?php echo $row_colegio['nomcol']; ?></td>
                	</tr>
                	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  	</tr>
                  	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  	</tr>
                  </table>
              	</td>
</td></tr></table>

</td>              
     </tr>     

<!--INFORMACION DE LA CONSULTA  -->
 <td valign="top" align="left" class="texto_mediano_gris" ><h2>Certificado de Estudiantes de <?php echo $row_reporte['anio']." ".$row_reporte['descripcion'];?></h2>

<?php // CARGA DE NOTAS
if($totalRows_planilla>0) { 

// MODIFICACION DE CALIFICACIONES
?>

<form action="<?php echo $editFormAction; ?>" name="modi_form" id="modi_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table width="940" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="100%" height="30"><div align="center"><span class="texto_mediano_gris"><b>Informaci&oacute;n Descriptiva del Estudiante</b></span></div></td>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>



              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center">
<br />
<span><b>C&eacute;dula:</b>&nbsp; <?php echo $row_planilla['cedula']; ?>&nbsp;&nbsp; <b>Apellidos y Nombres:</b>&nbsp; <span style="text-decoration: underline; font-size:12px;"><?php echo $row_planilla['apellido'].", ".$row_planilla['nombre']; ?></span>&nbsp;&nbsp;
<b>Apreciaci&oacute;n Cualitativa:</b>&nbsp;&nbsp; <input name="<?php echo 'def_cualitativa'.$i;?>" type="text" id="<? echo 'def_cualitativa'.$i;?>" value="<?php echo $row_planilla['def_cualitativa']; ?>" style="width: 30px; height: 15px; font-size:9px;" />&nbsp;&nbsp;
<b>Condici&oacute;n:</b>&nbsp;&nbsp; <input name="<?php echo 'condicion'.$i;?>" type="text" id="<? echo 'condicion'.$i;?>" value="<?php echo $row_planilla['condicion']; ?>" style="height: 15px; font-size:9px;" size="20"/><br /><br />

<TEXTAREA class="ckeditor" COLS=50 ROWS=3 name="<? echo 'des_cualitativa'.$i;?>"  id="<? echo 'des_cualitativa'.$i;?>"><?php echo $row_planilla['des_cualitativa']; ?></TEXTAREA>


</span></div></td>






<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="<?php echo $row_planilla['id']; ?>" >

<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" >
<input type="hidden" name="periodo_id"  id="periodo_id" value="<?php echo $_POST['periodo']; ?>" >
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>"  id="<?php echo 'alumno_id'.$i;?>" value="<?php echo $row_planilla['alumno_id']; ?>" >
<input type="hidden" name="<?php echo 'asignatura_id'.$i;?>"  id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_planilla['asignatura_id']; ?>" >



</td>
           



                
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Modificar Certificaciones">    </td></tr>

            </table>
<?php // FIN CARGA DE NOTAS

?>


<input type="hidden" name="MM_update" value="modi_form">
</form>
<?php
}else {
// INSERTAR CALIFICACIONES
?>

<form action="<?php echo $editFormAction; ?>" name="new_form" id="new_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table width="940" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="100%" height="30"><div align="center"><span class="texto_mediano_gris"><b>Informaci&oacute;n Descriptiva del Estudiante</b></span></div></td>
              </tr>

              <?php 
 		$i = 0;
		
		do { $i++;  ?>


              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center">
<br />
<span><b>C&eacute;dula:</b>&nbsp; <?php echo $row_reporte['cedula']; ?>&nbsp;&nbsp; <b>Apellidos y Nombres:</b>&nbsp; <span style="text-decoration: underline; font-size:12px;"><?php echo $row_reporte['apellido'].", ".$row_reporte['nomalum']; ?></span>&nbsp;&nbsp;
<b>Apreciaci&oacute;n Cualitativa:</b>&nbsp;&nbsp; <input name="<?php echo 'def_cualitativa'.$i;?>" type="text" id="<? echo 'def_cualitativa'.$i;?>" value="<?php echo $row_planilla['def_cualitativa']; ?>" style="width: 30px; height: 15px; font-size:9px;" />&nbsp;&nbsp;
<b>Condici&oacute;n:</b>&nbsp;&nbsp; <input name="<?php echo 'condicion'.$i;?>" type="text" id="<? echo 'condicion'.$i;?>" value="<?php echo $row_planilla['condicion']; ?>" style="height: 15px; font-size:9px;" size="20"/><br /><br />

<TEXTAREA class="ckeditor" COLS=50 ROWS=3 name="<? echo 'des_cualitativa'.$i;?>"  id="<? echo 'des_cualitativa'.$i;?>"><?php echo $row_planilla['des_cualitativa']; ?></TEXTAREA>


</span></div></td>

<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" >
<input type="hidden" name="periodo_id"  id="periodo_id" value="<?php echo $_POST['periodo']; ?>" >
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>"  id="<?php echo 'alumno_id'.$i;?>" value="<?php echo $row_reporte['alumno_id']; ?>" >
<input type="hidden" name="<?php echo 'asignatura_id'.$i;?>"  id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_reporte['asig_id']; ?>" >



</td>
           



                
              </tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar Certificaciones">    </td></tr>

            </table>
<?php // FIN CARGA DE NOTAS

?>


<input type="hidden" name="MM_insert" value="new_form">
</form>
<?php } ?>

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
              <span class="titulo_grande_gris">Error... no existen registros en esta area</span><span class="texto_mediano_gris"><br>
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
mysql_free_result($periodo);
mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($planilla);

?>
