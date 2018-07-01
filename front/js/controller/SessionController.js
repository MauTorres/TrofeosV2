function endSession(){
	$.ajax({
		type:'POST',
		url: '../../src/controller/UsuarioController.php',
		data: {method:'endSession'},
		success: function(data){
			console.log(data);
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					window.location.replace("../../");
				}else{
					alert("Error, no se pudo cerrar la sesión");
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