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
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, f.id as asig_id FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND f.id= %s ORDER BY a.apellido ASC" , GetSQLValueString($colname_reporte, "text"));
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
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.lapso=$lapso_curso AND a.alumno_id=b.alumno_id AND a.asignatura_id = %s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "text"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);

//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_confiplanilla = $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "text"));
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
	$ind11=$_POST['ind11'.$i];
	$ind12=$_POST['ind12'.$i];
	$ind13=$_POST['ind13'.$i];
	$ind14=$_POST['ind14'.$i];
	$n1f1= ($ind11+$ind12+$ind13+$ind14);
	$n1f2=$_POST['n1f2'.$i];

	$ind21=$_POST['ind21'.$i];
	$ind22=$_POST['ind22'.$i];
	$ind23=$_POST['ind23'.$i];
	$ind24=$_POST['ind24'.$i];
	$n2f1= ($ind21+$ind22+$ind23+$ind24);
	$n2f2=$_POST['n2f2'.$i];

	$ind31=$_POST['ind31'.$i];
	$ind32=$_POST['ind32'.$i];
	$ind33=$_POST['ind33'.$i];
	$ind34=$_POST['ind34'.$i];
	$n3f1= ($ind31+$ind32+$ind33+$ind34);
	$n3f2=$_POST['n3f2'.$i];

	$ind41=$_POST['ind41'.$i];
	$ind42=$_POST['ind42'.$i];
	$ind43=$_POST['ind43'.$i];
	$ind44=$_POST['ind44'.$i];
	$n4f1= ($ind41+$ind42+$ind43+$ind44);
	$n4f2=$_POST['n4f2'.$i];

	$po1=$_POST['p1'.$i];
	$po2=$_POST['p2'.$i];
	$po3=$_POST['p3'.$i];
	$po4=$_POST['p4'.$i];
	
	
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
     $insertSQL = sprintf("INSERT INTO jos_formato_evaluacion_bol02 (id, alumno_id, asignatura_id, confiplanilla_id, lapso, ind11, ind12, ind13, ind14, n1f1, n1f2, ind21, ind22, ind23, ind24, n2f1, n2f2, ind31, ind32, ind33, ind34, n3f1, n3f2, ind41, ind42, ind43, ind44, n4f1, n4f2, calpro, def) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),

                            GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'.$i], "int"),
                            GetSQLValueString($_POST['lapso'.$i], "int"),
                            GetSQLValueString($_POST['ind11'.$i], "double"),
                            GetSQLValueString($_POST['ind12'.$i], "double"),
                            GetSQLValueString($_POST['ind13'.$i], "double"),
                            GetSQLValueString($_POST['ind14'.$i], "double"),
                            GetSQLValueString($n1f1, "double"),
                            GetSQLValueString($_POST['n1f2'.$i], "double"),
                            GetSQLValueString($_POST['ind21'.$i], "double"),
                            GetSQLValueString($_POST['ind22'.$i], "double"),
                            GetSQLValueString($_POST['ind23'.$i], "double"),
                            GetSQLValueString($_POST['ind24'.$i], "double"),
                            GetSQLValueString($n2f1, "double"),
                            GetSQLValueString($_POST['n2f2'.$i], "double"),
                            GetSQLValueString($_POST['ind31'.$i], "double"),
                            GetSQLValueString($_POST['ind32'.$i], "double"),
                            GetSQLValueString($_POST['ind33'.$i], "double"),
                            GetSQLValueString($_POST['ind34'.$i], "double"),
                            GetSQLValueString($n3f1, "double"),
                            GetSQLValueString($_POST['n3f2'.$i], "double"),
                            GetSQLValueString($_POST['ind41'.$i], "double"),
                            GetSQLValueString($_POST['ind42'.$i], "double"),
                            GetSQLValueString($_POST['ind43'.$i], "double"),
                            GetSQLValueString($_POST['ind44'.$i], "double"),
                            GetSQLValueString($n4f1, "double"),
                            GetSQLValueString($_POST['n4f2'.$i], "double"),
                            GetSQLValueString($calpro, "double"),
                            GetSQLValueString($def, "double"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $insertGoTo = "fin_carga_notas_bol02.php";
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
	$ind11=$_POST['ind11'.$i];
	$ind12=$_POST['ind12'.$i];
	$ind13=$_POST['ind13'.$i];
	$ind14=$_POST['ind14'.$i];
	$n1f1= ($ind11+$ind12+$ind13+$ind14);
	$n1f2=$_POST['n1f2'.$i];

	$ind21=$_POST['ind21'.$i];
	$ind22=$_POST['ind22'.$i];
	$ind23=$_POST['ind23'.$i];
	$ind24=$_POST['ind24'.$i];
	$n2f1= ($ind21+$ind22+$ind23+$ind24);
	$n2f2=$_POST['n2f2'.$i];

	$ind31=$_POST['ind31'.$i];
	$ind32=$_POST['ind32'.$i];
	$ind33=$_POST['ind33'.$i];
	$ind34=$_POST['ind34'.$i];
	$n3f1= ($ind31+$ind32+$ind33+$ind34);
	$n3f2=$_POST['n3f2'.$i];

	$ind41=$_POST['ind41'.$i];
	$ind42=$_POST['ind42'.$i];
	$ind43=$_POST['ind43'.$i];
	$ind44=$_POST['ind44'.$i];
	$n4f1= ($ind41+$ind42+$ind43+$ind44);
	$n4f2=$_POST['n4f2'.$i];

	$po1=$_POST['p1'.$i];
	$po2=$_POST['p2'.$i];
	$po3=$_POST['p3'.$i];
	$po4=$_POST['p4'.$i];
	
	
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
	$ajuste=$_POST['ajuste'.$i];
	$calpro=($nota1+$nota2+$nota3+$nota4);
	$def=$ajuste+$calpro;
	// FIN CALCULO
     $updateSQL = sprintf("update jos_formato_evaluacion_bol02 SET alumno_id=%s, asignatura_id=%s, confiplanilla_id=%s, lapso=%s, ind11=%s, ind12=%s, ind13=%s, ind14=%s, n1f1=%s, n1f2=%s, ind21=%s, ind22=%s, ind23=%s, ind24=%s, n2f1=%s, n2f2=%s, ind31=%s, ind32=%s, ind33=%s, ind34=%s, n3f1=%s, n3f2=%s, ind41=%s, ind42=%s, ind43=%s, ind44=%s, n4f1=%s, n4f2=%s, calpro=%s, ajuste=%s, def=%s WHERE id=%s",
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'.$i], "int"),
                            GetSQLValueString($_POST['confiplanilla_id'.$i], "int"),
                            GetSQLValueString($_POST['lapso'.$i], "int"),
                            GetSQLValueString($_POST['ind11'.$i], "double"),
                            GetSQLValueString($_POST['ind12'.$i], "double"),
                            GetSQLValueString($_POST['ind13'.$i], "double"),
                            GetSQLValueString($_POST['ind14'.$i], "double"),
                            GetSQLValueString($n1f1, "double"),
                            GetSQLValueString($_POST['n1f2'.$i], "double"),
                            GetSQLValueString($_POST['ind21'.$i], "double"),
                            GetSQLValueString($_POST['ind22'.$i], "double"),
                            GetSQLValueString($_POST['ind23'.$i], "double"),
                            GetSQLValueString($_POST['ind24'.$i], "double"),
                            GetSQLValueString($n2f1, "double"),
                            GetSQLValueString($_POST['n2f2'.$i], "double"),
                            GetSQLValueString($_POST['ind31'.$i], "double"),
                            GetSQLValueString($_POST['ind32'.$i], "double"),
                            GetSQLValueString($_POST['ind33'.$i], "double"),
                            GetSQLValueString($_POST['ind34'.$i], "double"),
                            GetSQLValueString($n3f1, "double"),
                            GetSQLValueString($_POST['n3f2'.$i], "double"),
                            GetSQLValueString($_POST['ind41'.$i], "double"),
                            GetSQLValueString($_POST['ind42'.$i], "double"),
                            GetSQLValueString($_POST['ind43'.$i], "double"),
                            GetSQLValueString($_POST['ind44'.$i], "double"),
                            GetSQLValueString($n4f1, "double"),
                            GetSQLValueString($_POST['n4f2'.$i], "double"),
                            GetSQLValueString($calpro, "double"),
                            GetSQLValueString($_POST['ajuste'.$i], "double"),
                            GetSQLValueString($def, "double"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $updateGoTo = "fin_carga_notas_bol02.php";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
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
                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N1F2</span></div></td>

                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N2F2</span></div></td>


                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N3F2</span></div></td>


                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N4F2</span></div></td>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_planilla['apellido'].", ".$row_planilla['nombre']; ?></span></div></td>

<?php if ($row_planilla['ind11']==""){ // INDICADOR 1 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind11'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>" value="<?php echo $row_planilla['ind11']; ?>"  style="width: 30px; height: 15px; font-size:9px;" maxlength="3"/></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind11'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>" value="<?php echo $row_planilla['ind11']; ?>"  style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind12']==""){ //INDICADOR 2 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind12'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" value="<?php echo $row_planilla['ind12']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind12'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" value="<?php echo $row_planilla['ind12']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind13']==""){ // INDICADOR 3 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind13'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" value="<?php echo $row_planilla['ind13']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind13'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" value="<?php echo $row_planilla['ind13']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind14']==""){ // INDICADOR 4 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind14'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" value="<?php echo $row_planilla['ind14']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind14'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" value="<?php echo $row_planilla['ind14']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['n1f2']==""){ // FORMA 2 PRUEBA 1 ?>
 <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n1f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" value="<?php echo $row_planilla['n1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>
<?php } else { ?>
 <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n1f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" value="<?php echo $row_planilla['n1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div>
<?php }?>

<?php if ($row_planilla['ind21']==""){ // INDICADOR 21 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind21'.$i;?>" type="text" id="<? echo 'ind21'.$i;?>" value="<?php echo $row_planilla['ind21']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind21'.$i;?>" type="text" id="<? echo 'ind21'.$i;?>" value="<?php echo $row_planilla['ind21']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind22']==""){ // INDICADOR 22 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind22'.$i;?>" type="text" id="<? echo 'ind22'.$i;?>" value="<?php echo $row_planilla['ind22']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind22'.$i;?>" type="text" id="<? echo 'ind22'.$i;?>" value="<?php echo $row_planilla['ind22']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['ind23']==""){ // INDICADOR 23 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind23'.$i;?>" type="text" id="<? echo 'ind23'.$i;?>" value="<?php echo $row_planilla['ind23']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind23'.$i;?>" type="text" id="<? echo 'ind23'.$i;?>" value="<?php echo $row_planilla['ind23']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind24']==""){ // INDICADOR 24 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind24'.$i;?>" type="text" id="<? echo 'ind24'.$i;?>" value="<?php echo $row_planilla['ind24']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind24'.$i;?>" type="text" id="<? echo 'ind24'.$i;?>" value="<?php echo $row_planilla['ind24']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['n2f2']==""){ // FORMA 2 PRUEBA 2?>
<td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n2f2'.$i;?>" type="text" id="<? echo 'n2f2'.$i;?>" value="<?php echo $row_planilla['n2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>
<?php } else { ?>
<td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n2f2'.$i;?>" type="text" id="<? echo 'n2f2'.$i;?>" value="<?php echo $row_planilla['n2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div>
<?php }?>


<?php if ($row_planilla['ind31']==""){ // INDICADOR 31 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind31'.$i;?>" type="text" id="<? echo 'ind31'.$i;?>" value="<?php echo $row_planilla['ind31']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind31'.$i;?>" type="text" id="<? echo 'ind31'.$i;?>" value="<?php echo $row_planilla['ind31']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"  /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind32']==""){ // INDICADOR 32 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind32'.$i;?>" type="text" id="<? echo 'ind32'.$i;?>" value="<?php echo $row_planilla['ind32']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind32'.$i;?>" type="text" id="<? echo 'ind32'.$i;?>" value="<?php echo $row_planilla['ind32']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div></td>
<?php }?>


<?php if ($row_planilla['ind33']==""){ // INDICADOR 33 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind33'.$i;?>" type="text" id="<? echo 'ind33'.$i;?>" value="<?php echo $row_planilla['ind33']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind33'.$i;?>" type="text" id="<? echo 'ind33'.$i;?>" value="<?php echo $row_planilla['ind33']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div></td>
<?php }?>

<?php if ($row_planilla['ind34']==""){ // INDICADOR 34 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind34'.$i;?>" type="text" id="<? echo 'ind34'.$i;?>" value="<?php echo $row_planilla['ind34']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind34'.$i;?>" type="text" id="<? echo 'ind34'.$i;?>" value="<?php echo $row_planilla['ind34']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"  /></span></div></td>
<?php }?>

<?php if ($row_planilla['n3f2']==""){ // FORMA 2 PRUEBA 3?>
<td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n3f2'.$i;?>" type="text" id="<? echo 'n3f2'.$i;?>" value="<?php echo $row_planilla['n3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>
<?php } else { ?>
<td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n3f2'.$i;?>" type="text" id="<? echo 'n3f2'.$i;?>" value="<?php echo $row_planilla['n3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div>
<?php }?>

<?php if ($row_planilla['ind41']==""){ // INDICADOR 41 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind41'.$i;?>" type="text" id="<? echo 'ind41'.$i;?>" value="<?php echo $row_planilla['ind41']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind41'.$i;?>" type="text" id="<? echo 'ind41'.$i;?>" value="<?php echo $row_planilla['ind41']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div></td
<?php }?>

<?php if ($row_planilla['ind42']==""){ // INDICADOR 42 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind42'.$i;?>" type="text" id="<? echo 'ind42'.$i;?>" value="<?php echo $row_planilla['ind42']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind42'.$i;?>" type="text" id="<? echo 'ind42'.$i;?>" value="<?php echo $row_planilla['ind42']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['ind43']==""){ // INDICADOR 43 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind43'.$i;?>" type="text" id="<? echo 'ind43'.$i;?>" value="<?php echo $row_planilla['ind43']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind43'.$i;?>" type="text" id="<? echo 'ind43'.$i;?>" value="<?php echo $row_planilla['ind43']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['ind44']==""){ // INDICADOR 44 ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind44'.$i;?>" type="text" id="<? echo 'ind44'.$i;?>" value="<?php echo $row_planilla['ind44']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
<?php } else { ?>
<td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind44'.$i;?>" type="text" id="<? echo 'ind44'.$i;?>" value="<?php echo $row_planilla['ind44']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly"/></span></div></td>
<?php }?>

<?php if ($row_planilla['n4f2']==""){ // FORMA 2 PRUEBA 4?>
 <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n4f2'.$i;?>" type="text" id="<? echo 'n4f2'.$i;?>" value="<?php echo $row_planilla['n4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>
<?php } else { ?>
 <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n4f2'.$i;?>" type="text" id="<? echo 'n4f2'.$i;?>" value="<?php echo $row_planilla['n4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" readonly="readonly" /></span></div>
<?php }?>

<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="<?php echo $row_planilla['id']; ?>" >
<input type="hidden" name="<?php echo 'ajuste'.$i;?>"  id="<?php echo 'ajuste'.$i;?>" value="<?php echo $row_planilla['ajuste']; ?>" >
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" >
<input type="hidden" name="<?php echo 'lapso'.$i;?>"  id="<?php echo 'lapso'.$i;?>" value="<?php echo $row_planilla['lapso']; ?>" >
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>"  id="<?php echo 'alumno_id'.$i;?>" value="<?php echo $row_planilla['alumno_id']; ?>" >
<input type="hidden" name="<?php echo 'asignatura_id'.$i;?>"  id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_planilla['asignatura_id']; ?>" >
<input type="hidden" name="<?php echo 'confiplanilla_id'.$i;?>"  id="<?php echo 'confiplanilla_id'.$i;?>" value="<?php echo $row_planilla['confiplanilla_id'];?>" >
<input type="hidden" name="<?php echo 'p1'.$i;?>"  id="<?php echo 'p1'.$i;?>" value="<?php echo $row_confiplanilla['p1']; ?>" >
<input type="hidden" name="<?php echo 'p2'.$i;?>"  id="<?php echo 'p2'.$i;?>" value="<?php echo $row_confiplanilla['p2']; ?>" >
<input type="hidden" name="<?php echo 'p3'.$i;?>"  id="<?php echo 'p3'.$i;?>" value="<?php echo $row_confiplanilla['p3']; ?>" >
<input type="hidden" name="<?php echo 'p4'.$i;?>"  id="<?php echo 'p4'.$i;?>" value="<?php echo $row_confiplanilla['p4']; ?>" >

</td>
           



                
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><span style="color:red; font-size:14px;"><b>Para realizar alguna modificaci&oacute;n debes dirigirte al departamento de Evaluaci&oacute;n... </b></span> &nbsp;&nbsp;&nbsp;&nbsp;<b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar Calificaciones">    </td></tr>

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

<table width="1250" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="80"><div align="center"><span>Cedula</span></div></td>
                <td width="270"><div align="center"><span>Apellidos y Nombres</span></div></td>
                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N1F2</span></div></td>

                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N2F2</span></div></td>


                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N3F2</span></div></td>


                <td width="30"><div align="center"><span>I1</span></div></td>
                <td width="30"><div align="center"><span>I2</span></div></td>
                <td width="30"><div align="center"><span>I3</span></div></td>
                <td width="30"><div align="center"><span>I4</span></div></td>

                <td width="30"><div align="center"><span>N4F2</span></div></td>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_reporte['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_reporte['apellido'].", ".$row_reporte['nomalum']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind11'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>"  style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind12'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind13'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind14'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>

                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n1f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>



                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind21'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>"  style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind22'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind23'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind24'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>

                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n2f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>



                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind31'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>"  style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind32'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind33'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind34'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>

                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n3f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>




                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind41'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>"  style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind42'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind43'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><input name="<?php echo 'ind44'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div></td>

                <td style="border-left:1px solid; background-color:green;"><div align="center"><span><input name="<?php echo 'n4f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" style="width: 30px; height: 15px; font-size:9px;" maxlength="3" /></span></div>


<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" >
<input type="hidden" name="<?php echo 'lapso'.$i;?>"  id="<?php echo 'lapso'.$i;?>" value="<?php echo $_POST['lapso']; ?>" >
<input type="hidden" name="<?php echo 'alumno_id'.$i;?>"  id="<?php echo 'alumno_id'.$i;?>" value="<?php echo $row_reporte['alumno_id']; ?>" >
<input type="hidden" name="<?php echo 'asignatura_id'.$i;?>"  id="<?php echo 'asignatura_id'.$i;?>" value="<?php echo $row_reporte['asig_id']; ?>" >
<input type="hidden" name="<?php echo 'confiplanilla_id'.$i;?>"  id="<?php echo 'confiplanilla_id'.$i;?>" value="<?php echo $_POST['confiplanilla_id'];?>" >
<input type="hidden" name="<?php echo 'p1'.$i;?>"  id="<?php echo 'p1'.$i;?>" value="<?php echo $row_confiplanilla['p1']; ?>" >
<input type="hidden" name="<?php echo 'p2'.$i;?>"  id="<?php echo 'p2'.$i;?>" value="<?php echo $row_confiplanilla['p2']; ?>" >
<input type="hidden" name="<?php echo 'p3'.$i;?>"  id="<?php echo 'p3'.$i;?>" value="<?php echo $row_confiplanilla['p3']; ?>" >
<input type="hidden" name="<?php echo 'p4'.$i;?>"  id="<?php echo 'p4'.$i;?>" value="<?php echo $row_confiplanilla['p4']; ?>" >

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
