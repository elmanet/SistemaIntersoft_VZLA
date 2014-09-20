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
$query_colegio = "SELECT * FROM sis_institucion";
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $row_colegio['tituloweb']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/main_central.css" rel="stylesheet" type="text/css">
</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td align="center" valign="top"><span class="titulo_periodico"><img src="../images/png/add_user.png" width="128" height="128"><br>
      REGISTRO EXITOSO!</span><br>
      <span class="texto_grande_gris">Imprimir Planilla de Inscripci&oacute;n</span><br>
      <br>
      <form action="inscripcion_formal1_planilla4.php" method="get" name="form1" target="_blank">
        <label>
          <input name="cedula" type="hidden" id="cedula" value="<?php echo $_GET['cedula']; ?>">
          <input name="button" type="submit" class="texto_mediano_grande" id="button" value="Imprimir Planilla &gt;&gt;">
        </label>
        <br>
        <br>
        <span class="texto_mediano_gris">Imprima la planilla en tama&ntilde;o carta y aseg&uacute;rese que est&eacute; de forma vertical </span>
      </form>
    <tr><td></td>
    
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($colegio);
?>
