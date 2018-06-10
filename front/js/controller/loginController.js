function Usuario(nombre, passwd, method){
	this.usuario = nombre;
	this.passwd = passwd;
	this.method = method;
}

function logginPOST(){
	var uName = $('#user').val();
	var uPasswd = $('#passwd').val();
	var usuario = new Usuario(uName, uPasswd, 'login');
	
	$.ajax({
		type:'GET',
		url: './src/controller/UsuarioController.php',
		data: usuario,
		success: function(data){
			console.log(data);
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					window.location.replace("./front/views/main.php");
				}else{
					alert("El usuario o contraseña no son correctos");
					return;
				}
			}catch(err){
				alert("Ha ocurrido un error en el servidor");
				return;
			}
			//Despliegue de información en la vista
			
			
				
				
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