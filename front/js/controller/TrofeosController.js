var actions = 
	[new ActionEdit('', '', ''),
	new ActionDelete('', '', '')];
var trofeosGridView = new GridView();
var elementosGridView = new GridView();

function openUpdateModal(row){
	if(row != undefined){
		var elementUpdate = trofeosGridView.elements[row.index()];
		$('#id-modelo').val(elementUpdate.nombre);
		$('#descripcion').val(elementUpdate.descripcion);
		$('#precio').val(elementUpdate.precio);
		$('#trophy-photo').val(elementUpdate.foto);
		$('#row-index').val(row.index());
	}
	$('#update-trophy-modal').modal('show');
}

function openElementModal(){
	$('#update-trophy-modal').modal('hide');
	$('#search-element-modal').modal('show');
}

function deleteElement(){
	
}

$(document).ready(function(){
	SessionController.checkSession('trofeos');
	trofeosGridView.getGrid({method: 'getTrofeosGrid'}, '../../src/controller/TrofeoController.php', actions, $('#grid-table'));
	elementosGridView.getGrid({method: 'getElementosTrofeos'}, '../../src/controller/ElementoController.php', actions, $('#grid-element-table'));
});
