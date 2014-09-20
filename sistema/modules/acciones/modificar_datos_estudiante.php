<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
         $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
          $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
  
}
}



// 	GRABADO EN LA TABLA JOS_ALUMNO_INFO


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha_nac= $_POST['ano_nacimiento']."-".$_POST['mes_nacimiento']."-".$_POST['dia_nacimiento'];
//corregir

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {

   $insertSQL = sprintf("INSERT INTO jos_alumno_info (alumno_id, nombre, apellido, indicador_nacionalidad, lugar_nacimiento, direccion_vivienda, telefono_alumno, nombre_representante, apellido_representante, parentesco_representante, direccion_representante, telefono_representante, email_representante, cedula_representante, descripcion_trabajo, direccion_trabajo, telefono_trabajo, nombre_madre, apellido_madre, tel_madre, direccion_madre, nombre_padre, apellido_padre, tel_padre, direccion_padre, ingreso_familiar, vecino1_nombre, vecino1_parentesco, vecino1_telefono, vecino2_nombre, vecino2_parentesco, vecino2_telefono, seguro_posee, seguro_nombre, seguro_clinica, tipo_sangre, alergico, creado, status, cursando, fecha_nacimiento, periodo_id, jos_alumno_infocol, joomla_id, anio_id, cedula, sexo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
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
							GetSQLValueString($_POST['cedula_representante'], "int"),
							GetSQLValueString($_POST['descripcion_trabajo'], "text"),
							GetSQLValueString($_POST['direccion_trabajo'], "text"),
							GetSQLValueString($_POST['telefono_trabajo'], "text"),
							GetSQLValueString($_POST['nombre_madre'], "text"),
							GetSQLValueString($_POST['apellido_madre'], "text"),
							GetSQLValueString($_POST['tel_madre'], "text"),
							GetSQLValueString($_POST['direccion_madre'], "text"),
							GetSQLValueString($_POST['nombre_padre'], "text"),
							GetSQLValueString($_POST['apellido_padre'], "text"),
							GetSQLValueString($_POST['tel_padre'], "text"),
							GetSQLValueString($_POST['direccion_padre'], "text"),
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
							GetSQLValueString($_POST['creado'], "time"),
							GetSQLValueString($_POST['status'], "int"),
							GetSQLValueString($_POST['cursando'], "int"),
							GetSQLValueString($fecha_nac, "date"),
							GetSQLValueString($_POST['periodo_id'], "int"),
							GetSQLValueString($_POST['jos_alumno_infocol'], "text"),
							GetSQLValueString($value, "int"),
							GetSQLValueString($_POST['anio_id'], "int"),
							GetSQLValueString($_POST['cedula'], "int"),
							GetSQLValueString($_POST['sexo'], "text"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "planilla_inscripcion2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}



// FIN DEL REGISTRO DE ESTUDIANTES 


$colname_alumno = "-1";
if (isset($_GET['cedula'])) {
  $colname_alumno = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_alumno_info WHERE cedula = %s", GetSQLValueString($colname_alumno, "text"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);

mysql_select_db($database_sistemacol, $sistemacol);
$query_anio = "SELECT * FROM jos_anio_nombre ORDER BY id ASC";
$anio = mysql_query($query_anio, $sistemacol) or die(mysql_error());
$row_anio = mysql_fetch_assoc($anio);
$totalRows_anio = mysql_num_rows($anio);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::PLANILLA DE REGISTRO DE ESTUDIANTES</title>
<link href="../../css/componentes.css" rel="stylesheet" type="text/css">

<script src="../../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />

</head>
<body >
<div id="contenedor">
	<div id="contenido">
		
		 <?php if ($totalRows_alumno == 0) { // Verificacion de datos 
		 ?> 
		 <b>No existe un Estudiante con ese numero de cedula</b>
		 <img src="../images/gif/1rrow4.gif" height="" width="" alt="" align="middle"/>&nbsp;&nbsp;<a href="../acceso/index.php"  >Volver al Menu</a>&nbsp;-&nbsp; <img src="../images/png/usua1.png" height="" width="" alt="" align="middle"/><a href=""  >Otro Estudiante</a>
		 <?php }
		   if ($totalRows_alumno > 0) {?> 
		   <h2 align="center">Modificar Datos de Estudiante</h2>
			<img src="../images/gif/1rrow4.gif" height="" width="" alt="" align="middle"/>&nbsp;&nbsp;<a href="../acceso/index.php" >Volver al Menu</a>&nbsp;-&nbsp; <img src="../images/png/usua1.png" height="" width="" alt="" align="middle"/><a href=""  >Otro Estudiante</a>
			<?php // INICIO DE LA TABLA PARA EL FOMULARIO
			?> 	   
	<table><tr><td>		   
		   <form action="<?php echo $editFormAction; ?>" method="POST" name="form3">
		   
			
<?php // INICIO DE REGISTRO DE DATOS DEL ESTUDIANTE 
?>			
				
			<fieldset class="marco">
		   <legend><strong><em>Datos del Estudiante</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px">Nombre:*</td>
			<td><span id="sprytextfield4"><strong><input type="text" name="nombre" value="<?php echo $row_alumno['nombre']; ?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >Apellido:*</td>
			<td><span id="sprytextfield5"><strong><input type="text" name="apellido" value="<?php echo $row_alumno['apellido']; ?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >Sexo:*</td>
			<td><select name="sexo" id="sexo">
             <option value="F">F</option>
             <option value="M">M</option></select></td>
             			
			<tr><td align="right" >Nacionalidad:*</td>
			<td><select name="indicador_nacionalidad" id="indicador_nacionalidad">
             <option value="V">Venezolano(a)</option>
             <option value="E">Extranjero(a)</option></select></td>

			<tr><td align="right" >Fecha de Nacimiento:*</td>
			<td><select name="dia_nacimiento" id="dia_nacimiento">
             <option value="01">01</option>
             <option value="02">02</option>
             <option value="03">03</option>
             <option value="04">04</option>
             <option value="05">05</option>
             <option value="06">06</option>
             <option value="07">07</option>
             <option value="08">08</option>
             <option value="09">09</option>
             <option value="10">10</option>
         	 <option value="11">11</option>
		 		 <option value="12">12</option>
				 <option value="13">13</option>
				 <option value="14">14</option>
				 <option value="15">15</option>
				 <option value="16">16</option>
				 <option value="17">17</option>
				 <option value="18">18</option>
				 <option value="19">19</option>
				 <option value="20">20</option>
				 <option value="21">21</option>
				 <option value="22">22</option>
				 <option value="23">23</option>
				 <option value="24">24</option>
				 <option value="25">25</option>
				 <option value="26">26</option>
				 <option value="27">27</option>
				 <option value="28">28</option>
				 <option value="29">29</option>
				 <option value="30">30</option>  
				 <option value="31">31</option>                        
             </select>
             <select name="mes_nacimiento" id="mes_nacimiento">
             <option value="01">Enero</option>
             <option value="02">Febrero</option>
             <option value="03">Marzo</option>
             <option value="04">Abril</option>
             <option value="05">Mayo</option>
             <option value="06">Junio</option>
             <option value="07">Julio</option>
             <option value="08">Agosto</option>
             <option value="09">Septiembre</option>
             <option value="10">Octubre</option>
				 <option value="11">Noviembre</option>
				 <option value="12">Diciembre</option>                          
             </select>
             <select name="ano_nacimiento" id="ano_nacimiento">
             
             <option value="2008">2008</option>
             <option value="2007">2007</option>
             <option value="2006">2006</option>
             <option value="2005">2005</option>
             <option value="2004">2004</option>
             <option value="2003">2003</option>
             <option value="2002">2002</option>
             <option value="2001">2001</option>
             <option value="2000">2000</option>
             <option value="1999">1999</option>
             <option value="1998">1998</option>
             <option value="1997">1997</option>
             <option value="1996">1996</option>
             <option value="1995">1995</option>
             <option value="1994">1994</option>
             <option value="1993">1993</option>
             <option value="1992">1992</option>
             <option value="1991">1991</option>
             <option value="1990">1990</option>
             <option value="1989">1989</option>
             <option value="1988">1988</option>
             <option value="1987">1987</option>
             <option value="1986">1986</option>
             <option value="1985">1985</option>
             </select>
             </td></tr>
             			
			<tr><td align="right">Cedula:</td>
			<td><span id="sprytextfield8"><strong><input type="text" name="cedula" value="<?php echo $_GET['cedula']; ?>"  onKeyUp="this.value=this.value.toUpperCase()" readonly="readonly" /><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span><span class="texto_pequeno_gris">                            Ej. 13987456</span></strong></span></td></tr>
			
			<tr><td align="right" >Lugar de Nacimiento:*</td>
			<td><span id="sprytextfield9"><strong><input type="text" name="lugar_nacimiento" value="<?php echo $row_alumno['lugar_nacimiento']; ?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right">Direccion:*</td>
			<td><TEXTAREA COLS=32 ROWS=3 NAME="direccion_vivienda"> <?php echo $row_alumno['direccion_vivienda']; ?></TEXTAREA></td></tr>
			
			<tr><td align="right" >Telefono:*</td>
			<td><span id="sprytextfield11"><strong><input type="text" name="telefono_alumno" value="<?php echo $row_alumno['telefono_alumno']; ?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>				   
		   </td></tr></table>
					
			</fieldset>	
			
			
			<?php // INICIO DE REGISTRO DE DATOS DEL REPRESENTANTE
?>			
				
			<fieldset class="marco">
		   <legend><strong><em>Datos del Representante</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px">Nombre:*</td>
			<td><span id="sprytextfield12"><strong><input type="text" name="nombre_representante" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right">Apellido:*</td>
			<td><span id="sprytextfield13"><strong><input type="text" name="apellido_representante" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >Cedula:*</td>
			<td><span id="sprytextfield14"><strong><input type="text" name="cedula_representante" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span><span class="texto_pequeno_gris">                            Ej. 13987456</span></strong></span></td></tr>
			
			<tr><td align="right" >Parentesco:*</td>
			<td><select name="parentesco_representante" id="parentesco_representante">
             <option value="MADRE">Madre</option>
             <option value="PADRE">Padre</option>
             <option value="Abuelo">Abuelo(a)</option>
             <option value="Hermano">Hermano(a)</option>
             <option value="Tio">Tio(a)</option>
             <option value="Padrino">Padrino</option>
             <option value="Madrina">Madrina</option>
             <option value="Vecino">Vecino(a)</option>
             <option value="Primo">Primo(a)</option>
             <option value="Otro">Otro</option>                          
             </select></td></tr>
			
			<tr><td align="right" >Direccion:*</td>
			<td><TEXTAREA COLS=32 ROWS=3 NAME="direccion_representante"></TEXTAREA></td></tr>
			
			<tr><td align="right" >Telefono:*</td>
			<td><span id="sprytextfield17"><strong><input type="text" name="telefono_representante" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >E-mail:*</td>
			<td><span id="sprytextfield18"><strong><input type="text" name="email_representante" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>				   
		   
			<tr><td align="right" >Profesion:</td>
			<td><input type="text" name="descripcion_trabajo" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right" >Direccion de Trabajo:</td>
			<td><TEXTAREA COLS=32 ROWS=3 NAME="direccion_trabajo"></TEXTAREA></td></tr>				   
		   
		   <tr><td align="right" >Telefono de Trabajo:</td>
			<td><input type="text" name="telefono_trabajo" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			


		   </td></tr></table>
					
			</fieldset>
			
			<?php // INICIO DE REGISTRO DE DATOS DE LOS PADRES
?>			
				
			<fieldset class="marco">
		   <legend><strong><em>Datos de los Padres</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px">Nombre de la Madre:</td>
			<td><input type="text" name="nombre_madre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right" >Apellido de la Madre:</td>
			<td><input type="text" name="apellido_madre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right">Telefono de la Madre:</td>
			<td><input type="text" name="tel_madre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right">Direccion de la Madre:</td>
			<td><TEXTAREA COLS=32 ROWS=3 NAME="direccion_madre"></TEXTAREA></td></tr>
			
			<tr><td align="right">Nombre del Padre:</td>
			<td><strong><input type="text" name="nombre_padre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right" >Apellido del Padre:</td>
			<td><strong><input type="text" name="apellido_padre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right">Telefono del Padre:</td>
			<td><strong><input type="text" name="tel_padre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right" >Direccion del Padre:</td>
			<td><TEXTAREA COLS=32 ROWS=3 NAME="direccion_padre"></TEXTAREA></td></tr>
			
		   </td></tr></table>
					
			</fieldset>
			
				<?php // INICIO DE REGISTRO DE DATOS DE LOS PADRES
?>			
				
			<fieldset class="marco">
		   <legend><strong><em>Informacion General</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px ">Ingreso Familiar:</td>
			<td><select name="ingreso_familiar" id="ingreso_familiar">
             <option value="800Bs a 1200Bs">800Bs a 1200Bs</option>
             <option value="1200Bs a 1800Bs">1200Bs a 1800Bs</option>
             <option value="1800Bs a 2500Bs">1800Bs a 2500Bs</option>
             <option value="2500Bs a 3500Bs">2500Bs a 3500Bs</option>
             <option value="3500Bs a 5000Bs">3500Bs a 5000Bs</option>
                        
             </select></td></tr>
			
			<tr><td align="right" >Vecino o familiar(1):*</td>
			<td><span id="sprytextfield31"><strong><input type="text" name="vecino1_nombre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right">Parentesco Vecino(1):*</td>
			<td><select name="vecino1_parentesco" id="vecino1_parentesco">
             <option value="MADRE">Madre</option>
             <option value="PADRE">Padre</option>
             <option value="Abuelo">Abuelo(a)</option>
             <option value="Hermano">Hermano(a)</option>
             <option value="Tio">Tio(a)</option>
             <option value="Padrino">Padrino</option>
             <option value="Madrina">Madrina</option>
             <option value="Vecino">Vecino(a)</option>
             <option value="Primo">Primo(a)</option>
             <option value="Otro">Otro</option>                          
             </select></td></tr>
			
			<tr><td align="right">Telefono Vecino(1):*</td>
			<td><span id="sprytextfield33"><strong><input type="text" name="vecino1_telefono" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >Vecino o familiar(2):</td>
			<td><input type="text" name="vecino2_nombre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right">Parentesco Vecino(2):</td>
			<td><select name="vecino2_parentesco" id="vecino2_parentesco">
             <option value="MADRE">Madre</option>
             <option value="PADRE">Padre</option>
             <option value="Abuelo">Abuelo(a)</option>
             <option value="Hermano">Hermano(a)</option>
             <option value="Tio">Tio(a)</option>
             <option value="Padrino">Padrino</option>
             <option value="Madrina">Madrina</option>
             <option value="Vecino">Vecino(a)</option>
             <option value="Primo">Primo(a)</option>
             <option value="Otro">Otro</option>                          
             </select></td></tr>
			
			<tr><td align="right">Telefono Vecino(2):</td>
			<td><input type="text" name="vecino2_telefono" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>		
			
			<tr><td align="right">Posee Seguro:</td>
			<td><select name="seguro_posee" id="seguro_posee">
             <option value="0">No</option>
             <option value="1">Si</option>
                             
             </select></td></tr>
			
			<tr><td align="right" >Nombre del Seguro:</td>
			<td><input type="text" name="seguro_nombre" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right">Llevar a la Clinica:</td>
			<td><input type="text" name="seguro_clinica" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
			<tr><td align="right" >Tipo de Sangre:</td>
			<td><select name="tipo_sangre" id="tipo_sangre">
             <option value="O+">O+</option>
             <option value="O-">O-</option>
             <option value="A+">A+</option>
             <option value="A-">A-</option>
             <option value="B+">B+</option>
             <option value="B-">B-</option>
             <option value="AB+">AB+</option>
             <option value="AB-">AB-</option>
                        
             </select></td></tr>

			<tr><td align="right" >Alergico a:</td>
			<td><input type="text" name="alergico" value=""  onKeyUp="this.value=this.value.toUpperCase()" /></td></tr>
			
		   </td></tr></table>
			
			<input type="hidden" name="alumno_id" value="" />
			<input type="hidden" name="creado" value="0" />
			<input type="hidden" name="status" value="1" />
			<input type="hidden" name="cursando" value="0" />
			<input type="hidden" name="periodo_id" value="4" />
			<input type="hidden" name="jos_alumno_infocol" value="" />

		
					
			</fieldset>


				   
			<table class="zona_boton"><tr><td align="right"></td><tr><td><h3 align="center">Verifica todos los Datos antes de Continuar..</h3></td></tr><td><center><input class="texto_grande_gris" type="submit" name="buttom" value="Registrar >" /></center></td></tr>	</table>
		   <input type="hidden" name="MM_insert" value="form3">

		   </form>
		   <?php } // fin de la verificacion
		   ?>

	</div>

</td></tr></table>
</div>
 </div>

 <?php if ($totalRows_alumno == 0) { // Verificacion de datos 
 ?>
<script type="text/javascript">
<!--

var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "integer", {hint:"Ej. 13568420", validateOn:["blur"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {validateOn:["blur"]});

var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {validateOn:["blur"]});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {validateOn:["blur"]});
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "none", {validateOn:["blur"]});
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "integer", {hint:"Ej. 13568420", validateOn:["blur"]});
var sprytextfield17 = new Spry.Widget.ValidationTextField("sprytextfield17", "none", {validateOn:["blur"]});

var sprytextfield31 = new Spry.Widget.ValidationTextField("sprytextfield31", "none", {validateOn:["blur"]});
var sprytextfield33 = new Spry.Widget.ValidationTextField("sprytextfield33", "none", {validateOn:["blur"]});
var sprytextfield34 = new Spry.Widget.ValidationTextField("sprytextfield34", "none", {validateOn:["blur"]});
var sprytextfield36 = new Spry.Widget.ValidationTextField("sprytextfield36", "none", {validateOn:["blur"]});
var sprytextfield38 = new Spry.Widget.ValidationTextField("sprytextfield38", "none", {validateOn:["blur"]});
var sprytextfield39 = new Spry.Widget.ValidationTextField("sprytextfield39", "none", {validateOn:["blur"]});
var sprytextfield41 = new Spry.Widget.ValidationTextField("sprytextfield41", "none", {validateOn:["blur"]});


//-->




</script>
 <?php } ?>
</body>
</html>

<?php
mysql_free_result($alumno);
?>
