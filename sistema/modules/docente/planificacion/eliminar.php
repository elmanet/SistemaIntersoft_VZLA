<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Eliminar</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script>
function elimino(mensaje){
document.getElementById('respuesta').innerHTML=mensaje;
}
</script>
</head>

<body>
<form method="post" action="controlEliminar.php" target="iframeUpload">
<input name="imagen" type="text" value="<?php echo $_GET['nomarchivo'];?>"/>
<input type="submit" value="Eliminar Archivo"/><br>
<iframe name="iframeUpload" style="display:none" ></iframe>
<div id="respuesta" ></div>
</form>
</body>
</html>
