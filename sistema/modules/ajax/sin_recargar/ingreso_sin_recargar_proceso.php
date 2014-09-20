<?php
function validaValor($cadena)
{
	// Funcion utilizada para validar el dato a ingresar recibido por GET	
	if(eregi('^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$', $cadena)) return TRUE;
	else return FALSE;
}

$valor=trim($_GET['dato']); $campo=trim($_GET['actualizar']);

if(validaValor($valor) && validaValor($campo))
{
	// Si los campos son validos, se procede a actualizar los valores en la DB
	include 'conexion.php';
	conectar();

	// Actualizo el campo recibido por GET con la informacion que tambien hemos recibido
	mysql_query("UPDATE jos_alumno_info SET nombre='$valor' WHERE alumno_id='$campo'") or die(mysql_error());
	desconectar();
}
// No retorno ninguna respuesta
?>
