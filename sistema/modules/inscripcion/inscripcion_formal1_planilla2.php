<?php require_once('../../Connections/sistemacol.php'); ?>
<?php require_once('../../Connections/sistemacol.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO sis_alumno_info (alumno_id, nombre, apellido, indicador_nacionalidad, fecha_nacimiento_dia, fecha_nacimiento_mes, fecha_nacimiento_ano, lugar_nacimiento, direccion_vivienda, telefono_alumno, ano_cursar, cedula_representante, nombre_representante, apellido_representante, parentesco_representante, direccion_representante, telefono_representante, email_representante, descripcion_trabajo, direccion_trabajo, telefono_trabajo, nombre_madre, apellido_madre, tel_madre, direccion_madre, nombre_padre, apellido_padre, tel_padre, direccion_padre, ingreso_familiar, vecino1_nombre, vecino1_parentesco, vecino1_telefono, vecino2_nombre, vecino2_parentesco, vecino2_telefono, seguro_posee, seguro_nombre, seguro_clinica, tipo_sangre, alergico, creado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['alumno_id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento_dia'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento_mes'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento_ano'], "int"),
                       GetSQLValueString($_POST['lugar_nacimiento'], "text"),
                       GetSQLValueString($_POST['direccion_vivienda'], "text"),
                       GetSQLValueString($_POST['telefono_alumno'], "text"),
                       GetSQLValueString($_POST['ano_cursar'], "text"),
                       GetSQLValueString($_POST['cedula_representante'], "int"),
                       GetSQLValueString($_POST['nombre_representante'], "text"),
                       GetSQLValueString($_POST['apellido_representante'], "text"),
                       GetSQLValueString($_POST['parentesco_representante'], "text"),
                       GetSQLValueString($_POST['direccion_representante'], "text"),
                       GetSQLValueString($_POST['telefono_representante'], "text"),
                       GetSQLValueString($_POST['email_representante'], "text"),
                       GetSQLValueString($_POST['descripcion_trabajo'], "text"),
                       GetSQLValueString($_POST['direccion_trabajo'], "text"),
                       GetSQLValueString($_POST['telefono_trabajo'], "text"),
                       GetSQLValueString($_POST['nombre_madre'], "text"),
                       GetSQLValueString($_POST['apellido_madre'], "text"),
                       GetSQLValueString($_POST['tel_madre'], "text"),
                       GetSQLValueString($_POST['direccion_madre'], "text"),
                       GetSQLValueString($_POST['nombre_padre'], "text"),
                       GetSQLValueString($_POST['apellido_padre'], "text"),
                       GetSQLValueString($_POST['tel_padre'], "text"),
                       GetSQLValueString($_POST['direccion_padre'], "text"),
                       GetSQLValueString($_POST['ingreso_familiar'], "text"),
                       GetSQLValueString($_POST['vecino1_nombre'], "text"),
                       GetSQLValueString($_POST['vecino1_parentesco'], "text"),
                       GetSQLValueString($_POST['vecino1_telefono'], "text"),
                       GetSQLValueString($_POST['vecino2_nombre'], "text"),
                       GetSQLValueString($_POST['vecino2_parentesco'], "text"),
                       GetSQLValueString($_POST['vecino2_telefono'], "text"),
                       GetSQLValueString($_POST['seguro_posee'], "int"),
                       GetSQLValueString($_POST['seguro_nombre'], "text"),
                       GetSQLValueString($_POST['seguro_clinica'], "text"),
                       GetSQLValueString($_POST['tipo_sangre'], "text"),
                       GetSQLValueString($_POST['alergico'], "text"),
                       GetSQLValueString($_POST['creado'], "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion_formal1_planilla3.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_sistemacol, $sistemacol);
$query_institucion = "SELECT * FROM sis_institucion";
$institucion = mysql_query($query_institucion, $sistemacol) or die(mysql_error());
$row_institucion = mysql_fetch_assoc($institucion);
$totalRows_institucion = mysql_num_rows($institucion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = "SELECT * FROM sis_periodo ORDER BY id DESC";
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$colname_alumno = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM sis_usuario WHERE cedula = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_info = "SELECT * FROM sis_alumno_info";
$alumno_info = mysql_query($query_alumno_info, $sistemacol) or die(mysql_error());
$row_alumno_info = mysql_fetch_assoc($alumno_info);
$totalRows_alumno_info = mysql_num_rows($alumno_info);

$colname_preinscripcion = "-1";
if (isset($_GET['cedula'])) {
  $colname_preinscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_preinscripcion = sprintf("SELECT * FROM sis_alumno_preinscripcion WHERE cedula = %s", GetSQLValueString($colname_preinscripcion, "text"));
$preinscripcion = mysql_query($query_preinscripcion, $sistemacol) or die(mysql_error());
$row_preinscripcion = mysql_fetch_assoc($preinscripcion);
$totalRows_preinscripcion = mysql_num_rows($preinscripcion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi_preinscripcion = "SELECT * FROM sis_cofi_preinscripcion";
$confi_preinscripcion = mysql_query($query_confi_preinscripcion, $sistemacol) or die(mysql_error());
$row_confi_preinscripcion = mysql_fetch_assoc($confi_preinscripcion);
$totalRows_confi_preinscripcion = mysql_num_rows($confi_preinscripcion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_ano_curso = "SELECT * FROM sis_curso_preinscripcion";
$ano_curso = mysql_query($query_ano_curso, $sistemacol) or die(mysql_error());
$row_ano_curso = mysql_fetch_assoc($ano_curso);
$totalRows_ano_curso = mysql_num_rows($ano_curso);

$colname_alumno_regular = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno_regular = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_regular = sprintf("SELECT * FROM alumno WHERE cedalum = %s", GetSQLValueString($colname_alumno_regular, "int"));
$alumno_regular = mysql_query($query_alumno_regular, $sistemacol) or die(mysql_error());
$row_alumno_regular = mysql_fetch_assoc($alumno_regular);
$totalRows_alumno_regular = mysql_num_rows($alumno_regular);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/main_central.css" rel="stylesheet" type="text/css">
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor_cetral">
  <table width="730" border="0" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td width="739"><table width="730" border="0" align="center">
        <tr>
          <td valign="top"><div align="right"><img src="../images/png/notas2.PNG" alt="" width="63" height="63"></div></td>
          <td><div align="left"><span class="titulo_extragrande_gris">PROCESO DE INSCRIPCION</span> <span class="titulo_extragrande_gris"><?php echo $row_periodo['descripcion']; ?></span></div></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center">
            <hr>
            <span class="cartelera_eloy">*Todos los datos son obligatorios, el estudiante no quedar&aacute; inscrito hasta tanto no presente esta planilla y realice la entrevista con su representante.</span><br>
          </div>
            <?php if  (($row_preinscripcion['estatus']==1) or ($row_confi_preinscripcion['tipo_inscripcion']==1) or ($totalRows_alumno_regular >0)) { // Show if recordset not empty ?>
            <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
              <fieldset>
                <legend class="texto_mediano_gris"><span class="titulo_periodico"><em>PASO 2</em></span></legend>
                <table width="700" align="center">
                  <tr valign="baseline">
                    <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_mediano_grande" ><strong><em>DATOS PERSONALES DEL ESTUDIANTE</em></strong>
                      </legend><table width="500" border="0">
                        <tr valign="baseline">
                          <td width="138" align="right" valign="top" nowrap class="texto_mediano_gris">Nacionalidad y C&eacute;dula: </td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><label>
                            </label>
                            <table width="318" border="0">
                              <tr>
                                <td width="44"><select name="indicador_nacionalidad" class="texto_mediano_gris" id="indicador_nacionalidad">
                                  <option value="V">V</option>
                                  <option value="E">E</option>
                                  </select></td>
                                <td><input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="<?php echo $row_alumno['cedula']; ?>" size="15" maxlength="15" readonly="readonly" onKeyUp="this.value=this.value.toUpperCase()">
                                  <span class="textfieldRequiredMsg">Se necesita un valor.</span></td>
                                </tr>
                              </table>
                            <div align="left"></div></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre del Estudiante:</td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><input name="nombre" type="text" class="texto_mediano_gris" id="nombre" value="<?php echo $row_preinscripcion['nombre']; ?>" onKeyUp="this.value=this.value.toUpperCase()"></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Apellido del Estudiante:</td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><input name="apellido" type="text" class="texto_mediano_gris" id="apellido" value="<?php echo $row_preinscripcion['apellido']; ?>" onKeyUp="this.value=this.value.toUpperCase()"></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Fecha de Nacimiento:</td>
                          <td width="22" align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="fecha_nacimiento_dia" type="text" class="texto_mediano_gris" id="fecha_nacimiento_dia" value="<?php echo $row_preinscripcion['fecha_nacimiento_dia']; ?>" size="2" maxlength="2">
                          </label></td>
                          <td width="35" align="left" valign="top" class="textograndes_eloy"> /
                            <input name="fecha_nacimiento_mes" type="text" class="texto_mediano_gris" id="fecha_nacimiento_mes" value="<?php echo $row_preinscripcion['fecha_nacimiento_mes']; ?>" size="2" maxlength="2"></td>
                          <td width="287" align="left" valign="top" class="textograndes_eloy">/
                            <input name="fecha_nacimiento_ano" type="text" class="texto_mediano_gris" id="fecha_nacimiento_ano" value="<?php echo $row_preinscripcion['fecha_nacimiento_ano']; ?>" size="4" maxlength="4">
                            <span class="texto_pequeno_gris">Ej. Dia/Mes/A&ntilde;o</span></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Lugar de Nacimiento:</td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><span id="sprytextfield4">
                            <label>
                              <input name="lugar_nacimiento" type="text" class="texto_mediano_gris" id="lugar_nacimiento" onKeyUp="this.value=this.value.toUpperCase()">
                            </label>
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Direcci&oacute;n:</td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><textarea name="direccion_vivienda" cols="40" rows="3" class="texto_mediano_gris" id="direccion_vivienda" onKeyUp="this.value=this.value.toUpperCase()"><?php echo $row_preinscripcion['direccion_vivienda']; ?></textarea></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono del Estudiante:</td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><input name="telefono_alumno" type="text" class="texto_mediano_gris" id="telefono_alumno" value="<?php echo $row_preinscripcion['telefono_alumno']; ?>"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Grado a Cursar:</td>
                          <td colspan="3" align="left" valign="top" class="textograndes_eloy"><label>
                            <select name="ano_cursar" class="texto_mediano_grande" id="ano_cursar">
                              <?php
do {  
?>
                              <option value="<?php echo $row_ano_curso['descripcion']?>"<?php if (!(strcmp($row_ano_curso['descripcion'], $row_preinscripcion['ano_cursar']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ano_curso['descripcion']?></option>
                              <?php
} while ($row_ano_curso = mysql_fetch_assoc($ano_curso));
  $rows = mysql_num_rows($ano_curso);
  if($rows > 0) {
      mysql_data_seek($ano_curso, 0);
	  $row_ano_curso = mysql_fetch_assoc($ano_curso);
  }
?>
                            </select>
                          </label></td>
                        </tr>
                        </table>
                      <BR>
                      </fieldset></td>
                    </tr>
                  <tr valign="baseline">
                    <td colspan="3" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                    </tr>
                  <tr valign="baseline">
                    <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_mediano_grande" ><strong><em>DATOS DEL REPRESENTANTE</em></strong> </legend>
                      <table width="500" border="0">
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre del Representante: </td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="nombre_representante" type="text" class="texto_mediano_gris" id="nombre_representante" onKeyUp="this.value=this.value.toUpperCase()"></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Apellido del Representante:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="apellido_representante" type="text" class="texto_mediano_gris" id="apellido_representante" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">No. Cedula del Representante:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="sprytextfield3">
                          <input name="cedula_representante" type="text" class="texto_mediano_gris" id="cedula_representante">
                          <span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span><span class="texto_pequeno_gris">                            Ej. 13987456</span></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Parentesco con el Estudiante:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="parentesco_representante" type="text" class="texto_mediano_gris" id="parentesco_representante" onKeyUp="this.value=this.value.toUpperCase()">
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Direccion de Vivienda:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <textarea name="direccion_representante" cols="40" rows="3" class="texto_mediano_gris" id="direccion_representante" onKeyUp="this.value=this.value.toUpperCase()"></textarea>
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="telefono_representante" type="text" class="texto_mediano_gris" id="telefono_representante"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">E-mail:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="email_representante" type="text" class="texto_mediano_gris" id="email_representante"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Profesi&oacute;n:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="descripcion_trabajo" type="text" class="texto_mediano_gris" id="descripcion_trabajo" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Direcci&oacute;n de Trabajo:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><textarea name="direccion_trabajo" cols="40" rows="3" class="texto_mediano_gris" id="direccion_trabajo" onKeyUp="this.value=this.value.toUpperCase()"></textarea></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono del Trabajo:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="telefono_trabajo" type="text" class="texto_mediano_gris" id="telefono_trabajo"></td>
                        </tr>
                      </table>
                      <BR>
                    </fieldset></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="3" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                    </tr>
                  <tr valign="baseline">
                    <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_mediano_grande" ><strong><em>DATOS DE LOS PADRES</em></strong></legend>
                      <table width="500" border="0">
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre de la Madre: </td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="nombre_madre" type="text" class="texto_mediano_gris" id="respuesta_secreta15" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Apellido de la Madre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="apellido_madre" type="text" class="texto_mediano_gris" id="respuesta_secreta16" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Direcci&oacute;n de la Madre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><textarea name="direccion_madre" cols="40" rows="3" class="texto_mediano_gris" id="respuesta_secreta17" onKeyUp="this.value=this.value.toUpperCase()"></textarea></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono de la Madre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="tel_madre" type="text" class="texto_mediano_gris" id="tel_madre">
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre del Padre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="nombre_padre" type="text" class="texto_mediano_gris" id="respuesta_secreta18" onKeyUp="this.value=this.value.toUpperCase()">
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Apellido del Padre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="apellido_padre" type="text" class="texto_mediano_gris" id="respuesta_secreta19" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Direcci&oacute;n del Padre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><textarea name="direccion_padre" cols="40" rows="3" class="texto_mediano_gris" id="respuesta_secreta20" onKeyUp="this.value=this.value.toUpperCase()"></textarea></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono del Padre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="tel_padre" type="text" class="texto_mediano_gris" id="respuesta_secreta21"></td>
                        </tr>
                      </table>
                      <BR>
                    </fieldset></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="3" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_mediano_grande" ><strong><em>INFORMACION GENERAL</em></strong></legend>
                      <table width="500" border="0">
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Ingreso Familiar:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <select name="ingreso_familiar" class="texto_mediano_gris" id="ingreso_familiar">
                              <option value="de 1.000 a 1.500 Bsf">de 1.000 a 1.500 Bsf</option>
                              <option value="de 1.500 a 2.000 Bsf">de 1.500 a 2.000 Bsf</option>
                              <option value="de 2.000 a 3.000 Bsf">de 2.000 a 3.000 Bsf</option>
                              <option value="de 3.000 a 4.000 Bsf">de 3.000 a 4.000 Bsf</option>
                              <option value="mas de 5.000 Bsf">mas de 5.000 Bsf</option>
                            </select>
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td colspan="2" align="center" valign="top" nowrap class="texto_mediano_grande"><strong><br>
                            En Caso de Emergencia llamar a:</strong>
                            <hr width="300"></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre Vecino/familiar(1):</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="vecino1_nombre" type="text" class="texto_mediano_gris" id="respuesta_secreta26" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Parentesco vecino/familiar(1):</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="vecino1_parentesco" type="text" class="texto_mediano_gris" id="pregunta_secreta4" onKeyUp="this.value=this.value.toUpperCase()">
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono vecino/familiar(1):</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="vecino1_telefono" type="text" class="texto_mediano_gris" id="respuesta_secreta27">
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre Vecino/familiar(2):</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="vecino2_nombre" type="text" class="texto_mediano_gris" id="respuesta_secreta28" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Parentesco vecino/familiar(2):</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="vecino2_parentesco" type="text" class="texto_mediano_gris" id="respuesta_secreta29" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tel&eacute;fono vecino/familiar(2):</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="vecino2_telefono" type="text" class="texto_mediano_gris" id="respuesta_secreta30"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Posee Seguro:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <select name="seguro_posee" class="texto_mediano_gris" id="seguro_posee">
                              <option value="1">Si</option>
                              <option value="0">No</option>
                            </select>
                          </label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Nombre del Seguro:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="seguro_nombre" type="text" class="texto_mediano_gris" id="respuesta_secreta32" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">En Caso de Emergencia Llevar a:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="seguro_clinica" type="text" class="texto_mediano_gris" id="respuesta_secreta22" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Tipo de Sangre:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="tipo_sangre" type="text" class="texto_mediano_gris" id="respuesta_secreta23" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Alergico(a) a:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><input name="alergico" type="text" class="texto_mediano_gris" id="respuesta_secreta33" onKeyUp="this.value=this.value.toUpperCase()"></td>
                        </tr>
                      </table>
                      <BR>
                    </fieldset></td>
                  </tr>
                  <tr valign="baseline">
                    <td width="234" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                    <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
                      <input name="alumno_id" type="hidden" id="alumno_id" value="<?php echo $row_alumno['id']; ?>">
                      <input name="creado" type="hidden" id="creado" value="<?php echo date("Y-m-d");  ?>">
                      <input type="submit" class="texto_mediano_gris" value="Aceptar >>">
                      </div></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                    <td colspan="2" valign="top" class="textograndes_eloy">&nbsp;</td>
                  </tr>
                  </table>
                </fieldset>
              <input type="hidden" name="MM_insert" value="form1">
            </form>
            <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($row_preinscripcion['estatus']==0) and  ($row_confi_preinscripcion['tipo_inscripcion']==0) and ($totalRows_alumno_regular ==0)) { // Show if recordset not empty ?>
            <table width="500" border="0" align="center">
            <tr>
              <td align="center"><img src="../images/png/6.png" width="179" height="179"><br>
                <span class="texto_mediano_grande"><br>
                  Aun no has sido <strong>Aceptado</strong> en la Instituci&oacute;n si deseas tener informaci&oacute;n al respecto comunicate con nosotros a traves del: <strong><?php echo $row_institucion['telcol']; ?></strong></span></td>
              </tr>
          </table>
            <?php } // Show if recordset not empty ?></td>
        </tr>
      </table>
  </table>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {hint:"Ej. 13568420", validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {minChars:7, validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($institucion);

mysql_free_result($periodo);

mysql_free_result($alumno);

mysql_free_result($alumno_info);

mysql_free_result($preinscripcion);

mysql_free_result($confi_preinscripcion);

mysql_free_result($ano_curso);

mysql_free_result($alumno_regular);
?>
