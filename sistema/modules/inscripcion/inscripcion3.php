<?php require_once('../inc/conexion_sinsesion.inc.php');

if (isset($_GET['cedula'])) {
  $colname_preinscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_preinscripcion = sprintf("SELECT * FROM jos_alumno_preinscripcion WHERE ced_alumno=%s ", GetSQLValueString($colname_preinscripcion, "biginit"));
$preinscripcion = mysql_query($query_preinscripcion, $sistemacol) or die(mysql_error());
$row_preinscripcion = mysql_fetch_assoc($preinscripcion);
$totalRows_preinscripcion = mysql_num_rows($preinscripcion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = "SELECT * FROM jos_institucion";
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table  border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top"><?php if ($totalRows_preinscripcion > 0) { // Show if recordset not empty ?>
        <table  border="0" align="center" >
          <tr>
            <td width="126"><div align="center" class="titulosgrandes_eloy">
              <div align="right"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" height="70"></div>
            </div></td>
            <td align="center" valign="middle"><div align="center" class="titulosmedianos_eloy">
              <div align="center"></div>
            </div>
              <div align="center">
                <table border="0" align="left">
                  <tr>
                    <td align="left"><span class="titulo_grande_gris"><?php echo $row_colegio['nomcol']; ?></span></td>
                  </tr>
                  <tr>
                    <td align="left"><span class="texto_mediano_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  </tr>
                  <tr>
                    <td align="left"><span class="texto_mediano_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
              <hr>
              <span style="font-size:25px; font-family:verdana;"><strong>ENTREVISTA</strong></span></div></td>
          </tr>
          <tr>
            <td colspan="2"><hr></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
              <table height="373" border="0">
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>CEDULA: </strong></div></td>
                  <td width="17" align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['indicador_nacionalidad']; ?>-<?php echo $row_preinscripcion['ced_alumno']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>NOMBRE DEL ESTUDIANTE: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['nom_alumno']; ?> <?php echo $row_preinscripcion['ape_alumno']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>DIRECCION:</strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['dir_alumno']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>TELEFONO:</strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['tel_alumno']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>FECHA DE NACIMIENTO: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php  echo $row_preinscripcion['fecha_nacimiento']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>EDAD:</strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['edad']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>GRADO O A&Ntilde;O A CURSAR: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['grado_cursar']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>PORQUE SER RETIRA: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['porque_retira']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>COMO ES TU COMPORTAMIENTO: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['comportamiento']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>CON QUIEN VIVES: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['quien_vives']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>INGRESO FAMILIAR: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['ingreso_familiar']; ?> BsF.</td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>QUIEN LE RECOMENDO EL COLEGIO: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['recomendado']; ?></td>
                </tr>
                <tr>
                  <td width="260" align="center" valign="top" class="texto_mediano_gris"><div align="right"><strong>QUIEN LE PAGARA LA MENSUALIDAD: </strong></div></td>
                  <td align="center" valign="top" class="textograndes_eloy">&nbsp;</td>
                  <td width="340" align="left" class="texto_mediano_gris"><?php echo $row_preinscripcion['pago_mensualidad']; ?></td>
                </tr>
                <tr>
                  <td colspan="3" class="textograndes_eloy"><hr></td>
                </tr>
                <tr>
                  <td colspan="3" class="textograndes_eloy"><p><span class="texto_mediano_gris">1. EL ESTUDIANTE MANIFIESTA:____________________________________________<br>
                    ______________________________________________________________________<br>
                    ______________________________________________________________________<br>
                    <br>
                    2. EL REPRESENTANTE MANIFIESTA:_________________________________________<br>
                    ______________________________________________________________________<br>
                    ______________________________________________________________________<br>
                    <br>
                    3. SUGERENCIA DEL ENCUESTADOR O DOCENTE:_____________________________<br>
                    ______________________________________________________________________<br>
                    ______________________________________________________________________ </span></p></td>
                </tr>
                <tr>
                  <td colspan="3" class="textograndes_eloy"><hr>
                    <span class="texto_mediano_gris"> DOCUMENTOS A ENTREGAR PARA LA ENTREVISTA: <br>
                      <br>
                      1. CARTA DE BUENA CONDUCTA:____<br>
                      2. NOTAS Y RENDIMIENTO:___<br>
                      3. 2 CARPETAS MARRON OFICIO CON GANCHO:___<br>
                      4. 4 FOTOGRAFIAS DEL ESTUDIANTE Y REPRESENTANTE:___ </span></td>
                </tr>
                <tr>
                  <td colspan="3" class="textograndes_eloy"><span class="texto_mediano_gris"><br>
                    OBSERVACIONES:________________________________________________________<br>
                    ______________________________________________________________________<br>
                    ______________________________________________________________________<br>
                    <br>
                  </span></td>
                </tr>
                <tr>
                  <td colspan="3" class="textograndes_eloy"><hr></td>
                </tr>
                <tr>
                  <td colspan="2" class="textograndes_eloy"><div align="center"><span class="texto_mediano_gris">ACEPTADO:____</span></div></td>
                  <td width="340" class="textograndes_eloy"><div align="center"><span class="texto_mediano_gris">NO ACEPTADO:____ </span></div></td>
                </tr>                
                <tr>
                  <td colspan="3" class="textograndes_eloy"><div align="center">
                    <hr>
                  </div></td>
                </tr>
                <tr><td colspan="5" align="center" style="font-size:10px; font-family:verdana;">Esta planilla NO tiene VALIDEZ hasta ser aprobada por la Instituci&oacute;n</td></tr>
                <tr>
                  <td colspan="3" class="textograndes_eloy"><div align="center"><span class="texto_mediano_gris"><br>
                    <br>
                   FIRMA DEL REPRESENTANTE  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                   FIRMA DEL ESTUDIANTE  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                   FIRMA DEL DIRECTOR </span></div></td>
                </tr>
                <!-- <tr>
                  <td colspan="2" class="textograndes_eloy"><div align="left"><span class="texto_mediano_gris"><br>
                    <br>
                    FIRMA DEL REPRESENTANTE </span></div></td>
                  <td width="340" class="textograndes_eloy"><div align="right"><span class="texto_mediano_gris"><br>
                    <br>
                    FIRMA DEL ESTUDIANTE </span></div></td>
                </tr>-->
                
              </table>
            </div></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?>
<br>
      <?php if ($totalRows_preinscripcion == 0) { // Show if recordset empty ?>
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
      <p align="center">&nbsp;</p>      
    
	<tr><td>    </td>
    
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($preinscripcion);

mysql_free_result($colegio);
?>
