var isCollapseUp = false;
function createOrUpdateColor(){
	var color;
	if($('#row-index').val() != null && $('#row-index').val() != ''){
		color = colores[parseInt($('#row-index').val())];	
	}else{
		color = new Color(null, $('#color-descripcion').val(), null);
	}
	
	color.method = 'createOrUpdateColor';
	color.descripcion = $('#color-descripcion').val();

	$.ajax({
		type:'POST',
		url: rootURL,
		data: color,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					ColoresView.getColoresGrid(null);
					$('#update-color-modal').modal('hide');
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

	color.method = undefined;
}

function deleteColor(row){
	var colorDelete = colores[row.index()];
	colorDelete.method = 'deleteColor';
	$.ajax({
		type:'POST',
		url: rootURL,
		data: colorDelete,
		success: function(data){
			try{
				var responce = jQuery.parseJSON(data);
				if(responce.success){
					ColoresView.getColoresGrid(null);
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
	colorDelete.method = undefined;
}

function openUpdateModal(row){
	if(row != undefined){
		var colorUpdate = colores[row.index()];
		$('#color-descripcion').val(colorUpdate.descripcion);
		$('#row-index').val(row.index());
	}
	$('#update-color-modal').modal('show');
}

function cleanUserForm(){
	$('#color-descripcion').val('');
	$('#row-index').val('');
	$('#update-color-modal').modal('hide');
}

function searchColor(){
	var color = new Color(
		$('#id-catalogo').val(),
		$('#descripcion').val(),
		null
		);
	ColoresView.getColoresGrid(color);
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
	SessionController.checkSession('colores');
	ColoresView.getColoresGrid(null);
});
