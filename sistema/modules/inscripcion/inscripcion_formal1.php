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

   $updateSQL = sprintf("UPDATE jos_alumno_info SET nombre=%s, apellido=%s, indicador_nacionalidad=%s, lugar_nacimiento=%s, direccion_vivienda=%s, telefono_alumno=%s, nombre_representante=%s, apellido_representante=%s, parentesco_representante=%s, direccion_representante=%s, telefono_representante=%s, email_representante=%s, cedula_representante=%s, descripcion_trabajo=%s, direccion_trabajo=%s, telefono_trabajo=%s, cedula_madre=%s, nombre_madre=%s, apellido_madre=%s, tel_madre=%s, direccion_madre=%s, profesion_madre=%s, cedula_padre=%s, nombre_padre=%s, apellido_padre=%s, tel_padre=%s, direccion_padre=%s, profesion_padre=%s, ingreso_familiar=%s, vecino1_nombre=%s, vecino1_parentesco=%s, vecino1_telefono=%s, vecino2_nombre=%s, vecino2_parentesco=%s, vecino2_telefono=%s, seguro_posee=%s, seguro_nombre=%s, seguro_clinica=%s, tipo_sangre=%s, alergico=%s, status=%s, fecha_nacimiento=%s, anio_id=%s, cedula=%s, sexo=%s, ef=%s, estado=%s  WHERE alumno_id=%s",

							  GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                       GetSQLValueString($_POST['lugar_nacimiento'], "text"),
                       GetSQLValueString($_POST['direccion_vivienda'], "text"),
                       GetSQLValueString($_POST['telefono_alumno'], "text"),
                       GetSQLValueString($_POST['nombre_representante'], "text"),
                       GetSQLValueString($_POST['apellido_representante'], "text"),
                       GetSQLValueString($_POST['parentesco_representante'], "text"),
                       GetSQLValueString($_POST['direccion_representante'], "text"),
                       GetSQLValueString($_POST['telefono_representante'], "text"),
                       GetSQLValueString($_POST['email_representante'], "text"),
                       GetSQLValueString($_POST['cedula_representante'], "bigint"),
                       GetSQLValueString($_POST['descripcion_trabajo'], "text"),
                       GetSQLValueString($_POST['direccion_trabajo'], "text"),
                       GetSQLValueString($_POST['telefono_trabajo'], "text"),
                       GetSQLValueString($_POST['cedula_madre'], "bigint"),
                       GetSQLValueString($_POST['nombre_madre'], "text"),
                       GetSQLValueString($_POST['apellido_madre'], "text"),
                       GetSQLValueString($_POST['tel_madre'], "text"),
                       GetSQLValueString($_POST['direccion_madre'], "text"),
                       GetSQLValueString($_POST['profesion_madre'], "text"),
                       GetSQLValueString($_POST['cedula_padre'], "bigint"),
                       GetSQLValueString($_POST['nombre_padre'], "text"),
                       GetSQLValueString($_POST['apellido_padre'], "text"),
                       GetSQLValueString($_POST['tel_padre'], "text"),
                       GetSQLValueString($_POST['direccion_padre'], "text"),
                       GetSQLValueString($_POST['profesion_padre'], "text"),
                       GetSQLValueString($_POST['ingreso_familiar'], "text"),
                       GetSQLValueString($_POST['vecino1_nombre'], "text"),
                       GetSQLValueString($_POST['vecino1_parentesco'], "text"),
                       GetSQLValueString($_POST['vecino1_telefono'], "text"),
                       GetSQLValueString($_POST['vecino2_nombre'], "text"),
                       GetSQLValueString($_POST['vecino2_parentesco'], "text"),
                       GetSQLValueString($_POST['vecino2_telefono'], "text"),
                       GetSQLValueString($_POST['seguro_posee'], "int"),
                       GetSQLValueString($_POST['seguro_nombre'], "text"),
                       GetSQLValueString($_POST['seguro_clinica'], "text"),
                       GetSQLValueString($_POST['tipo_sangre'], "text"),
                       GetSQLValueString($_POST['alergico'], "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['anio_id'], "int"),
                       GetSQLValueString($_POST['cedula'], "bigint"),
                       GetSQLValueString($_POST['sexo'], "text"),
                       GetSQLValueString($_POST['ef'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['alumno_id'], "bigint"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());

  $updateGoTo = "inscripcion_formal2.php";
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
 $insertSQL = sprintf("INSERT INTO jos_alumno_info (alumno_id, nombre, apellido, indicador_nacionalidad, lugar_nacimiento, direccion_vivienda, telefono_alumno, nombre_representante, apellido_representante, parentesco_representante, direccion_representante, telefono_representante, email_representante, cedula_representante, descripcion_trabajo, direccion_trabajo, telefono_trabajo, cedula_madre, nombre_madre, apellido_madre, tel_madre, direccion_madre, profesion_madre, cedula_padre, nombre_padre, apellido_padre, tel_padre, direccion_padre, profesion_padre, ingreso_familiar, vecino1_nombre, vecino1_parentesco, vecino1_telefono, vecino2_nombre, vecino2_parentesco, vecino2_telefono, seguro_posee, seguro_nombre, seguro_clinica, tipo_sangre, alergico, status, fecha_nacimiento, anio_id, cedula, sexo, ef, estado) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
							  
							  GetSQLValueString($_POST['alumno_id'], "int"),
						  	  GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['indicador_nacionalidad'], "text"),
                       GetSQLValueString($_POST['lugar_nacimiento'], "text"),
                       GetSQLValueString($_POST['direccion_vivienda'], "text"),
                       GetSQLValueString($_POST['telefono_alumno'], "text"),
                       GetSQLValueString($_POST['nombre_representante'], "text"),
                       GetSQLValueString($_POST['apellido_representante'], "text"),
                       GetSQLValueString($_POST['parentesco_representante'], "text"),
                       GetSQLValueString($_POST['direccion_representante'], "text"),
                       GetSQLValueString($_POST['telefono_representante'], "text"),
                       GetSQLValueString($_POST['email_representante'], "text"),
                       GetSQLValueString($_POST['cedula_representante'], "bigint"),
                       GetSQLValueString($_POST['descripcion_trabajo'], "text"),
                       GetSQLValueString($_POST['direccion_trabajo'], "text"),
                       GetSQLValueString($_POST['telefono_trabajo'], "text"),
                       GetSQLValueString($_POST['cedula_madre'], "bigint"),
                       GetSQLValueString($_POST['nombre_madre'], "text"),
                       GetSQLValueString($_POST['apellido_madre'], "text"),
                       GetSQLValueString($_POST['tel_madre'], "text"),
                       GetSQLValueString($_POST['direccion_madre'], "text"),
                       GetSQLValueString($_POST['profesion_madre'], "text"),
                       GetSQLValueString($_POST['cedula_padre'], "bigint"),
                       GetSQLValueString($_POST['nombre_padre'], "text"),
                       GetSQLValueString($_POST['apellido_padre'], "text"),
                       GetSQLValueString($_POST['tel_padre'], "text"),
                       GetSQLValueString($_POST['direccion_padre'], "text"),
                       GetSQLValueString($_POST['profesion_padre'], "text"),
                       GetSQLValueString($_POST['ingreso_familiar'], "text"),
                       GetSQLValueString($_POST['vecino1_nombre'], "text"),
                       GetSQLValueString($_POST['vecino1_parentesco'], "text"),
                       GetSQLValueString($_POST['vecino1_telefono'], "text"),
                       GetSQLValueString($_POST['vecino2_nombre'], "text"),
                       GetSQLValueString($_POST['vecino2_parentesco'], "text"),
                       GetSQLValueString($_POST['vecino2_telefono'], "text"),
                       GetSQLValueString($_POST['seguro_posee'], "int"),
                       GetSQLValueString($_POST['seguro_nombre'], "text"),
                       GetSQLValueString($_POST['seguro_clinica'], "text"),
                       GetSQLValueString($_POST['tipo_sangre'], "text"),
                       GetSQLValueString($_POST['alergico'], "text"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['anio_id'], "int"),
                       GetSQLValueString($_POST['cedula'], "bigint"),
                       GetSQLValueString($_POST['sexo'], "text"),
                       GetSQLValueString($_POST['ef'], "text"),
                       GetSQLValueString($_POST['estado'], "text"));
                       
  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "inscripcion_formal2.php";
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
<h2 style="font-family:verdana; text-shadow: black 0em 0.1em 0.1em ">Formulario de Inscripci&oacute;n (paso 2)</h2>
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
			<td align="right"><label> Sexo: </label></td>
			<td>
			<select class="text_input_peq" style="width:120px;" name="sexo" class="texto_mediano_gris" id="sexo">
         <option value="<?php echo $row_alumnor['sexo'];?>"><?php echo $row_alumnor['sexo'];?></option>
         <option value="F">Femenino</option>
         <option value="M">Masculino</option>
         </select>			
			</td>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_vivienda" name="direccion_vivienda" /><?php echo $row_alumnor['direccion_vivienda'];?></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="telefono_alumno" name="telefono_alumno" value="<?php echo $row_alumnor['telefono_alumno'];?>" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Fecha de Nacimiento: </label></td>
			<td><div style="color:blue; font-size:10px;">Presiona click en el campo para la Fecha</div>
			<input name="fecha_nacimiento" class="text_input_peq" style="width:120px;" type="text" id="dateArrival" value="<?php echo $row_alumnor['fecha_nacimiento'];?>" onClick="popUpCalendar(this, captchaform.dateArrival, 'yyyy/mm/dd');" size="10" readonly="readonly"></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Lugar de Nacimiento: </label></td>
			<td>
			<?php if($row_alumnor['lugar_nacimiento']==NULL){?>						
			<input class="text_input_peq" type="text" id="lugar_nacimiento" name="lugar_nacimiento" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="lugar_nacimiento" name="lugar_nacimiento" value="<?php echo $row_alumnor['lugar_nacimiento'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>		
		
		<tr>
			<td align="right"><label> Estado: </label></td>
			<td>
			<?php if($row_alumnor['estado']==NULL){?>						
			<input class="text_input_peq" type="text" id="estado" name="estado" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
			<?php }else {?>
			<input class="text_input_peq" type="text" id="estado" name="estado" value="<?php echo $row_alumnor['estado'];?>" readonly="readonly"/></td>
			<?php }?>
							
		</tr>		

		<tr>
			<td align="right"><label>Entidad Federal (inicial): </label></td>
			<td>
			<?php if($row_alumnor['ef']==NULL){?>						
			<input class="text_input_peq" style="width:50px;" type="text" id="ef" name="ef" value="" onKeyUp="this.value=this.value.toUpperCase()"/><small>Ej. TA</small></td>
			<?php }else {?>
			<input class="text_input_peq" style="width:50px;" type="text" id="ef" name="ef" value="<?php echo $row_alumnor['ef'];?>" readonly="readonly"/>&nbsp;&nbsp;<small>Ej. TA</small></td>
			<?php }?>
							
		</tr>
		
		</table>
		</fieldset>
		<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos del Representante</legend>
		<table>
		<tr>
			<td align="right"><label> C&eacute;dula del Representante: </label></td>
			<td>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_representante" name="cedula_representante" value="<?php echo $row_alumnor['cedula_representante'];?>" /></td>
			
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Representante: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="nombre_representante" name="nombre_representante" value="<?php echo $row_alumnor['nombre_representante'];?>" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Apellido del Representante: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="apellido_representante" name="apellido_representante" value="<?php echo $row_alumnor['apellido_representante'];?>"/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Parentesco Representante: </label></td>
			<td>
			<select class="text_input_peq" name="parentesco_representante" class="texto_mediano_gris" id="parentesco_representante">
			 <option value="">..Seleccionar</option>
			 <option value="Madre">Madre</option>
			 <option value="Padre">Padre</option>
         <option value="Abuelo(a)">Abuelo(a)</option>
         <option value="T&iacute;o(a)">T&iacute;o(a)</option>
         <option value="Hermano(a)">Hermano(a)</option>
         <option value="Vecino(a)">Vecino(a)</option>
         <option value="Otro">Otro</option>
         </select>			
			
			</td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_representante" name="direccion_representante" /><?php echo $row_alumnor['direccion_representante'];?></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="telefono_representante" name="telefono_representante" value="<?php echo $row_alumnor['telefono_representante'];?>" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> E-mail/Correo Electr&oacute;nico: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="email_representante" name="email_representante" value="<?php echo $row_alumnor['email_representante'];?>" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Ocupaci&oacute;n del Representante: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="descripcion_trabajo" name="descripcion_trabajo" value="<?php echo $row_alumnor['descripcion_trabajo'];?>"/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n de Trabajo: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_trabajo" name="direccion_trabajo" /><?php echo $row_alumnor['direccion_trabajo'];?></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono del Trabajo: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="telefono_trabajo" name="telefono_trabajo" value="<?php echo $row_alumnor['telefono_trabajo'];?>" /></td>
							
		</tr>
		</table>
		
	</fieldset>
	<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos de los Padres</legend>
	<table>
		
		<tr>
			<td align="right"><label> C&eacute;dula de la Madre: </label></td>
			<td>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_madre" name="cedula_madre" value="<?php echo $row_alumnor['cedula_madre'];?>" /></td>
			
							
		</tr>
		<tr>
			<td align="right"><label> Nombre de la Madre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="nombre_madre" name="nombre_madre" value="<?php echo $row_alumnor['nombre_madre'];?>" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Apellido de la Madre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="apellido_madre" name="apellido_madre" value="<?php echo $row_alumnor['apellido_madre'];?>"/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n de la Madre: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_madre" name="direccion_madre" /><?php echo $row_alumnor['direccion_madre'];?></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono de la Madre: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="tel_madre" name="tel_madre" value="<?php echo $row_alumnor['tel_madre'];?>" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Ocupaci&oacute;n de la Madre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="profesion_madre" name="profesion_madre" value="<?php echo $row_alumnor['profesion_madre'];?>"/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> C&eacute;dula del Padre: </label></td>
			<td>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_padre" name="cedula_padre" value="<?php echo $row_alumnor['cedula_padre'];?>" /></td>
			
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Padre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="nombre_padre" name="nombre_padre" value="<?php echo $row_alumnor['nombre_padre'];?>" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Apellido del Padre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="apellido_padre" name="apellido_padre" value="<?php echo $row_alumnor['apellido_padre'];?>"/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n del Padre: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_padre" name="direccion_padre" /><?php echo $row_alumnor['direccion_padre'];?></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono del Padre: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="tel_padre" name="tel_padre" value="<?php echo $row_alumnor['tel_padre'];?>" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Ocupaci&oacute;n del Padre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="profesion_padre" name="profesion_padre" value="<?php echo $row_alumnor['profesion_padre'];?>"/></td>
							
		</tr>
				
		<tr>
			<td align="right"><label> Ingreso Familiar: </label></td>
			<td>
			<select class="text_input_peq" name="ingreso_familiar" class="texto_mediano_gris" id="ingreso_familiar">
         <option value="M&aacute;s de 5.000 BsF.">M&aacute;s de 5.000 BsF.</option>
         <option value="De 4.000 BsF. a 5.000 BsF.">De 4.000 BsF. a 5.000 BsF.</option>
         <option value="De 2.500 BsF. a 4.000 BsF.">De 2.500 BsF. a 4.000 BsF.</option>
         <option value="De 1.000 BsF. a 2.500 BsF.">De 1.000 BsF. a 2.500 BsF.</option>
         </select>			
			
			</td>
							
		</tr>

</table>
</fieldset>
<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos Varios</legend>
<table>
	<tr>
			<td align="right"><label> Nombre del Vecino/Familiar (1): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino1_nombre" name="vecino1_nombre" value="<?php echo $row_alumnor['vecino1_nombre'];?>" /></td>
			
		</tr>

	<tr>
			<td align="right"><label> Parentesco Vecino/Familiar (1): </label></td>
			<td>
			<select class="text_input_peq" name="vecino1_parentesco" class="texto_mediano_gris" id="vecino1_parentesco">
			 <option value="<?php echo $row_alumnor['vecino1_parentesco'];?>"><?php echo $row_alumnor['vecino1_parentesco'];?></option>
         <option value="Abuelo(a)">Abuelo(a)</option>
         <option value="T&iacute;o(a)">T&iacute;o(a)</option>
         <option value="Hermano(a)">Hermano(a)</option>
         <option value="Vecino(a)">Vecino(a)</option>
         <option value="Otro">Otro</option>
         </select>			
			
			</td>
							
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono del Vecino/Familiar (1): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino1_telefono" name="vecino1_telefono" value="<?php echo $row_alumnor['vecino1_telefono'];?>" /></td>
			
		</tr>
		
<tr>
			<td align="right"><label> Nombre del Vecino/Familiar (2): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino2_nombre" name="vecino2_nombre" value="<?php echo $row_alumnor['vecino2_nombre'];?>" /></td>
			
		</tr>

	<tr>
			<td align="right"><label> Parentesco Vecino/Familiar (2): </label></td>
			<td>
			<select class="text_input_peq" name="vecino2_parentesco" class="texto_mediano_gris" id="vecino2_parentesco">
			 <option value="<?php echo $row_alumnor['vecino2_parentesco'];?>"><?php echo $row_alumnor['vecino2_parentesco'];?></option>
         <option value="Abuelo(a)">Abuelo(a)</option>
         <option value="T&iacute;o(a)">T&iacute;o(a)</option>
         <option value="Hermano(a)">Hermano(a)</option>
         <option value="Vecino(a)">Vecino(a)</option>
         <option value="Otro">Otro</option>
         </select>			
			
			</td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Tel&eacute;fono del Vecino/Familiar (2): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino2_telefono" name="vecino2_telefono" value="<?php echo $row_alumnor['vecino2_telefono'];?>" /></td>
			
		</tr>
		
					<tr>
			<td align="right"><label> Posee Seguro: </label></td>
			<td>
			<select class="text_input_peq" style="width:50px;" name="seguro_posee" class="texto_mediano_gris" id="seguro_posee">
		   <option value="NO">NO</option>
		   <option value="SI">SI</option>
         
         </select>			
			
			</td>
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Seguro: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="seguro_nombre" name="seguro_nombre" value="<?php echo $row_alumnor['seguro_nombre'];?>" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Llevar al Centro M&eacute;dico: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="seguro_clinica" name="seguro_clinica" value="<?php echo $row_alumnor['seguro_clinica'];?>" /></td>
			
		</tr>	
		<tr>
			<td align="right"><label> Tipo de Sangre: </label></td>
			<td>
			<input class="text_input_peq" style="width:80px;" type="text" id="tipo_sangre" name="tipo_sangre" value="<?php echo $row_alumnor['tipo_sangre'];?>" /></td>
			
		</tr>	
		<tr>
			<td align="right"><label>El Estudiante es Alergico a: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="alergico" name="alergico" value="<?php echo $row_alumnor['alergico'];?>" /></td>
			
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
<!--		
		<tr>
			<td align="right"><div id="captchaimage" style="border:1px solid; width:135px;"><img src="images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image" /></td>
			<td><div style="color:blue; font-size:10px;">Ingresa los caracteres de la imagen</div>
			<input type="text" maxlength="6" style="width:150px;" size="25" name="captcha" id="captcha" class="text_input_peq"/></td>
							
		</tr>
		-->
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
<?php if(($totalRows_alumnopre>0) and ($totalRows_alumnor==0)){ ?>
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
		<legend align="left" class="texto_grande_gris">Datos del Cliente</legend>
		<table>
		<tr>
			<td align="right"><label> C&eacute;dula: </label></td>
			<td>	
<select class="text_input_peq" name="indicador_nacionalidad" style="width:50px; border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px;">
   		  <option value="V">V</option>
  			  <option value="E">E</option>
			</select> -	
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula" name="cedula" value="" onKeyUp="this.value=this.value.toUpperCase()"/></td>
							
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
			<tr>
			<td align="right"><label> Sexo: </label></td>
			<td>
			<select class="text_input_peq" style="width:120px;" name="sexo" class="texto_mediano_gris" id="sexo">
         <option value="">..Seleccionar</option>
         <option value="F">Femenino</option>
         <option value="M">Masculino</option>
         </select>			
			</td>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_vivienda" name="direccion_vivienda" /><?php echo $row_alumnopre['dir_alumno'];?></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="telefono_alumno" name="telefono_alumno" value="<?php echo $row_alumnopre['tel_alumno'];?>" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Fecha de Nacimiento: </label></td>
			<td><div style="color:blue; font-size:10px;">Presiona click en el campo para la Fecha</div>
			<input name="fecha_nacimiento" class="text_input_peq" style="width:120px;" type="text" id="dateArrival" value="<?php echo $row_alumnopre['fecha_nacimiento'];?>" onClick="popUpCalendar(this, captchaform.dateArrival, 'yyyy/mm/dd');" size="10" readonly="readonly"></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Lugar de Nacimiento: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="lugar_nacimiento" name="lugar_nacimiento" value="" /></td>

							
		</tr>		
		
		<tr>
			<td align="right"><label> Estado: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="estado" name="estado" value="" /></td>

							
		</tr>		

		<tr>
			<td align="right"><label>Entidad Federal (inicial): </label></td>
			<td>
			<input class="text_input_peq" style="width:50px;" type="text" id="ef" name="ef" value="" />&nbsp;&nbsp;<small>Ej. TA</small></td>

							
		</tr>
		
		</table>
		</fieldset>
		<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos del Representante</legend>
		<table>
		<tr>
			<td align="right"><label> C&eacute;dula del Representante: </label></td>
			<td>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_representante" name="cedula_representante" value="" /></td>
			
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Representante: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="nombre_representante" name="nombre_representante" value="" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Apellido del Representante: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="apellido_representante" name="apellido_representante" value=""/></td>
							
		</tr>
			<tr>
			<td align="right"><label> Parentesco Representante: </label></td>
			<td>
			<select class="text_input_peq" name="parentesco_representante" class="texto_mediano_gris" id="parentesco_representante">
			 <option value="">..Seleccionar</option>
			 <option value="Madre">Madre</option>
			 <option value="Padre">Padre</option>
         <option value="Abuelo(a)">Abuelo(a)</option>
         <option value="T&iacute;o(a)">T&iacute;o(a)</option>
         <option value="Hermano(a)">Hermano(a)</option>
         <option value="Vecino(a)">Vecino(a)</option>
         <option value="Otro">Otro</option>
         </select>			
			
			</td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_representante" name="direccion_representante" /></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="telefono_representante" name="telefono_representante" value="" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> E-mail/Correo Electr&oacute;nico: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="email_representante" name="email_representante" value="" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Ocupaci&oacute;n del Representante: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="descripcion_trabajo" name="descripcion_trabajo" value=""/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n de Trabajo: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_trabajo" name="direccion_trabajo" /></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono del Trabajo: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="telefono_trabajo" name="telefono_trabajo" value="" /></td>
							
		</tr>
		</table>
		
	</fieldset>
	<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos de los Padres</legend>
	<table>
		
		<tr>
			<td align="right"><label> C&eacute;dula de la Madre: </label></td>
			<td>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_madre" name="cedula_madre" value="" /></td>
			
							
		</tr>
		<tr>
			<td align="right"><label> Nombre de la Madre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="nombre_madre" name="nombre_madre" value="" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Apellido de la Madre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="apellido_madre" name="apellido_madre" value=""/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n de la Madre: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_madre" name="direccion_madre" /></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono de la Madre: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="tel_madre" name="tel_madre" value="" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Ocupaci&oacute;n de la Madre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="profesion_madre" name="profesion_madre" value=""/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> C&eacute;dula del Padre: </label></td>
			<td>
			<input class="text_input_peq" style="width:180px;" type="text" id="cedula_padre" name="cedula_padre" value="" /></td>
			
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Padre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="nombre_padre" name="nombre_padre" value="" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Apellido del Padre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="apellido_padre" name="apellido_padre" value=""/></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Direcci&oacute;n del Padre: </label></td>
			<td>

			<textarea class="text_tarea" id="direccion_padre" name="direccion_padre" /></textarea></td>
						
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono del Padre: </label></td>
			<td>

			<input class="text_input_peq" type="text" id="tel_padre" name="tel_padre" value="" /></td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Ocupaci&oacute;n del Padre: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="profesion_padre" name="profesion_padre" value=""/></td>
							
		</tr>
				
		<tr>
			<td align="right"><label> Ingreso Familiar: </label></td>
			<td>
			<select class="text_input_peq" name="ingreso_familiar" class="texto_mediano_gris" id="ingreso_familiar">
         <option value="M&aacute;s de 5.000 BsF.">M&aacute;s de 5.000 BsF.</option>
         <option value="De 4.000 BsF. a 5.000 BsF.">De 4.000 BsF. a 5.000 BsF.</option>
         <option value="De 2.500 BsF. a 4.000 BsF.">De 2.500 BsF. a 4.000 BsF.</option>
         <option value="De 1.000 BsF. a 2.500 BsF.">De 1.000 BsF. a 2.500 BsF.</option>
         </select>			
			
			</td>
							
		</tr>

</table>
</fieldset>
<br />
		<fieldset >
		<legend align="left" class="texto_grande_gris">Datos Varios</legend>
<table>
	<tr>
			<td align="right"><label> Nombre del Vecino/Familiar (1): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino1_nombre" name="vecino1_nombre" value="" /></td>
			
		</tr>

	<tr>
			<td align="right"><label> Parentesco Vecino/Familiar (1): </label></td>
			<td>
			<select class="text_input_peq" name="vecino1_parentesco" class="texto_mediano_gris" id="vecino1_parentesco">
			 <option value="">..Seleccionar</option>
         <option value="Abuelo(a)">Abuelo(a)</option>
         <option value="T&iacute;o(a)">T&iacute;o(a)</option>
         <option value="Hermano(a)">Hermano(a)</option>
         <option value="Vecino(a)">Vecino(a)</option>
         <option value="Otro">Otro</option>
         </select>			
			
			</td>
							
		</tr>
		<tr>
			<td align="right"><label> Tel&eacute;fono del Vecino/Familiar (1): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino1_telefono" name="vecino1_telefono" value="" /></td>
			
		</tr>
		
<tr>
			<td align="right"><label> Nombre del Vecino/Familiar (2): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino2_nombre" name="vecino2_nombre" value="" /></td>
			
		</tr>

	<tr>
			<td align="right"><label> Parentesco Vecino/Familiar (2): </label></td>
			<td>
			<select class="text_input_peq" name="vecino2_parentesco" class="texto_mediano_gris" id="vecino2_parentesco">
			 <option value="">..Seleccionar</option>
         <option value="Abuelo(a)">Abuelo(a)</option>
         <option value="T&iacute;o(a)">T&iacute;o(a)</option>
         <option value="Hermano(a)">Hermano(a)</option>
         <option value="Vecino(a)">Vecino(a)</option>
         <option value="Otro">Otro</option>
         </select>			
			
			</td>
							
		</tr>
		
		<tr>
			<td align="right"><label> Tel&eacute;fono del Vecino/Familiar (2): </label></td>
			<td>
			<input class="text_input_peq" type="text" id="vecino2_telefono" name="vecino2_telefono" value="" /></td>
			
		</tr>
		
					<tr>
			<td align="right"><label> Posee Seguro: </label></td>
			<td>
			<select class="text_input_peq" style="width:50px;" name="seguro_posee" class="texto_mediano_gris" id="seguro_posee">
		   <option value="NO">NO</option>
		   <option value="SI">SI</option>
         
         </select>			
			
			</td>
							
		</tr>
		<tr>
			<td align="right"><label> Nombre del Seguro: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="seguro_nombre" name="seguro_nombre" value="" /></td>
			
		</tr>
		<tr>
			<td align="right"><label> Llevar al Centro M&eacute;dico: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="seguro_clinica" name="seguro_clinica" value="" /></td>
			
		</tr>	
		<tr>
			<td align="right"><label> Tipo de Sangre: </label></td>
			<td>
			<input class="text_input_peq" style="width:80px;" type="text" id="tipo_sangre" name="tipo_sangre" value="" /></td>
			
		</tr>	
		<tr>
			<td align="right"><label>El Estudiante es Alergico a: </label></td>
			<td>
			<input class="text_input_peq" type="text" id="alergico" name="alergico" value="" /></td>
			
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
		<!--
		<tr>
			<td align="right"><div id="captchaimage" style="border:1px solid; width:135px;"><img src="images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image" /></td>
			<td><div style="color:blue; font-size:10px;">Ingresa los caracteres de la imagen</div>
			<input type="text" maxlength="6" style="width:150px;" size="25" name="captcha" id="captcha" class="text_input_peq"/></td>
							
		</tr>
		-->
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

<!-- SI NO EXISTE EL ESTUDIANTE -->
<?php if(($totalRows_alumnopre==0) and ($totalRows_alumnor==0)){ ?>
<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-family:verdana; font-size:11px;">
				<h1> <img src="../../images/png/atencion.png" alt="" align="middle" width="80">No Autorizado!</h1>				
				<center>	A&uacute;n no estas Autorizado para llenar la Planilla de Inscripci&oacute;n <br />
			si crees que es un error puedes comunicarte con nosotros a trav&eacute;z del Tel&eacute;fono   <?php echo $row_users['telcol'];?> <br/>
			Volver Atras  <a href="inscripcion_formal.php">-->Aqu&iacute;</a> </center></div>
<?php } ?>
<!-- FIN SI NO EXISTE ESTUDIANTE -->	
	
  <br />
  <br />
  <br />

 </div>
<?php require_once('../inc/barra_publicidad.inc.php'); ?>	
</body>

</center>
</html>