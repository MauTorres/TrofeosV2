var actions = 
	[new ActionEdit('', '', ''),
	new ActionDelete('', '', '')];
var elemtsGridActions = [{_class: '', value: 1, component: 'check', functionECute: 'addElement($(this))'}];
var elementosGridView = new GridView();
var isCollapseUp = true;
var colorCatalogCreator = new CatalogCreator('../../src/controller/ColorController.php');
var materialCatalogCreator = new CatalogCreator('../../src/controller/MaterialController.php');
var categoriaCatalogCreator = new CatalogCreator('../../src/controller/CategoryController.php');
var medidaCatalogCreator = new CatalogCreator('../../src/controller/MeasureController.php');
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
						{method: 'getElementosTrofeos'}, 
						'../../src/controller/ElementoController.php', 
						actions, 
						$('#grid-element-table'), 
						[0, 1, 2, 3, 4, 5, 6]
					);
					alert(responce.message);
				}
			}catch(err){
				console.error( err);
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
	elementUpdate.idMedida = $('#medida').val();
	
	$.ajax({
		type:'POST',
		url: '../../src/controller/ElementoController.php',
		data: elementUpdate,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){

					elementosGridView.getGrid(
						{method: 'getElementosTrofeos'},
						'../../src/controller/ElementoController.php', 
						actions, 
						$('#grid-element-table'), 
						[0, 1, 2, 3, 4, 5, 6]
					);
					$('#update-element-modal').modal('hide');
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
		[0, 1, 2, 3, 4, 5, 6]
	);

}

function addElement(row){
	var index = row.parent().parent().index();
	elementosGridView.elements[index].selected = !elementosGridView.elements[index].selected;
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

function openMeasureModal(){
	$('#update-element-modal').modal('hide');
	$('#search-measure-modal').modal('show');
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

function cleanMeasureModal(){
	$('#id-medida').val('');
	$('#descripcion-medida').val('');
	$('#search-measure-modal').modal('hide');
}

function searchMeasure(){
	$('#search-measure-modal').modal('hide');
	$('#add-measure-modal').modal('show');
	var medida = new Measure(
		$('#id-medida').val(),
		$('#descripcion-medida').val()
	);
	elementosGridView.getGrid(
		{method: 'getElementsGrid', filters: medida},
		'../../src/controller/MeasureController.php',
		elemtsGridActions,
		$('#grid-measure-table'),
		[0, 1]);
}

function backSearchMeasures(){
	cleanMeasureModal();
	$('#add-measure-modal').modal('hide');
	$('#search-measure-modal').modal('show');
}

function addMeasure(row){
	var index = row.parent().parent().index();
	medidasGridView.elements[index].selected = !medidasGridView.elements[index].selected;
}

function addMeasures(){
	var elementoUpdate = null
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		//elementoUpdate = elementosGridView.elements[$('#row-index').val()];
		elementoUpdate = new Object();
	}else{
		alert("Primero cree el elemento antes de agregar medidas");
		$('#add-element-modal').modal('hide');
		openUpdateModal(null);
		return;
	}

	var medidas = [];
	elementosGridView.elements.forEach(function(medida){
		if(medida.selected){
			medidas.push(medida);
		}
	});
	elementoUpdate.medidas = medidas;
	$.ajax({
		type: 'POST',
		url: '../../src/controller/ElementoController.php',
		data: {method: 'setMeasures', 'elementoUpdate': elementoUpdate},
		success: function(result){
			try{
				var res = jQuery.parseJSON(result);
				if(res.success){
					$('#add-measure-modal').modal('hide');
					alert("Se han agregado las medidas");
				}
			}catch(exeption){
				alert("Ocurrió un error en el servidor");
			}
		},
		error: function( jqhqr, textStatus, errorThrown ){
			console.error( textStatus + ": " + errorThrown );
		}
	});
	cleanMeasureModal();
}

$(document).ready(function(){
	SessionController.checkSession('elementos');
	elementosGridView.getGrid({method: 'getElementosTrofeos'}, '../../src/controller/ElementoController.php', actions, $('#grid-element-table'),[0, 1, 2, 3, 4, 5, 6]);
});