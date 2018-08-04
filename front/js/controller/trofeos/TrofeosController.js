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
		if(currentTrophy == null){
			currentTrophy = trofeosGridView.elements[row.index()];
			$('#row-index').val(row.index());
		}
		$('#id-modelo').val(currentTrophy.nombre);
		$('#descripcion').val(currentTrophy.descripcion);
		$('#precio').val(currentTrophy.precio);
		$('#trophy-photo').val(currentTrophy.foto);
	}else{
		$('#grid-elementtrophy-table').html('');
	}
	elementosGridView.getGrid(
		{method: 'getElementosTrofeo', trophy:currentTrophy == null ? {id:0} : currentTrophy}, 
		'../../src/controller/ElementoController.php', 
		null, 
		$('#grid-elementtrophy-table'), 
		[1, 2, 3, 4, 5]
	);

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
	elementosGridView.getGrid(
		{method: 'getElementosTrofeos'}, 
		'../../src/controller/ElementoController.php', 
		elemtsGridActions, 
		$('#grid-element-table'), 
		[0, 1, 2, 3, 4, 5]);
}

function addElement(row){
	var index = row.parent().parent().index();
	elementosGridView.elements[index].selected = !elementosGridView.elements[index].selected;
}

function addElements(){
	if(currentTrophy == null){
		currentTrophy = {id:0};
	}

	var elementos = [];
	elementosGridView.elements.forEach(function(element){
		if(element.selected){
			elementos.push(element);
		}
	});

	currentTrophy.elementos = elementos;
	$('#add-element-modal').modal('hide');
	openUpdateModal(null);
	TableCreator.updateTable(
		elementos,
		$('#grid-elementtrophy-table'), 
		[1, 2, 3, 4, 5]
	);
	$.ajax({
		type: 'POST',
		url: '../../src/controller/TrofeoController.php',
		data: {method: 'setElements', currentTrophy},
		success: function(result){
			try{
				var res = jQuery.parseJSON(result);
				if(res.success){
					$('#add-element-modal').modal('hide');
					openUpdateModal(currentTrophy);
				}
			}catch(exeption){

			}
		}
	});
}

function deleteElement(){
	
}

function createOrUpdateTrophy(){
	if(currentTrophy == null){
		currentTrophy = new Trofeo(
			null,
			$('#id-modelo').val(),
			$('#descripcion').val(),
			$('#precio').val(),
			null,
			null);
	}

	$('#form-update-trophy').submit();
}

function cleanTrophyForm(){
	$('#id-modelo').val('');
	$('#descripcion').val('');
	$('#precio').val('');
	$('#trophy-photo').val('');
	$('#row-index').val('');
	$('#update-trophy-modal').modal('hide');
	currentTrophy = null;
}

$(document).ready(function(){
	SessionController.checkSession('trofeos');
	trofeosGridView.getGrid(
		{method: 'getTrofeosGrid'}, 
		'../../src/controller/TrofeoController.php', 
		actions, 
		$('#grid-table'), 
		[0, 1, 2]);
	$('#form-update-trophy').submit(function(e){
		e.preventDefault();
		var formData = new FormData($(this));
		for ( var key in currentTrophy ) {
			formData.append(key, currentTrophy[key]);
		}
		formData.append("foto", document.getElementById("trophy-photo").files[0]);
		formData.append("method", "createOrUpdateTrophy");
		$.ajax({
			url: '../../src/controller/TrofeoController.php',
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			success: function (result) {
				try{
					var res = jQuery.parseJSON(result);
					alert(res.message);
				}catch(exeption){
					alert("Ocurrió un error en el servidor");
				}
				cleanTrophyForm();
				trofeosGridView.getGrid(
					{method: 'getTrofeosGrid'}, 
					'../../src/controller/TrofeoController.php', 
					actions, 
					$('#grid-table'), 
					[0, 1, 2]
				);
			}
		});
	});
});
