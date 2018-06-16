var usuarios = {};

UsersView = {
	getUsersGrid: function (){
		$.ajax({
			type:'GET',
			url: '../../src/controller/UsuarioController.php',
			data: {method: 'getUsersGrid'},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					usuarios = responce.data.resultSet;
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
		{type:'light', label:'', icon:'fa fa-edit', _class:'btn-edit-usr', size:'', functionECute:'openUpdateModal($(this).parent().parent());'},
		{type:'danger', label:'', icon:'fa fa-close', _class:'btn-delete-usr', size:'', functionECute:'deleteUser($(this).parent().parent());'}]
};

function deleteUser(row){
	var userDelete = usuarios[row.index()];
	userDelete.method = 'deleteUser';
	$.ajax({
		type:'POST',
		url: '../../src/controller/UsuarioController.php',
		data: userDelete,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					UsersView.getUsersGrid();
					alert(responce.message);
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
	userDelete.method = undefined;
}

function testFunction(element){
	console.log(element);
}

function createOrUpdateUser(){
	var userUpdate = {};
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		userUpdate = usuarios[parseInt($('#row-index').val())];	
	}else{
		userUpdate.id = null;
	}
	
	userUpdate.method = 'createOrUpdateUser';
	userUpdate.usuario = $('#usuario').val();
	userUpdate.email = $('#email').val();
	userUpdate.passwd = $('#passwd').val();

	$.ajax({
		type:'POST',
		url: '../../src/controller/UsuarioController.php',
		data: userUpdate,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					UsersView.getUsersGrid();
					$('#update-user-modal').modal('hide');
				}
				alert(responce.message);
			}catch(err){
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

function openUpdateModal(row){
	if(row != undefined){
		var userUpdate = usuarios[row.index()];
		$('#usuario').val(userUpdate.usuario);
		$('#email').val(userUpdate.email);
		$('#row-index').val(row.index());
	}
	$('#update-user-modal').modal('show');
}

function cleanUserForm(){
	$('#usuario').val('');
	$('#email').val('');
	$('#row-index').val('');
	$('#passwd').val('');
	$('#passwdValidate').val('');
	$('#update-user-modal').modal('hide');
}

$(document).ready(function(){
	MenuNavs.getMenuNavs('usuarios');
	UsersView.getUsersGrid();
});
