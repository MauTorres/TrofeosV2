UsersView = {
	getUsersGrid: function (){
		$.ajax({
			type:'GET',
			url: '../../src/controller/UsuarioController.php',
			data: {method: 'getUsersGrid'},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					responce.data.actions = UsersView.actions;
					var table = $('#user-table');
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
		{type:'light', label:'', icon:'fa fa-edit', _class:'btn-edit-usr', size:''},
		{type:'danger', label:'', icon:'fa fa-close', _class:'btn-delete-usr', size:''}]
};
function editUser(row){
	
}
$(document).ready(function(){
	MenuNavs.getMenuNavs('usuarios');
	UsersView.getUsersGrid();
});
