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
 <script language='javascript' src="popcalendar.js"></script>
 <script type="text/javascript" src="captcha.js"></script>
 

 
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
 
 <script type="text/javascript" >
	$(document).ready(function(){
$('#ced_alumno').focusout( function(){
    if($('#ced_alumno').val()!= ""){
        $.ajax({
            type: "POST",
            url: "valida.php",
            data: "ced_alumno="+$('#ced_alumno').val(),
            beforeSend: function(){
              $('#msgUsuario').html('<img src="loader.gif"/> verificando');
            },
            success: function( respuesta ){
              if(respuesta == '1')
                $('#msgUsuario').html("");
         			
                
              else
                $('#msgUsuario').html("<div class='texto_mediano_gris' style='color:red; font-size:20px;'> * * Estudiante No Autorizado * * </div>");

	
       			
            }
        });
    }
});
});

function checkSubmit() {
    document.getElementById("btsubmit").value = "Enviando...";
    document.getElementById("btsubmit").disabled = true;
    return true;
}

</script>

</head>
<center>
<body>

<!-- INICIO DEL CONTENEDOR PRINCIPAL -->

<div id="div_acceso">
	
  

 <form action="autorizar_inscripcion2.php" id="captchaform" onsubmit="return checkSubmit();" method="POST" enctype="multipart/form-data" target="_self" class="cmxform" >
 		<table>
 		<tr>
		<td colspan="2">
				<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-size:12px;">
				<h1> <img src="../../images/pngnew/agregar-usuarios-icono-3782-48.png" alt="" align="middle" >Autorizaci&oacute;n Realizada con Exito!</h1>				
			<center>	Debes ingresar el No. de c&eacute;dula del estudiante sin puntos ni letras,  
				si este no posee ingresar el No. de c&eacute;dula escolar ej. 19816128654, este No. sale de: el 1 si es un estudiante el 98 
				del a&ntilde;o de nacimiento del estudiante y el 16128654 el No. de c&eacute;dula del representante </center></div><br />		
		</td> 		
 		</tr>
		<tr>
			<td align="right"><label> C&eacute;dula: </label></td>
			<td>

			<input class="text_input_peq" style="width:180px;" type="text" id="ced_alumno" name="ced_alumno" onKeyUp="this.value=this.value.toUpperCase()"/>&nbsp;&nbsp;<input type="submit" name="submit" id="btsubmit" value="Verificar Cuenta" class="texto_grande_gris"  /><div style="color:red; font-weight: bold; font-size:25px;" id="msgUsuario"></div></td>
						
	
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
