<?php require_once('../../Connections/sistemacol.php'); ?>
<?php
if (!isset($_SESSION)){
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../acceso/acceso.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

?>
<?php

//AUTORIZACION PARA ENTRAR A LA PAGINA

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../acceso/acceso_error2.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
// fin de la autorizacion
?>
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


$colname_reporte = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_reporte = $_GET['asignatura_id'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_reporte = sprintf("SELECT a.nombre as nomalum, a.apellido, a.cedula, a.alumno_id, c.nombre as anio, b.no_lista, e.descripcion, f.id as asig_id, g.nombre_docente, g.apellido_docente, h.nombre as mate FROM jos_alumno_info a, jos_alumno_curso b, jos_anio_nombre c, jos_curso d, jos_seccion e, jos_asignatura f, jos_docente g, jos_asignatura_nombre h WHERE a.alumno_id=b.alumno_id AND b.curso_id=d.id AND d.anio_id=c.id AND d.seccion_id=e.id AND f.curso_id=d.id AND f.docente_id=g.id AND f.asignatura_nombre_id=h.id AND f.id= %s" , GetSQLValueString($colname_reporte, "text"));
$reporte = mysql_query($query_reporte, $sistemacol) or die(mysql_error());
$row_reporte = mysql_fetch_assoc($reporte);
$totalRows_reporte = mysql_num_rows($reporte);

mysql_select_db($database_sistemacol, $sistemacol);
$query_colegio = sprintf("SELECT * FROM jos_institucion ");
$colegio = mysql_query($query_colegio, $sistemacol) or die(mysql_error());
$row_colegio = mysql_fetch_assoc($colegio);
$totalRows_colegio = mysql_num_rows($colegio);

$colname_planilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_planilla = $_GET['asignatura_id'];
}
$lap_planilla = "-1";
if (isset($_GET['lapso'])) {
  $lap_planilla = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planilla = sprintf("SELECT * FROM jos_formato_evaluacion_bol02 a, jos_alumno_info b WHERE a.alumno_id=b.alumno_id AND a.asignatura_id = %s AND a.lapso = %s ORDER BY b.apellido ASC", GetSQLValueString($colname_planilla, "int"), GetSQLValueString($lap_planilla, "int"));
$planilla = mysql_query($query_planilla, $sistemacol) or die(mysql_error());
$row_planilla = mysql_fetch_assoc($planilla);
$totalRows_planilla = mysql_num_rows($planilla);

//confiplanilla

$colname_confiplanilla = "-1";
if (isset($_GET['asignatura_id'])) {
  $colname_confiplanilla = $_GET['asignatura_id'];
}
$lap_confiplanilla = "-1";
if (isset($_GET['lapso'])) {
  $lap_confiplanilla = $_GET['lapso'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_confiplanilla = sprintf("SELECT * FROM jos_formato_evaluacion_planilla WHERE asignatura_id = %s AND lapso=%s ORDER BY id DESC", GetSQLValueString($colname_confiplanilla, "int"), GetSQLValueString($lap_confiplanilla, "int"));
$confiplanilla = mysql_query($query_confiplanilla, $sistemacol) or die(mysql_error());
$row_confiplanilla = mysql_fetch_assoc($confiplanilla);
$totalRows_confiplanilla = mysql_num_rows($confiplanilla);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css">

</head>
<center>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <!--DWLayoutTable-->
  <tr>
    <td valign="top">
    
    <?php if ($totalRows_reporte > 0) { // Show if recordset not empty ?>
    <?php if ($totalRows_planilla > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" >
          <tr><td height="100" valign="top">

<!--INFORMACION DEL COLEGIO -->
		<table class="ancho_tabla4de"><tr><td>
 	           <td height="100"  width="120" align="right" valign="middle"><img src="../../images/<?php echo $row_colegio['logocol']; ?>" width="100" height="100" align="absmiddle"></td>

            	<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="left">
                 	<tr>
                    		<td align="left" valign="bottom" style="font-size:25px"><?php echo $row_colegio['nomcol']; ?></td>
                	</tr>
                	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  	</tr>
                  	<tr>
                    		<td align="left" valign="top"><span class="texto_pequeno_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  	</tr>
                  </table>
              	</td>
		<td align="center" valign="middle"><div align="center">
            	  <table width="100%" border="0" align="right">
                 	<tr>
                    		<td align="left"><b>DISCIPLINA:</b> <?php echo $row_reporte['mate'];?> <b>DOCENTE:</b> <?php echo $row_reporte['apellido_docente']." ".$row_reporte['nombre_docente']; ?></td>

                	</tr>
			<tr>
                    		<td align="left"><b>PROYECTO:</b> <?php echo $row_confiplanilla['nombre_proyecto']; ?></td>

                	</tr>
			<tr>
                    		<td align="left"><b>PERIODO:</b> 2010-2011 <b>A&ntilde;O Y SECCION:</b> <?php echo $row_reporte['anio']." ".$row_reporte['descripcion']; ?></td>

                	</tr>
                  </table>
              	</td>
</td></tr></table>

</td>              
     </tr>     

<!--INFORMACION DE LA CONSULTA  -->
 <tr><td valign="top" align="center" class="texto_mediano_gris" ><h2>REGISTRO DE EVALUACION INTEGRAL DEL ESTUDIANTE </h2>


<table id="ancho_planilla_4deagosto" style="font-size:9px;" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#fff" bordercolor="#000000" bordercolordark="#000000" class="borde">
             
 <tr bgcolor="#00FF99" class="textogrande_eloy" >
		
		<tr>
		<td width="30" rowspan="5" ><div align="center"><span>No.</span></div></td>
                <td width="350" rowspan="5"><div align="center"><span>Apellidos y Nombres</span></div></td>
		</tr>


		<tr>
		<td colspan="6"><div align="left"><span>TEC. E INSTR: <?php echo $row_confiplanilla['info1']; ?></span></div></td>
		<td colspan="6"><div align="left"><span>TEC. E INSTR: <?php echo $row_confiplanilla['info2']; ?></span></div></td>
		<td colspan="6"><div align="left"><span>TEC. E INSTR: <?php echo $row_confiplanilla['info3']; ?></span></div></td>
		<td colspan="6"><div align="left"><span>TEC. E INSTR: <?php echo $row_confiplanilla['info4']; ?></span></div></td>
		<td width="30" rowspan="4"><div align="center"><span>CALPRO</span></div></td> 
		<td width="30" rowspan="4"><div align="center"><span>AJUSTE</span></div></td>
		<td width="30" rowspan="4"><div align="center"><span>DEF</span></div></td>
		</tr>  
		
		<tr>
		<td colspan="6"><div align="left"><span>FECHA: <?php echo $row_confiplanilla['fecha1']; ?></span></div></td>
		<td colspan="6"><div align="left"><span>FECHA: <?php echo $row_confiplanilla['fecha2']; ?></span></div></td>
		<td colspan="6"><div align="left"><span>FECHA: <?php echo $row_confiplanilla['fecha3']; ?></span></div></td>
		<td colspan="6"><div align="left"><span>FECHA: <?php echo $row_confiplanilla['fecha4']; ?></span></div></td>
		</tr>  

		<tr>
		<td colspan="4"><div align="center"><span>INDICADORES</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F1</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F2</span></div></td>		
		<td colspan="4"><div align="center"><span>INDICADORES</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F1</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F2</span></div></td>
		<td colspan="4"><div align="center"><span>INDICADORES</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F1</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F2</span></div></td>
		<td colspan="4"><div align="center"><span>INDICADORES</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F1</span></div></td>
                <td width="30" rowspan="2"><div align="center"><span>N1F2</span></div></td>

		</tr>              
		

		<tr>		
		<td width="30"><div align="center"><span>1</span></div></td>
                <td width="30"><div align="center"><span>2</span></div></td>
                <td width="30"><div align="center"><span>3</span></div></td>
                <td width="30"><div align="center"><span>4</span></div></td>
		<td width="30"><div align="center"><span>1</span></div></td>
                <td width="30"><div align="center"><span>2</span></div></td>
                <td width="30"><div align="center"><span>3</span></div></td>
                <td width="30"><div align="center"><span>4</span></div></td>
		<td width="30"><div align="center"><span>1</span></div></td>
                <td width="30"><div align="center"><span>2</span></div></td>
                <td width="30"><div align="center"><span>3</span></div></td>
                <td width="30"><div align="center"><span>4</span></div></td>
		<td width="30"><div align="center"><span>1</span></div></td>
                <td width="30"><div align="center"><span>2</span></div></td>
                <td width="30"><div align="center"><span>3</span></div></td>
                <td width="30"><div align="center"><span>4</span></div></td>
 
		</tr>
		
                
	
         
	
	</tr>
          

              <?php 
 		 $lista = 1;	
		do { ?>
              <tr bgcolor="#FFFFFF" class="titulosgrandes_eloy">

		<td style="border-left:1px solid"><div align="center"><span>&nbsp;<?php echo $lista; $lista ++; ?>&nbsp;</span></div></td>
                <td style="border-left:1px solid"><div align="left"><span>&nbsp;<?php echo $row_planilla['apellido'].", ".$row_planilla['nombre']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind11']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind12']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind13']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind14']; ?></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><b><?php echo $row_planilla['n1f1']; ?></b></span></div></td>
                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><?php echo $row_planilla['n1f2']; ?></span></div></td>



                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind21']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind22']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind23']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind24']; ?></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><b><?php echo $row_planilla['n2f1']; ?></b></span></div></td>
                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><?php echo $row_planilla['n2f2']; ?></span></div></td>



                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind31']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind32']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind33']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind34']; ?></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><b><?php echo $row_planilla['n3f1']; ?></b></span></div></td>
                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><?php echo $row_planilla['n3f2']; ?></span></div></td>




                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind41']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind42']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind43']; ?></span></div></td>
                <td style="border-left:1px solid"><div align="center"><span><?php echo $row_planilla['ind44']; ?></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><b><?php echo $row_planilla['n4f1']; ?></b></span></div></td>
                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><?php echo $row_planilla['n4f2']; ?></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><b><?php if ($row_planilla['calpro']<10 and $row_planilla['calpro']>0){ echo "0".$row_planilla['calpro'];} if ($row_planilla['calpro']>=10){ echo $row_planilla['calpro'];} if ($row_planilla['calpro']==0){ echo "NP";} ?></b></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><?php echo $row_planilla['ajuste']; ?></span></div></td>

                <td style="border-left:1px solid; background-color:#FFFCCC;"><div align="center"><span><b><?php if ($row_planilla['def']<10 and $row_planilla['def']>0){ echo "0".$row_planilla['def'];} if ($row_planilla['def']>=10){ echo $row_planilla['def'];} if ($row_planilla['def']==0){ echo "";} ?></b></span></div></td>



                
              </tr>
              <?php } while ($row_planilla = mysql_fetch_assoc($planilla)); ?>



            </table>



<span class="texto_pequeno_gris">Sistema administrativo Colegionline para: <b><?php echo $row_colegio['webcol'];?></b></span>
<tr><td align="center"><span class="texto_mediano_gris">DOCENTE 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 JEFE DEL DPTO. DE EVALUACION</span></td</tr>
<!--FIN INFO CONSULTA -->
</td>

          </tr>
	</table>
		<?php } // Show if recordset empty ?>
		<?php if ($totalRows_planilla == 0) { // Show if recordset empty ?>
	<table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
		 <span class="titulo_grande_gris">No han cargado Calificaciones de <?php echo $_POST['lapso']; ?> Lapso para esta Asignatura.</span><span class="texto_mediano_gris"><br>
  <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
        </table>
		<?php } // Show if recordset empty ?>

	<?php } // Show if recordset empty ?>
        
<?php if ($totalRows_reporte == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/png/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">Error... no existen registros en esta area</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
    <tr><td>    </td>
</tr>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($reporte);

mysql_free_result($colegio);

mysql_free_result($planilla);

mysql_free_result($confiplanilla);
?>
