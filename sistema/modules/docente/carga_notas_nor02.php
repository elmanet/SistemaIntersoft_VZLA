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

mysql_select_db($database_sistemacol, $sistemacol);
$query_lap = sprintf("SELECT * FROM jos_lapso_encurso" , GetSQLValueString($colname_lap, "int"));
$lap = mysql_query($query_lap, $sistemacol) or die(mysql_error());
$row_lap = mysql_fetch_assoc($lap);
$totalRows_lap = mysql_num_rows($lap);
$lapso_curso=$row_lap['cod'];

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
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_alumno_info b WHERE a.lapso=$lapso_curso AND a.alumno_id=b.alumno_id AND a.asignatura_id = %s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);

//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_confiplanilla = $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);


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

	// CALCULAR
	
	$p1f1=$_POST['p1f1'.$i];
	$p1f2=$_POST['p1f2'.$i];
	$p2f1=$_POST['p2f1'.$i];
	$p2f2=$_POST['p2f2'.$i];
	$p3f1=$_POST['p3f1'.$i];
	$p3f2=$_POST['p3f2'.$i];
	$p4f1=$_POST['p4f1'.$i];
	$p4f2=$_POST['p4f2'.$i];
	$p5f1=$_POST['p5f1'.$i];
	$p5f2=$_POST['p5f2'.$i];
        $p6f1=$_POST['p6f1'.$i];
/*
 	$flf1=$_POST['flf1'.$i];
	$flf2=$_POST['flf2'.$i];
*/

        $po1=$_POST['p1'.$i];
	$po2=$_POST['p2'.$i];
	$po3=$_POST['p3'.$i];
	$po4=$_POST['p4'.$i];
	$po5=$_POST['p5'.$i];
        $po6=$_POST['p6'.$i];
	
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

 	if ($p5f2==""){
	$nota5=(($p5f1*$po5)/100);
	}else{
	$nota5=(($p5f2*$po5)/100);
	}

	$nota6=(($p6f1*$po6)/100);
/*
 	if ($flf2==""){
	$treinta=(($flf1*30)/100);
	}else{
	$treinta=(($flf2*30)/100);
	}
*/
	$sumapon=($nota1+$nota2+$nota3+$nota4+$nota5+$nota6);
//	$seten=(($sumapon*70)/100);
	$calpro=$sumapon;
	$def=$calpro;


	

	// FIN CALCULO

     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_nor02 (id, alumno_id, asignatura_id, confiplanilla_id, lapso, p1f1, p1f2, p2f1, p2f2, p3f1, p3f2, p4f1, p4f2, p5f1, p5f2, p6f1, sumapon, calpro, def) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),

                            GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'.$i], "int"),
                            GetSQLValueString($_POST['lapso'.$i], "int"),

                            GetSQLValueString($_POST['p1f1'.$i], "double"),
                            GetSQLValueString($_POST['p1f2'.$i], "double"),

                            GetSQLValueString($_POST['p2f1'.$i], "double"),
                            GetSQLValueString($_POST['p2f2'.$i], "double"),

                            GetSQLValueString($_POST['p3f1'.$i], "double"),
                            GetSQLValueString($_POST['p3f2'.$i], "double"),

                            GetSQLValueString($_POST['p4f1'.$i], "double"),
                            GetSQLValueString($_POST['p4f2'.$i], "double"),

                            GetSQLValueString($_POST['p5f1'.$i], "double"),
                            GetSQLValueString($_POST['p5f2'.$i], "double"),

                            GetSQLValueString($_POST['p6f1'.$i], "double"),

                            GetSQLValueString($sumapon, "double"),
                 //           GetSQLValueString($seten, "double"),

 //                           GetSQLValueString($_POST['flf1'.$i], "double"),
   //                         GetSQLValueString($_POST['flf2'.$i], "double"),

     //                       GetSQLValueString($treinta, "double"),
                            GetSQLValueString($calpro, "double"),              
                            GetSQLValueString($def, "double"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $insertGoTo = "fin_carga_notas_nor02.php";
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

	// CALCULAR
	
	$p1f1=$_POST['p1f1'.$i];
	$p1f2=$_POST['p1f2'.$i];
	$p2f1=$_POST['p2f1'.$i];
	$p2f2=$_POST['p2f2'.$i];
	$p3f1=$_POST['p3f1'.$i];
	$p3f2=$_POST['p3f2'.$i];
	$p4f1=$_POST['p4f1'.$i];
	$p4f2=$_POST['p4f2'.$i];
	$p5f1=$_POST['p5f1'.$i];
	$p5f2=$_POST['p5f2'.$i];
        $p6f1=$_POST['p6f1'.$i];
/*
 	$flf1=$_POST['flf1'.$i];
	$flf2=$_POST['flf2'.$i];
*/

        $po1=$_POST['p1'.$i];
	$po2=$_POST['p2'.$i];
	$po3=$_POST['p3'.$i];
	$po4=$_POST['p4'.$i];
	$po5=$_POST['p5'.$i];
        $po6=$_POST['p6'.$i];
	
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

 	if ($p5f2==""){
	$nota5=(($p5f1*$po5)/100);
	}else{
	$nota5=(($p5f2*$po5)/100);
	}

	$nota6=(($p6f1*$po6)/100);
/*
 	if ($flf2==""){
	$treinta=(($flf1*30)/100);
	}else{
	$treinta=(($flf2*30)/100);
	}
*/
	$sumapon=($nota1+$nota2+$nota3+$nota4+$nota5+$nota6);
//	$seten=(($sumapon*70)/100);
	$calpro=$sumapon;
	$def=$calpro;


	

	// FIN CALCULO

     $updateSQL = sprintf("update jos_formato_evaluacion_nor02 SET alumno_id=%s, asignatura_id=%s, confiplanilla_id=%s, lapso=%s, p1f1=%s, p1f2=%s, p2f1=%s, p2f2=%s, p3f1=%s, p3f2=%s, p4f1=%s, p4f2=%s, p5f1=%s, p5f2=%s, p6f1=%s,  sumapon=%s, calpro=%s, def=%s WHERE id=%s",
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'.$i], "int"),
                            GetSQLValueString($_POST['lapso'.$i], "int"),

                            GetSQLValueString($_POST['p1f1'.$i], "double"),
                            GetSQLValueString($_POST['p1f2'.$i], "double"),

                            GetSQLValueString($_POST['p2f1'.$i], "double"),
                            GetSQLValueString($_POST['p2f2'.$i], "double"),

                            GetSQLValueString($_POST['p3f1'.$i], "double"),
                            GetSQLValueString($_POST['p3f2'.$i], "double"),

                            GetSQLValueString($_POST['p4f1'.$i], "double"),
                            GetSQLValueString($_POST['p4f2'.$i], "double"),

                            GetSQLValueString($_POST['p5f1'.$i], "double"),
                            GetSQLValueString($_POST['p5f2'.$i], "double"),

                             GetSQLValueString($_POST['p6f1'.$i], "double"),

                             GetSQLValueString($sumapon, "double"),
                //           GetSQLValueString($seten, "double"),

                   //         GetSQLValueString($_POST['flf1'.$i], "double"),
                   //         GetSQLValueString($_POST['flf2'.$i], "double"),

                  //          GetSQLValueString($treinta, "double"),
                            GetSQLValueString($calpro, "double"),
                            GetSQLValueString($def, "double"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $updateGoTo = "fin_carga_notas_nor02.php";
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
 <td valign="top" align="left" class="texto_mediano_gris" ><h2>Estudiantes de <?php echo $row_reporte['anio']." ".$row_reporte['descripcion'];?></h2>

<?php // CARGA DE NOTAS
if(($_POST['asignatura_id']==$row_planilla['asignatura_id']) and ($_POST['lapso']==$row_planilla['lapso'])) { 

// MODIFICACION DE CALIFICACIONES
?>
<form action="<?php echo $editFormAction; ?>" name="modi_form" id="modi_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<table width="1250" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="80"><div align="center"><span>Cedula</span></div></td>
                <td width="270"><div align="center"><span>Apellidos y Nombres</span></div></td>

                <td width="30"><div align="center"><span>P1F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P2F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P3F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P4F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P5F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span><b>Ser y Convivir</b></span></div></td>
<?php /* 
                <td width="30"><div align="center"><span>FLF1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>
*/?>
              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_planilla['apellido'].", ".$row_planilla['nombre']; ?></span></div></td>


<?php if ($row_planilla['p1f1']==""){ // PRUEBA 1 F1 ?>
                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p1f1'.$i;?>" type="text" id="<? echo 'p1f1'.$i;?>" value="<?php echo $row_planilla['p1f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p1f1'.$i;?>" type="text" id="<? echo 'p1f1'.$i;?>" value="<?php echo $row_planilla['p1f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['p1f2']==""){ // PRUEBA 1 F2 ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p1f2'.$i;?>" type="text" id="<? echo 'p1f2'.$i;?>" value="<?php echo $row_planilla['p1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p1f2'.$i;?>" type="text" id="<? echo 'p1f2'.$i;?>" value="<?php echo $row_planilla['p1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['p2f1']==""){ // PRUEBA 2 F1 ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p2f1'.$i;?>" type="text" id="<? echo 'p2f1'.$i;?>" value="<?php echo $row_planilla['p2f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p2f1'.$i;?>" type="text" id="<? echo 'p2f1'.$i;?>" value="<?php echo $row_planilla['p2f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly"/></span></div></td>
<?php }?>


<?php if ($row_planilla['p2f2']==""){ // PRUEBA 2 F2 ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p2f2'.$i;?>" type="text" id="<? echo 'p2f2'.$i;?>" value="<?php echo $row_planilla['p2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p2f2'.$i;?>" type="text" id="<? echo 'p2f2'.$i;?>" value="<?php echo $row_planilla['p2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['p3f1']==""){ // PRUEBA 3 F1 ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p3f1'.$i;?>" type="text" id="<? echo 'p3f1'.$i;?>" value="<?php echo $row_planilla['p3f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p3f1'.$i;?>" type="text" id="<? echo 'p3f1'.$i;?>" value="<?php echo $row_planilla['p3f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['p3f2']==""){ // PRUEBA 3 F2 ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p3f2'.$i;?>" type="text" id="<? echo 'p3f2'.$i;?>" value="<?php echo $row_planilla['p3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p3f2'.$i;?>" type="text" id="<? echo 'p3f2'.$i;?>" value="<?php echo $row_planilla['p3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['p4f1']==""){ // PRUEBA 4 F1 ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p4f1'.$i;?>" type="text" id="<? echo 'p4f1'.$i;?>" value="<?php echo $row_planilla['p4f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p4f1'.$i;?>" type="text" id="<? echo 'p4f1'.$i;?>" value="<?php echo $row_planilla['p4f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div></td>
<?php }?>


<?php if ($row_planilla['p4f2']==""){ // PRUEBA 4 F2 ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p4f2'.$i;?>" type="text" id="<? echo 'p4f2'.$i;?>" value="<?php echo $row_planilla['p4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p4f2'.$i;?>" type="text" id="<? echo 'p4f2'.$i;?>" value="<?php echo $row_planilla['p4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div></td>

<?php }?>

<?php if ($row_planilla['p5f1']==""){ // PRUEBA 5 F1 ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p5f1'.$i;?>" type="text" id="<? echo 'p5f1'.$i;?>" value="<?php echo $row_planilla['p5f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p5f1'.$i;?>" type="text" id="<? echo 'p5f1'.$i;?>" value="<?php echo $row_planilla['p5f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['p5f2']==""){ // PRUEBA 5 F2 ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p5f2'.$i;?>" type="text" id="<? echo 'p5f2'.$i;?>" value="<?php echo $row_planilla['p5f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p5f2'.$i;?>" type="text" id="<? echo 'p5f2'.$i;?>" value="<?php echo $row_planilla['p5f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['p6f1']==""){ // PRUEBA 6 Indicadores ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p6f1'.$i;?>" type="text" id="<? echo 'p6f1'.$i;?>" value="<?php echo $row_planilla['p6f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p6f1'.$i;?>" type="text" id="<? echo 'p6f1'.$i;?>" value="<?php echo $row_planilla['p6f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div></td>
<?php }?>



<?php // INGRESO DE CALIFICACIONES
?>
<?php /* 
<?php if ($row_planilla['flf1']==""){ // PRUEBA FINAL F1 ?>
                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'flf1'.$i;?>" type="text" id="<? echo 'flf1'.$i;?>" value="<?php echo $row_planilla['flf1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'flf1'.$i;?>" type="text" id="<? echo 'flf1'.$i;?>" value="<?php echo $row_planilla['flf1']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div></td>
<?php }?>


<?php if ($row_planilla['flf2']==""){ // PRUEBA FINAL F2 ?>
    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'flf2'.$i;?>" type="text" id="<? echo 'flf2'.$i;?>" value="<?php echo $row_planilla['flf2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'flf2'.$i;?>" type="text" id="<? echo 'flf2'.$i;?>" value="<?php echo $row_planilla['flf2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" readonly="readonly" /></span></div>
<?php }?>
*/?>

<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="<?php echo $row_planilla['id']; ?>" />
<input type="hidden" name="<?php echo 'ajuste'.$i;?>"  id="<?php echo 'ajuste'.$i;?>" value="<?php echo $row_planilla['ajuste']; ?>" />
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" />
<input type="hidden" name="<?php echo 'lapso'.$i;?>"  id="<?php echo 'lapso'.$i;?>" value="<?php echo $row_planilla['lapso']; ?>" />
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>"  id="<?php echo 'alumno_id'.$i;?>" value="<?php echo $row_planilla['alumno_id']; ?>" />
<input type="hidden" name="<?php echo 'asignatura_id'.$i;?>"  id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_planilla['asignatura_id']; ?>" />
<input type="hidden" name="<?php echo 'confiplanilla_id'.$i;?>"  id="<?php echo 'confiplanilla_id'.$i;?>" value="<?php echo $row_planilla['confiplanilla_id'];?>" />
<input type="hidden" name="<?php echo 'p1'.$i;?>"  id="<?php echo 'p1'.$i;?>" value="<?php echo $row_confiplanilla['p1']; ?>" />
<input type="hidden" name="<?php echo 'p2'.$i;?>"  id="<?php echo 'p2'.$i;?>" value="<?php echo $row_confiplanilla['p2']; ?>" />
<input type="hidden" name="<?php echo 'p3'.$i;?>"  id="<?php echo 'p3'.$i;?>" value="<?php echo $row_confiplanilla['p3']; ?>" />
<input type="hidden" name="<?php echo 'p4'.$i;?>"  id="<?php echo 'p4'.$i;?>" value="<?php echo $row_confiplanilla['p4']; ?>" />
<input type="hidden" name="<?php echo 'p5'.$i;?>"  id="<?php echo 'p5'.$i;?>" value="<?php echo $row_confiplanilla['p5']; ?>" />
<input type="hidden" name="<?php echo 'p6'.$i;?>"  id="<?php echo 'p6'.$i;?>" value="<?php echo $row_confiplanilla['p6']; ?>" />
</td>
           



                
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><span style="color:red; font-size:14px;"><b>Para realizar alguna modificaci&oacute;n debes dirigirte al departamento de Evaluaci&oacute;n... </b></span> &nbsp;&nbsp;&nbsp;&nbsp;<b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar Calificaciones"/>    </td></tr>

            </table>
<?php // FIN CARGA DE NOTAS

?>


<input type="hidden" name="MM_update" value="modi_form"/>
</form>
<?php
}else {
// INSERTAR CALIFICACIONES
?>

<form action="<?php echo $editFormAction; ?>" name="new_form" id="new_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)"/>

<table width="1250" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="80"><div align="center"><span>Cedula</span></div></td>
                <td width="270"><div align="center"><span>Apellidos y Nombres</span></div></td>

                <td width="30"><div align="center"><span>P1F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P2F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P3F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P4F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30"><div align="center"><span>P5F1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>

                <td width="30" ><div align="center"><span><b>Ser y Convivir</b></span></div></td>
<?php /*
                <td width="30"><div align="center"><span>FLF1</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>
*/?>
               </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_reporte['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_reporte['apellido'].", ".$row_reporte['nomalum']; ?></span></div></td>


                    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p1f1'.$i;?>" type="text" id="<? echo 'p1f1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
                    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p1f2'.$i;?>" type="text" id="<? echo 'p1f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>

                    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p2f1'.$i;?>" type="text" id="<? echo 'p2f1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
                    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p2f2'.$i;?>" type="text" id="<? echo 'p2f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>

                    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p3f1'.$i;?>" type="text" id="<? echo 'p3f1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
                    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p3f2'.$i;?>" type="text" id="<? echo 'p3f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>

                    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p4f1'.$i;?>" type="text" id="<? echo 'p4f1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
                    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p4f2'.$i;?>" type="text" id="<? echo 'p4f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>

                    <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'p5f1'.$i;?>" type="text" id="<? echo 'p5f1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
                    <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p5f2'.$i;?>" type="text" id="<? echo 'p5f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>

                    <td style="border-left:1px solid; background-color:#00FF99;"><div align="center"><span><input name="<?php echo 'p6f1'.$i;?>" type="text" id="<? echo 'p6f1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>


<?php /*
?>

                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'flf1'.$i;?>" type="text" id="<? echo 'flf1'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'flf2'.$i;?>" type="text" id="<? echo 'flf2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="2" /></span></div></td>
*/?>

<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value=""/>
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" />
<input type="hidden" name="<?php echo 'lapso'.$i;?>"  id="<?php echo 'lapso'.$i;?>" value="<?php echo $_POST['lapso']; ?>" />
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>"  id="<?php echo 'alumno_id'.$i;?>" value="<?php echo $row_reporte['alumno_id']; ?>" />
<input type="hidden" name="<?php echo 'asignatura_id'.$i;?>"  id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_reporte['asig_id']; ?>" />
<input type="hidden" name="<?php echo 'confiplanilla_id'.$i;?>"  id="<?php echo 'confiplanilla_id'.$i;?>" value="<?php echo $_POST['confiplanilla_id'];?>" />
<input type="hidden" name="<?php echo 'p1'.$i;?>"  id="<?php echo 'p1'.$i;?>" value="<?php echo $row_confiplanilla['p1']; ?>" />
<input type="hidden" name="<?php echo 'p2'.$i;?>"  id="<?php echo 'p2'.$i;?>" value="<?php echo $row_confiplanilla['p2']; ?>" />
<input type="hidden" name="<?php echo 'p3'.$i;?>"  id="<?php echo 'p3'.$i;?>" value="<?php echo $row_confiplanilla['p3']; ?>" />
<input type="hidden" name="<?php echo 'p4'.$i;?>"  id="<?php echo 'p4'.$i;?>" value="<?php echo $row_confiplanilla['p4']; ?>" />
<input type="hidden" name="<?php echo 'p5'.$i;?>"  id="<?php echo 'p5'.$i;?>" value="<?php echo $row_confiplanilla['p5']; ?>" />
<input type="hidden" name="<?php echo 'p6'.$i;?>"  id="<?php echo 'p6'.$i;?>" value="<?php echo $row_confiplanilla['p6']; ?>" />
</td>
           



                
              </tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar Calificaciones">    </td></tr>

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

mysql_free_result($lap);

mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($planilla);

mysql_free_result($confiplanilla);
?>
