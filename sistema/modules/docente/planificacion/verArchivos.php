<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>Ver Archivos</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body>
<?php
$directorio = 'data/';
$handle = opendir($directorio);
while ($file = readdir($handle)) {
if($file!= "." && $file != ".." && $file!="Thumbs.db"){
echo $file;
?>
<img src="<?php echo $directorio.$file; ?>" /><br />
<?php
}
}
?>
</body>
</html>
