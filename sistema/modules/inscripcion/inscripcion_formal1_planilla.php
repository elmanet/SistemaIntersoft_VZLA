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
  $insertSQL = sprintf("INSERT INTO sis_usuario (id, cedula, clave, pregunta_secreta, respuesta_secreta, creado) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['pregunta_secreta'], "text"),
                       GetSQLValueString($_POST['respuesta_secreta'], "text"),
                       GetSQLValueString($_POST['creado'], "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion_formal1_planilla2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO sis_usuario (id, cedula, clave, pregunta_secreta, respuesta_secreta, creado) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['pregunta_secreta'], "text"),
                       GetSQLValueString($_POST['respuesta_secreta'], "text"),
                       GetSQLValueString($_POST['creado'], "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion_formal1_planilla2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO sis_usuario (id, cedula, clave, pregunta_secreta, respuesta_secreta, creado) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['pregunta_secreta'], "text"),
                       GetSQLValueString($_POST['respuesta_secreta'], "text"),
                       GetSQLValueString($_POST['creado'], "date"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion_formal1_planilla2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_preinscripcion = "-1";
if (isset($_GET['cedula'])) {
  $colname_preinscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_preinscripcion = sprintf("SELECT id, nombre, apellido, indicador_nacionalidad, cedula, fecha_nacimiento_dia, fecha_nacimiento_mes, fecha_nacimiento_ano, edad, direccion_vivienda, telefono_alumno, ano_cursar, info_retira, comportamiento, vivescon, ingre_familiar, recomendado, quien_paga, estatus, creado FROM sis_alumno_preinscripcion WHERE cedula = %s", GetSQLValueString($colname_preinscripcion, "text"));
$preinscripcion = mysql_query($query_preinscripcion, $sistemacol) or die(mysql_error());
$row_preinscripcion = mysql_fetch_assoc($preinscripcion);
$totalRows_preinscripcion = mysql_num_rows($preinscripcion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_confi_preinscripcion = "SELECT * FROM sis_cofi_preinscripcion";
$confi_preinscripcion = mysql_query($query_confi_preinscripcion, $sistemacol) or die(mysql_error());
$row_confi_preinscripcion = mysql_fetch_assoc($confi_preinscripcion);
$totalRows_confi_preinscripcion = mysql_num_rows($confi_preinscripcion);

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
$query_institucion = "SELECT * FROM sis_institucion";
$institucion = mysql_query($query_institucion, $sistemacol) or die(mysql_error());
$row_institucion = mysql_fetch_assoc($institucion);
$totalRows_institucion = mysql_num_rows($institucion);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = "SELECT * FROM sis_periodo ORDER BY id DESC";
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$colname_alumno_info = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno_info = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno_info = sprintf("SELECT * FROM sis_alumno_info a, sis_usuario b WHERE a.alumno_id=b.id AND b.cedula = %s", GetSQLValueString($colname_alumno_info, "int"));
$alumno_info = mysql_query($query_alumno_info, $sistemacol) or die(mysql_error());
$row_alumno_info = mysql_fetch_assoc($alumno_info);
$totalRows_alumno_info = mysql_num_rows($alumno_info);

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
<script src="../../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
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
            <span class="cartelera_eloy">*Todos los datos son obligatorios, el estudiante no quedar&aacute; inscrito hasta tanto no presente esta planilla y realice la entrevista con su representante.</span> </div>
            <?php if (($totalRows_preinscripcion == 0) and ($row_confi_preinscripcion['tipo_inscripcion']==1) and ($totalRows_alumno == 0)) { // Show if recordset empty ?>
            <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
              <fieldset>
                <legend class="texto_mediano_gris"><span class="titulo_periodico"><em>PASO 1</em></span></legend>
                <table width="700" align="center">
                  <tr valign="baseline">
                    <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_mediano_grande" ><strong><em>INFORMACION DE CUENTA</em></strong></legend>
                      <table width="500" border="0">
                        <tr valign="baseline">
                          <td width="133" align="right" valign="top" nowrap class="texto_mediano_gris"><div align="right">C&eacute;dula del Estudiante: </div></td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="sprytextfield1">
                            <strong>
                            <input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="<?php echo $_GET['cedula']; ?>" size="15" maxlength="15" readonly="readonly">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></strong><span class="textfieldRequiredMsg"></span></span></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Clave:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="sprypassword1"><span id="sprypassword2">
                            <label>
                              <input name="clave" type="password" class="texto_mediano_gris" id="clave">
                              </label>
                            <span class="passwordRequiredMsg">Se necesita un valor.</span><span class="passwordMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Confirmar clave:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="spryconfirm1">
                            <label>
                              <input name="confirma" type="password" class="texto_mediano_gris" id="confirma">
                              </label>
                            <span class="confirmRequiredMsg">Se necesita un valor.</span><span class="confirmInvalidMsg">Los valores no coinciden.</span></span></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Pregunta Secreta:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="pregunta_secreta" type="text" class="texto_mediano_gris" id="pregunta_secreta">
                            <em>Ej. Nombre de mi Perro</em></label></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Respuesta Secreta:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="respuesta_secreta" type="text" class="texto_mediano_gris" id="respuesta_secreta">
                            </label></td>
                          </tr>
                        </table>
                      <BR>
                      </fieldset></td>
                    </tr>
                  <tr valign="baseline">
                    <td width="234" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                    <td width="454" colspan="2" valign="top" class="textograndes_eloy"><div align="left">
                      <input type="hidden" name="id" id="id">
                      <input name="creado" type="hidden" id="creado" value="<?php echo date("Y-m-d");  ?>">
                      <input type="submit" class="texto_mediano_gris" value="Aceptar >>">
                      </div></td>
                    </tr>
                  </table>
                </fieldset>
              <input type="hidden" name="MM_insert" value="form1">
            </form>
            <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2">
            <?php if (($totalRows_preinscripcion > 0) and ($row_confi_preinscripcion['tipo_inscripcion']==0) and ($row_preinscripcion['estatus']==1) and ($totalRows_alumno ==0)) { // Show if recordset not empty ?>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form2">
    <fieldset>
      <legend class="texto_mediano_gris"><span class="titulo_periodico"><em>PASO 1 - Estudiante Nuevo</em></span></legend>
      <table width="700" align="center">
        <tr valign="baseline">
          <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
            <legend class="texto_mediano_grande" ><strong><em>INFORMACION DE CUENTA</em></strong></legend>
            <table width="500" border="0">
              <tr valign="baseline">
                <td width="133" align="right" valign="top" nowrap class="texto_mediano_gris"><div align="right">C&eacute;dula del Estudiante: </div></td>
                <td align="left" valign="top" class="textograndes_eloy"><span id="sprytextfield2">
                    <strong>
                    <input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="<?php echo $_GET['cedula']; ?>" size="15" maxlength="15" readonly="readonly">
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span></strong><span class="textfieldRequiredMsg"></span></span></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Clave:</td>
                <td align="left" valign="top" class="textograndes_eloy"><span id="sprypassword2">
                  <label>
                    <input name="clave" type="password" class="texto_mediano_gris" id="clave">
                    </label>
                  <span class="passwordRequiredMsg">Se necesita un valor.</span><span class="passwordMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span></span></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Confirmar clave:</td>
                <td align="left" valign="top" class="textograndes_eloy"><span id="spryconfirm1">
                  <label>
                    <input name="confirma" type="password" class="texto_mediano_gris" id="confirma">
                    </label>
                  <span class="confirmRequiredMsg">Se necesita un valor.</span><span class="confirmInvalidMsg">Los valores no coinciden.</span></span></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Pregunta Secreta:</td>
                <td align="left" valign="top" class="textograndes_eloy"><label>
                  <input name="pregunta_secreta" type="text" class="texto_mediano_gris" id="pregunta_secreta">
                  <em>Ej. Nombre de mi Perro</em></label></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap class="texto_mediano_gris">Respuesta Secreta:</td>
                <td align="left" valign="top" class="textograndes_eloy"><label>
                  <input name="respuesta_secreta" type="text" class="texto_mediano_gris" id="respuesta_secreta">
                  </label></td>
                </tr>
              </table>
            <BR>
            </fieldset></td>
          </tr>
        <tr valign="baseline">
          <td width="234" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
          <td width="454" colspan="2" valign="top" class="textograndes_eloy"><div align="left">
            <input type="hidden" name="id" id="id">
            <input name="creado" type="hidden" id="creado" value="<?php echo date("Y-m-d");  ?>">
            <input type="submit" class="texto_mediano_gris" value="Aceptar >>">
          </div></td>
          </tr>
        </table>
      </fieldset>
    <input type="hidden" name="MM_insert" value="form2">
  </form>
  <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($totalRows_preinscripcion == 0) and ($row_confi_preinscripcion['tipo_inscripcion']==1) and ($totalRows_alumno > 0)) { // Show if recordset empty ?>
            <table width="500" border="0" align="center">
              <tr>
                <td align="center"><?php if ($totalRows_alumno_info == 0) { // Show if recordset empty ?>
                      <fieldset style="background-color:#FFC">
                        <em>
                        <legend class="titulo_grande_gris">ATENCION</legend>
                        </em>
                        <p><span class="texto_mediano_grande">El sistema ha detectado que no has llenado el </span><span class="texto_grande_gris"><strong>PASO 2</strong></span><span class="texto_mediano_grande"> <em><strong>Informaci&oacute;n general del Estudiante</strong></em> para hacerlo ahora presiona click en el siguiente bot&oacute;n:</span></p>
                        <form name="form3" method="get" action="inscripcion_formal1_planilla2.php">
                          <label>
                            <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
                            <input name="button2" type="submit" class="texto_mediano_grande" id="button2" value="Llenar Datos &gt;&gt;">
                          </label>
                          <br>
                        </form>
                      </fieldset>
                  <?php } // Show if recordset empty ?>
                  <span class="texto_mediano_grande">                  </span></td>
              </tr>
              <tr>
                <td align="center"><?php if ($totalRows_alumno_info > 0) { // Show if recordset not empty ?>
  <img src="../images/png/atencion.png" width="140" height="125"><br>
                    <br>
                    <span class="texto_mediano_grande">Ya estas Registrado(a) si deseas hacer una modificaci&oacute;n <br>
                    Presiona click en el siguiente bot&oacute;n:<br>
  <form name="form4" method="get" action="inscripcion_formal1_modificar1.php">
    <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
    <label>
      <input name="button4" type="submit" class="texto_mediano_gris" id="button4" value="Modificar Informaci&oacute;n &gt;&gt;">
      </label>
  </form>
                    ____________________
  <?php } // Show if recordset not empty ?></td>
              </tr>
            </table>
            <p>
              <?php } // Show if recordset not empty ?>
            </p></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($totalRows_preinscripcion > 0) and ($row_confi_preinscripcion['tipo_inscripcion']==0) and ($row_preinscripcion['estatus']==1) and ($totalRows_alumno > 0)) { // Show if recordset not empty ?>
            <table width="500" border="0" align="center">
              <tr>
                <td align="center" valign="top">
____________________
<?php if ($totalRows_alumno_info == 0) { // Show if recordset empty ?>
  <fieldset style="background-color:#FFC">
    <em>
      <legend class="titulo_grande_gris">ATENCION</legend>
      </em>
    <p><span class="texto_mediano_grande">El sistema ha detectado que no has llenado el </span><span class="texto_grande_gris"><strong>PASO 2</strong></span><span class="texto_mediano_grande"> <em><strong>Informaci&oacute;n general del Estudiante</strong></em> para hacerlo ahora presiona click en el siguiente bot&oacute;n:</span></p>
    <form name="form3" method="get" action="inscripcion_formal1_planilla2.php">
      <label>
        <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
        <input name="button" type="submit" class="texto_mediano_grande" id="button" value="Llenar Datos &gt;&gt;">
        </label>
      <br>
      </form>
  </fieldset>
  <?php } // Show if recordset empty ?></td>
              </tr>
              <tr>
                <td align="center" valign="top"><?php if ($totalRows_alumno_info > 0) { // Show if recordset not empty ?>
                    <p><img src="../images/png/atencion.png" width="102" height="91"><br>
                      <br>
                      <span class="texto_mediano_grande">Ya estas Registrado(a) si deseas hacer una modificaci&oacute;n <br>
                      Presiona click en el siguiente bot&oacute;n:<br>
                    </p>
                    <form name="form4" method="get" action="inscripcion_formal1_modificar1.php">
                      <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
                      <label>
                        <input name="button5" type="submit" class="texto_mediano_gris" id="button5" value="Modificar Informaci&oacute;n &gt;&gt;">
                      </label>
                    </form>
                    <?php } // Show if recordset not empty ?></td>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($totalRows_preinscripcion > 0) and ($row_confi_preinscripcion['tipo_inscripcion']==0) and ($row_preinscripcion['estatus']==0) and ($totalRows_alumno == 0)) { // Show if recordset not empty ?>
            <table width="500" border="0" align="center">
              <tr>
                <td align="center"><img src="../images/png/6.png" width="179" height="179"><br>
                  <span class="texto_mediano_grande"><br>
Aun no has sido <strong>Aceptado</strong> en la Instituci&oacute;n si deseas tener informaci&oacute;n al respecto comunicate con nosotros a traves del: <strong><?php echo $row_institucion['telcol']; ?></strong></span></td>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($totalRows_preinscripcion == 0) and ($row_confi_preinscripcion['tipo_inscripcion']==0) and ($totalRows_alumno_regular ==0)) { // Show if recordset not empty ?>
            <table width="500" border="0" align="center">
              <tr>
                <td align="center"><img src="../images/png/send.png" width="128" height="128"><br>
                  <span class="texto_mediano_grande"><br>
                    Aun no has llenado la planilla de <strong>PRE-INSCRIPCION</strong> para la Entrevista si lo deseas hacer en este momento presiona click <a href="inscripcion1.php">AQUI</a></span></td>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($row_confi_preinscripcion['tipo_inscripcion']==0) and ($totalRows_alumno ==0) and ($totalRows_alumno_regular > 0)) { // Show if recordset not empty ?>
            <form action="<?php echo $editFormAction; ?>" method="POST" name="form3">
              <fieldset>
                <legend class="texto_mediano_gris"><span class="titulo_periodico"><em>PASO 1 - Estudiante Regular</em></span></legend>
                <table width="700" align="center">
                  <tr valign="baseline">
                    <td colspan="3" align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_mediano_grande" ><strong><em>INFORMACION DE CUENTA</em></strong></legend>
                      <table width="500" border="0">
                        <tr valign="baseline">
                          <td width="133" align="right" valign="top" nowrap class="texto_mediano_gris"><div align="right">C&eacute;dula del Estudiante: </div></td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="sprytextfield2"> <strong>
                            <input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="<?php echo $_GET['cedula']; ?>" size="15" maxlength="15" readonly="readonly">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></strong><span class="textfieldRequiredMsg"></span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Clave:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="sprypassword2">
                            <label>
                              <input name="clave" type="password" class="texto_mediano_gris" id="clave">
                            </label>
                            <span class="passwordRequiredMsg">Se necesita un valor.</span><span class="passwordMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Confirmar clave:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><span id="spryconfirm1">
                            <label>
                              <input name="confirma" type="password" class="texto_mediano_gris" id="confirma">
                            </label>
                            <span class="confirmRequiredMsg">Se necesita un valor.</span><span class="confirmInvalidMsg">Los valores no coinciden.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Pregunta Secreta:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="pregunta_secreta" type="text" class="texto_mediano_gris" id="pregunta_secreta">
                            <em>Ej. Nombre de mi Perro</em></label></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap class="texto_mediano_gris">Respuesta Secreta:</td>
                          <td align="left" valign="top" class="textograndes_eloy"><label>
                            <input name="respuesta_secreta" type="text" class="texto_mediano_gris" id="respuesta_secreta">
                          </label></td>
                        </tr>
                      </table>
                      <BR>
                    </fieldset></td>
                  </tr>
                  <tr valign="baseline">
                    <td width="234" align="right" valign="middle" nowrap class="textograndes_eloy">&nbsp;</td>
                    <td width="454" colspan="2" valign="top" class="textograndes_eloy"><div align="left">
                      <input type="hidden" name="id" id="id">
                      <input name="creado" type="hidden" id="creado" value="<?php echo date("Y-m-d");  ?>">
                      <input type="submit" class="texto_mediano_gris" value="Aceptar >>">
                    </div></td>
                  </tr>
                </table>
              </fieldset>
              <input type="hidden" name="MM_insert" value="form3">
            </form>
            <?php } // Show if recordset not empty ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if (($row_confi_preinscripcion['tipo_inscripcion']==0) and ($totalRows_alumno > 0) and ($totalRows_alumno_regular >0)) { // Show if recordset not empty ?>
            <table width="500" border="0" align="center">
              <tr>
                <td align="center" valign="top"><?php if ($totalRows_alumno_info == 0) { // Show if recordset empty ?>
                    <fieldset style="background-color:#FFC">
                      <em>
                        <legend class="titulo_grande_gris">ATENCION</legend>
                        </em>
                      <p><span class="texto_mediano_grande">El sistema ha detectado que no has llenado el </span><span class="texto_grande_gris"><strong>PASO 2</strong></span><span class="texto_mediano_grande"> <em><strong>Informaci&oacute;n general del Estudiante</strong></em> para hacerlo ahora presiona click en el siguiente bot&oacute;n:</span></p>
                      <form name="form3" method="get" action="inscripcion_formal1_planilla2.php">
                        <label>
                          <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
                          <input name="button3" type="submit" class="texto_mediano_grande" id="button3" value="Llenar Datos &gt;&gt;">
                        </label>
                        <br>
                      </form>
                    </fieldset>
                    <?php } // Show if recordset empty ?></td>
              </tr>
              <tr>
                <td align="center" valign="top"><?php if ($totalRows_alumno_info > 0) { // Show if recordset not empty ?>
                    <p><img src="../images/png/atencion.png" width="102" height="91"><br>
                      <br>
                      <span class="texto_mediano_grande">Ya estas Registrado(a) si deseas hacer una modificaci&oacute;n <br>
                      Presiona click en el siguiente bot&oacute;n:<br>
                    </p>
                    <form name="form4" method="get" action="inscripcion_formal1_modificar1.php">
                      <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
                      <label>
                        <input name="button6" type="submit" class="texto_mediano_gris" id="button6" value="Modificar Informaci&oacute;n &gt;&gt;">
                      </label>
                    </form>
                    <?php } // Show if recordset not empty ?></td>
              </tr>
            </table>
            <?php } // Show if recordset not empty ?></td>
        </tr>
      </table>
  </table>
</div>

</body>
</html>
<?php
mysql_free_result($preinscripcion);

mysql_free_result($confi_preinscripcion);

mysql_free_result($alumno);

mysql_free_result($institucion);

mysql_free_result($periodo);

mysql_free_result($alumno_info);

mysql_free_result($alumno_regular);
?>
