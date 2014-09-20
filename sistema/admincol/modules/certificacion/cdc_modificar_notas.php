<?php require_once('../inc/conexion.inc.php');

// CONSULTA SQL

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_sistemacol, $sistemacol);
$query_anio = "SELECT a.id, a.nombre_anio, b.cod FROM jos_cdc_pensum_anios a, jos_cdc_planestudio b WHERE a.planestudio_id=b.id ORDER BY b.id, a.no_anio ASC";
$anio = mysql_query($query_anio, $sistemacol) or die(mysql_error());
$row_anio = mysql_fetch_assoc($anio);
$totalRows_anio = mysql_num_rows($anio);

// CONSULTA DE NOTAS
$plan_notas_plan1 = "-1";
if (isset($_GET['9812HHFJHJHF63883B3CNCH7'])) {
  $plan_notas_plan1 = $_GET['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_notas_plan1 = "-1";
if (isset($_GET['1298JJII128938367HHY'])) {
  $alumno_notas_plan1 = $_GET['1298JJII128938367HHY'];
}
$anio_notas_plan1 = "-1";
if (isset($_GET['anio'])) {
  $anio_notas_plan1 = $_GET['anio'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_notas_plan1 = sprintf("SELECT e.id, e.def, e.tipo_eva, e.fecha_mes, e.fecha_anio, e.plantelcurso_no, c.nombre_asignatura FROM jos_cdc_planestudio a, jos_cdc_estudiante b, jos_cdc_pensum_asignaturas c, jos_cdc_pensum_anios d, jos_cdc_pensum e WHERE e.alumno_id=b.id AND e.asignatura_id=c.id AND c.anio_id=d.id AND d.planestudio_id=a.id AND a.id=%s AND b.cedula=%s AND d.no_anio=%s ORDER BY c.orden_asignatura ASC", GetSQLValueString($plan_notas_plan1, "int"), GetSQLValueString($alumno_notas_plan1, "bigint"), GetSQLValueString($anio_notas_plan1, "int"));
$notas_plan1 = mysql_query($query_notas_plan1, $sistemacol) or die(mysql_error());
$row_notas_plan1 = mysql_fetch_assoc($notas_plan1);
$totalRows_notas_plan1 = mysql_num_rows($notas_plan1);



// INICIO DE SQL DE REGISTRO DE  DATOS 

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


     $updateSQL = sprintf("update jos_cdc_pensum SET def=%s, tipo_eva=%s, fecha_mes=%s, fecha_anio=%s, plantelcurso_no=%s WHERE id=%s",
                         
                            GetSQLValueString($_POST['def'.$i], "int"),
                            GetSQLValueString($_POST['tipo_eva'.$i], "text"),
                            GetSQLValueString($_POST['fecha_mes'.$i], "text"),
                            GetSQLValueString($_POST['fecha_anio'.$i], "int"),
                            GetSQLValueString($_POST['plantelcurso_no'.$i], "int"),
                            GetSQLValueString($_POST['id'.$i], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

} while ($i+1 <= $total );

  $updateGoTo = "cdc_modificar_plantel2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//FIN CONSULTA
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../jquery/styles/nyroModal.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../../jquery/js/jquery.nyroModal.custom.js"></script>

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
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top" align="center">

<br />
	
	</td></tr>

<tr><td>
	
<table style="font-size:10px; font-family:verdana;" width="80%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" align="center" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		<td align="center">Nombre de la Asignatura</td>
		<td align="center">Cal. No.</td>
		<td align="center">T-E</td>
		<td align="center">Mes</td>
		<td align="center">A&ntilde;o</td>
		<td align="center">Plantel</td>
	</tr>
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">

<tr >
<?php $i=1;
do { ?>		
			<td align="center">
				<?php echo $row_notas_plan1['nombre_asignatura'];?>
			</td>
			<td align="center">
				<input name="<?php echo 'def'.$i;?>" type="text" id="<?php echo 'def'.$i;?>" value="<?php echo $row_notas_plan1['def']; ?>" size="2" />
			</td>
			<td align="center">
				<select name="<?php echo 'tipo_eva'.$i;?>">
				<option value="<?php echo $row_notas_plan1['tipo_eva']; ?>"><?php echo $row_notas_plan1['tipo_eva']; ?></option>
				<option value="">**</option>
				<option value="F">F</option>
				<option value="R">R</option>
				<option value="P">P</option>
				<option value="T">T</option>
				<option value="M">M</option>
				<option value="*">*</option>
				</select>
			</td>
			<td align="center">
				<select name="<?php echo 'fecha_mes'.$i;?>">
				<option value="<?php echo $row_notas_plan1['fecha_mes']; ?>"><?php echo $row_notas_plan1['fecha_mes']; ?></option>
				<option value="">**</option>
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
				</select>
			</td>
			<td align="center">
				<select name="<?php echo 'fecha_anio'.$i;?>">
				<option value="<?php echo $row_notas_plan1['fecha_anio']; ?>"><?php echo $row_notas_plan1['fecha_anio']; ?></option>
				<option value="">----</option>
				<?php  $fec=date(Y);
				do { ?>
				<option value="<?php echo $fec;?>"><?php echo $fec;?></option>
				<?php  $fec=$fec-1;
				} while($fec>=1950); ?>
				</select>
			</td>
			<td align="center">
				<select name="<?php echo 'plantelcurso_no'.$i;?>">
				<option value="<?php echo $row_notas_plan1['plantelcurso_no']; ?>"><?php echo $row_notas_plan1['plantelcurso_no']; ?></option>
				<option value="">**</option>
				<?php  $no=1;
				do { ?>
				<option value="<?php echo $no;?>"><?php echo $no;?></option>
				<?php  $no=$no+1;
				} while($no<=5); ?>
				</select>
			</td>
		</tr>
		<input type="hidden" name="<?php echo 'id'.$i;?>" id="<?php echo 'id'.$i;?>" value="<?php echo $row_notas_plan1['id']; ?>">

<?php  $i++;  } while ($row_notas_plan1 = mysql_fetch_assoc($notas_plan1)); ?>
		<tr>
		<td colspan="6" align="center">
		<br />
		<input type="hidden" name="totalalum"  id="totalalum" value="<?php echo $totalRows_notas_plan1; ?>" >
		<input type="hidden" name="MM_update" value="modi_form">
		<input type="submit" name="buttom" value="Modificar >" />
		</td></tr>




 </form>  	

</table>

<tr><td>
&nbsp;&nbsp;
</td></tr>
<tr><td align="center">
	<span class="texto_grande_gris">Para cancelar presiona click afuera de esta Ventana!</span>
</td></tr>
    </table>




<?php } //FIN DE LA AUTENTIFICACION 

?> 
</body>
</center>
</html>
<?php

mysql_free_result($usuario);
mysql_free_result($localidad);
mysql_free_result($plantel);

?>
