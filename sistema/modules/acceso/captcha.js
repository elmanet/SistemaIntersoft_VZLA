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
			username:"required",
			password:"required",
		},
		messages: {
			captcha: " Captcha Incorrecto!",
			username: " Debes Ingresar T&uacute; Login",
			password: " Debes Ingresar T&uacute; Clave",	
		},

		onkeyup: true
	});
	
});
