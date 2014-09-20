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


//MODIFICAR LA TABLA DE ALUMNO CDC

$total=$_POST["total"];

// MODIFICAR TABLA ALUMNO INFO

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

$i=0;
do { 
   $i++;

$fecha_nac= $_POST['ano'.$i]."-".$_POST['mes'.$i]."-".$_POST['dia'.$i];

     $updateSQL = sprintf("update jos_alumno_info SET nombre=%s, apellido=%s, lugar_nacimiento=%s, ef=%s, cedula=%s, sexo=%s, fecha_nacimiento=%s, estado=%s WHERE alumno_id=%s",
                         
                            GetSQLValueString($_POST['nombre'.$i], "text"),
                            GetSQLValueString($_POST['apellido'.$i], "text"),
                            GetSQLValueString($_POST['lugar_nacimiento'.$i], "text"),
                            GetSQLValueString($_POST['ef'.$i], "text"),
                            GetSQLValueString($_POST['cedula'.$i], "biginit"),
                            GetSQLValueString($_POST['sexo'.$i], "text"),
                            GetSQLValueString($fecha_nac, "date"),
                            GetSQLValueString($_POST['ent_federal_pais'.$i], "text"),
                            GetSQLValueString($_POST['alumno_id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result7 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

 $updateGoTo = "proceso_fin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $updateGoTo));
}

//FIN CONSULTA
mysql_select_db($database_sistemacol, $sistemacol);
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);




$colname_asignatura = "-1";
if (isset($_POST['curso_id'])) {
  $colname_asignatura = $_POST['curso_id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_asignatura = sprintf("SELECT * FROM jos_curso a, jos_anio_nombre b, jos_seccion c WHERE a.anio_id=b.id AND a.seccion_id=c.id AND a.id = %s ", GetSQLValueString($colname_asignatura, "text"));
$asignatura = mysql_query($query_asignatura, $sistemacol) or die(mysql_error());
$row_asignatura = mysql_fetch_assoc($asignatura);
$totalRows_asignatura = mysql_num_rows($asignatura);


//MATERIA 1
//nombres
$colname_mate1 = "-1";
if (isset($_POST['curso_id'])) {
  $colname_mate1 = $_POST['curso_id'];
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_mate1 = sprintf("SELECT  a.alumno_id, a.cedula, a.nombre, a.apellido, a.cedula, a.lugar_nacimiento, a.fecha_nacimiento, a.sexo, a.ef, a.indicador_nacionalidad, a.estado FROM jos_alumno_info a, jos_alumno_curso b WHERE a.cursando=1 AND a.alumno_id=b.alumno_id AND b.curso_id = %s ORDER BY a.cedula ASC", GetSQLValueString($colname_mate1, "text"));
$mate1 = mysql_query($query_mate1, $sistemacol) or die(mysql_error());
$row_mate1 = mysql_fetch_assoc($mate1);
$totalRows_mate1 = mysql_num_rows($mate1);


mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
<script>
function todos_ept1(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept1"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept2(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept2"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept3(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox")
{
if(elemento.id =="ept3"){
elemento.checked = chkbox.checked
}
}
}
}

function todos_ept4(chkbox)
{
for (var i=0;i < document.forms[0].elements.length;i++)
{
var elemento = document.forms[0].elements[i]type="text" ;
if (elemento.type == "checkbox")
{
if(elemento.id =="ept4"){
elemento.checked = chkbox.checked
}
}
}
}
</script>

</head>
<body>
<center>
<?php if($totalRows_mate1>0){?>
<table width="1100"><tr><td>
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
		<td align="center">
			
		</td>
</td></tr></table>



<h3>Estudiantes de <?php echo $row_asignatura['nombre']." ".$row_asignatura['descripcion']; ?></h3>
<table width="1100"><tr>


<?php // MATERIA 1
?> 

<form action="<?php echo $editFormAction; ?>" method="POST" name="form">

<td>

<table><tr><td>
<tr>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
NO.
</td>
<td  class="ancho_td_cedula" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center">
CEDULA
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
APELLIDOS
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
NOMBRES
</td>
<td  class="ancho_td_nombre" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc;" align="center" >
LUGAR DE NAC.
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
E.F.
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
ESTADO
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
SEXO
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
D
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
M
</td>
<td  class="ancho_td_no" style="border-bottom:1px solid; border-right:1px solid; background-color:#fffccc; " align="center">
A
</td>
</tr>
<?php $lista=1; $i=1; do { ?>
<tr >

<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<span class="texto_pequeno_gris"><?php echo $lista; ?></span>
<input type="hidden" name="<?php echo 'alumno_id'.$i; ?>" value="<?php echo $row_mate1['alumno_id']; ?>" />


<input type="hidden" name="<?php echo 'no_alumno'.$i; ?>" value="<?php echo $lista; ?>" />
<input type="hidden" name="<?php echo 'id'.$i; ?>" value="" />
</td>
<td class="ancho_td_nombre3" style="border-right:1px solid; border-bottom:1px solid; " align="center" >
<span class="texto_mediano_gris"><input type="text" size="2" name="<?php echo 'indicador_nacionalidad'.$i; ?>" value="<?php echo $row_mate1['indicador_nacionalidad']; ?>" />-<input type="text" size="10" name="<?php echo 'cedula'.$i; ?>" value="<?php echo $row_mate1['cedula']; ?>" /></span>
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<input type="text" size="25" class="texto_pequeno_gris" name="<?php echo 'apellido'.$i; ?>" value="<?php echo $row_mate1['apellido']; ?>" />
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<input type="text" size="25" class="texto_pequeno_gris" name="<?php echo 'nombre'.$i; ?>" value="<?php echo $row_mate1['nombre']; ?>" />
</td>
<td  class="ancho_td_nombre3"style="border-right:1px solid; border-bottom:1px solid;" >
&nbsp;&nbsp;<input type="text" size="20" class="texto_pequeno_gris" name="<?php echo 'lugar_nacimiento'.$i; ?>" value="<?php echo $row_mate1['lugar_nacimiento']; ?>" />
</td>
<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" class="texto_pequeno_gris" size="2" name="<?php echo 'ef'.$i; ?>" value="<?php echo $row_mate1['ef']; ?>" />
</td>
<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" class="texto_pequeno_gris" size="12" name="<?php echo 'ent_federal_pais'.$i; ?>" value="<?php echo $row_mate1['estado']; ?>" />
</td>
<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" class="texto_pequeno_gris" size="1" name="<?php echo 'sexo'.$i; ?>" value="<?php echo $row_mate1['sexo']; ?>" />
</td>
<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
			<?php
			$fecha = $row_mate1['fecha_nacimiento'];
			$ano = substr($fecha, -10, 4);
			$mes = substr($fecha, -5, 2);
			$dia = substr($fecha, -2, 2);
			?>
<input type="text" class="texto_pequeno_gris" size="1" name="<?php echo 'dia'.$i; ?>" value="<?php echo $dia; ?>" />
</td>
<td class="ancho_td_no3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" class="texto_pequeno_gris" size="1" name="<?php echo 'mes'.$i; ?>" value="<?php echo $mes; ?>" />
</td>
<td class="ancho_td_cedula3" style="border-right:1px solid; border-bottom:1px solid;" align="center">
<input type="text" class="texto_pequeno_gris" size="4" name="<?php echo 'ano'.$i; ?>" value="<?php echo $ano; ?>" />
</td>

</tr>
<?php $i++; $lista ++; } while ($row_mate1 = mysql_fetch_assoc($mate1)); ?>
</table>
</td>



		<input type="hidden" name="total"  id="total" value="<?php echo $totalRows_mate1;?>" >
		<input type="hidden" name="curso_id" value="<?php echo $_POST['curso_id'];?>">


</tr>
</table>

<br />
<img src="../../images/pngnew/beos-descarga-un-archivo-icono-4218-96.png" width="50" height="50" border="0" align="absmiddle">&nbsp;&nbsp;<input type="submit" name="buttom" value="Datos Verificados" style="font-size:16px;"/>
</td>
	<input type="hidden" name="MM_insert" value="form">
	</form>
<br />
<br />
</center>


 </tr></table>
 <center>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
</center>


<?php } else { ?>
<center>
<br />
<br />
<br />
<img src="../../images/png/atencion.png" /><br /><br />
<span class="texto_grande_gris" >NO HAY ESTUDIANTES REGISTRADOS EN ESTA SECCION </span>
</center>

<?php } ?>
</center>
</body>
</html>
<?php
mysql_free_result($asignatura);
mysql_free_result($confip);
mysql_free_result($mate1);
mysql_free_result($mate2);
mysql_free_result($mate3);
mysql_free_result($mate4);
mysql_free_result($mate5);
mysql_free_result($mate6);
mysql_free_result($mate7);
mysql_free_result($mate8);
mysql_free_result($mate9);
mysql_free_result($mate10);
mysql_free_result($mate11);
mysql_free_result($mate12);
mysql_free_result($mate13);
mysql_free_result($mate14);
mysql_free_result($mate15);

mysql_free_result($colegio);
mysql_free_result($resumen);

?>
