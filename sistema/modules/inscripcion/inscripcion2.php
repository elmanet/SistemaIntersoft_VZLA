<?php
require_once('../inc/conexion_sinsesion.inc.php');
// CONSULTA SQL
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_institucion";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>INTERSOFT | Software Educativo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css">
<link href="../../css/fondo.css" rel="stylesheet" type="text/css">
<link href="../../css/input.css" rel="stylesheet" type="text/css">
<link href="../../css/marca.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../../images/favicon.ico">
</head>
<center>
<body>
<div id="contenedor_menu_top">
<div style="float: left;padding-left:200px;">
	<div style="float: left;">
		<img src="../../images/<?php echo $row_users['logocol'];?> " height="40" alt="" align="middle">
	</div>
	<div style="float: left;padding-left:5px;">
		<span class="texto_pequeno_gris" style="color:#fff;"><?php echo $row_users['nomcol'];?></span><br />
		<span class="texto_pequeno_gris" style="color:#fff;">Sistema Automatizado Educativo</span>
	</div>
</div>
</div>
<br />
<br />
<br />
<div id="div_acceso">
  <table border="0" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td width="100%"><table width="716" border="0" align="center">
        <tr>
          <td width="738"><div align="center" class="titulosgrandes_eloy"><img src="../../images/png/atencion.png" width="80" height="72"><br>
            <br>
          </div></td>
        </tr>
        <tr>
          <td><div align="center"><h1 style="font-family:verdana; color:#19582E; text-shadow: black 0em 0.1em 0.1em ">REGISTRO EXITOSO! </h1></div></td>
        </tr>
        <tr>
          <td><br></td>
        </tr>
        <tr>
          <td><div align="center" class="texto_mediano_gris">Para imprimir la planilla de la entrevista introduce el numero de c&eacute;dula que ingresaste en el registro: <br>
            <span class="titulosmedianos_eloy"><span class="titulo_extramediano_gris">Ejm. 23540720 sin puntos ni espacios </span></span> <br>
          </div></td>
        </tr>
        <tr>
          <td><form action="inscripcion3.php" method="get" name="form1" target="_blank">
            <div align="center">
              <input name="cedula" type="text" class="text_input" style="width:150px;" id="cedula">
              <input name="Submit" type="submit" class="texto_grande_gris" value="descargar planilla >>">
              <br>
              <a href="inscripcion.php"><br>
              </a></div>
          </form></td>
        </tr>
      </table>
        <p align="center"><span class="texto_mediano_gris">___________________________________________________________<br>
          <br>
            Dpto. Inform&aacute;tica - Coordinaci&oacute;n de Inform&aacute;tica</span><span class="textomediano_eloy"><span class="textograndes_eloy"><br>
          </span></span></p>
      <tr>
        <td></td>
      </table>
</div>
<?php require_once('../inc/barra_publicidad.inc.php'); ?>
</body>
</center>
</html>