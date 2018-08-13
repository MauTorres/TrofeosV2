var actions = 
	[new ActionEdit('', '', ''),
	new ActionDelete('', '', '')];
var elementosGridView = new GridView();
var isCollapseUp = true;
var colorCatalogCreator = new CatalogCreator('../../src/controller/ColorController.php');
var materialCatalogCreator = new CatalogCreator('../../src/controller/MaterialController.php');
var categoriaCatalogCreator = new CatalogCreator('../../src/controller/CategoryController.php');
var currentElement = null;

function deleteElement(row){
	var elementDelete = elementosGridView.elements[row.index()];
	elementDelete.method = 'deleteElement';
	$.ajax({
		type:'POST',
		url: '../../src/controller/ElementoController.php',
		data: elementDelete,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					elementosGridView.getGrid(
					{method: 'deleteElement'}, 
					'../../src/controller/ElementoController.php', 
					actions, 
					$('#grid-element-table'), 
					[0, 1, 2, 3, 4, 5]
					);
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

function createOrUpdateElement(){
	var elementUpdate = {};
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		elementUpdate = elementosGridView.elements[parseInt($('#row-index').val())];	
	}else{
		elementUpdate.id = null;
	}
	
	elementUpdate.method = 'createOrUpdateElement';
	elementUpdate.nombre = $('#nm-elemento').val();
	elementUpdate.descripcion = $('#descripcion').val();
	elementUpdate.idColor = $('#color').val();
	elementUpdate.idMaterial = $('#material').val();
	elementUpdate.idCategoria = $('#categoria').val();
	
	$.ajax({
		type:'POST',
		url: '../../src/controller/ElementoController.php',
		data: elementUpdate,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){

					elementosGridView.getGrid(
					{method: 'createOrUpdateElement'}, 
					'../../src/controller/ElementoController.php', 
					actions, 
					$('#grid-element-table'), 
					[0, 1, 2, 3, 4, 5]
					);
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
		$('#descripcion-elemento').val()
	);
	elementosGridView.getGrid(
		{method: 'getElementosTrofeos',filters:elemento}, 
		'../../src/controller/ElementoController.php', 
		actions, 
		$('#grid-element-table'), 
		[0, 1, 2, 3, 4, 5]
	);

}

function openUpdateModal(row){
	colorCatalogCreator.fillCatalog($('#color'));
	materialCatalogCreator.fillCatalog($('#material'));
	categoriaCatalogCreator.fillCatalog($('#categoria'));
	if(row != undefined){
		var elementUpdate = elementosGridView.elements[row.index()];
		$('#nm-elemento').val(elementUpdate.nombre);
		$('#descripcion').val(elementUpdate.descripcion);
		$('#idColor').val(elementUpdate.idColor);
		$('#idCategoria').val(elementUpdate.idCategoria);
		$('#idMaterial').val(elementUpdate.idMaterial);
		$('#row-index').val(row.index());
	}
	$('#update-element-modal').modal('show');
}

function cleanElementForm(){
	$('#nm-elemento').val('');
	$('#descripcion').val('');
	$('#color').val('');
	$('#categoria').val('');
	$('#material').val('');
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
	elementosGridView.getGrid({method: 'getElementosTrofeos'}, '../../src/controller/ElementoController.php', actions, $('#grid-element-table'),[0, 1, 2, 3, 4, 5]);
});
