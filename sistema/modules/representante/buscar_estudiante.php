<?php require_once('../inc/conexion_sinsesion.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

<script type="text/javascript" >
$(document).ready(function(){

$('#boton').click(function(e){
	
	if(($('#cedre').val()=='') || (isNaN($('#cedre').val())==true)) {	
		e.preventDefault();	
		alert('Verifique el No. de la Cedula!');	
		}
	});
		
	});
</script>


</head>
<center>
<body>

  </div>
<div class="marco_vista">
	<div class="icono"><img src="../../images/pngnew/humanos-de-usuario-icono-7364-96.png" width="40" height="40" /></div>
	<div class="container">
		<h1>C&eacute;dula del Representante:</h1>
		<form  action="buscar_estudiante2.php" name="form" id="form" method="POST" enctype="multipart/form-data">
			<input type="text" id="cedre" name="ced_representante" size="15" value=""/><br /><br />
			<input type="submit" id="boton" name="buttom" value="Buscar >" />	
		</form>	
	</div>
	

	
	<div class="footer">Sistema Intersoft &reg; <?php echo date(Y);?></div>
	
</div>



</body>
</center>
</html>