<?php require_once('../inc/conexion.inc.php');


// CONSULTA SQL
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_institucion";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; utf-8" />

<title>INTERSOFT | Software Educativo</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css">
<link href="../../css/fondo.css" rel="stylesheet" type="text/css">
<link href="../../css/input.css" rel="stylesheet" type="text/css">
<link href="../../css/marca.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../../images/favicon.ico">
<?php require_once('../inc/validate.inc.php'); ?>
 <script language='javascript' src="../valida/popcalendar.js"></script>
 <script type="text/javascript" src="../valida/captcha.js"></script>
 

 
 <style type="text/css">

  p#statusgreen { font-size: 1.2em; background-color: #fff; color: #0a0; }
  p#statusred { font-size: 1.2em; background-color: #fff; color: #a00; }
  fieldset label { display: block; }
  fieldset div#captchaimage { float: left; margin-right: 15px; }
  fieldset input#captcha { width: 25%; border: 1px solid #ddd; padding: 2px; }
  fieldset input#submit { display: block; margin: 2% 0% 0% 0%; }
  #captcha.success {
  	border: 1px solid #49c24f;
	background: #bcffbf;
  }
  #captcha.error {
  	border: 1px solid #c24949;
	background: #ffbcbc;
  }
 </style>

</head>
<center>
<body>

<!-- INICIO DEL CONTENEDOR PRINCIPAL -->

<div id="div_acceso">
	
  

 <form action="imprimir_titulo.php" id="captchaform" onsubmit="return checkSubmit();" method="POST" enctype="multipart/form-data" class="cmxform" target="_blank" >
 		<table>
 		<tr>
			<td colspan="2"><span style="font-size:28px;font-weight: bold;">M&oacute;dulo de Impresi&oacute;n de T&iacute;tulos</span><br>
			<span style="color:red;font-weight: bold;">Deseas cambiar los m&aacute;rgenes del t&iacute;tulo?  <a href="imprimir_margen_titulo.php" target="_blank">Click AQUI</a></span><br><br></td> 		
 		</tr>
 		<!--<tr>
		<td colspan="2">
				<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-size:12px;">
				<h1> <img src="../../images/pngnew/agregar-usuarios-icono-3782-48.png" alt="" align="middle" >Autorizar Inscripci&oacute;n</h1>				
			<center>	Debes ingresar el No. de c&eacute;dula del estudiante sin puntos ni letras,  
				si este no posee ingresar el No. de c&eacute;dula escolar ej. 19816128654, este No. sale de: el 1 si es un estudiante el 98 
				del a&ntilde;o de nacimiento del estudiante y el 16128654 el No. de c&eacute;dula del representante </center></div><br />		
		</td> 		
 		</tr>-->
		<tr>
			<td align="right"><label> C&eacute;dula del Estudiante: </label></td>
			<td>

			<input class="text_input_peq" style="width:180px;" type="text" id="ced_alumno" name="ced_alumno" onKeyUp="this.value=this.value.toUpperCase()"/></td>
						
		</tr>
		 <tr>
			<td align="right"><label> T&iacute;tulo de: </label></td>
			<td><input class="text_input_peq" style="width:280px;" type="text" id="titulo" name="titulo" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
				
     <tr>
			<td align="right"><label> C&oacute;digo Plan: </label></td>
			<td><input class="text_input_peq" style="width:80px;" type="text" id="plan" name="plan" ></td>	
		</tr>
 	<tr>
			<td align="right"><label>Lugar lleva Estado? </label></td>
			<td>SI <input type="radio" name="estado" value="1"> NO <input type="radio" name="estado" value="2"></td>	
		</tr>

		
	 <tr>
			<td align="right"><label> Lugar y fecha de expedici&oacute;n </label></td>
			<td><input class="text_input_peq" style="width:280px;" type="text" id="fechaex" name="fechaex" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>

  	 <tr>
			<td align="right"><label> A&ntilde;o de Egreso: </label></td>
			<td><input class="text_input_peq" style="width:80px;" type="text" id="egreso" name="egreso" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
		
		 <tr>
			<td align="right"><label> Nombre Director de Zona: </label></td>
			<td><input class="text_input_peq" style="width:280px;" type="text" id="nombredz" name="nombredz" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
		 <tr>
			<td align="right"><label> C&eacute;dula Director de Zona: </label></td>
			<td><input class="text_input_peq" style="width:180px;" type="text" id="ceduladz" name="ceduladz" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
			
		 <tr>
			<td align="right"><label> Nombre Coordinador: </label></td>
			<td><input class="text_input_peq" style="width:280px;" type="text" id="nombrece" name="nombrece" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
		
		<tr>
			<td align="right"><label> C&eacute;dula Coordinador: </label></td>
			<td><input class="text_input_peq" style="width:180px;" type="text" id="cedulace" name="cedulace" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
		 <tr>
			<td align="right"><label> Nombre funcionario Zona: </label></td>
			<td><input class="text_input_peq" style="width:280px;" type="text" id="funcionario" name="funcionario" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
		<tr>
			<td align="right"><label> C&eacute;dula funcionario Zona: </label></td>
			<td><input class="text_input_peq" style="width:180px;" type="text" id="cedulaf" name="cedulaf" onKeyUp="this.value=this.value.toUpperCase()"/></td>	
		</tr>
		
		
		
		 <tr>
		 	<td>&nbsp;</td>
			<td ><input type="submit" name="submit" id="btsubmit" value="Ver Titulo" class="texto_grande_gris"  /></td>	
		</tr>
		
		
	
		<tr>
			
		<td colspan="2" align="center"><br /><small>Sistema Intersoft | Software Educativo &copy; <?php echo date('Y');?></small></td>
		</tr>

 		</table>
    

	
</form>  
  <br />
  <br />
  <br />

 </div>
	
</body>

</center>
</html>
