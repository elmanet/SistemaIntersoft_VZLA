
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Subida de Archivos</title>
<style type="text/css">
body { font-size:12px; font-family:verdana;color:#424242;}
</style>
<script>
function resultadoUpload(estado, file) {
var link = '<br /><br /><h2><img src="../../../images/gif/construccion-plantilla.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;&nbsp;<a href="../cargar_planificacion2.php?asignatura_id=<?php echo $_POST['asignatura_id']?>&tipo_plan=<?php echo $_POST['tipo_plan']?>&lapso=<?php echo $_POST['lapso']?>&docente_id=<?php echo $_POST['docente_id']?>&nomarchivo=' + file + '">Ir al Paso 3</h2></a><br /> <a href="eliminar.php?nomarchivo=' + file + '">Eliminar Archivo</a>';
if (estado == 0)
var mensaje = '<br />El Archivo <a href="data/' + file + '" target="_blank">' + file + '</a> se ha subido al servidor correctamente' + link;
if (estado == 1)
var mensaje = '<br />Error ! - El Archivo no llego al servdor' + link;
if (estado == 2)
var mensaje = '<br />Error ! - Solo se permiten Archivos tipo Imagen' + link;
if (estado == 3)
var mensaje = '<br />Error ! - No se pudo copiar Archivo. Posible problema de permisos en server' + link;
document.getElementById('formUpload').innerHTML=mensaje;
}
</script>
</head>
<center>
<body>
<h2>Paso 2. Seleccione el Archivo de la Planificaci&oacute;n</h2>
<form method="post" enctype="multipart/form-data"
action="controlUpload3.php"
target="iframeUpload">
<input type="hidden" name="phpMyAdmin" />
Archivo: <input name="fileUpload" type="file" onchange="submit()"/>
<input type="hidden" name="asignatura_id" value="<?php echo $_POST['asignatura_id']?>"/>
<input type="hidden" name="tipo_plan" value="<?php echo $_POST['tipo_plan']?>"/>
<input type="hidden" name="lapso" value="<?php echo $_POST['lapso']?>"/>
<input type="hidden" name="docente_id" value="<?php echo $_POST['docente_id']?>"/>
<br />

<iframe name="iframeUpload" style="display:none" ></iframe>
<div id="formUpload"> </div>

<div style="font-size:13px; color:red; width:400px; font-family:verdana; background-color:#fffccc; border:1px solid; margin-top: 10px; align-text:center;">
<center><img src="../../../images/pngnew/foro-de-charla-sobre-el-usuario-icono-5354-128.png" border="0" align="absmiddle" height="40"></center>
<p align="center" style="font-size:14px">"El nombre del Archivo que vas a subir<br /> no debe poseer <b style="font-size:20px">&ntilde;</b> ni acentos!" <br /><br /><span style="font-size:16px"><b>Debes esperar mientras se carga el Archivo</b></span></p>
</div>
</div>
</form>
</body>
</center>
</html>
