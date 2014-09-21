<?php require_once('../inc/conexion.inc.php');

// CONSULTA SQL

$colname_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario = $_SESSION['MM_Username'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_usuario = sprintf("SELECT username, password, gid FROM jos_users WHERE username = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysql_query($query_usuario, $sistemacol) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

$pass_supervisor = "-1";
if (isset($_POST['pass'])) {
  $pass_supervisor = $_POST['pass'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_supervisor = sprintf("SELECT * FROM jos_users_supervisor a, jos_users b WHERE a.user_id=b.id AND a.pass= %s", GetSQLValueString($pass_supervisor, "text"));
$supervisor = mysql_query($query_supervisor, $sistemacol) or die(mysql_error());
$row_supervisor = mysql_fetch_assoc($supervisor);
$totalRows_supervisor = mysql_num_rows($supervisor);

$colname_planestudio = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_planestudio = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_planestudio = sprintf("SELECT * FROM jos_cdc_planestudio WHERE id=%s", GetSQLValueString($colname_planestudio, "int"));
$planestudio = mysql_query($query_planestudio, $sistemacol) or die(mysql_error());
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);

mysql_select_db($database_sistemacol, $sistemacol);
$query_institucion = sprintf("SELECT * FROM jos_cdc_institucion");
$institucion = mysql_query($query_institucion, $sistemacol) or die(mysql_error());
$row_institucion = mysql_fetch_assoc($institucion);
$totalRows_institucion = mysql_num_rows($institucion);

// SELECCIONAR ESTUDIANTE
$colname_alumno1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $colname_alumno1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno1 = sprintf("SELECT * FROM jos_cdc_estudiante WHERE cedula = %s", GetSQLValueString($colname_alumno1, "bigint"));
$alumno1 = mysql_query($query_alumno1, $sistemacol) or die(mysql_error());
$row_alumno1 = mysql_fetch_assoc($alumno1);
$totalRows_alumno1 = mysql_num_rows($alumno1);

$colname_alumno2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $colname_alumno2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno2 = sprintf("SELECT * FROM jos_alumno_info WHERE cedula = %s", GetSQLValueString($colname_alumno2, "bigint"));
$alumno2 = mysql_query($query_alumno2, $sistemacol) or die(mysql_error());
$row_alumno2 = mysql_fetch_assoc($alumno2);
$totalRows_alumno2 = mysql_num_rows($alumno2);

// TRABAJANDO EN ESTE MODULO ****************************************************
if(($totalRows_alumno1>0)and($totalRows_alumno2>0)) {
$colname_alumno = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $colname_alumno = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT b.nombre as nombre_alumno, b.apellido as apellido_alumno, b.indicador_nacionalidad, b.fecha_nacimiento, b.lugar_nacimiento, b.estado as ent_federal_pais, b.cedula FROM jos_cdc_estudiante a, jos_alumno_info b WHERE a.cedula=b.cedula AND b.cedula = %s", GetSQLValueString($colname_alumno, "bigint"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
}

if(($totalRows_alumno1>0)and($totalRows_alumno2==0)) {
$colname_alumno = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $colname_alumno = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_alumno = sprintf("SELECT * FROM jos_cdc_estudiante WHERE cedula = %s", GetSQLValueString($colname_alumno, "bigint"));
$alumno = mysql_query($query_alumno, $sistemacol) or die(mysql_error());
$row_alumno = mysql_fetch_assoc($alumno);
$totalRows_alumno = mysql_num_rows($alumno);
}



// MATERIAS DE EPT
$colname_nota_ept1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept1 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept1, "int"), GetSQLValueString($alumno_nota_ept1, "bigint"));
$nota_ept1 = mysql_query($query_nota_ept1, $sistemacol) or die(mysql_error());
$row_nota_ept1 = mysql_fetch_assoc($nota_ept1);
$totalRows_nota_ept1 = mysql_num_rows($nota_ept1);

$colname_nota_ept2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept2 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept2, "int"), GetSQLValueString($alumno_nota_ept2, "bigint"));
$nota_ept2 = mysql_query($query_nota_ept2, $sistemacol) or die(mysql_error());
$row_nota_ept2 = mysql_fetch_assoc($nota_ept2);
$totalRows_nota_ept2 = mysql_num_rows($nota_ept2);

$colname_nota_ept3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept3 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept3, "int"), GetSQLValueString($alumno_nota_ept3, "bigint"));
$nota_ept3 = mysql_query($query_nota_ept3, $sistemacol) or die(mysql_error());
$row_nota_ept3 = mysql_fetch_assoc($nota_ept3);
$totalRows_nota_ept3 = mysql_num_rows($nota_ept3);

$colname_nota_ept4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept4 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept4, "int"), GetSQLValueString($alumno_nota_ept4, "bigint"));
$nota_ept4 = mysql_query($query_nota_ept4, $sistemacol) or die(mysql_error());
$row_nota_ept4 = mysql_fetch_assoc($nota_ept4);
$totalRows_nota_ept4 = mysql_num_rows($nota_ept4);

$colname_nota_ept5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept5 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept5, "int"), GetSQLValueString($alumno_nota_ept5, "bigint"));
$nota_ept5 = mysql_query($query_nota_ept5, $sistemacol) or die(mysql_error());
$row_nota_ept5 = mysql_fetch_assoc($nota_ept5);
$totalRows_nota_ept5 = mysql_num_rows($nota_ept5);

$colname_nota_ept6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept6 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept6, "int"), GetSQLValueString($alumno_nota_ept6, "bigint"));
$nota_ept6 = mysql_query($query_nota_ept6, $sistemacol) or die(mysql_error());
$row_nota_ept6 = mysql_fetch_assoc($nota_ept6);
$totalRows_nota_ept6 = mysql_num_rows($nota_ept6);

$colname_nota_ept7 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept7 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept7 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept7 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept7 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept7, "int"), GetSQLValueString($alumno_nota_ept7, "bigint"));
$nota_ept7 = mysql_query($query_nota_ept7, $sistemacol) or die(mysql_error());
$row_nota_ept7 = mysql_fetch_assoc($nota_ept7);
$totalRows_nota_ept7 = mysql_num_rows($nota_ept7);

$colname_nota_ept8 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept8 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept8 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept8 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept8 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept8, "int"), GetSQLValueString($alumno_nota_ept8, "bigint"));
$nota_ept8 = mysql_query($query_nota_ept8, $sistemacol) or die(mysql_error());
$row_nota_ept8 = mysql_fetch_assoc($nota_ept8);
$totalRows_nota_ept8 = mysql_num_rows($nota_ept8);

$colname_nota_ept9 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept9 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept9 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept9 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept9 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept9, "int"), GetSQLValueString($alumno_nota_ept9, "bigint"));
$nota_ept9 = mysql_query($query_nota_ept9, $sistemacol) or die(mysql_error());
$row_nota_ept9 = mysql_fetch_assoc($nota_ept9);
$totalRows_nota_ept9 = mysql_num_rows($nota_ept9);

$colname_nota_ept10 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota_ept10 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota_ept10 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota_ept10 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota_ept10 = sprintf("SELECT * FROM jos_cdc_ept_cursadas a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas_ept d, jos_cdc_estudiante e WHERE a.asignatura_ept_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND a.no_orden=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota_ept10, "int"), GetSQLValueString($alumno_nota_ept10, "bigint"));
$nota_ept10 = mysql_query($query_nota_ept10, $sistemacol) or die(mysql_error());
$row_nota_ept10 = mysql_fetch_assoc($nota_ept10);
$totalRows_nota_ept10 = mysql_num_rows($nota_ept10);

// OBSERVACIONES
$colname_observa = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_observa = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_observa = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_observa = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_observa = sprintf("SELECT * FROM jos_cdc_observaciones a, jos_cdc_planestudio b, jos_cdc_estudiante c WHERE a.planestudio_id=b.id AND a.alumno_id=c.id AND b.id=%s AND c.cedula=%s", GetSQLValueString($colname_observa, "int"), GetSQLValueString($alumno_observa, "bigint"));
$observa = mysql_query($query_observa, $sistemacol) or die(mysql_error());
$row_observa = mysql_fetch_assoc($observa);
$totalRows_observa = mysql_num_rows($observa);


//consultar la existencia de planteles asociados a estudiante
$colname_plantelcurso1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_plantelcurso1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_plantelcurso1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_plantelcurso1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantelcurso1 = sprintf("SELECT * FROM jos_cdc_plantelcurso a, jos_cdc_estudiante b, jos_cdc_nombre_plantel c, jos_cdc_planestudio d, jos_cdc_localidad e WHERE a.alumno_id=b.id AND a.nombre_plantel_id=c.id AND a.planestudio_id=d.id AND a.localidad_id=e.id AND a.no=1 AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no ASC", GetSQLValueString($colname_plantelcurso1, "int"), GetSQLValueString($alumno_plantelcurso1, "bigint"));
$plantelcurso1 = mysql_query($query_plantelcurso1, $sistemacol) or die(mysql_error());
$row_plantelcurso1 = mysql_fetch_assoc($plantelcurso1);
$totalRows_plantelcurso1 = mysql_num_rows($plantelcurso1);

$colname_plantelcurso2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_plantelcurso2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_plantelcurso2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_plantelcurso2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantelcurso2 = sprintf("SELECT * FROM jos_cdc_plantelcurso a, jos_cdc_estudiante b, jos_cdc_nombre_plantel c, jos_cdc_planestudio d, jos_cdc_localidad e WHERE a.alumno_id=b.id AND a.nombre_plantel_id=c.id AND a.planestudio_id=d.id AND a.localidad_id=e.id AND a.no=2 AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no ASC", GetSQLValueString($colname_plantelcurso2, "int"), GetSQLValueString($alumno_plantelcurso2, "bigint"));
$plantelcurso2 = mysql_query($query_plantelcurso2, $sistemacol) or die(mysql_error());
$row_plantelcurso2 = mysql_fetch_assoc($plantelcurso2);
$totalRows_plantelcurso2 = mysql_num_rows($plantelcurso2);


$colname_plantelcurso3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_plantelcurso3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_plantelcurso3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_plantelcurso3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantelcurso3 = sprintf("SELECT * FROM jos_cdc_plantelcurso a, jos_cdc_estudiante b, jos_cdc_nombre_plantel c, jos_cdc_planestudio d, jos_cdc_localidad e WHERE a.alumno_id=b.id AND a.nombre_plantel_id=c.id AND a.planestudio_id=d.id AND a.localidad_id=e.id AND a.no=3 AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no ASC", GetSQLValueString($colname_plantelcurso3, "int"), GetSQLValueString($alumno_plantelcurso3, "bigint"));
$plantelcurso3 = mysql_query($query_plantelcurso3, $sistemacol) or die(mysql_error());
$row_plantelcurso3 = mysql_fetch_assoc($plantelcurso3);
$totalRows_plantelcurso3 = mysql_num_rows($plantelcurso3);

$colname_plantelcurso4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_plantelcurso4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_plantelcurso4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_plantelcurso4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantelcurso4 = sprintf("SELECT * FROM jos_cdc_plantelcurso a, jos_cdc_estudiante b, jos_cdc_nombre_plantel c, jos_cdc_planestudio d, jos_cdc_localidad e WHERE a.alumno_id=b.id AND a.nombre_plantel_id=c.id AND a.planestudio_id=d.id AND a.localidad_id=e.id AND a.no=4 AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no ASC", GetSQLValueString($colname_plantelcurso4, "int"), GetSQLValueString($alumno_plantelcurso4, "bigint"));
$plantelcurso4 = mysql_query($query_plantelcurso4, $sistemacol) or die(mysql_error());
$row_plantelcurso4 = mysql_fetch_assoc($plantelcurso4);
$totalRows_plantelcurso4 = mysql_num_rows($plantelcurso4);

$colname_plantelcurso5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_plantelcurso5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_plantelcurso5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_plantelcurso5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_plantelcurso5 = sprintf("SELECT * FROM jos_cdc_plantelcurso a, jos_cdc_estudiante b, jos_cdc_nombre_plantel c, jos_cdc_planestudio d, jos_cdc_localidad e WHERE a.alumno_id=b.id AND a.nombre_plantel_id=c.id AND a.planestudio_id=d.id AND a.localidad_id=e.id AND a.no=5 AND a.planestudio_id=%s AND b.cedula=%s ORDER BY a.no ASC", GetSQLValueString($colname_plantelcurso5, "int"), GetSQLValueString($alumno_plantelcurso5, "bigint"));
$plantelcurso5 = mysql_query($query_plantelcurso5, $sistemacol) or die(mysql_error());
$row_plantelcurso5 = mysql_fetch_assoc($plantelcurso5);
$totalRows_plantelcurso5 = mysql_num_rows($plantelcurso5);

// CONSULTA DE NOTAS ANIO 1 

$colname_nota1_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota1_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota1_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota1_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota1_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota1_anio1, "int"), GetSQLValueString($alumno_nota1_anio1, "bigint"));
$nota1_anio1 = mysql_query($query_nota1_anio1, $sistemacol) or die(mysql_error());
$row_nota1_anio1 = mysql_fetch_assoc($nota1_anio1);
$totalRows_nota1_anio1 = mysql_num_rows($nota1_anio1);

$colname_nota2_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota2_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota2_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota2_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota2_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota2_anio1, "int"), GetSQLValueString($alumno_nota2_anio1, "bigint"));
$nota2_anio1 = mysql_query($query_nota2_anio1, $sistemacol) or die(mysql_error());
$row_nota2_anio1 = mysql_fetch_assoc($nota2_anio1);
$totalRows_nota2_anio1 = mysql_num_rows($nota2_anio1);

$colname_nota3_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota3_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota3_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota3_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota3_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota3_anio1, "int"), GetSQLValueString($alumno_nota3_anio1, "bigint"));
$nota3_anio1 = mysql_query($query_nota3_anio1, $sistemacol) or die(mysql_error());
$row_nota3_anio1 = mysql_fetch_assoc($nota3_anio1);
$totalRows_nota3_anio1 = mysql_num_rows($nota3_anio1);

$colname_nota4_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota4_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota4_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota4_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota4_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota4_anio1, "int"), GetSQLValueString($alumno_nota4_anio1, "bigint"));
$nota4_anio1 = mysql_query($query_nota4_anio1, $sistemacol) or die(mysql_error());
$row_nota4_anio1 = mysql_fetch_assoc($nota4_anio1);
$totalRows_nota4_anio1 = mysql_num_rows($nota4_anio1);

$colname_nota5_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota5_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota5_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota5_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota5_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota5_anio1, "int"), GetSQLValueString($alumno_nota5_anio1, "bigint"));
$nota5_anio1 = mysql_query($query_nota5_anio1, $sistemacol) or die(mysql_error());
$row_nota5_anio1 = mysql_fetch_assoc($nota5_anio1);
$totalRows_nota5_anio1 = mysql_num_rows($nota5_anio1);

$colname_nota6_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota6_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota6_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota6_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota6_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota6_anio1, "int"), GetSQLValueString($alumno_nota6_anio1, "bigint"));
$nota6_anio1 = mysql_query($query_nota6_anio1, $sistemacol) or die(mysql_error());
$row_nota6_anio1 = mysql_fetch_assoc($nota6_anio1);
$totalRows_nota6_anio1 = mysql_num_rows($nota6_anio1);

$colname_nota7_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota7_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota7_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota7_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota7_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota7_anio1, "int"), GetSQLValueString($alumno_nota7_anio1, "bigint"));
$nota7_anio1 = mysql_query($query_nota7_anio1, $sistemacol) or die(mysql_error());
$row_nota7_anio1 = mysql_fetch_assoc($nota7_anio1);
$totalRows_nota7_anio1 = mysql_num_rows($nota7_anio1);

$colname_nota8_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota8_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota8_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota8_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota8_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota8_anio1, "int"), GetSQLValueString($alumno_nota8_anio1, "bigint"));
$nota8_anio1 = mysql_query($query_nota8_anio1, $sistemacol) or die(mysql_error());
$row_nota8_anio1 = mysql_fetch_assoc($nota8_anio1);
$totalRows_nota8_anio1 = mysql_num_rows($nota8_anio1);

$colname_nota9_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota9_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota9_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota9_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota9_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota9_anio1, "int"), GetSQLValueString($alumno_nota9_anio1, "bigint"));
$nota9_anio1 = mysql_query($query_nota9_anio1, $sistemacol) or die(mysql_error());
$row_nota9_anio1 = mysql_fetch_assoc($nota9_anio1);
$totalRows_nota9_anio1 = mysql_num_rows($nota9_anio1);

$colname_nota10_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota10_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota10_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota10_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota10_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota10_anio1, "int"), GetSQLValueString($alumno_nota10_anio1, "bigint"));
$nota10_anio1 = mysql_query($query_nota10_anio1, $sistemacol) or die(mysql_error());
$row_nota10_anio1 = mysql_fetch_assoc($nota10_anio1);
$totalRows_nota10_anio1 = mysql_num_rows($nota10_anio1);

$colname_nota11_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota11_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota11_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota11_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota11_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=11 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota11_anio1, "int"), GetSQLValueString($alumno_nota11_anio1, "bigint"));
$nota11_anio1 = mysql_query($query_nota11_anio1, $sistemacol) or die(mysql_error());
$row_nota11_anio1 = mysql_fetch_assoc($nota11_anio1);
$totalRows_nota11_anio1 = mysql_num_rows($nota11_anio1);

$colname_nota12_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota12_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota12_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota12_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota12_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=12 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota12_anio1, "int"), GetSQLValueString($alumno_nota12_anio1, "bigint"));
$nota12_anio1 = mysql_query($query_nota12_anio1, $sistemacol) or die(mysql_error());
$row_nota12_anio1 = mysql_fetch_assoc($nota12_anio1);
$totalRows_nota12_anio1 = mysql_num_rows($nota12_anio1);

$colname_nota13_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota13_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota13_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota13_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota13_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=13 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota13_anio1, "int"), GetSQLValueString($alumno_nota13_anio1, "bigint"));
$nota13_anio1 = mysql_query($query_nota13_anio1, $sistemacol) or die(mysql_error());
$row_nota13_anio1 = mysql_fetch_assoc($nota13_anio1);
$totalRows_nota13_anio1 = mysql_num_rows($nota13_anio1);

$colname_nota14_anio1 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota14_anio1 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota14_anio1 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota14_anio1 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota14_anio1 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=1 AND d.orden_asignatura=14 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota14_anio1, "int"), GetSQLValueString($alumno_nota14_anio1, "bigint"));
$nota14_anio1 = mysql_query($query_nota14_anio1, $sistemacol) or die(mysql_error());
$row_nota14_anio1 = mysql_fetch_assoc($nota14_anio1);
$totalRows_nota14_anio1 = mysql_num_rows($nota14_anio1);

// CONSULTA DE NOTAS ANIO 2

$colname_nota1_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota1_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota1_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota1_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota1_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota1_anio2, "int"), GetSQLValueString($alumno_nota1_anio2, "bigint"));
$nota1_anio2 = mysql_query($query_nota1_anio2, $sistemacol) or die(mysql_error());
$row_nota1_anio2 = mysql_fetch_assoc($nota1_anio2);
$totalRows_nota1_anio2 = mysql_num_rows($nota1_anio2);

$colname_nota2_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota2_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota2_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota2_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota2_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota2_anio2, "int"), GetSQLValueString($alumno_nota2_anio2, "bigint"));
$nota2_anio2 = mysql_query($query_nota2_anio2, $sistemacol) or die(mysql_error());
$row_nota2_anio2 = mysql_fetch_assoc($nota2_anio2);
$totalRows_nota2_anio2 = mysql_num_rows($nota2_anio2);

$colname_nota3_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota3_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota3_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota3_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota3_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota3_anio2, "int"), GetSQLValueString($alumno_nota3_anio2, "bigint"));
$nota3_anio2 = mysql_query($query_nota3_anio2, $sistemacol) or die(mysql_error());
$row_nota3_anio2 = mysql_fetch_assoc($nota3_anio2);
$totalRows_nota3_anio2 = mysql_num_rows($nota3_anio2);

$colname_nota4_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota4_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota4_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota4_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota4_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota4_anio2, "int"), GetSQLValueString($alumno_nota4_anio2, "bigint"));
$nota4_anio2 = mysql_query($query_nota4_anio2, $sistemacol) or die(mysql_error());
$row_nota4_anio2 = mysql_fetch_assoc($nota4_anio2);
$totalRows_nota4_anio2 = mysql_num_rows($nota4_anio2);

$colname_nota5_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota5_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota5_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota5_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota5_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota5_anio2, "int"), GetSQLValueString($alumno_nota5_anio2, "bigint"));
$nota5_anio2 = mysql_query($query_nota5_anio2, $sistemacol) or die(mysql_error());
$row_nota5_anio2 = mysql_fetch_assoc($nota5_anio2);
$totalRows_nota5_anio2 = mysql_num_rows($nota5_anio2);

$colname_nota6_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota6_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota6_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota6_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota6_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota6_anio2, "int"), GetSQLValueString($alumno_nota6_anio2, "bigint"));
$nota6_anio2 = mysql_query($query_nota6_anio2, $sistemacol) or die(mysql_error());
$row_nota6_anio2 = mysql_fetch_assoc($nota6_anio2);
$totalRows_nota6_anio2 = mysql_num_rows($nota6_anio2);

$colname_nota7_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota7_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota7_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota7_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota7_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota7_anio2, "int"), GetSQLValueString($alumno_nota7_anio2, "bigint"));
$nota7_anio2 = mysql_query($query_nota7_anio2, $sistemacol) or die(mysql_error());
$row_nota7_anio2 = mysql_fetch_assoc($nota7_anio2);
$totalRows_nota7_anio2 = mysql_num_rows($nota7_anio2);

$colname_nota8_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota8_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota8_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota8_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota8_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota8_anio2, "int"), GetSQLValueString($alumno_nota8_anio2, "bigint"));
$nota8_anio2 = mysql_query($query_nota8_anio2, $sistemacol) or die(mysql_error());
$row_nota8_anio2 = mysql_fetch_assoc($nota8_anio2);
$totalRows_nota8_anio2 = mysql_num_rows($nota8_anio2);

$colname_nota9_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota9_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota9_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota9_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota9_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota9_anio2, "int"), GetSQLValueString($alumno_nota9_anio2, "bigint"));
$nota9_anio2 = mysql_query($query_nota9_anio2, $sistemacol) or die(mysql_error());
$row_nota9_anio2 = mysql_fetch_assoc($nota9_anio2);
$totalRows_nota9_anio2 = mysql_num_rows($nota9_anio2);

$colname_nota10_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota10_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota10_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota10_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota10_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota10_anio2, "int"), GetSQLValueString($alumno_nota10_anio2, "bigint"));
$nota10_anio2 = mysql_query($query_nota10_anio2, $sistemacol) or die(mysql_error());
$row_nota10_anio2 = mysql_fetch_assoc($nota10_anio2);
$totalRows_nota10_anio2 = mysql_num_rows($nota10_anio2);

$colname_nota11_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota11_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota11_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota11_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota11_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=11 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota11_anio2, "int"), GetSQLValueString($alumno_nota11_anio2, "bigint"));
$nota11_anio2 = mysql_query($query_nota11_anio2, $sistemacol) or die(mysql_error());
$row_nota11_anio2 = mysql_fetch_assoc($nota11_anio2);
$totalRows_nota11_anio2 = mysql_num_rows($nota11_anio2);

$colname_nota12_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota12_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota12_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota12_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota12_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=12 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota12_anio2, "int"), GetSQLValueString($alumno_nota12_anio2, "bigint"));
$nota12_anio2 = mysql_query($query_nota12_anio2, $sistemacol) or die(mysql_error());
$row_nota12_anio2 = mysql_fetch_assoc($nota12_anio2);
$totalRows_nota12_anio2 = mysql_num_rows($nota12_anio2);

$colname_nota13_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota13_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota13_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota13_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota13_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=13 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota13_anio2, "int"), GetSQLValueString($alumno_nota13_anio2, "bigint"));
$nota13_anio2 = mysql_query($query_nota13_anio2, $sistemacol) or die(mysql_error());
$row_nota13_anio2 = mysql_fetch_assoc($nota13_anio2);
$totalRows_nota13_anio2 = mysql_num_rows($nota13_anio2);

$colname_nota14_anio2 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota14_anio2 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota14_anio2 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota14_anio2 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota14_anio2 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=2 AND d.orden_asignatura=14 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota14_anio2, "int"), GetSQLValueString($alumno_nota14_anio2, "bigint"));
$nota14_anio2 = mysql_query($query_nota14_anio2, $sistemacol) or die(mysql_error());
$row_nota14_anio2 = mysql_fetch_assoc($nota14_anio2);
$totalRows_nota14_anio2 = mysql_num_rows($nota14_anio2);

// CONSULTA DE NOTAS ANIO 3 

$colname_nota1_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota1_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota1_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota1_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota1_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota1_anio3, "int"), GetSQLValueString($alumno_nota1_anio3, "bigint"));
$nota1_anio3 = mysql_query($query_nota1_anio3, $sistemacol) or die(mysql_error());
$row_nota1_anio3 = mysql_fetch_assoc($nota1_anio3);
$totalRows_nota1_anio3 = mysql_num_rows($nota1_anio3);

$colname_nota2_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota2_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota2_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota2_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota2_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota2_anio3, "int"), GetSQLValueString($alumno_nota2_anio3, "bigint"));
$nota2_anio3 = mysql_query($query_nota2_anio3, $sistemacol) or die(mysql_error());
$row_nota2_anio3 = mysql_fetch_assoc($nota2_anio3);
$totalRows_nota2_anio3 = mysql_num_rows($nota2_anio3);

$colname_nota3_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota3_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota3_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota3_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota3_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota3_anio3, "int"), GetSQLValueString($alumno_nota3_anio3, "bigint"));
$nota3_anio3 = mysql_query($query_nota3_anio3, $sistemacol) or die(mysql_error());
$row_nota3_anio3 = mysql_fetch_assoc($nota3_anio3);
$totalRows_nota3_anio3 = mysql_num_rows($nota3_anio3);

$colname_nota4_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota4_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota4_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota4_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota4_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota4_anio3, "int"), GetSQLValueString($alumno_nota4_anio3, "bigint"));
$nota4_anio3 = mysql_query($query_nota4_anio3, $sistemacol) or die(mysql_error());
$row_nota4_anio3 = mysql_fetch_assoc($nota4_anio3);
$totalRows_nota4_anio3 = mysql_num_rows($nota4_anio3);

$colname_nota5_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota5_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota5_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota5_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota5_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota5_anio3, "int"), GetSQLValueString($alumno_nota5_anio3, "bigint"));
$nota5_anio3 = mysql_query($query_nota5_anio3, $sistemacol) or die(mysql_error());
$row_nota5_anio3 = mysql_fetch_assoc($nota5_anio3);
$totalRows_nota5_anio3 = mysql_num_rows($nota5_anio3);

$colname_nota6_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota6_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota6_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota6_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota6_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota6_anio3, "int"), GetSQLValueString($alumno_nota6_anio3, "bigint"));
$nota6_anio3 = mysql_query($query_nota6_anio3, $sistemacol) or die(mysql_error());
$row_nota6_anio3 = mysql_fetch_assoc($nota6_anio3);
$totalRows_nota6_anio3 = mysql_num_rows($nota6_anio3);

$colname_nota7_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota7_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota7_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota7_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota7_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota7_anio3, "int"), GetSQLValueString($alumno_nota7_anio3, "bigint"));
$nota7_anio3 = mysql_query($query_nota7_anio3, $sistemacol) or die(mysql_error());
$row_nota7_anio3 = mysql_fetch_assoc($nota7_anio3);
$totalRows_nota7_anio3 = mysql_num_rows($nota7_anio3);

$colname_nota8_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota8_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota8_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota8_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota8_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota8_anio3, "int"), GetSQLValueString($alumno_nota8_anio3, "bigint"));
$nota8_anio3 = mysql_query($query_nota8_anio3, $sistemacol) or die(mysql_error());
$row_nota8_anio3 = mysql_fetch_assoc($nota8_anio3);
$totalRows_nota8_anio3 = mysql_num_rows($nota8_anio3);

$colname_nota9_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota9_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota9_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota9_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota9_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota9_anio3, "int"), GetSQLValueString($alumno_nota9_anio3, "bigint"));
$nota9_anio3 = mysql_query($query_nota9_anio3, $sistemacol) or die(mysql_error());
$row_nota9_anio3 = mysql_fetch_assoc($nota9_anio3);
$totalRows_nota9_anio3 = mysql_num_rows($nota9_anio3);

$colname_nota10_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota10_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota10_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota10_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota10_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota10_anio3, "int"), GetSQLValueString($alumno_nota10_anio3, "bigint"));
$nota10_anio3 = mysql_query($query_nota10_anio3, $sistemacol) or die(mysql_error());
$row_nota10_anio3 = mysql_fetch_assoc($nota10_anio3);
$totalRows_nota10_anio3 = mysql_num_rows($nota10_anio3);

$colname_nota11_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota11_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota11_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota11_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota11_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=11 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota11_anio3, "int"), GetSQLValueString($alumno_nota11_anio3, "bigint"));
$nota11_anio3 = mysql_query($query_nota11_anio3, $sistemacol) or die(mysql_error());
$row_nota11_anio3 = mysql_fetch_assoc($nota11_anio3);
$totalRows_nota11_anio3 = mysql_num_rows($nota11_anio3);

$colname_nota12_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota12_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota12_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota12_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota12_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=12 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota12_anio3, "int"), GetSQLValueString($alumno_nota12_anio3, "bigint"));
$nota12_anio3 = mysql_query($query_nota12_anio3, $sistemacol) or die(mysql_error());
$row_nota12_anio3 = mysql_fetch_assoc($nota12_anio3);
$totalRows_nota12_anio3 = mysql_num_rows($nota12_anio3);

$colname_nota13_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota13_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota13_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota13_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota13_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=13 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota13_anio3, "int"), GetSQLValueString($alumno_nota13_anio3, "bigint"));
$nota13_anio3 = mysql_query($query_nota13_anio3, $sistemacol) or die(mysql_error());
$row_nota13_anio3 = mysql_fetch_assoc($nota13_anio3);
$totalRows_nota13_anio3 = mysql_num_rows($nota13_anio3);

$colname_nota14_anio3 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota14_anio3 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota14_anio3 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota14_anio3 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota14_anio3 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=3 AND d.orden_asignatura=14 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota14_anio3, "int"), GetSQLValueString($alumno_nota14_anio3, "bigint"));
$nota14_anio3 = mysql_query($query_nota14_anio3, $sistemacol) or die(mysql_error());
$row_nota14_anio3 = mysql_fetch_assoc($nota14_anio3);
$totalRows_nota14_anio3 = mysql_num_rows($nota14_anio3);

// CONSULTA DE NOTAS ANIO 4 

$colname_nota1_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota1_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota1_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota1_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota1_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota1_anio4, "int"), GetSQLValueString($alumno_nota1_anio4, "bigint"));
$nota1_anio4 = mysql_query($query_nota1_anio4, $sistemacol) or die(mysql_error());
$row_nota1_anio4 = mysql_fetch_assoc($nota1_anio4);
$totalRows_nota1_anio4 = mysql_num_rows($nota1_anio4);

$colname_nota2_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota2_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota2_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota2_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota2_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota2_anio4, "int"), GetSQLValueString($alumno_nota2_anio4, "bigint"));
$nota2_anio4 = mysql_query($query_nota2_anio4, $sistemacol) or die(mysql_error());
$row_nota2_anio4 = mysql_fetch_assoc($nota2_anio4);
$totalRows_nota2_anio4 = mysql_num_rows($nota2_anio4);

$colname_nota3_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota3_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota3_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota3_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota3_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota3_anio4, "int"), GetSQLValueString($alumno_nota3_anio4, "bigint"));
$nota3_anio4 = mysql_query($query_nota3_anio4, $sistemacol) or die(mysql_error());
$row_nota3_anio4 = mysql_fetch_assoc($nota3_anio4);
$totalRows_nota3_anio4 = mysql_num_rows($nota3_anio4);

$colname_nota4_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota4_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota4_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota4_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota4_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota4_anio4, "int"), GetSQLValueString($alumno_nota4_anio4, "bigint"));
$nota4_anio4 = mysql_query($query_nota4_anio4, $sistemacol) or die(mysql_error());
$row_nota4_anio4 = mysql_fetch_assoc($nota4_anio4);
$totalRows_nota4_anio4 = mysql_num_rows($nota4_anio4);

$colname_nota5_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota5_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota5_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota5_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota5_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota5_anio4, "int"), GetSQLValueString($alumno_nota5_anio4, "bigint"));
$nota5_anio4 = mysql_query($query_nota5_anio4, $sistemacol) or die(mysql_error());
$row_nota5_anio4 = mysql_fetch_assoc($nota5_anio4);
$totalRows_nota5_anio4 = mysql_num_rows($nota5_anio4);

$colname_nota6_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota6_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota6_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota6_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota6_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota6_anio4, "int"), GetSQLValueString($alumno_nota6_anio4, "bigint"));
$nota6_anio4 = mysql_query($query_nota6_anio4, $sistemacol) or die(mysql_error());
$row_nota6_anio4 = mysql_fetch_assoc($nota6_anio4);
$totalRows_nota6_anio4 = mysql_num_rows($nota6_anio4);

$colname_nota7_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota7_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota7_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota7_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota7_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota7_anio4, "int"), GetSQLValueString($alumno_nota7_anio4, "bigint"));
$nota7_anio4 = mysql_query($query_nota7_anio4, $sistemacol) or die(mysql_error());
$row_nota7_anio4 = mysql_fetch_assoc($nota7_anio4);
$totalRows_nota7_anio4 = mysql_num_rows($nota7_anio4);

$colname_nota8_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota8_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota8_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota8_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota8_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota8_anio4, "int"), GetSQLValueString($alumno_nota8_anio4, "bigint"));
$nota8_anio4 = mysql_query($query_nota8_anio4, $sistemacol) or die(mysql_error());
$row_nota8_anio4 = mysql_fetch_assoc($nota8_anio4);
$totalRows_nota8_anio4 = mysql_num_rows($nota8_anio4);

$colname_nota9_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota9_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota9_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota9_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota9_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota9_anio4, "int"), GetSQLValueString($alumno_nota9_anio4, "bigint"));
$nota9_anio4 = mysql_query($query_nota9_anio4, $sistemacol) or die(mysql_error());
$row_nota9_anio4 = mysql_fetch_assoc($nota9_anio4);
$totalRows_nota9_anio4 = mysql_num_rows($nota9_anio4);

$colname_nota10_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota10_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota10_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota10_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota10_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota10_anio4, "int"), GetSQLValueString($alumno_nota10_anio4, "bigint"));
$nota10_anio4 = mysql_query($query_nota10_anio4, $sistemacol) or die(mysql_error());
$row_nota10_anio4 = mysql_fetch_assoc($nota10_anio4);
$totalRows_nota10_anio4 = mysql_num_rows($nota10_anio4);

$colname_nota11_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota11_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota11_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota11_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota11_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=11 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota11_anio4, "int"), GetSQLValueString($alumno_nota11_anio4, "bigint"));
$nota11_anio4 = mysql_query($query_nota11_anio4, $sistemacol) or die(mysql_error());
$row_nota11_anio4 = mysql_fetch_assoc($nota11_anio4);
$totalRows_nota11_anio4 = mysql_num_rows($nota11_anio4);

$colname_nota12_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota12_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota12_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota12_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota12_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=12 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota12_anio4, "int"), GetSQLValueString($alumno_nota12_anio4, "bigint"));
$nota12_anio4 = mysql_query($query_nota12_anio4, $sistemacol) or die(mysql_error());
$row_nota12_anio4 = mysql_fetch_assoc($nota12_anio4);
$totalRows_nota12_anio4 = mysql_num_rows($nota12_anio4);

$colname_nota13_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota13_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota13_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota13_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota13_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=13 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota13_anio4, "int"), GetSQLValueString($alumno_nota13_anio4, "bigint"));
$nota13_anio4 = mysql_query($query_nota13_anio4, $sistemacol) or die(mysql_error());
$row_nota13_anio4 = mysql_fetch_assoc($nota13_anio4);
$totalRows_nota13_anio4 = mysql_num_rows($nota13_anio4);

$colname_nota14_anio4 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota14_anio4 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota14_anio4 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota14_anio4 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota14_anio4 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=4 AND d.orden_asignatura=14 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota14_anio4, "int"), GetSQLValueString($alumno_nota14_anio4, "bigint"));
$nota14_anio4 = mysql_query($query_nota14_anio4, $sistemacol) or die(mysql_error());
$row_nota14_anio4 = mysql_fetch_assoc($nota14_anio4);
$totalRows_nota14_anio4 = mysql_num_rows($nota14_anio4);

// CONSULTA DE NOTAS ANIO 5 

$colname_nota1_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota1_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota1_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota1_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota1_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota1_anio5, "int"), GetSQLValueString($alumno_nota1_anio5, "bigint"));
$nota1_anio5 = mysql_query($query_nota1_anio5, $sistemacol) or die(mysql_error());
$row_nota1_anio5 = mysql_fetch_assoc($nota1_anio5);
$totalRows_nota1_anio5 = mysql_num_rows($nota1_anio5);

$colname_nota2_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota2_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota2_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota2_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota2_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota2_anio5, "int"), GetSQLValueString($alumno_nota2_anio5, "bigint"));
$nota2_anio5 = mysql_query($query_nota2_anio5, $sistemacol) or die(mysql_error());
$row_nota2_anio5 = mysql_fetch_assoc($nota2_anio5);
$totalRows_nota2_anio5 = mysql_num_rows($nota2_anio5);

$colname_nota3_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota3_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota3_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota3_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota3_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota3_anio5, "int"), GetSQLValueString($alumno_nota3_anio5, "bigint"));
$nota3_anio5 = mysql_query($query_nota3_anio5, $sistemacol) or die(mysql_error());
$row_nota3_anio5 = mysql_fetch_assoc($nota3_anio5);
$totalRows_nota3_anio5 = mysql_num_rows($nota3_anio5);

$colname_nota4_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota4_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota4_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota4_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota4_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota4_anio5, "int"), GetSQLValueString($alumno_nota4_anio5, "bigint"));
$nota4_anio5 = mysql_query($query_nota4_anio5, $sistemacol) or die(mysql_error());
$row_nota4_anio5 = mysql_fetch_assoc($nota4_anio5);
$totalRows_nota4_anio5 = mysql_num_rows($nota4_anio5);

$colname_nota5_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota5_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota5_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota5_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota5_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota5_anio5, "int"), GetSQLValueString($alumno_nota5_anio5, "bigint"));
$nota5_anio5 = mysql_query($query_nota5_anio5, $sistemacol) or die(mysql_error());
$row_nota5_anio5 = mysql_fetch_assoc($nota5_anio5);
$totalRows_nota5_anio5 = mysql_num_rows($nota5_anio5);

$colname_nota6_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota6_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota6_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota6_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota6_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota6_anio5, "int"), GetSQLValueString($alumno_nota6_anio5, "bigint"));
$nota6_anio5 = mysql_query($query_nota6_anio5, $sistemacol) or die(mysql_error());
$row_nota6_anio5 = mysql_fetch_assoc($nota6_anio5);
$totalRows_nota6_anio5 = mysql_num_rows($nota6_anio5);

$colname_nota7_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota7_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota7_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota7_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota7_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota7_anio5, "int"), GetSQLValueString($alumno_nota7_anio5, "bigint"));
$nota7_anio5 = mysql_query($query_nota7_anio5, $sistemacol) or die(mysql_error());
$row_nota7_anio5 = mysql_fetch_assoc($nota7_anio5);
$totalRows_nota7_anio5 = mysql_num_rows($nota7_anio5);

$colname_nota8_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota8_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota8_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota8_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota8_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota8_anio5, "int"), GetSQLValueString($alumno_nota8_anio5, "bigint"));
$nota8_anio5 = mysql_query($query_nota8_anio5, $sistemacol) or die(mysql_error());
$row_nota8_anio5 = mysql_fetch_assoc($nota8_anio5);
$totalRows_nota8_anio5 = mysql_num_rows($nota8_anio5);

$colname_nota9_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota9_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota9_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota9_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota9_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota9_anio5, "int"), GetSQLValueString($alumno_nota9_anio5, "bigint"));
$nota9_anio5 = mysql_query($query_nota9_anio5, $sistemacol) or die(mysql_error());
$row_nota9_anio5 = mysql_fetch_assoc($nota9_anio5);
$totalRows_nota9_anio5 = mysql_num_rows($nota9_anio5);

$colname_nota10_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota10_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota10_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota10_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota10_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota10_anio5, "int"), GetSQLValueString($alumno_nota10_anio5, "bigint"));
$nota10_anio5 = mysql_query($query_nota10_anio5, $sistemacol) or die(mysql_error());
$row_nota10_anio5 = mysql_fetch_assoc($nota10_anio5);
$totalRows_nota10_anio5 = mysql_num_rows($nota10_anio5);

$colname_nota11_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota11_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota11_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota11_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota11_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=11 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota11_anio5, "int"), GetSQLValueString($alumno_nota11_anio5, "bigint"));
$nota11_anio5 = mysql_query($query_nota11_anio5, $sistemacol) or die(mysql_error());
$row_nota11_anio5 = mysql_fetch_assoc($nota11_anio5);
$totalRows_nota11_anio5 = mysql_num_rows($nota11_anio5);

$colname_nota12_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota12_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota12_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota12_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota12_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=12 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota12_anio5, "int"), GetSQLValueString($alumno_nota12_anio5, "bigint"));
$nota12_anio5 = mysql_query($query_nota12_anio5, $sistemacol) or die(mysql_error());
$row_nota12_anio5 = mysql_fetch_assoc($nota12_anio5);
$totalRows_nota12_anio5 = mysql_num_rows($nota12_anio5);

$colname_nota13_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota13_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota13_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota13_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota13_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=13 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota13_anio5, "int"), GetSQLValueString($alumno_nota13_anio5, "bigint"));
$nota13_anio5 = mysql_query($query_nota13_anio5, $sistemacol) or die(mysql_error());
$row_nota13_anio5 = mysql_fetch_assoc($nota13_anio5);
$totalRows_nota13_anio5 = mysql_num_rows($nota13_anio5);

$colname_nota14_anio5 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota14_anio5 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota14_anio5 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota14_anio5 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota14_anio5 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=5 AND d.orden_asignatura=14 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota14_anio5, "int"), GetSQLValueString($alumno_nota14_anio5, "bigint"));
$nota14_anio5 = mysql_query($query_nota14_anio5, $sistemacol) or die(mysql_error());
$row_nota14_anio5 = mysql_fetch_assoc($nota14_anio5);
$totalRows_nota14_anio5 = mysql_num_rows($nota14_anio5);

// CONSULTA DE NOTAS ANIO 6 

$colname_nota1_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota1_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota1_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota1_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota1_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=1 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota1_anio6, "int"), GetSQLValueString($alumno_nota1_anio6, "bigint"));
$nota1_anio6 = mysql_query($query_nota1_anio6, $sistemacol) or die(mysql_error());
$row_nota1_anio6 = mysql_fetch_assoc($nota1_anio6);
$totalRows_nota1_anio6 = mysql_num_rows($nota1_anio6);

$colname_nota2_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota2_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota2_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota2_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota2_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=2 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota2_anio6, "int"), GetSQLValueString($alumno_nota2_anio6, "bigint"));
$nota2_anio6 = mysql_query($query_nota2_anio6, $sistemacol) or die(mysql_error());
$row_nota2_anio6 = mysql_fetch_assoc($nota2_anio6);
$totalRows_nota2_anio6 = mysql_num_rows($nota2_anio6);

$colname_nota3_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota3_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota3_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota3_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota3_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=3 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota3_anio6, "int"), GetSQLValueString($alumno_nota3_anio6, "bigint"));
$nota3_anio6 = mysql_query($query_nota3_anio6, $sistemacol) or die(mysql_error());
$row_nota3_anio6 = mysql_fetch_assoc($nota3_anio6);
$totalRows_nota3_anio6 = mysql_num_rows($nota3_anio6);

$colname_nota4_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota4_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota4_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota4_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota4_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=4 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota4_anio6, "int"), GetSQLValueString($alumno_nota4_anio6, "bigint"));
$nota4_anio6 = mysql_query($query_nota4_anio6, $sistemacol) or die(mysql_error());
$row_nota4_anio6 = mysql_fetch_assoc($nota4_anio6);
$totalRows_nota4_anio6 = mysql_num_rows($nota4_anio6);

$colname_nota5_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota5_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota5_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota5_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota5_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=5 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota5_anio6, "int"), GetSQLValueString($alumno_nota5_anio6, "bigint"));
$nota5_anio6 = mysql_query($query_nota5_anio6, $sistemacol) or die(mysql_error());
$row_nota5_anio6 = mysql_fetch_assoc($nota5_anio6);
$totalRows_nota5_anio6 = mysql_num_rows($nota5_anio6);

$colname_nota6_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota6_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota6_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota6_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota6_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=6 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota6_anio6, "int"), GetSQLValueString($alumno_nota6_anio6, "bigint"));
$nota6_anio6 = mysql_query($query_nota6_anio6, $sistemacol) or die(mysql_error());
$row_nota6_anio6 = mysql_fetch_assoc($nota6_anio6);
$totalRows_nota6_anio6 = mysql_num_rows($nota6_anio6);

$colname_nota7_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota7_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota7_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota7_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota7_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=7 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota7_anio6, "int"), GetSQLValueString($alumno_nota7_anio6, "bigint"));
$nota7_anio6 = mysql_query($query_nota7_anio6, $sistemacol) or die(mysql_error());
$row_nota7_anio6 = mysql_fetch_assoc($nota7_anio6);
$totalRows_nota7_anio6 = mysql_num_rows($nota7_anio6);

$colname_nota8_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota8_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota8_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota8_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota8_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=8 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota8_anio6, "int"), GetSQLValueString($alumno_nota8_anio6, "bigint"));
$nota8_anio6 = mysql_query($query_nota8_anio6, $sistemacol) or die(mysql_error());
$row_nota8_anio6 = mysql_fetch_assoc($nota8_anio6);
$totalRows_nota8_anio6 = mysql_num_rows($nota8_anio6);

$colname_nota9_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota9_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota9_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota9_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota9_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=9 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota9_anio6, "int"), GetSQLValueString($alumno_nota9_anio6, "bigint"));
$nota9_anio6 = mysql_query($query_nota9_anio6, $sistemacol) or die(mysql_error());
$row_nota9_anio6 = mysql_fetch_assoc($nota9_anio6);
$totalRows_nota9_anio6 = mysql_num_rows($nota9_anio6);

$colname_nota10_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota10_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota10_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota10_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota10_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=10 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota10_anio6, "int"), GetSQLValueString($alumno_nota10_anio6, "bigint"));
$nota10_anio6 = mysql_query($query_nota10_anio6, $sistemacol) or die(mysql_error());
$row_nota10_anio6 = mysql_fetch_assoc($nota10_anio6);
$totalRows_nota10_anio6 = mysql_num_rows($nota10_anio6);

$colname_nota11_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota11_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota11_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota11_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota11_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=11 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota11_anio6, "int"), GetSQLValueString($alumno_nota11_anio6, "bigint"));
$nota11_anio6 = mysql_query($query_nota11_anio6, $sistemacol) or die(mysql_error());
$row_nota11_anio6 = mysql_fetch_assoc($nota11_anio6);
$totalRows_nota11_anio6 = mysql_num_rows($nota11_anio6);

$colname_nota12_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota12_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota12_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota12_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota12_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=12 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota12_anio6, "int"), GetSQLValueString($alumno_nota12_anio6, "bigint"));
$nota12_anio6 = mysql_query($query_nota12_anio6, $sistemacol) or die(mysql_error());
$row_nota12_anio6 = mysql_fetch_assoc($nota12_anio6);
$totalRows_nota12_anio6 = mysql_num_rows($nota12_anio6);

$colname_nota13_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota13_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota13_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota13_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota13_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=13 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota13_anio6, "int"), GetSQLValueString($alumno_nota13_anio6, "bigint"));
$nota13_anio6 = mysql_query($query_nota13_anio6, $sistemacol) or die(mysql_error());
$row_nota13_anio6 = mysql_fetch_assoc($nota13_anio6);
$totalRows_nota13_anio6 = mysql_num_rows($nota13_anio6);

$colname_nota14_anio6 = "-1";
if (isset($_POST['9812HHFJHJHF63883B3CNCH7'])) {
  $colname_nota14_anio6 = $_POST['9812HHFJHJHF63883B3CNCH7'];
}
$alumno_nota14_anio6 = "-1";
if (isset($_POST['1298JJII128938367HHY'])) {
  $alumno_nota14_anio6 = $_POST['1298JJII128938367HHY'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_nota14_anio6 = sprintf("SELECT * FROM jos_cdc_pensum a, jos_cdc_planestudio b, jos_cdc_pensum_anios c, jos_cdc_pensum_asignaturas d, jos_cdc_estudiante e WHERE a.asignatura_id=d.id AND d.anio_id=c.id AND c.planestudio_id=b.id AND a.alumno_id=e.id AND c.no_anio=6 AND d.orden_asignatura=14 AND b.id=%s AND e.cedula=%s", GetSQLValueString($colname_nota14_anio6, "int"), GetSQLValueString($alumno_nota14_anio6, "bigint"));
$nota14_anio6 = mysql_query($query_nota14_anio6, $sistemacol) or die(mysql_error());
$row_nota14_anio6 = mysql_fetch_assoc($nota14_anio6);
$totalRows_nota14_anio6 = mysql_num_rows($nota14_anio6);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SISTEMA INTERSOFT |Software Educativo</title>
<link href="../../css/form_vista_certificacion.css" rel="stylesheet" type="text/css" >
<link href="../../css/form_impresion_certificacion.css" rel="stylesheet" type="text/css" media="print">
<?php // SCRIPT PARA BLOQUEAR EL ENTER 
?>
<script>
function disableEnterKey(e){
var key;
if(window.event){
key = window.event.keyCode; //IE
}else{
key = e.which; //firefox
}
if(key==13){
return false;
}else{
return true;
}
}
</script>

</head>
<center>
<body>
<?php if ($row_usuario['gid']==25){ // AUTENTIFICACION DE USUARIO 
?>

<div id="ancho_certificacion">
<div id="logo_me">
<div id="logo">
<img src="../../images/logo_ce_2013.jpg" border="0" align="absmiddle" width="300" height="35"> 
</div>
<!--
Ministerio de Poder Popular<br />
para la Educaci&oacute;n<br />
Viceministerio de Participaci&oacute;n y Apoyo Acad&eacute;mico<br />
Direcci&oacute;n General de Registro y Control Acad&eacute;mico
-->
</div>
<div id="titulo_mencion">
	<div class="certificacion">
	<b>CERTIFICACION DE CALIFICACIONES</b>
	</div>
	<div class="coddea">
	<b>Codigo del Formato: RR-DEA-03-03</b>
	</div>
	<div class="titulo1">
	<b>I. Plan de Estudio:</b>
	</div>
	<div class="plan">
	 <?php echo $row_planestudio['plan_estudio']; ?> 
	</div>
	<div class="titulo2">
	<b>COD:</b>
	</div>
	<div class="codplan">
	<?php echo $row_planestudio['cod']; ?>
	</div>
	<div class="titulo1">
	<b>Menci&oacute;n:</b>
	</div>
	<div class="mencion">
	<?php if ($row_planestudio['mencion']==NULL) { echo "************";} else { echo $row_planestudio['mencion'];} ?>
	</div>
	<div class="fecha_titulo">
	<b>Lugar y Fecha de Expedici&oacute;n:</b>
	</div>
	<div class="fecha">
	<span style="font-size:5.7pt;" ><?php echo $row_institucion['ciudad'];?>, <?php echo date(d);?> DE 
	<?php 
	$mes=date("M");
	if ($mes=="Jan") $mes="ENERO";
	if ($mes=="Feb") $mes="FEBRERO";
	if ($mes=="Mar") $mes="MARZO";
	if ($mes=="Apr") $mes="ABRIL";
	if ($mes=="May") $mes="MAYO";
	if ($mes=="Jun") $mes="JUNIO";
	if ($mes=="Jul") $mes="JULIO";
	if ($mes=="Aug") $mes="AGOSTO";
	if ($mes=="Sep")$mes="SEPTIEMBRE";
	if ($mes=="Oct") $mes="OCTUBRE";
	if ($mes=="Nov") $mes="NOVIEMBRE";
	if ($mes=="Dec") $mes="DICIEMBRE";

	echo $mes;?> DE <?php echo date(Y);?>
	</span>
	</div>



</div>
<div id="info_plantel_estudiante">
	<div class="titulo">
	<b>II. Datos del Plantel o Z.E. que emite la Certificaci&oacute;n:</b>
	</div>
	<div class="titulo_info" style="text-align:left;">
	<b>C&oacute;d. Plantel:</b>
	</div>
	<div class="cod_plantel">
	<?php echo $row_institucion['cod_plantel'];?>
	</div>
	<div class="titulo_info">
	<b>Nombre:</b> 
	</div>
	<div class="nombre_plantel" >
	<?php echo $row_institucion['nombre_plantel'];?>
	</div>
	<div class="titulo_info">
	<b>Dtto.Esc.:</b>
	</div>
	<div class="dtto">
	 <?php echo $row_institucion['dtto_esc'];?> 
	</div>

	<div class="titulo_info" style="text-align:left;">
	<b>Direcci&oacute;n:</b>
	</div>
	<div class="direccion" style="font-size:9px;">
	 <?php echo $row_institucion['direccion'];?>
	</div>
	<div class="titulo_info" >
	 <b>Tel&eacute;fono:</b>
	</div>
	<div class="telefono">
 	<?php echo $row_institucion['telefono'];?>
	</div>

	<div class="titulo_info" style="text-align:left;">
	<b>Municipio:</b>
	</div>
	<div class="municipio">
 	 <?php echo $row_institucion['municipio'];?>
	</div>
	<div class="titulo_info" >
	<b>Ent. Federal:</b> 
	</div>
	<div class="varios">
 	 <?php echo $row_institucion['ent_federal'];?>
	</div>
	<div class="titulo_info" style="width:3cm;" >
	<b>Zona Educativa:</b>
	</div>
	<div class="varios">
 	 <?php echo $row_institucion['zona_educativa'];?>
	</div>


	<div class="titulo">
	<b>III. Datos de Identificaci&oacute;n del (la) Estudiante:</b>
	</div>
	<div class="titulo_info" style="text-align:left;" >
	<b>C&eacute;d. Identidad:</b>
	</div>
	<div class="cedula">
 	<?php echo $row_alumno['indicador_nacionalidad']."-".$row_alumno['cedula'];?>
	</div>
	<div class="titulo_info" style="width:3cm;" >
	<b>Fecha de Nacimiento:</b>
	</div>
	<div class="varios">
	<?php
	$fecha = $row_alumno['fecha_nacimiento'];
	$ano = substr($fecha, -10, 4);
	$mes = substr($fecha, -5, 2);
	$dia = substr($fecha, -2, 2);
	?> 
	<?php echo $dia."/".$mes."/".$ano; ?>
	</div>

	<div class="titulo_info" style="text-align:left;" >
	<b>Apellidos:</b>
	</div>
	<div class="nombres">
 	<?php echo $row_alumno['apellido_alumno'];?>
	</div>
	<div class="titulo_info" style="width:3cm;" >
	<b>Nombres:</b>
	</div>
	<div class="nombres">
 	<?php echo $row_alumno['nombre_alumno'];?> 
	</div>

	<div class="titulo_info" style="text-align:left; width:3cm;"  >
	<b>Lugar de Nacimiento:</b>
	</div>
	<div class="entidad">
 	<?php echo $row_alumno['lugar_nacimiento'];?>
	</div>
	<div class="titulo_info" style="width:3cm;" >
	 <b>Ent. Federal o Pa&iacute;s:</b>
	</div>
	<div class="entidad">
 	 <?php echo $row_alumno['ent_federal_pais'];?>
	</div>


</div>
<div id="plantel_curso1">
	<div class="titulo"  style="border-bottom:1px solid;">
		<b>IV. Planteles donde Curs&oacute; estos Estudios:</b>
	</div>
	<div class="cuadrito" style="border-top:1px solid;">
		<b>No.</b>
	</div>
	<div class="cuadro_grande" style="font-size:9pt; border-top:1px solid;">
		<b>Nombre del Plantel</b>
	</div>
	<div class="cuadro_mediano" style="font-size:9pt; border-top:1px solid;">
		<b>Localidad</b>
	</div>
	<div class="cuadrito" style="border-top:1px solid; border-right:1px solid;">
		<b>E.F.</b>
	</div>
</div>

<div id="plantel_curso">
	<div class="cuadrito">
		<b>No.</b>
	</div>
	<div class="cuadro_grande" style="font-size:9pt;" >
		<b>Nombre del Plantel</b>
	</div>
	<div class="cuadro_mediano2" style="font-size:9pt;">
		<b>Localidad</b>
	</div>
	<div class="cuadrito" >
		<b>E.F.</b>
	</div>

<div class="cuadrito">
<b>3</b>
</div>
<div class="cuadro_grande" >
<?php if($totalRows_plantelcurso3>0){echo $row_plantelcurso3['nombre_plantel'];}else{ echo "*";} ?>
</div>
<div class="cuadro_mediano" style="font-size:8px;">
<?php if($totalRows_plantelcurso3>0){echo $row_plantelcurso3['localidad'];}else{ echo "*";} ?>
</div>
<div class="cuadrito" style="border-right:1px solid;">
<?php if($totalRows_plantelcurso3>0){echo $row_plantelcurso3['ef'];}else{ echo "*";} ?>
</div>

<div class="cuadrito">
<b>1</b>
</div>
<div class="cuadro_grande">
<?php if($totalRows_plantelcurso1>0){echo $row_plantelcurso1['nombre_plantel'];}else{ echo "*";} ?>
</div>
<div class="cuadro_mediano2" style="font-size:8px;">
<?php if($totalRows_plantelcurso1>0){echo $row_plantelcurso1['localidad'];}else{ echo "*";} ?>
</div>
<div class="cuadrito">
<?php if($totalRows_plantelcurso1>0){echo $row_plantelcurso1['ef'];}else{ echo "*";} ?>
</div>

<div class="cuadrito">
<b>4</b>
</div>
<div class="cuadro_grande">
<?php if($totalRows_plantelcurso4>0){echo $row_plantelcurso4['nombre_plantel'];}else{ echo "*";} ?>
</div>
<div class="cuadro_mediano" style="font-size:8px;">
<?php if($totalRows_plantelcurso4>0){echo $row_plantelcurso4['localidad'];}else{ echo "*";} ?>
</div>
<div class="cuadrito" style="border-right:1px solid;">
<?php if($totalRows_plantelcurso4>0){echo $row_plantelcurso4['ef'];}else{ echo "*";} ?>
</div>

<div class="cuadrito">
<b>2</b>
</div>
<div class="cuadro_grande">
<?php if($totalRows_plantelcurso2>0){echo $row_plantelcurso2['nombre_plantel'];}else{ echo "*";} ?>
</div>
<div class="cuadro_mediano2" style="font-size:8px;">
<?php if($totalRows_plantelcurso2>0){echo $row_plantelcurso2['localidad'];}else{ echo "*";} ?>
</div>
<div class="cuadrito">
<?php if($totalRows_plantelcurso2>0){echo $row_plantelcurso2['ef'];}else{ echo "*";} ?>
</div>

<div class="cuadrito">
<b>5</b>
</div>
<div class="cuadro_grande">
<?php if($totalRows_plantelcurso5>0){echo $row_plantelcurso5['nombre_plantel']; }else{ echo "*";}?>
</div>
<div class="cuadro_mediano">
<?php if($totalRows_plantelcurso5>0){echo $row_plantelcurso5['localidad'];}else{ echo "*";} ?>
</div>
<div class="cuadrito" style="border-right:1px solid;">
<?php if($totalRows_plantelcurso5>0){echo $row_plantelcurso5['ef'];}else{ echo "*";} ?>
</div>

</div>


<div id="central_notas">

<b>V. Pensum de Estudio:</b>
<div class="container_titulos">

<div class="container_cuadro_left" style="border-top:1px solid;">
	<div class="cuadro_left">
	<b>A&ntilde;o o Grado: <?php if($totalRows_nota1_anio1>0) { echo $row_nota1_anio1['nombre_anio'];} if($totalRows_nota1_anio4>0) { echo $row_nota1_anio4['nombre_anio'];}  ?></b>
	</div>
	<div class="cuadro_left" style="text-align:center;">
	<b>Asignaturas</b>
	</div>

</div>

<div class="container_cuadro_medio_grande">
	<div class="cuadro_medio_grande" style="border-top:1px solid;">
	<b>Calificaci&oacute;n</b>
	</div>
	<div class="cuadro_medio_grande">
		<div class="enno">
		<b>En No.</b>
		</div>
		<div class="enletras">
		<b>En letras</b>
		</div>

	</div>
</div>

<div class="t-e" style="border-top:1px solid;">
<b>T-E</b>
</div>

<div class="container_fecha">
	<div class="fecha" style="border-top:1px solid;"> 
	<b>Fecha</b>
	</div>
	<div class="fecha">
		<div class="mes">
		<b>Mes</b>
		</div>
		<div class="anio">
		<b>A&ntilde;o</b>
		</div>
	</div>

</div>

<div class="container_plantel">
	<div class="plantel" style="border-top:1px solid;">
	<b>Plantel</b>
	</div>
	<div class="plantel">
	<b>No.</b>
	</div>
</div>

<div id="container_asignaturas">

<?php 
if ($totalRows_nota1_anio1>0){ // NOTA 1 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota1_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota1_anio1['def']<=20){echo $row_nota1_anio1['def'];} if($row_nota1_anio1['def']==99){echo "PE";} if($row_nota1_anio1['def']==98){echo "C";} if($row_nota1_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota1_anio1['def']==10){ echo "DIEZ";} if ($row_nota1_anio1['def']==11){ echo "ONCE";} if ($row_nota1_anio1['def']==12){ echo "DOCE";} if ($row_nota1_anio1['def']==13){ echo "TRECE";} if ($row_nota1_anio1['def']==14){ echo "CATORCE";} if ($row_nota1_anio1['def']==15){ echo "QUINCE";} if ($row_nota1_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota1_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota1_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota1_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota1_anio1['def']==20){ echo "VEINTE";} if ($row_nota1_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota1_anio1['def']==98){ echo "CURSADA";} if ($row_nota1_anio1['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota1_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota1_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota1_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota1_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 1 ANIO 1

if ($totalRows_nota1_anio4>0){ // NOTA 1 DE ANIO 4

?>
	<div class="mate">
	&nbsp;<?php echo $row_nota1_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota1_anio4['def']<=20){echo $row_nota1_anio4['def'];} if($row_nota1_anio4['def']==99){echo "PE";} if($row_nota1_anio4['def']==98){echo "C";} if($row_nota1_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota1_anio4['def']==10){ echo "DIEZ";} if ($row_nota1_anio4['def']==11){ echo "ONCE";} if ($row_nota1_anio4['def']==12){ echo "DOCE";} if ($row_nota1_anio4['def']==13){ echo "TRECE";} if ($row_nota1_anio4['def']==14){ echo "CATORCE";} if ($row_nota1_anio4['def']==15){ echo "QUINCE";} if ($row_nota1_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota1_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota1_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota1_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota1_anio4['def']==20){ echo "VEINTE";} if ($row_nota1_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota1_anio4['def']==98){ echo "CURSADA";} if ($row_nota1_anio4['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota1_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota1_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota1_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota1_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 1 ANIO 4
?>

<?php 
if ($totalRows_nota2_anio1>0){ // NOTA 2 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota2_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota2_anio1['def']<=20){echo $row_nota2_anio1['def'];} if($row_nota2_anio1['def']==99){echo "PE";} if($row_nota2_anio1['def']==98){echo "C";} if($row_nota2_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota2_anio1['def']==10){ echo "DIEZ";} if ($row_nota2_anio1['def']==11){ echo "ONCE";} if ($row_nota2_anio1['def']==12){ echo "DOCE";} if ($row_nota2_anio1['def']==13){ echo "TRECE";} if ($row_nota2_anio1['def']==14){ echo "CATORCE";} if ($row_nota2_anio1['def']==15){ echo "QUINCE";} if ($row_nota2_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota2_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota2_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota2_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota2_anio1['def']==20){ echo "VEINTE";}if ($row_nota2_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota2_anio1['def']==98){ echo "CURSADA";} if ($row_nota2_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota2_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota2_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota2_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota2_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 2 ANIO 1
if ($totalRows_nota2_anio4>0){ // NOTA 2 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota2_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota2_anio4['def']<=20){echo $row_nota2_anio4['def'];} if($row_nota2_anio4['def']==99){echo "PE";} if($row_nota2_anio4['def']==98){echo "C";} if($row_nota2_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota2_anio4['def']==10){ echo "DIEZ";} if ($row_nota2_anio4['def']==11){ echo "ONCE";} if ($row_nota2_anio4['def']==12){ echo "DOCE";} if ($row_nota2_anio4['def']==13){ echo "TRECE";} if ($row_nota2_anio4['def']==14){ echo "CATORCE";} if ($row_nota2_anio4['def']==15){ echo "QUINCE";} if ($row_nota2_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota2_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota2_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota2_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota2_anio4['def']==20){ echo "VEINTE";} if ($row_nota2_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota2_anio4['def']==98){ echo "CURSADA";} if ($row_nota2_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota2_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota2_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota2_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota2_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 2 ANIO 4
?>

<?php 
if ($totalRows_nota3_anio1>0){ // NOTA 2 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota3_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota3_anio1['def']<=20){echo $row_nota3_anio1['def'];} if($row_nota3_anio1['def']==99){echo "PE";} if($row_nota3_anio1['def']==98){echo "C";} if($row_nota3_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota3_anio1['def']==10){ echo "DIEZ";} if ($row_nota3_anio1['def']==11){ echo "ONCE";} if ($row_nota3_anio1['def']==12){ echo "DOCE";} if ($row_nota3_anio1['def']==13){ echo "TRECE";} if ($row_nota3_anio1['def']==14){ echo "CATORCE";} if ($row_nota3_anio1['def']==15){ echo "QUINCE";} if ($row_nota3_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota3_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota3_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota3_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota3_anio1['def']==20){ echo "VEINTE";} if ($row_nota3_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota3_anio1['def']==98){ echo "CURSADA";} if ($row_nota3_anio1['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota3_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota3_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota3_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota3_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 3 ANIO 1
if ($totalRows_nota3_anio4>0){ // NOTA 3 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota3_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota3_anio4['def']<=20){echo $row_nota3_anio4['def'];} if($row_nota3_anio4['def']==99){echo "PE";} if($row_nota3_anio4['def']==98){echo "C";} if($row_nota3_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota3_anio4['def']==10){ echo "DIEZ";} if ($row_nota3_anio4['def']==11){ echo "ONCE";} if ($row_nota3_anio4['def']==12){ echo "DOCE";} if ($row_nota3_anio4['def']==13){ echo "TRECE";} if ($row_nota3_anio4['def']==14){ echo "CATORCE";} if ($row_nota3_anio4['def']==15){ echo "QUINCE";} if ($row_nota3_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota3_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota3_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota3_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota3_anio4['def']==20){ echo "VEINTE";}if ($row_nota3_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota3_anio4['def']==98){ echo "CURSADA";} if ($row_nota3_anio4['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota3_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota3_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota3_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota3_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 3 ANIO 4
?>


<?php 
if ($totalRows_nota4_anio1>0){ // NOTA 4 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota4_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota4_anio1['def']<=20){echo $row_nota4_anio1['def'];} if($row_nota4_anio1['def']==99){echo "PE";} if($row_nota4_anio1['def']==98){echo "C";} if($row_nota4_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota4_anio1['def']==10){ echo "DIEZ";} if ($row_nota4_anio1['def']==11){ echo "ONCE";} if ($row_nota4_anio1['def']==12){ echo "DOCE";} if ($row_nota4_anio1['def']==13){ echo "TRECE";} if ($row_nota4_anio1['def']==14){ echo "CATORCE";} if ($row_nota4_anio1['def']==15){ echo "QUINCE";} if ($row_nota4_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota4_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota4_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota4_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota4_anio1['def']==20){ echo "VEINTE";} if ($row_nota4_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota4_anio1['def']==98){ echo "CURSADA";} if ($row_nota4_anio1['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota4_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota4_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota4_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota4_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 4 ANIO 1
if ($totalRows_nota4_anio4>0){ // NOTA 4 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota4_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota4_anio4['def']<=20){echo $row_nota4_anio4['def'];} if($row_nota4_anio4['def']==99){echo "PE";} if($row_nota4_anio4['def']==98){echo "C";} if($row_nota4_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota4_anio4['def']==10){ echo "DIEZ";} if ($row_nota4_anio4['def']==11){ echo "ONCE";} if ($row_nota4_anio4['def']==12){ echo "DOCE";} if ($row_nota4_anio4['def']==13){ echo "TRECE";} if ($row_nota4_anio4['def']==14){ echo "CATORCE";} if ($row_nota4_anio4['def']==15){ echo "QUINCE";} if ($row_nota4_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota4_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota4_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota4_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota4_anio4['def']==20){ echo "VEINTE";}if ($row_nota4_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota4_anio4['def']==98){ echo "CURSADA";} if ($row_nota4_anio4['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota4_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota4_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota4_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota4_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 4 ANIO 4
?>



<?php 
if ($totalRows_nota5_anio1>0){ // NOTA 5 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota5_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota5_anio1['def']<=20){echo $row_nota5_anio1['def'];} if($row_nota5_anio1['def']==99){echo "PE";} if($row_nota5_anio1['def']==98){echo "C";} if($row_nota5_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota5_anio1['def']==10){ echo "DIEZ";} if ($row_nota5_anio1['def']==11){ echo "ONCE";} if ($row_nota5_anio1['def']==12){ echo "DOCE";} if ($row_nota5_anio1['def']==13){ echo "TRECE";} if ($row_nota5_anio1['def']==14){ echo "CATORCE";} if ($row_nota5_anio1['def']==15){ echo "QUINCE";} if ($row_nota5_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota5_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota5_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota5_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota5_anio1['def']==20){ echo "VEINTE";} if ($row_nota5_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota5_anio1['def']==98){ echo "CURSADA";} if ($row_nota5_anio1['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota5_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota5_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota5_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota5_anio1['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 5 ANIO 1
if ($totalRows_nota5_anio4>0){ // NOTA 5 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota5_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota5_anio4['def']<=20){echo $row_nota5_anio4['def'];} if($row_nota5_anio4['def']==99){echo "PE";} if($row_nota5_anio4['def']==98){echo "C";} if($row_nota5_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota5_anio4['def']==10){ echo "DIEZ";} if ($row_nota5_anio4['def']==11){ echo "ONCE";} if ($row_nota5_anio4['def']==12){ echo "DOCE";} if ($row_nota5_anio4['def']==13){ echo "TRECE";} if ($row_nota5_anio4['def']==14){ echo "CATORCE";} if ($row_nota5_anio4['def']==15){ echo "QUINCE";} if ($row_nota5_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota5_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota5_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota5_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota5_anio4['def']==20){ echo "VEINTE";} if ($row_nota5_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota5_anio4['def']==98){ echo "CURSADA";} if ($row_nota5_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota5_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota5_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota5_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota5_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 5 ANIO 4
?>




<?php 
if ($totalRows_nota6_anio1>0){ // NOTA 6 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota6_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota6_anio1['def']<=20){echo $row_nota6_anio1['def'];} if($row_nota6_anio1['def']==99){echo "PE";} if($row_nota6_anio1['def']==98){echo "C";} if($row_nota6_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota6_anio1['def']==10){ echo "DIEZ";} if ($row_nota6_anio1['def']==11){ echo "ONCE";} if ($row_nota6_anio1['def']==12){ echo "DOCE";} if ($row_nota6_anio1['def']==13){ echo "TRECE";} if ($row_nota6_anio1['def']==14){ echo "CATORCE";} if ($row_nota6_anio1['def']==15){ echo "QUINCE";} if ($row_nota6_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota6_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota6_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota6_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota6_anio1['def']==20){ echo "VEINTE";}if ($row_nota6_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota6_anio1['def']==98){ echo "CURSADA";} if ($row_nota6_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota6_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota6_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota6_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota6_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 6 ANIO 1
if ($totalRows_nota6_anio4>0){ // NOTA 6 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota6_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota6_anio4['def']<=20){echo $row_nota6_anio4['def'];} if($row_nota6_anio4['def']==99){echo "PE";} if($row_nota6_anio4['def']==98){echo "C";} if($row_nota6_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota6_anio4['def']==10){ echo "DIEZ";} if ($row_nota6_anio4['def']==11){ echo "ONCE";} if ($row_nota6_anio4['def']==12){ echo "DOCE";} if ($row_nota6_anio4['def']==13){ echo "TRECE";} if ($row_nota6_anio4['def']==14){ echo "CATORCE";} if ($row_nota6_anio4['def']==15){ echo "QUINCE";} if ($row_nota6_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota6_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota6_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota6_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota6_anio4['def']==20){ echo "VEINTE";} if ($row_nota6_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota6_anio4['def']==98){ echo "CURSADA";} if ($row_nota6_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota6_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota6_anio4['fecha_mes']; ?>

	</div>
	<div class="fanio">
	<?php echo $row_nota6_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota6_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 6 ANIO 4
?>



<?php 
if ($totalRows_nota7_anio1>0){ // NOTA 7 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota7_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota7_anio1['def']<=20){echo $row_nota7_anio1['def'];} if($row_nota7_anio1['def']==99){echo "PE";} if($row_nota7_anio1['def']==98){echo "C";} if($row_nota7_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota7_anio1['def']==10){ echo "DIEZ";} if ($row_nota7_anio1['def']==11){ echo "ONCE";} if ($row_nota7_anio1['def']==12){ echo "DOCE";} if ($row_nota7_anio1['def']==13){ echo "TRECE";} if ($row_nota7_anio1['def']==14){ echo "CATORCE";} if ($row_nota7_anio1['def']==15){ echo "QUINCE";} if ($row_nota7_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota7_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota7_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota7_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota7_anio1['def']==20){ echo "VEINTE";}if ($row_nota7_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota7_anio1['def']==98){ echo "CURSADA";} if ($row_nota7_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota7_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota7_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota7_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota7_anio1['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 7 ANIO 1
if ($totalRows_nota7_anio4>0){ // NOTA 7 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota7_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota7_anio4['def']<=20){echo $row_nota7_anio4['def'];} if($row_nota7_anio4['def']==99){echo "PE";} if($row_nota7_anio4['def']==98){echo "C";} if($row_nota7_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota7_anio4['def']==10){ echo "DIEZ";} if ($row_nota7_anio4['def']==11){ echo "ONCE";} if ($row_nota7_anio4['def']==12){ echo "DOCE";} if ($row_nota7_anio4['def']==13){ echo "TRECE";} if ($row_nota7_anio4['def']==14){ echo "CATORCE";} if ($row_nota7_anio4['def']==15){ echo "QUINCE";} if ($row_nota7_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota7_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota7_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota7_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota7_anio4['def']==20){ echo "VEINTE";}if ($row_nota7_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota7_anio4['def']==98){ echo "CURSADA";} if ($row_nota7_anio4['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota7_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota7_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota7_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota7_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 7 ANIO 4
?>



<?php 
if ($totalRows_nota8_anio1>0){ // NOTA 8 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota8_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota8_anio1['def']<=20){echo $row_nota8_anio1['def'];} if($row_nota8_anio1['def']==99){echo "PE";} if($row_nota8_anio1['def']==98){echo "C";} if($row_nota8_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota8_anio1['def']==10){ echo "DIEZ";} if ($row_nota8_anio1['def']==11){ echo "ONCE";} if ($row_nota8_anio1['def']==12){ echo "DOCE";} if ($row_nota8_anio1['def']==13){ echo "TRECE";} if ($row_nota8_anio1['def']==14){ echo "CATORCE";} if ($row_nota8_anio1['def']==15){ echo "QUINCE";} if ($row_nota8_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota8_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota8_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota8_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota8_anio1['def']==20){ echo "VEINTE";}if ($row_nota8_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota8_anio1['def']==98){ echo "CURSADA";} if ($row_nota8_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota8_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota8_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota8_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota8_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 8 ANIO 1
if ($totalRows_nota8_anio4>0){ // NOTA 8 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota8_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota8_anio4['def']<=20){echo $row_nota8_anio4['def'];} if($row_nota8_anio4['def']==99){echo "PE";} if($row_nota8_anio4['def']==98){echo "C";} if($row_nota8_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota8_anio4['def']==10){ echo "DIEZ";} if ($row_nota8_anio4['def']==11){ echo "ONCE";} if ($row_nota8_anio4['def']==12){ echo "DOCE";} if ($row_nota8_anio4['def']==13){ echo "TRECE";} if ($row_nota8_anio4['def']==14){ echo "CATORCE";} if ($row_nota8_anio4['def']==15){ echo "QUINCE";} if ($row_nota8_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota8_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota8_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota8_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota8_anio4['def']==20){ echo "VEINTE";} if ($row_nota8_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota8_anio4['def']==98){ echo "CURSADA";} if ($row_nota8_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota8_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota8_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota8_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota8_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 8 ANIO 4
?>



<?php 
if ($totalRows_nota9_anio1>0){ // NOTA 9 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota9_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota9_anio1['def']<=20){echo $row_nota9_anio1['def'];} if($row_nota9_anio1['def']==99){echo "PE";} if($row_nota9_anio1['def']==98){echo "C";} if($row_nota9_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota9_anio1['def']==10){ echo "DIEZ";} if ($row_nota9_anio1['def']==11){ echo "ONCE";} if ($row_nota9_anio1['def']==12){ echo "DOCE";} if ($row_nota9_anio1['def']==13){ echo "TRECE";} if ($row_nota9_anio1['def']==14){ echo "CATORCE";} if ($row_nota9_anio1['def']==15){ echo "QUINCE";} if ($row_nota9_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota9_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota9_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota9_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota9_anio1['def']==20){ echo "VEINTE";} if ($row_nota9_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota9_anio1['def']==98){ echo "CURSADA";} if ($row_nota9_anio1['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota9_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota9_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota9_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota9_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 9 ANIO 1
if ($totalRows_nota9_anio4>0){ // NOTA 9 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota9_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota9_anio4['def']<=20){echo $row_nota9_anio4['def'];} if($row_nota9_anio4['def']==99){echo "PE";} if($row_nota9_anio4['def']==98){echo "C";} if($row_nota9_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota9_anio4['def']==10){ echo "DIEZ";} if ($row_nota9_anio4['def']==11){ echo "ONCE";} if ($row_nota9_anio4['def']==12){ echo "DOCE";} if ($row_nota9_anio4['def']==13){ echo "TRECE";} if ($row_nota9_anio4['def']==14){ echo "CATORCE";} if ($row_nota9_anio4['def']==15){ echo "QUINCE";} if ($row_nota9_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota9_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota9_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota9_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota9_anio4['def']==20){ echo "VEINTE";} if ($row_nota9_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota9_anio4['def']==98){ echo "CURSADA";} if ($row_nota9_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota9_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota9_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota9_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota9_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 9 ANIO 4
?>
<?php 
if (($totalRows_nota9_anio1==0)and($totalRows_nota9_anio4==0)){ // NOTA 9 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 9 
?>


<?php 
if ($totalRows_nota10_anio1>0){ // NOTA 10 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota10_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota10_anio1['def']<=20){echo $row_nota10_anio1['def'];} if($row_nota10_anio1['def']==99){echo "PE";} if($row_nota10_anio1['def']==98){echo "C";} if($row_nota10_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota10_anio1['def']==10){ echo "DIEZ";} if ($row_nota10_anio1['def']==11){ echo "ONCE";} if ($row_nota10_anio1['def']==12){ echo "DOCE";} if ($row_nota10_anio1['def']==13){ echo "TRECE";} if ($row_nota10_anio1['def']==14){ echo "CATORCE";} if ($row_nota10_anio1['def']==15){ echo "QUINCE";} if ($row_nota10_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota10_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota10_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota10_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota10_anio1['def']==20){ echo "VEINTE";} if ($row_nota10_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota10_anio1['def']==98){ echo "CURSADA";} if ($row_nota10_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota10_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota10_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota10_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota10_anio1['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 10 ANIO 1
if ($totalRows_nota10_anio4>0){ // NOTA 10 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota10_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota10_anio4['def']<=20){echo $row_nota10_anio4['def'];} if($row_nota10_anio4['def']==99){echo "PE";} if($row_nota10_anio4['def']==98){echo "C";} if($row_nota10_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota10_anio4['def']==10){ echo "DIEZ";} if ($row_nota10_anio4['def']==11){ echo "ONCE";} if ($row_nota10_anio4['def']==12){ echo "DOCE";} if ($row_nota10_anio4['def']==13){ echo "TRECE";} if ($row_nota10_anio4['def']==14){ echo "CATORCE";} if ($row_nota10_anio4['def']==15){ echo "QUINCE";} if ($row_nota10_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota10_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota10_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota10_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota10_anio4['def']==20){ echo "VEINTE";}if ($row_nota10_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota10_anio4['def']==98){ echo "CURSADA";} if ($row_nota10_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota10_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota10_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota10_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota10_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 10 ANIO 4
?>
<?php 
if (($totalRows_nota10_anio1==0)and($totalRows_nota10_anio4==0)){ // NOTA 10 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 10 
?>


<?php 
if ($totalRows_nota11_anio1>0){ // NOTA 11 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota11_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota11_anio1['def']<=20){echo $row_nota11_anio1['def'];} if($row_nota11_anio1['def']==99){echo "PE";} if($row_nota11_anio1['def']==98){echo "C";} if($row_nota11_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota11_anio1['def']==10){ echo "DIEZ";} if ($row_nota11_anio1['def']==11){ echo "ONCE";} if ($row_nota11_anio1['def']==12){ echo "DOCE";} if ($row_nota11_anio1['def']==13){ echo "TRECE";} if ($row_nota11_anio1['def']==14){ echo "CATORCE";} if ($row_nota11_anio1['def']==15){ echo "QUINCE";} if ($row_nota11_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota11_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota11_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota11_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota11_anio1['def']==20){ echo "VEINTE";} if ($row_nota11_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota11_anio1['def']==98){ echo "CURSADA";} if ($row_nota11_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota11_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota11_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota11_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota11_anio1['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 11 ANIO 1
if ($totalRows_nota11_anio4>0){ // NOTA 11 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota11_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota11_anio4['def']<=20){echo $row_nota11_anio4['def'];} if($row_nota11_anio4['def']==99){echo "PE";} if($row_nota11_anio4['def']==98){echo "C";} if($row_nota11_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota11_anio4['def']==10){ echo "DIEZ";} if ($row_nota11_anio4['def']==11){ echo "ONCE";} if ($row_nota11_anio4['def']==12){ echo "DOCE";} if ($row_nota11_anio4['def']==13){ echo "TRECE";} if ($row_nota11_anio4['def']==14){ echo "CATORCE";} if ($row_nota11_anio4['def']==15){ echo "QUINCE";} if ($row_nota11_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota11_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota11_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota11_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota11_anio4['def']==20){ echo "VEINTE";} if ($row_nota11_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota11_anio4['def']==98){ echo "CURSADA";} if ($row_nota11_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota11_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota11_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota11_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota11_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 11 ANIO 4
?>
<?php 
if (($totalRows_nota11_anio1==0)and($totalRows_nota11_anio4==0)){ // NOTA 11 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 11 
?>


<?php 
if ($totalRows_nota12_anio1>0){ // NOTA 12 DE ANIO 1
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota12_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota12_anio1['def']<=20){echo $row_nota12_anio1['def'];} if($row_nota12_anio1['def']==99){echo "PE";} if($row_nota12_anio1['def']==98){echo "C";} if($row_nota12_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota12_anio1['def']==10){ echo "DIEZ";} if ($row_nota12_anio1['def']==11){ echo "ONCE";} if ($row_nota12_anio1['def']==12){ echo "DOCE";} if ($row_nota12_anio1['def']==13){ echo "TRECE";} if ($row_nota12_anio1['def']==14){ echo "CATORCE";} if ($row_nota12_anio1['def']==15){ echo "QUINCE";} if ($row_nota12_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota12_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota12_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota12_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota12_anio1['def']==20){ echo "VEINTE";}if ($row_nota12_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota12_anio1['def']==98){ echo "CURSADA";} if ($row_nota12_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota12_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota12_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota12_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota12_anio1['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 12 ANIO 1
if ($totalRows_nota12_anio4>0){ // NOTA 12 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota12_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota12_anio4['def']<=20){echo $row_nota12_anio4['def'];} if($row_nota12_anio4['def']==99){echo "PE";} if($row_nota12_anio4['def']==98){echo "C";} if($row_nota12_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota12_anio4['def']==10){ echo "DIEZ";} if ($row_nota12_anio4['def']==11){ echo "ONCE";} if ($row_nota12_anio4['def']==12){ echo "DOCE";} if ($row_nota12_anio4['def']==13){ echo "TRECE";} if ($row_nota12_anio4['def']==14){ echo "CATORCE";} if ($row_nota12_anio4['def']==15){ echo "QUINCE";} if ($row_nota12_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota12_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota12_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota12_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota12_anio4['def']==20){ echo "VEINTE";} if ($row_nota12_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota12_anio4['def']==98){ echo "CURSADA";} if ($row_nota12_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota12_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota12_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota12_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota12_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 12 ANIO 4
?>
<?php 
if (($totalRows_nota12_anio1==0)and($totalRows_nota12_anio4==0)){ // NOTA 12 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 12 
?>


<?php 
if ($totalRows_nota13_anio1>0){ // NOTA 13 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota13_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota13_anio1['def']<=20){echo $row_nota13_anio1['def'];} if($row_nota13_anio1['def']==99){echo "PE";} if($row_nota13_anio1['def']==98){echo "C";} if($row_nota13_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota13_anio1['def']==10){ echo "DIEZ";} if ($row_nota13_anio1['def']==11){ echo "ONCE";} if ($row_nota13_anio1['def']==12){ echo "DOCE";} if ($row_nota13_anio1['def']==13){ echo "TRECE";} if ($row_nota13_anio1['def']==14){ echo "CATORCE";} if ($row_nota13_anio1['def']==15){ echo "QUINCE";} if ($row_nota13_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota13_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota13_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota13_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota13_anio1['def']==20){ echo "VEINTE";}if ($row_nota13_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota13_anio1['def']==98){ echo "CURSADA";} if ($row_nota13_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota13_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota13_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota13_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota13_anio1['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 13 ANIO 1
if ($totalRows_nota13_anio4>0){ // NOTA 13 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota13_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota13_anio4['def']<=20){echo $row_nota13_anio4['def'];} if($row_nota13_anio4['def']==99){echo "PE";} if($row_nota13_anio4['def']==98){echo "C";} if($row_nota13_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota13_anio4['def']==10){ echo "DIEZ";} if ($row_nota13_anio4['def']==11){ echo "ONCE";} if ($row_nota13_anio4['def']==12){ echo "DOCE";} if ($row_nota13_anio4['def']==13){ echo "TRECE";} if ($row_nota13_anio4['def']==14){ echo "CATORCE";} if ($row_nota13_anio4['def']==15){ echo "QUINCE";} if ($row_nota13_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota13_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota13_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota13_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota13_anio4['def']==20){ echo "VEINTE";}if ($row_nota13_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota13_anio4['def']==98){ echo "CURSADA";} if ($row_nota13_anio4['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota13_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota13_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota13_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota13_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 13 ANIO 4
?>

<?php 
if (($totalRows_nota13_anio1==0)and($totalRows_nota13_anio4==0)){ // NOTA 13 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 13 
?>


<?php 
if ($totalRows_nota14_anio1>0){ // NOTA 14 DE ANIO 1
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota14_anio1['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota14_anio1['def']<=20){echo $row_nota14_anio1['def'];} if($row_nota14_anio1['def']==99){echo "PE";} if($row_nota14_anio1['def']==98){echo "C";} if($row_nota14_anio1['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota14_anio1['def']==10){ echo "DIEZ";} if ($row_nota14_anio1['def']==11){ echo "ONCE";} if ($row_nota14_anio1['def']==12){ echo "DOCE";} if ($row_nota14_anio1['def']==13){ echo "TRECE";} if ($row_nota14_anio1['def']==14){ echo "CATORCE";} if ($row_nota14_anio1['def']==15){ echo "QUINCE";} if ($row_nota14_anio1['def']==16){ echo "DIECISEIS";} if ($row_nota14_anio1['def']==17){ echo "DIECISIETE";}  if ($row_nota14_anio1['def']==18){ echo "DIECIOCHO";} if ($row_nota14_anio1['def']==19){ echo "DIECINUEVE";} if ($row_nota14_anio1['def']==20){ echo "VEINTE";}if ($row_nota14_anio1['def']==99){ echo "PENDIENTE";} if ($row_nota14_anio1['def']==98){ echo "CURSADA";} if ($row_nota14_anio1['def']==97){ echo "EXONERADA";}  ?>
	</div>
	<div class="te">
	<?php echo $row_nota14_anio1['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota14_anio1['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota14_anio1['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota14_anio1['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 14 ANIO 1
if ($totalRows_nota14_anio4>0){ // NOTA 14 DE ANIO 4
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota14_anio4['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota14_anio4['def']<=20){echo $row_nota14_anio4['def'];} if($row_nota14_anio4['def']==99){echo "PE";} if($row_nota14_anio4['def']==98){echo "C";} if($row_nota14_anio4['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota14_anio4['def']==10){ echo "DIEZ";} if ($row_nota14_anio4['def']==11){ echo "ONCE";} if ($row_nota14_anio4['def']==12){ echo "DOCE";} if ($row_nota14_anio4['def']==13){ echo "TRECE";} if ($row_nota14_anio4['def']==14){ echo "CATORCE";} if ($row_nota14_anio4['def']==15){ echo "QUINCE";} if ($row_nota14_anio4['def']==16){ echo "DIECISEIS";} if ($row_nota14_anio4['def']==17){ echo "DIECISIETE";}  if ($row_nota14_anio4['def']==18){ echo "DIECIOCHO";} if ($row_nota14_anio4['def']==19){ echo "DIECINUEVE";} if ($row_nota14_anio4['def']==20){ echo "VEINTE";} if ($row_nota14_anio4['def']==99){ echo "PENDIENTE";} if ($row_nota14_anio4['def']==98){ echo "CURSADA";} if ($row_nota14_anio4['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota14_anio4['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota14_anio4['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota14_anio4['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota14_anio4['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 14 ANIO 4
?>
<?php 
if (($totalRows_nota14_anio1==0)and($totalRows_nota14_anio4==0)){ // NOTA 14 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 14 
?>

	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>


</div>

<?php // DESDE AQUI COMIENZA EL ANIO 2 Y 5
?>

<div class="container_titulos">

<div class="container_cuadro_left">
	<div class="cuadro_left">
	<b>A&ntilde;o o Grado: <?php if($totalRows_nota1_anio2>0) { echo $row_nota1_anio2['nombre_anio'];} if($totalRows_nota1_anio5>0) { echo $row_nota1_anio5['nombre_anio'];}  ?></b>
	</div>
	<div class="cuadro_left" style="text-align:center;">
	<b>Asignaturas</b>
	</div>

</div>

<div class="container_cuadro_medio_grande">
	<div class="cuadro_medio_grande">
	<b>Calificaci&oacute;n</b>
	</div>
	<div class="cuadro_medio_grande">
		<div class="enno">
		<b>En No.</b>
		</div>
		<div class="enletras">
		<b>En letras</b>
		</div>

	</div>
</div>

<div class="t-e">
<b>T-E</b>
</div>

<div class="container_fecha">
	<div class="fecha">
	<b>Fecha</b>
	</div>
	<div class="fecha">
		<div class="mes">
		<b>Mes</b>
		</div>
		<div class="anio">
		<b>A&ntilde;o</b>
		</div>
	</div>

</div>

<div class="container_plantel">
	<div class="plantel">
	<b>Plantel</b>
	</div>
	<div class="plantel">
	<b>No.</b>
	</div>
</div>

<div id="container_asignaturas">

<?php 
if ($totalRows_nota1_anio2>0){ // NOTA 1 DE ANIO 2
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota1_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota1_anio2['def']<=20){echo $row_nota1_anio2['def'];} if($row_nota1_anio2['def']==99){echo "PE";} if($row_nota1_anio2['def']==98){echo "C";} if($row_nota1_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota1_anio2['def']==10){ echo "DIEZ";} if ($row_nota1_anio2['def']==11){ echo "ONCE";} if ($row_nota1_anio2['def']==12){ echo "DOCE";} if ($row_nota1_anio2['def']==13){ echo "TRECE";} if ($row_nota1_anio2['def']==14){ echo "CATORCE";} if ($row_nota1_anio2['def']==15){ echo "QUINCE";} if ($row_nota1_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota1_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota1_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota1_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota1_anio2['def']==20){ echo "VEINTE";} if ($row_nota1_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota1_anio2['def']==98){ echo "CURSADA";} if ($row_nota1_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota1_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota1_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota1_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota1_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 1 ANIO 2
if ($totalRows_nota1_anio5>0){ // NOTA 1 DE ANIO 5
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota1_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota1_anio5['def']<=20){echo $row_nota1_anio5['def'];} if($row_nota1_anio5['def']==99){echo "PE";} if($row_nota1_anio5['def']==98){echo "C";} if($row_nota1_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota1_anio5['def']==10){ echo "DIEZ";} if ($row_nota1_anio5['def']==11){ echo "ONCE";} if ($row_nota1_anio5['def']==12){ echo "DOCE";} if ($row_nota1_anio5['def']==13){ echo "TRECE";} if ($row_nota1_anio5['def']==14){ echo "CATORCE";} if ($row_nota1_anio5['def']==15){ echo "QUINCE";} if ($row_nota1_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota1_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota1_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota1_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota1_anio5['def']==20){ echo "VEINTE";} if ($row_nota1_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota1_anio5['def']==98){ echo "CURSADA";} if ($row_nota1_anio5['def']==97){ echo "EXONERADA";} ?>


	</div>
	<div class="te">
	<?php echo $row_nota1_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota1_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota1_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota1_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 1 ANIO 5
?>

<?php 
if ($totalRows_nota2_anio2>0){ // NOTA 2 DE ANIO 5
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota2_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota2_anio2['def']<=20){echo $row_nota2_anio2['def'];} if($row_nota2_anio2['def']==99){echo "PE";} if($row_nota2_anio2['def']==98){echo "C";} if($row_nota2_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota2_anio2['def']==10){ echo "DIEZ";} if ($row_nota2_anio2['def']==11){ echo "ONCE";} if ($row_nota2_anio2['def']==12){ echo "DOCE";} if ($row_nota2_anio2['def']==13){ echo "TRECE";} if ($row_nota2_anio2['def']==14){ echo "CATORCE";} if ($row_nota2_anio2['def']==15){ echo "QUINCE";} if ($row_nota2_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota2_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota2_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota2_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota2_anio2['def']==20){ echo "VEINTE";} if ($row_nota2_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota2_anio2['def']==98){ echo "CURSADA";} if ($row_nota2_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota2_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota2_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota2_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota2_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 2 ANIO 2
if ($totalRows_nota2_anio5>0){ // NOTA 2 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota2_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota2_anio5['def']<=20){echo $row_nota2_anio5['def'];} if($row_nota2_anio5['def']==99){echo "PE";} if($row_nota2_anio5['def']==98){echo "C";} if($row_nota2_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota2_anio5['def']==10){ echo "DIEZ";} if ($row_nota2_anio5['def']==11){ echo "ONCE";} if ($row_nota2_anio5['def']==12){ echo "DOCE";} if ($row_nota2_anio5['def']==13){ echo "TRECE";} if ($row_nota2_anio5['def']==14){ echo "CATORCE";} if ($row_nota2_anio5['def']==15){ echo "QUINCE";} if ($row_nota2_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota2_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota2_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota2_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota2_anio5['def']==20){ echo "VEINTE";} if ($row_nota2_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota2_anio5['def']==98){ echo "CURSADA";} if ($row_nota2_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota2_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota2_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota2_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota2_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 2 ANIO 5
?>

<?php 
if ($totalRows_nota3_anio2>0){ // NOTA 2 DE ANIO 2
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota3_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota3_anio2['def']<=20){echo $row_nota3_anio2['def'];} if($row_nota3_anio2['def']==99){echo "PE";} if($row_nota3_anio2['def']==98){echo "C";} if($row_nota3_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota3_anio2['def']==10){ echo "DIEZ";} if ($row_nota3_anio2['def']==11){ echo "ONCE";} if ($row_nota3_anio2['def']==12){ echo "DOCE";} if ($row_nota3_anio2['def']==13){ echo "TRECE";} if ($row_nota3_anio2['def']==14){ echo "CATORCE";} if ($row_nota3_anio2['def']==15){ echo "QUINCE";} if ($row_nota3_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota3_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota3_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota3_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota3_anio2['def']==20){ echo "VEINTE";} if ($row_nota3_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota3_anio2['def']==98){ echo "CURSADA";} if ($row_nota3_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota3_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota3_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota3_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota3_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 3 ANIO 5
if ($totalRows_nota3_anio5>0){ // NOTA 3 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota3_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota3_anio5['def']<=20){echo $row_nota3_anio5['def'];} if($row_nota3_anio5['def']==99){echo "PE";} if($row_nota3_anio5['def']==98){echo "C";} if($row_nota3_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota3_anio5['def']==10){ echo "DIEZ";} if ($row_nota3_anio5['def']==11){ echo "ONCE";} if ($row_nota3_anio5['def']==12){ echo "DOCE";} if ($row_nota3_anio5['def']==13){ echo "TRECE";} if ($row_nota3_anio5['def']==14){ echo "CATORCE";} if ($row_nota3_anio5['def']==15){ echo "QUINCE";} if ($row_nota3_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota3_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota3_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota3_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota3_anio5['def']==20){ echo "VEINTE";} if ($row_nota3_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota3_anio5['def']==98){ echo "CURSADA";} if ($row_nota3_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota3_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota3_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota3_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota3_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 3 ANIO 5
?>


<?php 
if ($totalRows_nota4_anio2>0){ // NOTA 4 DE ANIO 2
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota4_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota4_anio2['def']<=20){echo $row_nota4_anio2['def'];} if($row_nota4_anio2['def']==99){echo "PE";} if($row_nota4_anio2['def']==98){echo "C";} if($row_nota4_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota4_anio2['def']==10){ echo "DIEZ";} if ($row_nota4_anio2['def']==11){ echo "ONCE";} if ($row_nota4_anio2['def']==12){ echo "DOCE";} if ($row_nota4_anio2['def']==13){ echo "TRECE";} if ($row_nota4_anio2['def']==14){ echo "CATORCE";} if ($row_nota4_anio2['def']==15){ echo "QUINCE";} if ($row_nota4_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota4_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota4_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota4_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota4_anio2['def']==20){ echo "VEINTE";} if ($row_nota4_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota4_anio2['def']==98){ echo "CURSADA";} if ($row_nota4_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota4_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota4_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota4_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota4_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 4 ANIO 2
if ($totalRows_nota4_anio5>0){ // NOTA 4 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota4_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota4_anio5['def']<=20){echo $row_nota4_anio5['def'];} if($row_nota4_anio5['def']==99){echo "PE";} if($row_nota4_anio5['def']==98){echo "C";} if($row_nota4_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota4_anio5['def']==10){ echo "DIEZ";} if ($row_nota4_anio5['def']==11){ echo "ONCE";} if ($row_nota4_anio5['def']==12){ echo "DOCE";} if ($row_nota4_anio5['def']==13){ echo "TRECE";} if ($row_nota4_anio5['def']==14){ echo "CATORCE";} if ($row_nota4_anio5['def']==15){ echo "QUINCE";} if ($row_nota4_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota4_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota4_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota4_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota4_anio5['def']==20){ echo "VEINTE";} if ($row_nota4_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota4_anio5['def']==98){ echo "CURSADA";} if ($row_nota4_anio5['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota4_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota4_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota4_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota4_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 4 ANIO 5
?>



<?php 
if ($totalRows_nota5_anio2>0){ // NOTA 5 DE ANIO 2
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota5_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota5_anio2['def']<=20){echo $row_nota5_anio2['def'];} if($row_nota5_anio2['def']==99){echo "PE";} if($row_nota5_anio2['def']==98){echo "C";} if($row_nota5_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota5_anio2['def']==10){ echo "DIEZ";} if ($row_nota5_anio2['def']==11){ echo "ONCE";} if ($row_nota5_anio2['def']==12){ echo "DOCE";} if ($row_nota5_anio2['def']==13){ echo "TRECE";} if ($row_nota5_anio2['def']==14){ echo "CATORCE";} if ($row_nota5_anio2['def']==15){ echo "QUINCE";} if ($row_nota5_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota5_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota5_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota5_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota5_anio2['def']==20){ echo "VEINTE";} if ($row_nota5_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota5_anio2['def']==98){ echo "CURSADA";} if ($row_nota5_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota5_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota5_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota5_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota5_anio2['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 5 ANIO 2
if ($totalRows_nota5_anio5>0){ // NOTA 5 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota5_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota5_anio5['def']<=20){echo $row_nota5_anio5['def'];} if($row_nota5_anio5['def']==99){echo "PE";} if($row_nota5_anio5['def']==98){echo "C";} if($row_nota5_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota5_anio5['def']==10){ echo "DIEZ";} if ($row_nota5_anio5['def']==11){ echo "ONCE";} if ($row_nota5_anio5['def']==12){ echo "DOCE";} if ($row_nota5_anio5['def']==13){ echo "TRECE";} if ($row_nota5_anio5['def']==14){ echo "CATORCE";} if ($row_nota5_anio5['def']==15){ echo "QUINCE";} if ($row_nota5_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota5_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota5_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota5_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota5_anio5['def']==20){ echo "VEINTE";} if ($row_nota5_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota5_anio5['def']==98){ echo "CURSADA";} if ($row_nota5_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota5_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota5_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota5_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota5_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 5 ANIO 5
?>




<?php 
if ($totalRows_nota6_anio2>0){ // NOTA 6 DE ANIO 2
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota6_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota6_anio2['def']<=20){echo $row_nota6_anio2['def'];} if($row_nota6_anio2['def']==99){echo "PE";} if($row_nota6_anio2['def']==98){echo "C";} if($row_nota6_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota6_anio2['def']==10){ echo "DIEZ";} if ($row_nota6_anio2['def']==11){ echo "ONCE";} if ($row_nota6_anio2['def']==12){ echo "DOCE";} if ($row_nota6_anio2['def']==13){ echo "TRECE";} if ($row_nota6_anio2['def']==14){ echo "CATORCE";} if ($row_nota6_anio2['def']==15){ echo "QUINCE";} if ($row_nota6_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota6_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota6_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota6_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota6_anio2['def']==20){ echo "VEINTE";} if ($row_nota6_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota6_anio2['def']==98){ echo "CURSADA";} if ($row_nota6_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota6_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota6_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota6_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota6_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 6 ANIO 2
if ($totalRows_nota6_anio5>0){ // NOTA 6 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota6_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota6_anio5['def']<=20){echo $row_nota6_anio5['def'];} if($row_nota6_anio5['def']==99){echo "PE";} if($row_nota6_anio5['def']==98){echo "C";} if($row_nota6_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota6_anio5['def']==10){ echo "DIEZ";} if ($row_nota6_anio5['def']==11){ echo "ONCE";} if ($row_nota6_anio5['def']==12){ echo "DOCE";} if ($row_nota6_anio5['def']==13){ echo "TRECE";} if ($row_nota6_anio5['def']==14){ echo "CATORCE";} if ($row_nota6_anio5['def']==15){ echo "QUINCE";} if ($row_nota6_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota6_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota6_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota6_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota6_anio5['def']==20){ echo "VEINTE";} if ($row_nota6_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota6_anio5['def']==98){ echo "CURSADA";} if ($row_nota6_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota6_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota6_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota6_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota6_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 6 ANIO 5
?>



<?php 
if ($totalRows_nota7_anio2>0){ // NOTA 7 DE ANIO 2
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota7_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota7_anio2['def']<=20){echo $row_nota7_anio2['def'];} if($row_nota7_anio2['def']==99){echo "PE";} if($row_nota7_anio2['def']==98){echo "C";} if($row_nota7_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota7_anio2['def']==10){ echo "DIEZ";} if ($row_nota7_anio2['def']==11){ echo "ONCE";} if ($row_nota7_anio2['def']==12){ echo "DOCE";} if ($row_nota7_anio2['def']==13){ echo "TRECE";} if ($row_nota7_anio2['def']==14){ echo "CATORCE";} if ($row_nota7_anio2['def']==15){ echo "QUINCE";} if ($row_nota7_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota7_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota7_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota7_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota7_anio2['def']==20){ echo "VEINTE";} if ($row_nota7_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota7_anio2['def']==98){ echo "CURSADA";} if ($row_nota7_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota7_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota7_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota7_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota7_anio2['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 7 ANIO 2
if ($totalRows_nota7_anio5>0){ // NOTA 7 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota7_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota7_anio5['def']<=20){echo $row_nota7_anio5['def'];} if($row_nota7_anio5['def']==99){echo "PE";} if($row_nota7_anio5['def']==98){echo "C";} if($row_nota7_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota7_anio5['def']==10){ echo "DIEZ";} if ($row_nota7_anio5['def']==11){ echo "ONCE";} if ($row_nota7_anio5['def']==12){ echo "DOCE";} if ($row_nota7_anio5['def']==13){ echo "TRECE";} if ($row_nota7_anio5['def']==14){ echo "CATORCE";} if ($row_nota7_anio5['def']==15){ echo "QUINCE";} if ($row_nota7_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota7_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota7_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota7_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota7_anio5['def']==20){ echo "VEINTE";} if ($row_nota7_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota7_anio5['def']==98){ echo "CURSADA";} if ($row_nota7_anio5['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota7_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota7_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota7_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota7_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 7 ANIO 5
?>



<?php 
if ($totalRows_nota8_anio2>0){ // NOTA 8 DE ANIO 2
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota8_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota8_anio2['def']<=20){echo $row_nota8_anio2['def'];} if($row_nota8_anio2['def']==99){echo "PE";} if($row_nota8_anio2['def']==98){echo "C";} if($row_nota8_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota8_anio2['def']==10){ echo "DIEZ";} if ($row_nota8_anio2['def']==11){ echo "ONCE";} if ($row_nota8_anio2['def']==12){ echo "DOCE";} if ($row_nota8_anio2['def']==13){ echo "TRECE";} if ($row_nota8_anio2['def']==14){ echo "CATORCE";} if ($row_nota8_anio2['def']==15){ echo "QUINCE";} if ($row_nota8_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota8_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota8_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota8_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota8_anio2['def']==20){ echo "VEINTE";} if ($row_nota8_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota8_anio2['def']==98){ echo "CURSADA";} if ($row_nota8_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota8_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota8_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota8_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota8_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 8 ANIO 2
if ($totalRows_nota8_anio5>0){ // NOTA 8 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota8_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota8_anio5['def']<=20){echo $row_nota8_anio5['def'];} if($row_nota8_anio5['def']==99){echo "PE";} if($row_nota8_anio5['def']==98){echo "C";} if($row_nota8_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota8_anio5['def']==10){ echo "DIEZ";} if ($row_nota8_anio5['def']==11){ echo "ONCE";} if ($row_nota8_anio5['def']==12){ echo "DOCE";} if ($row_nota8_anio5['def']==13){ echo "TRECE";} if ($row_nota8_anio5['def']==14){ echo "CATORCE";} if ($row_nota8_anio5['def']==15){ echo "QUINCE";} if ($row_nota8_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota8_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota8_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota8_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota8_anio5['def']==20){ echo "VEINTE";} if ($row_nota8_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota8_anio5['def']==98){ echo "CURSADA";} if ($row_nota8_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota8_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota8_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota8_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota8_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 8 ANIO 5
?>



<?php 
if ($totalRows_nota9_anio2>0){ // NOTA 9 DE ANIO 2
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota9_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota9_anio2['def']<=20){echo $row_nota9_anio2['def'];} if($row_nota9_anio2['def']==99){echo "PE";} if($row_nota9_anio2['def']==98){echo "C";} if($row_nota9_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota9_anio2['def']==10){ echo "DIEZ";} if ($row_nota9_anio2['def']==11){ echo "ONCE";} if ($row_nota9_anio2['def']==12){ echo "DOCE";} if ($row_nota9_anio2['def']==13){ echo "TRECE";} if ($row_nota9_anio2['def']==14){ echo "CATORCE";} if ($row_nota9_anio2['def']==15){ echo "QUINCE";} if ($row_nota9_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota9_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota9_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota9_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota9_anio2['def']==20){ echo "VEINTE";} if ($row_nota9_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota9_anio2['def']==98){ echo "CURSADA";} if ($row_nota9_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota9_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota9_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota9_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota9_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 9 ANIO 2
if ($totalRows_nota9_anio5>0){ // NOTA 9 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota9_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota9_anio5['def']<=20){echo $row_nota9_anio5['def'];} if($row_nota9_anio5['def']==99){echo "PE";} if($row_nota9_anio5['def']==98){echo "C";} if($row_nota9_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota9_anio5['def']==10){ echo "DIEZ";} if ($row_nota9_anio5['def']==11){ echo "ONCE";} if ($row_nota9_anio5['def']==12){ echo "DOCE";} if ($row_nota9_anio5['def']==13){ echo "TRECE";} if ($row_nota9_anio5['def']==14){ echo "CATORCE";} if ($row_nota9_anio5['def']==15){ echo "QUINCE";} if ($row_nota9_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota9_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota9_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota9_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota9_anio5['def']==20){ echo "VEINTE";} if ($row_nota9_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota9_anio5['def']==98){ echo "CURSADA";} if ($row_nota9_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota9_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota9_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota9_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota9_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 9 ANIO 5
?>
<?php 
if (($totalRows_nota9_anio2==0)and($totalRows_nota9_anio5==0)){ // NOTA 9 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 9 
?>


<?php 
if ($totalRows_nota10_anio2>0){ // NOTA 10 DE ANIO 1
?>

	<div class="mate">

	&nbsp;<?php echo $row_nota10_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota10_anio2['def']<=20){echo $row_nota10_anio2['def'];} if($row_nota10_anio2['def']==99){echo "PE";} if($row_nota10_anio2['def']==98){echo "C";} if($row_nota10_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota10_anio2['def']==10){ echo "DIEZ";} if ($row_nota10_anio2['def']==11){ echo "ONCE";} if ($row_nota10_anio2['def']==12){ echo "DOCE";} if ($row_nota10_anio2['def']==13){ echo "TRECE";} if ($row_nota10_anio2['def']==14){ echo "CATORCE";} if ($row_nota10_anio2['def']==15){ echo "QUINCE";} if ($row_nota10_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota10_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota10_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota10_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota10_anio2['def']==20){ echo "VEINTE";} if ($row_nota10_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota10_anio2['def']==98){ echo "CURSADA";} if ($row_nota10_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota10_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota10_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota10_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota10_anio2['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 10 ANIO 2
if ($totalRows_nota10_anio5>0){ // NOTA 10 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota10_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota10_anio5['def']<=20){echo $row_nota10_anio5['def'];} if($row_nota10_anio5['def']==99){echo "PE";} if($row_nota10_anio5['def']==98){echo "C";} if($row_nota10_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota10_anio5['def']==10){ echo "DIEZ";} if ($row_nota10_anio5['def']==11){ echo "ONCE";} if ($row_nota10_anio5['def']==12){ echo "DOCE";} if ($row_nota10_anio5['def']==13){ echo "TRECE";} if ($row_nota10_anio5['def']==14){ echo "CATORCE";} if ($row_nota10_anio5['def']==15){ echo "QUINCE";} if ($row_nota10_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota10_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota10_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota10_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota10_anio5['def']==20){ echo "VEINTE";} if ($row_nota10_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota10_anio5['def']==98){ echo "CURSADA";} if ($row_nota10_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota10_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota10_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota10_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota10_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 10 ANIO 5
?>
<?php 
if (($totalRows_nota10_anio2==0)and($totalRows_nota10_anio5==0)){ // NOTA 10 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 10 
?>


<?php 
if ($totalRows_nota11_anio2>0){ // NOTA 11 DE ANIO 2
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota11_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota11_anio2['def']<=20){echo $row_nota11_anio2['def'];} if($row_nota11_anio2['def']==99){echo "PE";} if($row_nota11_anio2['def']==98){echo "C";} if($row_nota11_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota11_anio2['def']==10){ echo "DIEZ";} if ($row_nota11_anio2['def']==11){ echo "ONCE";} if ($row_nota11_anio2['def']==12){ echo "DOCE";} if ($row_nota11_anio2['def']==13){ echo "TRECE";} if ($row_nota11_anio2['def']==14){ echo "CATORCE";} if ($row_nota11_anio2['def']==15){ echo "QUINCE";} if ($row_nota11_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota11_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota11_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota11_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota11_anio2['def']==20){ echo "VEINTE";} if ($row_nota11_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota11_anio2['def']==98){ echo "CURSADA";} if ($row_nota11_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota11_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota11_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota11_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota11_anio2['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 11 ANIO 2
if ($totalRows_nota11_anio5>0){ // NOTA 11 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota11_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota11_anio5['def']<=20){echo $row_nota11_anio5['def'];} if($row_nota11_anio5['def']==99){echo "PE";} if($row_nota11_anio5['def']==98){echo "C";} if($row_nota11_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota11_anio5['def']==10){ echo "DIEZ";} if ($row_nota11_anio5['def']==11){ echo "ONCE";} if ($row_nota11_anio5['def']==12){ echo "DOCE";} if ($row_nota11_anio5['def']==13){ echo "TRECE";} if ($row_nota11_anio5['def']==14){ echo "CATORCE";} if ($row_nota11_anio5['def']==15){ echo "QUINCE";} if ($row_nota11_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota11_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota11_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota11_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota11_anio5['def']==20){ echo "VEINTE";} if ($row_nota11_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota11_anio5['def']==98){ echo "CURSADA";} if ($row_nota11_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota11_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota11_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota11_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota11_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 11 ANIO 5
?>
<?php 
if (($totalRows_nota11_anio2==0)and($totalRows_nota11_anio5==0)){ // NOTA 11 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*

	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 11 
?>


<?php 
if ($totalRows_nota12_anio2>0){ // NOTA 12 DE ANIO 2
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota12_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota12_anio2['def']<=20){echo $row_nota12_anio2['def'];} if($row_nota12_anio2['def']==99){echo "PE";} if($row_nota12_anio2['def']==98){echo "C";} if($row_nota12_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota12_anio2['def']==10){ echo "DIEZ";} if ($row_nota12_anio2['def']==11){ echo "ONCE";} if ($row_nota12_anio2['def']==12){ echo "DOCE";} if ($row_nota12_anio2['def']==13){ echo "TRECE";} if ($row_nota12_anio2['def']==14){ echo "CATORCE";} if ($row_nota12_anio2['def']==15){ echo "QUINCE";} if ($row_nota12_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota12_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota12_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota12_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota12_anio2['def']==20){ echo "VEINTE";} if ($row_nota12_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota12_anio2['def']==98){ echo "CURSADA";} if ($row_nota12_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota12_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota12_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota12_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota12_anio2['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 12 ANIO 2
if ($totalRows_nota12_anio5>0){ // NOTA 12 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota12_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota12_anio5['def']<=20){echo $row_nota12_anio5['def'];} if($row_nota12_anio5['def']==99){echo "PE";} if($row_nota12_anio5['def']==98){echo "C";} if($row_nota12_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota12_anio5['def']==10){ echo "DIEZ";} if ($row_nota12_anio5['def']==11){ echo "ONCE";} if ($row_nota12_anio5['def']==12){ echo "DOCE";} if ($row_nota12_anio5['def']==13){ echo "TRECE";} if ($row_nota12_anio5['def']==14){ echo "CATORCE";} if ($row_nota12_anio5['def']==15){ echo "QUINCE";} if ($row_nota12_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota12_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota12_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota12_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota12_anio5['def']==20){ echo "VEINTE";} if ($row_nota12_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota12_anio5['def']==98){ echo "CURSADA";} if ($row_nota12_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota12_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota12_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota12_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota12_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 12 ANIO 5
?>
<?php 
if (($totalRows_nota12_anio2==0)and($totalRows_nota12_anio5==0)){ // NOTA 12 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 12 
?>


<?php 
if ($totalRows_nota13_anio2>0){ // NOTA 13 DE ANIO 2
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota13_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota13_anio2['def']<=20){echo $row_nota13_anio2['def'];} if($row_nota13_anio2['def']==99){echo "PE";} if($row_nota13_anio2['def']==98){echo "C";} if($row_nota13_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota13_anio2['def']==10){ echo "DIEZ";} if ($row_nota13_anio2['def']==11){ echo "ONCE";} if ($row_nota13_anio2['def']==12){ echo "DOCE";} if ($row_nota13_anio2['def']==13){ echo "TRECE";} if ($row_nota13_anio2['def']==14){ echo "CATORCE";} if ($row_nota13_anio2['def']==15){ echo "QUINCE";} if ($row_nota13_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota13_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota13_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota13_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota13_anio2['def']==20){ echo "VEINTE";} if ($row_nota13_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota13_anio2['def']==98){ echo "CURSADA";} if ($row_nota13_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota13_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota13_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota13_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota13_anio2['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 13 ANIO 2
if ($totalRows_nota13_anio5>0){ // NOTA 13 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota13_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota13_anio5['def']<=20){echo $row_nota13_anio5['def'];} if($row_nota13_anio5['def']==99){echo "PE";} if($row_nota13_anio5['def']==98){echo "C";} if($row_nota13_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota13_anio5['def']==10){ echo "DIEZ";} if ($row_nota13_anio5['def']==11){ echo "ONCE";} if ($row_nota13_anio5['def']==12){ echo "DOCE";} if ($row_nota13_anio5['def']==13){ echo "TRECE";} if ($row_nota13_anio5['def']==14){ echo "CATORCE";} if ($row_nota13_anio5['def']==15){ echo "QUINCE";} if ($row_nota13_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota13_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota13_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota13_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota13_anio5['def']==20){ echo "VEINTE";} if ($row_nota13_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota13_anio5['def']==98){ echo "CURSADA";} if ($row_nota13_anio5['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota13_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota13_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota13_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota13_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 13 ANIO 4
?>

<?php 
if (($totalRows_nota13_anio2==0)and($totalRows_nota13_anio5==0)){ // NOTA 13 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 13 
?>


<?php 
if ($totalRows_nota14_anio2>0){ // NOTA 14 DE ANIO 2
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota14_anio2['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota14_anio2['def']<=20){echo $row_nota14_anio2['def'];} if($row_nota14_anio2['def']==99){echo "PE";} if($row_nota14_anio2['def']==98){echo "C";} if($row_nota14_anio2['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota14_anio2['def']==10){ echo "DIEZ";} if ($row_nota14_anio2['def']==11){ echo "ONCE";} if ($row_nota14_anio2['def']==12){ echo "DOCE";} if ($row_nota14_anio2['def']==13){ echo "TRECE";} if ($row_nota14_anio2['def']==14){ echo "CATORCE";} if ($row_nota14_anio2['def']==15){ echo "QUINCE";} if ($row_nota14_anio2['def']==16){ echo "DIECISEIS";} if ($row_nota14_anio2['def']==17){ echo "DIECISIETE";}  if ($row_nota14_anio2['def']==18){ echo "DIECIOCHO";} if ($row_nota14_anio2['def']==19){ echo "DIECINUEVE";} if ($row_nota14_anio2['def']==20){ echo "VEINTE";} if ($row_nota14_anio2['def']==99){ echo "PENDIENTE";} if ($row_nota14_anio2['def']==98){ echo "CURSADA";} if ($row_nota14_anio2['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota14_anio2['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota14_anio2['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota14_anio2['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota14_anio2['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 14 ANIO 2
if ($totalRows_nota14_anio5>0){ // NOTA 14 DE ANIO 5
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota14_anio5['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota14_anio5['def']<=20){echo $row_nota14_anio5['def'];} if($row_nota14_anio5['def']==99){echo "PE";} if($row_nota14_anio5['def']==98){echo "C";} if($row_nota14_anio5['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota14_anio5['def']==10){ echo "DIEZ";} if ($row_nota14_anio5['def']==11){ echo "ONCE";} if ($row_nota14_anio5['def']==12){ echo "DOCE";} if ($row_nota14_anio5['def']==13){ echo "TRECE";} if ($row_nota14_anio5['def']==14){ echo "CATORCE";} if ($row_nota14_anio5['def']==15){ echo "QUINCE";} if ($row_nota14_anio5['def']==16){ echo "DIECISEIS";} if ($row_nota14_anio5['def']==17){ echo "DIECISIETE";}  if ($row_nota14_anio5['def']==18){ echo "DIECIOCHO";} if ($row_nota14_anio5['def']==19){ echo "DIECINUEVE";} if ($row_nota14_anio5['def']==20){ echo "VEINTE";} if ($row_nota14_anio5['def']==99){ echo "PENDIENTE";} if ($row_nota14_anio5['def']==98){ echo "CURSADA";} if ($row_nota14_anio5['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota14_anio5['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota14_anio5['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota14_anio5['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota14_anio5['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 14 ANIO 5
?>
<?php 
if (($totalRows_nota14_anio2==0)and($totalRows_nota14_anio5==0)){ // NOTA 14 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 14 
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>

</div>

<?php // AQUI COMIENZA EL ANIO 3 Y 6
?>

<?php if(($totalRows_nota1_anio6>0)or($totalRows_nota1_anio3>0)){?>
<div class="container_titulos">

<div class="container_cuadro_left">
	<div class="cuadro_left">
	<b>A&ntilde;o o Grado: <?php if($totalRows_nota1_anio3>0) { echo $row_nota1_anio3['nombre_anio'];} if($totalRows_nota1_anio6>0) { echo $row_nota1_anio5['nombre_anio'];}  ?></b>
	</div>
	<div class="cuadro_left" style="text-align:center;">
	<b>Asignaturas</b>
	</div>

</div>


<div class="container_cuadro_medio_grande">
	<div class="cuadro_medio_grande">
	<b>Calificaci&oacute;n</b>
	</div>
	<div class="cuadro_medio_grande">
		<div class="enno">
		<b>En No.</b>
		</div>
		<div class="enletras">
		<b>En letras</b>
		</div>

	</div>
</div>

<div class="t-e">
<b>T-E</b>
</div>

<div class="container_fecha">
	<div class="fecha">
	<b>Fecha</b>
	</div>
	<div class="fecha">
		<div class="mes">
		<b>Mes</b>
		</div>
		<div class="anio">
		<b>A&ntilde;o</b>
		</div>
	</div>

</div>

<div class="container_plantel">
	<div class="plantel">
	<b>Plantel</b>
	</div>
	<div class="plantel">
	<b>No.</b>
	</div>
</div>
<?php }?>


<div id="container_asignaturas">

<?php 
if ($totalRows_nota1_anio3>0){ // NOTA 1 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota1_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota1_anio3['def']<=20){echo $row_nota1_anio3['def'];} if($row_nota1_anio3['def']==99){echo "PE";} if($row_nota1_anio3['def']==98){echo "C";} if($row_nota1_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota1_anio3['def']==10){ echo "DIEZ";} if ($row_nota1_anio3['def']==11){ echo "ONCE";} if ($row_nota1_anio3['def']==12){ echo "DOCE";} if ($row_nota1_anio3['def']==13){ echo "TRECE";} if ($row_nota1_anio3['def']==14){ echo "CATORCE";} if ($row_nota1_anio3['def']==15){ echo "QUINCE";} if ($row_nota1_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota1_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota1_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota1_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota1_anio3['def']==20){ echo "VEINTE";} if ($row_nota1_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota1_anio3['def']==98){ echo "CURSADA";} if ($row_nota1_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota1_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota1_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota1_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota1_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 1 ANIO 3
if ($totalRows_nota1_anio6>0){ // NOTA 1 DE ANIO 6
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota1_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota1_anio6['def']<=20){echo $row_nota1_anio6['def'];} if($row_nota1_anio6['def']==99){echo "PE";} if($row_nota1_anio6['def']==98){echo "C";} if($row_nota1_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota1_anio6['def']==10){ echo "DIEZ";} if ($row_nota1_anio6['def']==11){ echo "ONCE";} if ($row_nota1_anio6['def']==12){ echo "DOCE";} if ($row_nota1_anio6['def']==13){ echo "TRECE";} if ($row_nota1_anio6['def']==14){ echo "CATORCE";} if ($row_nota1_anio6['def']==15){ echo "QUINCE";} if ($row_nota1_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota1_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota1_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota1_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota1_anio6['def']==20){ echo "VEINTE";} if ($row_nota1_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota1_anio6['def']==98){ echo "CURSADA";} if ($row_nota1_anio6['def']==97){ echo "EXONERADA";} ?>


	</div>
	<div class="te">
	<?php echo $row_nota1_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota1_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota1_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota1_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 1 ANIO 6
?>

<?php 
if ($totalRows_nota2_anio3>0){ // NOTA 2 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota2_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota2_anio3['def']<=20){echo $row_nota2_anio3['def'];} if($row_nota2_anio3['def']==99){echo "PE";} if($row_nota2_anio3['def']==98){echo "C";} if($row_nota2_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota2_anio3['def']==10){ echo "DIEZ";} if ($row_nota2_anio3['def']==11){ echo "ONCE";} if ($row_nota2_anio3['def']==12){ echo "DOCE";} if ($row_nota2_anio3['def']==13){ echo "TRECE";} if ($row_nota2_anio3['def']==14){ echo "CATORCE";} if ($row_nota2_anio3['def']==15){ echo "QUINCE";} if ($row_nota2_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota2_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota2_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota2_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota2_anio3['def']==20){ echo "VEINTE";} if ($row_nota2_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota2_anio3['def']==98){ echo "CURSADA";} if ($row_nota2_anio3['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota2_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota2_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota2_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota2_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 2 ANIO 3
if ($totalRows_nota2_anio6>0){ // NOTA 2 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota2_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota2_anio6['def']<=20){echo $row_nota2_anio6['def'];} if($row_nota2_anio6['def']==99){echo "PE";} if($row_nota2_anio6['def']==98){echo "C";} if($row_nota2_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota2_anio6['def']==10){ echo "DIEZ";} if ($row_nota2_anio6['def']==11){ echo "ONCE";} if ($row_nota2_anio6['def']==12){ echo "DOCE";} if ($row_nota2_anio6['def']==13){ echo "TRECE";} if ($row_nota2_anio6['def']==14){ echo "CATORCE";} if ($row_nota2_anio6['def']==15){ echo "QUINCE";} if ($row_nota2_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota2_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota2_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota2_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota2_anio6['def']==20){ echo "VEINTE";} if ($row_nota2_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota2_anio6['def']==98){ echo "CURSADA";} if ($row_nota2_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota2_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota2_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota2_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota2_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 2 ANIO 6
?>

<?php 
if ($totalRows_nota3_anio3>0){ // NOTA 2 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota3_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota3_anio3['def']<=20){echo $row_nota3_anio3['def'];} if($row_nota3_anio3['def']==99){echo "PE";} if($row_nota3_anio3['def']==98){echo "C";} if($row_nota3_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota3_anio3['def']==10){ echo "DIEZ";} if ($row_nota3_anio3['def']==11){ echo "ONCE";} if ($row_nota3_anio3['def']==12){ echo "DOCE";} if ($row_nota3_anio3['def']==13){ echo "TRECE";} if ($row_nota3_anio3['def']==14){ echo "CATORCE";} if ($row_nota3_anio3['def']==15){ echo "QUINCE";} if ($row_nota3_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota3_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota3_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota3_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota3_anio3['def']==20){ echo "VEINTE";} if ($row_nota3_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota3_anio3['def']==98){ echo "CURSADA";} if ($row_nota3_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota3_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota3_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota3_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota3_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 3 ANIO 6
if ($totalRows_nota3_anio6>0){ // NOTA 3 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota3_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota3_anio6['def']<=20){echo $row_nota3_anio6['def'];} if($row_nota3_anio6['def']==99){echo "PE";} if($row_nota3_anio6['def']==98){echo "C";} if($row_nota3_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota3_anio6['def']==10){ echo "DIEZ";} if ($row_nota3_anio6['def']==11){ echo "ONCE";} if ($row_nota3_anio6['def']==12){ echo "DOCE";} if ($row_nota3_anio6['def']==13){ echo "TRECE";} if ($row_nota3_anio6['def']==14){ echo "CATORCE";} if ($row_nota3_anio6['def']==15){ echo "QUINCE";} if ($row_nota3_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota3_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota3_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota3_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota3_anio6['def']==20){ echo "VEINTE";} if ($row_nota3_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota3_anio6['def']==98){ echo "CURSADA";} if ($row_nota3_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota3_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota3_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota3_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota3_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 3 ANIO 6
?>


<?php 
if ($totalRows_nota4_anio3>0){ // NOTA 4 DE ANIO 3
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota4_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota4_anio3['def']<=20){echo $row_nota4_anio3['def'];} if($row_nota4_anio3['def']==99){echo "PE";} if($row_nota4_anio3['def']==98){echo "C";} if($row_nota4_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">

	&nbsp;<?php if ($row_nota4_anio3['def']==10){ echo "DIEZ";} if ($row_nota4_anio3['def']==11){ echo "ONCE";} if ($row_nota4_anio3['def']==12){ echo "DOCE";} if ($row_nota4_anio3['def']==13){ echo "TRECE";} if ($row_nota4_anio3['def']==14){ echo "CATORCE";} if ($row_nota4_anio3['def']==15){ echo "QUINCE";} if ($row_nota4_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota4_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota4_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota4_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota4_anio3['def']==20){ echo "VEINTE";} if ($row_nota4_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota4_anio3['def']==98){ echo "CURSADA";} if ($row_nota4_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota4_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota4_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota4_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota4_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 4 ANIO 3
if ($totalRows_nota4_anio6>0){ // NOTA 4 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota4_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota4_anio6['def']<=20){echo $row_nota4_anio6['def'];} if($row_nota4_anio6['def']==99){echo "PE";} if($row_nota4_anio6['def']==98){echo "C";} if($row_nota4_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota4_anio6['def']==10){ echo "DIEZ";} if ($row_nota4_anio6['def']==11){ echo "ONCE";} if ($row_nota4_anio6['def']==12){ echo "DOCE";} if ($row_nota4_anio6['def']==13){ echo "TRECE";} if ($row_nota4_anio6['def']==14){ echo "CATORCE";} if ($row_nota4_anio6['def']==15){ echo "QUINCE";} if ($row_nota4_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota4_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota4_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota4_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota4_anio6['def']==20){ echo "VEINTE";} if ($row_nota4_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota4_anio6['def']==98){ echo "CURSADA";} if ($row_nota4_anio6['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota4_anio6['tipo_eva']; ?>
	</div>

	<div class="fmes">
	<?php echo $row_nota4_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota4_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota4_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 4 ANIO 6
?>



<?php 
if ($totalRows_nota5_anio3>0){ // NOTA 5 DE ANIO 3
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota5_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota5_anio3['def']<=20){echo $row_nota5_anio3['def'];} if($row_nota5_anio3['def']==99){echo "PE";} if($row_nota5_anio3['def']==98){echo "C";} if($row_nota5_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota5_anio3['def']==10){ echo "DIEZ";} if ($row_nota5_anio3['def']==11){ echo "ONCE";} if ($row_nota5_anio3['def']==12){ echo "DOCE";} if ($row_nota5_anio3['def']==13){ echo "TRECE";} if ($row_nota5_anio3['def']==14){ echo "CATORCE";} if ($row_nota5_anio3['def']==15){ echo "QUINCE";} if ($row_nota5_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota5_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota5_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota5_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota5_anio3['def']==20){ echo "VEINTE";} if ($row_nota5_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota5_anio3['def']==98){ echo "CURSADA";} if ($row_nota5_anio3['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota5_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota5_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota5_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota5_anio3['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 5 ANIO 3
if ($totalRows_nota5_anio6>0){ // NOTA 5 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota5_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota5_anio6['def']<=20){echo $row_nota5_anio6['def'];} if($row_nota5_anio6['def']==99){echo "PE";} if($row_nota5_anio6['def']==98){echo "C";} if($row_nota5_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota5_anio6['def']==10){ echo "DIEZ";} if ($row_nota5_anio6['def']==11){ echo "ONCE";} if ($row_nota5_anio6['def']==12){ echo "DOCE";} if ($row_nota5_anio6['def']==13){ echo "TRECE";} if ($row_nota5_anio6['def']==14){ echo "CATORCE";} if ($row_nota5_anio6['def']==15){ echo "QUINCE";} if ($row_nota5_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota5_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota5_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota5_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota5_anio6['def']==20){ echo "VEINTE";} if ($row_nota5_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota5_anio6['def']==98){ echo "CURSADA";} if ($row_nota5_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota5_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota5_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota5_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota5_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 5 ANIO 6
?>




<?php 
if ($totalRows_nota6_anio3>0){ // NOTA 6 DE ANIO 3
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota6_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota6_anio3['def']<=20){echo $row_nota6_anio3['def'];} if($row_nota6_anio3['def']==99){echo "PE";} if($row_nota6_anio3['def']==98){echo "C";} if($row_nota6_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota6_anio3['def']==10){ echo "DIEZ";} if ($row_nota6_anio3['def']==11){ echo "ONCE";} if ($row_nota6_anio3['def']==12){ echo "DOCE";} if ($row_nota6_anio3['def']==13){ echo "TRECE";} if ($row_nota6_anio3['def']==14){ echo "CATORCE";} if ($row_nota6_anio3['def']==15){ echo "QUINCE";} if ($row_nota6_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota6_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota6_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota6_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota6_anio3['def']==20){ echo "VEINTE";} if ($row_nota6_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota6_anio3['def']==98){ echo "CURSADA";} if ($row_nota6_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota6_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota6_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota6_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota6_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 6 ANIO 3
if ($totalRows_nota6_anio6>0){ // NOTA 6 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota6_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota6_anio6['def']<=20){echo $row_nota6_anio6['def'];} if($row_nota6_anio6['def']==99){echo "PE";} if($row_nota6_anio6['def']==98){echo "C";} if($row_nota6_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota6_anio6['def']==10){ echo "DIEZ";} if ($row_nota6_anio6['def']==11){ echo "ONCE";} if ($row_nota6_anio6['def']==12){ echo "DOCE";} if ($row_nota6_anio6['def']==13){ echo "TRECE";} if ($row_nota6_anio6['def']==14){ echo "CATORCE";} if ($row_nota6_anio6['def']==15){ echo "QUINCE";} if ($row_nota6_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota6_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota6_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota6_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota6_anio6['def']==20){ echo "VEINTE";} if ($row_nota6_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota6_anio6['def']==98){ echo "CURSADA";} if ($row_nota6_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota6_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota6_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota6_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota6_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 6 ANIO 6
?>



<?php 
if ($totalRows_nota7_anio3>0){ // NOTA 7 DE ANIO 3
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota7_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota7_anio3['def']<=20){echo $row_nota7_anio3['def'];} if($row_nota7_anio3['def']==99){echo "PE";} if($row_nota7_anio3['def']==98){echo "C";} if($row_nota7_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota7_anio3['def']==10){ echo "DIEZ";} if ($row_nota7_anio3['def']==11){ echo "ONCE";} if ($row_nota7_anio3['def']==12){ echo "DOCE";} if ($row_nota7_anio3['def']==13){ echo "TRECE";} if ($row_nota7_anio3['def']==14){ echo "CATORCE";} if ($row_nota7_anio3['def']==15){ echo "QUINCE";} if ($row_nota7_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota7_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota7_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota7_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota7_anio3['def']==20){ echo "VEINTE";} if ($row_nota7_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota7_anio3['def']==98){ echo "CURSADA";} if ($row_nota7_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota7_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota7_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota7_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota7_anio3['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 7 ANIO 3
if ($totalRows_nota7_anio6>0){ // NOTA 7 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota7_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota7_anio6['def']<=20){echo $row_nota7_anio6['def'];} if($row_nota7_anio6['def']==99){echo "PE";} if($row_nota7_anio6['def']==98){echo "C";} if($row_nota7_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota7_anio6['def']==10){ echo "DIEZ";} if ($row_nota7_anio6['def']==11){ echo "ONCE";} if ($row_nota7_anio6['def']==12){ echo "DOCE";} if ($row_nota7_anio6['def']==13){ echo "TRECE";} if ($row_nota7_anio6['def']==14){ echo "CATORCE";} if ($row_nota7_anio6['def']==15){ echo "QUINCE";} if ($row_nota7_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota7_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota7_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota7_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota7_anio6['def']==20){ echo "VEINTE";} if ($row_nota7_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota7_anio6['def']==98){ echo "CURSADA";} if ($row_nota7_anio6['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota7_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota7_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota7_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota7_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 7 ANIO 6
?>



<?php 
if ($totalRows_nota8_anio3>0){ // NOTA 8 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota8_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota8_anio3['def']<=20){echo $row_nota8_anio3['def'];} if($row_nota8_anio3['def']==99){echo "PE";} if($row_nota8_anio3['def']==98){echo "C";} if($row_nota8_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota8_anio3['def']==10){ echo "DIEZ";} if ($row_nota8_anio3['def']==11){ echo "ONCE";} if ($row_nota8_anio3['def']==12){ echo "DOCE";} if ($row_nota8_anio3['def']==13){ echo "TRECE";} if ($row_nota8_anio3['def']==14){ echo "CATORCE";} if ($row_nota8_anio3['def']==15){ echo "QUINCE";} if ($row_nota8_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota8_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota8_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota8_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota8_anio3['def']==20){ echo "VEINTE";} if ($row_nota8_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota8_anio3['def']==98){ echo "CURSADA";} if ($row_nota8_anio3['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota8_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota8_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota8_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota8_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 8 ANIO 3
if ($totalRows_nota8_anio6>0){ // NOTA 8 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota8_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota8_anio6['def']<=20){echo $row_nota8_anio6['def'];} if($row_nota8_anio6['def']==99){echo "PE";} if($row_nota8_anio6['def']==98){echo "C";} if($row_nota8_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota8_anio6['def']==10){ echo "DIEZ";} if ($row_nota8_anio6['def']==11){ echo "ONCE";} if ($row_nota8_anio6['def']==12){ echo "DOCE";} if ($row_nota8_anio6['def']==13){ echo "TRECE";} if ($row_nota8_anio6['def']==14){ echo "CATORCE";} if ($row_nota8_anio6['def']==15){ echo "QUINCE";} if ($row_nota8_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota8_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota8_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota8_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota8_anio6['def']==20){ echo "VEINTE";} if ($row_nota8_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota8_anio6['def']==98){ echo "CURSADA";} if ($row_nota8_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota8_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota8_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota8_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota8_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 8 ANIO 6
?>



<?php 
if ($totalRows_nota9_anio3>0){ // NOTA 9 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota9_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota9_anio3['def']<=20){echo $row_nota9_anio3['def'];} if($row_nota9_anio3['def']==99){echo "PE";} if($row_nota9_anio3['def']==98){echo "C";} if($row_nota9_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota9_anio3['def']==10){ echo "DIEZ";} if ($row_nota9_anio3['def']==11){ echo "ONCE";} if ($row_nota9_anio3['def']==12){ echo "DOCE";} if ($row_nota9_anio3['def']==13){ echo "TRECE";} if ($row_nota9_anio3['def']==14){ echo "CATORCE";} if ($row_nota9_anio3['def']==15){ echo "QUINCE";} if ($row_nota9_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota9_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota9_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota9_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota9_anio3['def']==20){ echo "VEINTE";} if ($row_nota9_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota9_anio3['def']==98){ echo "CURSADA";} if ($row_nota9_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota9_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota9_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota9_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota9_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 9 ANIO 3
if ($totalRows_nota9_anio6>0){ // NOTA 9 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota9_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota9_anio6['def']<=20){echo $row_nota9_anio6['def'];} if($row_nota9_anio6['def']==99){echo "PE";} if($row_nota9_anio6['def']==98){echo "C";} if($row_nota9_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota9_anio6['def']==10){ echo "DIEZ";} if ($row_nota9_anio6['def']==11){ echo "ONCE";} if ($row_nota9_anio6['def']==12){ echo "DOCE";} if ($row_nota9_anio6['def']==13){ echo "TRECE";} if ($row_nota9_anio6['def']==14){ echo "CATORCE";} if ($row_nota9_anio6['def']==15){ echo "QUINCE";} if ($row_nota9_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota9_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota9_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota9_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota9_anio6['def']==20){ echo "VEINTE";} if ($row_nota9_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota9_anio6['def']==98){ echo "CURSADA";} if ($row_nota9_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota9_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota9_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota9_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota9_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 9 ANIO 5
?>
<?php 
if (($totalRows_nota9_anio3==0) and ($row_planestudio['cod']==32011)){ // NOTA 9 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*

	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 9 
?>


<?php 
if ($totalRows_nota10_anio3>0){ // NOTA 10 DE ANIO 3
?>

	<div class="mate">

	&nbsp;<?php echo $row_nota10_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota10_anio3['def']<=20){echo $row_nota10_anio3['def'];} if($row_nota10_anio3['def']==99){echo "PE";} if($row_nota10_anio3['def']==98){echo "C";} if($row_nota10_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota10_anio3['def']==10){ echo "DIEZ";} if ($row_nota10_anio3['def']==11){ echo "ONCE";} if ($row_nota10_anio3['def']==12){ echo "DOCE";} if ($row_nota10_anio3['def']==13){ echo "TRECE";} if ($row_nota10_anio3['def']==14){ echo "CATORCE";} if ($row_nota10_anio3['def']==15){ echo "QUINCE";} if ($row_nota10_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota10_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota10_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota10_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota10_anio3['def']==20){ echo "VEINTE";} if ($row_nota10_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota10_anio3['def']==98){ echo "CURSADA";} if ($row_nota10_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota10_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota10_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota10_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota10_anio3['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 10 ANIO 3
if ($totalRows_nota10_anio6>0){ // NOTA 10 DE ANIO 6
?>
	<div class="mate">

	&nbsp;<?php echo $row_nota10_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota10_anio6['def']<=20){echo $row_nota10_anio6['def'];} if($row_nota10_anio6['def']==99){echo "PE";} if($row_nota10_anio6['def']==98){echo "C";} if($row_nota10_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota10_anio6['def']==10){ echo "DIEZ";} if ($row_nota10_anio6['def']==11){ echo "ONCE";} if ($row_nota10_anio6['def']==12){ echo "DOCE";} if ($row_nota10_anio6['def']==13){ echo "TRECE";} if ($row_nota10_anio6['def']==14){ echo "CATORCE";} if ($row_nota10_anio6['def']==15){ echo "QUINCE";} if ($row_nota10_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota10_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota10_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota10_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota10_anio6['def']==20){ echo "VEINTE";} if ($row_nota10_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota10_anio6['def']==98){ echo "CURSADA";} if ($row_nota10_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota10_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota10_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota10_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota10_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 10 ANIO 6
?>
<?php 
if (($totalRows_nota10_anio3==0) and ($row_planestudio['cod']==32011)){ // NOTA 10 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
   *
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 10 
?>


<?php 
if ($totalRows_nota11_anio3>0){ // NOTA 11 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota11_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota11_anio3['def']<=20){echo $row_nota11_anio3['def'];} if($row_nota11_anio3['def']==99){echo "PE";} if($row_nota11_anio3['def']==98){echo "C";} if($row_nota11_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota11_anio3['def']==10){ echo "DIEZ";} if ($row_nota11_anio3['def']==11){ echo "ONCE";} if ($row_nota11_anio3['def']==12){ echo "DOCE";} if ($row_nota11_anio3['def']==13){ echo "TRECE";} if ($row_nota11_anio3['def']==14){ echo "CATORCE";} if ($row_nota11_anio3['def']==15){ echo "QUINCE";} if ($row_nota11_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota11_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota11_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota11_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota11_anio3['def']==20){ echo "VEINTE";} if ($row_nota11_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota11_anio3['def']==98){ echo "CURSADA";} if ($row_nota11_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota11_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota11_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota11_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota11_anio3['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 11 ANIO 3
if ($totalRows_nota11_anio6>0){ // NOTA 11 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota11_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota11_anio6['def']<=20){echo $row_nota11_anio6['def'];} if($row_nota11_anio6['def']==99){echo "PE";} if($row_nota11_anio6['def']==98){echo "C";} if($row_nota11_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota11_anio6['def']==10){ echo "DIEZ";} if ($row_nota11_anio6['def']==11){ echo "ONCE";} if ($row_nota11_anio6['def']==12){ echo "DOCE";} if ($row_nota11_anio6['def']==13){ echo "TRECE";} if ($row_nota11_anio6['def']==14){ echo "CATORCE";} if ($row_nota11_anio6['def']==15){ echo "QUINCE";} if ($row_nota11_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota11_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota11_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota11_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota11_anio6['def']==20){ echo "VEINTE";} if ($row_nota11_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota11_anio6['def']==98){ echo "CURSADA";} if ($row_nota11_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota11_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota11_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota11_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota11_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 11 ANIO 6
?>
<?php 
if (($totalRows_nota11_anio3==0) and ($row_planestudio['cod']==32011)){ // NOTA 11 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*

	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*

	</div>
<?php } // FIN NOTA 11 
?>


<?php 
if ($totalRows_nota12_anio3>0){ // NOTA 12 DE ANIO 3
?>

	<div class="mate">
	&nbsp;<?php echo $row_nota12_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota12_anio3['def']<=20){echo $row_nota12_anio3['def'];} if($row_nota12_anio3['def']==99){echo "PE";} if($row_nota12_anio3['def']==98){echo "C";} if($row_nota12_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota12_anio3['def']==10){ echo "DIEZ";} if ($row_nota12_anio3['def']==11){ echo "ONCE";} if ($row_nota12_anio3['def']==12){ echo "DOCE";} if ($row_nota12_anio3['def']==13){ echo "TRECE";} if ($row_nota12_anio3['def']==14){ echo "CATORCE";} if ($row_nota12_anio3['def']==15){ echo "QUINCE";} if ($row_nota12_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota12_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota12_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota12_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota12_anio3['def']==20){ echo "VEINTE";} if ($row_nota12_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota12_anio3['def']==98){ echo "CURSADA";} if ($row_nota12_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota12_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota12_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota12_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota12_anio3['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 12 ANIO 3
if ($totalRows_nota12_anio6>0){ // NOTA 12 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota12_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota12_anio6['def']<=20){echo $row_nota12_anio6['def'];} if($row_nota12_anio6['def']==99){echo "PE";} if($row_nota12_anio6['def']==98){echo "C";} if($row_nota12_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota12_anio6['def']==10){ echo "DIEZ";} if ($row_nota12_anio6['def']==11){ echo "ONCE";} if ($row_nota12_anio6['def']==12){ echo "DOCE";} if ($row_nota12_anio6['def']==13){ echo "TRECE";} if ($row_nota12_anio6['def']==14){ echo "CATORCE";} if ($row_nota12_anio6['def']==15){ echo "QUINCE";} if ($row_nota12_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota12_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota12_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota12_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota12_anio6['def']==20){ echo "VEINTE";} if ($row_nota12_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota12_anio6['def']==98){ echo "CURSADA";} if ($row_nota12_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota12_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota12_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota12_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota12_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 12 ANIO 6
?>
<?php 
if (($totalRows_nota12_anio3==0) and ($row_planestudio['cod']==32011)){ // NOTA 12 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 12 
?>


<?php 
if ($totalRows_nota13_anio3>0){ // NOTA 13 DE ANIO 3
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota13_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota13_anio3['def']<=20){echo $row_nota13_anio3['def'];} if($row_nota13_anio3['def']==99){echo "PE";} if($row_nota13_anio3['def']==98){echo "C";} if($row_nota13_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota13_anio3['def']==10){ echo "DIEZ";} if ($row_nota13_anio3['def']==11){ echo "ONCE";} if ($row_nota13_anio3['def']==12){ echo "DOCE";} if ($row_nota13_anio3['def']==13){ echo "TRECE";} if ($row_nota13_anio3['def']==14){ echo "CATORCE";} if ($row_nota13_anio3['def']==15){ echo "QUINCE";} if ($row_nota13_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota13_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota13_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota13_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota13_anio3['def']==20){ echo "VEINTE";} if ($row_nota13_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota13_anio3['def']==98){ echo "CURSADA";} if ($row_nota13_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota13_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota13_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota13_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota13_anio3['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 13 ANIO 3
if ($totalRows_nota13_anio6>0){ // NOTA 13 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota13_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota13_anio6['def']<=20){echo $row_nota13_anio6['def'];} if($row_nota13_anio6['def']==99){echo "PE";} if($row_nota13_anio6['def']==98){echo "C";} if($row_nota13_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota13_anio6['def']==10){ echo "DIEZ";} if ($row_nota13_anio6['def']==11){ echo "ONCE";} if ($row_nota13_anio6['def']==12){ echo "DOCE";} if ($row_nota13_anio6['def']==13){ echo "TRECE";} if ($row_nota13_anio6['def']==14){ echo "CATORCE";} if ($row_nota13_anio6['def']==15){ echo "QUINCE";} if ($row_nota13_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota13_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota13_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota13_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota13_anio6['def']==20){ echo "VEINTE";} if ($row_nota13_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota13_anio6['def']==98){ echo "CURSADA";} if ($row_nota13_anio6['def']==97){ echo "EXONERADA";} ?>

	</div>
	<div class="te">
	<?php echo $row_nota13_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota13_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota13_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota13_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 13 ANIO 6
?>

<?php 
if (($totalRows_nota13_anio3==0) and ($row_planestudio['cod']==32011)){ // NOTA 13 ESTA VACIA
?>
	<div class="mate" style="text-align:center;">
	*

	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 13 
?>


<?php 
if ($totalRows_nota14_anio3>0){ // NOTA 14 DE ANIO 3
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota14_anio3['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota14_anio3['def']<=20){echo $row_nota14_anio3['def'];} if($row_nota14_anio3['def']==99){echo "PE";} if($row_nota14_anio3['def']==98){echo "C";} if($row_nota14_anio3['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota14_anio3['def']==10){ echo "DIEZ";} if ($row_nota14_anio3['def']==11){ echo "ONCE";} if ($row_nota14_anio3['def']==12){ echo "DOCE";} if ($row_nota14_anio3['def']==13){ echo "TRECE";} if ($row_nota14_anio3['def']==14){ echo "CATORCE";} if ($row_nota14_anio3['def']==15){ echo "QUINCE";} if ($row_nota14_anio3['def']==16){ echo "DIECISEIS";} if ($row_nota14_anio3['def']==17){ echo "DIECISIETE";}  if ($row_nota14_anio3['def']==18){ echo "DIECIOCHO";} if ($row_nota14_anio3['def']==19){ echo "DIECINUEVE";} if ($row_nota14_anio3['def']==20){ echo "VEINTE";} if ($row_nota14_anio3['def']==99){ echo "PENDIENTE";} if ($row_nota14_anio3['def']==98){ echo "CURSADA";} if ($row_nota14_anio3['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota14_anio3['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota14_anio3['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota14_anio3['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota14_anio3['plantelcurso_no']; ?>
	</div>
<?php } // FIN NOTA 14 ANIO 3
if ($totalRows_nota14_anio6>0){ // NOTA 14 DE ANIO 6
?>
	<div class="mate">
	&nbsp;<?php echo $row_nota14_anio6['nombre_asignatura']; ?>
	</div>
	<div class="no">
	<?php if($row_nota14_anio6['def']<=20){echo $row_nota14_anio6['def'];} if($row_nota14_anio6['def']==99){echo "PE";} if($row_nota14_anio6['def']==98){echo "C";} if($row_nota14_anio6['def']==97){echo "EX";} ?>
	</div>
	<div class="letras">
	&nbsp;<?php if ($row_nota14_anio6['def']==10){ echo "DIEZ";} if ($row_nota14_anio6['def']==11){ echo "ONCE";} if ($row_nota14_anio6['def']==12){ echo "DOCE";} if ($row_nota14_anio6['def']==13){ echo "TRECE";} if ($row_nota14_anio6['def']==14){ echo "CATORCE";} if ($row_nota14_anio6['def']==15){ echo "QUINCE";} if ($row_nota14_anio6['def']==16){ echo "DIECISEIS";} if ($row_nota14_anio6['def']==17){ echo "DIECISIETE";}  if ($row_nota14_anio6['def']==18){ echo "DIECIOCHO";} if ($row_nota14_anio6['def']==19){ echo "DIECINUEVE";} if ($row_nota14_anio6['def']==20){ echo "VEINTE";} if ($row_nota14_anio6['def']==99){ echo "PENDIENTE";} if ($row_nota14_anio6['def']==98){ echo "CURSADA";} if ($row_nota14_anio6['def']==97){ echo "EXONERADA";} ?>
	</div>
	<div class="te">
	<?php echo $row_nota14_anio6['tipo_eva']; ?>
	</div>
	<div class="fmes">
	<?php echo $row_nota14_anio6['fecha_mes']; ?>
	</div>
	<div class="fanio">
	<?php echo $row_nota14_anio6['fecha_anio']; ?>
	</div>
	<div class="no_plantel">
	<?php echo $row_nota14_anio6['plantelcurso_no']; ?>
	</div>

<?php } // FIN NOTA 14 ANIO 6
?>
<?php 
if (($totalRows_nota14_anio3==0) and ($row_planestudio['cod']==32011)){ // NOTA 14 ESTA VACIA
?>

	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>


	<div class="mate" style="text-align:center;">
	*
	</div>
	<div class="no" style="text-align:center;">
	*
	</div>
	<div class="letras" style="text-align:center;">
	*
	</div>
	<div class="te" style="text-align:center;">
	*
	</div>
	<div class="fmes" style="text-align:center;">
	*
	</div>
	<div class="fanio" style="text-align:center;">
	*
	</div>
	<div class="no_plantel" style="text-align:center;">
	*
	</div>
<?php } // FIN NOTA 14 
?>

<?php if(($totalRows_nota1_anio3==0)and($totalRows_nota1_anio6==0)){ ?>

<div class="container_titulos">

<div class="container_cuadro_left">
	<div class="cuadro_left">
	<b>A&ntilde;o o Grado: 
	</div>
	<div class="cuadro_left" style="text-align:center;">
	<b>Asignaturas</b>
	</div>

</div>

<div class="container_cuadro_medio_grande">
	<div class="cuadro_medio_grande">
	<b>Calificaci&oacute;n</b>
	</div>
	<div class="cuadro_medio_grande">
		<div class="enno">
		<b>En No.</b>
		</div>
		<div class="enletras">
		<b>En letras</b>
		</div>

	</div>
</div>

<div class="t-e">
<b>T-E</b>
</div>

<div class="container_fecha">
	<div class="fecha">
	<b>Fecha</b>
	</div>
	<div class="fecha">
		<div class="mes">
		<b>Mes</b>
		</div>
		<div class="anio">
		<b>A&ntilde;o</b>
		</div>
	</div>

</div>

<div class="container_plantel">
	<div class="plantel">
	<b>Plantel</b>
	</div>
	<div class="plantel">
	<b>No.</b>
	</div>
</div>

<div id="container_asignaturas">
   <div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>

	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
	<div class="mate"  style="text-align:center;">
	*
	</div>
	<div class="no"  style="text-align:center;">
	*
	</div>
	<div class="letras"  style="text-align:center;">
	*
	</div>
	<div class="te"  style="text-align:center;">
	*
	</div>
	<div class="fmes"  style="text-align:center;">
	*
	</div>
	<div class="fanio"  style="text-align:center;">
	*
	</div>
	<div class="no_plantel"  style="text-align:center;">
	*
	</div>
</div>
</div>
<?php }?>

<?php if(($totalRows_nota1_anio3>0)or($totalRows_nota1_anio6>0)){?>
</div>
<?php } ?>
</div>
</div>
</div>
</div>


<div id="central_sellos">
	<div class="titulo">
	<b>VI. DIRECTOR(A) PLANTEL</b>
	</div>
	<div class="director">
	<b>Apellidos y Nombres del<br />
	Director(a):</b>
	</div>
	<bt />
	<div class="director" style="text-align:center;">
	<?php echo $row_institucion['apellido_director'].", ".$row_institucion['nombre_director'];?>
	</div>
	<div class="titulo">
	<b>N&uacute;mero de C.I.:</b>
	</div>
	<div class="titulo">
	V-<?php echo $row_institucion['cedula_director'];?>
	</div>
	<div class="titulo">
	<b>Firma:</b>
	</div>
	<div class="director">

	</div>
	<div class="sello">
	<br />
	<br />
	<br />
	SELLO DEL PLANTEL
	</div>
	<div class="cuadro_mediano">
	Para efectos de su validez a nivel estadal
	</div>
	<div class="cuadro_pequeno">
	<b>VII. DIRECTOR(A) DE LA ZONA EDUCATIVA</b>
	</div>
	<div class="cuadro_datos">
	<b>Apellidos y Nombres:</b>
	</div>
	<div class="cuadro_datos">
	<b>N&uacute;mero de C.I.:</b>
	</div>
	<div class="cuadro_datos">
	<b>Firma:</b>
	</div>
	<div class="sello">
	<br />
	<br />
	<br />
	SELLO DE LA ZONA EDUCATIVA
	</div>
	<div class="cuadro_mediano">
	Para efectos de su validez a nivel nacional e Internacional y cuando se trate de estudios libres o equivalentes sin escolaridad
	</div>
	<div class="cuadro_mediano">
	<b>Timbre Fiscal:</b> Este Documento no tiene validez si no se le colocan en la parte posterior timbres fiscales por Bs.30% de la Unidad Tributaria
	</div>

</div>

<div id="ept">
	<div class="titulo">
	<b>VIII. Programas Aprobados de Educaci&oacute;n para el Trabajo: A&Ntilde;O/NOMBRE/HORAS ESTUDIANTE SEMANAL</b>
	</div>

	<div class="pequeno" style="border-top:1px solid;">
		<?php if($totalRows_nota_ept1>0){ echo $row_nota_ept1['inicial']; }else{ echo "*";} ?>
	</div>
	<div class="grande" style="border-top:1px solid;<?php if($totalRows_nota_ept1==0){ echo 'text-align:center;';} ?>">
		&nbsp;<?php if($totalRows_nota_ept1>0){ echo $row_nota_ept1['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano" style="border-top:1px solid;">
		<?php  if($totalRows_nota_ept1>0){  echo $row_nota_ept1['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno" style="border-top:1px solid;">
		<?php if($totalRows_nota_ept6>0){echo $row_nota_ept6['inicial']; }else{ echo "*";} ?>
	</div>
	<div class="grande" style="border-top:1px solid;<?php if($totalRows_nota_ept6==0){ echo 'text-align:center;';} ?>">
		&nbsp;<?php if($totalRows_nota_ept6>0){echo $row_nota_ept6['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano" style="border-top:1px solid; border-right:1px solid;">
		<?php if($totalRows_nota_ept6>0){echo $row_nota_ept6['horas_clase']; }else{ echo "*";}?>
	</div>

	<div class="pequeno" >
		<?php if($totalRows_nota_ept2>0){ echo $row_nota_ept2['inicial'];}else{ echo "*";} ?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept2==0){ echo "style='text-align:center'";} ?> >
		&nbsp;<?php if($totalRows_nota_ept2>0){echo $row_nota_ept2['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano">
		<?php if($totalRows_nota_ept2>0){echo $row_nota_ept2['horas_clase'];}else{ echo "*";}?>
	</div>

	<div class="pequeno">
		<?php if($totalRows_nota_ept7>0){echo $row_nota_ept7['inicial']; }else{ echo "*";}?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept7==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept7>0){echo $row_nota_ept7['nombre_asignatura_ept']; }else{ echo "*";}?>
	</div>
	<div class="mediano" style="border-right:1px solid;">
		<?php if($totalRows_nota_ept7>0){echo $row_nota_ept7['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno" >
		<?php if($totalRows_nota_ept3>0){echo $row_nota_ept3['inicial'];}else{ echo "*";} ?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept3==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept3>0){echo $row_nota_ept3['nombre_asignatura_ept']; }else{ echo "*";}?>
	</div>
	<div class="mediano" >
		<?php if($totalRows_nota_ept3>0){echo $row_nota_ept3['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno">
		<?php if($totalRows_nota_ept8>0){echo $row_nota_ept8['inicial'];}else{ echo "*";}?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept8==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept8>0){echo $row_nota_ept8['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano" style="border-right:1px solid;">
		<?php if($totalRows_nota_ept8>0){echo $row_nota_ept8['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno" >
		<?php if($totalRows_nota_ept4>0){echo $row_nota_ept4['inicial']; }else{ echo "*";}?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept4==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept4>0){echo $row_nota_ept4['nombre_asignatura_ept']; }else{ echo "*";}?>
	</div>
	<div class="mediano" >
		<?php if($totalRows_nota_ept4>0){echo $row_nota_ept4['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno" >
		<?php if($totalRows_nota_ept9>0){echo $row_nota_ept9['inicial']; }else{ echo "*";}?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept9==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept9>0){echo $row_nota_ept9['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano" style="border-right:1px solid;">
		<?php if($totalRows_nota_ept9>0){echo $row_nota_ept9['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno" >
		<?php if($totalRows_nota_ept5>0){echo $row_nota_ept5['inicial']; }else{ echo "*";}?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept5==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept5>0){echo $row_nota_ept5['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano">
		<?php if($totalRows_nota_ept5>0){echo $row_nota_ept5['horas_clase'];}else{ echo "*";} ?>
	</div>

	<div class="pequeno" >
		<?php if($totalRows_nota_ept10>0){echo $row_nota_ept10['inicial'];}else{ echo "*";} ?>
	</div>
	<div class="grande" <?php if($totalRows_nota_ept10==0){ echo "style='text-align:center'";} ?>>
		&nbsp;<?php if($totalRows_nota_ept10>0){echo $row_nota_ept10['nombre_asignatura_ept'];}else{ echo "*";} ?>
	</div>
	<div class="mediano" style="border-right:1px solid;">
		<?php if($totalRows_nota_ept10>0){echo $row_nota_ept10['horas_clase'];}else{ echo "*";} ?>
	</div>



</div>
<div id="observaciones">
	<div class="lineas">
	<b>IX. Observaciones:</b>&nbsp;&nbsp;&nbsp;<?php echo $row_observa['observacion']; ?> 
	</div>
	<div class="lineas">
	</div>
	<div class="lineas">
	</div>
	<div class="lineas">
	</div>
	<div class="lineas">
	</div>
	<div class="info">
	<b>LA CERTIFICACION NO TIENEN FECHA DE VENCIMIENTO (CIRCULAR No. 05 DEL 02/07/03 MODIFICADA AL 30/03/07) CONSIDERACIONES FINALES NUMERALES 3.8</b>
	</div>
</div>

</div>



<?php }else{ ?>
<table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../../images/pngnew/olvidaste-tu-contrasena-de-usuario-de-oficina-de-las-preferencias-de-icono-4565-128.png" width="80" height="72"><br>
              <br>
                  <span class="titulo_grande_gris">Error... no estas autorizado para imprimir Certificaciones..</span><span class="texto_mediano_gris"><br>
                <br>
                </span><br>
            </div></td>
          </tr>
        </table>
<?php  }?>

</body>
</center>
</html>