<?php require_once('../Connections/sistemacol.php'); ?>
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



// INICIO DE SQL DE REGISTRO DE  USUARIOS 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {

$pass=md5($_POST['password']);

// GRABADO EN LA TABLA DE USUARIOS

  $insertSQL = sprintf("INSERT INTO jos_users (id, name, username, email, password, usertype, block, sendEmail, gid, registerDate, lastvisitDate, activation, params ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($pass, "text"),
		       GetSQLValueString($_POST['usertype'], "text"),
		       GetSQLValueString($_POST['block'], "int"),
                       GetSQLValueString($_POST['sendEmail'], "int"),
                       GetSQLValueString($_POST['gid'], "int"),
                       GetSQLValueString($_POST['registerDate'], "datetime"),
                       GetSQLValueString($_POST['lastvisitDate'], "datetime"),
                       GetSQLValueString($_POST['activation'], "text"),
                       GetSQLValueString($_POST['params'], "text"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());
  
 
 header(sprintf("Location: %s", $insertGoTo));
}

// 	GRABADO EN LA TABLA CORE_ACL_ARO

mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = "SELECT * FROM jos_users ORDER BY id DESC";
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$value= $row_usuario['id'];


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {

   $insertSQL = sprintf("INSERT INTO jos_core_acl_aro (id, section_value, value, order_value, name, hidden ) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id, "int"),
                       GetSQLValueString($_POST['section_value'], "text"),
                       GetSQLValueString($value, "text"),
                       GetSQLValueString($_POST['order_value'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
							  GetSQLValueString($_POST['hidden'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

header(sprintf("Location: %s", $insertGoTo));
}



// 	GRABADO EN LA TABLA GROUPS_ARO_MAP

mysql_select_db($database_sistemacol, $sistemacol);
$query_grupo = "SELECT * FROM jos_core_acl_aro ORDER BY id DESC";
$grupo = mysql_query($query_grupo, $sistemacol) or die(mysql_error());
$row_grupo = mysql_fetch_assoc($grupo);
$totalRows_grupo = mysql_num_rows($grupo);

$id_aro= $row_grupo['id'];
$seccion_value=0;
$group_id=18;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {

   $insertSQL = sprintf("INSERT INTO jos_core_acl_groups_aro_map (group_id, section_value, aro_id) VALUES (%s, %s, %s)",
                       GetSQLValueString($group_id, "int"),
                       GetSQLValueString($seccion_value, "text"),
                       GetSQLValueString($id_aro, "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result3 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

 header(sprintf("Location: %s", $insertGoTo));
}

$email_docente=$_POST['email'];

// 	GRABADO EN LA TABLA JOS_COORDINADOR


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// corregir
$fecha_nac= $_POST['ano_nacimiento']."-".$_POST['mes_nacimiento']."-".$_POST['dia_nacimiento'];
//corregir

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {

   $insertSQL = sprintf("INSERT INTO jos_secretaria_coordinador (id, cedula_docente, nombre_docente, apellido_docente, direccion_docente, telefono_docente, email_docente, joomla_id, periodo, tipo_docente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['cedula_docente'], "bigint"),
							GetSQLValueString($_POST['nombre_docente'], "text"),
							GetSQLValueString($_POST['apellido_docente'], "text"),
							GetSQLValueString($_POST['direccion_docente'], "text"),	
							GetSQLValueString($_POST['telefono_docente'], "text"),	
							GetSQLValueString($email_docente, "text"),	
							GetSQLValueString($value, "int"),
							GetSQLValueString($_POST['periodo'], "text"),
							GetSQLValueString($_POST['tipo_docente'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "planilla_registro_coordinador2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}



// FIN DEL REGISTRO DE COORDINADORES


$colname_docente = "-1";
if (isset($_GET['cedula'])) {
  $colname_docente = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT * FROM jos_secretaria_coordinador WHERE cedula_docente = %s", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

$colname_users = "-1";
if (isset($_GET['cedula'])) {
  $colname_users = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = sprintf("SELECT * FROM jos_users WHERE username = %s", GetSQLValueString($colname_users, "text"));
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::PLANILLA DE REGISTRO DE COORDINADORES Y SECRETARIAS</title>
<link href="../css/componentes.css" rel="stylesheet" type="text/css">

<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />

</head>
<body >
<div id="contenedor">
	<div id="contenido">
		<h2 align="center">Planilla de Registro de Coordinadores</h2>
		<h5 align="center">Los campos son obligatorios (*)</h5>
		 <?php if ($totalRows_docente == 0) { // Verificacion de datos 
		if ($totalRows_users > 0) { ?>
<p align="center">
<img src="../images/png/atencion.png" height="" width="" alt="" align="middle"/>&nbsp;&nbsp;<br /><br /><b>Este usuario ya tiene cuenta Asignada en el Sistema:</b> <br /><span class="texto_mediano_gris">Los Docentes registrados que sean Coordinadores no hay que volverlos a registrar </span> 
</p>
		 <?php //<p style="color:red;">Para realizar cambios en el registro debes ingresar por el PANEL ADMINISTRATIVO</p>?><br /><br /><br />
		 <img src="../images/gif/1rrow4.gif" height="" width="" alt="" align="middle"/>&nbsp;&nbsp;<a href="../modules/acceso/index.php"  >Volver al Menu</a>&nbsp;-&nbsp; <img src="../images/png/usua1.png" height="" width="" alt="" align="middle"/><a href="planilla_verifica_coordinador.php"  >Otro Coordinador</a>
<?php } else { ?>

		   <h2 align="center">Crear cuenta de Usuario</h2>
			<img src="../images/gif/1rrow4.gif" height="" width="" alt="" align="middle"/>&nbsp;&nbsp;<a href="../modules/acceso/index.php"  >Volver al Menu</a>&nbsp;-&nbsp; <img src="../images/png/usua1.png" height="" width="" alt="" align="middle"/><a href="planilla_verifica_coordinador.php"  >Otro 
Coordinador</a>
			<?php // INICIO DE LA TABLA PARA EL FOMULARIO
			?> 	   
	<table><tr><td>		   
		   <form action="<?php echo $editFormAction; ?>" method="POST" name="form3">
		   <fieldset class="marco">
		   <legend><strong><em>Datos de la Cuenta</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px">Nombre:*</td>
			<td> <span id="sprytextfield1"><strong><input type="text" name="name" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right">login:*</td>
			<td><span id="sprytextfield2"><strong><input type="text" name="username" value="<?php echo $_GET['cedula']; ?>" readonly="readonly" />  Tu Login es la Cedula<span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>	
			
			<tr><td align="right">E-mail:*</td>
			<td><span id="sprytextfield3"><strong><input type="text" name="email" value="" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>	
			
			<tr><td align="right">Clave:*</td>
			<td><span id="sprypassword2"><label><input type="password" name="password" value="" id="clave" /></label><span class="passwordRequiredMsg">Se necesita un valor.</span><span class="passwordMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span></span></td></tr>
			
			<tr><td align="right">Confirmar clave:*</td>
			<td><span id="spryconfirm1"><label><input type="password" name="password2" id="confirma"  value=""/></label><span class="confirmRequiredMsg">Se necesita un valor.</span><span class="confirmInvalidMsg">Los valores no coinciden.</span></span></td></tr>
			
			</table>
			
			<input type="hidden" name="id" value="" />
			<input type="hidden" name="usertype" value="Author" />
			<input type="hidden" name="block" value="0" />
			<input type="hidden" name="sendEmail" value="0" />
			<input type="hidden" name="gid" value="50" />
			<input type="hidden" name="registerDate" value="0" />
			<input type="hidden" name="lastvisitDate" value="0" />
			<input type="hidden" name="activation"  value="0"/>
			<input type="hidden" name="params"  value="0" />
			<input type="hidden" name="section_value"  value="users" />
			<input type="hidden" name="order_value"  value="0" />
			<input type="hidden" name="hidden"  value="0" />
			
			</fieldset>	
			
<?php // INICIO DE REGISTRO DE DATOS DEL COORDINADOR
?>			
				
			<fieldset class="marco">
		   <legend><strong><em>Datos del Coordinador</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px">Nombre:*</td>
			<td><span id="sprytextfield4"><strong><input type="text" name="nombre_docente" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >Apellido:*</td>
			<td><span id="sprytextfield5"><strong><input type="text" name="apellido_docente" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>

			<tr><td align="right" >Direccion:*</td>
			<td><span id="sprytextfield6"><strong><input type="text" name="direccion_docente" value="" size="50" onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>

			<tr><td align="right" >Telefono:*</td>
			<td><span id="sprytextfield7"><strong><input type="text" name="telefono_docente" value=""  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>

<tr><td align="right" >Tipo de Usuario:</td><td>
<select name="tipo_docente" id="tipo_docente">
<option value="1">Coordinador</option>
<option value="2">Secretaria</option>
</select>
</td></tr>
<tr><td align="right" >Cédula:</td><td> <?php echo $_GET['cedula']; ?></td></tr>

			
		   </td></tr></table>
			
			<input type="hidden" name="id" value="" />
			<input type="hidden" name="cedula_docente" value="<?php echo $_GET['cedula']; ?>" />

			<input type="hidden" name="periodo" value="<?php echo $row_periodo['id']; ?>" />


		
					
			</fieldset>


				   
			<table class="zona_boton"><tr><td align="right"></td><tr><td><h3 align="center">Verifica todos los Datos antes de Continuar..</h3></td></tr><td><center><input class="texto_grande_gris" type="submit" name="buttom" value="Registrar >" /></center></td></tr>	</table>
		   <input type="hidden" name="MM_insert" value="form3">
		   </form>
		   <?php } // fin de la verificacion
		   ?>
<?php } else { ?>
		 <b>Usuario ya Registrado(a) como:</b> <?php echo $row_docente['nombre_docente']." ".$row_docente['apellido_docente'];?>
		 <?php //<p style="color:red;">Para realizar cambios en el registro debes ingresar por el PANEL ADMINISTRATIVO</p>?><br /><br /><br />
		 <img src="../images/gif/1rrow4.gif" height="" width="" alt="" align="middle"/>&nbsp;&nbsp;<a href="../modules/acceso/index.php"  >Volver al Menu</a>&nbsp;-&nbsp; <img src="../images/png/usua1.png" height="" width="" alt="" align="middle"/><a href="planilla_verifica_coordinador.php"  >Otro Coordinador</a>
		 <?php }?>

	</div>
</td></tr></table>
</div>
 </div>

 <?php if (($totalRows_docente == 0) and ($totalRows_users == 0)) { // Verificacion de datos 
 ?>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});

var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2", {validateOn:["blur"], minChars:6});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "clave", {validateOn:["blur"]});
//-->




</script>
 <?php } ?>

</body>
</html>

<?php
mysql_free_result($docente);

mysql_free_result($periodo);
?>
