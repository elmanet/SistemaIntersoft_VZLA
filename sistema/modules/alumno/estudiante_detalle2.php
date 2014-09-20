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


$colname_inscripcion = "-1";
if (isset($_GET['cedula'])) {
  $colname_inscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inscripcion = sprintf("SELECT * FROM jos_alumno_info a, jos_alumno_curso b WHERE a.alumno_id=b.alumno_id AND a.cedula = %s", GetSQLValueString($colname_inscripcion, "text"));
$inscripcion = mysql_query($query_inscripcion, $sistemacol) or die(mysql_error());
$row_inscripcion = mysql_fetch_assoc($inscripcion);
$totalRows_inscripcion = mysql_num_rows($inscripcion);

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
</head>
<center>
<body>
<table  border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_inscripcion > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
			<tr>
				<td><br />
				
<form action="estudiante_detalle.php" name="form" id="form" method="GET" enctype="multipart/form-data" >
&nbsp;&nbsp;&nbsp;<span style="font-size:12px;"><b>Buscar otro Estudiante:</b> </span> 

<input type="text" name="apellido_alumno" value="" size="20"/>
<input type="submit" name="buttom" value="Buscar >" />

</form> 

<br />
&nbsp;&nbsp;&nbsp;<a href="estudiante_detalle.php" > | Ver Todos los Estudiantes |</a>
<br />
<br />				
				</td>			
			</tr>
          <tr>
            <td colspan="3" valign="top"><div align="center">
              <hr>
              <span class="texto_grande_gris"><strong>DATOS DEL ESTUDIANTE</strong></span>
              <hr>
              </div>

<?
$fecha = $row_inscripcion['fecha_nacimiento'];
$anio = substr($fecha, -10, 4);
$mes = substr($fecha, -5, 2);
$dia = substr($fecha, -2, 2);
?> 

              <table width="850" border="0">
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos del Estudiante</em></strong></legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_mediano_gris"><strong>CEDULA:</strong>&nbsp; <?php echo $row_inscripcion['indicador_nacionalidad']; ?>-<?php echo $row_inscripcion['cedula']; ?> <strong>NOMBRE DEL ESTUDIANTE: </strong><?php echo $row_inscripcion['nombre']; ?> <?php echo $row_inscripcion['apellido']; ?> <br><strong>
                              DIRECCION: </strong>&nbsp;<?php echo $row_inscripcion['direccion_vivienda']; ?><strong>
                              SECTOR: </strong>&nbsp;<?php echo $row_inscripcion['direccion_vivienda_sector']; ?><strong> <br>
                              TELEFONO: </strong>&nbsp;<?php echo $row_inscripcion['telefono_alumno']; ?> <strong>LUGAR DE NACIMIENTO: </strong></strong><?php echo $row_inscripcion['lugar_nacimiento']; ?><br>
                            <strong><strong> <strong>FECHA DE NACIMIENTO: 
                              </strong></strong></strong>&nbsp;<?php echo $dia."/".$mes."/".$anio; ?>&nbsp;&nbsp;<strong><strong><strong> <strong>  CODIGO DEL A&Ntilde;O A CURSAR: </strong></strong></strong></strong><?php echo $row_inscripcion['anio_id']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos del Representante</em></strong> </legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_mediano_gris"><strong>CEDULA:</strong> <?php echo $row_inscripcion['cedula_representante']; ?> <strong>NOMBRE  REPRESENTANTE: </strong><?php echo $row_inscripcion['nombre_representante']; ?> <?php echo $row_inscripcion['apellido_representante']; ?><strong><br>
                              DIRECCION:                          </strong>&nbsp;<?php echo $row_inscripcion['direccion_representante']; ?><strong>
                              SECTOR: </strong>&nbsp;<?php echo $row_inscripcion['direccion_representante_sector']; ?><strong><br>
                              TELEFONO:                          </strong>&nbsp;<?php echo $row_inscripcion['telefono_representante']; ?><strong> E-MAIL: </strong><?php echo $row_inscripcion['email_representante']; ?><strong><br>
                              PROFESION:                          </strong>&nbsp;<?php echo $row_inscripcion['descripcion_trabajo']; ?><strong> DIRECCION DE TRABAJO: </strong><?php echo $row_inscripcion['direccion_trabajo']; ?><strong>
                              SECTOR: </strong>&nbsp;<?php echo $row_inscripcion['direccion_trabajo_sector']; ?><strong> <br> TELEFONO DE TRABAJO: </strong><?php echo $row_inscripcion['telefono_trabajo']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos de  los Padres</em></strong> </legend>
                      <table width="100%" border="0" align="left">
                        <tr>
                          <td align="left" valign="top" class="texto_mediano_gris">
				<strong>CEDULA MADRE:</strong>&nbsp;<?php echo $row_inscripcion['cedula_madre']; ?>
				<strong>NOMBRE MADRE:</strong>&nbsp;<?php echo $row_inscripcion['nombre_madre']; ?> <?php echo $row_inscripcion['apellido_madre']; ?> <strong><br>
                              DIRECCION MADRE:</strong>&nbsp;<?php echo $row_inscripcion['direccion_madre']; ?> <strong>
                              SECTOR: </strong>&nbsp;<?php echo $row_inscripcion['direccion_madre_sector']; ?><strong> TELEFONO MADRE: </strong><?php echo $row_inscripcion['tel_madre']; ?> <strong> PROFESION MADRE:</strong>&nbsp;<?php echo $row_inscripcion['profesion_madre']; ?><br>
				<strong>CEDULA PADRE:</strong>&nbsp;<?php echo $row_inscripcion['cedula_padre']; ?>
                              <strong>NOMBRE PADRE: </strong>&nbsp;<?php echo $row_inscripcion['nombre_padre']; ?> <?php echo $row_inscripcion['apellido_padre']; ?><br>
                            <strong> DIRECCION PADRE: </strong>&nbsp;<?php echo $row_inscripcion['direccion_padre']; ?><strong> 
                              SECTOR: </strong>&nbsp;<?php echo $row_inscripcion['direccion_padre_sector']; ?><strong> TELEFONO PADRE: </strong><?php echo $row_inscripcion['tel_padre']; ?> <strong>PROFESION PADRE:</strong>&nbsp;<?php echo $row_inscripcion['profesion_padre']; ?><br>
<strong class="texto_pequeno_gris">INGRESO FAMILIAR:</strong> <?php echo $row_inscripcion['ingreso_familiar']; ?>
</td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><em><strong>Informaci&oacute;n General</strong></em></legend>
                      <table width="100%" border="0" align="left">
                        <tr>
                          <td height="10" align="left" valign="top" class="texto_mediano_gris">
                            <strong>OTRO CONTACTO(1): </strong>&nbsp;<?php echo $row_inscripcion['vecino1_nombre']; ?><strong> PARENTESCO(1): </strong><?php echo $row_inscripcion['vecino1_parentesco']; ?><strong> TELEFONO(1): </strong><?php echo $row_inscripcion['vecino1_telefono']; ?><strong><br> 
                              OTRO CONTACTO(2): </strong>&nbsp;<?php echo $row_inscripcion['vecino2_nombre']; ?><strong> PARENTESCO(2): </strong><?php echo $row_inscripcion['vecino2_parentesco']; ?><strong> TELEFONO(2): </strong><?php echo $row_inscripcion['vecino2_telefono']; ?><strong><br> 
                              NOMBRE DEL SEGURO: </strong>&nbsp;<?php echo $row_inscripcion['seguro_nombre']; ?> <strong>LLEVAR A LA CLINICA: </strong><?php echo $row_inscripcion['seguro_clinica']; ?><strong><br> 
                              TIPO DE SANGRE: </strong>&nbsp;<?php echo $row_inscripcion['tipo_sangre']; ?><strong> ALERGICO(A): </strong><?php echo $row_inscripcion['alergico']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
             
          </table>
          <?php } // Show if recordset not empty ?>
      <tr>
      <td valign="top"><?php if ($totalRows_inscripcion == 0) { // Show if recordset empty ?>
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
mysql_free_result($inscripcion);

mysql_free_result($colegio);
?>
