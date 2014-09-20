<?php
$carpeta="data/";
$archivo=$_POST["imagen"];
$resp='';
if ((!empty($_POST["imagen"])) && (file_exists($carpeta.$archivo) == true)){
unlink($carpeta.$archivo);
$resp='El archivo se ha borrado con exito';
echo '<script>parent.elimino("'.$resp.'");</script>';
}
else{
$resp='No existe o no has escrito nada!';
echo '<script>parent.elimino("'.$resp.'");</script>';
}
?>
