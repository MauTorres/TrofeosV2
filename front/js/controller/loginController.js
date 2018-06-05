function Usuario(nombre, passwd){
	return {usuario:nombre, passwd:passwd};
}

function logginPOST(){
	var uName = $('#user').val();
	var uPasswd = $('#passwd').val();
	var usuario = Usuario(uName, uPasswd);
	usuario.method = 'login';
	
	$.ajax({
		type:'POST',
		url: './src/controller/UsuarioController.php',
		data: usuario,
		success: function(data){
			console.log(data);
			//Despliegue de información en la vista
			
			/*if(data == "failure"){
				alert("El usuario o contraseña no son correctos");
				return;
			}else if(data == "succes")
				window.location.replace("./gui/volumetrias.php");
			else
				alert("Ocurrió un error en el servidor");*/
		},
		//En caso de error se informa al usuario
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Error contactando con el servidor");
		}
	});
}

$(document).ready(function(){
	$('form').submit(function(event){
		//if($(this).isValid()){
			event.preventDefault();
			console.log("Loggin");
			logginPOST();
		//}
	});
});