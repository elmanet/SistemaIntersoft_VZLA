<?php
mb_http_input("iso-8859-1");
mb_http_output("iso-8859-1");
?>
<?php require_once('../Connections/colegionline.php'); ?>
<?php
session_start();
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

$MM_restrictGoTo = "admin_alumnoerror.php";
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
?>
<?php
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

$currentPage = $_SERVER["PHP_SELF"];

$colname_alumno = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_alumno = $_SESSION['MM_Username'];
}
mysql_select_db($database_colegionline, $colegionline);
$query_alumno = sprintf("SELECT * FROM alumno WHERE cedalum = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $colegionline) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);$colname_alumno = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_alumno = $_SESSION['MM_Username'];
}
mysql_select_db($database_colegionline, $colegionline);
$query_alumno = sprintf("SELECT * FROM alumno a, asignaturas b WHERE a.gradoalum=b.seccionmate AND cedalum = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $colegionline) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

mysql_select_db($database_colegionline, $colegionline);
$query_colegio = "SELECT * FROM colegio";
$colegio = mysql_query($query_colegio, $colegionline) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

mysql_select_db($database_colegionline, $colegionline);
$query_Recordset1 = "SELECT * FROM notialum";
$Recordset1 = mysql_query($query_Recordset1, $colegionline) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_colegionline, $colegionline);
$query_web = "SELECT * FROM version";
$web = mysql_query($query_web, $colegionline) or die(mysql_error());
$row_web = mysql_fetch_assoc($web);
$totalRows_web = mysql_num_rows($web);

$maxRows_mensaje = 10;
$pageNum_mensaje = 0;
if (isset($_GET['pageNum_mensaje'])) {
  $pageNum_mensaje = $_GET['pageNum_mensaje'];
}
$startRow_mensaje = $pageNum_mensaje * $maxRows_mensaje;

$colname_mensaje = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_mensaje = $_SESSION['MM_Username'];
}
mysql_select_db($database_colegionline, $colegionline);
$query_mensaje = sprintf("SELECT * FROM mensaje_docente_alum a, asignaturas b, alumno c WHERE a.codmate=b.codmate AND c.gradoalum=b.seccionmate AND c.cedalum = %s", GetSQLValueString($colname_mensaje, "text"));
$query_limit_mensaje = sprintf("%s LIMIT %d, %d", $query_mensaje, $startRow_mensaje, $maxRows_mensaje);
$mensaje = mysql_query($query_limit_mensaje, $colegionline) or die(mysql_error());
$row_mensaje = mysql_fetch_assoc($mensaje);

if (isset($_GET['totalRows_mensaje'])) {
  $totalRows_mensaje = $_GET['totalRows_mensaje'];
} else {
  $all_mensaje = mysql_query($query_mensaje);
  $totalRows_mensaje = mysql_num_rows($all_mensaje);
}
$totalPages_mensaje = ceil($totalRows_mensaje/$maxRows_mensaje)-1;

mysql_select_db($database_colegionline, $colegionline);
$query_fondo = "SELECT * FROM periodico_admin";
$fondo = mysql_query($query_fondo, $colegionline) or die(mysql_error());
$row_fondo = mysql_fetch_assoc($fondo);
$totalRows_fondo = mysql_num_rows($fondo);

$queryString_mensaje = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_mensaje") == false && 
        stristr($param, "totalRows_mensaje") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_mensaje = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_mensaje = sprintf("&totalRows_mensaje=%d%s", $totalRows_mensaje, $queryString_mensaje);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/main_central.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-size: 14px; font-style: normal; line-height: 13px; font-variant: normal; text-transform: none; color: #009933; text-decoration: none; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
</head>
<body>
<div id="contenedor_cetral">
  <table width="730" border="0" cellspacing="0" cellpadding="0">
	  <!--DWLayoutTable-->
	  <tr>
	    <td width="730" valign="top"><table width="700" border="0" align="center">
	      <tr>
	        <td width="686" align="center" valign="top"><?php if ($row_alumno['autoriza'] == 1) { // Show if recordset not empty ?>
	          <table width="700">
	            <tr>
	              <td width="100" valign="bottom"><div align="center"><a href="admin_alumno1.php"><img src="../images/png/home-big.png" width="64" height="64" border="0"></a></div></td>
	              <td width="100" valign="bottom"><div align="center"><a href="admin_aluminfo.php"><img src="../images/png/edit_user.png" width="60" height="60" border="0"></a></div></td>
	              <td width="100" valign="bottom"><div align="center"><a href="admin_alumno_calificaciones_lista.php"><img src="../images/png/notas2.PNG" width="61" height="61" border="0"></a></div></td>
	              <td width="100" align="center" valign="bottom"><a href="admin_alumno_horarioexa.php?seccionmate=<?php echo $row_alumno['gradoalum']; ?>"><img src="../images/png/Tasks.png" width="61" height="61" border="0" align="absmiddle"></a></td>
	              <td width="100" align="center" valign="bottom"><a href="#"><img src="../images/png/calendario.png" alt="" width="60" height="60" border="0"></a></td>
	              <td width="100" valign="bottom"><div align="center"><img src="../images/png/Mail4.png" alt="" width="61" height="61"></div></td>
	              <td width="100" valign="bottom"><div align="center"><a href="admin_alumno_tarea1.php?seccionmate=<?php echo $row_alumno['gradoalum']; ?>"><img src="../images/png/HEINSNEXTGEN APPLICATIONS.png" width="61" height="61" border="0"></a></div></td>
                </tr>
	            <tr>
	              <td valign="top" class="cartelera_eloy"><div align="center"><a href="admin_alumno1.php" class="cartelera_eloy">INICIO </a></div></td>
	              <td valign="top" class="cartelera_eloy"><div align="center"><a href="admin_aluminfo.php" class="cartelera_eloy">INFORMACION PERSONAL </a></div></td>
	              <td valign="top" class="cartelera_eloy"><div align="center"><a href="admin_alumno_calificaciones_lista.php" class="cartelera_eloy">CALIFICACIONES</a></div></td>
	              <td valign="top" class="cartelera_eloy"><div align="center"><a href="admin_alumno_horarioexa.php?seccionmate=<?php echo $row_alumno['gradoalum']; ?>" class="cartelera_eloy">HORARIO DE EXAMANES</a></div></td>
	              <td width="100" align="center" valign="top" class="cartelera_eloy"><a href="#" class="cartelera_eloy">HORARIO DE CLASES</a></td>
	              <td valign="top" class="cartelera_eloy"><div align="center">DOCUMENTOS DE ESTUDIO </div></td>
	              <td valign="top" class="cartelera_eloy"><div align="center"><a href="admin_alumno_tarea1.php?seccionmate=<?php echo $row_alumno['gradoalum']; ?>" class="cartelera_eloy">TAREAS</a></div></td>
                </tr>
	            <tr>
	              <td width="600" colspan="7" valign="middle" bgcolor="<?php echo $row_fondo['color']; ?>" class="cartelera_eloy">&nbsp;</td>
                </tr>
	            <tr>
	              <td colspan="7" valign="middle" class="cartelera_eloy"><table width="700" border="0" cellspacing="0" cellpadding="0">
	                <tr>
	                  <td width="250" align="center" valign="top"><table width="250" border="0" align="left" cellpadding="0" cellspacing="0">
	                    <tr>
	                      <td width="250" height="33" background="../images/png/imagenes/fon_alum_cole_01.png">&nbsp;</td>
	                      </tr>
	                    <tr>
	                      <td background="../images/png/imagenes/fon_alum_cole_02.png" style="background-repeat:repeat-x"><div style="font-family:Verdana, Geneva, sans-serif; font-size:10px; width:200px; height:auto; margin-top:15px; margin-left:22px; text-align:center;"> <strong class="titulo_grande_gris"><img src="../images/png/32px-Crystal_Clear_app_aim3.png" width="32" height="32" align="absmiddle"> Mis Mensajes!</strong><br>
	                        </span><span class="texto_mediano_gris"><br>
	                        <?php echo $row_Recordset1['noticia']; ?> <br>
	                        <br>
                          </div></td>
	                      </tr>
	                    <tr>
	                      <td height="34" background="../images/png/imagenes/fon_alum_cole_03.png">&nbsp;</td>
	                      </tr>
	                    </table>	                    
	                    <span class="textogrande_eloy"><br>
	                    </span></td>
	                  <td width="450" align="center" valign="top"><?php if ($totalRows_mensaje > 0) { // Show if recordset not empty ?>
                        <span class="titulo_grande_gris"><br>
                        <strong class="titulo_grande_gris"><img src="../images/png/32px-Crystal_Clear_kdm_user_male.png" width="32" height="32" align="absmiddle"></strong> Mensaje de los Docentes</span><br>
                        <br>
                        <table border="0" cellpadding="0" cellspacing="1">
                          <tr id="foncarte2">
                            <td width="200" height="21" align="center" bgcolor="<?php echo $row_fondo['color']; ?>"><strong><span class="texto_mediano_gris">Mensaje</span></strong></td>
                            <td width="80" align="center" bgcolor="<?php echo $row_fondo['color']; ?>"><strong><span class="texto_mediano_gris">Dia</span></strong></td>
                            <td width="50" align="center" bgcolor="<?php echo $row_fondo['color']; ?>" class="texto_mediano_gris"><strong>Hora</strong></td>
                            <td width="80" align="center" bgcolor="<?php echo $row_fondo['color']; ?>" class="texto_mediano_gris"><strong>Materia</strong></td>
                          </tr>
                          <?php do { ?>
                          <tr>
                            <td height="23" class="texto_mediano_gris" align="justify"><?php echo $row_mensaje['mensaje']; ?></td>
                            <td align="center" class="texto_mediano_gris"><?php echo $row_mensaje['dia']; ?></td>
                            <td align="center" class="texto_mediano_gris"><?php echo $row_mensaje['hora']; ?></td>
                            <td align="center" class="texto_mediano_gris"><?php echo $row_mensaje['nombremate']; ?></td>
                          </tr>
                          <tr>
                            <td height="3" colspan="4" align="center" bgcolor="<?php echo $row_fondo['color']; ?>" class="texto_mediano_gris">&nbsp;</td>
                            </tr>
                          <?php } while ($row_mensaje = mysql_fetch_assoc($mensaje)); ?>
                        </table>
                        <?php if ($pageNum_mensaje > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_mensaje=%d%s", $currentPage, max(0, $pageNum_mensaje - 1), $queryString_mensaje); ?>">&lt;&lt; Mensaje Anterior</a>
                        <?php } // Show if not first page ?>
                        <?php if ($pageNum_mensaje < $totalPages_mensaje) { // Show if not last page ?>
                        <?php if ($pageNum_mensaje == 0) { // Show if first page ?>
                        <a href="<?php printf("%s?pageNum_mensaje=%d%s", $currentPage, min($totalPages_mensaje, $pageNum_mensaje + 1), $queryString_mensaje); ?>">Siguiente Mensaje &gt;&gt;</a>
                        <?php } // Show if first page ?>
                        <?php } // Show if not last page ?>
                        <br>
                        <?php } // Show if recordset not empty ?></td>
	                  </tr>
                  </table></td>
                </tr>
              </table>
	          <p>
	            <?php } // Show if recordset not empty ?>
            </p></td>
          </tr>
	      <tr>
	        <td><?php if ($row_alumno['autoriza'] == 0) { // Show if recordset not empty ?>
	          <div align="center" class="textograndes_eloy"><span class="texto_mediano_gris">&quot;EL ALUMNO <strong><?php echo $row_alumno['nomalum']; ?></strong> AUN NO ESTA AUTORIZADO PARA TENER ACCESO AL SISTEMA AUTOMATIZADO DE COLEGIONLINE<br>
	            HASTA EL DIA QUE EMPIECE EL A&Ntilde;O ESCOLAR 2009 - 2010&quot;</span><br>
	            <?php } // Show if recordset not empty ?>
              </div>
	          <div align="center" class="textomediano_eloy"></div></td>
          </tr>
	      <tr>
	        <td><div align="center">
	          <hr width="500">
	          <span class="texto_mediano_gris">Dpto. Inform&aacute;tica - Coordinaci&oacute;n de Inform&aacute;tica<br>
	            Sistema colegionline &copy;<?php echo $row_web['ano']; ?> - version <?php echo $row_web['version']; ?> <br>
	              dise&ntilde;o <?php echo $row_web['nomempresa']; ?><br>
	              Todos los derechos reservados </span><br>
	        </div></td>
          </tr>
	      </table>
	      <br>
    <tr>
	        <td valign="top"></td>
  </table>
</div>

</body>
</html>
<?php
mysql_free_result($alumno);

mysql_free_result($colegio);

mysql_free_result($Recordset1);

mysql_free_result($web);

mysql_free_result($mensaje);

mysql_free_result($fondo);

?>
