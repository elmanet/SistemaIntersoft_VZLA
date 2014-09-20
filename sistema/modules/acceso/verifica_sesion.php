<?php
$fechaOld= $_SESSION["ultimoAcceso"];
$ahora = date("Y-n-j H:i:s");
$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaOld));
if($tiempo_transcurrido>= 1) { //comparamos el tiempo y verificamos si pasaron 20 minutos o más
	session_destroy(); // destruimos la sesión
 	header("Location: acceso.php"); //enviamos al usuario a la página principal
}else {       //sino, actualizo la fecha de la sesión
	$_SESSION["ultimoAcceso"] = $ahora;
} ?>


