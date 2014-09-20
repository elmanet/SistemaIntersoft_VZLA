<?php require_once('../inc/conexion.inc.php');


// CONSULTA SQL
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_institucion";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

$colname_inscripcion = "-1";
if (isset($_POST['ced_alumno'])) {
  $colname_inscripcion = $_POST['ced_alumno'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inscripcion = sprintf("SELECT * FROM jos_alumno_preinscripcion WHERE ced_alumno = %s", GetSQLValueString($colname_inscripcion, "text"));
$inscripcion = mysql_query($query_inscripcion, $sistemacol) or die(mysql_error());
$row_inscripcion = mysql_fetch_assoc($inscripcion);
$totalRows_inscripcion = mysql_num_rows($inscripcion);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {

  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {

   $insertSQL = sprintf("INSERT INTO jos_alumno_preinscripcion (id, ced_alumno, aceptado) VALUES (%s, %s, %s)",
							GetSQLValueString($_POST['id'], "int"),
							GetSQLValueString($_POST['ced_alumno'], "bigint"),
							GetSQLValueString($_POST['aceptado'], "int"));


  mysql_select_db($database_sistemacol, $sistemacol);
  $Result4 = mysql_query($insertSQL, $sistemacol) or die(mysql_error());

  $insertGoTo = "autorizar_inscripcion3.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
}
 
 header(sprintf("Location: %s", $insertGoTo));
}


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
<br />
<br />
<h2 style="font-family:verdana; text-shadow: black 0em 0.1em 0.1em ">Autorizar Inscripci&oacute;n</h2>
<div id="div_acceso">

<?php if($totalRows_inscripcion==0) { ?>	
  
<small style="font-family:verdana;color:red;">C&eacute;dula Verificada para Autorizaci&oacute;n</small>
 <form action="<?php echo $editFormAction; ?>" name="form3" id="captchaform" onsubmit="return checkSubmit();" method="POST" enctype="multipart/form-data" target="_self" class="cmxform" >
 		<table>
		<tr>
			<td align="right"><label> C&eacute;dula: </label></td>
			<td>

			<input class="text_input_peq" style="width:180px;" type="text" id="ced_alumno" name="ced_alumno" value="<?php echo $_POST['ced_alumno']; ?>" readonly="readonly"/>&nbsp;&nbsp;<input type="submit" name="submit" id="btsubmit" value="Autorizar" class="texto_grande_gris"  /></div></td>
						
	
		<tr>
		
		<td colspan="2" align="center"><br /><small>Sistema Intersoft | Software Educativo &copy; <?php echo date('Y');?></small></td>
		</tr>

 		</table>
    
		<input type="hidden" name="id" value="" />
		<input type="hidden" name="aceptado" value="1" />
	 <input type="hidden" name="MM_insert" value="form3">
</form>  

<?php }else{ ?>
<div style="color:red; background-color:#fffccc; border:1px solid; padding: 5 5 5 5; border-radius: 8px 8px 8px 8px; -moz-border-radius: 8px; box-shadow: 0 0 4px rgba(0, 0, 0, 0.4); font-size:12px;">
				<h1> <img src="../../images/png/Atencion.png" alt="" width="100" align="middle" >C&eacute;dula YA REGISTRADA!</h1>				
			<center><h3> Volver Atras --> <a href="autorizar_inscripcion1.php"/>AQUI</a></h3></center></div>
<?php }?>
  <br />
  <br />
  <br />

 </div>
	
</body>

</center>
</html>
