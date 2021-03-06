var trofeosGridView = new GridView();
trofeosGridView.setActions([new ActionEdit(), new ActionDelete()]);
trofeosGridView.setTable('#grid-table');
trofeosGridView.setElementsToDisplay([0, 1, 2, 3]);

//Para los elementos que se muestran en el 2do modal
var elementosGridView = new GridView();
var elementAction = new Action();
elementAction.setComponent('check');
elementAction.setFunctionECute('addElement($(this))');
elementAction.value = 1;
elementosGridView.setActions([elementAction]);
elementosGridView.setTable('#grid-element-table');
elementosGridView.setElementsToDisplay([0, 1, 2, 3, 4, 5]);

var addedElementsGridView = new GridView();
var deleteElementAction = new ActionDelete();
deleteElementAction.setFunctionECute('deleteElementTrofeo($(this).parent().parent());');
addedElementsGridView.setActions([deleteElementAction]);
addedElementsGridView.setTable('#grid-elementtrophy-table');
addedElementsGridView.setElementsToDisplay([1, 2, 3, 4, 5]);


var colorCatalogCreator = new CatalogCreator('../../src/controller/ColorController.php');
var materialCatalogCreator = new CatalogCreator('../../src/controller/MaterialController.php');
var categoriaCatalogCreator = new CatalogCreator('../../src/controller/CategoryController.php');

function openUpdateModal(row){
	colorCatalogCreator.fillIfNeeded($('#color'));
	materialCatalogCreator.fillIfNeeded($('#material'));
	categoriaCatalogCreator.fillIfNeeded($('#categoria'));
	var trofeoUpdate = null;
	$('#photo-body').html('');
	if(row !== undefined && row !== null){
		currentRow = row.index();
		$("#modal-trofeo-table-extra").show();
		$("#modal-trofeo-option").show();
		currentRow = row.index();
		trofeoUpdate = trofeosGridView.elements[row.index()];
		trofeoUpdate.estatus = 1;
		$('#row-index').val(row.index());
		$('#id-modelo').val(trofeoUpdate.nombre);
		$('#descripcion').val(trofeoUpdate.descripcion);
		$('#precio-trofeo').val(trofeoUpdate.precio);
		if(trofeoUpdate.fotoPath != null){
			$('#photo-body').append('<img src="../../src' + trofeoUpdate.fotoPath + '" class="img-fluid">');
		}
	}else{
		$('.hide-on-new').hide();
		$('#grid-elementtrophy-table').html('');
	}

	addedElementsGridView.getGrid(
		{method: 'getElementosTrofeo', trophy:trofeoUpdate == null ? {id:0} : trofeoUpdate},
		'../../src/controller/ElementoController.php'
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
	var elemento = new Elemento(
		$('#id-elemento').val(),
		$('#nombre-elemento').val(),
		null,
		$('#color').val(),
		$('#categoria').val(),
		$('#material').val(),
		null
	);
	elementosGridView.getGrid(
		{method: 'getElementosTrofeos', filters: elemento},
		'../../src/controller/ElementoController.php');
}

function searchTrophy(){
	var trofeo = new Trofeo(
		$('#id').val(), 
		$('#nombre-trofeo').val(),
		null,
		$('#precio').val(),
		null,
		null);
	trofeosGridView.getGrid( {method: 'getTrofeosGrid', filters: trofeo},
		'../../src/controller/TrofeoController.php');
}

function addElement(row){
	var index = row.parent().parent().index();
	elementosGridView.elements[index].selected = !elementosGridView.elements[index].selected;
}

function addElements(){
	var trofeoUpdate = null
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		trofeoUpdate = trofeosGridView.elements[$('#row-index').val()];
	}else{
		alert("Primero cree el trofeo antes de agregar elementos");
		$('#add-element-modal').modal('hide');
		openUpdateModal(null);
		return;
	}

	var elementos = [];
	elementosGridView.elements.forEach(function(element){
		if(element.selected){
			elementos.push(element);
		}
	});

	trofeoUpdate.elementos = elementos;
	$.ajax({
		type: 'POST',
		url: '../../src/controller/TrofeoController.php',
		data: {method: 'setElements', trofeoUpdate},
		success: function(result){
			try{
				var res = jQuery.parseJSON(result);
				if(res.success){
					$('#add-element-modal').modal('hide');
					alert("Se han agregado los elementos");
					//openUpdateModal(trofeoUpdate);
				}
			}catch(exeption){
				alert("Ocurrió un error en el servidor");
			}
		}
	});
	cleanElementModal();
}

function backSearchElements(){
	cleanElementModal();
	$('#add-element-modal').modal('hide');
	$('#search-element-modal').modal('show');
}

function deleteElement(row){
	var trofeoDelete = trofeosGridView.elements[row.index()];
	trofeoDelete.estatus = 0;
	$.ajax({
		type: 'POST',
		url: '../../src/controller/TrofeoController.php',
		data: {method:'deleteTrophy', trofeo: trofeoDelete},
		success: function(responce){
			try{
				var res = jQuery.parseJSON(responce);
				if(res.success){
					alert(res.message);
					loadTrofeoGrid();
				}
			}catch(exeption){
				alert("Ocurrió un error en el servidor");
			}
		}
	});
}

function getTrophyToCreateOrUpdate(){
	var trofeoUpdate = new Trofeo(null, null, null, null, null, null);
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		trofeoUpdate = trofeosGridView.elements[$('#row-index').val()];
	}else{
		trofeoUpdate.id = null;
	}

	trofeoUpdate.nombre = $('#id-modelo').val();
	trofeoUpdate.descripcion = $('#descripcion').val();
	trofeoUpdate.precio = $('#precio-trofeo').val();

	return trofeoUpdate;
}

function createOrUpdateTrophy(){
	$('#form-update-trophy').submit();
}

function cleanTrophyForm(){
	$('#id-modelo').val('');
	$('#descripcion').val('');
	$('#precio-trofeo').val('');
	$('#trophy-photo').val('');
	$('#row-index').val('');
	$('#update-trophy-modal').modal('hide');
}

function cleanElementModal(){
	$('#id-elemento').val('');
	$('#nombre-elemento').val('');
	$('#color').val('');
	$('#material').val('');
	$('#categoria').val('');
	$('#search-element-modal').modal('hide');
}

function loadTrofeoGrid(){
	trofeosGridView.getGrid({method: 'getTrofeosGrid'},
		'../../src/controller/TrofeoController.php');
}

function deleteElementTrofeo(row){
	var elementoTrofeo = elementosGridView.elements[row.index()];
	var trofeo = trofeosGridView.elements[$('#row-index').val()];

	$.ajax({
		type: 'POST',
		url: '../../src/controller/TrofeoController.php',
		data: {method:'deleteTrofeoElemento', trofeo: trofeo, elemento: elementoTrofeo},
		success: function(respoce){
			try{
				var res = jQuery.parseJSON(respoce);
				if(res.success){
					alert(res.message);
					addedElementsGridView.getGrid(
						{method: 'getElementosTrofeo', trophy: trofeo},
						'../../src/controller/ElementoController.php'
					);
				}
			}catch(exeption){
				alert("Ocurrió un error en el servidor");
			}
		}
	});
}

$(document).ready(function(){
	SessionController.checkSession('trofeos');
	loadTrofeoGrid();
	/*Uso ésta forma de enviar la información para lograr cargar imágenes en el server*/
	$(document).on( 'submit', '#form-update-trophy', function(e){
		e.preventDefault();
		var trofeoUpdate = getTrophyToCreateOrUpdate();
		var formData = new FormData();
		for ( var key in trofeoUpdate ) {
			formData.append(key, trofeoUpdate[key]);
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
				loadTrofeoGrid();
			}
		});
	});
});
