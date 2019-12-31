/*var encrypt = new JSEncrypt({default_key_size: 2048});
var publicKey = 
"-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzPNd/emKzu00M1ZPkmXDvXakc14/fS9P/2hQiCdDjKvy56qhjE3DgpA1b7PKK/cZ1pv3SN2Zg2XoBmOzTJPRsjfSNe0LofEzdkSDysZmILUpLoiXls8XM7UpTwfgk41SUr6QtuwVuOK2UJXu4pB5Kc4AzkgGmFgSdvLr4mjmF5L9O7qsiLe7Dj3HLyxxPIBbxsQGPJdzI/aEDzKqSCK8FKZioRXLiMT0V3ZEVV3iDgpNIxcuSi9lKiSvZYMBGMcxPkZYODarIwdCf6lzrQA4IlRw6LOeymo0uuCTRqM6izVmGcvHetHJUxhGKGA4rVofzY0/ctymCdhU2W9YhTDHqQIDAQAB-----END PUBLIC KEY-----";
encrypt.setPublicKey(publicKey);*/

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
		type:'POST',
		url: './src/controller/SessionController.php',
		data: usuario,
		success: function(data){
			console.log(data);
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					window.location.replace("./front/views/main.html");
				}else{
					notifyWarning('El usuario o contraseña son incorrectos');
					return;
				}
			}catch(err){
				console.error(err);
				notifyError("Ha ocurrido un error con el servidor. Por favor, vuelva a intentar", "Error con el servidor")
				return;
			}
			//Despliegue de información en la vista				
		},
		//En caso de error se informa al usuario
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			notifyError("Ha ocurrido un error con el servidor. Por favor, vuelva a intentar", "Error con el servidor")
			console.error(textStatus + ": " + errorThrown);
		}
	});
}

$(document).ready(function(){
	$('form').submit(function(event){
		//if($(this).isValid()){
			event.preventDefault();
			logginPOST();
		//}
	});
});