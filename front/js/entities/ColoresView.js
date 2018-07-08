var colores = {};

ColoresView = {
	getColoresGrid: function (filters){
		$.ajax({
			type:'GET',
			url: '../../src/controller/ColorController.php',
			data: {method: 'getColorsGrid', filters: filters},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					colores = responce.data.resultSet;
					responce.data.actions = ColoresView.actions;
					var table = $('#catalogo-table');
					if(responce.success){
						TableCreator.fillUserTable(responce.data, table);
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
		{type:'light', label:'', icon:'fa fa-edit', _class:'btn-edit-usr', size:'', functionECute:'openUpdateModal($(this).parent().parent());'},
		{type:'danger', label:'', icon:'fa fa-close', _class:'btn-delete-usr', size:'', functionECute:'deleteUser($(this).parent().parent());'}]
};