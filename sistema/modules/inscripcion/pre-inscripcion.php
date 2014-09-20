<?php require_once('../inc/conexion_sinsesion.inc.php');

// Make the page validate
//ini_set('session.use_trans_sid', '0');

// Include the random string file
require 'rand.php';

// Begin the session
session_start();

// Set the session contents
$_SESSION['captcha_id'] = $str;

// CONSULTA SQL
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_institucion";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

// SQL PARA REGISTRO DE DATOS

  

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "captchaform")) {
  $insertSQL = sprintf("INSERT INTO jos_alumno_preinscripcion (id, nom_alumno, ape_alumno, indicador_nacionalidad, ced_alumno, dir_alumno, tel_alumno, fecha_nacimiento, edad, grado_cursar, porque_retira, comportamiento, quien_vives, ingreso_familiar, recomendado, pago_mensualidad) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['nom_alumno'], "text"),
					   GetSQLValueString($_POST['ape_alumno'], "text"),
					   GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
					   GetSQLValueString($_POST['ced_alumno'], "biginit"),
							  GetSQLValueString($_POST['dir_alumno'], "text"),
					   GetSQLValueString($_POST['tel_alumno'], "text"),
					   GetSQLValueString($_POST['fecha_nacimiento'], "date"),
					   GetSQLValueString($_POST['edad'], "int"),					   
					   GetSQLValueString($_POST['grado_cursar'], "text"),
					   GetSQLValueString($_POST['porque_retira'], "text"),
					   GetSQLValueString($_POST['comportamiento'], "text"),
					   GetSQLValueString($_POST['quien_vives'], "text"),
					   GetSQLValueString($_POST['ingreso_familiar'], "text"),
					   GetSQLValueString($_POST['recomendado'], "text"),
					   GetSQLValueString($_POST['pago_mensualidad'], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	$insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
				$('#msgUsuario').html("<div class='texto_mediano_gris' style='color:red; font-size:20px;'> * * Estudiante Ya Registrado * * </div>");
	   
			}
		});
	}
});
});

</script>

</head>
<center>
<body>
<div id="contenedor_menu_top">
<div style="float: left;padding-left:200px;">
	<div style="float: left;">
		<img src="../../images/<?php echo $row_users['logocol'];?> " height="40" alt="" align="middle">
	</div>
	<div style="float: left;padding-left:5px;">
		<span class="texto_pequeno_gris" style="color:#fff;"><?php echo $row_users['nomcol'];?></span><br />
		<span class="texto_pequeno_gris" style="color:#fff;">Sistema Automatizado Educativo</span>
	</div>
</div>
</div>
<!-- INICIO DEL CONTENEDOR PRINCIPAL -->
<br />
<br />
<h2 style="font-family:verdana; text-shadow: black 0em 0.1em 0.1em ">Formulario de Pre-Inscripci&oacute;n</h2>
<div id="div_acceso">
	
  

 <form action="<?php echo $editFormAction; ?>" id="captchaform" method="POST" enctype="multipart/form-data" target="_self" class="cmxform" >
 		<table>
 		<tr>
		<td colspan="2">
				<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-size:12px;text-align:justify;">
				<h1>Nota Importante:</h1>				
				Debes ingresar el n&uacute;mero  de c&eacute;dula del estudiante sin puntos ni letras.  
				Si no la posee ingresa el n&uacute;mero  de c&eacute;dula escolar. Ejm. 19816128654, este n&uacute;mero se obtiene de la siguiente manera: el "1" si el estudiante es s&oacute;lo en un parto (de ser morochos "1" para uno de los estudiantes y "2" para el otro); el 98 
				corresponde al a&ntilde;o de nacimiento y el 16128654 es el n&uacute;mero de c&eacute;dula del representante. Si el n&uacute;mero de c&eacute;dula del representante tiene 7 d&iacute;gitos se agrega un "0" (CERO) despu&ecaute;s del a&ntilde;o de nacimiento. Lo importante es que la c&eacute;dula escolar este compuesta por 11 d&iacute;gitos.  </div><br />		
		</td> 		
 		</tr>
		<tr>
			<td align="right"><label> C&eacute;dula: </label></td>
			<td>
			<select class="text_input_peq" name="indicador_nacionalidad" style="width:50px; border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px;">
   		  <option value="V">V</option>
  			  <option value="E">E</option>
			</select> -
			<input class="text_input_peq" style="width:180px;" type="text" id="ced_alumno" name="ced_alumno" onKeyUp="this.value=this.value.toUpperCase()"/><div style="color:red; font-weight: bold; font-size:25px;" id="msgUsuario"></div></td>
							
		</tr>
		<tr>
			<td align="right"><label> Nombre: </label></td>
			<td><input class="text_input_peq" type="text" id="nom_alumno" name="nom_alumno" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
				<tr>
			<td align="right"><label> Apellido: </label></td>
			<td><input class="text_input_peq" type="text" id="ape_alumno" name="ape_alumno" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n: </label></td>
			<td><textarea class="text_tarea" id="nombre2"  name="dir_alumno" onKeyUp="this.value=this.value.toUpperCase()" ></textarea>  </td>
							
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono: </label></td>
			<td><input class="text_input_peq" type="text" id="tel_alumno" name="tel_alumno" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<tr>
			<td align="right"><label> Fecha de Nacimiento: </label></td>
			<td><div style="color:blue; font-size:10px;">Presiona click en el campo para la Fecha</div>
			<input name="fecha_nacimiento" class="text_input_peq" style="width:120px;" type="text" id="dateArrival" onClick="popUpCalendar(this, captchaform.dateArrival, 'yyyy/mm/dd');" size="10" readonly="readonly"></td>
							
		</tr>
		<tr>
			<td align="right"><label> Edad: </label></td>
			<td><input class="text_input_peq" maxlength="2" type="text" style="width:80px;" id="edad" name="edad" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<tr>
			<td align="right"><label> Grado a Cursar: </label></td>
			<td><input class="text_input_peq" style="width:120px;" type="text" id="grado_cursar" name="grado_cursar" onKeyUp="this.value=this.value.toUpperCase()"/> Ej. 1ER A&Ntilde;O</td>
							
		</tr>
		<tr>
			<td align="right"><label> Por qu&eacute; se retir&oacute; del otro Plantel: </label></td>
			<td><input class="text_input_peq" type="text" id="porque_retira" name="porque_retira" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<tr>
			<td align="right"><label> Como es t&uacute; Comportamiento: </label></td>
			<td><input class="text_input_peq" type="text" id="comportamiento" name="comportamiento" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<tr>
			<td align="right"><label> Con quien Vives: </label></td>
			<td><input class="text_input_peq" type="text" id="quien_vives" name="quien_vives" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<tr>
			<td align="right"><label> Ingreso Familiar Promedio: </label></td>
			<td><input class="text_input_peq" style="width:80px;" maxlength="6" type="text" id="ingreso_familiar" name="ingreso_familiar" onKeyUp="this.value=this.value.toUpperCase()"/> Ej. 2500</td>
							
		</tr>
		<tr>
			<td align="right"><label> Quien le Recomendo la Instituci&oacute;n: </label></td>
			<td><input class="text_input_peq" type="text" id="recomendado" name="recomendado" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<tr>
			<td align="right"><label> Quien pagar&aacute; la Mensualidad: </label></td>
			<td><input class="text_input_peq" type="text" id="pago_mensualidad" name="pago_mensualidad" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
		</tr>
		<!-- <tr>
			<td align="right"><div id="captchaimage" style="border:1px solid; width:135px;"><img src="images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image" /></td>
			<td><div style="color:blue; font-size:10px;">Ingresa los caracteres de la imagen</div>
			<input type="text" maxlength="6" size="15" name="captcha" id="captcha" class="text_input_peq"/></td>
							
		</tr> -->
		<tr>
		<td colspan="2" align="center"><input  type="checkbox" name="check" value=""  /> Estoy de acuerdo que hasta que no formalice la inscripci&oacute;n en la Instituci&oacute;n esta planilla ni tiene VALIDEZ  </td>
		</tr>
		<tr>
	
		<td colspan="2" align="center"><input type="submit" name="submit" value="Procesar Pre-Inscripci&oacute;n" class="texto_grande_gris"  /></td>
		</tr>
 		</table>
	
	  <input type="hidden" name="id" id="id">
	 <input type="hidden" name="MM_insert" value="captchaform">	
</form>  
  <br />
  <br />
  <br />

 </div>
<?php require_once('../inc/barra_publicidad.inc.php'); ?>	
</body>

</center>
</html>
