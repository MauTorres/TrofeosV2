var elementos = {};
var isCollapseUp = true;

ElementsView = {
	getElementsGrid: function (filters){
		$.ajax({
			type:'GET',
			url: '../../src/controller/ElementoController.php',
			data: {method: 'getElementsGrid', filters: filters},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					elementos = responce.data.resultSet;
					responce.data.actions = ElementsView.actions;
					var table = $('#element-table');
					if(responce.success){
						TableCreator.fillElementTable(responce.data, table);
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
		{type:'light', label:'', icon:'fa fa-edit', _class:'btn-edit-elm', size:'', functionECute:'openUpdateModal($(this).parent().parent());'},
		{type:'danger', label:'', icon:'fa fa-close', _class:'btn-delete-elm', size:'', functionECute:'deleteElement($(this).parent().parent());'}]
};

function deleteElement(row){
	var elementDelete = elementos[row.index()];
	elementDelete.method = 'deleteElement';
	$.ajax({
		type:'POST',
		url: '../../src/controller/ElementoController.php',
		data: elementDelete,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					ElementsView.getElementsGrid(null);
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
	elementDelete.method = undefined;
}

function testFunction(element){
	console.log(element);
}

function createOrUpdateElement(){
	var elementUpdate = {};
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		elementUpdate = elementos[parseInt($('#row-index').val())];	
	}else{
		elementUpdate.id = null;
	}
	
	elementUpdate.method = 'createOrUpdateElement';
	elementUpdate.nombre = $('#nombre').val();
	elementUpdate.descripcion = $('#descripcion').val();
	elementUpdate.precio = $('#precio').val();
	/*elementUpdate.color = $('#color').val();
	elementUpdate.deporte = $('#deporte').val();
	elementUpdate.material = $('#material').val();*/

	$.ajax({
		type:'POST',
		url: '../../src/controller/ElementoController.php',
		data: elementUpdate,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					ElementsView.getElementsGrid(null);
					$('#update-element-modal').modal('hide');
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

	elementUpdate.method = undefined;
}

function searchElement(){
	var elemento = new Elemento(
		$('#id-elemento').val(),
		$('#nombre-elemento').val(),
		null,
		$('#descripcion-elemento').val(),
		null
		);
	ElementsView.getElementsGrid(elemento);
}

function openUpdateModal(row){
	if(row != undefined){
		var elementUpdate = elementos[row.index()];
		$('#nombre').val(elementUpdate.nombre);
		$('#descripcion').val(elementUpdate.descripcion);
		$('#precio').val(elementUpdate.precio);
		/*$('#color').val(elementUpdate.color);
		$('#deporte').val(elementUpdate.deporte);
		$('#material').val(elementUpdate.material);*/
		$('#row-index').val(row.index());
	}
	$('#update-element-modal').modal('show');
}

function cleanElementForm(){
	$('#nombre').val('');
	$('#descripcion').val('');
	$('#precio').val('');
	/*$('#color').val('');
	$('#deporte').val('');
	$('#material').val('');*/
	$('#row-index').val('');
	$('#update-element-modal').modal('hide');
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
	SessionController.checkSession('elementos');
	ElementsView.getElementsGrid(null);
});
