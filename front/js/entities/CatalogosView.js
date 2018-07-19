CatalogosView = {
	elements: {},
	rootURL: '',
	deleteMethod: '',
	getCatalogosGrid: function (data){
		$.ajax({
			type:'GET',
			url: CatalogosView.rootURL,
			data: data,
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					CatalogosView.elements = responce.data.resultSet;
					responce.data.actions = CatalogosView.actions;
					var table = $('#catalogo-table');
					if(responce.success){
						TableCreator.fillTable(responce.data, table);
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
	actions: [
		{type:'light', label:'', icon:'fa fa-edit', _class:'btn-edit-usr', size:'', functionECute:'catalogosController.openUpdateModal($(this).parent().parent());'},
		{type:'danger', label:'', icon:'fa fa-close', _class:'btn-delete-usr', size:'', functionECute:'catalogosController.deleteElement($(this).parent().parent());'}]
};