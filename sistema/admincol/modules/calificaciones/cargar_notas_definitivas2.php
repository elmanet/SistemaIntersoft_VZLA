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
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);

$colname_reporte = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_reporte = $_GET['asignatura_id'];
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
if (isset($_GET['asignatura_id'])) {
  $colname_planilla = $_GET['asignatura_id'];
}
$lap_planilla = "-1";
if (isset($_GET['lapso'])) {
  $lap_planilla = $_GET['lapso'];
}
$confi=$row_confip['codfor'];

if ($confi=="bol01"){ // inicio de if
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso = %s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}// fin if

if ($confi=="bol02"){ // inicio de if
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso = %s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}// fin if

if ($confi=="nor01"){ // inicio de if
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso = %s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}// fin if

if ($confi=="nor02"){ // inicio de if
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso = %s ORDER BY b.cedula ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);
}// fin if

mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT a.id, a.username, a.password, a.gid, c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id  FROM jos_users a, jos_docente b, jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE  a.id=b.joomla_id AND b.id=c.docente_id AND c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id ORDER BY d.nombre, c.id, f.descripcion ASC", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);


//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_confiplanilla = $_GET['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "text"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT * FROM jos_lapso_encurso");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confi = mysql_query($query_confi, $sistemacol) or die(mysql_error());
$row_confi = mysql_fetch_assoc($confi);
$totalRows_confi = mysql_num_rows($confi);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
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
 <td valign="top" align="left" class="texto_mediano_gris" >
<h1><img src="../../images/png/apply_f2.png" border="0" align="absmiddle">&nbsp;&nbsp;Calificaciones cargadas con Exito!</h1>

<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">

	<h3>Selecciona otra Asignatura a cargar Calificaciones... </h3>
	<form action="cargar_notas_definitivas1.php" method="POST" name="f1">
	</td></tr><tr><td><img src="../../images/gif/construccion-plantilla.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<select name="asignatura_id" class="texto_mediano_gris" id="asignatura_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_docente['mate']; ?>"><?php echo $row_docente['nombre']." de ".$row_docente['anio']." ".$row_docente['descripcion']; ?></option>
           <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
           mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
         </select>
	 <select name="lapso" class="texto_mediano_gris" id="lapso">
          <option value="1">1er Lapso</option>
          <option value="2">2do Lapso</option>
          <option value="3">3er Lapso</option>
         </select>
          <span class="texto_mediano_gris">Clave del Supervisor:</span>
          <input type="password" id="pass" name="pass" value=""/>
	<input type="submit" name="buttom" value="Buscar >" />
	</td></tr>
	<tr><td>
		
	</td></tr>
	</form>
<tr><td>
&nbsp;&nbsp;
</td></tr>
    </table>


<?php // CARGA DE NOTAS
if(($_GET['asignatura_id']==$row_planilla['asignatura_id']) and ($_GET['lapso']==$row_planilla['lapso'])) { 

// FIN DE AJUSTES
?>

<table width="700" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="textogrande_eloy">

		<td width="80"><div align="center"><span>Cedula</span></div></td>
                <td width="270"><div align="center"><span>Apellidos y Nombres</span></div></td>
                <td width="30"><div align="center"><span>DEF</span></div></td>

              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_planilla['apellido'].", ".$row_planilla['nombre']; ?></span></div></td>

		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['def']; ?></span></div></td>

                
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)) ; ?>


            </table>
<?php // FIN AJUSTE DE NOTAS

?>


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

mysql_free_result($docente);

mysql_free_result($confi);
?>
