<?php
$tipoDato=$_POST['d'];
if($tipoDato=='ip') echo 'Tu IP es: '.$_SERVER['REMOTE_ADDR'];
elseif($tipoDato=="time") echo 'El horario de tu servior es: '.date('G:i');
?>
