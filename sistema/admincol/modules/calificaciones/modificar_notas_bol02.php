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
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, g.nombre as mate, f.id as asig_id FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_asignatura_nombre g WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.asignatura_nombre_id=g.id AND f.curso_id=d.id AND f.id= %s ORDER BY a.apellido ASC" , GetSQLValueString($colname_reporte, "text"));
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
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso=%s AND a.alumno_id=%s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"), GetSQLValueString($alumno_planilla, "int"));
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

// CALCULAR
	$ind11=$_POST['ind11'];
	$ind12=$_POST['ind12'];
	$ind13=$_POST['ind13'];
	$ind14=$_POST['ind14'];
	$n1f1= ($ind11+$ind12+$ind13+$ind14);
	$n1f2=$_POST['n1f2'];

	$ind21=$_POST['ind21'];
	$ind22=$_POST['ind22'];
	$ind23=$_POST['ind23'];
	$ind24=$_POST['ind24'];
	$n2f1= ($ind21+$ind22+$ind23+$ind24);
	$n2f2=$_POST['n2f2'];

	$ind31=$_POST['ind31'];
	$ind32=$_POST['ind32'];
	$ind33=$_POST['ind33'];
	$ind34=$_POST['ind34'];
	$n3f1= ($ind31+$ind32+$ind33+$ind34);
	$n3f2=$_POST['n3f2'];

	$ind41=$_POST['ind41'];
	$ind42=$_POST['ind42'];
	$ind43=$_POST['ind43'];
	$ind44=$_POST['ind44'];
	$n4f1= ($ind41+$ind42+$ind43+$ind44);
	$n4f2=$_POST['n4f2'];

	$po1=$_POST['p1'];
	$po2=$_POST['p2'];
	$po3=$_POST['p3'];
	$po4=$_POST['p4'];
	
	
	if ($n1f2==""){
	$nota1=(($n1f1*$po1)/100);
	}else{
	$nota1=(($n1f2*$po1)/100);
	}
	
	if ($n2f2==""){
	$nota2=(($n2f1*$po2)/100);
	}else{
	$nota2=(($n2f2*$po2)/100);
	}

	if ($n3f2==""){
	$nota3=(($n3f1*$po3)/100);
	}else{
	$nota3=(($n3f2*$po3)/100);
	}

	if ($n4f2==""){
	$nota4=(($n4f1*$po4)/100);
	}else{
	$nota4=(($n4f2*$po4)/100);
	}

	$calpro=($nota1+$nota2+$nota3+$nota4);
	$def=$calpro;
	// FIN CALCULO

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modi_form")) {
	$updateSQL = sprintf("update jos_formato_evaluacion_bol02 SET ind11=%s, ind12=%s, ind13=%s, ind14=%s, n1f1=%s, n1f2=%s, ind21=%s, ind22=%s, ind23=%s, ind24=%s, n2f1=%s, n2f2=%s, ind31=%s, ind32=%s, ind33=%s, ind34=%s, n3f1=%s, n3f2=%s, ind41=%s, ind42=%s, ind43=%s, ind44=%s, n4f1=%s, n4f2=%s, calpro=%s, def=%s WHERE id=%s",
                         
                            GetSQLValueString($ind11, "double"),
                            GetSQLValueString($ind12, "double"),
                            GetSQLValueString($ind13, "double"),
                            GetSQLValueString($ind14, "double"),
                            GetSQLValueString($n1f1, "double"),
                            GetSQLValueString($n1f2, "double"),

                            GetSQLValueString($ind21, "double"),
                            GetSQLValueString($ind22, "double"),
                            GetSQLValueString($ind23, "double"),
                            GetSQLValueString($ind24, "double"),
                            GetSQLValueString($n2f1, "double"),
                            GetSQLValueString($n2f2, "double"),

                            GetSQLValueString($ind31, "double"),
                            GetSQLValueString($ind32, "double"),
                            GetSQLValueString($ind33, "double"),
                            GetSQLValueString($ind34, "double"),
                            GetSQLValueString($n3f1, "double"),
                            GetSQLValueString($n3f2, "double"),

                            GetSQLValueString($ind41, "double"),
                            GetSQLValueString($ind42, "double"),
                            GetSQLValueString($ind43, "double"),
                            GetSQLValueString($ind44, "double"),
                            GetSQLValueString($n4f1, "double"),
                            GetSQLValueString($n4f2, "double"),
                            GetSQLValueString($calpro, "double"),
                            GetSQLValueString($def, "double"),

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
    <table width="700" style="font-size:9px" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="texto_mediano_gris">
		
                  <td width="80" colspan="5"><div align="center"><span>INDICADORES P1</span></div></td>
                  <td width="80" colspan="5"><div align="center"><span>INDICADORES P2</span></div></td>
                  <td width="80" colspan="5"><div align="center"><span>INDICADORES P3</span></div></td>
                  <td width="80" colspan="5"><div align="center"><span>INDICADORES P4</span></div></td>
              </tr>
    <tr>

		<td width="80"><div align="center"><span>1</span></div></td>
                <td width="80"><div align="center"><span>2</span></div></td>
                <td width="80"><div align="center"><span>3</span></div></td>
                <td width="80"><div align="center"><span>4</span></div></td>
                <td width="80"><div align="center"><span>F2</span></div></td>

		<td width="80"><div align="center"><span>1</span></div></td>
                <td width="80"><div align="center"><span>2</span></div></td>
                <td width="80"><div align="center"><span>3</span></div></td>
                <td width="80"><div align="center"><span>4</span></div></td>
                <td width="80"><div align="center"><span>F2</span></div></td>

		<td width="80"><div align="center"><span>1</span></div></td>
                <td width="80"><div align="center"><span>2</span></div></td>
                <td width="80"><div align="center"><span>3</span></div></td>
                <td width="80"><div align="center"><span>4</span></div></td>
                <td width="80"><div align="center"><span>F2</span></div></td>

		<td width="80"><div align="center"><span>1</span></div></td>
                <td width="80"><div align="center"><span>2</span></div></td>
                <td width="80"><div align="center"><span>3</span></div></td>
                <td width="80"><div align="center"><span>4</span></div></td>
                <td width="80"><div align="center"><span>F2</span></div></td>



              </tr>


              <?php 
 		
		
		do {   ?>
              <tr bgcolor="#FFFFFF" class="texto_mediano_gris">

                <td style="border-left:1px solid"><div align="center"><span><input name="ind11" type="text" id="ind11" value="<?php echo $row_planilla['ind11']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind12" type="text" id="ind12" value="<?php echo $row_planilla['ind12']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind13" type="text" id="ind13" value="<?php echo $row_planilla['ind13']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind14" type="text" id="ind14" value="<?php echo $row_planilla['ind14']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="n1f2" type="text" id="n1f2" value="<?php echo $row_planilla['n1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid"><div align="center"><span><input name="ind21" type="text" id="ind21" value="<?php echo $row_planilla['ind21']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind22" type="text" id="ind22" value="<?php echo $row_planilla['ind22']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind23" type="text" id="ind23" value="<?php echo $row_planilla['ind23']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind24" type="text" id="ind24" value="<?php echo $row_planilla['ind24']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="n2f2" type="text" id="n2f2" value="<?php echo $row_planilla['n2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid"><div align="center"><span><input name="ind31" type="text" id="ind31" value="<?php echo $row_planilla['ind31']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind32" type="text" id="ind32" value="<?php echo $row_planilla['ind32']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind33" type="text" id="ind33" value="<?php echo $row_planilla['ind33']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind34" type="text" id="ind34" value="<?php echo $row_planilla['ind34']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="n3f2" type="text" id="n3f2" value="<?php echo $row_planilla['n3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid"><div align="center"><span><input name="ind41" type="text" id="ind41" value="<?php echo $row_planilla['ind41']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind42" type="text" id="ind42" value="<?php echo $row_planilla['ind42']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind43" type="text" id="ind43" value="<?php echo $row_planilla['ind43']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="ind44" type="text" id="ind44" value="<?php echo $row_planilla['ind44']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="n4f2" type="text" id="n4f2" value="<?php echo $row_planilla['n4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

    

                <input type="hidden" name="id"  id="id" value="<?php echo $row_planilla['id']; ?>" >


		<input type="hidden" name="p1"  id="p1" value="<?php echo $row_confiplanilla['p1']; ?>" >
		<input type="hidden" name="p2"  id="p2" value="<?php echo $row_confiplanilla['p2']; ?>" >
		<input type="hidden" name="p3"  id="p3" value="<?php echo $row_confiplanilla['p3']; ?>" >
		<input type="hidden" name="p4"  id="p4" value="<?php echo $row_confiplanilla['p4']; ?>" >


              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Modificar Calificaciones"/>    </td></tr>

            </table>
<?php // FIN AJUSTE DE NOTAS

?>
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_planilla; ?>" />


<input type="hidden" name="id_aud" id="id_aud" value=""/>
<input type="hidden" name="user_id" id="user_id" value="<?php echo $row_supervisor['user_id'];?>"/>
<input type="hidden" name="alumno_id" id="alumno_id" value="<?php echo $_POST['alumno_id'];?>"/>
<input type="hidden" name="tipo_cambio" id="tipo_cambio" value="Modificacion Calificacion Parcial"/>
<input type="hidden" name="observacion_cambio" id="observacion_cambio" value="<?php echo 'Asignatura: '.$row_reporte['mate'].', Lapso: '.$_POST['lapso'].' Lapso';?>"/>
    

<input type="hidden" name="MM_update" value="modi_form"/>
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
