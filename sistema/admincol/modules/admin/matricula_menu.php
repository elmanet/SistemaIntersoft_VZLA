<?php require_once('../inc/conexion.inc.php');

// INICIO DE BUSQUEDAS SQL
$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />
</head>
<center>
<body>
<div id="contenedor_central_modulo">
<?php if ($row_usuario['gid']==25) { // INICIO DE LA CONSULTA 
?>
<table width="400" border="0">
        <tr>
        <td class="titulo_extragrande_gris">MATRICULA</td>
      </tr>
      
		           
      <tr><td class="enlace"><b>Acciones del Modulo</b></td></tr>
   
      <tr><td height="20" valign="top"><a href="../error/error01.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Matrícula Inicial</a></td></tr>
      <tr><td height="20" valign="top"><a href="../error/error01.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Modificación de Matrícula</a></td></tr>
      <tr><td height="20" valign="top"><a href="../error/error01.php">
	<img src="../../images/gif/ic_menu_link.gif" border="0" align="absmiddle">Matrícula Actual</a></td></tr>

        <tr><td class="enlace">&nbsp;</td></tr>
      </tr>
      <tr>
        <td height="20" valign="top"></td>
      </tr>
      <tr>
        <td> <a href="<?php echo $logoutAction ?>" class="link_blanco">.</a></td>
     
  </tr>
</table>
<?php } //FIN DE LA CONSULTA 

?> 
</div>
</body>
</center>
</html>
<?php
mysql_free_result($usuario);
?>
