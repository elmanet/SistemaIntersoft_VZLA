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
  $insertSQL = sprintf("INSERT INTO sis_alumno_preinscripcion (id, nombre, apellido, indicador_nacionalidad, cedula, clave, fecha_nacimiento_dia, fecha_nacimiento_mes, fecha_nacimiento_ano, edad, direccion_vivienda, telefono_alumno, ano_cursar, info_retira, comportamiento, vivescon, ingre_familiar, recomendado, quien_paga, estatus, creado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento_dia'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento_mes'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento_ano'], "int"),
                       GetSQLValueString($_POST['edad'], "int"),
                       GetSQLValueString($_POST['direccion_vivienda'], "text"),
                       GetSQLValueString($_POST['telefono_alumno'], "text"),
                       GetSQLValueString($_POST['ano_cursar'], "text"),
                       GetSQLValueString($_POST['info_retira'], "text"),
                       GetSQLValueString($_POST['comportamiento'], "text"),
                       GetSQLValueString($_POST['vivescon'], "text"),
                       GetSQLValueString($_POST['ingre_familiar'], "text"),
                       GetSQLValueString($_POST['recomendado'], "text"),
                       GetSQLValueString($_POST['quien_paga'], "text"),
                       GetSQLValueString($_POST['estatus'], "int"),
                       GetSQLValueString($_POST['creado'], "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE sis_alumno_preinscripcion SET nombre=%s, apellido=%s, indicador_nacionalidad=%s, cedula=%s, clave=%s, fecha_nacimiento_dia=%s, fecha_nacimiento_mes=%s, fecha_nacimiento_ano=%s, edad=%s, direccion_vivienda=%s, telefono_alumno=%s, ano_cursar=%s, info_retira=%s, comportamiento=%s, vivescon=%s, ingre_familiar=%s, recomendado=%s, quien_paga=%s, estatus=%s, creado=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento_dia'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento_mes'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento_ano'], "int"),
                       GetSQLValueString($_POST['edad'], "int"),
                       GetSQLValueString($_POST['direccion_vivienda'], "text"),
                       GetSQLValueString($_POST['telefono_alumno'], "text"),
                       GetSQLValueString($_POST['ano_cursar'], "text"),
                       GetSQLValueString($_POST['info_retira'], "text"),
                       GetSQLValueString($_POST['comportamiento'], "text"),
                       GetSQLValueString($_POST['vivescon'], "text"),
                       GetSQLValueString($_POST['ingre_familiar'], "text"),
                       GetSQLValueString($_POST['recomendado'], "text"),
                       GetSQLValueString($_POST['quien_paga'], "text"),
                       GetSQLValueString($_POST['estatus'], "int"),
                       GetSQLValueString($_POST['creado'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "inscripcion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$ced_preinscripcion = "-1";
if (isset($_GET['cedula'])) {
  $ced_preinscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_preinscripcion = sprintf("SELECT id, indicador_nacionalidad, cedula, nombre, apellido, direccion_vivienda, telefono_alumno, fecha_nacimiento_dia, fecha_nacimiento_mes, fecha_nacimiento_ano, edad, ano_cursar, info_retira, comportamiento, vivescon, ingre_familiar, recomendado, quien_paga, estatus, creado FROM sis_alumno_preinscripcion WHERE cedula=%s", GetSQLValueString($ced_preinscripcion, "int"));
$preinscripcion = mysql_query($query_preinscripcion, $sistemacol) or die(mysql_error());
$row_preinscripcion = mysql_fetch_assoc($preinscripcion);
$colname_preinscripcion = "-1";
if (isset($_GET['cedula'])) {
  $colname_preinscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_preinscripcion = sprintf("SELECT * FROM sis_alumno_preinscripcion WHERE cedula=%s ", GetSQLValueString($colname_preinscripcion, "text"));
$preinscripcion = mysql_query($query_preinscripcion, $sistemacol) or die(mysql_error());
$row_preinscripcion = mysql_fetch_assoc($preinscripcion);
$totalRows_preinscripcion = mysql_num_rows($preinscripcion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_curso = "SELECT * FROM sis_curso_preinscripcion ORDER BY id ASC";
$curso = mysql_query($query_curso, $sistemacol) or die(mysql_error());
$row_curso = mysql_fetch_assoc($curso);
$totalRows_curso = mysql_num_rows($curso);

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/main_central.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor_cetral">
  <table width="730" border="0" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td width="739"><table width="730" border="0" align="center">
        <tr>
          <td rowspan="3" valign="top"><div align="right"><img src="../images/png/notas2.PNG" alt="" width="63" height="63"></div></td>
          <td><div align="left"><span class="titulo_extragrande_gris">PROCESO DE PRE-INSCRIPCION</span></div></td>
        </tr>
        <tr>
          <td><div align="left"><span class="titulo_extramediano_gris"><span class="titulosmedianos_eloy">ESTUDIANTES NUEVO INGRESO</span></span></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="center">
            <hr>
            <span class="cartelera_eloy">*Todos los datos son obligatorios, el estudiante no quedar&aacute; inscrito hasta tanto no presente esta planilla y realice la entrevista con su representante.</span>
            <hr>
          </div>
            <?php if ($totalRows_preinscripcion == 0) { // Show if recordset empty ?>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
    <fieldset>
      <legend class="texto_mediano_gris">DATOS DEL ESTUDIANTE</legend>
      <table width="700" align="center">
        <tr valign="baseline">
          <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
            <legend class="texto_pequeno_gris" >INFORMACION DE CUENTA</legend>
            <table width="500" border="0">
              <tr valign="baseline">
                <td width="133" align="right" valign="top" nowrap class="texto_mediano_gris"><div align="right">C&eacute;dula del Estudiante: </div></td>
                <td width="44" align="left" valign="top" class="textograndes_eloy"><label>
                  <select name="indicador_nacionalidad" class="texto_mediano_gris" id="indicador_nacionalidad">
                    <option value="V">V</option>
                    <option value="E">E</option>
                    </select>
                  </label>
                  <div align="left"></div></td>
                <td width="309" align="left" valign="top" class="textograndes_eloy">
                  <input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="<?php echo $_GET['cedula']; ?>" size="15" maxlength="15" readonly="readonly">
                  <br>
                  <span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" width="18" height="18" align="absmiddle"> Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" alt="" width="18" height="18" align="absmiddle"></span><span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" width="18" height="18" align="absmiddle"></span>S&oacute;lo debes agregar N&uacute;meros.</span></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Clave:</td>
                <td colspan="2" align="left" valign="top" class="textograndes_eloy"><span id="sprypassword1">
                  <label>
                    <input name="clave" type="password" class="texto_mediano_gris" id="clave">
                  </label>
                  <span class="passwordRequiredMsg">Se necesita un valor.</span><span class="passwordMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Confirmar clave:</td>
                <td colspan="2" align="left" valign="top" class="textograndes_eloy"><span id="spryconfirm1">
                  <label>
                    <input name="confirma" type="password" class="texto_mediano_gris" id="confirma">
                  </label>
                  <span class="confirmRequiredMsg">Se necesita un valor.</span><span class="confirmInvalidMsg">Los valores no coinciden.</span></span></td>
              </tr>
            </table>
            <BR>
          </fieldset></td>
        </tr>
        <tr valign="baseline">
          <td width="310" align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Nombre  del Estudiante:</em></div></td>
          <td width="374" colspan="2" valign="top" class="textograndes_eloy"><div align="left"><span id="sprytextfield2">
            <input name="nombre" type="text" class="texto_mediano_gris" id="nombre" onKeyUp="this.value=this.value.toUpperCase()" value="" size="32">
            <br>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Apellido  del Estudiante:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left"><span id="sprytextfield3">
            <input name="apellido" type="text" class="texto_mediano_gris" id="apellido" value="" size="32" onKeyUp="this.value=this.value.toUpperCase()">
            <br>
            <span class="textfieldRequiredMsg"> Se necesita un valor.</span></span></div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Direcci&oacute;n:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <textarea name="direccion_vivienda" cols="32" rows="3" class="texto_mediano_gris" id="direccion_vivienda" onKeyUp="this.value=this.value.toUpperCase()"></textarea>
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Tel&eacute;fono:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="telefono_alumno" type="text" class="texto_mediano_gris" id="telefono_alumno" value="" size="32">
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Fecha de nacimiento: </em></div></td>
          <td colspan="2" align="left" valign="middle" class="textograndes_eloy"><div align="left">
            <label><span class="texto_mediano_gris"><strong>Dia:</strong>
              <input name="fecha_nacimiento_dia" type="text" id="fecha_nacimiento_dia" size="2" maxlength="2">
              </span></label>
            <span class="texto_mediano_gris"><strong>Mes:</strong>
              <input name="fecha_nacimiento_mes" type="text" id="fecha_nacimiento_mes" size="2" maxlength="2">
              <strong>A&ntilde;o:</strong>
              <input name="fecha_nacimiento_ano" type="text" id="fecha_nacimiento_ano" size="4" maxlength="4">
              </span></div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><em>Edad:</em></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="edad" type="text" class="texto_mediano_gris" id="edad" size="2">
            <span class="texto_mediano_gris">                    a&ntilde;os</span></div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><em>Grado o a&ntilde;o a Cursar: </em></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <select name="ano_cursar" class="texto_mediano_gris" id="ano_cursar">
              <?php
do {  
?>
              <option value="<?php echo $row_curso['descripcion']?>"><?php echo $row_curso['descripcion']?></option>
              <?php
} while ($row_curso = mysql_fetch_assoc($curso));
  $rows = mysql_num_rows($curso);
  if($rows > 0) {
      mysql_data_seek($curso, 0);
	  $row_curso = mysql_fetch_assoc($curso);
  }
?>
              </select>
            <span class="cartelera_eloy">Seleccione el grado o a&ntilde;o a cursar</span></div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Porqu&eacute; se retira del otro Plantel: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="info_retira" type="text" class="texto_mediano_gris" id="info_retira" onKeyUp="this.value=this.value.toUpperCase()" value="" size="32">
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Como es tu comportamiento: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="comportamiento" type="text" class="texto_mediano_gris" value="" size="32" onKeyUp="this.value=this.value.toUpperCase()">
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Con quien vives:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="vivescon" type="text" class="texto_mediano_gris" id="vivescon" onKeyUp="this.value=this.value.toUpperCase()" value="" size="32">
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Ingreso Familiar: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <select name="ingre_familiar" class="texto_mediano_gris" id="ingre_familiar">
              <option value="De 500 a 1.500 BsF" selected >De 500 a 1.500 BsF</option>
              <option value="De 1.500 a 2.500 BsF" >De 1.500 a 2.500 BsF</option>
              <option value="De 2.500 a 3.500 BsF" >De 2.500 a 3.500 BsF</option>
              <option value="M&aacute;s de 3.500 BsF" >M&aacute;s de 3.500 BsF</option>
              </select>
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Quien le recomendo el colegio:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="recomendado" type="text" class="texto_mediano_gris" value="" size="32" onKeyUp="this.value=this.value.toUpperCase()">
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Quien le pagar&aacute; la mensualidad: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="quien_paga" type="text" class="texto_mediano_gris" id="quien_paga" onKeyUp="this.value=this.value.toUpperCase()" value="" size="32">
            </div></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="textograndes_eloy"><div align="right"></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input type="hidden" name="id" id="id">
            <input name="estatus" type="hidden" id="estatus" value="0">
            <input name="creado" type="hidden" id="creado" value="<?php echo date("Y-m-d");  ?>">
            <input type="submit" class="texto_mediano_gris" value="Aceptar >>">
            - <a href="../privates/inscripcion.php" class="cartelera_eloy">CANCELAR </a>- </div></td>
        </tr>
      </table>
    </fieldset>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <?php } // Show if recordset empty ?>
<hr></td>
        </tr>
        <tr>
          <td colspan="2"><?php if ($totalRows_preinscripcion > 0) { // Show if recordset not empty ?>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form2">
    <fieldset>
      <legend class="texto_mediano_gris">DATOS DEL ESTUDIANTE</legend>
      <table width="700" align="center">
        <tr valign="baseline">
          <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
            <legend class="texto_pequeno_gris" >INFORMACION DE CUENTA</legend>
            <table width="500" border="0">
              <tr valign="baseline">
                <td width="133" align="right" valign="top" nowrap class="texto_mediano_gris"><div align="right">C&eacute;dula del Estudiante: </div></td>
                <td width="44" align="left" valign="top" class="textograndes_eloy"><label>
                  <select name="indicador_nacionalidad" class="texto_mediano_gris" id="indicador_nacionalidad">
                    <option value="V">V</option>
                    <option value="E">E</option>
                    </select>
                  </label>
                  <div align="left"></div></td>
                <td width="309" align="left" valign="top" class="textograndes_eloy">
                  <input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="<?php echo $_GET['cedula']; ?>" size="15" maxlength="15">
                  <br>
                  <span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" width="18" height="18" align="absmiddle"> Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" alt="" width="18" height="18" align="absmiddle"></span><span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" width="18" height="18" align="absmiddle"></span>S&oacute;lo debes agregar N&uacute;meros.</span></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Clave:</td>
                <td colspan="2" align="left" valign="top" class="textograndes_eloy"><span id="sprypassword1">
                  <label>
                    <input name="clave" type="password" class="texto_mediano_gris" id="clave">
                  </label>
                  <span class="passwordRequiredMsg">Se necesita un valor.</span><span class="passwordMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span></span></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Confirmar clave:</td>
                <td colspan="2" align="left" valign="top" class="textograndes_eloy"><span id="spryconfirm2"><span id="spryconfirm1">
                  <label>
                    <input name="confirma" type="password" class="texto_mediano_gris" id="confirma">
                  </label>
                  <span class="confirmRequiredMsg">Se necesita un valor.</span><span class="confirmInvalidMsg">Los valores no coinciden.</span></span></td>
                </tr>
              </table>
            <br>
            </fieldset>
            <span class="titulo_extragrande_gris">
            <?php if ($row_preinscripcion['estatus']==1){ echo "<BR>YA ESTAS ACEPTADO AHORA <BR> DEBES  LLENAR LA PLANILLA DE INSCRIPCION FORMAL<BR><BR>"; }?>
            </span><BR></td>
          </tr>
        <tr valign="baseline">
          <td width="310" align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Nombre  del Estudiante:</em></div></td>
          <td width="374" colspan="2" valign="top" class="textograndes_eloy"><div align="left"><span id="sprytextfield2">
            <input name="nombre" type="text" class="texto_mediano_gris" id="nombre" onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $row_preinscripcion['nombre']; ?>" size="32">
            <br>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Apellido  del Estudiante:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left"><span id="sprytextfield3">
            <input name="apellido" type="text" class="texto_mediano_gris" id="apellido" value="<?php echo $row_preinscripcion['apellido']; ?>" size="32" onKeyUp="this.value=this.value.toUpperCase()">
            <br>
            <span class="textfieldRequiredMsg"> Se necesita un valor.</span></span></div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Direcci&oacute;n:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <textarea name="direccion_vivienda" cols="32" rows="3" class="texto_mediano_gris" id="direccion_vivienda" onKeyUp="this.value=this.value.toUpperCase()"><?php echo $row_preinscripcion['direccion_vivienda']; ?></textarea>
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Tel&eacute;fono:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="telefono_alumno" type="text" class="texto_mediano_gris" id="telefono_alumno" value="<?php echo $row_preinscripcion['telefono_alumno']; ?>" size="32">
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Fecha de nacimiento: </em></div></td>
          <td colspan="2" align="left" valign="middle" class="textograndes_eloy"><div align="left">
            <label><span class="texto_mediano_gris"><strong>Dia:</strong>
              <input name="fecha_nacimiento_dia" type="text" id="fecha_nacimiento_dia" value="<?php echo $row_preinscripcion['fecha_nacimiento_dia']; ?>" size="2" maxlength="2">
              </span></label>
            <span class="texto_mediano_gris"><strong>Mes:</strong>
              <input name="fecha_nacimiento_mes" type="text" id="fecha_nacimiento_mes" value="<?php echo $row_preinscripcion['fecha_nacimiento_mes']; ?>" size="2" maxlength="2">
              <strong>A&ntilde;o:</strong>
              <input name="fecha_nacimiento_ano" type="text" id="fecha_nacimiento_ano" value="<?php echo $row_preinscripcion['fecha_nacimiento_ano']; ?>" size="4" maxlength="4">
              </span></div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><em>Edad:</em></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="edad" type="text" class="texto_mediano_gris" id="edad" value="<?php echo $row_preinscripcion['edad']; ?>" size="2">
            <span class="texto_mediano_gris"> a&ntilde;os</span></div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><em>Grado o a&ntilde;o a Cursar: </em></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <select name="ano_cursar" class="texto_mediano_gris" id="ano_cursar">
              <?php
do {  
?>
              <option value="<?php echo $row_curso['descripcion']?>"<?php if (!(strcmp($row_curso['descripcion'], $row_preinscripcion['ano_cursar']))) {echo "selected=\"selected\"";} ?>><?php echo $row_curso['descripcion']?></option>
              <?php
} while ($row_curso = mysql_fetch_assoc($curso));
  $rows = mysql_num_rows($curso);
  if($rows > 0) {
      mysql_data_seek($curso, 0);
	  $row_curso = mysql_fetch_assoc($curso);
  }
?>
              </select>
            <span class="cartelera_eloy">Seleccione el grado o a&ntilde;o a cursar</span></div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Porqu&eacute; se retira del otro Plantel: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="info_retira" type="text" class="texto_mediano_gris" id="info_retira" onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $row_preinscripcion['info_retira']; ?>" size="32">
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Como es tu comportamiento: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="comportamiento" type="text" class="texto_mediano_gris" id="comportamiento" onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $row_preinscripcion['comportamiento']; ?>" size="32">
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Con quien vives:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="vivescon" type="text" class="texto_mediano_gris" id="vivescon" onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $row_preinscripcion['vivescon']; ?>" size="32">
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Ingreso Familiar: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <select name="ingre_familiar" class="texto_mediano_gris" id="ingre_familiar">
              <option value="De 500 a 1.500 BsF" selected  <?php if (!(strcmp("De 500 a 1.500 BsF", $row_preinscripcion['ingre_familiar']))) {echo "selected=\"selected\"";} ?>>De 500 a 1.500 BsF</option>
              <option value="De 1.500 a 2.500 BsF"  <?php if (!(strcmp("De 1.500 a 2.500 BsF", $row_preinscripcion['ingre_familiar']))) {echo "selected=\"selected\"";} ?>>De 1.500 a 2.500 BsF</option>
              <option value="De 2.500 a 3.500 BsF"  <?php if (!(strcmp("De 2.500 a 3.500 BsF", $row_preinscripcion['ingre_familiar']))) {echo "selected=\"selected\"";} ?>>De 2.500 a 3.500 BsF</option>
              </select>
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Quien le recomendo el colegio:</em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="recomendado" type="text" class="texto_mediano_gris" id="recomendado" onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $row_preinscripcion['recomendado']; ?>" size="32">
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em>Quien le pagar&aacute; la mensualidad: </em></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="quien_paga" type="text" class="texto_mediano_gris" id="quien_paga" onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $row_preinscripcion['quien_paga']; ?>" size="32">
            </div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" valign="middle" nowrap class="textograndes_eloy"><div align="right"></div></td>
          <td colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input name="id" type="hidden" id="id" value="<?php echo $row_preinscripcion['id']; ?>">
            <input name="estatus" type="hidden" id="estatus" value="<?php echo $row_preinscripcion['estatus']; ?>">
            <input name="creado" type="hidden" id="creado" value="<?php echo $row_preinscripcion['creado']; ?>">
            <input type="submit" class="texto_mediano_gris" value="Aceptar >>">
          </div></td>
          </tr>
        </table>
      </fieldset>
    <input type="hidden" name="MM_update" value="form2">
  </form>
  <?php } // Show if recordset not empty ?></td>
        </tr>
      </table>
  </table>
</div>
<script type="text/javascript">
<!--
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {hint:"Ej. 13568420", validateOn:["blur"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:4, validateOn:["blur"]});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "clave", {validateOn:["blur"]});

//-->
</script>
</body>
</html>
<?php
mysql_free_result($preinscripcion);

mysql_free_result($curso);

?>
