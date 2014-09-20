<?php require_once('../inc/conexion.inc.php');


// CONSULTA SQL
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_cdc_institucion";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

$colname_alumno = "-1";
if (isset($_POST['ced_alumno'])) {
  $colname_alumno = $_POST['ced_alumno'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_alumno_info WHERE cedula=%s", GetSQLValueString($colname_alumno, "bigint"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

$colname_planestudio = "-1";
if (isset($_POST['plan'])) {
  $colname_planestudio = $_POST['plan'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE actual=1 AND cod=%s", GetSQLValueString($colname_planestudio, "text"));
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);

mysql_select_db($database_sistemacol, $sistemacol);
$query_margentitulo = sprintf("SELECT * FROM jos_cdc_titulos_margen");
$margentitulo = mysql_query($query_margentitulo, $sistemacol) or die(mysql_error());
$row_margentitulo = mysql_fetch_assoc($margentitulo);
$totalRows_margentitulo = mysql_num_rows($margentitulo);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<head>

<title>INTERSOFT | Software Educativo</title>

<link rel="shortcut icon" href="../../images/favicon.ico">

 <style type="text/css">
 body{margin: 0px;float: left; font-size: 12px;}
#contenedor{width: 27cm; height: 17cm; }
#plantel{float: left;margin-top: <?php echo $row_margentitulo['m1t'];?>cm;margin-left: <?php echo $row_margentitulo['m1l'];?>cm; position: absolute; }
#codigo{float: left;margin-top: <?php echo $row_margentitulo['m2t'];?>cm;margin-left: <?php echo $row_margentitulo['m2l'];?>cm;position: absolute;}
#titulo{float: left;margin-top: <?php echo $row_margentitulo['m3t'];?>cm;margin-left: <?php echo $row_margentitulo['m3l'];?>cm;position: absolute;}
#plan{float: left;margin-top: <?php echo $row_margentitulo['m4t'];?>cm;margin-left: <?php echo $row_margentitulo['m4l'];?>cm;position: absolute;}
#alumno{float: left;margin-top: <?php echo $row_margentitulo['m5t'];?>cm;margin-left: <?php echo $row_margentitulo['m5l'];?>cm;position: absolute;}
#cedula{float: left;margin-top: <?php echo $row_margentitulo['m6t'];?>cm;margin-left: <?php echo $row_margentitulo['m6l'];?>cm;position: absolute;}
#lugarn{float: left;margin-top: <?php echo $row_margentitulo['m7t'];?>cm;margin-left: <?php echo $row_margentitulo['m7l'];?>cm;position: absolute;}
#fechan{float: left;margin-top: <?php echo $row_margentitulo['m8t'];?>cm;margin-left: <?php echo $row_margentitulo['m8l'];?>cm;position: absolute;}
#lugarf{float: left;margin-top: <?php echo $row_margentitulo['m9t'];?>cm;margin-left: <?php echo $row_margentitulo['m9l'];?>cm;position: absolute;}
#egreso{float: left;margin-top: <?php echo $row_margentitulo['m10t'];?>cm;margin-left: <?php echo $row_margentitulo['m10l'];?>cm;position: absolute;}

#nombredz{float: left;margin-top: <?php echo $row_margentitulo['m11t'];?>cm;margin-left: <?php echo $row_margentitulo['m11l'];?>cm;position: absolute;font-size: 12px;}
#ceduladz{float: left;margin-top: <?php echo $row_margentitulo['m12t'];?>cm;margin-left: <?php echo $row_margentitulo['m12l'];?>cm;position: absolute;font-size: 12px;}

#nombrece{float: left;margin-top: <?php echo $row_margentitulo['m13t'];?>cm;margin-left: <?php echo $row_margentitulo['m13l'];?>cm;position: absolute;font-size: 12px;}
#cedulace{float: left;margin-top: <?php echo $row_margentitulo['m14t'];?>cm;margin-left: <?php echo $row_margentitulo['m14l'];?>cm;position: absolute;font-size: 12px;}

#funcionario{float: left;margin-top: <?php echo $row_margentitulo['m15t'];?>cm;margin-left: <?php echo $row_margentitulo['m15l'];?>cm;position: absolute;font-size: 12px;}
#cedulaf{float: left;margin-top: <?php echo $row_margentitulo['m16t'];?>cm;margin-left: <?php echo $row_margentitulo['m16l'];?>cm;position: absolute;font-size: 12px;}
 </style>
 
</head>
<center>
<body>

<!-- INICIO DEL CONTENEDOR PRINCIPAL -->

<?php
$fecha = $row_alumno['fecha_nacimiento'];
$anio = substr($fecha, -10, 4);
$mes = substr($fecha, -5, 2);
$dia = substr($fecha, -2, 2);
if($mes==1){$mesl="ENERO";}
if($mes==2){$mesl="FEBRERO";}
if($mes==3){$mesl="MARZO";}
if($mes==4){$mesl="ABRIL";}
if($mes==5){$mesl="MAYO";}
if($mes==6){$mesl="JUNIO";}
if($mes==7){$mesl="JULIO";}
if($mes==8){$mesl="AGOSTO";}
if($mes==9){$mesl="SEPTIEMBRE";}
if($mes==10){$mesl="OCTUBRE";}
if($mes==11){$mesl="NOVIEMBRE";}
if($mes==12){$mesl="DICIEMBRE";}

?> 
 <div id="contenedor"> 

		<div id="plantel"><?php echo $row_users['nombre_plantel'];?></div>
		<div id="codigo"><?php echo $row_users['cod_plantel'];?></div>
		<div id="titulo"><?php echo $_POST['titulo'];?></div>
		<div id="plan"><?php echo $row_planestudio['cod'];?></div>
		
		<div id="alumno"><?php echo $row_alumno['nombre']." ".$row_alumno['apellido'];?></div>
		<div id="cedula"><?php echo $row_alumno['indicador_nacionalidad']."-".$row_alumno['cedula'];?></div>
		<div id="lugarn"><?php if($_POST['estado']==1){ echo $row_alumno['lugar_nacimiento']."  ESTADO ".$row_alumno['estado'];}if($_POST['estado']==2){ echo $row_alumno['lugar_nacimiento']." ".$row_alumno['estado'];}?></div>
		<div id="fechan"><?php echo $dia." DE ".$mesl." DE ".$anio; ?></div>
		<div id="lugarf"><?php echo $_POST['fechaex'];?></div>
		<div id="egreso"><?php echo $_POST['egreso'];?></div>
		
		<div id="nombredz"><?php echo $_POST['nombredz'];?></div>
		<div id="ceduladz"><?php echo $_POST['ceduladz'];?></div>
		<div id="nombrece"><?php echo $_POST['nombrece'];?></div>
		<div id="cedulace"><?php echo $_POST['cedulace'];?></div>
		<div id="funcionario"><?php echo $_POST['funcionario'];?></div>
		<div id="cedulaf"><?php echo $_POST['cedulaf'];?></div>
    
 </div>
</body>

</center>
</html>
