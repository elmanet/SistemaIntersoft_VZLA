<?php
include 'conexion.php';
conectar();

$consulta=mysql_query("SELECT nombre FROM jos_alumno_info");

desconectar();

// Capturo los valores de la DB para mostrarlos apenas se carga la pagina
$campo1= mysql_fetch_row($consulta);
$campo2= mysql_fetch_row($consulta);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<!-- 



Este contenido es de libre uso y modificaci�n bajo la siguiente licencia: http://creativecommons.org/licenses/by-nc-sa/2.5/deed.es

Sobre el reconocimiento:
Todos los c�digos han sido realizados con la idea de que sirvan para colaborar con el aprendizage de aquellos que se est�n introduciendo
en estas tecnolog�as y no con el objetivo de que sean utilizados directamente en sitios web. No obstante si utilizas alg�n c�digo en tu sitio 
(ya sea sin modificar o modificado), o si ofreces los fuentes para descargar o si bien decides publicar alguno de los art�culos debes cumplir con:
-Colocar un link a http://www.formatoweb.com.ar/ajax/ visible por tus usuarios como forma de menci�n a la fuente original del contenido.
-Enviar un correo a edanps@gmail.com informando la URL donde el contenido se ha publicado o se va a publicar en un futuro.
-Si publicas los fuentes para descargar este texto no debe ser eliminado ni alterado.

M�s ejemplos y material sobre AJAX en: http://www.formatoweb.com.ar/ajax/
Cualquier sugerencia, cr�tica o comentario son bienvenidos.
Contacto: edanps@gmail.com



-->

<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>AJAX, Ejemplos: Ingreso a base de datos, codigo fuente - ejemplo</title>
<link rel="stylesheet" type="text/css" href="ingreso_sin_recargar.css">
<script type="text/javascript" src="ingreso_sin_recargar.js"></script>
</head>

<body>
			
			<div id="demo" style="width:600px;">
				<div id="demoArr" onclick="creaInput(this.id, '4')"><?=$campo1[0]; ?></div>
				<div id="demoAba" onclick="creaInput(this.id, '2')"><?=$campo2[0]; ?></div>
				<div class="mensaje" id="error"></div>
			</div>
			
</body>
</html>
