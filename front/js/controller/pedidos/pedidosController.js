var ordersGridView = new GridView();
ordersGridView.setActions([
    new ActionEdit('', '', ''),
    new ActionDelete('', '', '')]);
ordersGridView.setTable('#grid-element-table');
ordersGridView.setElementsToDisplay([0, 1, 2, 3, 4, 5, 6, 7]);

var trofeoCatalogCreator = new CatalogCreator('../../src/controller/TrofeoController.php');
var trophiesGridView = new GridView();
trophiesGridView.setActions([new ActionDeleteModal()]);
trophiesGridView.setElementsToDisplay([0, 1, 2, 3]);
trophiesGridView.setTable("#pedido-trofeos-table");
trophiesGridView.setCatalogCreator(trofeoCatalogCreator);

var isCollapseUp = true;
var currentElement = null;
/**
 * Para saber si el modal ha sido abierto antes, o es la primera vez
 * @type {boolean}
 */
var _hasBeenOpened = false;

function deleteElement(row){
	var elementDelete = ordersGridView.elements[row.index()];
	elementDelete.method = 'deleteElement';
	$.ajax({
		type:'POST',
		url: '../../src/controller/PedidoController.php',
		data: elementDelete,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					ordersGridView.getGrid(
						{method: 'getElementosTrofeos'}, 
						'../../src/controller/PedidoController.php', 
						actions, 
						$('#grid-element-table'), 
						[0, 1, 2, 3, 4, 5, 6, 7]
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
		elementUpdate = ordersGridView.elements[parseInt($('#row-index').val())];	
	}else{
		elementUpdate.id = null;
	}
	
	elementUpdate.method = 'createOrUpdateElement';
	elementUpdate.Folio = $('#Folio').val();
	elementUpdate.fElaboracion = $('#fech-El').val();
	elementUpdate.fEntrega = $('#fech-Ent').val();
	elementUpdate.subtotal = $('#subtotal').val();
	elementUpdate.total = $('#total').val();
	elementUpdate.idCliente = $('#cliente').val();
	elementUpdate.IdUsuario = $('#usuario').val();
	elementUpdate.trophies = trophiesGridView.getCollection();
	
	$.ajax({
		type:'POST',
		url: '../../src/controller/PedidoController.php',
		data: elementUpdate,
		dataType: 'json',
		success: function(response){
			if(response.success){
				ordersGridView.getGrid( {method: 'getElementosTrofeos'},
					'../../src/controller/PedidoController.php');
				cleanElementForm();
			}
			notifySuccess(response.message);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			notifyError("Error contactando con el servidor");
			console.error("Error al agregar pedido: " + textStatus + ": " + errorThrown)
		}
	});
	elementUpdate.method = undefined;
}

function searchElement(){
	var pedido = new Pedido(
		$('#folio-pedido').val(),
		$('#nombre-cliente').val(),
		$('#fecha-pedido').val()
	);
	ordersGridView.getGrid(
		{method: 'getElementosTrofeos',filters:elemento}, 
		'../../src/controller/PedidoController.php', 
		actions, 
		$('#grid-element-table'), 
		[0, 1, 2, 3, 4, 5, 6]
	);

}

var _handleCalendarActions = function(){
	//Disable the input for delivery day
	$("#fech-Ent").prop("disabled", true);
	/**
	 * To call when the user has entered some text in the elaboration input text
	 */
	var _enableDeliveryDate = function(date, context){
		if($("#fech-Ent").prop("disabled")){
			//If the input is disabled, enabled it
			$("#fech-Ent").prop("disabled", false);
		} else {
			//Otherwise, check the dates
			_checkDeliveryDate();
		}
	};
	/**
	 * To call when the user picks a delivery date
	 * @param {moment} date 
	 * @param {object} context 
	 */
	var _checkDeliveryDate = function(date, context){
		var _elabDate = moment($("#fech-El").val());
		var _deliveryDate = moment($("#fech-Ent").val());

		if(!_deliveryDate.isAfter(_elabDate)){
			notifyError('La fecha de entrega debe ser posterior a la de elaboración');
			$("#fech-Ent").val("")
		}
	};
	//Configure the calendar
	$("#fech-El").pignoseCalendar({
		lang: 'es',
		disabledWeekdays: [0, 6],
		//toggle: true
		minDate: moment(),
		//maxDate: null,
		select: _enableDeliveryDate
	});
	$("#fech-Ent").pignoseCalendar({
		lang: 'es',
		disabledWeekdays: [0, 6],
		//toggle: true
		//maxDate: null,
		minDate: moment(),
		select: _checkDeliveryDate
	});
	_hasBeenOpened = true;
}

var _handleEdit = function(row){
	var elementUpdate = ordersGridView.elements[row.index()];
	var pedido = new Pedido(
		elementUpdate.Folio,
		elementUpdate.idCliente,
		elementUpdate.IdUsuario
	);
	$('#Folio').val(elementUpdate.Folio);
	$('#fech-El').val(elementUpdate.fElaboracion);
	$('#fech-Ent').val(elementUpdate.fEntrega);
	$('#subtotal').val(elementUpdate.subtotal);
	$('#total').val(elementUpdate.total);
	$('#cliente').val(elementUpdate.idCliente);
	$('#usuario').val(elementUpdate.IdUsuario);
	$('#row-index').val(row.index());
}

var _handleAdd = function(){
	$.ajax({
		type:'GET',
		url: '../../src/controller/SessionController.php',
		data: {method:'getSession'},
		success: function(username){
			$('#usuario').val($.parseJSON(username).data);
		},
		error: function(xhr, textStatus, errorThrown){
			notifyError("Ha habido un error desconocido");
			console.error(textStatus + ": " + errorThrown);
		}
	});
}

function openUpdateModal(row){
	if(row != undefined && row != null){
		_handleEdit();
	} else {
		_handleAdd();
	}
	trophiesGridView.fillGridFromCatalog('TrofeoController.php');
	$('#update-element-modal').modal('show');
	if(!_hasBeenOpened){
		_handleCalendarActions();
	}
}

function cleanElementForm(){
	$('#Folio').val('');
	$('#fech-El').val('');
	$('#fech-Ent').val('');
	$('#subtotal').val('');
	$('#total').val('');
	$('#cliente').val('');
	$('#usuario').val('');
	$('#row-index').val('');
	$('#update-element-modal').modal('hide');
}

function openTrophyModal(){
	trofeoCatalogCreator.fillIfNeeded($("#id-trofeo"));
	$('#pedido-trofeos-modal').modal('show');
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

function closeTrophyModal(){
	$("#id-trofeo").val([]);
	$('#pedido-trofeos-modal').modal('hide');
	$('#update-element-modal').modal('show');
}

function addTrophy(){
	trophiesGridView.addElement($("#id-trofeo").val());
	closeTrophyModal();
}

function removeFromTable(trophy){
	trophiesGridView.removeElement(trophy);
}

$(document).ready(function(){
	SessionController.checkSession('pedidos');
	ordersGridView.getGrid({method: 'getElementosTrofeos'}, '../../src/controller/PedidoController.php');
});
