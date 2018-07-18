var SessionController = {
	usuario: null,
	endSession: function (){
		$.ajax({
			type:'POST',
			url: '../../src/controller/SessionController.php',
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
	},
	getSession: function (){
		return $.ajax({
			type:'GET',
			url: '../../src/controller/SessionController.php',
			data: {method:'getSession'}
		});
	},
	sessionFailed: function(message){
		alert(message);
		window.location.replace("../../");
	},
	checkSession: function(pageName){
		$.when(SessionController.getSession()).done(function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(!responce.success){
					SessionController.sessionFailed("No se pudo obtener la sesión");
				}
			}catch(err){
				SessionController.sessionFailed("Ocurrió un error en el servidor");
			}
			MenuNavs.getMenuNavs(pageName, responce.data);
		});
	}
}