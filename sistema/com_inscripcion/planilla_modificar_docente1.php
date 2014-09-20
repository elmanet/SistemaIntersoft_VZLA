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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {

   $updateSQL = sprintf("UPDATE jos_docente SET cedula_docente=%s, nombre_docente=%s, apellido_docente=%s, direccion_docente=%s, telefono_docente=%s WHERE id=%s",
							GetSQLValueString($_POST['cedula_docente'], "bigint"),
							GetSQLValueString($_POST['nombre_docente'], "text"),
							GetSQLValueString($_POST['apellido_docente'], "text"),
							GetSQLValueString($_POST['direccion_docente'], "text"),	
							GetSQLValueString($_POST['telefono_docente'], "text"),	
							GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());


  $updateGoTo = "planilla_modificar_docente2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];

  }
  header(sprintf("Location: %s", $updateGoTo));
}


// FIN DEL REGISTRO DE ESTUDIANTES 


$colname_docente = "-1";
if (isset($_GET['cedula'])) {
  $colname_docente = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_docente = sprintf("SELECT * FROM jos_docente WHERE cedula_docente = %s", GetSQLValueString($colname_docente, "text"));
$docente = mysql_query($query_docente, $sistemacol) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);

mysql_select_db($database_sistemacol, $sistemacol);
$query_periodo = sprintf("SELECT * FROM jos_periodo WHERE actual=1");
$periodo = mysql_query($query_periodo, $sistemacol) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  >


<head>
<title>::PLANILLA DE REGISTRO DE ESTUDIANTES</title>
<link href="../css/componentes.css" rel="stylesheet" type="text/css">

<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

</head>
<center>
<body >
<div id="contenedor">
	<div id="contenido">
		<h2 align="center">Modificar Datos del Docente</h2>
		<h5 align="center">Los campos son obligatorios (*)</h5>
		<?php if ($totalRows_docente == 0) { // Verificacion de datos 
		 ?> 
		 Error No Existen Datos!
		 <?php } ?>
		 <?php if ($totalRows_docente > 0) { // Verificacion de datos 
		 ?> 
		
<?php // INICIO DE REGISTRO DE DATOS DEL DOCENTE
?>			
<form action="<?php echo $editFormAction; ?>" name="form" id="form" method="POST" enctype="multipart/form-data" onKeyPress="return disableEnterKey(event)">				
			<fieldset class="marco">
		   <legend><strong><em>Datos del Docente</em></strong> </legend>
		   <table><tr><td>
			<tr><td align="right" width="190px">Nombre:*</td>
			<td><span id="sprytextfield4"><strong><input type="text" name="nombre_docente" value="<?php echo $row_docente['nombre_docente'];?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>
			
			<tr><td align="right" >Apellido:*</td>
			<td><span id="sprytextfield5"><strong><input type="text" name="apellido_docente" value="<?php echo $row_docente['apellido_docente'];?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>

			<tr><td align="right" >Direccion:*</td>
			<td><span id="sprytextfield6"><strong><input type="text" name="direccion_docente" value="<?php echo $row_docente['direccion_docente'];?>" size="50" onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>

			<tr><td align="right" >Telefono:*</td>
			<td><span id="sprytextfield7"><strong><input type="text" name="telefono_docente" value="<?php echo $row_docente['telefono_docente'];?>"  onKeyUp="this.value=this.value.toUpperCase()" /><span class="textfieldRequiredMsg">Se necesita un valor.</span></strong></span></td></tr>


<tr><td align="right" >C&eacute;dula:</td><td> <?php echo $_GET['cedula']; ?></td></tr>

			
		   </td></tr></table>
			
			<input type="hidden" name="id" value="<?php echo $row_docente['id'];?>" />
			<input type="hidden" name="cedula_docente" value="<?php echo $_GET['cedula']; ?>" />

			<input type="hidden" name="periodo" value="<?php echo $row_periodo['id']; ?>" />


		
					
			</fieldset>


				   
			<table class="zona_boton"><tr><td align="right"></td><tr><td><h3 align="center">Verifica todos los Datos antes de Continuar..</h3></td></tr><td><center><input class="texto_grande_gris" type="submit" name="buttom" value="Modificar >" /></center></td></tr>	</table>
<input type="hidden" name="MM_update" value="form">
		   </form>
		   <?php } // fin de la verificacion
		   ?>

	</div>
</td></tr></table>
</div>
 </div>

 <?php if ($totalRows_docente > 0) { // Verificacion de datos 
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

//-->




</script>
 <?php } ?>
</body>
</center>
</html>

<?php
mysql_free_result($docente);

mysql_free_result($periodo);
?>
