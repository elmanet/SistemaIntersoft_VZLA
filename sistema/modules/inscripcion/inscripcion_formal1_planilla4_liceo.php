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
$query_inscripcion = sprintf("SELECT * FROM sis_usuario a, sis_alumno_info b WHERE a.id=b.alumno_id AND cedula = %s", GetSQLValueString($colname_inscripcion, "text"));
$inscripcion = mysql_query($query_inscripcion, $sistemacol) or die(mysql_error());
$row_inscripcion = mysql_fetch_assoc($inscripcion);
$totalRows_inscripcion = mysql_num_rows($inscripcion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = "SELECT * FROM sis_institucion";
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top"><?php if ($totalRows_inscripcion > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" id="ancho_planilla">
          <tr>
            <td height="92" align="right" valign="middle"><img src="../images/cole/ima/<?php echo $row_colegio['logocol']; ?>" width="79" height="90" align="absmiddle"></td>
            <td align="center" valign="middle"><div align="center">
              <table width="100%" border="0" align="left">
                  <tr>
                    <td align="left" valign="bottom"><p class="titulo_grande_gris"><?php echo $row_colegio['nomcol']; ?></p></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><span class="texto_pequeno_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><span class="texto_pequeno_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  </tr>
                </table>
              </div></td>
            <td align="center" valign="middle" class="texto_mediano_grande"><strong><div id="foto_planilla">
              <p>&nbsp;</p>
              <p>FOTO</p>
            </div></strong></td>
          </tr>
          <tr>
            <td colspan="3" valign="top"><div align="center">
              <hr>
              <span class="texto_grande_gris"><strong>FICHA DE INSCRIPCION</strong></span>
              <hr>
              </div>
              <table width="100%" border="0">
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos del Estudiante</em></strong></legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_8pt_negro"><strong>CEDULA:</strong> <?php echo $row_inscripcion['indicador_nacionalidad']; ?>-<?php echo $row_inscripcion['cedula']; ?> <strong>NOMBRE DEL ESTUDIANTE: </strong><?php echo $row_inscripcion['nombre']; ?> <?php echo $row_inscripcion['apellido']; ?><strong> <br>
                              DIRECCION: </strong><?php echo $row_inscripcion['direccion_vivienda']; ?><strong> <br>
                              TELEFONO: </strong><?php echo $row_inscripcion['telefono_alumno']; ?><strong> <strong>LUGAR DE NACIMIENTO: </strong></strong><?php echo $row_inscripcion['lugar_nacimiento']; ?><br>
                            <strong><strong> <strong>FECHA DE NACIMIENTO: 
                              </strong></strong></strong>
                            <?php if ($row_inscripcion['fecha_nacimiento_dia']<10){  echo "0".$row_inscripcion['fecha_nacimiento_dia'];} if ($row_inscripcion['fecha_nacimiento_dia']>9){  echo $row_inscripcion['fecha_nacimiento_dia'];}  ?>
                            /
  <?php if ($row_inscripcion['fecha_nacimiento_mes']<10){  echo "0".$row_inscripcion['fecha_nacimiento_mes'];} if ($row_inscripcion['fecha_nacimiento_mes']>9){  echo $row_inscripcion['fecha_nacimiento_mes'];}  ?>
                            /<?php echo $row_inscripcion['fecha_nacimiento_ano']; ?><strong><strong><strong> <strong>  GRADO O A&Ntilde;O A CURSAR: </strong></strong></strong></strong><?php echo $row_inscripcion['ano_cursar']; ?></td>
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
                          <td align="left" valign="top" class="texto_8pt_negro"><strong>CEDULA:</strong> <?php echo $row_inscripcion['cedula_representante']; ?> <strong>NOMBRE  REPRESENTANTE: </strong><?php echo $row_inscripcion['nombre_representante']; ?> <?php echo $row_inscripcion['apellido_representante']; ?><strong><br>
                              DIRECCION:                          </strong><?php echo $row_inscripcion['direccion_representante']; ?><strong><br>
                              TELEFONO:                          </strong><?php echo $row_inscripcion['telefono_representante']; ?><strong> E-MAIL: </strong><?php echo $row_inscripcion['email_representante']; ?><strong><br>
                              PROFESION:                          </strong><?php echo $row_inscripcion['descripcion_trabajo']; ?><strong> DIRECCION DE TRABAJO: </strong><?php echo $row_inscripcion['direccion_trabajo']; ?><strong> TELEFONO DE TRABAJO: </strong><?php echo $row_inscripcion['telefono_trabajo']; ?></td>
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
                          <td align="left" valign="top" class="texto_8pt_negro"><strong>NOMBRE MADRE:</strong><?php echo $row_inscripcion['nombre_madre']; ?> <?php echo $row_inscripcion['apellido_madre']; ?> <strong><br>
                              DIRECCION MADRE:</strong><?php echo $row_inscripcion['direccion_madre']; ?> <strong>TELEFONO MADRE: </strong><?php echo $row_inscripcion['tel_madre']; ?><strong> <br>
                              NOMBRE PADRE: </strong><?php echo $row_inscripcion['nombre_padre']; ?> <?php echo $row_inscripcion['apellido_padre']; ?><br>
                            <strong> DIRECCION PADRE: </strong><?php echo $row_inscripcion['direccion_padre']; ?><strong> TELEFONO PADRE: </strong><?php echo $row_inscripcion['tel_padre']; ?></td>
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
                          <td height="10" align="left" valign="top" class="texto_8pt_negro"><strong class="texto_pequeno_gris">INGRESO FAMILIAR:</strong><?php echo $row_inscripcion['ingreso_familiar']; ?><br> 
                            <strong>VECINO/FAMILIAR(1): </strong><?php echo $row_inscripcion['vecino1_nombre']; ?><strong> PARENTESCO(1): </strong><?php echo $row_inscripcion['vecino1_parentesco']; ?><strong> TELEFONO(1): </strong><?php echo $row_inscripcion['vecino1_telefono']; ?><strong><br> 
                              VECINO/FAMILIAR(2): </strong><?php echo $row_inscripcion['vecino2_nombre']; ?><strong> PARENTESCO(2): </strong><?php echo $row_inscripcion['vecino2_parentesco']; ?><strong> TELEFONO(2): </strong><?php echo $row_inscripcion['vecino2_telefono']; ?><strong><br> 
                              NOMBRE DEL SEGURO: </strong><?php echo $row_inscripcion['seguro_nombre']; ?> <strong>LLEVAR A LA CLINICA: </strong><?php echo $row_inscripcion['seguro_clinica']; ?><strong><br> 
                              TIPO DE SANGRE: </strong><?php echo $row_inscripcion['tipo_sangre']; ?><strong> ALERGICO(A): </strong><?php echo $row_inscripcion['alergico']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><table width="100%" border="0">
                    <tr>
                      <td width="50%" valign="top"><p class="texto_mediano_gris"><span class="texto_8pt_negro"><strong>NORMAS GENERALES QUE DEBE CUMPLIR EL ESTUDIANTE</strong></span><br>
                        <span class="texto_pequeno6pt_negro">                        1. CUMPLIR CON EL INIFORME ESCOLAR ESTABLECIDO POR EL MPPPE<br>
                          2. DEBE TENER RESPETO Y CONSIDERACION AL PERSONAL DOCENTE, ADMINISTRATIVO Y OBRERO<br>
                          3. RESPONSABILIZARSE POR EL MATERIAL DIDACTICO Y EQUIPO INSTITUCIONAL <br>
                          4. ASISTIR DIARIAMENTE A CLASES Y SER PUNTUAL CON EL HORARIO<br>
5. CUMPLIR CON LAS ORIENTACIONES EMITIDAS POR LOS DOCENTE<br>
                          6. CUMPLIR CON EL REGLAMENTO INTERNO DE LA INSTITUCION Y NORMATIVAS LEGALES EDUCATIVAS</span></p>
                        <p class="texto_mediano_gris"><strong class="texto_8pt_negro">NORMAS DEL REPRESENTANTE </strong><br>
                          <span class="texto_pequeno6pt_negro">1. ASISTIR A LAS REUNIONES PARA VERIFICAR LA ASISTENCIA Y RENDIMIENTO DE SU REPRESENTADO<br>
                          2. CUMPLIR CON EL REGLAMENTO INTERNO DE LA INSTITUCION Y NORMATIVA LEGAL VIGENTE </span></p></td>
                      <td valign="top" class="texto_pequeno6pt_negro"><span class="texto_8pt_negro"><strong><br>
                        DOCUMENTOS CONSIGNADOS</strong></span><br>
                        __ 02 FOTOCOPIAS AMPLIADAS DE CEDULA DE IDENTIDAD DEL ESTUDIANTE<br>
                        __ 01 FOTOCOPIA DE CEDULA DE IDENTIDAD DEL REPRESENTANTE<br>
                        __ PARTIDA DE NACIMIENTO (ORIGINAL Y COPIA)<br>
                        __ 05 FOTOGRAFIAS DEL ESTUDIANTE<br>
                        __ 02 FOTOGRAFIAS DEL REPRESENTANTE<br>
                        __ CARPETA MARRON CON GANCHO Y 01 SOBRE MANILA TAMA&Ntilde;O OFICIO<br>
                        __ CERTIFICACION DE CALIFICACIONES (SI PROCEDE DE OTRO ESTADO, AVALADA POR LA ZONA EDUCATIVA)<br>
                        __ PARA 1er A&Ntilde;O: INFORME DESCRIPTIVO DE 6TO GRADO Y CERTIFICADO DE EDUCACION PRIMARIA</td>
                      </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><span class="texto_8pt_negro"><br>
                        FIRMA DEL REPRESENTANTE:___________________________________ C.I.:_____________</span></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><span class="texto_8pt_negro"><br>
                        RESPONSABLE DE LA INSCRIPCION :______________________________ C.I.:____________</span></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top"><span class="texto_8pt_negro"><br>
                      </span></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top"><span class="texto_8pt_negro">EN SAN CRISTOBAL A LOS_______________ DEL MES DE_____________DE_____________ </span></td>
                      </tr>
                    </table></td>
                  </tr>
              </table></td>
          </tr>
          </table>
        <?php } // Show if recordset not empty ?>
        <br>
    <tr>
      <td valign="top"><?php if ($totalRows_inscripcion == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../images/PNG/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">&quot; Error no existen datos&quot;</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana y vuelve a escribir tu n&uacute;mero de c&eacute;dula<br>
                acuerdate que no debe llevar ni puntos, ni espacios...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
    <tr><td>    </td>
    
    <tr>
      <td></td>
    <tr>
      <td></td>
    <tr>
      <td></td>
    <tr>
      <td></td>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($inscripcion);

mysql_free_result($colegio);
?>
