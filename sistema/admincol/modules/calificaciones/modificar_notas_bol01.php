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
if (isset($_POST['asignatura_id'])) {
  $colname_reporte = $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, g.nombre as mate, f.id as asig_id FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_asignatura_nombre g WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.asignatura_nombre_id=g.id AND f.curso_id=d.id AND f.id= %s ORDER BY a.cedula ASC" , GetSQLValueString($colname_reporte, "text"));
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
$lap_planilla = "-1";
if (isset($_POST['lapso'])) {
  $lap_planilla = $_POST['lapso'];
}
$alumno_planilla = "-1";
if (isset($_POST['alumno_id'])) {
  $alumno_planilla = $_POST['alumno_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso=%s AND a.alumno_id=%s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"), GetSQLValueString($alumno_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);

$pass_supervisor = "-1";
if (isset($_POST['pass'])) {
  $pass_supervisor = $_POST['pass'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_supervisor = sprintf("SELECT * FROM jos_users_supervisor a, jos_users b WHERE a.user_id=b.id AND a.pass= %s", GetSQLValueString($pass_supervisor, "text"));
$supervisor = mysql_query($query_supervisor, $sistemacol) or die(mysql_error());
$row_supervisor = mysql_fetch_assoc($supervisor);
$totalRows_supervisor = mysql_num_rows($supervisor);

//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_confiplanilla = $_POST['asignatura_id'];
}
$lap_confiplanilla = "-1";
if (isset($_POST['lapso'])) {
  $lap_confiplanilla = $_POST['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s AND lapso = %s", GetSQLValueString($colname_confiplanilla, "int"), GetSQLValueString($lap_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);


// MODIFICAR DATOS MULTIPLES

	$p1f1=$_POST['p1f1'];
	$p1f2=$_POST['p1f2'];
	$p2f1=$_POST['p2f1'];
	$p2f2=$_POST['p2f2'];
	$p3f1=$_POST['p3f1'];
	$p3f2=$_POST['p3f2'];
	$p4f1=$_POST['p4f1'];
	$p4f2=$_POST['p4f2'];
	$po1=$_POST['p1'];
	$po2=$_POST['p2'];
	$po3=$_POST['p3'];
	$po4=$_POST['p4'];
	
	
	if ($p1f2==""){
	$nota1=(($p1f1*$po1)/100);
	}else{
	$nota1=(($p1f2*$po1)/100);
	}
	
	if ($p2f2==""){
	$nota2=(($p2f1*$po2)/100);
	}else{
	$nota2=(($p2f2*$po2)/100);
	}

	if ($p3f2==""){
	$nota3=(($p3f1*$po3)/100);
	}else{
	$nota3=(($p3f2*$po3)/100);
	}

	if ($p4f2==""){
	$nota4=(($p4f1*$po4)/100);
	}else{
	$nota4=(($p4f2*$po4)/100);
	}
	
	$treinta_sc=$_POST['30_sc'];
	$sumapon=($nota1+$nota2+$nota3+$nota4);
	$seten=(($sumapon*70)/100);
	$calpro=$treinta_sc+$seten;
	$def=round($calpro,0);

	if(($calpro>=0) and ($calpro<10)){ $defcuali=1;}
	if(($calpro>9) and ($calpro<14)){ $defcuali=3;}
	if(($calpro>13) and ($calpro<18)){ $defcuali=4;}
	if(($calpro>17) and ($calpro<21)){ $defcuali=5;}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {
	$updateSQL = sprintf("update jos_formato_evaluacion_bol01 SET p1f1=%s, p1f2=%s, p2f1=%s, p2f2=%s, p3f1=%s, p3f2=%s, p4f1=%s, p4f2=%s, sumapon=%s, seten=%s, calpro=%s, def=%s, defcuali=%s WHERE id=%s",
                         
                            GetSQLValueString($p1f1, "double"),
                            GetSQLValueString($p1f2, "double"),
                            GetSQLValueString($p2f1, "double"),
                            GetSQLValueString($p2f2, "double"),
                            GetSQLValueString($p3f1, "double"),
                            GetSQLValueString($p3f2, "double"),
                            GetSQLValueString($p4f1, "double"),
                            GetSQLValueString($p4f2, "double"),

                            GetSQLValueString($sumapon, "double"),
                            GetSQLValueString($seten, "double"),
                            GetSQLValueString($calpro, "double"),
                            GetSQLValueString($def, "int"),
                            GetSQLValueString($defcuali, "int"),

                            GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

 
  
  header(sprintf("Location: %s", $updateGoTo));
}

// INSERCION EN LA TABLA DE AUDITORIA

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {
	$insertSQL = sprintf("INSERT INTO jos_users_auditoria (id, user_id, alumno_id, tipo_cambio, observacion_cambio, motivo_cambio ) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_aud'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['tipo_cambio'], "text"),
                       GetSQLValueString($_POST['observacion_cambio'], "text"),
                       GetSQLValueString($_POST['motivo_cambio'], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "modificar_notas_fin.php";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

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
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    <?php if ($totalRows_supervisor>0){ ?>
    <?php if ($totalRows_planilla > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr>


<!--INFORMACION DE LA CONSULTA  -->
<td valign="top" align="left" class="texto_mediano_gris" ><h3>Modificar de Calificaciones</h3>
  <b>Asignatura:</b> <?php echo $row_reporte['mate'];?> <br />
 <b> Estudiante: </b><?php echo $row_planilla['nombre']." ".$row_planilla['apellido'];?><br />
  <b>Lapso:</b> <?php echo $row_planilla['lapso'];?> Lapso.<br /><br /></td></tr>
  <tr><td>

<?php // CARGA DE NOTAS
if(($_POST['asignatura_id']==$row_planilla['asignatura_id']) and ($_POST['lapso']==$row_planilla['lapso'])) { 

// MODIFICACION DE CALIFICACIONES
?>
<form action="<?php echo $editFormAction; ?>asignatura_id=<?php echo $_POST['asignatura_id']; ?>&lapso=<?php echo $_POST['lapso']; ?>" name="modi_form" id="modi_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

 <span class="texto_mediano_gris">Motivo de la Modificaci&oacute;n: </span><br />
    <span id="sprytextfield4"><input type="text"  size="60" name="motivo_cambio" id="motivo_cambio" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Debes Agregar el Motivo.</span></span>
<br />
<br />

<table width="700" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="texto_mediano_gris">

		<td width="80"><div align="center"><span>N1f1</span></div></td>
                <td width="80"><div align="center"><span>N1f2</span></div></td>
                <td width="80"><div align="center"><span>N2f1</span></div></td>
                <td width="80"><div align="center"><span>N2f2</span></div></td>
                <td width="80"><div align="center"><span>N3f1</span></div></td>
                <td width="80"><div align="center"><span>N3f2</span></div></td>
                <td width="80"><div align="center"><span>N4f1</span></div></td>
                <td width="80"><div align="center"><span>N4f2</span></div></td>


              </tr>


              <?php 
 		
		
		do {   ?>
              <tr bgcolor="#FFFFFF" class="texto_mediano_gris">

                <td style="border-left:1px solid"><div align="center"><span><input name="p1f1" type="text" id="p1f1" value="<?php echo $row_planilla['p1f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="p1f2" type="text" id="p1f2" value="<?php echo $row_planilla['p1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid"><div align="center"><span><input name="p2f1" type="text" id="p2f1" value="<?php echo $row_planilla['p2f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="p2f2" type="text" id="p2f2" value="<?php echo $row_planilla['p2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid"><div align="center"><span><input name="p3f1" type="text" id="p3f1" value="<?php echo $row_planilla['p3f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="p3f2" type="text" id="p3f2" value="<?php echo $row_planilla['p3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid"><div align="center"><span><input name="p4f1" type="text" id="p4f1" value="<?php echo $row_planilla['p4f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="p4f2" type="text" id="p4f2" value="<?php echo $row_planilla['p4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

   

                <input type="hidden" name="id"  id="id" value="<?php echo $row_planilla['id']; ?>" >
		<input type="hidden" name="30_sc"  id="30_sc" value="<?php echo $row_planilla['30_sc']; ?>" >

		<input type="hidden" name="p1"  id="p1" value="<?php echo $row_confiplanilla['p1']; ?>" >
		<input type="hidden" name="p2"  id="p2" value="<?php echo $row_confiplanilla['p2']; ?>" >
		<input type="hidden" name="p3"  id="p3" value="<?php echo $row_confiplanilla['p3']; ?>" >
		<input type="hidden" name="p4"  id="p4" value="<?php echo $row_confiplanilla['p4']; ?>" >
		<input type="hidden" name="p5"  id="p5" value="<?php echo $row_confiplanilla['p5']; ?>" >
		<input type="hidden" name="p6"  id="p6" value="<?php echo $row_confiplanilla['p6']; ?>" >

		<input type="hidden" name="id_aud" id="id_aud" value=""/>
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $row_supervisor['user_id'];?>"/>
		<input type="hidden" name="alumno_id" id="alumno_id" value="<?php echo $_POST['alumno_id'];?>"/>
		<input type="hidden" name="tipo_cambio" id="tipo_cambio" value="Modificacion Calificacion Parcial"/>
		<input type="hidden" name="observacion_cambio" id="observacion_cambio" value="<?php echo 'Asignatura: '.$row_reporte['mate'].', Lapso: '.$_POST['lapso'].' Lapso';?>"/>


              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>



<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Modificar Calificaciones">    </td></tr>

            </table>
<?php // FIN AJUSTE DE NOTAS

?>
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_planilla; ?>" >

<input type="hidden" name="MM_update" value="modi_form">
</form>

<script type="text/javascript">
<!--
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
//-->

</script>

<?php } ?>
          <?php } ?>

<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
<!--FIN INFO CONSULTA -->

</td>

          </tr>
	</table>
		<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_planilla == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen registros..</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>

        <?php if ($totalRows_supervisor == 0) { // Show if recordset empty ?>

        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/pngnew/olvidaste-tu-contrasena-de-usuario-de-oficina-de-las-preferencias-de-icono-4565-128.png" width="80" height="72"><br>
              <br>
                  <span class="titulo_grande_gris">Error... no estas autorizado para realizar modificaciones..</span><span class="texto_mediano_gris"><br>
                <br>
                </span><br>
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

mysql_free_result($planilla);

mysql_free_result($confiplanilla);

mysql_free_result($lapso);

mysql_free_result($supervisor);
?>
