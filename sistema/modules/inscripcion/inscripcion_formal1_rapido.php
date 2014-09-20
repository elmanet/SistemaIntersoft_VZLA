<?php require_once('../inc/conexion_sinsesion.inc.php');

// Make the page validate
//ini_set('session.use_trans_sid', '0');

// Include the random string file
require 'rand.php';

// Begin the session
session_start();

// Set the session contents
$_SESSION['captcha_id'] = $str;

// NUEVA INSCRIPCION ESTUDIANTE REGULAR

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "captchaform")) {

   $updateSQL = sprintf("UPDATE jos_alumno_info SET nombre=%s, apellido=%s, indicador_nacionalidad=%s, nombre_representante=%s, apellido_representante=%s, cedula_representante=%s, status=%s, anio_id=%s, cedula=%s  WHERE alumno_id=%s",

			GetSQLValueString($_POST['nombre'], "text"),
					   GetSQLValueString($_POST['apellido'], "text"),
					   GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
					   GetSQLValueString($_POST['nombre_representante'], "text"),
					   GetSQLValueString($_POST['apellido_representante'], "text"),
					   GetSQLValueString($_POST['cedula_representante'], "int"),
					   GetSQLValueString($_POST['status'], "int"),
					   GetSQLValueString($_POST['anio_id'], "int"),
					   GetSQLValueString($_POST['cedula'], "bigint"),
					   GetSQLValueString($_POST['alumno_id'], "bigint"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "inscripcion_formal2_rapido.php";
  if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
}
 header(sprintf("Location: %s", $updateGoTo));
}



// SQL PARA REGISTRO DE DATOS

  

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "captchaform")) {
 $insertSQL = sprintf("INSERT INTO jos_alumno_info (alumno_id, nombre, apellido, indicador_nacionalidad, nombre_representante, apellido_representante, cedula_representante, status, anio_id, cedula) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
							  
							  GetSQLValueString($_POST['alumno_id'], "int"),
						  	  GetSQLValueString($_POST['nombre'], "text"),
					   GetSQLValueString($_POST['apellido'], "text"),
					   GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
					   GetSQLValueString($_POST['nombre_representante'], "text"),
					   GetSQLValueString($_POST['apellido_representante'], "text"),
					   GetSQLValueString($_POST['cedula_representante'], "int"),
					   GetSQLValueString($_POST['status'], "int"),
					   GetSQLValueString($_POST['anio_id'], "int"),
					   GetSQLValueString($_POST['cedula'], "bigint"));
					   
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion_formal2_rapido.php";
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

mysql_select_db($database_sistemacol, $sistemacol);
$query_anio = "SELECT * FROM jos_anio_nombre ORDER BY numero_anio ASC";
$anio = mysql_query($query_anio, $sistemacol) or die(mysql_error());
$row_anio = mysql_fetch_assoc($anio);
$totalRows_anio = mysql_num_rows($anio);

$colname_alumnor = "-1";
if (isset($_POST['ced_alumno'])) {
  $colname_alumnor = $_POST['ced_alumno'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumnor = sprintf("SELECT * FROM jos_alumno_info WHERE cedula=%s", GetSQLValueString($colname_alumnor, "bigint"));
$alumnor = mysql_query($query_alumnor, $sistemacol) or die(mysql_error());
$row_alumnor = mysql_fetch_assoc($alumnor);
$totalRows_alumnor = mysql_num_rows($alumnor);

$colname_alumnopre = "-1";
if (isset($_POST['ced_alumno'])) {
  $colname_alumnopre = $_POST['ced_alumno'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumnopre = sprintf("SELECT * FROM jos_alumno_preinscripcion WHERE aceptado=1 AND ced_alumno=%s", GetSQLValueString($colname_alumnopre, "bigint"));
$alumnopre = mysql_query($query_alumnopre, $sistemacol) or die(mysql_error());
$row_alumnopre = mysql_fetch_assoc($alumnopre);
$totalRows_alumnopre = mysql_num_rows($alumnopre);

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
<h2 style="font-family:verdana; text-shadow: black 0em 0.1em 0.1em ">Formulario de Inscripci&oacute;n R&aacute;pida (paso 2)</h2>
<div id="div_acceso">
	
  

<!-- FORMULARIO PARA LOS ALUMNOS REGULARES -->
<?php if($totalRows_alumnor>0){ ?>
 <form action="<?php echo $editFormAction; ?>"  id="captchaform" method="POST" enctype="multipart/form-data" target="_self" class="cmxform" >

 		<table>


 		<tr>
		<td colspan="2">
				<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-size:12px;">
				<h1><img src="../../images/png/atencion.png" alt="" align="middle" width="80">Nota Importante:</h1>				
				Los estudiantes regulares s&oacute;lo podr&aacute;n modificar no. de tel&eacute;fono, direcciones o alg&uacute;n dato que les falte </div><br />		
		</td> 		
 		</tr>
 		</table>
 		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos personales del Estudiante</legend>
		<table>
		<tr>
			<td align="right"><label> C&eacute;dula: </label></td>
			<td>
			<select class="text_input_peq" name="indicador_nacionalidad" style="width:50px; border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px;">
   		  <option value="V">V</option>
  			  <option value="E">E</option>
			</select> -
			<?php if($row_alumnor['cedula']==NULL){?>						
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula" name="cedula" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula" name="cedula" value="<?php echo $row_alumnor['cedula'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>
		<tr>
			<td align="right"><label> Nombre: </label></td>
			<td>
			<?php if($row_alumnor['nombre']==NULL){?>						
			<input class="text_input_peq" type="text" id="nombre" name="nombre" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="nombre" name="nombre" value="<?php echo $row_alumnor['nombre'];?>" readonly="readonly"/></td>
			<?php }?>				
		</tr>
		<tr>
			<td align="right"><label> Apellido: </label></td>
			<td>
			<?php if($row_alumnor['apellido']==NULL){?>						
			<input class="text_input_peq" type="text" id="apellido" name="apellido" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="apellido" name="apellido" value="<?php echo $row_alumnor['apellido'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>

<tr>
			<td align="right"><label> C&eacute;dula del Representante: </label></td>
			<td>
			
			<?php if($row_alumnor['cedula_representante']==NULL){?>						
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_representante" name="cedula_representante" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_representante" name="cedula_representante" value="<?php echo $row_alumnor['cedula_representante'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Representante: </label></td>
			<td>
			<?php if($row_alumnor['nombre_representante']==NULL){?>						
			<input class="text_input_peq" type="text" id="nombre_representante" name="nombre_representante" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="nombre_representante" name="nombre_representante" value="<?php echo $row_alumnor['nombre_representante'];?>" readonly="readonly"/></td>
			<?php }?>				
		</tr>
		<tr>
			<td align="right"><label> Apellido del Representante: </label></td>
			<td>
			<?php if($row_alumnor['apellido_representante']==NULL){?>						
			<input class="text_input_peq" type="text" id="apellido_representante" name="apellido_representante" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="apellido_representante" name="apellido_representante" value="<?php echo $row_alumnor['apellido_representante'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>
			
	
		</table>
		</fieldset>	
		
<!-- validacion y capcha -->
<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Validaci&oacute;n de Datos</legend>
		<table>
		<tr>
			<td align="right"><label> A&ntilde;o a Cursar: </label></td>
			<td>
			<select class="text_input_peq" name="anio_id" class="texto_mediano_gris" id="anio_id">
		 <option value="">..Selecciona</option>
		   <?php do { ?>
		   <option value="<?php echo $row_anio['id']; ?>"><?php echo $row_anio['nombre']; ?></option>
		   <?php } while ($row_anio = mysql_fetch_assoc($anio));
  	   $rows = mysql_num_rows($anio);
  	   if($rows > 0) {
		   mysql_data_seek($anio, 0);
	  $row_anio = mysql_fetch_assoc($anio);
		 }
	   ?>
		 </select>			
			</td>
					
		</tr>
		


		<tr>
		<td colspan="2" align="center"><input  type="checkbox" name="check" value=""  /> Estoy de acuerdo con las <b>NORMAS DE CONVIVENCIA</b> de la Instituci&oacute;n </td>
		</tr>
		<tr>
	
		<td colspan="2" align="center"><input type="submit" name="submit"  value="Procesar Inscripci&oacute;n" class="texto_grande_gris"  /></td>
		</tr>
 		</table>
 		</fieldset>
	
	  <input type="hidden" name="alumno_id" id="alumno_id" value="<?php echo $row_alumnor['alumno_id'];?>">
	  <input type="hidden" name="status" id="status" value="0">
	 <input type="hidden" name="MM_update" value="captchaform">	
</form>  
<?php } ?>
<!-- FIN DE ALUMNOS REGULARES -->


<!-- FORMULARIO PARA LOS ALUMNOS NUEVO INGRESO -->
<?php if(($totalRows_alumnor==0)){ ?>
 <form action="<?php echo $editFormAction; ?>"  id="captchaform" method="POST" enctype="multipart/form-data" target="_self" class="cmxform" >

 		<table>


 		<tr>
		<td colspan="2">
				<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-size:12px;">
				<h1><img src="../../images/png/atencion.png" alt="" align="middle" width="80">Nota Importante:</h1>				
				Los estudiantes regulares s&oacute;lo podr&aacute;n modificar no. de tel&eacute;fono, direcciones o alg&uacute;n dato que les falte </div><br />		
		</td> 		
 		</tr>
 		</table>
 		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos personales del Estudiante</legend>
		<table>
		<tr>
			<td align="right"><label> C&eacute;dula: </label></td>
			<td>
			<select class="text_input_peq" name="indicador_nacionalidad" style="width:50px; border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px;">
   		  <option value="V">V</option>
  			  <option value="E">E</option>
			</select> -
			<?php if($row_alumnopre['ced_alumno']==NULL){?>						
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula" name="cedula" value="<?php echo $_POST['ced_alumno'];?>" readonly="readonly" /></td>
			<?php }else {?>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula" name="cedula" value="<?php echo $_POST['ced_alumno'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>
		<tr>
			<td align="right"><label> Nombre: </label></td>
			<td>
			<?php if($row_alumnopre['nom_alumno']==NULL){?>						
			<input class="text_input_peq" type="text" id="nombre" name="nombre" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="nombre" name="nombre" value="<?php echo $row_alumnopre['nom_alumno'];?>" readonly="readonly"/></td>
			<?php }?>				
		</tr>
		<tr>
			<td align="right"><label> Apellido: </label></td>
			<td>
			<?php if($row_alumnopre['ape_alumno']==NULL){?>						
			<input class="text_input_peq" type="text" id="apellido" name="apellido" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="apellido" name="apellido" value="<?php echo $row_alumnopre['ape_alumno'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>
			
		
	
		</table>
		</fieldset>	
		
<!-- validacion y capcha -->
<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Validaci&oacute;n de Datos</legend>
		<table>
		<tr>
			<td align="right"><label> A&ntilde;o a Cursar: </label></td>
			<td>
			<select class="text_input_peq" name="anio_id" class="texto_mediano_gris" id="anio_id">
		 <option value="">..Selecciona</option>
		   <?php do { ?>
		   <option value="<?php echo $row_anio['id']; ?>"><?php echo $row_anio['nombre']; ?></option>
		   <?php } while ($row_anio = mysql_fetch_assoc($anio));
  	   $rows = mysql_num_rows($anio);
  	   if($rows > 0) {
		   mysql_data_seek($anio, 0);
	  $row_anio = mysql_fetch_assoc($anio);
		 }
	   ?>
		 </select>			
			</td>
					
		</tr>
		
		<tr>
		<td colspan="2" align="center"><input  type="checkbox" name="check" value=""  /> Estoy de acuerdo con las <b>NORMAS DE CONVIVENCIA</b> de la Instituci&oacute;n </td>
		</tr>
		<tr>
	
		<td colspan="2" align="center"><input type="submit" name="submit"  value="Procesar Inscripci&oacute;n" class="texto_grande_gris"  /></td>
		</tr>
 		</table>
 		</fieldset>
	
	  <input type="hidden" name="alumno_id" id="alumno_id" value="">
	  <input type="hidden" name="status" id="status" value="0">
	 <input type="hidden" name="MM_insert" value="captchaform">	
</form>  
<?php } ?>
<!-- FIN DE ALUMNOS NUEVO INGRESO -->	

<!-- SI NO EXISTE EL ESTUDIANTE 
<?php if(($totalRows_alumnopre==0) and ($totalRows_alumnor==0)){ ?>
<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-family:verdana; font-size:11px;">
				<h1> <img src="../../images/png/atencion.png" alt="" align="middle" width="80">No Autorizado!</h1>				
				<center>	A&uacute;n no estas Autorizado para llenar la Planilla de Inscripci&oacute;n <br />
			si crees que es un error puedes comunicarte con nosotros a trav&eacute;z del Tel&eacute;fono   <?php echo $row_users['telcol'];?> <br/>
			Volver Atras  <a href="inscripcion_formal.php">Aqu&iacute;</a> </center></div>
<?php } ?>
 FIN SI NO EXISTE ESTUDIANTE -->	
	
  <br />
  <br />
  <br />

 </div>
<?php require_once('../inc/barra_publicidad.inc.php'); ?>	
</body>

</center>
</html>