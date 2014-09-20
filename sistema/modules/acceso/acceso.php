<?php require_once('../inc/conexion_sinsesion.inc.php');
mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_users";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {


if(@session_start() == false){session_destroy();session_start();}else {
session_start();
}
   $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=md5($_POST['password']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "acceso_error.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_sistemacol, $sistemacol);
  
  $LoginRS__query=sprintf("SELECT username, password FROM jos_users WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $sistemacol) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php

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
<link rel="shortcut icon" href="../../images/favicon.ico">
<?php require_once('../inc/validate.inc.php'); ?>
<!--
 <script type="text/javascript" src="captcha.js"></script>
 -->
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
<div id="div_acceso">
	<br />
	<br />
	<br />
  <p class="titulo_extragrande_gris">Autentificaci&oacute;n de Usuarios</p>
  <form ACTION="<?php echo $loginFormAction; ?>" id="captchaform" method="POST" enctype="multipart/form-data" target="_self" class="cmxform" id="captchaform" >
  <table width="90%">	
  	<!-- <tr>
	
	<td align="right"><div id="captchaimage" style="border:1px solid; width:135px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>" id="refreshimg" title="Click to refresh image"><img src="images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image" /></a></div></td>
 	<td  aling="left"><input type="text" maxlength="6" size="15" name="captcha" id="captcha" class="text_input"/></td>	
	</tr>	
		<tr><td><br /></td></tr> -->
	<tr>
	<td align="right"><img src="../../images/icons/user.png" height="15" width="15" alt="" aling="middle" /> Login:</td>
	<td aling="left"><input type="text" name="username" size="15" class="text_input"  /></td>
	</tr>
	<tr>
	<td align="right"><img src="../../images/icons/key.png" height="15" width="15" alt="" aling="middle" />Clave:</td>
	<td aling="left"><input type="password" name="password" size="15" class="text_input"/></td>
	</tr>


	
	<tr>
	<td> </td>
	<td aling="left"><input type="submit" name="submit" value="Iniciar Sesion" class="texto_grande_gris"  /></td>
	</tr>
	<tr>
	<!--  <td id="notas" colspan="2" ><a href="">Olvido Clave?</a></td> -->
	</tr>
</table>
</form> 
 </div>
 <br />
 <br />
<br />
<br />
<br />
 <table><tr><td>
 <div style="float:left;"><img src="../../images/pngnew/jabber-icono-3920-96.png"  alt="" aling="middle" /></div>
 <div >  <span class="resaltar">Esta area requiere una autentificaci&oacute;n especial es s&oacute;lo para Estudiantes, Docentes y Personal de la Instituci&oacute;n Educativa!<br>  </span>
  <b style="color:black">Puedes ingresar al area privada con tu Login o no. de C&eacute;dula y tu clave de acceso para ingresar el Sistema</b> 
  </div> 
  </td></tr></table> 
 	<br />
		<br />
			<br />
			<!--	<br />
				<span class="texto_pequeno_gris">| <a href="http://www.intersoftlatin.com/index.php/quienes-somos" target="_blank">Quienes Somos?</a></span><span class="texto_pequeno_gris"> | <a href="http://www.intersoftlatin.com/index.php/contacto" target="_blank">Contactanos</a> |</span>
				<br />
				<span class="texto_pequeno_gris"> Todos los derechos reservados 2002 - 2012 &copy; INTERSOFT-latin</span>
				<br />
				<br />-->
				<br />
				<?php require_once('../inc/barra_publicidad.inc.php'); ?>
</body>

</center>
</html>