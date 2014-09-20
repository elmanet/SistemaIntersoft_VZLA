<?php require_once('../inc/conexion.inc.php');

// 	GRABADO EN LA TABLA DE ALUMNO_CURSO

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {

   $updateSQL = sprintf("UPDATE jos_cdc_titulos_margen  SET m1t=%s, m1l=%s, m2t=%s, m2l=%s, m3t=%s, m3l=%s, m4t=%s, m4l=%s, m5t=%s, m5l=%s, m6t=%s, m6l=%s, m7t=%s, m7l=%s, m8t=%s, m8l=%s, m9t=%s, m9l=%s, m10t=%s, m10l=%s, m11t=%s, m11l=%s, m12t=%s, m12l=%s, m13t=%s, m13l=%s, m14t=%s, m14l=%s, m15t=%s, m15l=%s, m16t=%s, m16l=%s WHERE id=%s",
                       GetSQLValueString($_POST['m1t'], "double"),
                       GetSQLValueString($_POST['m1l'], "double"),
                       GetSQLValueString($_POST['m2t'], "double"),
                       GetSQLValueString($_POST['m2l'], "double"),
                       GetSQLValueString($_POST['m3t'], "double"),
                       GetSQLValueString($_POST['m3l'], "double"),
                       GetSQLValueString($_POST['m4t'], "double"),
                       GetSQLValueString($_POST['m4l'], "double"),
                       GetSQLValueString($_POST['m5t'], "double"),
                       GetSQLValueString($_POST['m5l'], "double"),
                       GetSQLValueString($_POST['m6t'], "double"),
                       GetSQLValueString($_POST['m6l'], "double"),
                       GetSQLValueString($_POST['m7t'], "double"),
                       GetSQLValueString($_POST['m7l'], "double"),
                       GetSQLValueString($_POST['m8t'], "double"),
                       GetSQLValueString($_POST['m8l'], "double"),
                       GetSQLValueString($_POST['m9t'], "double"),
                       GetSQLValueString($_POST['m9l'], "double"),
                       GetSQLValueString($_POST['m10t'], "double"),
                       GetSQLValueString($_POST['m10l'], "double"),
                       GetSQLValueString($_POST['m11t'], "double"),
                       GetSQLValueString($_POST['m11l'], "double"),
                       GetSQLValueString($_POST['m12t'], "double"),
                       GetSQLValueString($_POST['m12l'], "double"),
                       GetSQLValueString($_POST['m13t'], "double"),
                       GetSQLValueString($_POST['m13l'], "double"),
                       GetSQLValueString($_POST['m14t'], "double"),
                       GetSQLValueString($_POST['m14l'], "double"),
                       GetSQLValueString($_POST['m15t'], "double"),
                       GetSQLValueString($_POST['m15l'], "double"),
                       GetSQLValueString($_POST['m16t'], "double"),
                       GetSQLValueString($_POST['m16l'], "double"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result2 = mysql_query($updateSQL, $sistemacol) or die(mysql_error());
 

 $updateGoTo = "imprimir_margen_titulo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}

header(sprintf("Location: %s", $updateGoTo));
}


// CONSULTA SQL

mysql_select_db($database_sistemacol, $sistemacol);
$query_margentitulo = sprintf("SELECT * FROM jos_cdc_titulos_margen");
$margentitulo = mysql_query($query_margentitulo, $sistemacol) or die(mysql_error());
$row_margentitulo = mysql_fetch_assoc($margentitulo);
$totalRows_margentitulo = mysql_num_rows($margentitulo);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<head>

<title>INTERSOFT | Software Educativo</title>

<link rel="shortcut icon" href="../../images/favicon.ico">
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

 
 
</head>
<center>
<body style="background:url('../../images/fon_logo.jpg');font-family:verdana;font-size:10px;">

<!-- INICIO DEL CONTENEDOR PRINCIPAL -->

<table width="760" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top" style="text-align:center;"><h2>Cambiar Margenes del T&iacute;tulo</h2></td></tr>
	<tr>	
	<td>
	<form action="<?php echo $editFormAction; ?>" method="POST" name="form">   
   <table>
   <tr>
		<td style="text-align:right;"><b>Plantel:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m1t" value="<?php echo $row_margentitulo['m1t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m1l" value="<?php echo $row_margentitulo['m1l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>C&oacute;digo:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m2t" value="<?php echo $row_margentitulo['m2t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m2l" value="<?php echo $row_margentitulo['m2l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Menci&oacute;n Titulo:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m3t" value="<?php echo $row_margentitulo['m3t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m3l" value="<?php echo $row_margentitulo['m3l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
 
   <tr>
		<td style="text-align:right;"><b>Plan:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m4t" value="<?php echo $row_margentitulo['m4t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda:<input type="text" name="m4l" value="<?php echo $row_margentitulo['m4l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
 
   <tr>
		<td style="text-align:right;"><b>Nombre del Estudiante:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m5t" value="<?php echo $row_margentitulo['m5t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m5l" value="<?php echo $row_margentitulo['m5l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>C&eacute;dula Estudiante:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m6t" value="<?php echo $row_margentitulo['m6t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m6l" value="<?php echo $row_margentitulo['m6l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Lugar de Nacimiento:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m7t" value="<?php echo $row_margentitulo['m7t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m7l" value="<?php echo $row_margentitulo['m7l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Fecha Nacimiento:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m8t" value="<?php echo $row_margentitulo['m8t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m8l" value="<?php echo $row_margentitulo['m8l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Lugar y Fecha del T&iacute;tulo:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m9t" value="<?php echo $row_margentitulo['m9t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m9l" value="<?php echo $row_margentitulo['m9l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>A&ntilde;o de Egreso:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m10t" value="<?php echo $row_margentitulo['m10t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m10l" value="<?php echo $row_margentitulo['m10l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Nombre Firma 1:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m11t" value="<?php echo $row_margentitulo['m11t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m11l" value="<?php echo $row_margentitulo['m11l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>C&eacute;dula Firma 1:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m12t" value="<?php echo $row_margentitulo['m12t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m12l" value="<?php echo $row_margentitulo['m12l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Nombre Firma 2:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m13t" value="<?php echo $row_margentitulo['m13t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m13l" value="<?php echo $row_margentitulo['m13l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>C&eacute;dula Firma 2:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m14t" value="<?php echo $row_margentitulo['m14t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m14l" value="<?php echo $row_margentitulo['m14l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>Nombre Firma 3:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m15t" value="<?php echo $row_margentitulo['m15t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m15l" value="<?php echo $row_margentitulo['m15l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   <tr>
		<td style="text-align:right;"><b>C&eacute;dula Firma 3:</b></td>
		<td>&nbsp;&nbsp;Arriba:<input type="text" name="m16t" value="<?php echo $row_margentitulo['m16t']; ?>" size="4" maxlength="5"/> cm</td>
		<td>&nbsp;&nbsp;Izquierda: <input type="text" name="m16l" value="<?php echo $row_margentitulo['m16l']; ?>" size="4" maxlength="5"/> cm</td>   
   </tr>
   
   
   <tr>
     <td colspan="3" style="text-align:right;"><input type="submit" name="buttom" value="Guardar Margen >" class="texto_grande_gris" /></td>   
   </tr>
   
   </table>
	<input type="hidden" name="id" value="<?php echo $row_margentitulo['id']; ?>" />
	<input type="hidden" name="MM_insert" value="form">
	</form>
	<center><small>SISTEMA INTERSOFT | Software Educativo. Todos los derechos reservados &copy; 2013</small></center>
	</td>
	</tr>
</table>

<!--
 <div id="contenedor"> 

		<div id="plantel"><?php echo $row_users['nombre_plantel'];?></div>
		<div id="codigo"><?php echo $row_users['cod_plantel'];?></div>
		<div id="titulo"><?php echo $_POST['titulo'];?></div>
		<div id="plan"><?php echo $row_planestudio['cod'];?></div>
		
		<div id="alumno"><?php echo $row_alumno['nombre']." ".$row_alumno['apellido'];?></div>
		<div id="cedula"><?php echo $row_alumno['indicador_nacionalidad']."-".$row_alumno['cedula'];?></div>
		<div id="lugarn"><?php if($_POST['estado']==1){ echo $row_alumno['lugar_nacimiento']."  ESTADO ".$row_alumno['estado'];}if($_POST['estado']==2){ echo $row_alumno['lugar_nacimiento']." ".$row_alumno['estado'];}?></div>
		<div id="fechan"><?php echo $dia." DE ".$mesl." DE ".$anio; ?></div>
		<div id="lugarf"><?php echo $_POST['fechaex'];?></div>
		<div id="egreso"><?php echo $_POST['egreso'];?></div>
		
		<div id="nombredz"><?php echo $_POST['nombredz'];?></div>
		<div id="ceduladz"><?php echo $_POST['ceduladz'];?></div>
		<div id="nombrece"><?php echo $_POST['nombrece'];?></div>
		<div id="cedulace"><?php echo $_POST['cedulace'];?></div>
		<div id="funcionario"><?php echo $_POST['funcionario'];?></div>
		<div id="cedulaf"><?php echo $_POST['cedulaf'];?></div>
    
 </div>
 -->
</body>

</center>
</html>
