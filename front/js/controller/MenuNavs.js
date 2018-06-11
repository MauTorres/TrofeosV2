MenuNavs = {
	setMenuNavs: function (navsNameArray, currentPage){
		var navVar = $(".navbar-nav");
		var navItem;
		for(var navsCount = 0; navsCount < navsNameArray.length; navsCount ++){
			navItem = navsNameArray[navsCount];
			var active = '';
			if(navItem.descripcion == currentPage)
				active = 'active';
			navVar.append('<a class="nav-item nav-link ' + active + '" href="' + navItem.descripcion + '.php">' + navItem.descripcion + '</a>');
		}
	},
	getMenuNavs: function (currentPage){
		$.ajax({
			type:'GET',
			url: '../../src/controller/VistasController.php',
			data: {method: 'getVistasAll'},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					if(responce.success){
						MenuNavs.setMenuNavs(responce.data, currentPage);
					}else{
						alert("Ha ocurrido un error en el servidor");
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
};