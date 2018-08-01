var actions = 
	[new ActionEdit('', '', ''),
	new ActionDelete('', '', '')];
var elemtsGridActions = [{_class: '', value: 1, component: 'check', functionECute: 'addElement($(this))'}];
var trofeosGridView = new GridView();
var elementosGridView = new GridView();
var colorCatalogCreator = new CatalogCreator('../../src/controller/ColorController.php');
var materialCatalogCreator = new CatalogCreator('../../src/controller/MaterialController.php');
var categoriaCatalogCreator = new CatalogCreator('../../src/controller/CategoryController.php');
var currentTrophy = null;

function openUpdateModal(row){
	colorCatalogCreator.fillCatalog($('#color'));
	materialCatalogCreator.fillCatalog($('#material'));
	categoriaCatalogCreator.fillCatalog($('#categoria'));

	if(row != undefined){
		currentTrophy = trofeosGridView.elements[row.index()];
		$('#id-modelo').val(currentTrophy.nombre);
		$('#descripcion').val(currentTrophy.descripcion);
		$('#precio').val(currentTrophy.precio);
		$('#trophy-photo').val(currentTrophy.foto);
		$('#row-index').val(row.index());
	}

	$('#update-trophy-modal').modal('show');
}

function openElementModal(){
	$('#update-trophy-modal').modal('hide');
	$('#search-element-modal').modal('show');
}

function toggleCollapse(row){

}

function searchElement(){
	$('#search-element-modal').modal('hide');
	$('#add-element-modal').modal('show');
	elementosGridView.getGrid({method: 'getElementosTrofeos'}, '../../src/controller/ElementoController.php', elemtsGridActions, $('#grid-element-table'), [0, 1, 2, 3, 4, 5]);
}

function addElement(row){
	var index = row.parent().parent().index();
	elementosGridView.elements[index].selected = !elementosGridView.elements[index].selected;
}

function addElements(){
	if(currentTrophy == null){
		return;
	}

	var elementos = [];
	elementosGridView.elements.forEach(function(element){
		if(element.selected){
			elementos.push(element);
		}
	});

	currentTrophy.elementos = elementos;

	$.ajax({
		type: 'POST',
		url: '../../src/controller/TrofeoController.php',
		data: {method: 'setElements', currentTrophy},
		success: function(result){
			try{
				var res = jQuery.parseJSON(result);
			}catch(exeption){

			}
		}
	});
}

function deleteElement(){
	
}

$(document).ready(function(){
	SessionController.checkSession('trofeos');
	trofeosGridView.getGrid({method: 'getTrofeosGrid'}, '../../src/controller/TrofeoController.php', actions, $('#grid-table'), [0, 1, 2]);
});
