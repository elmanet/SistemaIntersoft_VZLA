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

// 	GRABADO EN LA TABLA 

$pruebas= $_POST['cant_pruebas'];
$po1=$_POST['p1'];
$po2=$_POST['p2'];
$po3=$_POST['p3'];
$po4=$_POST['p4'];
$po5=$_POST['p5'];
$po6=$_POST['p6'];
$totalporcentaje=($po1+$po2+$po3+$po4+$po5+$po6);

if ((!empty($pruebas)) and ($totalporcentaje==100)) { 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha1= $_POST['ano1']."-".$_POST['mes1']."-".$_POST['dia1'];
$fecha2= $_POST['ano2']."-".$_POST['mes2']."-".$_POST['dia2'];
$fecha3= $_POST['ano3']."-".$_POST['mes3']."-".$_POST['dia3'];
$fecha4= $_POST['ano4']."-".$_POST['mes4']."-".$_POST['dia4'];
$fecha5= $_POST['ano5']."-".$_POST['mes5']."-".$_POST['dia5'];
//corregir

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

   $updateSQL = sprintf("UPDATE jos_formato_evaluacion_planilla SET asignatura_id=%s, lapso=%s, nombre_proyecto=%s, cant_pruebas=%s, isc1=%s, isc2=%s, isc3=%s, isc4=%s, p1=%s, p2=%s, p3=%s, p4=%s, p5=%s, p6=%s, info1=%s, tipo_eva1=%s, fecha1=%s, info2=%s, tipo_eva2=%s, fecha2=%s, info3=%s, tipo_eva3=%s, fecha3=%s, info4=%s, tipo_eva4=%s, fecha4=%s, info5=%s, tipo_eva5=%s, fecha5=%s WHERE id=%s",

							GetSQLValueString($_POST['asignatura_id'], "int"),
							GetSQLValueString($_POST['lapso'], "int"),
							GetSQLValueString($_POST['nombre_proyecto'], "text"),
							GetSQLValueString($_POST['cant_pruebas'], "int"),
							GetSQLValueString($_POST['isc1'], "text"),
							GetSQLValueString($_POST['isc2'], "text"),
							GetSQLValueString($_POST['isc3'], "text"),
							GetSQLValueString($_POST['isc4'], "text"),
							GetSQLValueString($_POST['p1'], "int"),
							GetSQLValueString($_POST['p2'], "int"),
							GetSQLValueString($_POST['p3'], "int"),
							GetSQLValueString($_POST['p4'], "int"),
                                                        GetSQLValueString($_POST['p5'], "int"),
                                                        GetSQLValueString($_POST['p6'], "int"),
							GetSQLValueString($_POST['info1'], "text"),
							GetSQLValueString($_POST['tipo_eva1'], "text"),
							GetSQLValueString($fecha1, "date"),
							GetSQLValueString($_POST['info2'], "text"),
							GetSQLValueString($_POST['tipo_eva2'], "text"),
							GetSQLValueString($fecha2, "date"),
							GetSQLValueString($_POST['info3'], "text"),
							GetSQLValueString($_POST['tipo_eva3'], "text"),
							GetSQLValueString($fecha3, "date"),
							GetSQLValueString($_POST['info4'], "text"),
							GetSQLValueString($_POST['tipo_eva4'], "text"),
							GetSQLValueString($fecha4, "date"),
           					        GetSQLValueString($_POST['info5'], "text"),
							GetSQLValueString($_POST['tipo_eva5'], "text"),
							GetSQLValueString($fecha5, "date"),
							GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "seleccionar_anio_carga_notas2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}
 header(sprintf("Location: %s", $updateGoTo));
}

}


// CONSULTA SQL

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confi = mysql_query($query_confi, $sistemacol) or die(mysql_error());
$row_confi = mysql_fetch_assoc($confi);
$totalRows_confi = mysql_num_rows($confi);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso ");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

$colname_docente = "-1";
if (isset($_POST['asignatura_id'])) {
  $colname_docente = $_POST['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.name, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id  FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id AND c.id = %s", GetSQLValueString($colname_docente, "int"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

// CONSULTA POR POST

$colname_confiplanilla = "-1";
if (isset($_POST['id'])) {
  $colname_confiplanilla = $_POST['id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE id = %s ", GetSQLValueString($colname_confiplanilla, "text"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);


//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
</head>

<center>
<body>

<?php if ($row_docente['gid']==19) { // INICIO DE LA RESTRICCION DE SESIONES ?>

<table width="680" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top"><h3>Modificar Planilla de Calificaciones </h3>



<?php // MODIFICAR

 ?>

<table><tr><td>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
	<span class="texto_mediano_gris"><b>Asignatura:</b> <?php echo $row_docente['nombre']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>A&ntilde;o y Secci&oacute;n:</b> <?php echo $row_docente['anio']." ".$row_docente['descripcion']; ?></span>
	</td></tr>
	<tr><td>
	<span class="texto_mediano_gris"><b>Docente:</b> <?php echo $row_docente['name']; ?></span>
	</td></tr>	   
	<tr><td>
	<span class="texto_mediano_gris"><b>Nombre del Proyecto:</b></span>
	<input name="nombre_proyecto"  class="texto_mediano_gris" type="text" size="50" id="nombre_proyecto" value="<?php echo $row_confiplanilla['nombre_proyecto']; ?>">
	</td></tr>
<tr><td align="left">Cantidad de Evaluaciones y Ponderaciones: 
</td></tr>
<tr><td>
       <select name="cant_pruebas" id="cant_pruebas">
	     <option value="<?php echo $row_confiplanilla['cant_pruebas']; ?>"><?php echo $row_confiplanilla['cant_pruebas']; ?></option>

	     <option value="3">3</option>
	     <option value="4">4</option>
             <?php  if($row_confi['codfor']== "nor01"){?>
               <option value="5">5</option>
             <?php } ?>
             <?php  if($row_confi['codfor']== "nor02"){?>
               <option value="5">5</option>
               <option value="6">6</option>
             <?php } ?>
        </select>

       <select name="p1" id="p1">
             <option value="<?php echo $row_confiplanilla['p1']; ?>"><?php echo $row_confiplanilla['p1']; ?>%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
        </select>

       <select name="p2" id="p2">
             <option value="<?php echo $row_confiplanilla['p2']; ?>"><?php echo $row_confiplanilla['p2']; ?>%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>>
        </select>

       <select name="p3" id="p3">
             <option value="<?php echo $row_confiplanilla['p3']; ?>"><?php echo $row_confiplanilla['p3']; ?>%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>

        </select>

       <select name="p4" id="p4">
             <option value="<?php echo $row_confiplanilla['p4']; ?>"><?php echo $row_confiplanilla['p4']; ?>%</option>
	     <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
	     <option value="50">50%</option>
        </select>

   <?php  if(($row_confi['codfor']== "nor01") or ($row_confi['codfor']=="nor02")){?>
           <select name="p5" id="p5">
             <option value="<?php echo $row_confiplanilla['p5']; ?>"><?php echo $row_confiplanilla['p5']; ?>%</option>
	     <option value="">%</option>
	     <option value="10">10%</option>
	     <option value="15">15%</option>
	     <option value="20">20%</option>
	     <option value="25">25%</option>
	     <option value="30">30%</option>
	     <option value="35">35%</option>
	     <option value="50">50%</option>
            </select>
   <?php } ?>

<?php  if($row_confi['codfor']== "nor02"){?>
<span class="texto_mediano_gris"><b>Ser y Convivir: <span style="font-size:15px;"><?php echo $row_confiplanilla['p6']; ?>%</span></b></span>
<input type="hidden" name="p6" id="p6" value="<?php echo $row_confiplanilla['p6']; ?>"/>
<?php }?>
</td></tr>

<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #1:</b></span>
	<input class="texto_mediano_gris" name="isc1" type="text" id="isc1" value="<?php echo $row_confiplanilla['isc1']; ?>">
	</td></tr>
<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc1" type="hidden" id="isc1" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #1:</b></span>
	<input class="texto_mediano_gris" name="isc1" type="text" id="isc1" value="<?php echo $row_confiplanilla['isc1']; ?>">
	</td></tr>
<?php }?>



<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #2:</b></span>
	<input class="texto_mediano_gris" name="isc2" type="text" id="isc2" value="<?php echo $row_confiplanilla['isc2']; ?>">
	</td></tr>
<?php }?>

<?php if (($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<input name="isc2" type="hidden" id="isc2" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #2:</b></span>
	<input class="texto_mediano_gris" name="isc2" type="text" id="isc2" value="<?php echo $row_confiplanilla['isc2']; ?>">
	</td></tr>
<?php }?>



<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #3:</b></span>
	<input class="texto_mediano_gris" name="isc3" type="text" id="isc3" value="<?php echo $row_confiplanilla['isc3']; ?>">
	</td></tr>
<?php }?>

<?php if ($row_confi['codfor']=="bol02"){?>
	<input name="isc3" type="hidden" id="isc3" value=""/>
<?php } ?>

<?php if (($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Rasgo de Personalidad #3:</b></span>
	<input class="texto_mediano_gris" name="isc3" type="text" id="isc3" value="<?php echo $row_confiplanilla['isc3']; ?>">
	</td></tr>
<?php }?>



<?php if ($row_confi['codfor']=="bol01"){?>
	<tr><td>
	<span class="texto_mediano_gris"><b>Indicador #4:</b></span>
	<input class="texto_mediano_gris" name="isc4" type="text" id="isc4" value="<?php echo $row_confiplanilla['isc4']; ?>">
	</td></tr>
<?php }else{?>
		<input name="isc4" type="hidden" id="isc4" value="">
<?php } ?>


<tr><td align="left" class="texto_mediano_gris"><b>Informaci&oacute;n de la 1eras. Evaluaci&oacute;n:</b>
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info1"><?php echo $row_confiplanilla['info1']; ?></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01")or($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span >Tipo de Evaluacion 1:</span>
	<input name="tipo_eva1"  class="texto_mediano_gris" type="text" id="tipo_eva1" value="<?php echo $row_confiplanilla['tipo_eva1']; ?>">
	</td></tr>
<?php }else{?>
		<input class="texto_mediano_gris" name="tipo_eva1" type="hidden" id="tipo_eva1" value="">
<?php } ?>


<tr><td align="left">Fecha de la 1era. Evaluaci&oacute;n: 
</td></tr>
<tr><td>
<?
$f1 = $row_confiplanilla['fecha1'];
$ano1 = substr($f1, -10, 4);
$mes1 = substr($f1, -5, 2);
$dia1 = substr($f1, -2, 2);
?>
<select name="dia1" id="dia1">
             <option value="<?php echo $dia1; ?>"><?php echo $dia1; ?></option>
	     <option value="">---</option>
             <option value="01">01</option>
             <option value="02">02</option>
             <option value="03">03</option>
             <option value="04">04</option>
             <option value="05">05</option>
             <option value="06">06</option>
             <option value="07">07</option>
             <option value="08">08</option>
             <option value="09">09</option>
             <option value="10">10</option>
         	 <option value="11">11</option>
		<option value="12">12</option>
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>  
		 <option value="31">31</option>                        


             </select>
             <select name="mes1" id="mes1">
             <option value="<?php echo $mes1; ?>"><?php if($mes1==1){echo "Enero"; }if($mes1==2){echo "Febrero"; }if($mes1==3){echo "Marzo"; }if($mes1==4){echo "Abril"; }if($mes1==5){echo "Mayo"; }if($mes1==6){echo "Junio"; }if($mes1==7){echo "Julio"; }if($mes1==8){echo "Agosto"; }if($mes1==9){echo "Septiembre"; }if($mes1==10){echo "Octubre"; }if($mes1==11){echo "Noviembre"; }if($mes1==12){echo "Diciembre"; } ?></option>
	     <option value="">---</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>                          
             </select>
             <select name="ano1" id="ano1">
             <option value="<?php echo $ano1; ?>"><?php echo $ano1; ?></option>
	     <option value="">---</option>
             <option value="2013">2013</option>
	     <option value="2014">2014</option>
             </select>

</td></tr>

<tr><td align="left" class="texto_mediano_gris"><b>Informaci&oacute;n de la 2da. Evaluaci&oacute;n:</b>
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info2"><?php echo $row_confiplanilla['info2']; ?></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01")or($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span>Tipo de Evaluacion 2:</span>
	<input name="tipo_eva2"  class="texto_mediano_gris" type="text" id="tipo_eva2" value="<?php echo $row_confiplanilla['tipo_eva2']; ?>">
	</td></tr>
<?php }else{?>
		<input class="texto_mediano_gris" name="tipo_eva2" type="hidden" id="tipo_eva2" value="">
<?php } ?>

<tr>
<td align="left">Fecha de la 2da. Evaluaci&oacute;n: 
</td></tr>
<tr><td>
<?
$f2 = $row_confiplanilla['fecha2'];
$ano2 = substr($f2, -10, 4);
$mes2 = substr($f2, -5, 2);
$dia2 = substr($f2, -2, 2);
?>
<select name="dia2" id="dia2">
             <option value="<?php echo $dia2; ?>"><?php echo $dia2; ?></option>
	     <option value="">---</option>
             <option value="01">01</option>
             <option value="02">02</option>
             <option value="03">03</option>
             <option value="04">04</option>
             <option value="05">05</option>
             <option value="06">06</option>
             <option value="07">07</option>
             <option value="08">08</option>
             <option value="09">09</option>
             <option value="10">10</option>
         	 <option value="11">11</option>
		<option value="12">12</option>
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>  
		 <option value="31">31</option>                        
             </select>

             <select name="mes2" id="mes2">
             <option value="<?php echo $mes2; ?>"><?php if($mes2==1){echo "Enero"; }if($mes2==2){echo "Febrero"; }if($mes2==3){echo "Marzo"; }if($mes2==4){echo "Abril"; }if($mes2==5){echo "Mayo"; }if($mes2==6){echo "Junio"; }if($mes2==7){echo "Julio"; }if($mes2==8){echo "Agosto"; }if($mes2==9){echo "Septiembre"; }if($mes2==10){echo "Octubre"; }if($mes2==11){echo "Noviembre"; }if($mes2==12){echo "Diciembre"; } ?></option>
	     <option value="">---</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>                          
             </select>
             <select name="ano2" id="ano2">
             <option value="<?php echo $ano2; ?>"><?php echo $ano2; ?></option>    
	     <option value="">---</option>      
             <option value="2013">2013</option>
	     <option value="2014">2014</option>
             </select>

</td></tr>

<tr><td align="left" class="texto_mediano_gris"><b>Informaci&oacute;n de la 3era. Evaluaci&oacute;n:</b>
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info3"><?php echo $row_confiplanilla['info3']; ?></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01")or($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span >Tipo de Evaluacion 3:</span>
	<input class="texto_mediano_gris" name="tipo_eva3" type="text" id="tipo_eva3" value="<?php echo $row_confiplanilla['tipo_eva3']; ?>">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva3" type="hidden" id="tipo_eva3" value="">
<?php } ?>

<tr>
<td align="left">Fecha de la 3era. Evaluaci&oacute;n: 
</td></tr>
<tr><td>
<?
$f3 = $row_confiplanilla['fecha3'];
$ano3 = substr($f3, -10, 4);
$mes3 = substr($f3, -5, 2);
$dia3 = substr($f3, -2, 2);
?>
<select name="dia3" id="dia3">
             <option value="<?php echo $dia3; ?>"><?php echo $dia3; ?></option> 
	     <option value="">---</option>   
             <option value="01">01</option>
             <option value="02">02</option>
             <option value="03">03</option>
             <option value="04">04</option>
             <option value="05">05</option>
             <option value="06">06</option>
             <option value="07">07</option>
             <option value="08">08</option>
             <option value="09">09</option>
             <option value="10">10</option>
         	 <option value="11">11</option>
		<option value="12">12</option>
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>  
		 <option value="31">31</option>                        
             </select>
             <select name="mes3" id="mes3">
             <option value="<?php echo $mes3; ?>"><?php if($mes3==1){echo "Enero"; }if($mes3==2){echo "Febrero"; }if($mes3==3){echo "Marzo"; }if($mes3==4){echo "Abril"; }if($mes3==5){echo "Mayo"; }if($mes3==6){echo "Junio"; }if($mes3==7){echo "Julio"; }if($mes3==8){echo "Agosto"; }if($mes3==9){echo "Septiembre"; }if($mes3==10){echo "Octubre"; }if($mes3==11){echo "Noviembre"; }if($mes3==12){echo "Diciembre"; } ?></option> 
	     <option value="">---</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>                          
             </select>
             <select name="ano3" id="ano3">
	     <option value="">---</option>
             <option value="<?php echo $ano3; ?>"><?php echo $ano3; ?></option>                 
             <option value="2013">2013</option>
	     <option value="2014">2014</option>
             </select>

</td></tr>

<tr><td align="left" class="texto_mediano_gris"><b>Informaci&oacute;n de la 4ta. Evaluaci&oacute;n:</b>
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info4"><?php echo $row_confiplanilla['info4']; ?></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01")or($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span >Tipo de Evaluacion 4:</span>
	<input class="texto_mediano_gris" name="tipo_eva4" type="text" id="tipo_eva4" value="<?php echo $row_confiplanilla['tipo_eva4']; ?>">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva4" type="hidden" id="tipo_eva4" value="">
<?php } ?>

<tr>
<td align="left">Fecha de la 4ta. Evaluaci&oacute;n: 
</td></tr>
<tr><td>
<?
$f4 = $row_confiplanilla['fecha4'];
$ano4 = substr($f4, -10, 4);
$mes4 = substr($f4, -5, 2);
$dia4 = substr($f4, -2, 2);
?>
<select name="dia4" id="dia4">
             <option value="<?php echo $dia4; ?>"><?php echo $dia4; ?></option>  
	     <option value="">---</option> 
	     <option value="01">01</option>
             <option value="02">02</option>
             <option value="03">03</option>
             <option value="04">04</option>
             <option value="05">05</option>
             <option value="06">06</option>
             <option value="07">07</option>
             <option value="08">08</option>
             <option value="09">09</option>
             <option value="10">10</option>
         	 <option value="11">11</option>
		<option value="12">12</option>
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>  
		 <option value="31">31</option>                        
             </select>
             <select name="mes4" id="mes4">
             <option value="<?php echo $mes4; ?>"><?php if($mes4==1){echo "Enero"; }if($mes4==2){echo "Febrero"; }if($mes4==3){echo "Marzo"; }if($mes4==4){echo "Abril"; }if($mes4==5){echo "Mayo"; }if($mes4==6){echo "Junio"; }if($mes4==7){echo "Julio"; }if($mes4==8){echo "Agosto"; }if($mes4==9){echo "Septiembre"; }if($mes4==10){echo "Octubre"; }if($mes4==11){echo "Noviembre"; }if($mes4==12){echo "Diciembre"; } ?></option>
	     <option value="">---</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>                          
             </select>
             <select name="ano4" id="ano4">
	     <option value="">---</option>
             <option value="<?php echo $ano4; ?>"><?php echo $ano4; ?></option>               
             <option value="2013">2013</option>
	     <option value="2014">2014</option>
             </select>


</td></tr>


<tr><td align="left" class="texto_mediano_gris"><b>Informaci&oacute;n de la 5ta. Evaluaci&oacute;n:</b>
</td></tr>
<tr><td>
	<TEXTAREA COLS=32 ROWS=3 NAME="info5"><?php echo $row_confiplanilla['info5']; ?></TEXTAREA>
</td></tr>

<?php if (($row_confi['codfor']=="bol01")or($row_confi['codfor']=="nor01") or ($row_confi['codfor']=="nor02")){?>
	<tr><td>
	<span >Tipo de Evaluacion 5:</span>
	<input class="texto_mediano_gris" name="tipo_eva5" type="text" id="tipo_eva5" value="<?php echo $row_confiplanilla['info5']; ?>">
	</td></tr>
<?php }else{?>
		<input name="tipo_eva5" type="hidden" id="tipo_eva5" value="">
<?php } ?>

<tr>
<td align="left">Fecha de la 5ta. Evaluaci&oacute;n:
</td></tr>
<tr><td>
<?
$f5 = $row_confiplanilla['fecha5'];
$ano5 = substr($f5, -10, 4);
$mes5 = substr($f5, -5, 2);
$dia5 = substr($f5, -2, 2);
?>
<select name="dia5" id="dia5">
             <option value="<?php echo $dia5; ?>"><?php echo $dia5; ?></option>
	     <option value="">---</option>
	     <option value="01">01</option>
             <option value="02">02</option>
             <option value="03">03</option>
             <option value="04">04</option>
             <option value="05">05</option>
             <option value="06">06</option>
             <option value="07">07</option>
             <option value="08">08</option>
             <option value="09">09</option>
             <option value="10">10</option>
         	 <option value="11">11</option>
		<option value="12">12</option>
		 <option value="13">13</option>
		 <option value="14">14</option>
		 <option value="15">15</option>
		 <option value="16">16</option>
		 <option value="17">17</option>
		 <option value="18">18</option>
		 <option value="19">19</option>
		 <option value="20">20</option>
		 <option value="21">21</option>
		 <option value="22">22</option>
		 <option value="23">23</option>
		 <option value="24">24</option>
		 <option value="25">25</option>
		 <option value="26">26</option>
		 <option value="27">27</option>
		 <option value="28">28</option>
		 <option value="29">29</option>
		 <option value="30">30</option>
		 <option value="31">31</option>
             </select>
             <select name="mes5" id="mes5">
             <option value="<?php echo $mes5; ?>"><?php if($mes5==1){echo "Enero"; }if($mes5==2){echo "Febrero"; }if($mes5==3){echo "Marzo"; }if($mes5==4){echo "Abril"; }if($mes5==5){echo "Mayo"; }if($mes5==6){echo "Junio"; }if($mes5==7){echo "Julio"; }if($mes5==8){echo "Agosto"; }if($mes5==9){echo "Septiembre"; }if($mes5==10){echo "Octubre"; }if($mes5==11){echo "Noviembre"; }if($mes5==12){echo "Diciembre"; } ?></option>
	     <option value="">---</option>
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
             </select>
             <select name="ano5" id="ano5">
	     <option value=""></option>
             <option value="<?php echo $ano5; ?>"><?php echo $ano5; ?></option>
	     <option value="">---</option>
             <option value="2013">2013</option>
	     <option value="2014">2014</option>
             </select>


</td></tr>



<tr>
<td>
     
	<input name="id" type="hidden" id="id" value="<?php echo $row_confiplanilla['id']; ?>">
	<input name="asignatura_id" type="hidden" id="asignatura_id" value="<?php echo $row_confiplanilla['asignatura_id']; ?>">
	<input name="lapso" type="hidden" id="lapso" value="<?php echo $row_confiplanilla['lapso']; ?>">
	
	<input class="texto_mediano_gris" type="submit" name="buttom" value="Grabar Planilla >" />
	
	<input type="hidden" name="MM_update" value="form1">
      </form>


</td></tr>
</table>


<?php  // FIN DE FORM DE REGISTRO DE PLANILLA
 ?>

	
 <tr><td>
   &nbsp;&nbsp;
 </td></tr>
</table>

<?php } //FIN DE LA RESTRICCION DE SESIONES
?>
</body>
</center>
</html>
<?php

mysql_free_result($docente);

mysql_free_result($confi);

mysql_free_result($lapso);

mysql_free_result($confiplanilla);

?>
