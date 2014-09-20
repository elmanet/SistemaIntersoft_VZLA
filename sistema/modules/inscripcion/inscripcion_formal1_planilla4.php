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

$colname_inscripcion = "-1";
if (isset($_GET['cedula'])) {
  $colname_inscripcion = $_GET['cedula'];
}
mysql_select_db($database_sistemacol, $sistemacol);
$query_inscripcion = sprintf("SELECT * FROM sis_usuario a, sis_alumno_info b WHERE a.id=b.alumno_id AND cedula = %s", GetSQLValueString($colname_inscripcion, "text"));
$inscripcion = mysql_query($query_inscripcion, $sistemacol) or die(mysql_error());
$row_inscripcion = mysql_fetch_assoc($inscripcion);
$totalRows_inscripcion = mysql_num_rows($inscripcion);

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
    <td valign="top"><?php if ($totalRows_inscripcion > 0) { // Show if recordset not empty ?>
        <table border="0" align="center" id="ancho_planilla">
          <tr>
            <td height="92" align="right" valign="middle"><img src="../images/cole/ima/<?php echo $row_colegio['logocol']; ?>" width="79" height="90" align="absmiddle"></td>
            <td align="center" valign="middle"><div align="center">
              <table width="100%" border="0" align="left">
                  <tr>
                    <td align="left" valign="bottom"><p class="titulo_grande_gris"><?php echo $row_colegio['nomcol']; ?></p></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><span class="texto_pequeno_gris"><?php echo $row_colegio['dircol']; ?></span></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><span class="texto_pequeno_gris">Telf.: <?php echo $row_colegio['telcol']; ?></span></td>
                  </tr>
                </table>
              </div></td>
            <td align="center" valign="middle" class="texto_mediano_grande"><strong><div id="foto_planilla">
              <p>&nbsp;</p>
              <p>FOTO</p>
            </div></strong></td>
          </tr>
          <tr>
            <td colspan="3" valign="top"><div align="center">
              <hr>
              <span class="texto_grande_gris"><strong>FICHA DE INSCRIPCION</strong></span>
              <hr>
              </div>
              <table width="100%" border="0">
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos del Estudiante</em></strong></legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_8pt_negro"><strong>CEDULA:</strong> <?php echo $row_inscripcion['indicador_nacionalidad']; ?>-<?php echo $row_inscripcion['cedula']; ?> <strong>NOMBRE DEL ESTUDIANTE: </strong><?php echo $row_inscripcion['nombre']; ?> <?php echo $row_inscripcion['apellido']; ?><strong> <br>
                              DIRECCION: </strong><?php echo $row_inscripcion['direccion_vivienda']; ?><strong> <br>
                              TELEFONO: </strong><?php echo $row_inscripcion['telefono_alumno']; ?><strong> <strong>LUGAR DE NACIMIENTO: </strong></strong><?php echo $row_inscripcion['lugar_nacimiento']; ?><br>
                            <strong><strong> <strong>FECHA DE NACIMIENTO: 
                              </strong></strong></strong>
                            <?php if ($row_inscripcion['fecha_nacimiento_dia']<10){  echo "0".$row_inscripcion['fecha_nacimiento_dia'];} if ($row_inscripcion['fecha_nacimiento_dia']>9){  echo $row_inscripcion['fecha_nacimiento_dia'];}  ?>
                            /
  <?php if ($row_inscripcion['fecha_nacimiento_mes']<10){  echo "0".$row_inscripcion['fecha_nacimiento_mes'];} if ($row_inscripcion['fecha_nacimiento_mes']>9){  echo $row_inscripcion['fecha_nacimiento_mes'];}  ?>
                            /<?php echo $row_inscripcion['fecha_nacimiento_ano']; ?><strong><strong><strong> <strong>  GRADO O A&Ntilde;O A CURSAR: </strong></strong></strong></strong><?php echo $row_inscripcion['ano_cursar']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos del Representante</em></strong> </legend>
                      <table width="100%" border="0" align="center">
                        <tr>
                          <td align="left" valign="top" class="texto_8pt_negro"><strong>CEDULA:</strong> <?php echo $row_inscripcion['cedula_representante']; ?> <strong>NOMBRE  REPRESENTANTE: </strong><?php echo $row_inscripcion['nombre_representante']; ?> <?php echo $row_inscripcion['apellido_representante']; ?><strong><br>
                              DIRECCION:                          </strong><?php echo $row_inscripcion['direccion_representante']; ?><strong><br>
                              TELEFONO:                          </strong><?php echo $row_inscripcion['telefono_representante']; ?><strong> E-MAIL: </strong><?php echo $row_inscripcion['email_representante']; ?><strong><br>
                              PROFESION:                          </strong><?php echo $row_inscripcion['descripcion_trabajo']; ?><strong> DIRECCION DE TRABAJO: </strong><?php echo $row_inscripcion['direccion_trabajo']; ?><strong> TELEFONO DE TRABAJO: </strong><?php echo $row_inscripcion['telefono_trabajo']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><strong><em>Datos de  los Padres</em></strong> </legend>
                      <table width="100%" border="0" align="left">
                        <tr>
                          <td align="left" valign="top" class="texto_8pt_negro"><strong>NOMBRE MADRE:</strong><?php echo $row_inscripcion['nombre_madre']; ?> <?php echo $row_inscripcion['apellido_madre']; ?> <strong><br>
                              DIRECCION MADRE:</strong><?php echo $row_inscripcion['direccion_madre']; ?> <strong>TELEFONO MADRE: </strong><?php echo $row_inscripcion['tel_madre']; ?><strong> <br>
                              NOMBRE PADRE: </strong><?php echo $row_inscripcion['nombre_padre']; ?> <?php echo $row_inscripcion['apellido_padre']; ?><br>
                            <strong> DIRECCION PADRE: </strong><?php echo $row_inscripcion['direccion_padre']; ?><strong> TELEFONO PADRE: </strong><?php echo $row_inscripcion['tel_padre']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><div align="center">
                    <fieldset style="width:90%;">
                      <legend class="texto_mediano_grande"><em><strong>Informaci&oacute;n General</strong></em></legend>
                      <table width="100%" border="0" align="left">
                        <tr>
                          <td height="10" align="left" valign="top" class="texto_8pt_negro"><strong class="texto_pequeno_gris">INGRESO FAMILIAR:</strong><?php echo $row_inscripcion['ingreso_familiar']; ?><br> 
                            <strong>VECINO/FAMILIAR(1): </strong><?php echo $row_inscripcion['vecino1_nombre']; ?><strong> PARENTESCO(1): </strong><?php echo $row_inscripcion['vecino1_parentesco']; ?><strong> TELEFONO(1): </strong><?php echo $row_inscripcion['vecino1_telefono']; ?><strong><br> 
                              VECINO/FAMILIAR(2): </strong><?php echo $row_inscripcion['vecino2_nombre']; ?><strong> PARENTESCO(2): </strong><?php echo $row_inscripcion['vecino2_parentesco']; ?><strong> TELEFONO(2): </strong><?php echo $row_inscripcion['vecino2_telefono']; ?><strong><br> 
                              NOMBRE DEL SEGURO: </strong><?php echo $row_inscripcion['seguro_nombre']; ?> <strong>LLEVAR A LA CLINICA: </strong><?php echo $row_inscripcion['seguro_clinica']; ?><strong><br> 
                              TIPO DE SANGRE: </strong><?php echo $row_inscripcion['tipo_sangre']; ?><strong> ALERGICO(A): </strong><?php echo $row_inscripcion['alergico']; ?></td>
                          </tr>
                        </table>
                      </fieldset>
                    </div></td>
                  </tr>
                <tr>
                  <td align="left" valign="top"><table width="100%" border="0">
                    <tr>
                      <td width="50%" valign="top"><p class="texto_mediano_gris"><span class="texto_8pt_negro"><strong>NORMAS GENERALES QUE DEBE CUMPLIR EL ESTUDIANTE</strong></span><br>
                        <span class="texto_pequeno6pt_negro">                        1. CUMPLIR CON EL INIFORME ESCOLAR ESTABLECIDO POR EL MPPPE<br>
                          2. DEBE TENER RESPETO Y CONSIDERACION AL PERSONAL DOCENTE, ADMINISTRATIVO Y OBRERO<br>
                          3. RESPONSABILIZARSE POR EL MATERIAL DIDACTICO Y EQUIPO INSTITUCIONAL <br>
                          4. ASISTIR DIARIAMENTE A CLASES Y SER PUNTUAL CON EL HORARIO<br>
5. CUMPLIR CON LAS ORIENTACIONES EMITIDAS POR LOS DOCENTE<br>
                          6. CUMPLIR CON EL REGLAMENTO INTERNO DE LA INSTITUCION Y NORMATIVAS LEGALES EDUCATIVAS</span></p>
                        <p class="texto_mediano_gris"><strong class="texto_8pt_negro">NORMAS DEL REPRESENTANTE </strong><br>
                          <span class="texto_pequeno6pt_negro">1. ASISTIR A LAS REUNIONES PARA VERIFICAR LA ASISTENCIA Y RENDIMIENTO DE SU REPRESENTADO<br>
                          2. CUMPLIR CON EL REGLAMENTO INTERNO DE LA INSTITUCION Y NORMATIVA LEGAL VIGENTE </span></p></td>
                      <td valign="top" class="texto_pequeno6pt_negro"><span class="texto_8pt_negro"><strong><br>
                        DOCUMENTOS CONSIGNADOS</strong></span><br>
                        __ 02 FOTOCOPIAS AMPLIADAS DE CEDULA DE IDENTIDAD DEL ESTUDIANTE<br>
                        __ 01 FOTOCOPIA DE CEDULA DE IDENTIDAD DEL REPRESENTANTE<br>
                        __ PARTIDA DE NACIMIENTO (ORIGINAL Y COPIA)<br>
                        __ 05 FOTOGRAFIAS DEL ESTUDIANTE<br>
                        __ 02 FOTOGRAFIAS DEL REPRESENTANTE<br>
                        __ CARPETA MARRON CON GANCHO Y 01 SOBRE MANILA TAMA&Ntilde;O OFICIO<br>
                        __ CERTIFICACION DE CALIFICACIONES (SI PROCEDE DE OTRO ESTADO, AVALADA POR LA ZONA EDUCATIVA)<br>
                        __ PARA 1er A&Ntilde;O: INFORME DESCRIPTIVO DE 6TO GRADO Y CERTIFICADO DE EDUCACION PRIMARIA</td>
                      </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><span class="texto_8pt_negro"><br>
                        FIRMA DEL REPRESENTANTE:___________________________________ C.I.:_____________</span></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="left" valign="top"><span class="texto_8pt_negro"><br>
                        RESPONSABLE DE LA INSCRIPCION :______________________________ C.I.:____________</span></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top"><span class="texto_8pt_negro"><br>
                      </span></td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center" valign="top"><span class="texto_8pt_negro">EN SAN CRISTOBAL A LOS_______________ DEL MES DE_____________DE_____________ </span></td>
                      </tr>
                    </table></td>
                  </tr>
              </table></td>
          </tr>
          </table>
        <?php } // Show if recordset not empty ?>
        <br>
    <tr>
	  <td valign="top"><p>&nbsp;</p>
        <?php if ($totalRows_inscripcion > 0) { // Show if recordset not empty ?>
  <p>&nbsp;</p>
          <table width="80%" border="0" align="center">
            <tr>
              <td><p align="center">&nbsp;</p>
                <p align="center">&nbsp;</p>
                <p align="center"><span class="texto_grande_gris">ACUERDOS DE CONVIVENCIA ESCOLAR</span><br>
                <span class="texto_8pt_negro">(Estudiantes y Representantes)</span></p>
                <p align="center" class="texto_8pt_negro"><strong>TITULO SEGUNDO<br>
                  DERECHOS, DEBERES Y GARANTIAS<br>
                  CAPITULO I&nbsp;  DERECHOS Y DEBERES DE LOS Y LAS ESTUDIANTES<br>
                SECCION PRIMERA. DE LOS DERECHOS DE LOS Y  LAS ESTUDIANTES</strong></p>
                <p class="texto_8pt_negro">ARTICULO 9&ordm;&nbsp; Son  derechos y garant&iacute;as de todos los estudiantes de la Unidad Educativa Colegio  &ldquo;Doctor Arturo Uslar Pietri&rdquo;&nbsp; ubicada en  la Calle 3, entre carreras 12 y avenida Lucio Oquendo, parroquia la Concordia,  Municipio San Crist&oacute;bal, Estado T&aacute;chira.</p>
                <ul>
                  <li class="texto_8pt_negro">Conocer las normas de  Convivencia Escolar</li>
                  <li class="texto_8pt_negro">Recibir una educaci&oacute;n  integral que le permita contar con todas las oportunidades y servicios  educativos orientados a darle una formaci&oacute;n de calidad. Orientada de acuerdo a  los ideales de nuestra constituci&oacute;n y leyes emanadas del poder p&uacute;blico.</li>
                  <li class="texto_8pt_negro">Recibir una educaci&oacute;n  acorde con su desarrollo biol&oacute;gico, psicol&oacute;gico&nbsp;  y social, ajust&aacute;ndose a sus aptitudes, necesidades e intereses. Seg&uacute;n lo  establecido en el art&iacute;culo 3&ordm; de la L.O.E. vigente, art&iacute;culo 53&ordm;, 54&ordm;, 55&ordm;56,57,67,80,88,91  de la ley org&aacute;nica de protecci&oacute;n del ni&ntilde;o yd el adolescente.</li>
                  <li class="texto_8pt_negro">Recibir una educaci&oacute;n  t&eacute;cnica, cient&iacute;fica, human&iacute;stica, deportiva, recreativa y art&iacute;stica, que le  permita la prosecuci&oacute;n de sus estudios.</li>
                  <li class="texto_8pt_negro">Ser atendidos  oportunamente&nbsp; por las autoridades  educativas de la instituci&oacute;n, cuando acudan a ellos para formular  planteamientos relacionados con sus estudios, derechos e intereses.</li>
                  <li class="texto_8pt_negro">Hacer uso del debido  proceso y condiciones suficientes para su defensa especialmente en todos los  procedimientos de car&aacute;cter sancionatorio.</li>
                  <li class="texto_8pt_negro">Ser atendidos en una  planta f&iacute;sica que cuente con las instalaciones m&iacute;nimas necesarias&nbsp; y con los recursos pedag&oacute;gicos y did&aacute;cticos  para el desarrollo de su funci&oacute;n educativa.</li>
                  <li class="texto_8pt_negro">Conocer todo lo  concerniente al proceso educativo en las diferentes asignaturas que curse; a  ser evaluados de acuerdo a las disposiciones legales vigentes; a recibir  informaci&oacute;n peri&oacute;dica de sus evaluaciones seg&uacute;n lo establecido en el art&iacute;culo  123&ordm; de la R.G.L.O.E.</li>
                  <li class="texto_8pt_negro">Derecho a expresar  libremente su opini&oacute;n en todos los asuntos de vida de la instituci&oacute;n en el que  tenga inter&eacute;s directo.</li>
                  <li class="texto_8pt_negro">Derecho a la defensa.</li>
                  <li class="texto_8pt_negro">Elegir y ser elegido para  el gobierno escolar, en cuanto a la elecci&oacute;n de los delegados y sub delegados,  para conformar las vocer&iacute;as del plantel.</li>
                  <li class="texto_8pt_negro">Recibir, previo  cumplimiento de los requisitos establecidos, los boletines parciales de  calificaciones, la certificaci&oacute;n de calificaciones, certificados de aprobaci&oacute;n  de primaria y secundaria.&nbsp; </li>
                  <li class="texto_8pt_negro">Igualmente los estudiantes  que hayan cursado los cinco a&ntilde;os consecutivos&nbsp;  de bachillerato en el colegio, recibir&aacute;n en el Acto de Graduaci&oacute;n, un  diploma&nbsp; llamado PREMIO SENIOR.</li>
                </ul>
                <p class="texto_8pt_negro">PARAGRAFO UNICO: Al inicio del a&ntilde;o escolar, le  corresponde a la coordinaci&oacute;n y/o subdirecci&oacute;n acad&eacute;mica o administrativa del  plantel, implementar las actividades conducentes para dar a conocer a los&nbsp; estudiantes y representantes, los deberes y  derechos contemplados en este acuerdo de convivencia.</p>
                <p class="texto_8pt_negro" align="center">SECCION SEGUNDA. DE LOS DEBERES DE LOS Y  LAS ESTUDIANTES</p>
                <p class="texto_8pt_negro">Art&iacute;culo 10&ordm; Son deberes y responsabilidades de todos  los estudiantes de la Unidad Educativa Colegio &ldquo;Doctor Arturo Uslar Pietri&rdquo;  ubicada en la Calle 3, entre carrera 12 y avenida Lucio Oquendo, parroquia la  Concordia, Municipio San Crist&oacute;bal, Estado T&aacute;chira.</p>
                <ul>
                  <li class="texto_8pt_negro">Ejercer y defender  apropiadamente sus derechos y garant&iacute;as</li>
                  <li class="texto_8pt_negro">Respetar los derechos y  garant&iacute;as de las dem&aacute;s personas, </li>
                  <li class="texto_8pt_negro">Ofrecer un trato decente y  afectuoso con sus compa&ntilde;eros de clase y con todo el personal del colegio.</li>
                  <li class="texto_8pt_negro">A tratar las &oacute;rdenes,  consejos y sugerencias emanadas de la autoridad del colegio, personal docente,  administrativo y de apoyo, bien sea dentro o fuera de la instituci&oacute;n, siempre  que las mismas no violen sus derechos y garant&iacute;as&nbsp; o contravengan el ordenamiento jur&iacute;dico.</li>
                  <li class="texto_8pt_negro">Dedicarse al estudio en  forma responsable, esforz&aacute;ndose para desarrollar todas sus capacidades y  cumplir los deberes escolares, las evaluaciones, tareas, ejercicios y  asignaciones.</li>
                  <li class="texto_8pt_negro">Cumplir con el horario  establecido por la instituci&oacute;n, s&iacute; como con las normas dispuestas para cada  &aacute;rea de servicio que exista en la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Contribuir y mantener el  buen nombre del colegio, observando una conducta c&oacute;nsona a su condici&oacute;n de  estudiante, absteni&eacute;ndose de participar directa o indirectamente en actos  contrarios a la disciplina, la moral, las buenas costumbres y el orden p&uacute;blico,  dentro o fuera del colegio.</li>
                  <li class="texto_8pt_negro">Portar la insignia del  colegio al lado izquierdo de la camisa que lo acredita como estudiante de la  instituci&oacute;n. No debe utilizar abrigos, chaquetas cerradas que impidan mostrar o  hacer visible el distintivo del colegio.&nbsp;  Debe utilizarse correa y la camisa por dentro del pantal&oacute;n.</li>
                  <li class="texto_8pt_negro">Participar activamente en  tareas, servicios o programas para la instituci&oacute;n o la colectividad, de acuerdo  a los principios de responsabilidad social, solidaridad y reciprocidad  establecidos en la L.O.E.</li>
                  <li class="texto_8pt_negro">Mantener una actitud de  respeto y excelente vocabulario con el personal&nbsp;  directivo, docente, administrativo y de apoyo, igualmente con sus  compa&ntilde;eros y dem&aacute;s miembros de la comunidad.</li>
                  <li class="texto_8pt_negro">Respetar los s&iacute;mbolos  patrios, al Libertador Sim&oacute;n Bol&iacute;var y los dem&aacute;s valores inherentes a nuestra  identidad nacional dentro y fuera de la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Mantener en excelente  estado de pulcritud y limpieza el uniforme escolar de uso diario.</li>
                  <li class="texto_8pt_negro">Abstenerse de traer a la  instituci&oacute;n animales, discos, playstation, reproductores, pel&iacute;culas, revistas  pornogr&aacute;ficas, barajitas, juguetes, art&iacute;culos deportivos que no hayan sido  solicitados, o cualquier otro elemento que contravenga la actividad educativa.</li>
                  <li class="texto_8pt_negro">El uso de la telefon&iacute;a  celular queda restringida en los pasillos y espacios diferentes al sal&oacute;n de  clase, siempre y cuando sea para hacer o recibir llamadas.&nbsp; El uso del tel&eacute;fono debe ser para lo cual fue  concebido, para hacer y recibir llamadas &uacute;nica y exclusivamente. Cualquier uso  distinto ser&aacute; objeto de decomiso y retenci&oacute;n por parte de cualquier docente o  directivo de la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Abstenerse de cualquier  tipo de actividad, conversaci&oacute;n p&uacute;blica de car&aacute;cter pol&iacute;tico dentro del  colegio.</li>
                  <li class="texto_8pt_negro">Cumplir con eficiencia y  responsabilidad las funciones inherentes a los cargos y comisiones para lo cual  sea elegido. Se sugiere que por lo menos el estudiante participe en una  actividad complementaria que se desarrolle dentro del plantel.</li>
                  <li class="texto_8pt_negro">Participar en la  organizaci&oacute;n, promoci&oacute;n y realizaci&oacute;n de actividades extracurriculares, actos  c&iacute;vicos, deportivos, recreacionales, desfiles y cualquier otra actividad que  propicien las buenas relaciones entre la instituci&oacute;n y la comunidad.</li>
                  <li class="texto_8pt_negro">Actuar como enlace entre  la instituci&oacute;n y sus respectivos hogares, con el objeto de mantener&nbsp; y facilitar una comunicaci&oacute;n permanente con  sus representantes.</li>
                  <li class="texto_8pt_negro">Usar apropiadamente el  local, el mobiliario y cualquier material de la instituci&oacute;n, as&iacute; como su propio  material y sus &uacute;tiles escolares.</li>
                  <li class="texto_8pt_negro">Colaborar con la limpieza  y mantenimiento del local dentro de los l&iacute;mites de sus responsabilidades&nbsp; como estudiante.</li>
                  <li class="texto_8pt_negro">No debe introducir ni  portar armas u objetos contundentes dentro o fuera de la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Si alg&uacute;n estudiante debe  retirarse del colegio, debe participar al docente o directivo inmediato, para que  &eacute;ste se comunique con su representado y al ingresar nuevamente presente el  justificado por el cual se retir&oacute;.&nbsp; Se  desconocen excusas por tel&eacute;fono.</li>
                  <li class="texto_8pt_negro">Abstenerse de formar  grupos bulliciosos o belicosos dentro del colegio y mantener una actitud  responsable dentro de la clase.&nbsp; Evitar  las interrupciones innecesarias al docente.</li>
                  <li class="texto_8pt_negro">Los estudiantes deben  cumplir la condici&oacute;n de SEMANERO, quedando bajo su custodia el cuidado de la  carpeta de actividades docentes, limpieza y cuidado del aula de clase durante  la semana asignada.</li>
                  <li class="texto_8pt_negro">Los estudiantes que hayan  sido elegidos como DELEGADO Y SUBDELEGADOS&nbsp;  por secciones, ejercer&aacute;n funciones&nbsp;  escolares durante todo el a&ntilde;o escolar, ser&aacute;n solo removidos por causa de  fuerza mayor.&nbsp; Debe cumplir  funciones&nbsp; tales como disciplina de la  secci&oacute;n; notificaci&oacute;n de cualquier evento tanto a sus compa&ntilde;eros como al  docente o directivo; escuchar y presentar por escrito a la autoridad competente  del colegio cualquier requerimiento o necesidad que tengan sus compa&ntilde;eros de  clase y debe coordinar cualquier tipo de evento o actividad escolar o  extracurricular con el profesor gu&iacute;a, el docente de m&uacute;sica, el orientador o el  director del colegio.</li>
                  <li class="texto_8pt_negro">Las dem&aacute;s  responsabilidades y deberes establecidos en el ordenamiento jur&iacute;dico, el  presente Acuerdo de Convivencia y los reglamentos especiales inherentes al  proceso educativo.</li>
                </ul>
                <p class="texto_8pt_negro">PARAGRAFO PRIMERO: La unidad educativa Colegio &ldquo;Doctor  Arturo Uslar Pietri&rdquo;&nbsp; no se hace  responsable bajo ninguna raz&oacute;n ni circunstancia por la p&eacute;rdida de accesorios,  tel&eacute;fonos, u otros objetos de valor tra&iacute;dos por los estudiantes<br>
                PARAGRAFO SEGUNDO: En el momento de proceder a la  inscripci&oacute;n en la instituci&oacute;n, el representante o responsable junto con el  estudiante, firmar&aacute;n un ACTA DE COMPROMISO, mediante el cual se compromete a  respetar y cumplir las disposiciones establecidas en este Acuerdo de  Convivencia y las emanadas de las dem&aacute;s leyes o autoridades educativas  competentes.</p>
                <p class="texto_8pt_negro" align="center">CAPITULO IV: PADRES, REPRESENTANTES Y  RESPONSABLES<br>
                SECCION PRIMERA. DE LOS DERECHOS DE  LOS&nbsp; PADRES</p>
                <p class="texto_8pt_negro">Articulo 15&ordm;&nbsp; Los  padres, representantes y responsables de los estudiantes inscritos en la unidad  educativa colegio &ldquo;Doctor Arturo Uslar Pietri&rdquo;&nbsp;  ubicado en la calle 3 con carrera 12 y avenida Lucio Oquendo en la  parroquia la Concordia, Municipio San Crist&oacute;bal, Estado T&aacute;chira, tienen los  siguientes derechos y garant&iacute;as:</p>
                <ul>
                  <li class="texto_8pt_negro">Ser respetado por todas  las personas que integran la instituci&oacute;n educativa.</li>
                  <li class="texto_8pt_negro">Ser informado y participar  libre, activa y plenamente en el proceso educativo de sus representados, as&iacute;  como en todos los &aacute;mbitos de la vida escolar, entre ellos las actividades  educativas, recreacionales, deportivas, sociales y culturales que realice o  planifique la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Tener voz y voto en la  Asamblea General de Padres y Representantes</li>
                  <li class="texto_8pt_negro">Elegir y ser elegidos como  miembros de la comunidad educativa o de cualquier otra organizaci&oacute;n donde tenga  participaci&oacute;n la sociedad de padres y representantes.</li>
                  <li class="texto_8pt_negro">Ser atendidos  oportunamente con cordialidad y equidad por el personal docente, administrativo  y de apoyo, cuando acudan ante ellos para tratar asuntos que les conciernen,  siempre y cuando lo hagan dentro del horario del plantel.</li>
                  <li class="texto_8pt_negro">Presentar o dirigir  peticiones a personal directivo, docente, administrativo, de apoyo o a la  sociedad de padres y representantes, sobre asuntos que le conciernen y a  obtener respuesta oportuna y veraz a sus peticiones.</li>
                  <li class="texto_8pt_negro">Derecho a opinar  libremente sobre todos los asuntos de la vida escolar en el que tenga inter&eacute;s.</li>
                  <li class="texto_8pt_negro">Conocer los Acuerdos de  Convivencia&nbsp; de este Colegio. </li>
                  <li class="texto_8pt_negro">Los dem&aacute;s derechos y  garant&iacute;as reconocidas en el ordenamiento jur&iacute;dico, el presente Acuerdo de  Convivencia y los reglamentos especiales.</li>
                </ul>
                <p align="center" class="texto_8pt_negro">SECCION SEGUNDA. DE LOS DEBERES DE LOS  PADRES</p>
                <p class="texto_8pt_negro">Articulo 16&ordm;&nbsp; Los  padres, representantes y responsables de los estudiantes que cursan estudios en  la unidad educativa colegio &ldquo;Doctor Arturo Uslar Pietri&rdquo;&nbsp; ubicado en la calle 3 con carrera 12 y  avenida Lucio Oquendo en la parroquia la Concordia, Municipio San Crist&oacute;bal,  Estado T&aacute;chira, tienen los deberes y responsabilidades que se establecen:</p>
                <ul>
                  <li class="texto_8pt_negro">Garantizar el derecho a la  educaci&oacute;n de sus ni&ntilde;os, ni&ntilde;as y adolescentes bajo su patria de potestad,  custodia, representaci&oacute;n y responsabilidad.</li>
                  <li class="texto_8pt_negro">Respetar y cumplir las  disposiciones emanadas en estos Acuerdos de Convivencia.</li>
                  <li class="texto_8pt_negro">Orientar y fomentar en sus  estudiantes en cuanto a sus tareas, labores y responsabilidades acad&eacute;micas,  llevar un control de sus actividades, tener el horario de sus representados en  sitio visible.&nbsp; </li>
                  <li class="texto_8pt_negro">Orientar a sus  representados&nbsp; para que cumpla con el  horario de clase, que asista regularmente al colegio y no recargarle otras  actividades que pudieran socavar su tiempo como estudiante.</li>
                  <li class="texto_8pt_negro">Asistir al plantel a  reuniones, eventos, asambleas y cuando se le cite por cualquier evento en la  que este incurso su representado.</li>
                  <li class="texto_8pt_negro">Cuidar y estar pendiente  del uniforme escolar, de los &uacute;tiles que debe llevar al plantel y de las tareas  o trabajos que le sean asignados.</li>
                  <li class="texto_8pt_negro">Evitar que su representado  traiga objetos distintos a la actividad escolar al colegio, tales como:  pircengs, joyas, equipos de sonido, objetos que no sean de su propiedad, armas  u objetos contundentes que pudieran servir de agresi&oacute;n a terceros.</li>
                  <li class="texto_8pt_negro">Enviar a sus representados  con excelente aseo personal.</li>
                  <li class="texto_8pt_negro">Leer y firmar las circulares  enviadas por la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Dirigirse con el debido  respeto al docente que le haya citado, o&iacute;r las propuestas o quejas del docente,  dialogar y buscar una soluci&oacute;n pronta y eficaz para mejorar la actividad y  conducta de su representado.</li>
                  <li class="texto_8pt_negro">Responder civilmente por  los da&ntilde;os y deterioros que ocasionen&nbsp; los  ni&ntilde;os, ni&ntilde;as y adolescentes bajo su patria de potestad, custodia,  representaci&oacute;n o responsabilidad, al local, a los materiales, enseres,  mobiliario de la instituci&oacute;n, de conformidad con la legislaci&oacute;n vigente.</li>
                </ul>
                <p align="center" class="texto_8pt_negro">TITULO TERCERO<br>
                ACUERDOS DE CONVIVENCIA</p>
                <p align="center" class="texto_8pt_negro">CAPITULO I: INSCRIPCION DE LOS ESTUDIANTES</p>
                <p class="texto_8pt_negro">Art&iacute;culo 17&ordm;&nbsp;  Todos los ni&ntilde;os, ni&ntilde;as y adolescentes tienen derecho a ser inscritos  formalmente para recibir una educaci&oacute;n integral en la unidad educativa colegio  &ldquo;Doctor Arturo Uslar Pietri&rdquo;&nbsp; ubicado en  la calle 3 con carrera 12 y avenida Lucio Oquendo en la parroquia la Concordia,  Municipio San Crist&oacute;bal, Estado T&aacute;chira, siempre y cuando cumplan con:</p>
                <ul>
                  <li class="texto_8pt_negro">Requisitos y disposiciones  previstas en el ordenamiento jur&iacute;dico, el presente Acuerdo de Convivencia</li>
                  <li class="texto_8pt_negro">Que exista el &ldquo;cupo&rdquo; en  cualquiera de los subsistemas de educaci&oacute;n impartida en este colegio.</li>
                </ul>
                <p class="texto_8pt_negro">Art&iacute;culo 18&ordm;&nbsp; Los  ni&ntilde;os, ni&ntilde;as y adolescentes de este colegio, tienen derecho a mantener y  conservar su inscripci&oacute;n y prosecuci&oacute;n en el mismo, siempre que cumpla con los  requisitos y disposiciones presentes en el ordenamiento jur&iacute;dico y el presente  Acuerdo de Convivencia Escolar.</p>
                <p align="center" class="texto_8pt_negro">CAPITULO II: ACUERDOS ESPECIFICOS DE  CONVIVENCIA<br>
                SECCION PRIMERA. DEL UNIFORME DE LOS Y LAS  ESTUDIANTES</p>
                <p class="texto_8pt_negro">Art&iacute;culo 19&ordm;&nbsp; Los  y las estudiantes deben presentarse a la instituci&oacute;n, correctamente vestidos y  aseados.<br>
                  Art&iacute;culo 20&ordm;&nbsp; Los  y las estudiantes no podr&aacute;n ingresar al colegio con pircengs, pucas, tatuajes  visibles, gorras, pa&ntilde;ueletas.&nbsp; Su  presentaci&oacute;n&nbsp; debe ser sencilla con  respecto al maquillaje, zarcillos collares y peinados, cabello te&ntilde;ido (las  hembras), as&iacute; como el corte de cabello en los varones.&nbsp; Las hembras deben utilizar la falda 5 cms.  sobre la rodilla.<br>
                Articulo 21&ordm;&nbsp;  Todos los y las estudiantes deben asistir a clases, a las actividades  culturales y deportivas portando el traje escolar correspondiente a la  actividad indicada en el horario, seg&uacute;n lo establecido en el decreto 1139 de  gaceta oficial 32271 del 16 de julio de 1981.&nbsp;  El traje escolar es el siguiente:</p>
                <ul>
                  <li class="texto_8pt_negro">Los y las estudiantes del  subsistema primaria utilizar&aacute;n:</li>
                  <li class="texto_8pt_negro">Pantal&oacute;n y/o falta de  gabardina azul marino con pretina a la cintura</li>
                  <li class="texto_8pt_negro">Camisa o chemise blanca  con mangas y la insignia del colegio bordada al lado izquierdo.&nbsp; La camisa o franela debe ir por dentro.</li>
                  <li class="texto_8pt_negro">Correa y zapatos negros</li>
                  <li class="texto_8pt_negro">Pul&oacute;ver azul con la  insignia del colegio. </li>
                  <li class="texto_8pt_negro">El traje de educaci&oacute;n  f&iacute;sica&nbsp; consta de un mono y franela color  verde con la insignia del colegio tanto en el pantal&oacute;n mono como en la franela.</li>
                  <li class="texto_8pt_negro">Los y las estudiantes del  subsistema secundaria utilizar&aacute;n:</li>
                  <li class="texto_8pt_negro">Pantal&oacute;n y/o falda de  gabardina azul marino con pretina a la cintura</li>
                  <li class="texto_8pt_negro">Camisa o chemise azul  (b&aacute;sica) y beige (diversificado) con mangas&nbsp;  y la insignia del colegio bordada al lado izquierdo.&nbsp;&nbsp; La camisa o chemise debe ir por dentro del  pantal&oacute;n.</li>
                  <li class="texto_8pt_negro">Correa y zapatos negros</li>
                  <li class="texto_8pt_negro">Pul&oacute;ver azul con la  insignia del colegio.</li>
                  <li class="texto_8pt_negro">El traje de educaci&oacute;n  f&iacute;sica consta de un mono y franela color verde con la insignia del colegio  tanto en el pantal&oacute;n mono como en la franela.</li>
                  <li class="texto_8pt_negro">El uniforme de premilitar  consta de un pantal&oacute;n negro, franela con el distintivo de premilitar bordado en  la parte izquierda y gorra negra con la insignia militar correspondiente.</li>
                </ul>
                <p class="texto_8pt_negro">PARAGRAFO PRIMERO: El uso de los morrales queda a  discreci&oacute;n de las autoridades del plantel y ser&aacute;n sujetos de revisi&oacute;n sin  previo aviso por cualquier directivo o docente de la instituci&oacute;n.<br>
                PARAGRAFO SEGUNDO: El uso de chaqueta o abrigo ser&aacute;  permitido solo en forma abierta para permitir la visibilidad de la insignia.</p>
                <p align="center" class="texto_8pt_negro">SECCION SEGUNDA. DE LA ASISTENCIA Y  PUNTUALIDAD</p>
                <p class="texto_8pt_negro">ART&Iacute;CULO 22&ordm;&nbsp; La  asistencia a clase es obligatoria (art 109&ordm; del reglamento general de la ley  org&aacute;nica de educaci&oacute;n) y para aprobar el grado o asignatura correspondiente,  ser&aacute; necesario un porcentaje m&iacute;nimo de asistencia del 75%.&nbsp; La aplicaci&oacute;n de este art&iacute;culo es el  siguiente:</p>
                <ul>
                  <li class="texto_8pt_negro">Cuando un estudiante  presenta tres inasistencias al mes, el docente deber&aacute; citar al representante  legal y reportar el caso a la coordinaci&oacute;n pedag&oacute;gica y a la coordinaci&oacute;n de  protecci&oacute;n y bienestar estudiantil.</li>
                  <li class="texto_8pt_negro">Si a pesar de los  esfuerzos realizados en este sentido, el estudiante acumula el 25%, se citar&aacute; a  su representante o responsable legal y en presencia del estudiante, se  levantar&aacute; un acta en la cual queda registrada la p&eacute;rdida del a&ntilde;o escolar  vigente.</li>
                  <li class="texto_8pt_negro">En caso de que el  representante citado en tres ocasiones, no se presente, el caso ser&aacute; remitido a  la direcci&oacute;n y esta oportunamente lo har&aacute; llegar a la defensor&iacute;a estudiantil  para el procedimiento pertinente.</li>
                </ul>
                <p align="center" class="texto_8pt_negro">SECCION TERCERA. DEL HORARIO ESCOLAR</p>
                <p class="texto_8pt_negro">Articulo 23&ordm;&nbsp; Las  actividades escolares de la Unidad Educativa Colegio Doctor Arturo Uslar  Pietri, comienzan a las 7 a.m. hasta las 12.45 p.m. y de 1.30 p.m. a 6.05  p.m.&nbsp; Los estudiantes del subsistema de  educaci&oacute;n primaria&nbsp; laboran en el turno  de la ma&ntilde;ana y los estudiantes del subsistema de educaci&oacute;n secundaria&nbsp; laboran durante todo el d&iacute;a de acuerdo a su  horario de clase.<br>
                Art&iacute;culo 24&ordm;&nbsp;  Iniciada la actividad de clase no se permite estudiantes en los pasillos  y alrededor del colegio.&nbsp; En caso de  retardos el o la estudiante debe solicitar a la coordinaci&oacute;n correspondiente el  pase para tener acceso al sal&oacute;n de clase y debe justificar dicho retardo.&nbsp; Cuando sea reiterativo se le citar&aacute; el  representante para conocer las razones y establecer mecanismos de colaboraci&oacute;n  mutua.</p>
                <p align="center" class="texto_8pt_negro">SECCION CUARTA.&nbsp; DE LA EVALUACION</p>
                <p class="texto_8pt_negro">Art&iacute;culo 25&ordm;&nbsp;  Todos los procesos de evaluaci&oacute;n estar&aacute;n sujetos a las normas  establecidas por la Ley Org&aacute;nica de Educaci&oacute;n, su reglamento y las  disposiciones legales.<br>
                  Articulo 26&ordm;&nbsp; El  r&eacute;gimen de evaluaci&oacute;n se cumplir&aacute; como parte del proceso educativo como una  actividad remanente dentro de los par&aacute;metros normales de la ejecuci&oacute;n&nbsp; y ser&aacute; continua, reflexiva, integral,  sistem&aacute;tica, acumulativa e informativa.&nbsp;  Ser&aacute;n ejecutadas los tipos de evaluaci&oacute;n exploratoria o diagn&oacute;stica,  evaluaci&oacute;n de proceso o formativa, final o sumativa.&nbsp; Esta &uacute;ltima se har&aacute; a trav&eacute;s de un horario  especial de presentaci&oacute;n de cierre de lapso.<br>
                  Art&iacute;culo 27&ordm; Al iniciar cada lapso, el docente debe  elaborar y discutir el plan de evaluaci&oacute;n con los grados y estar dispuestos a  escoger las sugerencias y propuestas de los estudiantes siempre que enriquezcan  el proceso educativo.<br>
                  Art&iacute;culo 28&ordm;&nbsp; Los  estudiantes que padezcan impedimentos f&iacute;sicos o enfermedades de car&aacute;cter  pulmonar o bronquial que le impidan cumplir con la asignatura de educaci&oacute;n  f&iacute;sica o pr&aacute;ctica premilitar&nbsp; deben  asign&aacute;rseles trabajos escritos u orales relacionados con el contenido  desarrollado durante el lapso.&nbsp; La ponderaci&oacute;n  de rasgos debe incluir asistencia a clase, cumplimiento del uniforme y disciplina  escolar.<br>
                Art&iacute;culo 29&ordf; El departamento o coordinaci&oacute;n de  evaluaci&oacute;n o control de estudios deben suministrar a los estudiantes o  representantes la informaci&oacute;n que consideren necesaria para informarse de la  situaci&oacute;n en sus evaluaciones, as&iacute; como los reclamos que considere necesarios  cuando sienta que sus derechos en esta fase han sido violados o cercenados.</p>
                <p align="center" class="texto_8pt_negro">CAPITULO III: REGIMEN DISCIPLINARIO DE LOS  Y LAS ESTUDIANTES</p>
                <p align="center" class="texto_8pt_negro">SECCION PRIMERA: DE LA DISCIPLINA</p>
                <p class="texto_8pt_negro">Art&iacute;culo 30&ordm;&nbsp; La  disciplina escolar debe ser administrada de acuerdo con las garant&iacute;as, derechos  y deberes consagrados en el presente Acuerdo de Convivencia Escolar, sin  menoscabo&nbsp; de lo establecido en el  art&iacute;culo 226 de la L.O.G.N.A., previa apertura del expediente administrativo,  por tal motivo se considera&nbsp; que el  estudiante ha incurrido en faltas comprobadas y ser&aacute; sancionado cuando:</p>
                <ul>
                  <li class="texto_8pt_negro">No vista el uniforme  reglamentario del colegio, ya sea el de clase, deportivo o de premilitar.</li>
                  <li class="texto_8pt_negro">Por presentarse al plantel  sin sus correspondientes &uacute;tiles escolares.</li>
                  <li class="texto_8pt_negro">Por su notable desaseo  personal.</li>
                  <li class="texto_8pt_negro">Por no cumplir con sus  asignaciones escolares.</li>
                  <li class="texto_8pt_negro">Por vocabulario vulgar y  obsceno con sus compa&ntilde;eros o con el personal del plantel.</li>
                  <li class="texto_8pt_negro">Por negarse a  identificarse&nbsp; ante cualquier autoridad o  personal del plantel.</li>
                  <li class="texto_8pt_negro">Por acusar o  responsabilizar a terceros por actos que no ha cometido.</li>
                  <li class="texto_8pt_negro">Por portar material  pornogr&aacute;fico, armas o utensilios ajenos a la actividad escolar dentro del  per&iacute;metro del colegio.</li>
                  <li class="texto_8pt_negro">Por irrespeto a los  s&iacute;mbolos patrios.</li>
                  <li class="texto_8pt_negro">Por participar, incitar a  la violencia, a las ri&ntilde;as callejeras, pleitos dentro o en el per&iacute;metro del  colegio.</li>
                  <li class="texto_8pt_negro">Por inasistencia  reiterada, notoria, injustificada y p&uacute;blica a clase.</li>
                  <li class="texto_8pt_negro">Por deteriorar uniformes,  &uacute;tiles escolares o personales propios o de sus compa&ntilde;eros.</li>
                  <li class="texto_8pt_negro">Por cometer actos de  apropiaci&oacute;n indebida, hurto de objetos o realizar negocios il&iacute;citos dentro o en  el per&iacute;metro de la instituci&oacute;n.</li>
                  <li class="texto_8pt_negro">Por cometer fraude durante  el proceso de evaluaci&oacute;n</li>
                  <li class="texto_8pt_negro">Por alterar, enmendar y/o  deteriorar documentos tales como: boletines de calificaciones, diarios de  clase, planillas de registro de evaluaci&oacute;n y cualquier otro documento&nbsp; inherente al quehacer educativo del colegio.</li>
                  <li class="texto_8pt_negro">Cuando deteriore directa o  con ayuda de terceros mobiliario, locales o bienes del colegio.</li>
                  <li class="texto_8pt_negro">Por causar lesiones f&iacute;sicas  a otros estudiantes o personal del plantel en forma intencional, con alevos&iacute;a y  premeditaci&oacute;n o proferir amenazas </li>
                  <li class="texto_8pt_negro">Por introducir,  distribuir, portar o consumir sustancias psicotr&oacute;picas o estupefacientes,  bebidas alcoh&oacute;licas, chimo, cigarrillos, estimulantes o cualquier sustancia  nociva para la salud.</li>
                  <li class="texto_8pt_negro">Por introducir, utilizar  armas de cualquier tipo, municiones, explosivos o fuegos artificiales de  cualquier naturaleza.</li>
                </ul>
                <p class="texto_8pt_negro">PARGRAFO UNICO: las faltas anteriores no son taxativas,  son solo enunciativas Lo que cualquier otra falta&nbsp; no establecida en este Acuerdo de Convivencia  Escolar&nbsp; ser&aacute; sancionada de acuerdo a su  gravedad por la autoridad educativa correspondiente.</p>
                <p align="center" class="texto_8pt_negro">SECCION SEGUNDA. DE LAS SANCIONES</p>
                <p class="texto_8pt_negro">Art&iacute;culo 31&ordm;&nbsp; Las  sanciones y su correspondiente procedimiento en concordancia con el art&iacute;culo  57&ordm; de la L.O.G.N.A.: la disciplina escolar debe ser administrada de forma  acorde con los derechos, garant&iacute;as y deberes de los ni&ntilde;os y adolescentes.&nbsp; En consecuencia:</p>
                <ul>
                  <li class="texto_8pt_negro">Se establecen como hechos  susceptibles de sanci&oacute;n a todas las faltas disciplinarias establecidas en el  art&iacute;culo 30&ordm; Secci&oacute;n Primera, Cap&iacute;tulo III&nbsp;  de los Acuerdos de Convivencia aqu&iacute; establecidos.&nbsp; </li>
                  <li class="texto_8pt_negro">Todos los ni&ntilde;os, ni&ntilde;as,  adolescentes que son estudiantes regulares de esta instituci&oacute;n educativa&nbsp; ser&aacute;n informados previamente en forma verbal  o por escrito de los actos disciplinarios que son objeto de sanciones.</li>
                  <li class="texto_8pt_negro">Antes de la imposici&oacute;n de  cualquier sanci&oacute;n debe garantizarse a todos los estudiantes el ejercicio pleno  de sus derechos, por lo tanto tiene acceso a la leg&iacute;tima defensa, a conocer el  expediente que se le ha procesado&nbsp; y la  posibilidad de impugnar ante la autoridad superior e imparcial.</li>
                  <li class="texto_8pt_negro">Queda terminantemente  prohibida la sanci&oacute;n de car&aacute;cter corporal, vilipendio o tortura personal o  colectiva.&nbsp; Igualmente se proh&iacute;be la  aplicaci&oacute;n de la sanci&oacute;n cuando la estudiante este embarazada.</li>
                </ul>
                <p class="texto_8pt_negro">PARAGRAFO PRIMERO: Las sanciones por faltas leves se  aplicar&aacute; seg&uacute;n el siguiente procedimiento:&nbsp; </p>
                <ul>
                  <li class="texto_8pt_negro">Amonestaci&oacute;n verbal,  aplicada por el docente, coordinador pedag&oacute;gico o coordinador de protecci&oacute;n  estudiantil</li>
                  <li class="texto_8pt_negro">Tres amonestaciones  verbales&nbsp; dan lugar a una amonestaci&oacute;n  escrita, la cual se registrar&aacute; en el libro de vida o expediente del estudiante.</li>
                  <li class="texto_8pt_negro">Amonestaci&oacute;n escrita ser&aacute;  aplicada por el coordinador pedag&oacute;gico&nbsp;  conjuntamente con el director del colegio, dejando constancia&nbsp; en el registro correspondiente, debidamente  firmada por el estudiante.</li>
                  <li class="texto_8pt_negro">Tres amonestaciones  escritas dar&aacute; lugar a la aplicaci&oacute;n de sanciones previstas en el reglamento de  la ley de educaci&oacute;n vigente.</li>
                </ul>
                <p class="texto_8pt_negro">PARAGRAFO SEGUNDO: Queda establecido que todo  estudiante tiene derecho a la apelaci&oacute;n de los actos que se&nbsp; le han imputado ante la autoridad del plantel  y tiene tres d&iacute;as h&aacute;biles para presentar sus alegatos por escrito<br>
                  PARAGRAFO TERCERO: La imposici&oacute;n de cualquier sanci&oacute;n  ser&aacute; notificada al estudiante asistido por su representante legal.&nbsp; Podr&aacute; el estudiante ejercer la leg&iacute;tima  defensa, solicitar recurso de reconsideraci&oacute;n ante la autoridad que la aplic&oacute;  as&iacute; como tambi&eacute;n ejercer el recurso jer&aacute;rquico ante la autoridad superior de la  instituci&oacute;n, coordinaci&oacute;n municipal de educaci&oacute;n o zona educativa  correspondiente.<br>
                PARAGRAFO CUARTO: Todas las faltas cometidas por los y  las estudiantes&nbsp; deben ser asentadas en  el libro de incidencias&nbsp; diarias&nbsp; y en su respectivo expediente.</p>
                <p align="center" class="texto_8pt_negro">SECCION TERCERA. DE LA JUSTICIA Y PAZ  ESCOLAR</p>
                <p class="texto_8pt_negro">Art&iacute;culo 32&ordm; Es el mecanismo&nbsp; que permite la resoluci&oacute;n amistosa, r&aacute;pida y  efectiva&nbsp; de cualquier conflicto que  pudiera presentarse entre los y las estudiante en un momento determinado y  dentro de la jurisdicci&oacute;n del colegio.&nbsp;  La justicia de paz escolar ser&aacute; administrada por un juez que ser&aacute;  elegido&nbsp; democr&aacute;ticamente&nbsp; por sus propios compa&ntilde;eros y contar&aacute; para el  desempe&ntilde;o de sus funciones a un determinado n&uacute;mero de cojueces, igualmente  elegidos por el voto de los y las estudiantes,&nbsp;  y que le ayudar&aacute;n y representar&aacute;n en el momento en que sea oportuno para  dirimir conflictos.<br>
                Art&iacute;culo 33&ordm;&nbsp; El  juez de paz escolar&nbsp; y los cojueces deben  tener el siguiente perfil:</p>
                <ul>
                  <li class="texto_8pt_negro">Ser estudiante regular del  colegio</li>
                  <li class="texto_8pt_negro">Ser imparcial</li>
                  <li class="texto_8pt_negro">Alto sentido de altruismo</li>
                  <li class="texto_8pt_negro">Cooperativo </li>
                  <li class="texto_8pt_negro">Respeto por los dem&aacute;s</li>
                  <li class="texto_8pt_negro">Optimista, creativo y  positivo</li>
                  <li class="texto_8pt_negro">Propiciar la paz y la  tranquilidad en el &aacute;mbito educativo.</li>
                </ul>
                <p class="texto_8pt_negro">Art&iacute;culo 34&ordm;&nbsp; Son  funciones del juez de paz y sus respectivos cojueces:</p>
                <ul>
                  <li class="texto_8pt_negro">Fomentar la justicia,&nbsp; la paz&nbsp;  y los valores</li>
                  <li class="texto_8pt_negro">Establecer pautas&nbsp; y reglas en el momento de dirimir&nbsp; conflictos y problemas</li>
                  <li class="texto_8pt_negro">Buscar asesor&iacute;a legal para  fomentar charlas, eventos y o actividades&nbsp;  que promuevan la paz y el entendimiento escolar</li>
                  <li class="texto_8pt_negro">Llevar un control&nbsp; de las actividades&nbsp; realizadas&nbsp;  y presentar soluciones&nbsp; coherentes  ajustadas a la realidad y que tengan un alto sentido de imparcialidad</li>
                  <li class="texto_8pt_negro">Conocer y tener  fundamentos sustentados de los Acuerdos de Convivencia que tiene el colegio</li>
                  <li class="texto_8pt_negro">Atender situaciones  escolares cuando tenga conocimiento de que alg&uacute;n estudiante ha sido objeto de  exclusi&oacute;n, exceso de autoridad, sumisi&oacute;n, maltrato por parte de alguna  autoridad o de estudiantes</li>
                </ul>
                <p class="texto_8pt_negro"> Promover la igualdad  estudiantil, teniendo como norte que el estudiante tiene como privilegio el  derecho a ser atendido como tal y como ciudadano. </p>
                <p class="texto_8pt_negro">&nbsp;</p>
              <p class="texto_8pt_negro" align="center">Firma del Estudiante&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Firma del Representante</p></td>
            </tr>
          </table>
          <?php } // Show if recordset not empty ?>
      <tr>
      <td valign="top"><?php if ($totalRows_inscripcion == 0) { // Show if recordset empty ?>
        <table width="400" border="0" align="center">
          <tr>
            <td><div align="center"><img src="../images/PNG/atencion.png" width="80" height="72"><br>
              <br>
              <span class="titulo_grande_gris">&quot; Error no existen datos&quot;</span><span class="texto_mediano_gris"><br>
                <br>
                Cierra esta ventana y vuelve a escribir tu n&uacute;mero de c&eacute;dula<br>
                acuerdate que no debe llevar ni puntos, ni espacios...</span><br>
            </div></td>
          </tr>
        </table>
        <?php } // Show if recordset empty ?>
    <tr><td>    </td>
    
    <tr>
      <td></td>
    <tr>
      <td></td>
    <tr>
      <td></td>
    <tr>
      <td></td>
    </table>
</body>
</center>
</html>
<?php
mysql_free_result($inscripcion);

mysql_free_result($colegio);
?>
