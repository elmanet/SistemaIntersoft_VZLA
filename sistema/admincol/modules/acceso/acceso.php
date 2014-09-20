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

mysql_select_db($database_sistemacol, $sistemacol);
$query_users = "SELECT * FROM jos_users";
$users = mysql_query($query_users, $sistemacol) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
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

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">
<link href="../../css/modules.css" rel="stylesheet" type="text/css">
</head>
<center>
    <body>
    <div id="marco_acceso">

        <div id="cuadro_info">
             <img src="../../images/<?php echo $row_colegio['logocol']; ?>"  height="180" width="160" border="0" align="absmiddle"/></br>
             <p class="titulo_extragrande_gris">Autentificación de Usuarios </br> Dpto. Administrativo, Evaluación y Contro de Estudio</p>
             <span class="resaltar"></span></b><br>  </span></br>
        <span class="texto_mediano_gris">SISTEMA ADMINISTRATIVO EDUCATIVO <br /> <b>COLEGIONLINE</b> <br /><br />Todos los derechos reservados 2011. INTERSOFT-latin</span>
        </div>

        <div id="cuadro">
                <form ACTION="<?php echo $loginFormAction; ?>" method="POST" enctype="multipart/form-data" target="_self" id="form1">
                <table width="90%">
                    <tr><td align="left"><h2 class="texto_grande_gris">Introduce tus <br />Datos.</h2></td></tr>
                <tr><td><div id="cuadro_mensaje" >
                            <span>  Esta área requiere una autentificación especial es sólo para Administradores del sistema. <b style="color:black"><span style="font-size:10px"><?php echo $row_colegio['nomcol']; ?></span>
                    </div></td></tr>
                    <tr><td align="left"><img src="../../images/icons/user.png" height="15" width="15" alt="" aling="middle" /> LOGIN O CEDULA:</td></tr>
                    <tr><td aling="left"><input type="text" name="username" size="15"  /></td></tr>
                    <tr>
                    <td align="left" ><img src="../../images/icons/key.png" height="15" width="15" alt="" aling="middle" />PASSWORD:</td></tr>
                    <tr>
                    <td aling="left"><input type="password" name="password" size="15" /></td>
                    </tr>
                    <tr>
                    <td></td>
                    <tr>
                    <td aling="left"><input type="submit" name="boton" value="Iniciar Sesion" /></td>
                    </tr>
                    <tr>
                    <td  align="left" ><a href="" class="texto_pequeno_gris">Olvido Clave?</a><img src="../../images/logito.png" align="absmiddle" style="padding-left:60px;"></td><td></td>

                    </tr>
                </table>
                </form>
        
        </div>
    </div>

</body>
</center>
</html>

<?php

mysql_free_result($colegio);
?>
