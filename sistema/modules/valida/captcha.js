$(function(){
	$("#refreshimg").click(function(){
		$.post('newsession.php');
		$("#captchaimage").load('image_req.php');
		return false;
	});
	
	$("#captchaform").validate({
		rules: {
			captcha: {
				required: true,
				remote: "process.php"
			},
			nom_alumno: "required",
			ape_alumno: "required",
			ced_alumno: {
				required: true,
				number: true
			},
			dir_alumno: "required",
			tel_alumno: "required",
			fecha_nacimiento: "required",
			edad:{
				required: true,
				number: true
			},
			grado_cursar: "required",
			porque_retira: "required",
			comportamiento: "required",
			quien_vives: "required",
			ingreso_familiar:"required",
			recomendado: "required",
			pago_mensualidad: "required",
			check: "required",
			
			
			username:"required",
			password:"required",
			
			
			nombre: "required",
			apellido: "required",
			cedula: {
				required: true,
				number: true
			},
			sexo: "required",
			direccion_vivienda: "required",
			telefono_alumno: "required",
			fecha_nacimiento: "required",
			lugar_nacimiento: "required",
			estado: "required",
			ef: "required",
			anios_id: "required",
			cedula_representante: "required",
			nombre_representante: "required",
			apellido_representante: "required",
			direccion_representante: "required",
			telefono_representante: "required",
			email_representante: {
				required: true,
				email: true
			},
			descripcion_trabajo: "required",
			direccion_trabajo: "required",
			telefono_trabajo: "required",
			cedula_madre: {
				number: true
			},
			cedula_padre: {
				number: true
			},			
			
		},
		messages: {
			captcha: " <br /><div style='color:red; font-weight: bold; font-size:10px;'>* Captcha Incorrecto!</div>",
			ced_alumno: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el No. de C&eacute;dula del Estudiante Ej. 24567845</div>",
			nom_alumno: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el Nombre del Estudiante</div>",
			ape_alumno: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el Apellido del Estudiante</div>",
			dir_alumno: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la Direcci&oacute;n del Estudiante</div>",
			tel_alumno: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa t&uacute; No. de Tel&eacute;fono</div>",
			fecha_nacimiento: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la fecha de nacimiento del Estudiante</div>",
			edad: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la Edad del Estudiante</div>",	
			grado_cursar: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el Grado a Cursar</div>",
			porque_retira: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Debes ingresar la Informaci&oacute;n requerida</div>",
			comportamiento: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Debes ingresar la Informaci&oacute;n requerida</div>",
			quien_vives: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Debes ingresar la Informaci&oacute;n requerida</div>",
			ingreso_familiar: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Debes ingresar la Informaci&oacute;n requerida del ingreso</div>",
			recomendado: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Debes ingresar la Informaci&oacute;n requerida</div>",
			pago_mensualidad: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Debes ingresar la Informaci&oacute;n requerida </div>",
			check: "<div style='color:red; font-weight: bold; font-size:10px;'> * Debes estar de acuerdo para continuar </div>",			
			
			username: " Debes Ingresar T&uacute; Login",
			password: " Debes Ingresar T&uacute; Clave",	
			
			cedula: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el No. de C&eacute;dula del Estudiante Ej. 24567845</div>",
			nombre: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el Nombre del Estudiante</div>",
			apellido: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el Apellido del Estudiante</div>",
			sexo: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el sexo del Estudiante</div>",
			direccion_vivienda: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la Direcci&oacute;n del Estudiante</div>",
			telefono_alumno: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa t&uacute; No. de Tel&eacute;fono</div>",
			fecha_nacimiento: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la fecha de nacimiento del Estudiante</div>",	
			lugar_nacimiento: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el lugar de nacimiento del Estudiante</div>",			
			estado: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el estado de nacimiento del Estudiante</div>",
			ef: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la Entidad Federal del Estudiante. Ej. TA si es T&aacute;chira</div>",			
			anios_id: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el A&ntilde;o a Cursar</div>",
   	   cedula_representante: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la c&eacute;dula del Representante</div>",
			nombre_representante: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el nombre del Representante</div>",
			apellido_representante: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el apellido del Representante</div>",
			direccion_representante: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la direcci&oacute;n del Representante</div>",
			telefono_representante: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el No. de Tel&eacute;fono del Representante</div>",
			email_representante: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el e-mail del Representante</div>",
			descripcion_trabajo: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la ocupaci&oacute;n del Representante</div>",
			direccion_trabajo: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa la direcci&oacute;n de trabajo del Representante</div>",
			telefono_trabajo: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * Ingresa el No. de Tel&eacute;fono de trabajo  del Representante</div>",
			cedula_madre: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * La C&eacute;dula s&oacute;lo debe contener numeros</div>",
			cedula_padre: "<br /><div style='color:red; font-weight: bold; font-size:10px;'> * La C&eacute;dula s&oacute;lo debe contener numeros</div>",
		},

		onkeyup: true
	});
	
});
