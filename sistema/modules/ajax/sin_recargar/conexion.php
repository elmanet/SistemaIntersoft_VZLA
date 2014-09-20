<?php
function conectar()
{
	mysql_connect("localhost", "root", "ve16123617");
	mysql_select_db("sistemacol");
}

function desconectar()
{
	mysql_close();
}
?>
