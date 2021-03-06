<?php
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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
            <form action="inscripcion1_planilla.php" method="get" name="form1">
              <fieldset>
                <legend class="texto_mediano_gris"><strong>PASO - 1</strong></legend>
                <table width="700" align="center">
                  <tr valign="baseline">
                    <td align="center" valign="top" nowrap class="texto_mediano_gris"><fieldset style="background-color:#FFC">
                      <legend class="texto_pequeno_gris" >VERIFICACION DE CEDULA DEL ESTUDIANTE
                      </legend>
                      <br>
                      <br>
                      <table width="554" border="0">
                        <tr valign="baseline">
                          <td width="241" align="right" valign="middle" nowrap class="texto_mediano_gris"><div align="right"><em><strong>C&eacute;dula del Estudiante:</strong></em></div></td>
                          <td width="101" align="left" valign="top" class="textograndes_eloy"><span id="sprytextfield1">
                            <input name="cedula" type="text" class="texto_mediano_gris" id="cedula" value="" size="15" maxlength="15">
                            <br>
                            <span class="textfieldRequiredMsg"> Se necesita un valor.</span><span class="textfieldInvalidFormatMsg"><span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" alt="" width="18" height="18" align="absmiddle"></span><span class="textfieldRequiredMsg"><img src="../images/icons/exclamation.png" width="18" height="18" align="absmiddle"></span>S&oacute;lo debes agregar N&uacute;meros.</span></span></td>
                          <td width="198" align="left" valign="top" class="textograndes_eloy"><input type="submit" class="texto_mediano_gris" value="Aceptar >>"></td>
                          </tr>
                        <tr>
                          <td colspan="3" align="center"><p class="cartelera_eloy">&nbsp;</p>
                            <p class="cartelera_eloy">* SI EL ESTUDIANTE NO TIENE C&Eacute;DULA COLOCAR LA C&Eacute;DULA ESCOLAR EJM. <strong>10304589438</strong> <br>
                              EL 1 SI ES UN SOLO (SI SON GEMELOS AL OTRO LE COLOCA 2) <br>
                              EL 03 DE LOS ULTIMOS DIGITOS DEL A&Ntilde;O DE NACIMIENTO DEL ESTUDIANTE <br>
                              Y LO SIGUIENTE ES LA CEDULA DEL REPRESENTANTE SI EL NUMERO ES DE 10.000.000 HACIA ABAJO <br>
                              COLOCAR UN CERO (0) ANTES DEL NUMERO DEL REPRESENTANTE.</p></td>
                          </tr>
                        <tr>
                          <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        </table>
                      <BR>
                    </fieldset></td>
                  </tr>
                </table>
              </fieldset>
            </form>
            <hr></td>
        </tr>
      </table>
      </table>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {hint:"Ej. 13568420", validateOn:["blur"]});
//-->
</script>
</body>
</html>