<?php
// Script Que copia el archivo temporal subido al servidor en un directorio.
$tipo = substr($_FILES['fileUpload']['type'], 0, 5);
// Definimos Directorio donde se guarda el archivo
$dir = 'data/';
$separa = '_';
$valor = $_POST['asignatura_id'].$_POST['tipo_plan'].$_POST['lapso'].$_POST['docente_id'];
// Intentamos Subir Archivo
// (1) Comprovamos que existe el nombre temporal del archivo
if (isset($_FILES['fileUpload']['tmp_name'])) {
// (2) - Comprovamos que se trata de un archivo de imágen

// (3) Por ultimo se intenta copiar el archivo al servidor.
if (!copy($_FILES['fileUpload']['tmp_name'], $dir.$valor.$separa.$_FILES['fileUpload']['name']))
echo '<script>parent.resultadoUpload(1, "'.$valor.$separa.$_FILES['fileUpload']['name'].'");</script> ';

else{
echo '<script>parent.resultadoUpload(0, "'.$valor.$separa.$_FILES['fileUpload']['name'].'");</script> ';
}
}

else{
echo '<script>parent.resultadoUpload(3, "'.$valor.$separa.$_FILES['fileUpload']['name'].'");</script> ';
}
?>
