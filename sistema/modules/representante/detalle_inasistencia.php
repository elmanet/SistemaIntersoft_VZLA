<?php require_once('../../Connections/sistemacol.php'); ?>
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


$colname_estudiante = "-1";
if (isset($_GET['cod'])) {
  $colname_estudiante = $_GET['cod'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_estudiante = sprintf("SELECT a.alumno_id, a.cedula, a.nombre, a.apellido, a.indicador_nacionalidad, a.direccion_vivienda, a.telefono_alumno, d.descripcion, e.nombre as anio FROM jos_alumno_info a, jos_alumno_curso b, jos_curso c, jos_seccion d, jos_anio_nombre e WHERE a.alumno_id=b.alumno_id AND b.curso_id=c.id AND c.seccion_id=d.id AND c.anio_id=e.id AND a.alumno_id = %s", GetSQLValueString($colname_estudiante, "int"));
$estudiante = mysql_query($query_estudiante, $sistemacol) or die(mysql_error());
$row_estudiante = mysql_fetch_assoc($estudiante);
$totalRows_estudiante = mysql_num_rows($estudiante);

$colname_inasistencia = "-1";
if (isset($_GET['cod'])) {
  $colname_inasistencia = $_GET['cod'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inasistencia = sprintf("SELECT SUM(b.inasistencia_alumno) as inasistencia_alumno, b.justificativo, b.fecha_inasistencia, d.nombre as mate, c.id FROM jos_alumno_info a, jos_alumno_asistencia b, jos_asignatura c, jos_asignatura_nombre d WHERE a.alumno_id=b.alumno_id AND b.asignatura_id=c.id AND c.asignatura_nombre_id=d.id AND a.alumno_id = %s GROUP BY mate", GetSQLValueString($colname_inasistencia, "int"));
$inasistencia = mysql_query($query_inasistencia, $sistemacol) or die(mysql_error());
$row_inasistencia = mysql_fetch_assoc($inasistencia);
$totalRows_inasistencia = mysql_num_rows($inasistencia);

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=500,width=850,left=100,top=80,resizable=no,scrollbars=auto,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
function newPopup2(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=400,width=650,left=200,top=150,resizable=no,scrollbars=auto,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
</script>

</head>
<center>
<body>
<table  border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_estudiante > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >

          <tr>
            <td colspan="3" valign="top"><div align="center">
              <hr>
              <span class="texto_grande_gris"><strong>CONTROL DE INASISTENCIAS DEL ESTUDIANTE</strong></span>
              <hr>
              </div>



              <table width="740" border="0">
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos del Estudiante</em></strong></legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_mediano_gris"><strong>CEDULA:</strong>&nbsp; <?php echo $row_estudiante['indicador_nacionalidad']; ?>-<?php echo $row_estudiante['cedula']; ?> <strong>NOMBRE DEL ESTUDIANTE: </strong><?php echo $row_estudiante['nombre']; ?> <?php echo $row_estudiante['apellido']; ?> <br><strong>
                              DIRECCION: </strong>&nbsp;<?php echo $row_estudiante['direccion_vivienda']; ?> <br>
                             <strong> TELEFONO: </strong>&nbsp;<?php echo $row_estudiante['telefono_alumno']; ?> <br /><br />
                              <strong>GRADO O A&Ntilde;O EN CURSO: </strong>&nbsp;<?php echo $row_estudiante['anio'].' '.$row_estudiante['descripcion']; ?><!-- <a href="JavaScript:newPopup('reporte_inasistencia_estudiante_completo.php?cedula=<?php echo $_GET['cedula'];?>');" ><img src="../../images/png/Printer.png" style="padding-left:220px;" width="35" align="middle" border="0"/> Imprimir reporte completo</a>   -->
                              
                           </td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Inasistencias Generales por Asignaturas</em></strong> </legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_mediano_gris">
                          
                          <?php if ($totalRows_inasistencia > 0) { // Show if recordset empty ?>
 <center>                         
                          <table style="font-size:10px; font-family:verdana;" width="90%" BORDER="1" BORDERCOLOR="#fffccc" CELLSPACING="0" >
	<tr style="font-size:12px; font-family:verdana; background-color:#fffccc;">
		
		<td align="center">Asignatura</td>
		<!--<td align="center">Fecha</td>-->
		<td align="center">Horas/Inasistencia</td>
		<!--<td align="center">Justificativo</td>-->

	</tr>
	<?php $lista=1;
	do { ?>
	<tr >
		<td align="center" width="150"><a href="detalle_inasistencia2.php?cod=<?php echo $_GET['cod'];?>&id=<?php echo $row_inasistencia['id'];?>');" ><?php echo $row_inasistencia['mate']; ?></a></td>
		<!--<td align="center" width="30"><?php echo $row_inasistencia['fecha_inasistencia']; ?></td>-->
		<td align="center" width="10"><span class="texto_mediano_gris"><?php echo $row_inasistencia['inasistencia_alumno']; ?></span></td>
		<!--<td align="center" width="250"><?php echo $row_inasistencia['justificativo']; ?></td>-->
		
	</tr>
        <?php } while ($row_inasistencia = mysql_fetch_assoc($inasistencia)); ?>	

</table>
</center>

<?php } else { ?>

			<div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">&quot; Este Estudiante no posee Inasistencias o a&uacute;n no se las han cargado &quot;</span><br>
                <br>
                <br>
            </div>

<?php } ?>

                          
                          </td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
               
                  </tr>
             
          </table>
          <?php } // Show if recordset not empty ?>
      <tr>
      <td valign="top"><?php if ($totalRows_estudiante == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/PNG/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">&quot; Error no existen datos&quot;</span><span class="texto_mediano_gris"><br>
                <br>
                </span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
   
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($estudiante);

mysql_free_result($colegio);
?>
