<link rel="stylesheet" type="text/css" media="screen" href="../../js/css/screen.css" />
<script src="../../js/lib/jquery-1.7.2.js" type="text/javascript"></script>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	// validate signup form on keyup and submit
	$("#signupForm").validate({
		rules: {
			nom_alumno: "required",
			ape_alumno: "required",
         apellido_alumno: "required",
			cedalumno: {
				required: true,
				number: true
			},
			dir_alumno: "required",
			tel_alumno: "required",
			fecha_nacimiento: "required",
			gradocursar: "required",
			emailcliente: {
				required: true,
				email: true
			},
			no_deposito: {
				required: true,
				number: true
			},
			monto: {
				required: true,
				number: true
			},
			fecha1: {
				required: true,
				number: true,
				minlength: 2
			},
			fecha2: {
				required: true,
				number: true,
				minlength: 2
			},
			fecha3: {
				required: true,
				number: true,
				minlength: 4
			},
			username:"required",
			password:"required",
					
			
			
			
			
			
		},
		messages: {
			nom_alumno: "<br />Debes Ingresar el Nombre del Cliente",
			apellido_alumno: "<br />Debes el nombre, apellido o la c&eacute;dula del Estudiante",
			cedalumno: "<br />No. de Cedula Invalido o Vacio",
			dircliente: "<br />Debes Ingresar la Direccion",
			telcliente: "<br />Debes Ingresar el No. de Telefono",
			emailcliente: "<br />Por favor ingresa un Email Valido",
			no_deposito: "Ingresa No. de Deposito",
			monto: "Ingresa el Monto",
			fecha1: "Dia",
			fecha2: "Mes",
			fecha3: "A&ntilde;o",
			username: "Debes Ingresar T&uacute; Login2",
			password: "Debes Ingresar T&uacute; Clave2",

		}
	});
});
</script>
<style type="text/css">
#signupForm { width: 670px; }
#signupForm label.error {
	margin-left: 10px;
	width: auto;
	display: inline;
	color:red;
}
</style>
