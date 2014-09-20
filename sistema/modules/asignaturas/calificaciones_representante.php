<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
// VALIDACION DE VERSION DE PHP
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
$query_confip = sprintf("SELECT * FROM jos_formato_evaluacion_confi");
$confip = mysql_query($query_confip, $sistemacol) or die(mysql_error());
$row_confip = mysql_fetch_assoc($confip);
$totalRows_confip = mysql_num_rows($confip);
$confi=$row_confip['codfor'];

$colname_alumno = "-1";
if (isset($_GET['abc'])) {
  $colname_alumno = $_GET['abc'];
}
$ced_alumno = "-1";
if (isset($_GET['us'])) {
  $ced_alumno = $_GET['us'];
}
mysql_select_db($database_sistemacol, $sistemacol);
if ($confi=="bol01"){
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_bol01 a, jos_asignatura b, jos_asignatura_nombre c WHERE a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND lapso = %s AND alumno_id = %s ORDER BY orden_asignatura ASC", GetSQLValueString($colname_alumno, "int"), GetSQLValueString($ced_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
}
if ($confi=="bol02"){
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_asignatura b, jos_asignatura_nombre c WHERE a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND lapso = %s AND alumno_id = %s ORDER BY orden_asignatura ASC", GetSQLValueString($colname_alumno, "int"), GetSQLValueString($ced_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
}
if ($confi=="nor01"){
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_nor01 a, jos_asignatura b, jos_asignatura_nombre c WHERE a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND lapso = %s AND alumno_id = %s ORDER BY orden_asignatura ASC", GetSQLValueString($colname_alumno, "int"), GetSQLValueString($ced_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
}
if ($confi=="nor02"){
$query_alumno = sprintf("SELECT * FROM jos_formato_evaluacion_nor02 a, jos_asignatura b, jos_asignatura_nombre c WHERE a.asignatura_id=b.id AND b.asignatura_nombre_id=c.id AND lapso = %s AND alumno_id = %s ORDER BY orden_asignatura ASC", GetSQLValueString($colname_alumno, "int"), GetSQLValueString($ced_alumno, "int"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
}

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

<?php if($totalRows_alumno>0){ ?>

<table>
<tr>
<td>
<?php if($_GET['abc']==2){?>
  
<a href="calificaciones_representante.php?abc=1&us=<?php echo $_GET['us'];?>"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;Ver Calificaciones del 1er Lapso</a>
<?php }?>
<?php if($_GET['abc']==3){?>
  
 <a href="calificaciones_representante.php?abc=1&us=<?php echo $_GET['us'];?>"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;Ver Calificaciones del 1er Lapso</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="calificaciones_representante.php?abc=2&us=<?php echo $_GET['us'];?>"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;Ver Calificaciones del 2do Lapso</a>

<?php }?>
</td>
</tr>
<tr>
<td valign="top" align="center" class="texto_pequeno_gris" ><h2>Reporte de Calificaciones de <?php echo $_GET['abc'];?> Lapso</h2>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006600" bordercolor="#000000" bordercolordark="#000000" class="fondo_tabla" id="marco_tabla">
              <tr bgcolor="#00FF99" class="texto_pequeno_gris">
                <td width="150" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">Asignaturas</span></div></td>
		<td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">N1-F1</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">A112</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">N2-F1</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">A112</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">N3-F1</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">A112</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">N4-F1</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">A112</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">N5-F1</span></div></td>
                <td width="15" class="texto_pequeno_gris"><div align="center"><span class="texto_pequeno_gris">A112</span></div></td>
              </tr>
<?php if (($confi=="bol01") or ($confi=="nor01") or ($confi=="nor02")){ // FORMATOS GENERTALES
?>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="20" class="textoVARIOS_eloy"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['nombre']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p1f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p1f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p2f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p2f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p3f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p3f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p4f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p4f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p5f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['p5f2']; ?></span></div></td>


                
              </tr>
              <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>
<?php }?>

<?php if ($confi=="bol02"){ //FORMATO LICEO MILITAR
?>
              <?php do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">
                <td height="20" class="textoVARIOS_eloy"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['nombre']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n1f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n1f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n2f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n2f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n3f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n3f2']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n4f1']; ?></span></div></td>
		<td height="20" class="textoVARIOS_eloy"  style="border-left:1px solid"><div align="center"><span class="texto_pequeno_gris"><?php echo $row_alumno['n4f2']; ?></span></div></td>


                
              </tr>
              <?php } while ($row_alumno = mysql_fetch_assoc($alumno)); ?>
<?php }?>
            </table>
<span class="texto_pequeno_gris">Sistema administrativo Colegionline</b></span>
<!--FIN INFO CONSULTA -->
</td>
          </tr>
	</table>

<?php }?>


<?php if($totalRows_alumno==0){ ?>

<?php if($_GET['abc']==1){?>
  <p>&nbsp;</p>
  <p><img src="../../images/png/product-big.png" width="64" height="64" /><br />
    <span class="texto_mediano_grande">No se han agregado <br />
      Calificaciones de <?php echo $_GET['abc']; ?> Lapso para este Estudiante...<br />
    </span></p>
<?php }?>

<?php if($_GET['abc']==2){?>
  
  <p><a href="calificaciones_representante.php?abc=1&us=<?php echo $_GET['us'];?>"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;Ver Calificaciones del 1er Lapso</a></p>
  <p><img src="../../images/png/product-big.png" width="64" height="64" /><br />
    <span class="texto_mediano_grande">No se han agregado <br />
     Calificaciones de <?php echo $_GET['abc']; ?> Lapso para este Estudiante...<br />
    </span></p>
<?php }?>

<?php if($_GET['abc']==3){?>
  
  <p><a href="calificaciones_representante.php?abc=1&us=<?php echo $_GET['us'];?>"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;Ver Calificaciones del 1er Lapso</a></p>
 <p><a href="calificaciones_representante.php?abc=2&us=<?php echo $_GET['us'];?>"><img src="../../images/png/back_f2.png" width="20" height="20" border="0" align="absmiddle">&nbsp;Ver Calificaciones del 2do Lapso</a></p>
  <p><img src="../../images/png/product-big.png" width="64" height="64" /><br />
    <span class="texto_mediano_grande">No se han agregado <br />
      Calificaciones de <?php echo $_GET['abc']; ?> Lapso para este Estudiante...<br />
    </span></p>
<?php }?>

<?php }?>
</div>
</body>
</center>
</html>
</html>
<?php
mysql_free_result($confip);

mysql_free_result($alumno);

?>
