var clientes = {};
var isCollapseUp = true;

UsersView = {
	getUsersGrid: function (filters){
		$.ajax({
			type:'GET',
			url: '../../src/controller/ClienteController.php',
			data: {method: 'getUsersGrid', filters: filters},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					clientes = responce.data.resultSet;
					responce.data.actions = UsersView.actions;
					var table = $('#client-table');
					if(responce.success){
						TableCreator.fillTable(responce.data, table, [0, 1, 2, 3]);
					}
				}catch(err){
					console.error(err);
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
		{type:'light', label:'', icon:'fa fa-edit', _class:'btn-edit-usr', size:'', functionECute:'openUpdateModal($(this).parent().parent());', component:'button'},
		{type:'danger', label:'', icon:'fa fa-close', _class:'btn-delete-usr', size:'', functionECute:'deleteUser($(this).parent().parent());', component:'button'}]
};

function deleteUser(row){
	var userDelete = clientes[row.index()];
	userDelete.method = 'deleteUser';
	$.ajax({
		type:'POST',
		url: '../../src/controller/ClienteController.php',
		data: userDelete,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					UsersView.getUsersGrid(null);
					alert(responce.message);
				}
			}catch(err){
				console.error(err);
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
	userDelete.method = undefined;
}

function createOrUpdateUser(){
	var userUpdate = {};
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		userUpdate = clientes[parseInt($('#row-index').val())];	
	}else{
		userUpdate.id = null;
	}
	
	userUpdate.method = 'createOrUpdateUser';
	userUpdate.nombre = $('#nombre').val();
	userUpdate.direccion = $('#direccion').val();
	userUpdate.vendedorInt = $('#vendedorInt').val();

	$.ajax({
		type:'POST',
		url: '../../src/controller/ClienteController.php',
		data: userUpdate,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					UsersView.getUsersGrid(null);
					$('#update-user-modal').modal('hide');
				}
				alert(responce.message);
			}catch(err){
				console.error(err);
				alert("Ha ocurrido un error en el servidor");
				return;
			}		
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log("Error contactando con el servidor");
		}
	});

	userUpdate.method = undefined;
}

function searchUser(){
	var cliente = new Cliente(
		null,
		$('#nombre-cliente').val(),
		$('#direccion-cliente').val(),
		$('#vend-int').val()
		);
	UsersView.getUsersGrid(cliente);
}

function openUpdateModal(row){
	if(row != undefined){
		var userUpdate = usuarios[row.index()];
		$('#nombre').val(userUpdate.nombre);
		$('#direccion').val(userUpdate.direccion);
		$('#vendedorInt').val(userUpdate.vendedorInt);
		$('#row-index').val(row.index());
	}
	$('#update-client-modal').modal('show');
}

function cleanUserForm(){
	$('#nombre').val('');
	$('#direccion').val('');
	$('#vendedorInt').val('');
	$('#row-index').val('');
	$('#update-client-modal').modal('hide');
}

function toggleCollapse(element){
	if(isCollapseUp){
		element.children().removeClass('fa fa-caret-square-o-down');
		element.children().addClass('fa fa-caret-square-o-up');
		isCollapseUp = false;
	}else{
		element.children().removeClass('fa fa-caret-square-o-up');
		element.children().addClass('fa fa-caret-square-o-down');
		isCollapseUp = true;
	}
}

$(document).ready(function(){
	SessionController.checkSession('clientes');
	UsersView.getUsersGrid(null);
});
