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
if (isset($_GET['curso_id'])) {
  $colname_reporte = $_GET['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, b.no_lista, d.nombre, e.descripcion FROM jos_alumno_info a, jos_alumno_curso b, jos_curso c, jos_anio_nombre d, jos_seccion e WHERE a.alumno_id=b.alumno_id AND b.curso_id=c.id AND c.anio_id=d.id AND c.seccion_id=e.id AND a.cursando=1 AND b.curso_id= %s  ORDER BY b.no_lista ASC " , GetSQLValueString($colname_reporte, "int"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

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

$colname_seccion = "-1";
if (isset($_GET['anio_id'])) {
  $colname_seccion = $_GET['anio_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_seccion = sprintf("SELECT a.id, c.nombre, b.descripcion FROM jos_curso a, jos_seccion b, jos_anio_nombre c WHERE a.seccion_id=b.id AND a.anio_id=c.id AND a.anio_id= %s ORDER BY c.nombre ASC", GetSQLValueString($colname_seccion, "text"));
$seccion = mysql_query($query_seccion, $sistemacol) or die(mysql_error());
$row_seccion = mysql_fetch_assoc($seccion);
$totalRows_seccion = mysql_num_rows($seccion);

$colname_docente = "-1";
if (isset($_GET['curso_id'])) {
  $colname_docente = $_GET['curso_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT c.id as mate, d.nombre, f.descripcion, g.nombre as anio, e.id as curso_id  FROM jos_asignatura c, jos_asignatura_nombre d, jos_curso e, jos_seccion f, jos_anio_nombre g WHERE c.asignatura_nombre_id=d.id AND c.curso_id=e.id AND e.seccion_id=f.id AND e.anio_id=g.id AND e.id= %s", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_lapso = sprintf("SELECT *  FROM jos_lapso_encurso");
$lapso = mysql_query($query_lapso, $sistemacol) or die(mysql_error());
$row_lapso = mysql_fetch_assoc($lapso);
$totalRows_lapso = mysql_num_rows($lapso);


// INSERTAR DATOS MULTIPLES

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha= $_POST['ano']."-".$_POST['mes']."-".$_POST['dia'];
//corregir

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_form")) {
$total=$_POST["totalalum"];
//En este punto establezco la variable $i que me ayudara a contar el numero de veces que se debe ejecutar el do ... while
$i = 0;
do { 
   $i++;

	if($_POST['valor'.$i]==1){

if($_POST['valor2'.$i]==1){
$inasistencia_alumno=$_POST['inasistencia_alumno'.$i];
}else{
$inasistencia_alumno=$_POST['inasistencia'];
}

     $insertSQL = sprintf("INSERT INTO jos_alumno_asistencia (id, alumno_id, asignatura_id, lapso, inasistencia, inasistencia_alumno, justificativo, fecha_inasistencia) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'.$i], "int"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"),                           
                            GetSQLValueString($_POST['inasistencia'], "int"),
                            GetSQLValueString($inasistencia_alumno, "int"),
                            GetSQLValueString($_POST['justificativo'.$i], "text"),
                            GetSQLValueString($fecha, "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}

} while ($i+1 <= $total );

// SI HAY ASISTENCIA TOTAL

	if($_POST['si']==1){

$alumno=0;
$justificativo="";

     $insertSQL = sprintf("INSERT INTO jos_alumno_asistencia (id, alumno_id, asignatura_id, lapso, inasistencia, inasistencia_alumno, justificativo, fecha_inasistencia) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['id'], "int"),
                            GetSQLValueString($alumno, "int"),
                            GetSQLValueString($_POST['asignatura_id'], "int"),
                            GetSQLValueString($_POST['lapso'], "int"),                            
                            GetSQLValueString($_POST['inasistencia'], "int"),
                            GetSQLValueString($inasistencia_alumno, "int"),
                            GetSQLValueString($justificativo, "text"),
                            GetSQLValueString($_POST['fecha_inasistencia'], "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
}



  $insertGoTo = "asistencia_alumno.php";
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
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr>

 <td valign="top" align="center" class="texto_mediano_gris" ><h2>Agregar Inasistencia a Estudiantes de <?php echo $row_reporte['nombre']. " ".$row_reporte['descripcion'];?></h2>

<?php // CARGA DE ASIGNACION DE SECCION

?>

<form action="<?php echo $editFormAction; ?>" name="new_form" id="new_form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">
    <h3 style="color:red;">IMPORTANTE: Los campos de la siguiente tabla son OBLIGATORIOS!</h3>
    <table style="background-color: #fffccc; border: 1px solid;" width="700"><tr>
            <td></td><td></td><td></td>
        </tr>
        <tr>
            <td>
        &nbsp;&nbsp;<b> Asignatura:</b> <select name="asignatura_id" class="texto_mediano_gris" id="asignatura_id">
         <option value="">..Selecciona</option>
           <?php do { ?>
              <option value="<?php echo $row_docente['mate']; ?>"><?php echo $row_docente['nombre']; ?></option>
           <?php } while ($row_docente = mysql_fetch_assoc($docente));
  	   $rows = mysql_num_rows($docente);
  	   if($rows > 0) {
           mysql_data_seek($docente, 0);
	  $row_docente = mysql_fetch_assoc($docente);
		 }
	   ?>
         </select></td><td>
         
             <b> Horas de Clase:</b> <input type="text" class="texto_pequeno_gris" size="2" maxlength="2" name="inasistencia" id="inasistencia" value="" /> hora(s)
          <br /><br />
                <b>Fecha de la Clase:<br /><br /> </b> <span class="texto_mediano_gris"> D&iacute;a <input type="text" size="3" maxlength="2" class="texto_pequeno_gris" name="dia" value="<?php echo $_GET['dia'];?>" /> Mes <input type="text" size="3" class="texto_pequeno_gris" maxlength="2" name="mes" value="<?php echo $_GET['mes'];?>" /> A&ntilde;o <input type="text" size="5" class="texto_pequeno_gris" maxlength="4" name="ano" value="<?php echo date(Y);?>" /></span>
<br />  <br />          
            </td>
        </tr>
      <tr>
           <td colspan="4"><span class="texto_grande_gris" style="color:red;">Cierra Ventana para seleccionar otra secci&oacute;n</span> <!-- <b>Selecciona aqui si hubo asistencia Total: </b><input type="checkbox" name="si" id="si" value="1" /> --></td></tr>
    </table>
<br />
<h3 style="color:green;">Selecciona &uacute;nicamente los estudiantes que faltaron a la clase!</h3>
<table width="800" style="font-size:9px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              
	     
	      <tr bgcolor="#00FF99" class="texto_pequeno_gris">
                <td width="50"><div align="center"><span>No. Lista</span></div></td>
		<td width="50"><div align="center"><span>Cedula</span></div></td>
                <td width="300"><div align="center"><span>Apellidos y Nombres</span></div></td>
                <td width="50"><div align="center"><span>Seleccionar</span></div></td>
            <!--    <td width="100"><div align="center"><span>Inasistencia</span></div></td>-->
                <td><div align="center"><span>Justificativo</span></div></td>


              </tr>


              <?php 
 		$i = 0;
		
		do { $i++;  ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_reporte['no_lista']; ?></span></div></td>
		<td height="26"  style="border-left:1px solid"><div align="center"><span><?php echo $row_reporte['cedula']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_reporte['apellido'].", ".$row_reporte['nomalum']; ?></span></div></td>
              <td style="border-left:1px solid"><div align="center"><span><input type="checkbox" name="<?php echo 'valor'.$i;?>" id="<? echo 'valor'.$i;?>" value="1" />
                 <input type="hidden" name="<?php echo 'alumno_id'.$i;?>" id="<? echo 'alumno_id'.$i;?>" value="<?php echo $row_reporte['alumno_id']; ?>" /></span></div></td>
               <!--   <td style="border-left:1px solid"><div align="center"><span><input type="checkbox" name="<?php echo 'valor2'.$i;?>" id="<? echo 'valor2'.$i;?>" value="1" />
                 <input type="text" name="<?php echo 'inasistencia_alumno'.$i;?>" id="<? echo 'inasistencia_alumno'.$i;?>" value="" class="texto_pequeno_gris" size="2" /></span></div></td>-->
               
<td style="border-left:1px solid"><div align="center"><span><input type="text" size="32" maxlength="250" name="<?php echo 'justificativo'.$i;?>" id="<? echo 'justificativo'.$i;?>" value="" /></span></div>
<input type="hidden" name="<?php echo 'id'.$i;?>"  id="<?php echo 'id'.$i;?>" value="" >
<input type="hidden" name="lapso"  id="lapso" value="<?php echo $row_lapso['cod']; ?>" >
<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_reporte; ?>" >

</td>
                
              </tr>
              <?php } while ($row_reporte = mysql_fetch_assoc($reporte)); ?>


<tr style="background-color:#fffccc;" height="30" > <td colspan="26" align="right"><span><b>Verifica los Datos y presiona una (1) sola vez click...</b> &nbsp;&nbsp;</span><input name="Actualizar" type="submit" value="Cargar Inasistencia">    </td></tr>

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
        
<?php if ($totalRows_reporte == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen Estudiantes para Asignar!!!</span><span class="texto_mediano_gris"><br>
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

mysql_free_result($colegio);

mysql_free_result($seccion);

mysql_free_result($curso);

mysql_free_result($docente);

mysql_free_result($lapso);

?>
