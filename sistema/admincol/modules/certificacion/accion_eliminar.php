<?php require_once('../inc/conexion.inc.php');

// ELIMINAR ASIGNATURAS NORMALES

if ((isset($_GET['mate_id'])) && ($_GET['mate_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM jos_cdc_pensum_asignaturas WHERE id=%s",
                       GetSQLValueString($_GET['mate_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($deleteSQL, $sistemacol) or die(mysql_error());
  $deleteGoTo = "pensum_materias.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $deleteGoTo));

}

// ELIMINAR ASIGNATURAS EPT

if ((isset($_GET['mate_ept_id'])) && ($_GET['mate_ept_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM jos_cdc_pensum_asignaturas_ept WHERE id=%s",
                       GetSQLValueString($_GET['mate_ept_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($deleteSQL, $sistemacol) or die(mysql_error());
  $deleteGoTo = "pensum_materias_ept.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $deleteGoTo));

}

// ELIMINAR PLANTELES

if ((isset($_GET['plantel_id'])) && ($_GET['plantel_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM jos_cdc_nombre_plantel WHERE id=%s",
                       GetSQLValueString($_GET['plantel_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($deleteSQL, $sistemacol) or die(mysql_error());
  $deleteGoTo = "planteles.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $deleteGoTo));

}

// ELIMINAR LOCALIDAD

if ((isset($_GET['localidad_id'])) && ($_GET['localidad_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM jos_cdc_localidad WHERE id=%s",
                       GetSQLValueString($_GET['localidad_id'], "int"));

  mysql_select_db($database_sistemacol, $sistemacol);
  $Result1 = mysql_query($deleteSQL, $sistemacol) or die(mysql_error());
  $deleteGoTo = "localidad.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $deleteGoTo));

}




// FIN DE LA CONSULTA SQL 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1, utf-8" />
<title>:: SISTEMA COLEGIONLINE ::</title>
<link href="../../css/main_central.css" rel="stylesheet" type="text/css" />
<link href="../../css/modules.css" rel="stylesheet" type="text/css" />

</head>

<body>

</body>

</html>

