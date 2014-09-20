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
$query_tipofl = sprintf("SELECT * FROM jos_formato_evaluacion_tfinal" , GetSQLValueString($colname_tipofl, "int"));
$tipofl = mysql_query($query_tipofl, $sistemacol) or die(mysql_error());
$row_tipofl = mysql_fetch_assoc($tipofl);
$totalRows_tipofl = mysql_num_rows($tipofl);
$tipofl=$row_tipofl['cod'];

mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);

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

//consultas por formatos
$colname_planilla = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_planilla = $_POST['asignatura_id'];
}
$lap_planilla = "-1";
if (isset($_POST['lapso'])) {
  $lap_planilla = $_POST['lapso'];
}
$confi=$row_confip['codfor'];

if ($confi=="bol01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso= %s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}

if ($confi=="bol02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso= %s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}

if ($confi=="nor01"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso= %s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}

if ($confi=="nor02"){
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso= %s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}
// fin consulta por formatos
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
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s AND lapso= %s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "int"), GetSQLValueString($lap_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

$pass_supervisor = "-1";
if (isset($_POST['pass'])) {
  $pass_supervisor = $_POST['pass'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_supervisor = sprintf("SELECT * FROM jos_users_supervisor a, jos_users b WHERE a.user_id=b.id AND a.pass= %s", GetSQLValueString($pass_supervisor, "text"));
$supervisor = mysql_query($query_supervisor, $sistemacol) or die(mysql_error());
$row_supervisor = mysql_fetch_assoc($supervisor);
$totalRows_supervisor = mysql_num_rows($supervisor);

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
$confi=$row_confip['codfor'];

// calculo notas bol01

	// CALCULAR
if ($confi=="bol01"){
	
	/* $treinta_sc=$_POST['30_sc'.$i];*/
	$p1f1=$_POST['p1f1'.$i];
	$p1f2=$_POST['p1f2'.$i];
	$p2f1=$_POST['p2f1'.$i];
	$p2f2=$_POST['p2f2'.$i];
	$p3f1=$_POST['p3f1'.$i];
	$p3f2=$_POST['p3f2'.$i];
	$p4f1=$_POST['p4f1'.$i];
	$p4f2=$_POST['p4f2'.$i];
	$po1=$_POST['p1'];
	$po2=$_POST['p2'];
	$po3=$_POST['p3'];
	$po4=$_POST['p4'];
	$ajuste=$_POST['ajuste'.$i];
	
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
	$sumapon=($nota1+$nota2+$nota3+$nota4);
	/* $seten=(($sumapon*70)/100);*/
	$calpro=$sumapon;
	$def=(round($sumapon,0))+$ajuste;

	if(($calpro>=0) and ($calpro<10)){ $defcuali=1;}
	if(($calpro>9) and ($calpro<14)){ $defcuali=3;}
	if(($calpro>13) and ($calpro<18)){ $defcuali=4;}
	if(($calpro>17) and ($calpro<21)){ $defcuali=5;}
	
}
	// FIN CALCULO bol01


// CALCULAR
if ($confi=="bol02"){
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
}
	// FIN CALCULO


// calculo de las notas de nor01
if ($confi=="nor01"){
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
	if ($tipofl==1){
 	$flf1=$_POST['flf1'.$i];
	$flf2=$_POST['flf2'.$i];
	}
	$ajuste=$_POST['ajuste'.$i];
	$totalind=$_POST['indtotal'.$i];

   $po1=$_POST['p1'];
	$po2=$_POST['p2'];
	$po3=$_POST['p3'];
	$po4=$_POST['p4'];
	$po5=$_POST['p5'];
	
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

	if ($tipofl==1){

 	if ($flf2==""){
	$treinta=(($flf1*30)/100);
	}else{
	$treinta=(($flf2*30)/100);
	}
	}

	$sumanotas=($nota1+$nota2+$nota3+$nota4+$nota5);


        if (($sumanotas>=19) AND ($totalind>0)){
            $sumapon=20;
        }
        if (($sumanotas>=18) AND ($totalind==2)){
            $sumapon=20;
        }
        if (($sumanotas>=18) AND ($sumanotas<20) AND ($totalind==1)){
            $sumapon_casi=$sumanotas+$totalind;
             if ($sumapon_casi>=20) {
            $sumapon=20;
        }else {
            $sumapon= $sumapon_casi;
        }
        }
        if (($sumanotas>17) AND ($totalind==0)) {
            $sumapon=$sumanotas;
        }
        if ($sumanotas<18) {
            $sumapon=$sumanotas+$totalind;
        }

	if ($tipofl==1){
	$seten=(($sumapon*70)/100);
	$calpro=$seten+$treinta;
	$def=$calpro+$ajuste;
	}

	if ($tipofl==0){
	$treinta=NULL;
	$seten=NULL;
	$flf1=NULL;
	$flf2=NULL;
	$calpro=$sumapon;
	$def=$calpro+$ajuste;
	}
}
// fin nor01

// calculo notas nor02
if ($confi=="nor02"){	
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

        $po1=$_POST['p1'];
	$po2=$_POST['p2'];
	$po3=$_POST['p3'];
	$po4=$_POST['p4'];
	$po5=$_POST['p5'];
        $po6=$_POST['p6'];
	$ajuste=$_POST['ajuste'.$i];
	
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
	$def=$calpro+$ajuste;

}
// fin nor02



if ($confi=="bol01"){ // inicio if

     $updateSQL = sprintf("update jos_formato_evaluacion_bol01 SET p1f1=%s, p1f2=%s, p2f1=%s, p2f2=%s, p3f1=%s, p3f2=%s, p4f1=%s, p4f2=%s, sumapon=%s, calpro=%s, def=%s, defcuali=%s WHERE id=%s",
                         
		            GetSQLValueString($_POST['p1f1'.$i], "double"),
                            GetSQLValueString($_POST['p1f2'.$i], "double"),

                            GetSQLValueString($_POST['p2f1'.$i], "double"),
                            GetSQLValueString($_POST['p2f2'.$i], "double"),

                            GetSQLValueString($_POST['p3f1'.$i], "double"),
                            GetSQLValueString($_POST['p3f2'.$i], "double"),

                            GetSQLValueString($_POST['p4f1'.$i], "double"),
                            GetSQLValueString($_POST['p4f2'.$i], "double"),

                            GetSQLValueString($sumapon, "double"),
                            
                            GetSQLValueString($calpro, "double"),
                            GetSQLValueString($def, "int"),

                            GetSQLValueString($defcuali, "int"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());
}// fin if

if ($confi=="bol02"){ // inicio if

     $updateSQL = sprintf("update jos_formato_evaluacion_bol02 SET ind11=%s, ind12=%s, ind13=%s, ind14=%s, n1f1=%s, n1f2=%s, ind21=%s, ind22=%s, ind23=%s, ind24=%s, n2f1=%s, n2f2=%s, ind31=%s, ind32=%s, ind33=%s, ind34=%s, n3f1=%s, n3f2=%s, ind41=%s, ind42=%s, ind43=%s, ind44=%s, n4f1=%s, n4f2=%s, calpro=%s, ajuste=%s, def=%s WHERE id=%s",
                            
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
}// fin if

if ($confi=="nor01"){ // inicio if


     $updateSQL = sprintf("update jos_formato_evaluacion_nor01 SET p1f1=%s, p1f2=%s, p2f1=%s, p2f2=%s, p3f1=%s, p3f2=%s, p4f1=%s, p4f2=%s, p5f1=%s, p5f2=%s, sumanotas=%s, sumapon=%s, seten=%s, flf1=%s, flf2=%s, treinta=%s, calpro=%s, def=%s, ajuste=%s WHERE id=%s",
                         
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
                            GetSQLValueString($sumanotas, "double"),
                            GetSQLValueString($sumapon, "double"),
                            GetSQLValueString($seten, "double"),
                            GetSQLValueString($_POST['flf1'.$i], "double"),
                            GetSQLValueString($_POST['flf2'.$i], "double"),
                            GetSQLValueString($treinta, "double"),
                      	    GetSQLValueString($calpro, "double"),
                            GetSQLValueString($def, "double"),
			  					    GetSQLValueString($ajuste, "double"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());
}// fin if

if ($confi=="nor02"){ // inicio if

     $updateSQL = sprintf("update jos_formato_evaluacion_nor02 SET p1f1=%s, p1f2=%s, p2f1=%s, p2f2=%s, p3f1=%s, p3f2=%s, p4f1=%s, p4f2=%s, p5f1=%s, p5f2=%s, p6f1=%s,  sumapon=%s, calpro=%s, def=%s  WHERE id=%s",
                         
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
}// fin if

} while ($i+1 <= $total );

  $updateGoTo = "modificar_notas_parcial2.php";
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
 <td valign="top" align="left" class="texto_mediano_gris" ><h2>Calificaciones de <?php echo $_POST['lapso']." lapso de ".$row_reporte['mate']." de ".$row_reporte['anio']." ".$row_reporte['descripcion'];?></h2>

<?php // CARGA DE NOTAS
if(($_POST['asignatura_id']==$row_planilla['asignatura_id']) and ($_POST['lapso']==$row_planilla['lapso'])) { 

// MODIFICACION DE CALIFICACIONES
?>
<form action="<?php echo $editFormAction; ?>asignatura_id=<?php echo $_POST['asignatura_id']; ?>&lapso=<?php echo $_POST['lapso']; ?>" name="modi_form" id="modi_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<?php if(($confi=="bol01") or ($confi=="nor01") or ($confi=="nor02")){ ?>
<table width="1000" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
<?php }?>
<?php if($confi=="bol02"){ ?>
<table width="1300" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
<?php }?>
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="80"><div align="center"><span>Cedula</span></div></td>
                <td width="270"><div align="center"><span>Apellidos y Nombres</span></div></td>
<?php if(($confi=="bol01") or ($confi=="nor01") or ($confi=="nor02")){ ?>
                <td width="30" height="25"><div align="center"><span>P1F1</span></div></td>	
                <td width="30"><div align="center"><span>A112</span></div></td>	
                <td width="30"><div align="center"><span>P2F1</span></div></td>	
                <td width="30"><div align="center"><span>A112</span></div></td>	
                <td width="30"><div align="center"><span>P3F1</span></div></td>	
                <td width="30"><div align="center"><span>A112</span></div></td>	
                <td width="30"><div align="center"><span>P4F1</span></div></td>	
                <td width="30"><div align="center"><span>A112</span></div></td>
<?php if(($confi=="nor01") or ($confi=="nor02")){ ?>
                <td width="30"><div align="center"><span>P5F1</span></div></td>	
                <td width="30"><div align="center"><span>A112</span></div></td>
<?php } ?>		
<?php if ($confi=="nor02"){ ?>
                <td width="30"><div align="center"><span>SER Y CONVIVIR</span></div></td>	
<?php } ?>
<?php if (($confi=="nor01")and($tipofl==1)) { ?>
                <td width="30"><div align="center"><span>FINAL</span></div></td>
                <td width="30"><div align="center"><span>A112</span></div></td>	
<?php } ?>
<?php } // FIN DE SELECCION DE BOL01, NOR01, NOR02
?>	

<?php if($confi=="bol02"){ // formato BOL02
?>
		<td width="30" height="25"><div align="center"><span>IND11</span></div></td>	
                <td width="30"><div align="center"><span>IND12</span></div></td>
                <td width="30"><div align="center"><span>IND13</span></div></td>
                <td width="30"><div align="center"><span>IND14</span></div></td>

                <td width="30" style="background-color:4CC21A; font-color:#fff;"><div align="center"><span>ART112</span></div></td>

                <td width="30"><div align="center"><span>IND21</span></div></td>
                <td width="30"><div align="center"><span>IND22</span></div></td>
                <td width="30"><div align="center"><span>IND23</span></div></td>
                <td width="30"><div align="center"><span>IND24</span></div></td>

                <td width="30" style="background-color:4CC21A; font-color:#fff;"><div align="center"><span>ART112</span></div></td>

                <td width="30"><div align="center"><span>IND31</span></div></td>
                <td width="30"><div align="center"><span>IND32</span></div></td>
                <td width="30"><div align="center"><span>IND33</span></div></td>
                <td width="30"><div align="center"><span>IND34</span></div></td>

                <td width="30" style="background-color:4CC21A; font-color:#fff;"><div align="center"><span>ART112</span></div></td>	

                <td width="30"><div align="center"><span>IND41</span></div></td>
                <td width="30"><div align="center"><span>IND42</span></div></td>
                <td width="30"><div align="center"><span>IND43</span></div></td>
                <td width="30"><div align="center"><span>IND44</span></div></td>

                <td width="30" style="background-color:4CC21A; font-color:#fff;"><div align="center"><span>ART112</span></div></td>
<?php } //FIN BOL02
?>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_planilla['apellido'].", ".$row_planilla['nombre']; ?></span></div></td>


<?php if(($confi=="bol01") or ($confi=="nor01") or ($confi=="nor02")){ ?>

                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p1f1'.$i;?>" type="text" id="<? echo 'p1f1'.$i;?>" value="<?php echo $row_planilla['p1f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#00ff99;"><div align="center"><span><input name="<?php echo 'p1f2'.$i;?>" type="text" id="<? echo 'p1f2'.$i;?>" value="<?php echo $row_planilla['p1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p2f1'.$i;?>" type="text" id="<? echo 'p2f1'.$i;?>" value="<?php echo $row_planilla['p2f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#00ff99;"><div align="center"><span><input name="<?php echo 'p2f2'.$i;?>" type="text" id="<? echo 'p2f2'.$i;?>" value="<?php echo $row_planilla['p2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p3f1'.$i;?>" type="text" id="<? echo 'p3f1'.$i;?>" value="<?php echo $row_planilla['p3f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#00ff99;"><div align="center"><span><input name="<?php echo 'p3f2'.$i;?>" type="text" id="<? echo 'p3f2'.$i;?>" value="<?php echo $row_planilla['p3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p4f1'.$i;?>" type="text" id="<? echo 'p4f1'.$i;?>" value="<?php echo $row_planilla['p4f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#00ff99;"><div align="center"><span><input name="<?php echo 'p4f2'.$i;?>" type="text" id="<? echo 'p4f2'.$i;?>" value="<?php echo $row_planilla['p4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

<?php if(($confi=="nor01") or ($confi=="nor02")){ ?>
                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p5f1'.$i;?>" type="text" id="<? echo 'p5f1'.$i;?>" value="<?php echo $row_planilla['p5f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

                <td style="border-left:1px solid; background-color:#00ff99;"><div align="center"><span><input name="<?php echo 'p5f2'.$i;?>" type="text" id="<? echo 'p5f2'.$i;?>" value="<?php echo $row_planilla['p5f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
<?php } ?>

<?php if ($confi=="nor02"){ ?>
                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'p6f1'.$i;?>" type="text" id="<? echo 'p6f1'.$i;?>" value="<?php echo $row_planilla['p6f1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
<?php } ?>

<?php if (($confi=="nor01")and($tipofl==1)) { ?>
                <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'flf1'.$i;?>" type="text" id="<? echo 'flf1'.$i;?>" value="<?php echo $row_planilla['flf1']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
                <td style="border-left:1px solid; background-color:#00ff99;"><div align="center"><span><input name="<?php echo 'flf2'.$i;?>" type="text" id="<? echo 'flf2'.$i;?>" value="<?php echo $row_planilla['flf2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
<?php } ?>

<?php if ($confi=="nor01"){ ?>
<input type="hidden" name="<?php echo 'indtotal'.$i;?>"  id="<?php echo 'indtotal'.$i;?>" value="<?php echo $row_planilla['indtotal']; ?>" >
<?php }?>
<?php if ($confi=="bol01"){ ?>
<input type="hidden" name="<?php echo '30_sc'.$i;?>"  id="<?php echo '30_sc'.$i;?>" value="<?php echo $row_planilla['30_sc']; ?>" >
<?php }?>

<input type="hidden" name="<?php echo 'ajuste'.$i;?>"  id="<?php echo 'ajuste'.$i;?>" value="<?php echo $row_planilla['ajuste']; ?>" >

<?php } // FIN DE SELECCION DE BOL01, NOR01, NOR02
?>	

<?php if($confi=="bol02"){ // formato BOL02
?>

 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind11'.$i;?>" type="text" id="<? echo 'ind11'.$i;?>" value="<?php echo $row_planilla['ind11']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind12'.$i;?>" type="text" id="<? echo 'ind12'.$i;?>" value="<?php echo $row_planilla['ind12']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind13'.$i;?>" type="text" id="<? echo 'ind13'.$i;?>" value="<?php echo $row_planilla['ind13']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind14'.$i;?>" type="text" id="<? echo 'ind14'.$i;?>" value="<?php echo $row_planilla['ind14']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#4CC21A;"><div align="center"><span><input name="<?php echo 'n1f2'.$i;?>" type="text" id="<? echo 'n1f2'.$i;?>" value="<?php echo $row_planilla['n1f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind21'.$i;?>" type="text" id="<? echo 'ind21'.$i;?>" value="<?php echo $row_planilla['ind21']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind22'.$i;?>" type="text" id="<? echo 'ind22'.$i;?>" value="<?php echo $row_planilla['ind22']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind23'.$i;?>" type="text" id="<? echo 'ind23'.$i;?>" value="<?php echo $row_planilla['ind23']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind24'.$i;?>" type="text" id="<? echo 'ind24'.$i;?>" value="<?php echo $row_planilla['ind24']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#4CC21A;"><div align="center"><span><input name="<?php echo 'n2f2'.$i;?>" type="text" id="<? echo 'n2f2'.$i;?>" value="<?php echo $row_planilla['n2f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind31'.$i;?>" type="text" id="<? echo 'ind31'.$i;?>" value="<?php echo $row_planilla['ind31']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind32'.$i;?>" type="text" id="<? echo 'ind32'.$i;?>" value="<?php echo $row_planilla['ind32']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind33'.$i;?>" type="text" id="<? echo 'ind33'.$i;?>" value="<?php echo $row_planilla['ind33']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind34'.$i;?>" type="text" id="<? echo 'ind34'.$i;?>" value="<?php echo $row_planilla['ind34']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#4CC21A;"><div align="center"><span><input name="<?php echo 'n3f2'.$i;?>" type="text" id="<? echo 'n3f2'.$i;?>" value="<?php echo $row_planilla['n3f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind41'.$i;?>" type="text" id="<? echo 'ind41'.$i;?>" value="<?php echo $row_planilla['ind41']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind42'.$i;?>" type="text" id="<? echo 'ind42'.$i;?>" value="<?php echo $row_planilla['ind42']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind43'.$i;?>" type="text" id="<? echo 'ind43'.$i;?>" value="<?php echo $row_planilla['ind43']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>
 <td style="border-left:1px solid; background-color:#fffccc;"><div align="center"><span><input name="<?php echo 'ind44'.$i;?>" type="text" id="<? echo 'ind44'.$i;?>" value="<?php echo $row_planilla['ind44']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

 <td style="border-left:1px solid; background-color:#4CC21A;"><div align="center"><span><input name="<?php echo 'n4f2'.$i;?>" type="text" id="<? echo 'n4f2'.$i;?>" value="<?php echo $row_planilla['n4f2']; ?>" style="width: 30px; height: 15px; font-size:9px;" /></span></div></td>

<?php } ?>




                <input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="<?php echo $row_planilla['id']; ?>" >
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar Calificaciones">    </td></tr>

            </table>
<?php // FIN AJUSTE DE NOTAS

?>

<input type="hidden" name="p1" id="p1" value="<?php echo $row_confiplanilla['p1'];?>"/>
<input type="hidden" name="p2" id="p2" value="<?php echo $row_confiplanilla['p2'];?>"/>
<input type="hidden" name="p3" id="p3" value="<?php echo $row_confiplanilla['p3'];?>"/>
<input type="hidden" name="p4" id="p4" value="<?php echo $row_confiplanilla['p4'];?>"/>
<input type="hidden" name="p5" id="p5" value="<?php echo $row_confiplanilla['p5'];?>"/>
<input type="hidden" name="p6" id="p6" value="<?php echo $row_confiplanilla['p6'];?>"/>

<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_planilla; ?>" >

<input type="hidden" name="MM_update" value="modi_form">
</form>

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
                  <span class="titulo_grande_gris">Error... no estas autorizado para realizar esta tarea..</span><span class="texto_mediano_gris"><br>
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
mysql_free_result($confip);

mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($planilla);

mysql_free_result($confiplanilla);

mysql_free_result($lapso);

mysql_free_result($supervisor);

?>
